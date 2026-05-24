<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\RegenerateSitemapJob;
use Illuminate\Support\Facades\Cache;

class LatestNews extends Model
{
    use HasFactory;

    protected $fillable = ['post_news_id'];

    public function postNews()
    {
        return $this->belongsTo(PostNews::class);
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            Cache::forget('hp_latest');
            RegenerateSitemapJob::dispatch();
        });

        static::deleted(function ($model) {
            Cache::forget('hp_latest');
            RegenerateSitemapJob::dispatch();
        });
    }

}
