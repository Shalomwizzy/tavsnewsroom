<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\TopNews;
use App\Models\CarouselNews;
use App\Models\FeaturedNews;
use App\Models\LatestNews;
use App\Models\PopularNews;
use App\Models\QuickLink;
use App\Models\SocialFollows;
use App\Models\Tags;
use App\Models\TrendingNews;
use Illuminate\Support\Facades\Cache;


class PagesController extends Controller
{
   

    public function welcome(Request $request)
    {
        $topNews      = Cache::remember('hp_top_news',      300, fn() => TopNews::with('postNews')->get());
        $carouselNews = Cache::remember('hp_carousel',      300, fn() => CarouselNews::with('postNews')->get());
        $featuredNews = Cache::remember('hp_featured',      300, fn() => FeaturedNews::with('postNews')->get());
        $trendingNews = Cache::remember('hp_trending',      300, fn() => TrendingNews::with('postNews')->get());
        $popularNews  = Cache::remember('hp_popular',       300, fn() => PopularNews::with('postNews')->get());
        $latestNews   = Cache::remember('hp_latest',        300, fn() => LatestNews::with('postNews')->get());
        $socialFollows= Cache::remember('hp_social_follows',300, fn() => SocialFollows::where('is_active', true)->get());
        $tags         = Cache::remember('hp_tags',          300, fn() => Tags::with('category')->get());
        $quickLinks   = Cache::remember('hp_quick_links',   300, fn() => QuickLink::where('is_active', true)->get());
        $announcements= Cache::remember('hp_announcements', 300, fn() => Announcement::where('active', true)->get());
        $categories   = Cache::remember('hp_categories',    300, fn() => Category::with(['postNews' => function ($query) {
            $query->whereHas('categoryPostNews');
        }])->get());

        $showCookieConsent = $quickLinks->where('url', '/cookie-policy')->where('is_active', true)->isNotEmpty()
            && !$request->cookie('cookie_consent');

        return view('welcome', compact(
            'categories', 'topNews', 'carouselNews', 'featuredNews', 'trendingNews',
            'popularNews', 'latestNews', 'socialFollows', 'tags', 'quickLinks',
            'showCookieConsent', 'announcements'
        ));
    }



public function about()
{
    // Fetch active quick links
    $quickLinks = QuickLink::where('is_active', true)->get();

    return view('about', compact('quickLinks'));
}

public function advertise()
{
    // Fetch active quick links
    $quickLinks = QuickLink::where('is_active', true)->get();

    return view('advertise', compact('quickLinks'));
}

public function privacyPolicy()
{
    // Fetch active quick links
    $quickLinks = QuickLink::where('is_active', true)->get();

    return view('privacy-policy', compact('quickLinks'));
}

public function cookiePolicy()
{
      // Fetch active quick links
      $quickLinks = QuickLink::where('is_active', true)->get();
    return view('cookie-policy', compact('quickLinks'));
}


public function termsConditions()
{
    // Fetch active quick links
    $quickLinks = QuickLink::where('is_active', true)->get();

    return view('terms-conditions', compact('quickLinks'));
}

public function disclaimer()
{
    // Fetch active quick links
    $quickLinks = QuickLink::where('is_active', true)->get();

    return view('disclaimer', compact('quickLinks'));
}

public function affiliateDisclosure()
{
    // Fetch active quick links
    $quickLinks = QuickLink::where('is_active', true)->get();

    return view('affiliate-disclosure', compact('quickLinks'));
}

public function dmca()
{
    // Fetch active quick links
    $quickLinks = QuickLink::where('is_active', true)->get();

    return view('dmca', compact('quickLinks'));
}




public function contact()
{
    // Fetch active quick links
    $quickLinks = QuickLink::where('is_active', true)->get();

    $siteEmail = WebsiteSetting::getValue('site_email', 'default@example.com');
    $sitePhone = WebsiteSetting::getValue('site_phone', '+012 345 6789');

    return view('contact', compact('quickLinks', 'siteEmail', 'sitePhone'));
}




public function contactUs()
{
      // Fetch active quick links
      $quickLinks = QuickLink::where('is_active', true)->get();

      $siteEmail = WebsiteSetting::getValue('site_email', 'default@example.com');
      $sitePhone = WebsiteSetting::getValue('site_phone', '+012 345 6789');

      return view('contact-us', compact('quickLinks', 'siteEmail', 'sitePhone'));
}





}
