<?php

namespace App\Http\Controllers;

use App\Mail\MarketingEmail;
use App\Models\Customer;
use App\Models\EmailSend;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::withCount('sends')->latest('id')->get();

        return view('admin_panel.email_templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin_panel.email_templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        EmailTemplate::create($request->only('name', 'subject', 'body'));

        return redirect()->route('email-templates.index')->with('success', 'Template created successfully.');
    }

    public function edit($id)
    {
        $template = EmailTemplate::findOrFail($id);

        return view('admin_panel.email_templates.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $template = EmailTemplate::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $template->update($request->only('name', 'subject', 'body'));

        return redirect()->route('email-templates.index')->with('success', 'Template updated successfully.');
    }

    public function destroy($id)
    {
        EmailTemplate::findOrFail($id)->delete();

        return redirect()->route('email-templates.index')->with('success', 'Template deleted.');
    }

    public function showSend($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $customers = Customer::whereNotNull('email')->where('email', '!=', '')->orderBy('name')->get();

        return view('admin_panel.email_templates.send', compact('template', 'customers'));
    }

    public function send(Request $request, $id)
    {
        $template = EmailTemplate::findOrFail($id);

        $request->validate([
            'customer_ids' => 'required|array|min:1',
            'customer_ids.*' => 'exists:customers,id',
        ]);

        $customers = Customer::whereIn('id', $request->customer_ids)
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->get();

        $sent = 0;
        $failed = 0;

        foreach ($customers as $customer) {
            $body = str_replace(
                ['{{name}}', '{{customer_name}}'],
                $customer->name,
                $template->body
            );

            try {
                Mail::to($customer->email)->send(new MarketingEmail($template->subject, $body));

                EmailSend::create([
                    'email_template_id' => $template->id,
                    'customer_id' => $customer->id,
                    'sent_by' => auth()->id(),
                    'email' => $customer->email,
                    'status' => 'sent',
                ]);

                $sent++;
            } catch (\Throwable $e) {
                EmailSend::create([
                    'email_template_id' => $template->id,
                    'customer_id' => $customer->id,
                    'sent_by' => auth()->id(),
                    'email' => $customer->email,
                    'status' => 'failed',
                    'error' => $e->getMessage(),
                ]);

                $failed++;
            }
        }

        $message = "Sent to {$sent} customer(s).";
        if ($failed > 0) {
            $message .= " {$failed} failed — check the send log.";
        }

        return redirect()->route('email-templates.index')->with('success', $message);
    }

    public function sendLog($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $logs = $template->sends()->with('customer')->latest()->paginate(50);

        return view('admin_panel.email_templates.log', compact('template', 'logs'));
    }
}
