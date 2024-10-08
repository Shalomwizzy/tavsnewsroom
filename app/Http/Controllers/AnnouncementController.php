<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    //
    public function index()
    {
        $announcements = Announcement::paginate(20);
        return view('admin.announcements.index', compact('announcements'));
    }
    
    // public function create()
    // {
    //     return view('admin.announcements.create');
    // }
    public function create()
{
    $useTinyMCE = false; // Disable TinyMCE for this view
    return view('admin.announcements.create', compact('useTinyMCE'));
}

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'active' => 'boolean',
        ]);
    
        // Create the announcement using only the validated fields
        Announcement::create([
            'title' => $request->input('title'),
            'message' => $request->input('message'),
            'active' => $request->input('active', false),
        ]);
    
        return redirect()->route('announcements.index')->with('success', 'Announcement created successfully.');
    }

    public function toggle(Announcement $announcement)
{
    $announcement->active = !$announcement->active;
    $announcement->save();

    return redirect()->route('announcements.index')->with('success', 'Announcement status updated successfully.');
}

    

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'active' => 'boolean',
        ]);

        $announcement->update($request->all());

        return redirect()->route('announcements.index')->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', 'Announcement deleted successfully.');
    }
}