<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class BlogSetting extends Model
{
    use HasFactory;
    protected $table = 'blog_settings';

    protected $fillable = ['key', 'title', 'content'];

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
