<?php

namespace App\Models;

use App\Jobs\RegenerateSitemapJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TrendingNews extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_news_id',
        'section',
    ];

    public function postNews()
    {
        return $this->belongsTo(PostNews::class, 'post_news_id');
    }

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('hp_trending');
            RegenerateSitemapJob::dispatch();
        });

        static::deleted(function () {
            Cache::forget('hp_trending');
            RegenerateSitemapJob::dispatch();
        });
    }
}
