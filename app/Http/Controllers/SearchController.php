<?php

namespace App\Http\Controllers;

use App\Models\PostNews;
use App\Models\SocialFollows;
use App\Models\TrendingNews;
use App\Models\Tags;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function __construct(private GeminiService $gemini) {}

    public function search(Request $request)
    {
        $query = trim($request->input('query', ''));

        if (empty($query)) {
            return redirect()->back()->withErrors('Search query cannot be empty.');
        }

        // Expand the query with synonyms — cached 24h so repeat searches are instant
        $cacheKey     = 'search_expand_' . md5(strtolower($query));
        $expandedTerms = Cache::remember($cacheKey, now()->addHours(24), function () use ($query) {
            try {
                return $this->gemini->expandSearchQuery($query);
            } catch (\Throwable $e) {
                Log::warning('Search expansion failed, falling back to keyword', ['error' => $e->getMessage()]);
                return [$query];
            }
        });

        // Build search across headline, meta_description, meta_keywords, meta_title
        $searchResults = PostNews::where('status', 'published')
            ->where(function ($q) use ($expandedTerms) {
                foreach ($expandedTerms as $term) {
                    $term = addslashes($term);
                    $q->orWhere('headline',         'LIKE', "%{$term}%")
                      ->orWhere('meta_title',        'LIKE', "%{$term}%")
                      ->orWhere('meta_description',  'LIKE', "%{$term}%")
                      ->orWhere('meta_keywords',     'LIKE', "%{$term}%");
                }
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // Only show the expanded terms to the user if we actually got extras
        $extraTerms = count($expandedTerms) > 1
            ? array_slice($expandedTerms, 1)
            : [];

        $socialFollows = SocialFollows::where('is_active', true)->get();
        $trendingNews  = TrendingNews::with('postNews')->get();
        $tags          = Tags::with('category')->get();

        return view('search-results', [
            'searchResults' => $searchResults,
            'query'         => $query,
            'expandedTerms' => $extraTerms,
            'socialFollows' => $socialFollows,
            'trendingNews'  => $trendingNews,
            'tags'          => $tags,
        ]);
    }
}
