<?php

namespace App\Services\Sms;

use App\Contracts\SmsDriver;
use Illuminate\Support\Facades\Http;

class TwilioSmsDriver implements SmsDriver
{
    public function send(string $toPhone, string $message): array
    {
        $sid = config('sms.twilio.sid');
        $token = config('sms.twilio.token');
        $from = config('sms.twilio.from');

        if (!$sid || !$token || !$from) {
            return ['status' => 'failed', 'error' => 'Twilio is not configured — set TWILIO_SID, TWILIO_TOKEN, TWILIO_FROM in .env.'];
        }

        $response = Http::asForm()
            ->withBasicAuth($sid, $token)
            ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                'To' => $toPhone,
                'From' => $from,
                'Body' => $message,
            ]);

        if ($response->successful()) {
            return ['status' => 'sent', 'error' => null];
        }

        return ['status' => 'failed', 'error' => $response->json('message') ?? $response->body()];
    }
}
