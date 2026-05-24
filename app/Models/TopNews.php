<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\RegenerateSitemapJob;
use Illuminate\Support\Facades\Cache;

class TopNews extends Model
{
    use HasFactory;

    protected $fillable = ['post_news_id'];

    public function postNews()
    {
        return $this->belongsTo(PostNews::class, 'post_news_id');
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            Cache::forget('hp_top_news');
            RegenerateSitemapJob::dispatch();
        });

        static::deleted(function ($model) {
            Cache::forget('hp_top_news');
            RegenerateSitemapJob::dispatch();
        });
    }

}
