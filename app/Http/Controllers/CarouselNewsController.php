<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostNews;
use App\Models\CarouselNews;

class CarouselNewsController extends Controller
{
    public function index()
    {
        $posts = PostNews::where('status', 'published')->latest()->paginate(20);
        return view('admin.carousel.index', compact('posts'));
    }



    public function update(Request $request)
    {
        // Validate the form submission
        $request->validate([
            'carousel_news' => 'array|max:6', // Ensure carousel_news is an array and maximum of 3 items
            'carousel_news.*' => 'exists:post_news,id', // Ensure each item exists in post_news table
        ], [
            'carousel_news.max' => 'Maximum of 6 carousel news items allowed.',
            'carousel_news.*.exists' => 'Invalid carousel news selected.',
        ]);
    
        // Retrieve the selected carousel news IDs from the form input
        $carouselNewsIds = $request->input('carousel_news', []);
    
        // Clear previous carousel news
        CarouselNews::truncate();
    
        // Save selected carousel news
        foreach ($carouselNewsIds as $postId) {
            CarouselNews::create(['post_news_id' => $postId]);
        }
    
        // Redirect back or to another page
        return redirect()->route('admin.carousel.index')->with('success', 'Carousel News selection updated successfully.');
    }

}