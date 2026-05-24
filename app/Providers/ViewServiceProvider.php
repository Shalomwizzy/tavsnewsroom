<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\TrendingNews;
use App\Models\Contact;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Bind trending news data to the partials.topbar view
        View::composer('partials.topbar', function ($view) {
            $trendingNews = TrendingNews::with('postNews')
                ->where('section', 'top')
                ->orWhere('section', 'body')
                ->get();
                
            $view->with('trendingNews', $trendingNews);
        });

        // Bind message count and recent messages to the layouts.admin view
        View::composer('layouts.admin', function ($view) {
            $messageCount = Contact::count();
            $recentMessages = Contact::orderBy('created_at', 'desc')->take(3)->get();
            $view->with(compact('messageCount', 'recentMessages'));
        });
    }
}
