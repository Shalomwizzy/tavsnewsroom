<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\PostNews;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, PostNews $postNews)
    {
        if (!WebsiteSetting::getValue('comments_enabled', '1')) {
            return back()->with('error', 'Comments are disabled.');
        }

        $rules = [
            'body' => 'required|string|max:2000',
        ];

        if (!Auth::check()) {
            $rules['name']  = 'required|string|max:100';
            $rules['email'] = 'required|email|max:255';
        }

        $request->validate($rules);

        Comment::create([
            'post_news_id' => $postNews->id,
            'user_id'      => Auth::id(),
            'name'         => Auth::check() ? Auth::user()->username : $request->name,
            'email'        => Auth::check() ? Auth::user()->email    : $request->email,
            'body'         => $request->body,
            'is_approved'  => false,
        ]);

        return back()->with('comment_success', 'Your comment has been submitted and is awaiting moderation.');
    }

    public function index()
    {
        $this->authorizeAdmin();

        $pending  = Comment::with('postNews')->pending()->latest()->get();
        $approved = Comment::with('postNews')->approved()->latest()->paginate(20);

        return view('admin.comments.index', compact('pending', 'approved'));
    }

    public function approve(Comment $comment)
    {
        $this->authorizeAdmin();

        $comment->update(['is_approved' => true]);

        return back()->with('success', 'Comment approved.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorizeAdmin();

        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }

    private function authorizeAdmin()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403);
        }
    }
}
