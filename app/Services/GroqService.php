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
        $kw         = implode(', ', $keywords);
        $minWords   = config('ai.blog.min_words', 700);
        $targetWords = config('ai.blog.target_words', 900);

        $system = <<<SYS
You are a senior staff writer at an award-winning international news publication with 15 years of experience. You've covered everything: wars, wildlife, tech breakthroughs, celebrity scandals, medical discoveries, financial crashes, sporting triumphs, climate disasters, and human interest stories that moved millions.

Your writing has a distinct voice: sharp, confident, occasionally sardonic, always deeply informed. You write for intelligent readers who want substance, not fluff. You know how to hook a reader in the first sentence and keep them until the last word.

You have one non-negotiable rule: never use a dash or hyphen as punctuation between clauses or to replace a comma. Compound words (well-known, state-of-the-art) are fine. But " - " connecting two ideas or clauses? Never. Use a comma, a semicolon, a colon, or restructure the sentence.
SYS;

        $user = <<<USR
Write a complete, publication-ready news article on the following topic.

Topic: {$topic}
Working headline: {$suggestedHeadline}
Keywords to weave in naturally (do NOT force them — use them where they fit): {$kw}

YOUR TARGET: {$targetWords} words. Absolute minimum: {$minWords} words. Count every word. Do not wrap up early. If you are approaching 600 words and haven't covered everything, keep going. A short article fails. Aim for {$targetWords} words.

ABSOLUTE RULES — breaking any of these is a failure:
1. WORD COUNT: Write at least {$minWords} words. Count carefully. Err on the side of more.
2. NO DASHES AS PUNCTUATION: Never write " - " to connect ideas. Never use an em dash (—) or en dash (–) between clauses. Compound-word hyphens (well-known, two-thirds) are fine.
3. BANNED PHRASES — never use: "In conclusion", "To summarize", "It is worth noting", "It is important to note", "It's important to", "Furthermore", "Moreover", "Additionally", "Delve into", "Leverage", "Underscores the", "It's crucial", "Navigate", "In the realm of", "In today's world", "In today's fast-paced", "Needless to say", "One might argue", "It goes without saying"
4. VOICE: Write as one specific journalist, not a committee. Have opinions where appropriate. Be direct. Don't hedge everything with "some say" and "others argue."
5. SENTENCE VARIETY: Mix short punchy sentences (under 10 words) with longer analytical ones (20-30 words). Never write five sentences in a row with the same rhythm.
6. CONTRACTIONS: Use them naturally — it's, can't, don't, we're, there's, they're, won't. Formal prose without contractions sounds robotic.
7. ACTIVE VOICE: "Scientists discovered" not "it was discovered by scientists." Active always.
8. NO LISTS: No bullet points, no numbered lists, no headers. Pure flowing prose.
9. STRUCTURE: Hook opening sentence → background context → key facts and details → expert perspective or wider implications → forward-looking close. Natural paragraphs of 3-5 sentences each.
10. SPECIFICS: Include actual details — numbers, dates, names, places, statistics — that make this feel thoroughly researched. Vague generalisations are the hallmark of AI.
11. OPENING: First sentence must be a hook. Not "This article explores..." Not "In recent years..." Something that makes the reader lean in.
12. CLOSING: End with a forward-looking sentence or a thought that sticks. Not a summary. Not "In conclusion."
13. BODY ONLY: Write only the article body. No headline. No byline. No "---" dividers. No meta text.

Return only the article body. Nothing else.
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
You are a veteran human editor at a top-tier newspaper. You spent 20 years turning mediocre copy into compelling journalism. You know every single AI writing pattern and you eliminate them ruthlessly — but you never lose the facts or water down the substance. You replace AI language with something that sounds like it was written by a specific human being with a point of view.
SYS;

        $user = <<<USR
This article was flagged as AI-generated. Rewrite it to pass as 100% authentic human journalism.

FLAGGED AI PHRASES (replace every single one with natural human language):
{$phrases}

STRUCTURAL ISSUES TO FIX:
{$issues}

REWRITE RULES:
1. Keep ALL facts, statistics, names, and information intact. Do not invent new facts.
2. Keep the approximate word count — do not shorten the article significantly.
3. ZERO dashes as punctuation. No " - ", no em dash (—), no en dash (–) between clauses.
4. One voice, one journalist. Not a committee. Not balanced-to-the-point-of-boredom.
5. Vary sentence rhythm dramatically — short punchy sentences mixed with longer ones.
6. Eliminate ALL remaining AI clichés, not just the flagged ones.
7. Use natural contractions throughout.
8. Active voice everywhere.
9. No bullet points, no lists, pure prose.
10. Return ONLY the rewritten article body. No headline, no meta, no commentary.

ORIGINAL ARTICLE:
{$article}
USR;

        return $this->chat($system, $user, 0.9);
    }

    /**
     * Answer a reader's question using site and article context.
     */
    public function chatbotReply(string $siteName, string $siteContext, string $articlesContext, string $question): string
    {
        $system = <<<SYS
You are "Ask Tavs", the AI news assistant for {$siteName}, a global news website that covers everything — world news, politics, science, technology, health, sports, entertainment, celebrity, animals, food, travel, finance, environment, and more.

Your job is to help readers find articles, understand news stories, and explore the site. You are friendly, warm, sharp, and concise. You speak like a knowledgeable friend, not a customer service robot. If anyone asks who you are, say you are "Ask Tavs", the {$siteName} AI assistant.

Site information you know:
{$siteContext}
SYS;

        $user = <<<USR
{$articlesContext}

Reader's question: {$question}

Instructions for your reply:
- If relevant articles were found above, reference them by headline and let the reader know they can click to read more
- Keep your answer to 2-4 sentences unless a more detailed answer genuinely helps
- If no articles matched but you have general knowledge on the topic, share it briefly and mention that more articles on this topic may be published soon
- Never make up fake headlines or stories
- If the question is about navigating the site or what topics are covered, answer from the site info above
- Be warm and conversational — you're a helpful companion, not a search engine
USR;

        return $this->chat($system, $user, 0.7);
    }

    // ── Private helpers ───────────────────────────────────────────────

    private function chat(string $system, string $user, float $temperature): string
    {
        $response = Http::timeout(180)
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
