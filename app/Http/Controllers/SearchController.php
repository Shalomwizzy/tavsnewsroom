<?php

namespace App\Http\Controllers;

use App\Models\PostNews;
use App\Models\SocialFollows;
use App\Models\TrendingNews;
use App\Models\Tags; // Add this line to import the Tags model
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Sanitize and validate the search query if needed
        if (empty($query)) {
            return redirect()->back()->withErrors('Search query cannot be empty.');
        }

        // Fetch search results
        $searchResults = PostNews::where('headline', 'LIKE', "%$query%")
            ->orWhere('content', 'LIKE', "%$query%")
            ->get();

        // Fetch active social follows
        $socialFollows = SocialFollows::where('is_active', true)->get();

        // Fetch trending news with their post news
        $trendingNews = TrendingNews::with('postNews')->get();

        // Fetch selected tags
        $tags = Tags::with('category')->get();// Adjust this if you need specific tags

        return view('search-results', [
            'searchResults' => $searchResults,
            'query' => $query,
            'socialFollows' => $socialFollows,
            'trendingNews' => $trendingNews,
            'tags' => $tags, // Pass tags to the view
        ]);
    }
}


