<?php

namespace App\Jobs;

use App\Services\AIBlogService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateAIBlogPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 300;
    public int $tries   = 1;

    public function __construct(private ?int $categoryId = null) {}

    public function handle(AIBlogService $service): void
    {
        $count = config('ai.blog.articles_per_run', 1);

        for ($i = 0; $i < $count; $i++) {
            $log = $service->generate($this->categoryId);
            Log::info('AI blog job finished', [
                'log_id' => $log->id,
                'status' => $log->status,
            ]);
        }
    }
}
