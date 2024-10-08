<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InboxComposer
{
    public function compose(View $view)
    {
        $userId = Auth::id();

        // Get inbox messages for the dashboard
        $inboxMessages = Message::where('receiver_id', $userId)->orderBy('created_at', 'desc')->take(5)->get();
        
        // Get unread message count for the current user
        $messageCount = Message::where('receiver_id', $userId)->where('read_at', null)->count();
        
        // Get recent messages
        $recentMessages = Message::where('receiver_id', $userId)->orderBy('created_at', 'desc')->take(5)->get();
        
        // Get unread message count for each user
        $unreadMessages = Message::select('sender_id', DB::raw('count(*) as total'))
                                ->where('receiver_id', $userId)
                                ->where('read_at', null)
                                ->groupBy('sender_id')
                                ->pluck('total', 'sender_id');
        
        $view->with(compact('inboxMessages', 'messageCount', 'recentMessages', 'unreadMessages'));
    }
}


