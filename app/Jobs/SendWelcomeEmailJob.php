<?php

namespace App\Jobs;

use App\Mail\WelcomeSubscriberEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(public readonly string $email) {}

    public function handle(): void
    {
        try {
            Mail::to($this->email)->send(new WelcomeSubscriberEmail($this->email));
        } catch (\Throwable $e) {
            Log::warning('Welcome email failed for ' . $this->email . ': ' . $e->getMessage());
        }
    }
}
