<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class SocialFollows extends Model
{
    use HasFactory;

    protected $fillable = ['platform', 'url', 'icon_class', 'followers', 'is_active'];


    public function getBackgroundColor()
    {
        $colors = [
            'facebook' => '#39569E',
            'twitter' => '#000000',
            'linkedin' => '#0185AE',
            'whatsapp' => '#008000',
            'telegram' => '#229ED9',
            'instagram' => '#C8359D',
            'youtube' => '#DC472E',
            'vimeo' => '#1AB7EA',
            'email' => '#0000FF',
            'tiktok' => '#020202',
            'snapchat' => '#020202',
            
        ];

        return $colors[strtolower($this->platform)] ?? '#000';
    }

    public function getFollowersLabel()
    {
        $labels = [
            'facebook' => 'Fans',
            'twitter' => 'Followers',
            'linkedin' => 'Connects',
            'instagram' => 'Followers',
            'whatsapp' => 'Followers',
            'telegram' => 'Subscribers',
            'email' => 'Connection',
            'tiktok' => 'Followers',
            'snapchat' => 'Snap Score',
            'youtube' => 'Subscribers',
            'vimeo' => 'Followers',
        ];

        return $labels[strtolower($this->platform)] ?? 'Followers';
    }



      // Define accessors for followers, fans, connections, etc.
      public function getFansAttribute()
      {
          return $this->attributes['fans'] ?? null;
      }
  
      public function getFollowersAttribute()
      {
          return $this->attributes['followers'] ?? null;
      }
  
      public function getConnectionsAttribute()
      {
          return $this->attributes['connections'] ?? null;
      }
  

      protected static function booted()
      {
          static::saved(function ($model) {
              Artisan::call('app:generate-sitemap');
          });
  
          static::deleted(function ($model) {
              Artisan::call('app:generate-sitemap');
          });
      }
  
      // Add more accessors as needed
}