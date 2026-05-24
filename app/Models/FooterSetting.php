<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class FooterSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'twitter_link',
        'facebook_link',
        'linkedin_link',
        'instagram_link',
        'youtube_link',
        'whatsapp_link',
        'tiktok_link',
        'telegram_link',
        'email_link',
        'snapchat_link',
        'reddit_link',
        'vimeo_link',
        'threads_link',
        'selected_links',
    ];

    protected static function booted()
    {
        static::saved(function ($model) {
            Artisan::call('app:generate-sitemap');
        });

        static::deleted(function ($model) {
            Artisan::call('app:generate-sitemap');
        });
    }

}