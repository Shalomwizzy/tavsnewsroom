<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqService
{
    private string $apiKey;
    private string $model;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey  = config('ai.groq.api_key');
        $this->model   = config('ai.groq.model');
        $this->baseUrl = config('ai.groq.base_url');
    }

    /**
     * Write a full news article from scratch.
     */
    public function writeArticle(string $topic, string $suggestedHeadline, array $keywords): string
    {
        $kw      = implode(', ', $keywords);
        $minWords = config('ai.blog.min_words', 620);

        $system = <<<SYS
You are an experienced senior journalist at a respected international news publication. You write in a clear, engaging, and authoritative style. Your articles are read by millions of people. You write as a human, with your own voice, observations, and natural rhythm.
SYS;

        $user = <<<USR
Write a complete news article about the following topic.

Topic: {$topic}
Working headline: {$suggestedHeadline}
Keywords to weave in naturally: {$kw}

Non-negotiable rules:
1. Minimum {$minWords} words. Count carefully. Do not stop early.
2. NEVER use a dash or hyphen as punctuation between words or clauses. Use a comma, semicolon, or restructure the sentence instead. Compound words with hyphens (like "well-known") are allowed.
3. NEVER use these phrases: "In conclusion", "It is worth noting", "It is important to note", "Furthermore", "Moreover", "Delve into", "Leverage", "Underscores the", "It's crucial to", "Navigating", "In the realm of"
4. Vary sentence length. Mix short punchy sentences with longer explanatory ones.
5. Use contractions naturally (it's, can't, don't, we're, there's).
6. Write entirely in active voice where possible.
7. No bullet points or numbered lists. Pure prose only.
8. Start with a compelling hook sentence that draws the reader in immediately.
9. Break into natural paragraphs of 3 to 5 sentences each.
10. End with a forward-looking or thought-provoking final paragraph.
11. Include specific details, context, and background that make the article feel thoroughly researched.
12. Write the BODY ONLY. Do not include the headline or any meta information.

Return only the article body text. Nothing else.
USR;

        return $this->chat($system, $user, 0.85);
    }

    /**
     * Rewrite sections of an article that sound AI-generated.
     */
    public function humanizeArticle(string $article, array $aiPhrases, array $structuralIssues): string
    {
        $phrases = implode("\n", array_map(fn($p) => "- \"{$p}\"", $aiPhrases));
        $issues  = implode("\n", array_map(fn($i) => "- {$i}", $structuralIssues));

        $system = <<<SYS
You are a veteran human editor at a top newspaper. Your job is to rewrite AI-generated text so it sounds completely human. You know every AI writing pattern and you eliminate them ruthlessly while keeping the facts and structure intact.
SYS;

        $user = <<<USR
The article below was flagged as AI-generated. Rewrite it so it passes as 100% human-written journalism.

Flagged phrases to replace:
{$phrases}

Structural issues to fix:
{$issues}

Strict rules:
1. Keep ALL the same facts, information, and approximate length.
2. NEVER use a dash or hyphen as punctuation between clauses.
3. Make it sound like one specific journalist's voice, not a committee.
4. Vary rhythm dramatically, short sentences next to long ones.
5. Remove any remaining AI clichés completely.
6. Use natural contractions.
7. Return ONLY the rewritten article body. No headline, no meta.

Original article:
{$article}
USR;

        return $this->chat($system, $user, 0.9);
    }

    // ── Private helpers ───────────────────────────────────────────────

    private function chat(string $system, string $user, float $temperature): string
    {
        $response = Http::timeout(120)
            ->withToken($this->apiKey)
            ->post("{$this->baseUrl}/chat/completions", [
                'model'       => $this->model,
                'messages'    => [
                    ['role' => 'system', 'content' => $system],
                    ['role' => 'user',   'content' => $user],
                ],
                'temperature' => $temperature,
            ]);

        if (!$response->successful()) {
            Log::error('Groq API error', ['status' => $response->status(), 'body' => $response->body()]);
            throw new \RuntimeException('Groq API error: ' . $response->status());
        }

        return trim($response->json('choices.0.message.content', ''));
    }
}
