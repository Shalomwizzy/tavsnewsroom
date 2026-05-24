<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
     * Ask Gemini to pick the best trending SEO topic to write about.
     */
    public function selectTrendingTopic(array $existingHeadlines, array $categoryNames): array
    {
        $headlines = implode("\n", array_slice($existingHeadlines, 0, 30));
        $cats      = implode(', ', $categoryNames);

        $prompt = <<<PROMPT
You are a senior SEO editor at a major online news publication. Your job is to identify the single best topic to write about right now for maximum search traffic and reader engagement.

Available categories: {$cats}

Recently published headlines (do NOT suggest anything similar to these):
{$headlines}

Pick ONE topic that:
- Is currently trending or has high search demand
- Will generate strong click-through from Google search results
- Has not been covered in the headlines above
- Fits one of the available categories
- Appeals to a broad general audience

Respond with valid JSON only. No markdown, no explanation, just the JSON object:
{"topic":"...","suggested_headline":"...","category":"...","seo_keywords":["k1","k2","k3","k4"],"meta_description":"...","image_search_query":"..."}
PROMPT;

        $data = $this->call($prompt, 0.9);
        return $this->parseJson($data);
    }

    /**
     * Check how human an article sounds. Returns score + flagged phrases.
     */
    public function humanizeCheck(string $article): array
    {
        $prompt = <<<PROMPT
You are an expert at detecting AI-generated text. Analyse the article below and evaluate how human it sounds.

Score it from 0 to 100:
- 100 = reads exactly like an experienced human journalist wrote it
- 0   = obviously machine-generated

Common AI tells to look for: repetitive sentence structure, unnatural transitions, overuse of phrases like "it is worth noting", "furthermore", "in conclusion", "it is important to", "delve into", "leverage", vague generalisations, bullet-point thinking in prose form, and mechanical pacing.

Article to analyse:
{$article}

Respond with valid JSON only, no markdown:
{
  "score": 87,
  "ai_phrases": ["exact phrase 1", "exact phrase 2"],
  "structural_issues": ["describe any structural AI patterns found"],
  "verdict": "one sentence overall assessment"
}
PROMPT;

        $data = $this->call($prompt, 0.2);
        $result = $this->parseJson($data);

        return [
            'score'              => (int) ($result['score'] ?? 0),
            'ai_phrases'         => $result['ai_phrases'] ?? [],
            'structural_issues'  => $result['structural_issues'] ?? [],
            'verdict'            => $result['verdict'] ?? '',
        ];
    }

    /**
     * Generate SEO meta fields from the final article text.
     */
    public function generateMeta(string $article, string $suggestedHeadline, array $keywords): array
    {
        $kw = implode(', ', $keywords);

        $prompt = <<<PROMPT
You are an SEO expert. Based on the article below, generate optimised metadata.

Primary keywords: {$kw}
Suggested headline: {$suggestedHeadline}

Rules:
- Headline: max 12 words, compelling, includes primary keyword, NO dashes
- Meta title: max 60 characters, includes keyword
- Meta description: 150-160 characters, persuasive, includes keyword, ends with a call to action
- Tags: 4-6 comma-separated topic tags

Article:
{$article}

Respond with valid JSON only, no markdown:
{
  "headline": "final article headline",
  "meta_title": "SEO meta title",
  "meta_description": "SEO meta description",
  "tags": "tag1, tag2, tag3, tag4"
}
PROMPT;

        $data = $this->call($prompt, 0.3);
        return $this->parseJson($data);
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

        $maxAttempts = 3;
        $lastError   = null;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            $response = Http::timeout(120)->post($url, $payload);

            if ($response->successful()) {
                return $response->json('candidates.0.content.parts.0.text', '');
            }

            $status = $response->status();
            $body   = $response->json();
            $msg    = $body['error']['message'] ?? $response->body();

            Log::warning("Gemini attempt {$attempt} failed", ['status' => $status, 'message' => $msg]);
            $lastError = "Gemini {$status}: {$msg}";

            if ($status === 429 && $attempt < $maxAttempts) {
                sleep($attempt * 10);
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
            Log::warning('Gemini JSON parse failed', ['raw' => $raw]);
            return [];
        }

        return $decoded;
    }
}
