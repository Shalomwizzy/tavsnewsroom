<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryPostNews;
use App\Models\Category;
use App\Models\PostNews;

class CategoryPostNewsController extends Controller
{

  


    public function index()
{
    $categories = Category::with(['postNews' => function ($query) {
        $query->where('status', 'published');
    }])->paginate(12); // Paginate categories

    return view('admin.category_post_news.index', compact('categories'));
}



    public function update(Request $request)
    {
        $request->validate([
            'selected_categories' => 'required|array|max:6',
            'selected_categories.*' => 'exists:categories,id',
            'selected_news' => 'nullable|array|max:6',
            'selected_news.*' => 'exists:post_news,id',
        ], [
            'selected_categories.*.exists' => 'Invalid category selected.',
            'selected_news.*.exists' => 'Invalid post news selected.',
        ]);

        CategoryPostNews::truncate();

        $categoryPostNews = [];

        foreach ($request->selected_categories as $categoryId) {
            if (isset($request->selected_news[$categoryId]) && is_array($request->selected_news[$categoryId])) {
                $newsIds = array_slice($request->selected_news[$categoryId], 0, 4);
                foreach ($newsIds as $newsId) {
                    $categoryPostNews[] = [
                        'category_id' => $categoryId,
                        'post_news_id' => $newsId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        CategoryPostNews::insert($categoryPostNews);

        return redirect()->back()->with('success', 'Homepage news updated successfully');
    }
    
    

}