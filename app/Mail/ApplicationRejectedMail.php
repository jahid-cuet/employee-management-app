<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $reason
    ) {}

    public function build(): self
    {
        return $this->subject('Application Update Rejection Notice')
            ->view('emails.application_rejected')
            ->with([
                'name' => $this->name,
                'reason' => $this->reason,
            ]);
    }
}
