<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OneSignalService
{
    private string $appId;
    private string $restKey;
    private string $baseUrl = 'https://onesignal.com/api/v1';

    public function __construct()
    {
        $this->appId   = config('services.onesignal.app_id', '');
        $this->restKey = config('services.onesignal.rest_api_key', '');
    }

    public function isConfigured(): bool
    {
        return !empty($this->appId) && !empty($this->restKey);
    }

    /**
     * Send a push notification to all subscribed users.
     * Returns the number of recipients or 0 on failure.
     */
    public function sendToAll(string $title, string $message, string $url = '', string $imageUrl = ''): int
    {
        if (!$this->isConfigured()) {
            Log::warning('OneSignal not configured — skipping push notification');
            return 0;
        }

        $payload = [
            'app_id'            => $this->appId,
            'included_segments' => ['All'],
            'headings'          => ['en' => $title],
            'contents'          => ['en' => $message],
        ];

        if (!empty($url)) {
            $payload['url'] = $url;
        }

        if (!empty($imageUrl)) {
            $payload['big_picture'] = $imageUrl;
            $payload['chrome_web_image'] = $imageUrl;
        }

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Basic ' . $this->restKey,
                    'Content-Type'  => 'application/json',
                ])
                ->post("{$this->baseUrl}/notifications", $payload);

            if ($response->successful()) {
                $recipients = $response->json('recipients', 0);
                Log::info('OneSignal push sent', ['title' => $title, 'recipients' => $recipients]);
                return (int) $recipients;
            }

            Log::error('OneSignal push failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
        } catch (\Throwable $e) {
            Log::error('OneSignal exception', ['error' => $e->getMessage()]);
        }

        return 0;
    }
}
