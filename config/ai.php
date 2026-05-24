<?php

return [

    'gemini' => [
        'api_key'  => env('GEMINI_API_KEY'),
        'model'    => env('GEMINI_MODEL', 'gemini-2.0-flash'),
        'base_url' => 'https://generativelanguage.googleapis.com/v1beta/models',
    ],

    'groq' => [
        'api_key'  => env('GROQ_API_KEY'),
        'model'    => env('GROQ_MODEL', 'llama-3.3-70b-versatile'),
        'base_url' => 'https://api.groq.com/openai/v1',
    ],

    'pexels' => [
        'api_key'  => env('PEXELS_API_KEY'),
        'base_url' => 'https://api.pexels.com/v1',
    ],

    'blog' => [
        'min_words'          => 620,
        'target_words'       => 750,
        'min_humanness'      => 90,
        'max_rewrite_loops'  => 3,
        'auto_publish'       => env('AI_BLOG_AUTO_PUBLISH', true),
        'author_user_id'     => env('AI_AUTHOR_USER_ID', 1),
        'articles_per_run'   => env('AI_ARTICLES_PER_RUN', 1),
    ],

];
