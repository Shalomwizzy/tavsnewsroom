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
     * Full pipeline: topic → draft → word-count check → humanize → image → meta → publish.
     * Returns the AiBlogLog record.
     */
    public function generate(?int $categoryId = null): AiBlogLog
    {
        $log = AiBlogLog::create(['status' => 'generating']);

        try {
            // 1. Gather context
            $categories        = Category::all(['id', 'name'])->toArray();
            $categoryNames     = array_column($categories, 'name');
            $existingHeadlines = PostNews::latest()->limit(60)->pluck('headline')->toArray();

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

            // 3. Groq writes the first draft — retry until word count is met
            $log->update(['status' => 'writing']);
            $minWords    = config('ai.blog.min_words', 700);
            $maxWriteAttempts = 3;
            $article     = '';

            for ($w = 1; $w <= $maxWriteAttempts; $w++) {
                $article   = $this->groq->writeArticle(
                    $topic['topic'],
                    $topic['suggested_headline'] ?? $topic['topic'],
                    $topic['seo_keywords'] ?? [],
                );
                $article   = $this->sanitizeDashes($article);
                $wordCount = str_word_count(strip_tags($article));

                if ($wordCount >= $minWords) break;

                Log::warning("AI article too short on attempt {$w}", ['words' => $wordCount, 'min' => $minWords]);

                if ($w < $maxWriteAttempts) {
                    // Give Groq a stronger nudge on retry
                    $topic['topic'] .= " — write at least {$minWords} words, this draft was only {$wordCount} words.";
                }
            }

            // 4. Gemini humanness check — loop until ≥ 90 or max attempts
            $minScore = config('ai.blog.min_humanness', 90);
            $maxLoops = config('ai.blog.max_rewrite_loops', 3);
            $score    = 0;
            $check    = [];

            for ($attempt = 1; $attempt <= $maxLoops; $attempt++) {
                $log->update(['status' => "humanizing_attempt_{$attempt}", 'attempts' => $attempt]);

                $check = $this->gemini->humanizeCheck($article);
                $score = $check['score'] ?? 0;

                if ($score >= $minScore) break;

                Log::info("Humanness {$score}% on attempt {$attempt}, rewriting...");

                if ($attempt < $maxLoops) {
                    $article = $this->groq->humanizeArticle(
                        $article,
                        $check['ai_phrases'] ?? [],
                        $check['structural_issues'] ?? [],
                    );
                    $article = $this->sanitizeDashes($article);

                    // Re-check word count after rewrite
                    $wordCount = str_word_count(strip_tags($article));
                }
            }

            // 5. Gemini generates final SEO meta
            $log->update(['status' => 'generating_meta']);
            $meta = $this->gemini->generateMeta(
                $article,
                $topic['suggested_headline'] ?? $topic['topic'],
                $topic['seo_keywords'] ?? [],
            );

            $headline = $this->sanitizeDashes($meta['headline'] ?? $topic['suggested_headline'] ?? $topic['topic']);

            // 6. Get a precise Pexels image query for this specific article
            $log->update(['status' => 'fetching_image']);

            $imageQuery = $this->gemini->generateImageQuery(
                $headline,
                $topic['topic'],
                $topic['category'] ?? '',
            );

            // Fall back to topic-embedded query or keywords
            if (empty(trim($imageQuery))) {
                $imageQuery = $topic['image_search_query'] ?? implode(' ', array_slice($topic['seo_keywords'] ?? [], 0, 3));
            }

            $imagePath = $this->pexels->fetchAndStore($imageQuery);

            if (!$imagePath) {
                // Last resort: try with just the first two keywords
                $fallbackQuery = implode(' ', array_slice($topic['seo_keywords'] ?? ['news'], 0, 2));
                $imagePath     = $this->pexels->fetchAndStore($fallbackQuery);
            }

            // 7. Resolve category (case-insensitive, partial match, then first)
            $resolvedCategoryId = $categoryId;
            if (!$resolvedCategoryId) {
                $suggestedCat = $topic['category'] ?? null;
                $cat = Category::whereRaw('LOWER(name) = ?', [strtolower($suggestedCat ?? '')])->first()
                    ?? Category::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($suggestedCat ?? '') . '%'])->first()
                    ?? Category::first();
                $resolvedCategoryId = $cat?->id;
            }

            // 8. Publish to post_news
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

            Log::info('AI blog post published', [
                'post_id'         => $post->id,
                'headline'        => $headline,
                'humanness_score' => $score,
                'word_count'      => $wordCount,
                'image_query'     => $imageQuery,
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
        $text = preg_replace('/\s+-\s+/', ', ', $text);
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
