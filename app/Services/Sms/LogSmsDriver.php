<?php

namespace App\Services\Sms;

use App\Contracts\SmsDriver;
use Illuminate\Support\Facades\Log;

/**
 * Default driver — no SMS provider configured yet.
 * Writes the message to the Laravel log instead of actually sending it, so the
 * rest of the feature (templates, recipient selection, send history) is fully
 * usable before a real provider (Twilio / ClickSend / MessageMedia) is wired up.
 *
 * Switch providers by setting SMS_DRIVER in .env and filling in the matching
 * credentials in config/sms.php — no changes needed elsewhere in the app.
 */
class LogSmsDriver implements SmsDriver
{
    public function send(string $toPhone, string $message): array
    {
        Log::info('[SMS:log driver] Would send SMS', [
            'to' => $toPhone,
            'message' => $message,
        ]);

        return ['status' => 'logged', 'error' => null];
    }
}
