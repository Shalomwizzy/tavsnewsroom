<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PostNews;

class SEOController extends Controller
{
    

    public function index()
{
    // Get the latest 5 posts that are either pending or published
    $recentPosts = PostNews::whereIn('status', ['pending', 'published'])->latest()->take(5)->get();
    return view('admin.dashboard.dashboard-index', compact('recentPosts'));
}

    public function analyze($id)
    {
        logger("Starting SEO analysis for post ID: {$id}");
    
        $post = PostNews::findOrFail($id);
    
        // Perform your SEO analysis logic here
        $seo_score = $this->calculateSEOScore($post);
        $seo_suggestions = $this->generateSEOSuggestions($post);
    
        // Update post with new SEO data
        $post->seo_score = $seo_score;
    
        // Check if seo_suggestions is a string and decode if necessary
        if (is_string($seo_suggestions)) {
            $seo_suggestions = json_decode($seo_suggestions, true) ?? [$seo_suggestions];
        }
    
        $post->seo_suggestions = json_encode($seo_suggestions);
        $post->save();
    
        logger("Completed SEO analysis for post ID: {$id}");
    
        // Return the view with the post and SEO data
        return view('admin.seo.seo-analyze', compact('post', 'seo_score', 'seo_suggestions'));
    }
    



    // Display all posts with SEO scores and suggestions
    public function showAll()
    {
        $allPosts = PostNews::paginate(10); // Paginate with 10 posts per page
        return view('admin.seo.seo-index', compact('allPosts'));
    }
    

    // Example method to calculate SEO score
    protected function calculateSEOScore(PostNews $post)
    {
        $score = 0;
        $keywords = explode(',', $post->meta_keywords); // Get the actual keywords from meta_keywords
    
        // Check for keywords in the headline
        foreach ($keywords as $keyword) {
            if (stripos($post->headline, trim($keyword)) !== false) {
                $score += 30; // Adjust the score value as needed
                break;
            }
        }
    
        // Check for keywords in the content
        foreach ($keywords as $keyword) {
            if (stripos($post->content, trim($keyword)) !== false) {
                $score += 50; // Adjust the score value as needed
                break;
            }
        }
    
        // Check for alt text in images (simplified example)
        if (strpos($post->content, '<img') !== false && strpos($post->content, 'alt="') !== false) {
            $score += 20; // Adjust the score value as needed
        }
    
        // Check for content length
        if (strlen($post->content) > 300) {
            $score += 30; // Adjust the score value as needed
        }
    
        return $score;
    }
    

    // Example method to generate SEO suggestions
    protected function generateSEOSuggestions(PostNews $post)
    {
        $suggestions = [];
        $keywords = ['keyword1', 'keyword2']; // Replace with actual keywords you want to check for

        // Suggest adding keywords to the headline
        $headlineHasKeyword = false;
        foreach ($keywords as $keyword) {
            if (stripos($post->headline, $keyword) !== false) {
                $headlineHasKeyword = true;
                break;
            }
        }
        if (!$headlineHasKeyword) {
            $suggestions[] = 'Add keywords to the headline.';
        }

        // Suggest adding keywords to the content
        $contentHasKeyword = false;
        foreach ($keywords as $keyword) {
            if (stripos($post->content, $keyword) !== false) {
                $contentHasKeyword = true;
                break;
            }
        }
        if (!$contentHasKeyword) {
            $suggestions[] = 'Add keywords to the content.';
        }

        // Suggest adding alt text to images
        if (strpos($post->content, '<img') !== false && strpos($post->content, 'alt="') === false) {
            $suggestions[] = 'Add alt text to images.';
        }

        // Suggest increasing content length
        if (strlen($post->content) <= 300) {
            $suggestions[] = 'Increase content length to provide more value to readers.';
        }

        return implode(' ', $suggestions);
    }
}
