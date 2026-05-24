<?php

namespace App\Console\Commands;

use App\Services\AIBlogService;
use Illuminate\Console\Command;

class GenerateAIBlogPost extends Command
{
    protected $signature   = 'ai:generate-blog {--category= : Category ID to target}';
    protected $description = 'Generate and publish an AI-written blog post using Groq + Gemini';

    public function handle(AIBlogService $service): void
    {
        $categoryId = $this->option('category') ? (int) $this->option('category') : null;

        $this->info('Starting AI blog generation...');
        $log = $service->generate($categoryId);

        if ($log->status === 'completed') {
            $this->info("Done. Post ID: {$log->post_news_id} | Headline: {$log->headline}");
            $this->info("Humanness score: {$log->humanness_score}/100 | Words: {$log->word_count}");
        } else {
            $this->error("Failed: {$log->error}");
        }
    }
}
