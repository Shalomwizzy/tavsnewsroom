<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class CookieConsentComposer
{
    /**
     * Bind data to the view.
     *
     * @param \Illuminate\View\View $view
     * @return void
     */
    public function compose(View $view)
    {
        $showCookieConsent = !request()->cookie('cookie_consent');
        $view->with('showCookieConsent', $showCookieConsent);
    }
}

