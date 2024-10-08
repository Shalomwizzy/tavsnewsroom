<?php

namespace App\Http\Controllers;

use App\Models\FooterSetting;
use App\Models\QuickLink;
use App\Models\Tags;
use Illuminate\Http\Request;

class FooterSettingsController extends Controller
{
    public function edit()
    {
        $footerSettings = FooterSetting::first();
        $tags = Tags::with('category')->get();
        $quickLinks = QuickLink::where('is_active', true)->get();

        return view('admin.footer_settings.index', compact('footerSettings', 'tags', 'quickLinks'));
    }

    public function showFooter()
    {
        $tags = Tags::with('category')->get();
        $quickLinks = QuickLink::where('is_active', true)->get();
        $footerSettings = FooterSetting::first();

        return view('partials.footer', compact('tags', 'quickLinks', 'footerSettings'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'nullable|string|max:200',
            'selected_links' => 'nullable|array',
            'selected_links.*' => 'string|in:twitter,facebook,linkedin,instagram,youtube,whatsapp,tiktok,telegram,email,snapchat,reddit,vimeo,threads',
            'twitter_link' => 'nullable|url',
            'facebook_link' => 'nullable|url',
            'linkedin_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'youtube_link' => 'nullable|url',
            'whatsapp_link' => 'nullable|url',
            'tiktok_link' => 'nullable|url',
            'telegram_link' => 'nullable|url',
            'email_link' => 'nullable|email',
            'snapchat_link' => 'nullable|url',
            'reddit_link' => 'nullable|url',
            'vimeo_link' => 'nullable|url',
            'threads_link' => 'nullable|url',
        ]);

        // Ensure that no more than 5 social links are selected
        if (isset($validatedData['selected_links']) && count($validatedData['selected_links']) > 5) {
            return redirect()->back()->withErrors(['selected_links' => 'You can select a maximum of 5 social links.'])->withInput();
        }

        $footerSettings = FooterSetting::firstOrNew([]);
        $footerSettings->description = $validatedData['description'] ?? $footerSettings->description;
        $footerSettings->selected_links = json_encode($validatedData['selected_links'] ?? []);

        foreach ($validatedData['selected_links'] ?? [] as $link) {
            $footerSettings->{$link . '_link'} = $validatedData[$link . '_link'] ?? null;
        }

        $footerSettings->save();

        return redirect()->route('admin.footer_settings.index')->with('success', 'Footer settings updated successfully.');
    }
}