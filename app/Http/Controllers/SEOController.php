<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PostNews;
use Illuminate\Support\Facades\Log;

class SEOController extends Controller
{
    // Display the latest 5 posts
    public function index()
    {
        $recentPosts = PostNews::whereIn('status', ['pending', 'published'])->latest()->take(5)->get();
        return view('admin.dashboard.dashboard-index', compact('recentPosts'));
    }

    // Analyze SEO for a specific post
    public function analyze($id)
    {
        Log::info("Starting SEO analysis for post ID: {$id}");

        $post = PostNews::findOrFail($id);

        $seo_score = $this->calculateSEOScore($post);
        $seo_suggestions = $this->generateSEOSuggestions($post);

        // Save the SEO data
        $post->seo_score = $seo_score;
        $post->seo_suggestions = json_encode($seo_suggestions);
        $post->save();

        Log::info("Completed SEO analysis for post ID: {$id}");

        return view('admin.seo.seo-analyze', compact('post', 'seo_score', 'seo_suggestions'));
    }

    // Show all posts with SEO scores
    public function showAll()
    {
        $allPosts = PostNews::paginate(10);
        return view('admin.seo.seo-index', compact('allPosts'));
    }

    // Calculate SEO score based on content, keywords, etc.
    protected function calculateSEOScore(PostNews $post)
    {
        $score = 0;
        $keywords = explode(',', $post->meta_keywords);

        // Check for keywords in the headline
        foreach ($keywords as $keyword) {
            if (stripos($post->headline, trim($keyword)) !== false) {
                $score += config('seo.scores.headline_keyword', 30); // configurable score
                break;
            }
        }

        // Check for keywords in the content
        foreach ($keywords as $keyword) {
            if (stripos($post->content, trim($keyword)) !== false) {
                $score += config('seo.scores.content_keyword', 50);
                break;
            }
        }

        // Check for alt text in images
        if (strpos($post->content, '<img') !== false && strpos($post->content, 'alt="') !== false) {
            $score += config('seo.scores.alt_text', 20);
        }

        // Check content length
        if (strlen($post->content) > config('seo.content_length_threshold', 300)) {
            $score += config('seo.scores.content_length', 30);
        }

        return $score;
    }

    // Generate suggestions for improving SEO
    protected function generateSEOSuggestions(PostNews $post)
    {
        $suggestions = [];
        $keywords = explode(',', $post->meta_keywords);

        // Check for keywords in the headline
        $headlineHasKeyword = false;
        foreach ($keywords as $keyword) {
            if (stripos($post->headline, trim($keyword)) !== false) {
                $headlineHasKeyword = true;
                break;
            }
        }
        if (!$headlineHasKeyword) {
            $suggestions[] = 'Consider adding keywords to the headline.';
        }

        // Check for keywords in the content
        $contentHasKeyword = false;
        foreach ($keywords as $keyword) {
            if (stripos($post->content, trim($keyword)) !== false) {
                $contentHasKeyword = true;
                break;
            }
        }
        if (!$contentHasKeyword) {
            $suggestions[] = 'Consider adding relevant keywords to the content.';
        }

        // Suggest adding alt text to images
        if (strpos($post->content, '<img') !== false && strpos($post->content, 'alt="') === false) {
            $suggestions[] = 'Add alt text to the images for better SEO.';
        }

        // Suggest increasing content length
        if (strlen($post->content) <= config('seo.content_length_threshold', 300)) {
            $suggestions[] = 'Increase the content length for better engagement.';
        }

        return $suggestions;
    }
}
