<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostNews;
use App\Models\PostView;
use App\Models\ToDo;
use App\Models\Contact;
use App\Models\Message;
use App\Models\ShareInteraction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\GoogleAnalyticsService;
use Illuminate\Support\Facades\File;
use App\Models\EnvSetting;
use Illuminate\Support\Facades\Artisan;


class AdminController extends Controller
{

  

    protected $analyticsService;

    public function __construct(GoogleAnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }


    public function showFullCalendar()
{
    return view('admin.dashboard.calendar-index');
}

    public function adminDashboard()
    {
        // Fetching analytics data for the past 7 days
        try {
            $propertyId = \App\Models\WebsiteSetting::getValue('ga_property_id', '');
            $analyticsDataRaw = $propertyId
                ? $this->analyticsService->getAnalyticsData($propertyId, '7daysAgo', 'today')
                : [];
        } catch (\Throwable $e) {
            $analyticsDataRaw = [];
        }

        // Structuring the analytics data to be passed to the view
        $analyticsData = [
            'analyticsData' => $analyticsDataRaw['analyticsData'] ?? [],
            'dates' => $analyticsDataRaw['dates'] ?? [],
            'countryData' => $analyticsDataRaw['countryData'] ?? [],
            'countries' => $analyticsDataRaw['countries'] ?? [],
            'activeUsers' => $analyticsDataRaw['activeUsers'] ?? 0,
            'screenPageViews' => $analyticsDataRaw['screenPageViews'] ?? 0,
            'mostVisitedPage' => $analyticsDataRaw['mostVisitedPage'] ?? 'N/A',
            'mostVisitedPageViews' => $analyticsDataRaw['mostVisitedPageViews'] ?? 0,
        ];

        // Fetching latest 5 to-dos
        $todos = ToDo::orderBy('created_at', 'desc')->take(5)->get();

        // Fetching latest 5 contact messages
        $contactMessages = Contact::orderBy('created_at', 'desc')->take(5)->get();

        // Fetching latest 5 recent posts
        $recentPosts = PostNews::latest()->take(5)->get();

        // Fetching unread message count for the current user
        $messageCount = Message::where('receiver_id', Auth::id())->whereNull('read_at')->count();

        // Fetching latest 5 recent messages for the current user
        $recentMessages = Message::where('receiver_id', Auth::id())->orderBy('created_at', 'desc')->take(5)->get();

        // Fetching unread message count grouped by sender for the current user
        $unreadMessages = Message::select('sender_id', DB::raw('count(*) as total'))
                                ->where('receiver_id', Auth::id())
                                ->whereNull('read_at')
                                ->groupBy('sender_id')
                                ->pluck('total', 'sender_id');

        // Fetching latest 5 inbox messages for the current user
        $inboxMessages = Message::where('receiver_id', Auth::id())->orderBy('created_at', 'desc')->take(5)->get();

        // Fetching latest 5 share interactions
        $shareInteractions = ShareInteraction::select('post_news_id', 'share_type', DB::raw('count(*) as share_count'))
                                ->groupBy('post_news_id', 'share_type')
                                ->orderByDesc('share_count')
                                ->take(5)
                                ->get();

        return view('admin.dashboard.dashboard-index', compact(
            'todos', 
            'contactMessages', 
            'recentPosts', 
            'messageCount', 
            'recentMessages', 
            'unreadMessages', 
            'inboxMessages', 
            'analyticsData', 
            'shareInteractions'
        ));
    }







    public function showEnvForm()
    {
        $settings = EnvSetting::all();
        return view('admin.env.show', compact('settings'));
    }
    
    public function updateEnv(Request $request)
    {
        $request->validate([
            'APP_NAME'         => 'required|string|max:255',
            'APP_URL'          => 'required|url',
            'DB_DATABASE'      => 'required|string|max:255',
            'DB_USERNAME'      => 'required|string|max:255',
            'DB_PASSWORD'      => 'required|string|max:255',
            'MAIL_MAILER'      => 'required|string|max:255',
            'MAIL_HOST'        => 'required|string|max:255',
            'MAIL_PORT'        => 'required|integer',
            'MAIL_USERNAME'    => 'required|string|max:255',
            'MAIL_PASSWORD'    => 'required|string|max:255',
            'MAIL_FROM_ADDRESS'=> 'required|email|max:255',
            'MAIL_FROM_NAME'   => 'required|string|max:255',
        ]);

        // Allowlist: only these keys may be written; quoted keys wrap value in double-quotes
        $allowedKeys = [
            'APP_NAME'          => true,
            'APP_URL'           => false,
            'DB_DATABASE'       => false,
            'DB_USERNAME'       => false,
            'DB_PASSWORD'       => false,
            'MAIL_MAILER'       => false,
            'MAIL_HOST'         => false,
            'MAIL_PORT'         => false,
            'MAIL_USERNAME'     => false,
            'MAIL_PASSWORD'     => false,
            'MAIL_FROM_ADDRESS' => false,
            'MAIL_FROM_NAME'    => true,
        ];

        $envPath    = base_path('.env');
        $envContent = File::get($envPath);

        foreach ($allowedKeys as $key => $quoted) {
            $raw = $request->input($key, '');
            // Strip newlines and carriage returns to prevent .env injection
            $raw = str_replace(["\n", "\r"], '', $raw);
            $value = $quoted ? '"' . $raw . '"' : $raw;
            // Escape \ and $ so preg_replace doesn't treat them as backreferences
            $escaped = str_replace(['\\', '$'], ['\\\\', '\$'], $value);
            $envContent = preg_replace('/^' . preg_quote($key, '/') . '=.*/m', $key . '=' . $escaped, $envContent);
        }

        File::put($envPath, $envContent);

        return redirect()->route('admin.dashboard')->with('status', 'Environment settings updated successfully.');
    }


        // Display the Clear Caches & Optimize page
        public function showClearCachePage()
        {
            return view('admin.clear-cache.index');
        }
    

    public function clearCaches()
    {
        // Clear view cache
        Artisan::call('view:clear');
        // Clear route cache
        Artisan::call('route:clear');
        // Clear config cache
        Artisan::call('config:clear');
        // Clear cache
        Artisan::call('cache:clear');

        // Optimize
        // Artisan::call('optimize');

        return back()->with('status', 'Caches cleared and optimization complete!');
    }


    public function maintenance()
    {
        // Fetch the current status of the maintenance mode
        $maintenanceMode = file_exists(storage_path('framework/down'));

        return view('admin.maintenance.index', compact('maintenanceMode'));
    }

    public function toggleMaintenance(Request $request)
    {
        if ($request->has('enable')) {
            Artisan::call('down', [
                '--secret' => env('MAINTENANCE_SECRET', \Illuminate\Support\Str::random(32)),
            ]);
        } else {
            // Disable maintenance mode
            Artisan::call('up');
        }

        return redirect()->route('admin.maintenance')->with('status', 'Maintenance mode updated.');
    }

    public function topArticles(Request $request)
    {
        $period = $request->input('period', '30');

        $posts = PostNews::withCount(['postViews as views_count' => function ($q) use ($period) {
            if ($period !== 'all') {
                $q->where('viewed_date', '>=', now()->subDays((int)$period)->toDateString());
            }
        }])
            ->where('status', 'published')
            ->orderByDesc('views_count')
            ->paginate(25);

        return view('admin.analytics.top-articles', compact('posts', 'period'));
    }
}
