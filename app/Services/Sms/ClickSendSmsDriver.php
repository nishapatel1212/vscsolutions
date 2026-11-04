<?php

namespace App\Services\Sms;

use App\Contracts\SmsDriver;
use Illuminate\Support\Facades\Http;

class ClickSendSmsDriver implements SmsDriver
{
    public function send(string $toPhone, string $message): array
    {
        $username = config('sms.clicksend.username');
        $apiKey = config('sms.clicksend.api_key');
        $from = config('sms.clicksend.from') ?: company('company_name', 'Your Business');

        if (!$username || !$apiKey) {
            return ['status' => 'failed', 'error' => 'ClickSend is not configured — set CLICKSEND_USERNAME, CLICKSEND_API_KEY in .env.'];
        }

        $response = Http::withBasicAuth($username, $apiKey)
            ->post('https://rest.clicksend.com/v3/sms/send', [
                'messages' => [[
                    'to' => $toPhone,
                    'body' => $message,
                    'from' => $from,
                ]],
            ]);

        if ($response->successful() && $response->json('data.messages.0.status') !== 'FAILED') {
            return ['status' => 'sent', 'error' => null];
        }

        return ['status' => 'failed', 'error' => $response->json('response_msg') ?? $response->body()];
    }
}
