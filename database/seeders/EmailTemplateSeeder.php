<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $company = company('company_name', 'Your Company');

        $templates = [
            [
                'name' => 'Annual Safety Check Reminder',
                'subject' => 'Time for your annual electrical safety check',
                'body' => '<p>Hi {{name}},</p>'
                    . "<p>It has been a year since your last electrical safety check with {$company}. Regular checks keep your home or business compliant and safe.</p>"
                    . '<p>Reply to this email or call us to book your next inspection.</p>'
                    . "<p>Thanks,<br>{$company}</p>",
            ],
            [
                'name' => 'Seasonal Promotion',
                'subject' => "Spring into savings with {$company}",
                'body' => '<p>Hi {{name}},</p>'
                    . '<p>For a limited time, we\'re offering a discount on switchboard upgrades and smoke alarm installations.</p>'
                    . '<p>Get in touch to book your job before the offer ends.</p>'
                    . "<p>Thanks,<br>{$company}</p>",
            ],
            [
                'name' => 'Referral Thank You',
                'subject' => "Thank you for referring {$company}",
                'body' => '<p>Hi {{name}},</p>'
                    . "<p>Thank you for referring a friend or family member to {$company} — we really appreciate your support!</p>"
                    . '<p>If you ever need any electrical work done, we\'re just a call away.</p>'
                    . "<p>Thanks,<br>{$company}</p>",
            ],
            [
                'name' => 'New Service Announcement',
                'subject' => "New service now available from {$company}",
                'body' => '<p>Hi {{name}},</p>'
                    . '<p>We\'re excited to let you know about a new service we now offer. Reply to this email to find out more or to book a free quote.</p>'
                    . "<p>Thanks,<br>{$company}</p>",
            ],
            [
                'name' => 'Job Completion',
                'subject' => "Your job with {$company} is complete",
                'body' => '<div style="font-family: Arial, Helvetica, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">'
                    . '<div style="background: #0b1f3a; padding: 20px 24px; display: flex; justify-content: space-between; align-items: center;">'
                    . "<span style=\"color: #ffffff; font-size: 20px; font-weight: bold;\">" . e($company) . "</span>"
                    . '</div>'
                    . '<div style="padding: 28px 24px;">'
                    . '<h2 style="color: #0b1f3a; margin-top: 0;">Your Electrical Job is Complete ✅</h2>'
                    . '<p>Hi {{customer_name}},</p>'
                    . "<p>Thank you for choosing {$company}. We're pleased to confirm the job at <strong>{{job_address}}</strong> was completed on <strong>{{job_date}}</strong>.</p>"
                    . '<div style="background: #f3f4f6; border-left: 4px solid #e8581c; padding: 14px 18px; margin: 20px 0;">'
                    . '<p style="margin: 4px 0;"><strong>Job Reference:</strong> {{job_number}}</p>'
                    . '<p style="margin: 4px 0;"><strong>Work Completed:</strong> {{work_description}}</p>'
                    . '<p style="margin: 4px 0;"><strong>Technician:</strong> {{technician_name}}</p>'
                    . '</div>'
                    . '<p>If you have any questions about the work carried out, or notice anything that needs attention, please don\'t hesitate to reach out.</p>'
                    . '<p style="margin: 24px 0;"><a href="{{review_link}}" style="background: #e8a73a; color: #0b1f3a; font-weight: bold; padding: 12px 20px; border-radius: 4px; text-decoration: none; display: inline-block;">Leave Us a Review</a></p>'
                    . '<p>Thank you again for your business!</p>'
                    . "<p>Warm regards,<br><strong>{$company} Team</strong></p>"
                    . '</div>'
                    . '<div style="background: #0b1f3a; color: #cbd5e1; text-align: center; padding: 14px; font-size: 12px;">'
                    . '{{phone_number}} | {{company_website}}'
                    . '</div>'
                    . '</div>',
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::firstOrCreate(['name' => $template['name']], $template);
        }
    }
}
