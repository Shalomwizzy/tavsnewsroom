<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostNews;
use App\Models\TopNews;

class TopNewsController extends Controller
{

    public function topNews()
    {
        // $posts = PostNews::latest()->get();
        $posts = PostNews::latest()->paginate(8);
        return view('admin.top_news.top-news', compact('posts'));
    }


    
    public function updateTopNews(Request $request)
    {
        $request->validate([
            'top_news' => 'array|max:8',
        ]);

        // Delete existing top news entries
        TopNews::truncate();

        // Create new top news entries based on the form submission
        foreach ($request->input('top_news', []) as $postId) {
            TopNews::create(['post_news_id' => $postId]);
        }

        return redirect()->route('admin.top-news')->with('success', 'Top News selection updated successfully.');
    }



}
