<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PexelsService
{
    private string $apiKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey  = config('ai.pexels.api_key');
        $this->baseUrl = config('ai.pexels.base_url');
    }

    /**
     * Search Pexels, download the best matching image, save to news_images,
     * and return the relative path (same format as manually uploaded images).
     */
    public function fetchAndStore(string $query): ?string
    {
        try {
            $response = Http::timeout(15)
                ->withHeaders(['Authorization' => $this->apiKey])
                ->get("{$this->baseUrl}/search", [
                    'query'       => $query,
                    'per_page'    => 5,
                    'orientation' => 'landscape',
                ]);

            if (!$response->successful()) {
                Log::warning('Pexels search failed', ['query' => $query, 'status' => $response->status()]);
                return null;
            }

            $photos = $response->json('photos', []);
            if (empty($photos)) {
                return null;
            }

            // Pick the first result with a large landscape image
            $photo    = $photos[0];
            $imageUrl = $photo['src']['large2x'] ?? $photo['src']['large'] ?? $photo['src']['original'];

            return $this->downloadImage($imageUrl);
        } catch (\Throwable $e) {
            Log::error('Pexels fetch error', ['error' => $e->getMessage()]);
            return null;
        }
    }

    private function downloadImage(string $url): ?string
    {
        $dir = public_path('images/news_images');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $extension = 'jpg';
        $filename  = 'ai_' . time() . '_' . uniqid() . '.' . $extension;
        $savePath  = $dir . '/' . $filename;

        $imageData = Http::timeout(30)->get($url)->body();
        if (empty($imageData)) {
            return null;
        }

        file_put_contents($savePath, $imageData);

        return 'images/news_images/' . $filename;
    }
}
