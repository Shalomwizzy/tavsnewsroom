<?php

namespace App\Http\Controllers;

use App\Models\User;

class AuthorController extends Controller
{
    public function show(string $username)
    {
        $author = User::where('username', $username)->firstOrFail();
        $posts = $author->posts()->withCount('postViews')->latest()->paginate(12);

        return view('author.show', compact('author', 'posts'));
    }
}
