<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostNews;
use App\Models\PopularNews;

class PopularNewsController extends Controller
{
    public function index()
    {
        // $posts = PostNews::latest()->get();
        $posts = PostNews::where('status', 'published')->latest()->paginate(12);
        return view('admin.popular_news.index', compact('posts'));
    }

    public function update(Request $request)
    {
        // Validate the form submission
        $request->validate([
            'popular_news' => 'array|max:8', // Ensure popular_news is an array and maximum of 8 items
            'popular_news.*' => 'exists:post_news,id', // Ensure each item exists in post_news table
        ], [
            'popular_news.max' => 'Maximum of 8 popular news items allowed.',
            'popular_news.*.exists' => 'Invalid popular news selected',

        ]);

        $popularNewsIds = $request->input('popular_news', []);
            // Clear previous popular news
        PopularNews::truncate();
    
        // Save selected popular news
        foreach ($popularNewsIds as $postId) {
            PopularNews::create(['post_news_id' => $postId]);
        }
    
        // Redirect back or to another page
        return redirect()->route('admin.popular_news.index')->with('success', 'Popular News selection updated successfully.');
    }




}