<?php

namespace App\Http\View\Composers;

use App\Models\Comment;
use Illuminate\View\View;
use App\Models\Tags;
use App\Models\SocialFollows;
use App\Models\TrendingNews;

class PostNewsComposer
{
    public function compose(View $view)
    {
        $tags = Tags::with('category')->get();
        $socialFollows = SocialFollows::where('is_active', true)->get();
        $trendingNews = TrendingNews::with('postNews')->get();
      

        $view->with(compact('tags', 'socialFollows','trendingNews'));
    }
}

