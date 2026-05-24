<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PostNews;
use App\Models\WebsiteSetting;
use App\Services\GroqService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AiChatController extends Controller
{
    public function __construct(private GroqService $groq) {}

    public function chat(Request $request): JsonResponse
    {
        $message = Str::limit(trim($request->input('message', '')), 600);

        if (empty($message)) {
            return response()->json(['reply' => 'Please type a question and I\'ll do my best to help!', 'articles' => []]);
        }

        // Site context
        $siteName   = WebsiteSetting::getValue('site_name', config('app.name'));
        $siteDesc   = WebsiteSetting::getValue('site_default_meta_description', '');
        $categories = Category::pluck('name')->join(', ');

        // Search relevant articles — extract meaningful words from the question
        $stopWords = ['what', 'when', 'where', 'which', 'who', 'how', 'why', 'the', 'and', 'for', 'are', 'was', 'did', 'does', 'about', 'with', 'this', 'that', 'have', 'tell', 'show', 'find', 'any', 'news', 'article', 'latest'];
        $searchWords = collect(preg_split('/\s+/', strtolower($message)))
            ->filter(fn($w) => strlen($w) > 3 && !in_array($w, $stopWords))
            ->unique()
            ->take(6)
            ->values();

        $articles = collect();
        if ($searchWords->isNotEmpty()) {
            $articles = PostNews::where('status', 'published')
                ->where(function ($q) use ($searchWords) {
                    foreach ($searchWords as $word) {
                        $q->orWhere('headline', 'LIKE', "%{$word}%")
                          ->orWhere('meta_keywords', 'LIKE', "%{$word}%")
                          ->orWhere('meta_description', 'LIKE', "%{$word}%");
                    }
                })
                ->latest()
                ->limit(5)
                ->get(['id', 'headline', 'content', 'slug', 'date', 'meta_description']);
        }

        // Recent articles always available as fallback context
        $recent = PostNews::where('status', 'published')
            ->latest()
            ->limit(8)
            ->get(['headline', 'slug', 'date']);

        // Build context for Groq
        $articlesContext = '';
        if ($articles->isNotEmpty()) {
            $articlesContext = "RELEVANT ARTICLES FOUND FOR THIS QUESTION:\n\n";
            foreach ($articles as $art) {
                $date    = Carbon::parse($art->date);
                $url     = url($date->format('Y/m/d') . '/' . $art->slug);
                $summary = $art->meta_description
                    ?: Str::limit(strip_tags(html_entity_decode($art->content)), 250);
                $articlesContext .= "- Headline: {$art->headline}\n";
                $articlesContext .= "  Published: {$art->date} | URL: {$url}\n";
                $articlesContext .= "  Summary: {$summary}\n\n";
            }
        }

        $recentContext = "MOST RECENT ARTICLES ON THE SITE:\n";
        foreach ($recent as $r) {
            $recentContext .= "- {$r->headline} ({$r->date})\n";
        }

        $siteContext = <<<CTX
Site name: {$siteName}
Description: {$siteDesc}
Topics covered: {$categories}

{$recentContext}
CTX;

        try {
            $reply = $this->groq->chatbotReply($siteName, $siteContext, $articlesContext, $message);
        } catch (\Throwable $e) {
            $reply = "I'm having a moment — please try again in a few seconds!";
        }

        // Article links to show as clickable chips in the UI
        $links = $articles->take(3)->map(function ($a) {
            $date = Carbon::parse($a->date);
            return [
                'headline' => Str::limit($a->headline, 70),
                'url'      => '/' . $date->format('Y/m/d') . '/' . $a->slug,
            ];
        })->values();

        return response()->json(['reply' => $reply, 'articles' => $links]);
    }
}
