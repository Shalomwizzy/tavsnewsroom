<?php

namespace App\Jobs;

use App\Mail\NewsletterEmail;
use App\Models\PostNews;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(public readonly int $postId) {}

    public function handle(): void
    {
        $post = PostNews::find($this->postId);

        if (!$post || $post->status !== 'published') {
            return;
        }

        Subscriber::query()->each(function (Subscriber $subscriber) use ($post) {
            try {
                Mail::to($subscriber->email)->send(new NewsletterEmail($post, $subscriber->email));
            } catch (\Throwable $e) {
                Log::warning('Newsletter send failed for ' . $subscriber->email . ': ' . $e->getMessage());
            }
        });
    }
}
