<?php

namespace App\Jobs;

use App\Mail\ApplicationRejectedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendApplicationRejectedMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct(public string $name, public string $email, public ?string $reason = null)
    {}

    public function handle(): void
    {
        Mail::to($this->email)->send(
            new ApplicationRejectedMail($this->name, $this->reason)
        );
    }
}
