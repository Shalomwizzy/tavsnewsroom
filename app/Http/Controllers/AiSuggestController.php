<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\GeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AiSuggestController extends Controller
{
    public function __construct(private GeminiService $gemini) {}

    public function suggest(Request $request): JsonResponse
    {
        $headline = trim($request->input('headline', ''));
        $content  = trim($request->input('content', ''));

        if (empty($headline) && empty($content)) {
            return response()->json(['error' => 'Please add a headline or some content first.'], 422);
        }

        $categories = Category::all(['id', 'name'])->toArray();

        try {
            $result = $this->gemini->suggestTagsAndCategory($headline, $content, $categories);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'AI suggestion failed — please try again.'], 500);
        }

        return response()->json([
            'category_id'      => $result['category_id']      ?? null,
            'meta_keywords'    => $result['meta_keywords']     ?? '',
            'meta_title'       => $result['meta_title']        ?? '',
            'meta_description' => $result['meta_description']  ?? '',
            'category_name'    => $result['category_name']     ?? '',
        ]);
    }
}
