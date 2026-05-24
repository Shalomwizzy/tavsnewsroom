<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SocialFollows;
use Illuminate\Http\Request;

class SocialFollowController extends Controller
{

    private function getPlatformIcon($platform)
    {
        $icons = [
            'facebook' => 'fa-facebook',
            'twitter' => 'fa-twitter',
            'whatsapp' => 'fa-whatsapp',
            'instagram' => 'fa-instagram',
            'telegram' => 'fa-telegram',
            'youtube' => 'fa-youtube',
            'linkedin' => 'fa-linkedin',
            'vimeo' => 'fa-vimeo',
            'snapchat' => 'fa-snapchat',
            'tiktok' => 'fa-tiktok',
            'reddit' => 'fa-reddit',
            'email' => 'fa-envelope',
        ];

       


        return $icons[$platform] ?? 'fa-share';
    }
    public function index()
    {
        // Subquery to get the latest entries for each platform
        $latestIds = SocialFollows::selectRaw('MAX(id) as id')
            ->groupBy('platform')
            ->get();
    
        // Use the latestIds to fetch the actual records
        $socialFollows = SocialFollows::whereIn('id', $latestIds->pluck('id')->all())
            ->get();
    
        return view('admin.social_follow.index', compact('socialFollows'));
    }
    
    


    // public function index()
    // {
    //     $socialFollows = SocialFollows::all();
    //     return view('admin.social_follow.index', compact('socialFollows'));
    // }

    public function store(Request $request)
    {
        $platforms = $request->input('platforms', []);
    
        // Delete existing entries for selected platforms
        SocialFollows::whereIn('platform', $platforms)->delete();
    
        // Insert new entries
        foreach ($platforms as $platform) {
            $url = $request->input("{$platform}_url");
            $followers = $request->input("{$platform}_followers");
            $icon_class = $this->getPlatformIcon($platform);
    
            SocialFollows::create([
                'platform' => $platform,
                'url' => $url,
                'followers' => $followers,
                'icon_class' => $icon_class,
            ]);
        }
    
        return redirect()->route('admin.social_follows.index');
    }
    

    public function update(Request $request, $id)
    {
        $platform = $request->input('platform');
        $urlField = "{$platform}_url";
        $followersField = "{$platform}_followers";
    
        $validated = $request->validate([
            $urlField => 'required|url',
            $followersField => 'required|integer',
        ]);
    
        $icon_class = $this->getPlatformIcon($platform);
    
        $socialFollow = SocialFollows::findOrFail($id);
        $socialFollow->update([
            'platform' => $platform,
            'url' => $validated[$urlField],
            'followers' => $validated[$followersField],
            'icon_class' => $icon_class,
            'is_active' => $request->input('is_active', true),
        ]);
    
        return redirect()->route('admin.social_follows.index')->with('success', 'Social follow link updated successfully.');
    }
    

    public function destroy($id)
    {
        SocialFollows::findOrFail($id)->delete();
        return redirect()->route('admin.social_follows.index')->with('success', 'Social follow link removed successfully.');
    }
}