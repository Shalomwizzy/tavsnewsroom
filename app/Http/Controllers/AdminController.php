<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostNews;
use App\Models\ToDo;
use App\Models\Contact;
use App\Models\Message;
use App\Models\ShareInteraction;
use App\Mail\ReplyToContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
        $analyticsDataRaw = $this->analyticsService->getAnalyticsData('450095341', '7daysAgo', 'today');

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
                                ->orderBy('created_at', 'desc')
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
            'APP_NAME' => 'required|string|max:255',
            'APP_URL' => 'required|url',
            'DB_DATABASE' => 'required|string|max:255',
            'DB_USERNAME' => 'required|string|max:255',
            'DB_PASSWORD' => 'required|string|max:255',
            'MAIL_MAILER' => 'required|string|max:255',
            'MAIL_HOST' => 'required|string|max:255',
            'MAIL_PORT' => 'required|integer',
            'MAIL_USERNAME' => 'required|string|max:255',
            'MAIL_PASSWORD' => 'required|string|max:255',
            'MAIL_FROM_ADDRESS' => 'required|email|max:255',
            'MAIL_FROM_NAME' => 'required|string|max:255',
        ]);
    
        $envPath = base_path('.env');
        $envContent = File::get($envPath);
        
        $envContent = preg_replace('/APP_NAME=.*/', 'APP_NAME="' . $request->APP_NAME . '"', $envContent);
        $envContent = preg_replace('/APP_URL=.*/', 'APP_URL=' . $request->APP_URL, $envContent);
        $envContent = preg_replace('/DB_DATABASE=.*/', 'DB_DATABASE=' . $request->DB_DATABASE, $envContent);
        $envContent = preg_replace('/DB_USERNAME=.*/', 'DB_USERNAME=' . $request->DB_USERNAME, $envContent);
        $envContent = preg_replace('/DB_PASSWORD=.*/', 'DB_PASSWORD=' . $request->DB_PASSWORD, $envContent);
        $envContent = preg_replace('/MAIL_MAILER=.*/', 'MAIL_MAILER=' . $request->MAIL_MAILER, $envContent);
        $envContent = preg_replace('/MAIL_HOST=.*/', 'MAIL_HOST=' . $request->MAIL_HOST, $envContent);
        $envContent = preg_replace('/MAIL_PORT=.*/', 'MAIL_PORT=' . $request->MAIL_PORT, $envContent);
        $envContent = preg_replace('/MAIL_USERNAME=.*/', 'MAIL_USERNAME=' . $request->MAIL_USERNAME, $envContent);
        $envContent = preg_replace('/MAIL_PASSWORD=.*/', 'MAIL_PASSWORD=' . $request->MAIL_PASSWORD, $envContent);
        $envContent = preg_replace('/MAIL_FROM_ADDRESS=.*/', 'MAIL_FROM_ADDRESS=' . $request->MAIL_FROM_ADDRESS, $envContent);
        $envContent = preg_replace('/MAIL_FROM_NAME=.*/', 'MAIL_FROM_NAME="' . $request->MAIL_FROM_NAME . '"', $envContent);
    
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
            // Enable maintenance mode
            Artisan::call('down', [
                '--secret' => 'temitopemi' // Optional secret key for access
            ]);
        } else {
            // Disable maintenance mode
            Artisan::call('up');
        }

        return redirect()->route('admin.maintenance')->with('status', 'Maintenance mode updated.');
    }

}
