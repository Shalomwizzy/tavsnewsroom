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
        // Block if a generation is already in progress (prevents rate-limit spamming)
        if (AiBlogLog::whereIn('status', ['generating','picking_topic','writing','generating_meta','fetching_image','saving','generating_summary'])
                ->where('created_at', '>=', now()->subMinutes(10))
                ->exists()) {
            return back()->with('error', 'A generation is already in progress. Wait for it to finish before starting another.');
        }

        $categoryId = $request->filled('category_id') ? (int) $request->category_id : null;

        // dispatchAfterResponse sends the HTTP response first, then runs the job.
        // This prevents 504 timeouts even when QUEUE_CONNECTION=sync.
        GenerateAIBlogPostJob::dispatchAfterResponse($categoryId);

        return back()->with('success', 'AI article generation started. Refresh this page in 60–90 seconds to see the result.');
    }
}
