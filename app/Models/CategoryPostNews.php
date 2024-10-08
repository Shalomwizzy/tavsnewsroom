<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class CategoryPostNews extends Model
{
    use HasFactory;

    protected $table = 'category_post_news';

    protected $fillable = [
        'category_id',
        'post_news_id',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function postNews() {
        return $this->belongsTo(PostNews::class);
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