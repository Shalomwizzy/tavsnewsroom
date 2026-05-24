<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\PublishScheduledPosts;
use App\Console\Commands\GenerateSitemap;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        PublishScheduledPosts::class,
        GenerateSitemap::class,
    ];

    /**
     * Define the application's command schedule.
     */   protected function schedule(Schedule $schedule): void
    {
        // Schedule the publish-scheduled-posts command to run every minute
        $schedule->command('app:publish-scheduled-posts')->everyMinute();

        // Schedule the sitemap to be generated every day at midnight
        // $schedule->command('app:generate-sitemap')->daily();
        $schedule->command('app:generate-sitemap')->everyMinute();

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
