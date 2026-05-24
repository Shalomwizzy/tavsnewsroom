<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Tags;
use App\Models\QuickLink;
use App\Models\FooterSetting;

class FooterComposer
{
    public function compose(View $view)
    {
        $tags = Tags::with('category')->get();
        $quickLinks = QuickLink::where('is_active', true)->get();
        $footerSettings = FooterSetting::first();

        $view->with(compact('tags', 'quickLinks', 'footerSettings'));
    }
}



