<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostNews;
use App\Models\TrendingNews;

class TrendingNewsController extends Controller
{



    public function index()
{
    $posts = PostNews::where('status', 'published')->latest()->paginate(12); // Paginate the posts, 10 per page
    $topSelectedNewsIds = TrendingNews::where('section', 'top')->pluck('post_news_id')->toArray();
    $bodySelectedNewsIds = TrendingNews::where('section', 'body')->pluck('post_news_id')->toArray();

    return view('admin.trending-news.index', compact('posts', 'topSelectedNewsIds', 'bodySelectedNewsIds'));
}

    
    public function update(Request $request)
    {
        $request->validate([
            'top_trending_news' => 'array|max:8',
            'top_trending_news.*' => 'exists:post_news,id',
            'body_trending_news' => 'array|max:8',
            'body_trending_news.*' => 'exists:post_news,id',
        ], [
            'top_trending_news.max' => 'Maximum of 8 top trending news items allowed.',
            'top_trending_news.*.exists' => 'Invalid top trending news selected.',
            'body_trending_news.max' => 'Maximum of 8 body trending news items allowed.',
            'body_trending_news.*.exists' => 'Invalid body trending news selected.',
        ]);
    
        $topTrendingNewsIds = $request->input('top_trending_news', []);
        $bodyTrendingNewsIds = $request->input('body_trending_news', []);
    
        TrendingNews::truncate();
    
        foreach ($topTrendingNewsIds as $postId) {
            TrendingNews::create(['post_news_id' => $postId, 'section' => 'top']);
        }
    
        foreach ($bodyTrendingNewsIds as $postId) {
            TrendingNews::create(['post_news_id' => $postId, 'section' => 'body']);
        }
    
        return redirect()->route('admin.trending-news.index')->with('success', 'Trending News selection updated successfully.');
    }
    //
}
