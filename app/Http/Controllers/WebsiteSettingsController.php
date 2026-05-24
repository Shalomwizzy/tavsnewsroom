<?php

namespace App\Http\Controllers;

use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class WebsiteSettingsController extends Controller
{




    public function index()
    {
        $siteName              = WebsiteSetting::getValue('site_name', '');
        $siteEmail             = WebsiteSetting::getValue('site_email', '');
        $sitePhone             = WebsiteSetting::getValue('site_phone', '');
        $siteCopyright         = WebsiteSetting::getValue('site_copyright', '');
        $siteLogoUrl           = WebsiteSetting::getValue('site_logo_url', '');
        $siteDefaultMetaDesc   = WebsiteSetting::getValue('site_default_meta_description', '');
        $gaTrackingId          = WebsiteSetting::getValue('ga_tracking_id', '');
        $gaPropertyId          = WebsiteSetting::getValue('ga_property_id', '');
        $commentsEnabled       = (bool) WebsiteSetting::getValue('comments_enabled', '1');
        $robotsTxt             = WebsiteSetting::getValue('robots_txt', "User-agent: *\nDisallow: /reject-cookies\nDisallow: /accept-cookies\nDisallow: /admin");
        $aiChatName            = WebsiteSetting::getValue('ai_chat_name', 'Ask Tavs');

        return view('admin.website-settings.index', compact(
            'siteName', 'siteEmail', 'sitePhone', 'siteCopyright', 'siteLogoUrl',
            'siteDefaultMetaDesc', 'gaTrackingId', 'gaPropertyId', 'commentsEnabled', 'robotsTxt',
            'aiChatName'
        ));
    }

    public function save(Request $request)
    {
        $request->validate([
            'site_name'                    => 'required|string|max:255',
            'site_email'                   => 'required|email|max:255',
            'site_phone'                   => 'required|string|max:20',
            'site_copyright'               => 'required|string|max:255',
            'site_logo'                    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_default_meta_description'=> 'nullable|string|max:320',
            'ga_tracking_id'               => 'nullable|string|max:50',
            'ga_property_id'               => 'nullable|string|max:50',
        ]);

        WebsiteSetting::setValue('site_name', $request->site_name);
        WebsiteSetting::setValue('site_email', $request->site_email);
        WebsiteSetting::setValue('site_phone', $request->site_phone);
        WebsiteSetting::setValue('site_copyright', $request->site_copyright);
        WebsiteSetting::setValue('site_default_meta_description', $request->site_default_meta_description ?? '');
        WebsiteSetting::setValue('ga_tracking_id', $request->ga_tracking_id ?? '');
        WebsiteSetting::setValue('ga_property_id', $request->ga_property_id ?? '');
        WebsiteSetting::setValue('comments_enabled', $request->has('comments_enabled') ? '1' : '0');
        WebsiteSetting::setValue('robots_txt', $request->input('robots_txt', ''));
        WebsiteSetting::setValue('ai_chat_name', $request->input('ai_chat_name', 'Ask Tavs'));
    
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
