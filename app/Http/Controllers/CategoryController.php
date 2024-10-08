<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PostNews;
use App\Models\SocialFollows;
use App\Models\Tags;
use App\Models\TrendingNews;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
{
    $categories = Category::paginate(20);
    return view('admin.categories.index', compact('categories'));
}


  // Method for displaying news under a specific category using slug
  public function showCategoryNews($slug)
  {
      $category = Category::where('slug', $slug)->firstOrFail();
      $posts = PostNews::where('category_id', $category->id)
                       ->where('status', 'published') // Ensure only published news is displayed
                       ->latest()
                      
                       ->paginate(4);
      $socialFollows = SocialFollows::where('is_active', true)->get();
      $trendingNews = TrendingNews::with('postNews')->get();
      $tags = Tags::with('category')->get();
  
      return view('categories.news', compact('category', 'posts', 'socialFollows', 'trendingNews', 'tags'));
  }
  


    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imageFile = $request->file('image');
        $imageFileName = "category_" . time() . '.' . $imageFile->extension();
        $location = public_path('images/categories');
        $imageFile->move($location, $imageFileName);
        $imagePath = 'images/categories/' . $imageFileName;
    }

    Category::create([
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'image' => $imagePath,
    ]);

    return redirect()->route('categories.index')
        ->with('success', 'Category created successfully.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $category = Category::findOrFail($id);

    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }

        $imageFile = $request->file('image');
        $imageFileName = "category_" . time() . '.' . $imageFile->extension();
        $location = public_path('images/categories');
        $imageFile->move($location, $imageFileName);
        $category->image = 'images/categories/' . $imageFileName;
    }

    $category->name = $request->name;
    $category->slug = Str::slug($request->name);
    $category->save();

    return redirect()->route('categories.index')
        ->with('success', 'Category updated successfully.');
}


public function showCategories()
{
    // Retrieve all categories and paginate them
    $categories = Category::paginate(4); // Paginate 4 categories per page

    // Retrieve social follows, trending news, and tags
    $socialFollows = SocialFollows::where('is_active', true)->get();
    $trendingNews = TrendingNews::with('postNews')->get();
    $tags = Tags::with('category')->get();

    // Pass the data to the view
    return view('categories.index', compact('categories', 'socialFollows', 'trendingNews', 'tags'));
}



    // public function showCategories()
    // {
    //     $categories = Category::all();
    //     return view('categories.index', compact('categories'));
    // }



    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

  

  



    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }





    public function selectHomepageCategories()
{
    // $categories = Category::all();
    $categories = Category::paginate(10);
    return view('admin.categories.select_homepage', compact('categories'));
}



public function updateHomepageCategories(Request $request)
{

    $request->validate([
        'categories' => 'array|max:6'
    ]);

    // Reset all categories
    Category::query()->update(['show_on_homepage' => false]);

    // Set selected categories
    if ($request->has('categories')) {
        Category::whereIn('id', $request->categories)->update(['show_on_homepage' => true]);
    }

    return redirect()->route('categories.select_homepage')->with('success', 'Homepage categories updated successfully.');
}
}