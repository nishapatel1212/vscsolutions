<?php

namespace Database\Seeders;

use App\Models\SmsTemplate;
use Illuminate\Database\Seeder;

class SmsTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $company = company('company_name', 'Your Company');

        $templates = [
            [
                'name' => 'Job Reminder',
                'trigger_type' => 'job_reminder',
                'message' => "Hi {{name}}, this is a reminder from {$company} about your upcoming job. Reply or call us if you need to reschedule.",
            ],
            [
                'name' => 'Quote Follow-up',
                'trigger_type' => 'quote_followup',
                'message' => "Hi {{name}}, just following up on the quote we sent from {$company}. Let us know if you have any questions or would like to go ahead.",
            ],
            [
                'name' => 'Invoice Due Reminder',
                'trigger_type' => 'invoice_due',
                'message' => "Hi {{name}}, a friendly reminder that your {$company} invoice is due. Reply if you have any questions about payment.",
            ],
        ];

        foreach ($templates as $template) {
            SmsTemplate::firstOrCreate(['name' => $template['name']], $template);
        }
    }
}
