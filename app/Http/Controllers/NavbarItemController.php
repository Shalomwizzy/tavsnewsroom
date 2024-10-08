<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\NavbarItem;
use Illuminate\Http\Request;

class NavbarItemController extends Controller
{
    public function index()
{
    // Paginate categories with 10 items per page
    $categories = Category::paginate(10);
    
    // Get the currently selected categories for the navbar
    $selectedCategories = NavbarItem::with('category')->get();

    return view('admin.navbar-items.index', compact('categories', 'selectedCategories'));
}

    // public function index()
    // {
    //     $categories = Category::all();
    //     $selectedCategories = NavbarItem::with('category')->get();
    //     return view('admin.navbar-items.index', compact('categories', 'selectedCategories'));
    // }

    public function store(Request $request)
    {
        $request->validate([
            'category_ids' => 'required|array|max:3',
            'category_ids.*' => 'exists:categories,id',
        ]);

        NavbarItem::truncate();

        foreach ($request->category_ids as $categoryId) {
            NavbarItem::create(['category_id' => $categoryId]);
        }

        return redirect()->route('admin.navbar-items.index')->with('status', 'Navbar categories updated successfully!');
    }
}
