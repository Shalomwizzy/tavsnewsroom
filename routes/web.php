<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TwitterController;
use App\Http\Controllers\TrendingNewsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TopNewsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostNewsController;
use App\Http\Controllers\CarouselNewsController;
use App\Http\Controllers\FeaturedNewsController;
use App\Http\Controllers\CategoryPostNewsController;
use App\Http\Controllers\PopularNewsController;
use App\Http\Controllers\SocialFollowController;
use App\Http\Controllers\LatestNewsController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\BlogSettingsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandNameController;
use App\Http\Controllers\QuickLinkController;
use App\Http\Controllers\WebsiteSettingsController;
use App\Http\Controllers\FooterSettingsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\EmailSettingsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SEOController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShareInteractionController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\NavbarItemController;
use App\Http\Controllers\AnnouncementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





Auth::routes();
// Auth::routes(['register' => false]);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');





// ROUTE FOR ONLY ADMIN ACCESS
Route::middleware(['auth', 'role.admin', 'cors'])->group(function () {

 

 // ENV ROUTE
 Route::get('admin/env-settings', [AdminController::class, 'showEnvForm'])->name('admin.env.show');
 Route::post('admin/env-settings', [AdminController::class, 'updateEnv'])->name('admin.env.update');



// CONTACT US ROUTE
Route::post('/admin/messages/reply/{id}', [ContactController::class, 'replyToMessage'])->name('contact.reply');


// USER ROUTE
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// EMAIL SETTINGS ROUTE
Route::get('/admin/email-settings', [EmailSettingsController::class, 'emailSettings'])->name('admin.email-settings');
Route::post('/admin/email-settings', [EmailSettingsController::class, 'saveEmailSettings']);


// SUBSCRIBER ROUTE
Route::post('/admin/subscribers/send-mail', [SubscriberController::class, 'sendMail'])->name('admin.subscribers.mail');
Route::get('/admin/subscribers/create', [SubscriberController::class, 'create'])->name('admin.subscribers.create');


// CATEGORIES ROUTE
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::get('/admin/select-homepage-categories', [CategoryController::class, 'selectHomepageCategories'])->name('categories.select_homepage');
Route::post('/admin/update-homepage-categories', [CategoryController::class, 'updateHomepageCategories'])->name('categories.update_homepage');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');


// POST NEWS ROUTES
Route::put('/post-news/{id}/approve', [PostNewsController::class, 'approve'])->name('post-news.approve');
Route::delete('/post-news/{id}', [PostNewsController::class, 'destroy'])->name('post-news.destroy');

// TRENDING NEWS
Route::post('admin/trending-news/update', [TrendingNewsController::class, 'update'])->name('admin.trending-news.update');

// TOP NEWS
Route::post('/admin/top-news/update', [TopNewsController::class, 'updateTopNews'])->name('admin.top-news.update');

// CAROUSEL NEWS
Route::post('/admin/carousel/update', [CarouselNewsController::class, 'update'])->name('admin.carousel.update');

// FEATURED NEWS
Route::post('/admin/featured-news/update', [FeaturedNewsController::class, 'update'])->name('admin.featured_news.update');

// POPULAR NEWS
Route::post('/admin/popular-news/update', [PopularNewsController::class, 'update'])->name('admin.popular_news.update');

// LATEST NEWS
Route::post('/admin/latest-news/update', [LatestNewsController::class, 'update'])->name('admin.latest_news.update');

// TAG 
Route::post('tags', [TagController::class, 'update'])->name('tags.update');

// CATEGORY/POSTNEWS
Route::post('/admin/category-post-news', [CategoryPostNewsController::class, 'update'])->name('admin.categoryPostNews.update');

// SOCIAL FOLLOWS
Route::post('/social-follows/store', [SocialFollowController::class, 'store'])->name('admin.social_follows.store');
Route::post('/social-follows/update/{id}', [SocialFollowController::class, 'update'])->name('admin.social_follows.update');
Route::post('/social-follows/edit/{id}', [SocialFollowController::class, 'edit'])->name('admin.social_follows.edit');
Route::delete('/social-follows/destroy/{id}', [SocialFollowController::class, 'destroy'])->name('admin.social_follows.destroy');

// QUICK LINK
Route::post('/quick-links/update', [QuickLinkController::class, 'update'])->name('admin.quick_links.update');

//BLOG SETTING 
Route::get('/admin/blog-settings/{key}', [BlogSettingsController::class, 'edit'])->name('admin.blog-settings.edit');
Route::post('/admin/blog-settings/{key}', [BlogSettingsController::class, 'update'])->name('admin.blog-settings.update');

 // BRAND NAME 
 Route::get('/admin/brand-name', [BrandNameController::class, 'index'])->name('admin.brand-name');
 Route::post('/admin/brand-name', [BrandNameController::class, 'save'])->name('admin.brand-name.save');
 

 // WEBSITE SETTINGS
 Route::post('/admin/website-settings/save', [WebsiteSettingsController::class, 'save'])->name('admin.website-settings.save');

 // FOOTER SETTINGS 
 Route::get('footer-settings', [FooterSettingsController::class, 'edit'])->name('admin.footer_settings.index');
 Route::post('footer-settings', [FooterSettingsController::class, 'update'])->name('admin.footer_settings.update');


 // MAINTENANCE ROUTE

 Route::post('/admin/toggle-maintenance', [AdminController::class, 'toggleMaintenance'])->name('admin.toggle.maintenance');


 //ANNOUNCEMENT ROUTE

 Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
 Route::post('/announcements/store', [AnnouncementController::class, 'store'])->name('announcements.store');
 Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
 Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
 Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
 Route::patch('/announcements/{announcement}/toggle', [AnnouncementController::class, 'toggle'])->name('announcements.toggle');


//  NAVBAR ROUTE
Route::post('navbar-items', [NavbarItemController::class, 'store'])->name('admin.navbar-items.store');

});












// ROUTES FOR BOTH ADMIN AND WRITER ACCESS

    
Route::middleware(['auth', 'role.admin.writer', 'cors'])->group(function () {
 // ADMIN DASHBOARD
 Route::get('/admin.dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
 Route::get('/full-calendar', [AdminController::class, 'showFullCalendar'])->name('full-calendar');
 Route::post('/admin/clear-caches', [AdminController::class, 'clearCaches'])->name('admin.clear.caches');
 Route::get('/admin/clear-cache', [AdminController::class, 'showClearCachePage'])->name('admin.show.clear.cache');



 // TODO LIST ROUTE
Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
Route::post('/todos/{id}/toggle', [TodoController::class, 'toggle'])->name('todos.toggle');
Route::delete('/todos/{id}', [TodoController::class, 'destroy'])->name('todos.destroy');


// SHAREINTERCTION ROUTE
Route::post('/post-news/{post}/share', [ShareInteractionController::class, 'store'])->name('post-news.share');
Route::get('/admin/share-interactions', [ShareInteractionController::class, 'index'])->name('share-interactions.index');



// CONTACT US ROUTE
Route::get('/admin/messages', [ContactController::class, 'showAllMessages'])->name('contact.index');


// USER ROUTE
Route::put('/user/update-account', [UserController::class, 'updateAccount'])->name('user.updateAccount');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::get('/users', [UserController::class, 'index'])->name('users.index');


// SUBSCRIBER ROUTE
Route::get('/admin/subscribers', [SubscriberController::class, 'index'])->name('admin.subscribers.index');


// MESSAGE ROUTE 
Route::get('messages/create', [MessageController::class, 'create'])->name('messages.create');
Route::get('messages/{receiver_id?}', [MessageController::class, 'index'])->name('messages.index');
Route::post('messages', [MessageController::class, 'store'])->name('messages.store');

// CATEGORIES ROUTE
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// POST NEWS ROUTES
Route::get('/post-news', [PostNewsController::class, 'index'])->name('post-news.index');
Route::get('/post-news/create', [PostNewsController::class, 'create'])->name('post-news.create');
// Route::get('/post-news/show', [PostNewsController::class, 'show'])->name('post-news.show');
Route::post('/post-news', [PostNewsController::class, 'store'])->name('post-news.store');
Route::get('/admin/post-news/{post}', [PostNewsController::class, 'adminShow'])->name('admin.post-news.show');
Route::get('/post-news/{id}/edit', [PostNewsController::class, 'edit'])->name('post-news.edit');
Route::put('/post-news/{id}', [PostNewsController::class, 'update'])->name('post-news.update');
Route::get('/draft', [PostNewsController::class, 'draft'])->name('admin.draft-news');
Route::get('/pending', [PostNewsController::class, 'pending'])->name('admin.pending-news');
Route::get('/published', [PostNewsController::class, 'published'])->name('admin.published-news');

// SEO ROUTE
Route::get('/seo', [SEOController::class, 'index'])->name('seo.index');
Route::get('/seo/analyze/{id}', [SEOController::class, 'analyze'])->name('seo.analyze');
Route::get('/seo/show-all', [SEOController::class, 'showAll'])->name('seo.show');

//ANNOUNCEMENT ROUTE
Route::get('/announcements/index', [AnnouncementController::class, 'index'])->name('announcements.index');


// NAVBAR ITEMS
Route::get('navbar-items', [NavbarItemController::class, 'index'])->name('admin.navbar-items.index');


// TRENDING NEWS
Route::get('admin/trending-news', [TrendingNewsController::class, 'index'])->name('admin.trending-news.index');


// TOP NEWS
Route::get('/admin/top-news', [TopNewsController::class, 'topNews'])->name('admin.top-news');

// CAROUSEL NEWS
Route::get('/admin/carousel', [CarouselNewsController::class, 'index'])->name('admin.carousel.index');

// FEATURED NEWS
Route::get('/admin/featured-news', [FeaturedNewsController::class, 'index'])->name('admin.featured_news.index');

// POPULAR NEWS
Route::get('/admin/popular-news', [PopularNewsController::class, 'index'])->name('admin.popular_news.index');

// LATEST NEWS
Route::get('/admin/latest-news', [LatestNewsController::class, 'index'])->name('admin.latest_news.index');

// TAG 
Route::get('tags', [TagController::class, 'show'])->name('tags.show');

// CATEGORY/POSTNEWS
Route::get('/admin/category-post-news', [CategoryPostNewsController::class, 'index'])->name('admin.categoryPostNews.index');


// SOCIAL FOLLOWS
Route::get('/social-follows', [SocialFollowController::class, 'index'])->name('admin.social_follows.index');

// QUICK LINK
Route::get('/quick-links', [QuickLinkController::class, 'index'])->name('admin.quick_links.index');

//BLOG SETTING 
Route::get('/admin/blog-settings', [BlogSettingsController::class, 'index'])->name('admin.blog-settings.index');

 // MAINTENANCE ROUTE
 Route::get('/admin/maintenance', [AdminController::class, 'maintenance'])->name('admin.maintenance');


  // WEBSITE SETTINGS
  Route::get('/admin/website-settings', [WebsiteSettingsController::class, 'index'])->name('admin.website-settings.index');

 
});













// GENERAL ROUTE 

Route::middleware(['cors'])->group(function () {

  // REGISTER ROUTE
 Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
 Route::post('register', [RegisterController::class, 'register'])->name('register');
 

// ERROR ROUTE 
Route::get('/404', [ErrorController::class, 'show404'])->name('errors.404');

// SEARCH ROUTE
Route::get('/search', [SearchController::class, 'search'])->name('search');

// SUBSCRIBER ROUTE
Route::post('/subscribe', [SubscriberController::class, 'subscribe'])->name('subscribe');
Route::get('/unsubscribe', [SubscriberController::class, 'unsubscribe'])->name('unsubscribe');


// PAGES ROUTE
Route::get('/', [PagesController::class, 'welcome'])->name('welcome');
Route::get('/about', [PagesController::class, 'about'])->name('about');
Route::get('/advertise', [PagesController::class, 'advertise'])->name('advertise');
Route::get('/privacy-policy', [PagesController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-conditions', [PagesController::class, 'termsConditions'])->name('terms-conditions');
Route::get('/contact', [PagesController::class, 'contact'])->name('contact');
Route::get('/contactUs', [PagesController::class, 'contactUs'])->name('contact-us');
Route::get('/cookie-policy', [PagesController::class, 'cookiePolicy'])->name('cookie-policy');
Route::get('/dmca', [PagesController::class, 'dmca'])->name('dmca');
Route::get('/affiliate-disclosure', [PagesController::class, 'affiliateDisclosure'])->name('affiliate_disclosure');
Route::get('/disclaimer', [PagesController::class, 'disclaimer'])->name('disclaimer');



  
// CATEGORIES ROUTE
Route::get('/categories/show', [CategoryController::class, 'showCategories'])->name('categories.show');

Route::get('/{slug}', [CategoryController::class, 'showCategoryNews'])->name('category.show');


// POST NEWS ROUTES
Route::get('/post-news/show', [PostNewsController::class, 'show'])->name('post-news.show');
Route::get('/{year}/{month}/{day}/{slug}', [PostNewsController::class, 'readMore'])->name('post-news.read-more');


// CONTACT US ROUTE
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');



// COOKIE ROUTE
Route::post('/accept-cookies', [CookieController::class, 'acceptCookies'])->name('accept-cookies');
Route::post('/reject-cookies', [CookieController::class, 'rejectCookies'])->name('reject-cookies');

Route::get('/cookie-policy', [PagesController::class, 'cookiePolicy'])->name('cookie-policy');

 
});