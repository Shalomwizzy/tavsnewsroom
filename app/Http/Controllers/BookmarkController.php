<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\PostNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function toggle(PostNews $postNews)
    {
        $userId = Auth::id();

        $deleted = Bookmark::where('user_id', $userId)
            ->where('post_news_id', $postNews->id)
            ->delete();

        if ($deleted) {
            return response()->json(['bookmarked' => false]);
        }

        Bookmark::create(['user_id' => $userId, 'post_news_id' => $postNews->id]);

        return response()->json(['bookmarked' => true]);
    }

    public function index()
    {
        $bookmarks = Bookmark::with(['postNews.category'])
            ->where('user_id', Auth::id())
            ->latest('created_at')
            ->paginate(12);

        return view('bookmarks.index', compact('bookmarks'));
    }
}
