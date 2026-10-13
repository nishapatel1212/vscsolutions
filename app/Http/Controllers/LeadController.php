<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Public endpoint for the website's contact form (routes/api.php).
     * No auth — this is how outside inquiries get into the portal.
     */
    public function store(Request $request)
    {
        $validated = validator($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'message' => 'required|string|max:2000',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validated->errors(),
            ], 422);
        }

        $lead = Lead::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'source' => $request->source ?? 'website',
            'job_type' => $this->classifyJobType($request->message),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Thanks {$lead->name}, we've received your inquiry and will be in touch shortly.",
        ], 201);
    }

    public function index(Request $request)
    {
        $leads = Lead::with('customer')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->get();

        return view('admin_panel.leads.index', compact('leads'));
    }

    public function show($id)
    {
        $lead = Lead::with('customer')->findOrFail($id);
        $customers = Customer::orderBy('name')->get();

        return view('admin_panel.leads.show', compact('lead', 'customers'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,contacted,quoted,converted,lost',
        ]);

        Lead::findOrFail($id)->update(['status' => $request->status]);

        return back()->with('success', 'Lead status updated.');
    }

    /**
     * Links the lead to an existing customer, or creates a new one from the
     * lead's details, then marks it converted.
     */
    public function convert(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        if ($request->customer_id) {
            $customerId = $request->customer_id;
        } else {
            $customer = Customer::create([
                'name' => $lead->name,
                'email' => $lead->email,
                'phone' => $lead->phone,
            ]);
            $customerId = $customer->id;
        }

        $lead->update(['customer_id' => $customerId, 'status' => 'converted']);

        return redirect()->route('jobs.create', ['customer_id' => $customerId])
            ->with('success', 'Lead converted. You can now schedule a job or create a quote for this customer.');
    }

    public function destroy($id)
    {
        Lead::findOrFail($id)->delete();

        return redirect()->route('leads.index')->with('success', 'Lead deleted.');
    }

    private function classifyJobType(string $description): ?string
    {
        $pythonPath = config('latin.python_path');
        $scriptPath = config('latin.scripts_path') . '/job_classifier.py';

        $escaped = escapeshellarg($description);
        $output = shell_exec("\"$pythonPath\" \"$scriptPath\" --classify $escaped");

        $data = json_decode($output, true);

        return $data['job_type'] ?? null;
    }
}
