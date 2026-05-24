<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostNews;
use App\Models\LatestNews;

class LatestNewsController extends Controller
{
    public function index()
    {
        $posts = PostNews::where('status', 'published')->latest()->paginate(12);
        return view('admin.latest_news.index', compact('posts'));
    }

    public function update(Request $request)
    {
        // Validate the form submission
        $request->validate([
            'latest_news' => 'array|max:8', // Ensure latest_news is an array and maximum of 8 items
            'latest_news.*' => 'exists:post_news,id', // Ensure each item exists in post_news table
        ], [
            'latest_news.max' => 'Maximum of 8 latest news items allowed.',
            'latest_news.*.exists' => 'Invalid latest news selected.',
        ]);
    
        // Retrieve the selected latest news IDs from the form input
        $latestNewsIds = $request->input('latest_news', []);
    
        // Clear previous latest news
        LatestNews::truncate();
    
        // Save selected latest news
        foreach ($latestNewsIds as $postId) {
            LatestNews::create(['post_news_id' => $postId]);
        }
    
        // Redirect back or to another page
        return redirect()->route('admin.latest_news.index')->with('success', 'Latest News selection updated successfully.');
    }
}
