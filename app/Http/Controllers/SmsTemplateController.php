<?php

namespace App\Http\Controllers;

use App\Contracts\SmsDriver;
use App\Models\Customer;
use App\Models\SmsSend;
use App\Models\SmsTemplate;
use Illuminate\Http\Request;

class SmsTemplateController extends Controller
{
    public function index()
    {
        $templates = SmsTemplate::withCount('sends')->latest('id')->get();
        $driver = config('sms.driver', 'log');

        return view('admin_panel.sms_templates.index', compact('templates', 'driver'));
    }

    public function create()
    {
        return view('admin_panel.sms_templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'trigger_type' => 'required|in:manual,job_reminder,quote_followup,invoice_due',
            'message' => 'required|string|max:1600',
        ]);

        SmsTemplate::create($request->only('name', 'trigger_type', 'message'));

        return redirect()->route('sms-templates.index')->with('success', 'SMS template created successfully.');
    }

    public function edit($id)
    {
        $template = SmsTemplate::findOrFail($id);

        return view('admin_panel.sms_templates.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $template = SmsTemplate::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'trigger_type' => 'required|in:manual,job_reminder,quote_followup,invoice_due',
            'message' => 'required|string|max:1600',
        ]);

        $template->update($request->only('name', 'trigger_type', 'message'));

        return redirect()->route('sms-templates.index')->with('success', 'SMS template updated successfully.');
    }

    public function destroy($id)
    {
        SmsTemplate::findOrFail($id)->delete();

        return redirect()->route('sms-templates.index')->with('success', 'SMS template deleted.');
    }

    public function showSend($id)
    {
        $template = SmsTemplate::findOrFail($id);
        $customers = Customer::whereNotNull('phone')->where('phone', '!=', '')->orderBy('name')->get();
        $driver = config('sms.driver', 'log');

        return view('admin_panel.sms_templates.send', compact('template', 'customers', 'driver'));
    }

    public function send(Request $request, $id, SmsDriver $smsDriver)
    {
        $template = SmsTemplate::findOrFail($id);

        $request->validate([
            'customer_ids' => 'required|array|min:1',
            'customer_ids.*' => 'exists:customers,id',
        ]);

        $customers = Customer::whereIn('id', $request->customer_ids)
            ->whereNotNull('phone')
            ->where('phone', '!=', '')
            ->get();

        $sent = 0;
        $failed = 0;

        foreach ($customers as $customer) {
            $message = str_replace(
                ['{{name}}', '{{customer_name}}'],
                $customer->name,
                $template->message
            );

            $result = $smsDriver->send($customer->phone, $message);

            SmsSend::create([
                'sms_template_id' => $template->id,
                'customer_id' => $customer->id,
                'sent_by' => auth()->id(),
                'phone' => $customer->phone,
                'message' => $message,
                'status' => $result['status'],
                'error' => $result['error'],
            ]);

            $result['status'] === 'failed' ? $failed++ : $sent++;
        }

        $message = "Processed {$sent} message(s).";
        if ($failed > 0) {
            $message .= " {$failed} failed — check the send log.";
        }
        if (config('sms.driver', 'log') === 'log') {
            $message .= ' No real SMS provider is configured yet, so these were only logged (see config/sms.php).';
        }

        return redirect()->route('sms-templates.index')->with('success', $message);
    }

    public function sendLog($id)
    {
        $template = SmsTemplate::findOrFail($id);
        $logs = $template->sends()->with('customer')->latest()->paginate(50);

        return view('admin_panel.sms_templates.log', compact('template', 'logs'));
    }
}
