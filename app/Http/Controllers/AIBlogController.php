<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateAIBlogPostJob;
use App\Models\AiBlogLog;
use App\Models\Category;
use Illuminate\Http\Request;

class AIBlogController extends Controller
{
    public function index()
    {
        $logs = AiBlogLog::with('post')->latest()->paginate(20);
        $categories = Category::orderBy('name')->get();

        $stats = [
            'total'       => AiBlogLog::where('status', 'completed')->count(),
            'today'       => AiBlogLog::where('status', 'completed')->whereDate('created_at', today())->count(),
            'avg_score'   => (int) AiBlogLog::where('status', 'completed')->avg('humanness_score'),
            'avg_words'   => (int) AiBlogLog::where('status', 'completed')->avg('word_count'),
        ];

        return view('admin.ai-blog.index', compact('logs', 'categories', 'stats'));
    }

    public function generate(Request $request)
    {
        $categoryId = $request->filled('category_id') ? (int) $request->category_id : null;

        GenerateAIBlogPostJob::dispatch($categoryId);

        return back()->with('success', 'AI article generation started. It will appear in the log below once complete (usually 30–60 seconds).');
    }
}
