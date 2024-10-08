<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\TopNews;
use App\Models\CarouselNews;
use App\Models\PostNews;
use App\Models\FeaturedNews;
use App\Models\LatestNews;
use App\Models\PopularNews;
use App\Models\QuickLink;
use App\Models\SocialFollows;
use App\Models\Tags;
use App\Models\TrendingNews;
use Illuminate\Support\Facades\Log;


class PagesController extends Controller
{
   

    public function welcome(Request $request)
{

   

    // Fetch categories for the homepage
    $categories = Category::where('show_on_homepage', true)->limit(4)->get();

    // Fetch top news for the homepage
    $topNews = TopNews::with('postNews')->get();

    $categories = Category::with(['postNews' => function ($query) {
        $query->whereHas('categoryPostNews');
    }])->get();

    // Fetch carousel news for the homepage
    $carouselNews = CarouselNews::with('postNews')->get();

     // Fetch featured news for the homepage
     $featuredNews = FeaturedNews::with('postNews')->get();

       // Fetch trending news for the homepage
    $trendingNews = TrendingNews::with('postNews')->get();

      

     // Fetch popular news for the homepage
     $popularNews = PopularNews::with('postNews')->get();

       // Fetch latest news for the homepage
     $latestNews = LatestNews::with('postNews')->get();

          // Fetch selected social follows
     $socialFollows = SocialFollows::where('is_active', true)->get();

     $tags = Tags::with('category')->get();



       // Fetch active quick links
       $quickLinks = QuickLink::where('is_active', true)->get();

  // Check if the Cookie quick link is active and the cookie consent is not yet accepted
  $showCookieConsent = $quickLinks->where('url', '/cookie-policy')->where('is_active', true)->isNotEmpty() && !$request->cookie('cookie_consent');


    // Fetch active announcements
    $announcements = Announcement::where('active', true)->get();

 

    return view('welcome', compact('categories', 'topNews', 'carouselNews','featuredNews','trendingNews','popularNews','latestNews','socialFollows','tags','quickLinks','showCookieConsent','announcements'));

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
