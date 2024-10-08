<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller {
   
    public function index(Request $request) {
        $receiver_id = $request->receiver_id;
        $messages = collect();
        
        if ($receiver_id) {
            $messages = Message::where(function($query) use ($receiver_id) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $receiver_id);
            })->orWhere(function($query) use ($receiver_id) {
                $query->where('receiver_id', Auth::id())
                      ->where('sender_id', $receiver_id);
            })->orderBy('created_at', 'asc')->get();
    
            // Mark messages as read
            Message::where('receiver_id', Auth::id())
                   ->where('sender_id', $receiver_id)
                   ->where('read_at', null)
                   ->update(['read_at' => now()]);
        }
    
        $users = User::where('id', '!=', Auth::id())->get();
    
        // Get unread message count for the current user
        $messageCount = Message::where('receiver_id', Auth::id())->where('read_at', null)->count();
    
        // Get recent messages
        $recentMessages = Message::where('receiver_id', Auth::id())->orderBy('created_at', 'desc')->take(5)->get();
    
        // Get unread message count for each user
        $unreadMessages = Message::select('sender_id', DB::raw('count(*) as total'))
                                ->where('receiver_id', Auth::id())
                                ->where('read_at', null)
                                ->groupBy('sender_id')
                                ->pluck('total', 'sender_id');

                                     // Get inbox messages for the dashboard
        $inboxMessages = Message::where('receiver_id', Auth::id())->orderBy('created_at', 'desc')->take(5)->get();
    
        return view('admin.messages.index', compact('messages', 'users', 'receiver_id', 'messageCount', 'recentMessages', 'unreadMessages','inboxMessages'));
    }
    
    


    public function store(Request $request) {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return redirect()->route('messages.index', ['receiver_id' => $request->receiver_id])
                         ->with('success', 'Message sent successfully.');
    }
}