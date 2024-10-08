<?php
namespace App\Http\Controllers;

use App\Models\ShareInteraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShareInteractionController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'share_type' => 'required|string',
        ]);

        ShareInteraction::create([
            'post_news_id' => $postId,
            'share_type' => $request->input('share_type'),
        ]);

        return response()->json(['message' => 'Share interaction recorded successfully'], 201);
    }

    public function index()
    {
        $shareInteractions = ShareInteraction::select('post_news_id', 'share_type', DB::raw('count(*) as share_count'))
            ->with('postNews')
            ->groupBy('post_news_id', 'share_type')
            ->paginate(10); // Paginate with 10 share interactions per page
    
        return view('admin.share_interactions.index', compact('shareInteractions'));
    }
    
}