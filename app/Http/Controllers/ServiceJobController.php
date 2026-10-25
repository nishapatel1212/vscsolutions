<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Quote;
use App\Models\ServiceJob;
use Illuminate\Http\Request;

class ServiceJobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = ServiceJob::with('customer', 'quote')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->orderBy('scheduled_date')
            ->get();

        return view('admin_panel.jobs.index', compact('jobs'));
    }

    public function create(Request $request)
    {
        $customers = Customer::orderBy('name')->get();
        $quotes = Quote::where('type', '!=', 'invoice')->latest()->get();

        $selectedQuoteId = $request->query('quote_id');
        $selectedCustomerId = $request->query('customer_id');

        return view('admin_panel.jobs.create', compact('customers', 'quotes', 'selectedQuoteId', 'selectedCustomerId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'quote_id' => 'nullable|exists:quotes,id',
            'title' => 'required|string|max:255',
            'scheduled_date' => 'required|date',
            'technician' => 'nullable|string|max:255',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        ServiceJob::create($request->all());

        return redirect()->route('jobs.index')->with('success', 'Job scheduled successfully.');
    }

    public function edit($id)
    {
        $job = ServiceJob::findOrFail($id);
        $customers = Customer::orderBy('name')->get();
        $quotes = Quote::where('type', '!=', 'invoice')->latest()->get();

        return view('admin_panel.jobs.edit', compact('job', 'customers', 'quotes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'quote_id' => 'nullable|exists:quotes,id',
            'title' => 'required|string|max:255',
            'scheduled_date' => 'required|date',
            'technician' => 'nullable|string|max:255',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $job = ServiceJob::findOrFail($id);
        $job->update($request->all());

        return redirect()->route('jobs.index')->with('success', 'Job updated successfully.');
    }

    public function destroy($id)
    {
        ServiceJob::findOrFail($id)->delete();

        return redirect()->route('jobs.index')->with('success', 'Job deleted.');
    }

    public function calendar()
    {
        return view('admin_panel.jobs.calendar');
    }

    public function calendarEvents(Request $request)
    {
        $jobs = ServiceJob::with('customer')
            ->whereBetween('scheduled_date', [$request->query('start'), $request->query('end')])
            ->get();

        $colors = [
            'scheduled' => '#2563eb',
            'in_progress' => '#b45309',
            'completed' => '#1a7f45',
            'cancelled' => '#c0392b',
        ];

        $events = $jobs->map(function ($job) use ($colors) {
            return [
                'id' => $job->id,
                'title' => $job->title . ($job->customer ? ' — ' . $job->customer->name : ''),
                'start' => $job->scheduled_date->format('Y-m-d'),
                'color' => $colors[$job->status] ?? '#6b7280',
                'url' => route('jobs.edit', $job->id),
            ];
        });

        return response()->json($events);
    }
}
