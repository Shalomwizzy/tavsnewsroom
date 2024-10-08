<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class EmailSettings extends Model
{
    use HasFactory;



    protected $fillable = [
        'logo_url',
        'facebook_link',
        'twitter_link',
        'instagram_link',
        'linkedin_link',
        
    ];

    public static function getValue($key, $default = null)
    {
        $setting = self::first();
        return $setting ? $setting->$key : $default;
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

}