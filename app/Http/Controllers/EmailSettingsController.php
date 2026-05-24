<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailSettings;

class EmailSettingsController extends Controller
{
    public function emailSettings()
    {
        // Fetch current settings
        $settings = EmailSettings::first();
        return view('admin.emails.settings', compact('settings'));
    }

    public function saveEmailSettings(Request $request)
    {
        $request->validate([
            'logo' => 'image|max:2048',
            'facebook_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'linkedin_link' => 'nullable|url',
        ]);

        $settings = EmailSettings::firstOrNew();

        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            $logoFileName = "logo_" . time() . '.' . $logoFile->extension();
            $location = public_path('images/logos');
            $logoFile->move($location, $logoFileName);
            $settings->logo_url = 'images/logos/' . $logoFileName;
        }

        $settings->facebook_link = $request->facebook_link;
        $settings->twitter_link = $request->twitter_link;
        $settings->instagram_link = $request->instagram_link;
        $settings->linkedin_link = $request->instagram_link;

        $settings->save();

        return redirect()->back()->with('success', 'Email settings updated successfully.');
    }
}