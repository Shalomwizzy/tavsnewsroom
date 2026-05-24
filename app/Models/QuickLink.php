<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\RegenerateSitemapJob;
use Illuminate\Support\Facades\Cache;

class QuickLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'is_visible',
    ];

    protected static function booted()
    {
        static::saved(function ($model) {
            Cache::forget('hp_quick_links');
            RegenerateSitemapJob::dispatch();
        });

        static::deleted(function ($model) {
            Cache::forget('hp_quick_links');
            RegenerateSitemapJob::dispatch();
        });
    }

}
