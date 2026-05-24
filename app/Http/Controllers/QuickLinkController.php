<?php

namespace App\Http\Controllers;

use App\Models\QuickLink;
use Illuminate\Http\Request;

class QuickLinkController extends Controller
{
    public function index()
    {
        $quickLinks = QuickLink::all();
        return view('admin.quick_links.index', compact('quickLinks'));
    }

    public function update(Request $request)
    {
        $quickLinks = $request->input('quick_links', []);

        foreach ($quickLinks as $id => $isActive) {
            $quickLink = QuickLink::find($id);
            if ($quickLink) {
                $quickLink->is_active = $isActive;
                $quickLink->save();
            }
        }

        return redirect()->route('admin.quick_links.index')->with('success', 'Quick links updated successfully');
    }
}

