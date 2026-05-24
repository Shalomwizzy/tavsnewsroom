<?php

namespace App\Jobs;

use App\Models\PushNotification;
use App\Services\OneSignalService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPushNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 60;
    public int $tries   = 2;

    public function __construct(
        private string  $title,
        private string  $message,
        private string  $url      = '',
        private string  $imageUrl = '',
        private string  $type     = 'manual',
        private ?int    $sentBy   = null,
    ) {}

    public function handle(OneSignalService $onesignal): void
    {
        $recipients = $onesignal->sendToAll($this->title, $this->message, $this->url, $this->imageUrl);

        PushNotification::create([
            'title'      => $this->title,
            'message'    => $this->message,
            'url'        => $this->url ?: null,
            'image_url'  => $this->imageUrl ?: null,
            'type'       => $this->type,
            'recipients' => $recipients,
            'sent_by'    => $this->sentBy,
        ]);
    }
}
