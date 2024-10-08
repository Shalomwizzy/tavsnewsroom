<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PostNews;
use Carbon\Carbon;

class PublishScheduledPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:publish-scheduled-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish scheduled posts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $scheduledPosts = PostNews::where('status', 'pending')
                                  ->where('scheduled_for', '<=', $now)
                                  ->get();

        foreach ($scheduledPosts as $post) {
            $post->update(['status' => 'published']);
        }

        $this->info('Scheduled posts published successfully.');
    }
}