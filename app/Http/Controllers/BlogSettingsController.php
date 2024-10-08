<?php

namespace App\Http\Controllers;

use App\Models\BlogSetting;
use Illuminate\Http\Request;

class BlogSettingsController extends Controller
{
    public function index()
    {
        $settings = BlogSetting::all();
        return view('admin.blog-settings.index', compact('settings'));
    }

    public function edit($key)
    {
        $setting = BlogSetting::where('key', $key)->firstOrFail();
        return view('admin.blog-settings.edit', compact('setting'));
    }

    public function update(Request $request, $key)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $setting = BlogSetting::where('key', $key)->firstOrFail();
        $setting->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('admin.blog-settings.index')->with('success', ucfirst(str_replace('_', ' ', $key)) . ' updated successfully.');
    }
}