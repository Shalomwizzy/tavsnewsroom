<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\RegenerateSitemapJob;
use Illuminate\Support\Facades\Cache;

class Tags extends Model
{
    use HasFactory;


    protected $fillable = ['category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            Cache::forget('hp_tags');
            RegenerateSitemapJob::dispatch();
        });

        static::deleted(function ($model) {
            Cache::forget('hp_tags');
            RegenerateSitemapJob::dispatch();
        });
    }

}