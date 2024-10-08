<?php

namespace App\Http\Controllers;
use App\Models\PostNews;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function show($slug)
    {
        $post = PostNews::where('slug', $slug)->firstOrFail();
        return view('blog.show', compact('postNews'));
    }
}
