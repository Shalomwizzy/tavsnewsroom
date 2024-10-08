<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class PopularNews extends Model
{
    use HasFactory;

    protected $fillable = ['post_news_id'];

    public function postNews()
    {
        return $this->belongsTo(PostNews::class,'post_news_id');
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
