<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MarketingEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $emailSubject;
    public string $bodyHtml;

    public function __construct(string $subject, string $bodyHtml)
    {
        $this->emailSubject = $subject;
        $this->bodyHtml = $bodyHtml;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.marketing',
            with: ['bodyHtml' => $this->bodyHtml],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
