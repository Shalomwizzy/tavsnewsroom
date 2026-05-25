<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GeminiService
{
    private string $apiKey;
    private string $model;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey  = config('ai.gemini.api_key');
        $this->model   = config('ai.gemini.model');
        $this->baseUrl = config('ai.gemini.base_url');
    }

    /**
     * Research and select the single best trending + SEO topic to write about.
     */
    public function selectTrendingTopic(array $existingHeadlines, array $categoryNames): array
    {
        $headlines = implode("\n", array_slice($existingHeadlines, 0, 60));
        $cats      = implode(', ', $categoryNames);
        $todayDate = now()->format('F j, Y');
        $todayDay  = now()->format('l');

        $prompt = <<<PROMPT
Today is {$todayDay}, {$todayDate}. You are the chief editor AND head of SEO at a fast-growing global news publication called Tavs Newsroom. Your job is to publish the single most valuable article RIGHT NOW, one that will rank on Google page 1 within days and drive massive traffic.

WHAT THIS SITE COVERS — everything and anything:
Breaking world news, politics, science, technology, AI, health and medicine, sports, entertainment, celebrity gossip and drama, animals and wildlife, food and cooking, travel and tourism, finance, crypto, stock markets, economy, environment, climate, space exploration, human interest, lifestyle, parenting, relationships, education, crime, legal cases, viral social media moments, fashion, music, film, TV, gaming, religion, culture, history, and any other topic millions of people are actively searching for.

Available site categories: {$cats}

DO NOT duplicate or closely repeat any of these already-published topics:
{$headlines}

YOUR RESEARCH PROCESS — think through each step carefully:

STEP 1 — WHAT IS TRENDING RIGHT NOW TODAY?
Think hard about what is happening in the world THIS WEEK. What events broke in the last 24-72 hours? What are people searching on Google right now? Consider: major political events, celebrity news, sports results, scientific discoveries, viral stories, product launches, court cases, natural disasters, economic news, health alerts, animal stories gone viral, film/TV releases, music drops, social media controversies. Be specific — not "sports news" but "who just won, lost, or got signed."

STEP 2 — SEO KEYWORD OPPORTUNITY
Which trending topic has a keyword with HIGH search volume AND low-to-medium competition? Think about:
- Question-based searches (how, why, what happened, who is, when will)
- Comparison searches (X vs Y, best X for Y)
- News-intent searches (breaking, latest, update, 2024, 2025)
- Long-tail variants that a small site can actually rank for
- Keywords where existing top results are weak or outdated

STEP 3 — HEADLINE THAT DEMANDS A CLICK
What headline creates an irresistible urge to click? Think: urgency, curiosity gap, surprising fact, emotional hook, or a bold claim the article can deliver on. No clickbait that doesn't pay off — genuine value.

STEP 4 — UNIQUENESS CHECK
Is this fresh? Not in the published list above? Does this angle exist or is there a gap this article can fill?

STEP 5 — FINAL SELECTION
Pick the ONE topic that scores highest across trending relevance, SEO opportunity, click appeal, and uniqueness. Be bold. Don't pick safe, boring topics. Pick what people are ACTUALLY searching for right now.

CRITICAL IMAGE INSTRUCTION: The image_search_query you provide MUST describe a real, specific photograph that directly illustrates THIS exact article. If the article is about a specific animal, name that animal. If it's about a specific place, name that place. If it's about a specific person or event, describe what a photo of that would look like. NEVER give a generic query like "news", "people talking", "business meeting", or "technology". Give something specific enough that the first Pexels result will be unmistakably relevant.

Respond with valid JSON only. No markdown, no explanation, just raw JSON:
{"topic":"detailed description of exactly what the article should cover including specific names, dates, and context","suggested_headline":"compelling SEO headline max 12 words no dashes","category":"exact category name from the list","seo_keywords":["primary keyword","secondary keyword","long-tail keyword 1","long-tail keyword 2","semantic keyword"],"meta_description":"155 character meta description includes primary keyword ends with action phrase","image_search_query":"specific 4-6 word Pexels photo query describing an actual photograph that directly illustrates this exact article topic","article_angle":"one sentence on the unique angle and what the reader learns"}
PROMPT;

        $data = $this->call($prompt, 0.85);
        return $this->parseJson($data);
    }

    /**
     * Expert humanness check — returns score, flagged phrases, and specific fixes.
     */
    public function humanizeCheck(string $article): array
    {
        $prompt = <<<PROMPT
You are the world's leading expert at detecting AI-generated text. You have analysed thousands of AI articles and you know every single pattern cold.

Read this article and score it from 0 to 100 on how authentically human it sounds:
- 90-100: Could be published in a major newspaper, completely undetectable as AI
- 70-89: Mostly human but has some telltale AI patterns
- 50-69: Clearly AI-generated to a trained eye
- 0-49: Obviously AI, mechanical and hollow

AI patterns to hunt for:
- Sentences starting with: "It is", "It's important to", "It's worth noting", "In today's world", "In today's fast-paced", "One might argue"
- Transition crutches: "Furthermore", "Moreover", "Additionally", "In conclusion", "Overall", "Needless to say", "To summarize"
- Hollow generalisations with no specific detail
- Repetitive sentence structure — every sentence the same length and rhythm
- Missing personality, voice, opinion, or specific concrete detail
- Overly balanced "on one hand / on the other hand" both-sidesing
- AI clichés: "delve into", "in the realm of", "it's crucial to", "navigate", "landscape", "leverage", "unlock", "underscores", "it is important to note", "shed light on"
- Any dash used as punctuation between clauses (em dash, en dash, or " - ")
- Passive voice overuse
- Endings that summarise instead of closing with impact

Article to analyse:
{$article}

Respond with valid JSON only, no markdown:
{"score":87,"ai_phrases":["exact phrase 1 from the text","exact phrase 2","exact phrase 3"],"structural_issues":["specific structural problem 1","specific structural problem 2"],"verdict":"one honest sentence about the overall quality and the single most important thing to fix"}
PROMPT;

        $data   = $this->call($prompt, 0.1);
        $result = $this->parseJson($data);

        return [
            'score'             => (int) ($result['score'] ?? 0),
            'ai_phrases'        => $result['ai_phrases'] ?? [],
            'structural_issues' => $result['structural_issues'] ?? [],
            'verdict'           => $result['verdict'] ?? '',
        ];
    }

    /**
     * Generate all SEO metadata from the final article.
     */
    public function generateMeta(string $article, string $suggestedHeadline, array $keywords): array
    {
        $kw    = implode(', ', $keywords);
        $year  = now()->format('Y');
        $month = now()->format('F');

        $prompt = <<<PROMPT
You are a world-class SEO specialist with a track record of ranking content on Google page 1 within days. Generate optimised metadata for this article that will maximise click-through rate and search ranking.

Primary keywords: {$kw}
Working headline: {$suggestedHeadline}
Current month/year: {$month} {$year}

SEO RULES:
Headline:
- 8-12 words
- Must include the primary keyword naturally
- Must create curiosity, urgency, or strong emotional pull
- ZERO dashes (em dash, en dash, or hyphen between clauses)
- No colon if possible — rewrite to avoid it
- If using a number (5 Reasons, 7 Ways), put it at the front

Meta title:
- Max 60 characters including spaces
- Primary keyword as close to the front as possible
- Include year ({$year}) if it adds relevance
- No keyword stuffing — must read naturally

Meta description:
- Exactly 150-160 characters — count precisely
- Tell the reader exactly what they will get from clicking
- Include the primary keyword naturally
- End with an action phrase (Find out, Learn why, See how, Read more, Discover)
- Must make someone choose this result over the 9 others on the page

Tags:
- 5-7 tags, comma-separated
- Mix: 1 broad topic tag, 2-3 specific subject tags, 1-2 long-tail tags
- These become internal taxonomy — make them genuinely useful

Article:
{$article}

Respond with valid JSON only, no markdown:
{"headline":"final optimised headline","meta_title":"SEO meta title max 60 chars","meta_description":"exactly 150-160 char description","tags":"tag1, tag2, tag3, tag4, tag5"}
PROMPT;

        $data = $this->call($prompt, 0.2);
        return $this->parseJson($data);
    }

    /**
     * Generate a 2-3 sentence TL;DR summary for an article.
     */
    public function generateSummary(string $headline, string $content): string
    {
        $excerpt = Str::limit(strip_tags(html_entity_decode($content)), 2000);

        $prompt = <<<PROMPT
Write a 2-3 sentence TL;DR summary of this news article. It should tell a reader exactly what happened and why it matters, so they can decide in seconds whether to read the full piece.

Rules:
- Maximum 3 sentences, minimum 2
- Plain prose only — no bullet points, no bold text, no dashes as punctuation
- Active voice, present or past tense as appropriate
- Do not start with "This article", "In this piece", or "The author"
- Do not use phrases like "TL;DR:", "Summary:", "In summary"
- Just write the summary directly, as if a sharp editor distilled the story in one breath

Article headline: {$headline}
Article content: {$excerpt}

Return only the summary text. Nothing else.
PROMPT;

        $result = trim($this->call($prompt, 0.3));
        // Strip any accidental leading labels
        $result = preg_replace('/^(tl;?dr:?|summary:?)\s*/i', '', $result);
        return $result;
    }

    /**
     * Suggest category, tags, meta title and meta description for a given article.
     */
    public function suggestTagsAndCategory(string $headline, string $content, array $categories): array
    {
        $cats        = implode(', ', array_column($categories, 'name'));
        $catsJson    = json_encode(array_map(fn($c) => ['id' => $c['id'], 'name' => $c['name']], $categories));
        $excerpt     = Str::limit(strip_tags(html_entity_decode($content)), 800);

        $prompt = <<<PROMPT
You are an expert news editor and SEO specialist. Analyse this article and suggest the best metadata so it ranks on Google and gets clicked.

Available categories (pick exactly one): {$cats}
Category list with IDs: {$catsJson}

Article headline: {$headline}
Article content excerpt: {$excerpt}

Tasks:
1. Pick the single most appropriate category from the list above
2. Generate 5-7 SEO keywords (comma-separated) — mix primary, secondary, and long-tail
3. Write an optimised meta title (max 60 characters, include primary keyword)
4. Write a meta description of exactly 150-160 characters — tells what the reader gets, ends with an action phrase

Respond with valid JSON only, no markdown:
{"category_id":3,"category_name":"Technology","meta_keywords":"keyword1, keyword2, keyword3, long tail keyword, semantic keyword","meta_title":"SEO title under 60 chars","meta_description":"exactly 150-160 character description ending with action phrase"}
PROMPT;

        $data   = $this->call($prompt, 0.2);
        $result = $this->parseJson($data);

        // Validate category_id is one we actually have
        $validIds = array_column($categories, 'id');
        if (!in_array($result['category_id'] ?? null, $validIds)) {
            $matched = collect($categories)->first(fn($c) => stripos($c['name'], $result['category_name'] ?? '') !== false);
            $result['category_id'] = $matched['id'] ?? $validIds[0];
        }

        return $result;
    }

    /**
     * Expand a search query with synonyms and related terms for semantic search.
     */
    public function expandSearchQuery(string $query): array
    {
        $prompt = <<<PROMPT
A reader on a news website searched for: "{$query}"

Generate 6-8 closely related search terms, synonyms, and alternative phrasings that would help find relevant news articles about this topic. Think about:
- Synonyms (football → soccer)
- Official names vs common names (heart attack → cardiac arrest, myocardial infarction)
- Abbreviations and full forms (AI → artificial intelligence, UK → United Kingdom)
- Related proper nouns (NBA → basketball, Lakers, LeBron)
- Alternative spellings or regional differences
- Related concepts a news article might use

Rules:
- Include the original query as the first item
- Return ONLY terms that are genuinely related to the original query
- Each term should be 1-4 words maximum
- Do not include generic words like "news", "article", "story"

Respond with valid JSON only, no markdown:
{"terms":["original query","synonym 1","related term 2","related term 3","related term 4","related term 5"]}
PROMPT;

        $data   = $this->call($prompt, 0.2);
        $result = $this->parseJson($data);
        $terms  = $result['terms'] ?? [];

        // Always include the original, deduplicate, limit to 8
        array_unshift($terms, $query);
        return array_unique(array_slice($terms, 0, 8));
    }

    /**
     * Generate a hyper-specific Pexels image search query based on article content.
     */
    public function generateImageQuery(string $headline, string $topic, string $category): string
    {
        $prompt = <<<PROMPT
You need to find a real photograph on Pexels that PERFECTLY and SPECIFICALLY illustrates this exact news article. The image must be unmistakably relevant — a reader should look at the photo and immediately know what the article is about.

Article headline: {$headline}
Topic: {$topic}
Category: {$category}

RULES FOR THE SEARCH QUERY:
1. Describe a SPECIFIC REAL PHOTOGRAPH — something that can actually be photographed
2. 4-6 words maximum
3. Be as specific as possible to this exact topic:
   - Article about lions attacking prey? → "lion hunting buffalo Africa"
   - Article about Elon Musk Tesla? → "Tesla electric car factory"
   - Article about coral reef bleaching? → "bleached coral reef underwater"
   - Article about NBA basketball game? → "basketball player dunking court"
   - Article about inflation grocery prices? → "shopping cart supermarket groceries"
   - Article about wildfires California? → "wildfire burning forest smoke"
   - Article about Taylor Swift concert? → "concert stadium crowd performance"
4. NEVER use: "news", "article", "concept", "idea", "background", "people", "business", "meeting", "technology" (alone)
5. If about a specific animal — name the animal
6. If about a specific place — name the place
7. If about a specific food — name the food
8. If about a specific sport — name the sport and action

Respond with ONLY the search query — no quotes, no explanation, nothing else.
PROMPT;

        $result = trim($this->call($prompt, 0.3));
        $result = trim($result, '"\'');
        return explode("\n", $result)[0];
    }

    // ── Private helpers ───────────────────────────────────────────────

    private function call(string $prompt, float $temperature = 0.7): string
    {
        $url     = "{$this->baseUrl}/{$this->model}:generateContent?key={$this->apiKey}";
        $payload = [
            'contents' => [
                ['parts' => [['text' => $prompt]]],
            ],
            'generationConfig' => [
                'temperature' => $temperature,
                'topP'        => 0.95,
            ],
        ];

        $maxAttempts = 4;
        $lastError   = null;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            $response = Http::timeout(120)->post($url, $payload);

            if ($response->successful()) {
                return $response->json('candidates.0.content.parts.0.text', '');
            }

            $status = $response->status();
            $msg    = $response->json('error.message') ?? $response->body();

            Log::warning("Gemini attempt {$attempt} failed", ['status' => $status, 'message' => $msg]);
            $lastError = "Gemini {$status}: {$msg}";

            if ($status === 429 && $attempt < $maxAttempts) {
                // Parse "please retry in X.Xs" from the error message
                $wait = 65;
                if (preg_match('/retry in (\d+(?:\.\d+)?)s/i', $msg, $m)) {
                    $wait = (int) ceil((float) $m[1]) + 5;
                }
                Log::info("Gemini rate-limited, waiting {$wait}s before retry {$attempt}");
                sleep($wait);
                continue;
            }

            break;
        }

        throw new \RuntimeException($lastError ?? 'Gemini API error');
    }

    private function parseJson(string $raw): array
    {
        $cleaned = preg_replace('/^```(?:json)?\s*/i', '', trim($raw));
        $cleaned = preg_replace('/\s*```$/', '', $cleaned);
        $decoded = json_decode(trim($cleaned), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::warning('Gemini JSON parse failed', ['raw' => substr($raw, 0, 500)]);
            return [];
        }

        return $decoded;
    }
}
