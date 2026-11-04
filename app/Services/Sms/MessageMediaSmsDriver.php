<?php

namespace App\Services\Sms;

use App\Contracts\SmsDriver;
use Illuminate\Support\Facades\Http;

class MessageMediaSmsDriver implements SmsDriver
{
    public function send(string $toPhone, string $message): array
    {
        $apiKey = config('sms.messagemedia.api_key');
        $apiSecret = config('sms.messagemedia.api_secret');

        if (!$apiKey || !$apiSecret) {
            return ['status' => 'failed', 'error' => 'MessageMedia is not configured — set MESSAGEMEDIA_API_KEY, MESSAGEMEDIA_API_SECRET in .env.'];
        }

        $response = Http::withBasicAuth($apiKey, $apiSecret)
            ->post('https://api.messagemedia.com/v1/messages', [
                'messages' => [[
                    'content' => $message,
                    'destination_number' => $toPhone,
                ]],
            ]);

        if ($response->successful()) {
            return ['status' => 'sent', 'error' => null];
        }

        return ['status' => 'failed', 'error' => $response->json('message') ?? $response->body()];
    }
}
