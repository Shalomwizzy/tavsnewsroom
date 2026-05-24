<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RegenerateSitemapJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 2;

    public function handle(): void
    {
        try {
            Artisan::call('app:generate-sitemap');
            $sitemapUrl = url('/sitemap.xml');
            Http::timeout(5)->get('https://www.google.com/ping', ['sitemap' => $sitemapUrl]);
        } catch (\Throwable $e) {
            Log::warning('Sitemap generation failed: ' . $e->getMessage());
        }
    }
}
