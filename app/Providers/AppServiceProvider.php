<?php

namespace App\Providers;

use App\Http\View\Composers\SiteLogoComposer;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\FooterComposer;
use App\Http\View\Composers\PostNewsComposer;
use App\Http\View\Composers\InboxComposer;
use App\Http\View\Composers\CookieConsentComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */


    public function register(): void
    {
        //
    }

   



    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the view composer
        View::composer('partials.footer', FooterComposer::class);
        View::composer('post-news.show', PostNewsComposer::class);
        View::composer('*', InboxComposer::class);
        View::composer('*', SiteLogoComposer::class); 
        // View::composer('*', CookieConsentComposer::class); 
    }
}
