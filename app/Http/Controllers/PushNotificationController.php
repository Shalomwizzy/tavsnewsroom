<?php

namespace App\Http\Controllers;

use App\Jobs\SendPushNotificationJob;
use App\Models\PostNews;
use App\Models\PushNotification;
use App\Services\OneSignalService;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    public function index(OneSignalService $onesignal)
    {
        $notifications = PushNotification::with('sender')
            ->latest()
            ->paginate(20);

        $recentPosts = PostNews::where('status', 'published')
            ->latest()
            ->limit(10)
            ->get(['id', 'headline', 'slug', 'date', 'image_url']);

        return view('admin.push-notifications.index', [
            'notifications'   => $notifications,
            'recentPosts'     => $recentPosts,
            'isConfigured'    => $onesignal->isConfigured(),
        ]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string|max:500',
            'url'     => 'nullable|url|max:500',
        ]);

        SendPushNotificationJob::dispatch(
            $request->title,
            $request->message,
            $request->url ?? '',
            '',
            'manual',
            auth()->id(),
        );

        return back()->with('success', 'Push notification queued and sending to all subscribers!');
    }

    public function sendPost(Request $request)
    {
        $request->validate(['post_id' => 'required|exists:post_news,id']);

        $post = PostNews::findOrFail($request->post_id);
        $date = \Carbon\Carbon::parse($post->date);
        $url  = url($date->format('Y/m/d') . '/' . $post->slug);

        SendPushNotificationJob::dispatch(
            $post->headline,
            $post->ai_summary ?: ($post->meta_description ?: 'Read the full story now.'),
            $url,
            $post->image_url ? asset($post->image_url) : '',
            'manual',
            auth()->id(),
        );

        return back()->with('success', "Push notification for \"{$post->headline}\" is sending!");
    }
}
