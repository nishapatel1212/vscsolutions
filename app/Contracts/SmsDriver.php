<?php

namespace App\Contracts;

interface SmsDriver
{
    /**
     * Send an SMS message.
     *
     * @return array{status: string, error: ?string} status is 'sent', 'logged', or 'failed'
     */
    public function send(string $toPhone, string $message): array;
}
