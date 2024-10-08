<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tags;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show()
    {
        $categories = Category::all();
        $selectedTags = Tags::all()->pluck('category_id')->toArray();
        return view('admin.tags.index', compact('categories', 'selectedTags'));
    }

    public function update(Request $request)
    {
        Tags::truncate();

        if ($request->has('selected_tags')) {
            foreach ($request->input('selected_tags') as $categoryId) {
                Tags::create(['category_id' => $categoryId]);
            }
        }

        return redirect()->route('tags.show')->with('success', 'Tags updated successfully.');
    }

}
