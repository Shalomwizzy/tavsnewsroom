<?php

namespace App\Http\Controllers;

use App\Models\BlogSetting;
use Illuminate\Http\Request;


class BrandNameController extends Controller
{
    



    public function index()
    {
        $brandNameSetting = BlogSetting::where('key', 'brand_name')->first();
        $brandName = $brandNameSetting ? $brandNameSetting->content : '';
        return view('admin.brand-name.index', compact('brandName'));
    }

    public function save(Request $request)
    {
        $brandNameSetting = BlogSetting::where('key', 'brand_name')->first();
        if (!$brandNameSetting) {
            $brandNameSetting = new BlogSetting();
            $brandNameSetting->key = 'brand_name';
        }
        $brandNameSetting->content = $request->brand_name;
        $brandNameSetting->save();

        return redirect()->back()->with('success', 'Brand name updated successfully.');
    }



}