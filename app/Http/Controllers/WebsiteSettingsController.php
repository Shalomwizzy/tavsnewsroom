<?php

namespace App\Http\Controllers;

use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class WebsiteSettingsController extends Controller
{




    public function index()
    {
        $siteName = WebsiteSetting::getValue('site_name', 'Site Name');
        $siteEmail = WebsiteSetting::getValue('site_email', 'default@example.com');
        $sitePhone = WebsiteSetting::getValue('site_phone', '000-000-0000');
        $siteCopyright = WebsiteSetting::getValue('site_copyright', 'All Rights Reserved.');
        $siteLogoUrl = WebsiteSetting::getValue('site_logo_url', 'default-logo.png');
    
        
        return view('admin.website-settings.index', compact('siteName', 'siteEmail', 'sitePhone', 'siteCopyright', 'siteLogoUrl', ));
    }

    // 'siteDescription', 'footerText'

    public function save(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email|max:255',
            'site_phone' => 'required|string|max:20',
            'site_copyright' => 'required|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        WebsiteSetting::setValue('site_name', $request->site_name);
        WebsiteSetting::setValue('site_email', $request->site_email);
        WebsiteSetting::setValue('site_phone', $request->site_phone);
        WebsiteSetting::setValue('site_copyright', $request->site_copyright);
        WebsiteSetting::setValue('site_description', $request->site_description);
        WebsiteSetting::setValue('footer_text', $request->footer_text);
    
        if ($request->hasFile('site_logo')) {
            $imageFile = $request->file('site_logo');
            $imageFileName = "logo_" . time() . '.' . $imageFile->getClientOriginalExtension();
            $location = public_path('uploads/logos');
            $imageFile->move($location, $imageFileName);
            $logoPath = 'uploads/logos/' . $imageFileName;
            WebsiteSetting::setValue('site_logo_url', $logoPath);
        }
    
        return redirect()->route('admin.website-settings.index')->with('success', 'Settings updated successfully.');
    }
}
