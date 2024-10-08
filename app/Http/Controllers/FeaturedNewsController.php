<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostNews;
use App\Models\FeaturedNews;

class FeaturedNewsController extends Controller
{
    public function index()
    {
        $posts = PostNews::where('status', 'published')->latest()->paginate(10);
        return view('admin.featured_news.index', compact('posts'));
    }

  

    public function update(Request $request)
    {
        // Validate the form submission
        $request->validate([
            'featured_news' => 'array|max:8', // Ensure featured_news is an array and maximum of 3 items
            'featured_news.*' => 'exists:post_news,id', // Ensure each item exists in post_news table
        ], [
            'featured_news.max' => 'Maximum of 8 featured news items allowed.',
            'featured_news.*.exists' => 'Invalid featured news selected.',
        ]);
    
        // Retrieve the selected featured news IDs from the form input
        $featuredNewsIds = $request->input('featured_news', []);
    
        // Clear previous featured news
        FeaturedNews::truncate();
    
        // Save selected featured news
        foreach ($featuredNewsIds as $postId) {
            FeaturedNews::create(['post_news_id' => $postId]);
        }
    
        // Redirect back or to another page
        return redirect()->route('admin.featured_news.index')->with('success', 'Featured News selection updated successfully.');
    }


   
}