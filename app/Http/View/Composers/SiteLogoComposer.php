<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\WebsiteSetting;

class SiteLogoComposer
{
    public function compose(View $view)
    {
        $siteLogoUrl = WebsiteSetting::getValue('site_logo_url');
        $view->with('siteLogoUrl', $siteLogoUrl);
    }
}