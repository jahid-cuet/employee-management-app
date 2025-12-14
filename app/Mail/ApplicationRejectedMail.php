<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $reason
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Application Update – Rejection Notice'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.application_rejected',
            with: [
                'name'   => $this->name,
                'reason' => $this->reason,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
