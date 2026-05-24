<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\NavbarItem;

class NavbarComposer
{
    public function compose(View $view): void
    {
        $view->with('navbarItems', NavbarItem::with('category')->get());
    }
}
