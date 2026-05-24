<?php

namespace App\Services;

use App\Models\AiBlogLog;
use App\Models\Category;
use App\Models\PostNews;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AIBlogService
{
    public function __construct(
        private GeminiService $gemini,
        private GroqService   $groq,
        private PexelsService $pexels,
    ) {}

    /**
     * Full pipeline: topic → draft → humanize → image → publish.
     * Returns the AiBlogLog record.
     */
    public function generate(?int $categoryId = null): AiBlogLog
    {
        $log = AiBlogLog::create(['status' => 'generating']);

        try {
            // 1. Gather context
            $categories       = Category::all(['id', 'name'])->toArray();
            $categoryNames    = array_column($categories, 'name');
            $existingHeadlines = PostNews::latest()->limit(40)->pluck('headline')->toArray();

            // Filter to requested category if specified
            if ($categoryId) {
                $categories    = array_filter($categories, fn($c) => $c['id'] === $categoryId);
                $categoryNames = array_column($categories, 'name');
            }

            // 2. Gemini picks the best trending topic
            $log->update(['status' => 'picking_topic']);
            $topic = $this->gemini->selectTrendingTopic($existingHeadlines, $categoryNames);

            if (empty($topic['topic'])) {
                throw new \RuntimeException('Gemini returned no topic.');
            }

            $log->update([
                'topic'    => $topic['topic'],
                'headline' => $topic['suggested_headline'] ?? '',
            ]);

            // 3. Groq writes the first draft
            $log->update(['status' => 'writing']);
            $article = $this->groq->writeArticle(
                $topic['topic'],
                $topic['suggested_headline'] ?? $topic['topic'],
                $topic['seo_keywords'] ?? [],
            );

            $article = $this->sanitizeDashes($article);

            // 4. Gemini checks humanness — loop until ≥ 90 or max attempts
            $minScore = config('ai.blog.min_humanness', 90);
            $maxLoops = config('ai.blog.max_rewrite_loops', 3);
            $score    = 0;
            $check    = [];

            for ($attempt = 1; $attempt <= $maxLoops; $attempt++) {
                $log->update(['status' => "humanizing_attempt_{$attempt}", 'attempts' => $attempt]);

                $check = $this->gemini->humanizeCheck($article);
                $score = $check['score'] ?? 0;

                if ($score >= $minScore) break;

                // Groq rewrites the flagged parts
                if ($attempt < $maxLoops) {
                    $article = $this->groq->humanizeArticle(
                        $article,
                        $check['ai_phrases'] ?? [],
                        $check['structural_issues'] ?? [],
                    );
                    $article = $this->sanitizeDashes($article);
                }
            }

            // 5. Gemini generates final meta
            $log->update(['status' => 'generating_meta']);
            $meta = $this->gemini->generateMeta(
                $article,
                $topic['suggested_headline'] ?? $topic['topic'],
                $topic['seo_keywords'] ?? [],
            );

            $headline = $this->sanitizeDashes($meta['headline'] ?? $topic['suggested_headline'] ?? $topic['topic']);

            // 6. Pexels fetches the image
            $log->update(['status' => 'fetching_image']);
            $imageQuery = $topic['image_search_query'] ?? $topic['topic'];
            $imagePath  = $this->pexels->fetchAndStore($imageQuery);

            if (!$imagePath) {
                // Fallback: try a more generic query
                $imagePath = $this->pexels->fetchAndStore(
                    implode(' ', array_slice($topic['seo_keywords'] ?? ['news'], 0, 2))
                );
            }

            // 7. Resolve category ID (case-insensitive, partial match fallback)
            $resolvedCategoryId = $categoryId;
            if (!$resolvedCategoryId) {
                $suggestedCat = $topic['category'] ?? null;
                $cat = Category::whereRaw('LOWER(name) = ?', [strtolower($suggestedCat ?? '')])->first()
                    ?? Category::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($suggestedCat ?? '') . '%'])->first()
                    ?? Category::first();
                $resolvedCategoryId = $cat?->id;
            }

            // 8. Save to post_news
            $log->update(['status' => 'saving']);

            $autoPublish = config('ai.blog.auto_publish', true);
            $wordCount   = str_word_count(strip_tags($article));

            $post = PostNews::create([
                'headline'         => $headline,
                'slug'             => $this->uniqueSlug($headline),
                'category_id'      => $resolvedCategoryId,
                'user_id'          => config('ai.blog.author_user_id', 1),
                'date'             => now()->toDateString(),
                'image_url'        => $imagePath ?? 'images/news-700x435-1.jpg',
                'content'          => nl2br(e($article)),
                'meta_title'       => $meta['meta_title'] ?? $headline,
                'meta_description' => $meta['meta_description'] ?? $topic['meta_description'] ?? '',
                'meta_keywords'    => $meta['tags'] ?? implode(', ', $topic['seo_keywords'] ?? []),
                'status'           => $autoPublish ? 'published' : 'pending',
                'reading_time'     => max(1, (int) ceil($wordCount / 200)),
                'ai_generated'     => true,
                'humanness_score'  => $score,
            ]);

            $log->update([
                'status'          => 'completed',
                'humanness_score' => $score,
                'word_count'      => $wordCount,
                'post_news_id'    => $post->id,
                'headline'        => $headline,
            ]);

            Log::info('AI blog post generated', [
                'post_id'         => $post->id,
                'headline'        => $headline,
                'humanness_score' => $score,
                'word_count'      => $wordCount,
            ]);

        } catch (\Throwable $e) {
            Log::error('AI blog generation failed', ['error' => $e->getMessage()]);
            $log->update(['status' => 'failed', 'error' => $e->getMessage()]);
        }

        return $log->fresh();
    }

    /** Replace dash-as-punctuation with a comma. Leaves compound-word hyphens intact. */
    private function sanitizeDashes(string $text): string
    {
        // " - " → ", "
        $text = preg_replace('/\s+-\s+/', ', ', $text);
        // em-dash / en-dash → ", "
        $text = preg_replace('/\s*[–—]\s*/', ', ', $text);
        return $text;
    }

    private function uniqueSlug(string $headline): string
    {
        $base = Str::slug($headline);
        $slug = $base;
        $i    = 1;
        while (PostNews::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}
