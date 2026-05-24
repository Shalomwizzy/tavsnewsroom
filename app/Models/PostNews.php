<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use App\Jobs\RegenerateSitemapJob;
use Illuminate\Support\Facades\Cache;

class PostNews extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'headline', 'slug', 'category_id', 'user_id', 'date', 'image_url', 'content',
        'is_top_news', 'is_breaking', 'seo_score', 'seo_suggestions', 'meta_title',
        'meta_description', 'meta_keywords', 'status', 'scheduled_for',
        'reading_time',
    ];

    protected $casts = [
        'is_breaking' => 'boolean',
        'is_top_news' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function topNews()
    {
        return $this->hasOne(TopNews::class);
    }

    public function carouselNews()
    {
        return $this->hasOne(CarouselNews::class, 'post_news_id');
    }

    public function isFeatured()
    {
        return $this->carouselNews()->exists();
    }

    public function isFeature()
    {
        return $this->featuredNews()->exists();
    }

    public function isSelected()
    {
        return $this->categoryPostNews()->exists();
    }

    
    public function popularNews()
    {
        return $this->hasOne(PopularNews::class,'post_news_id');
    }

    public function isPopular()
    {
        return $this->popularNews()->exists();
    }

    public function latestNews()
    {
        return $this->hasOne(LatestNews::class,'post_news_id');
    }


    public function  isLatest()
    {
        return $this->latestNews()->exists();
    }



    public function trendingNews()
    {
        return $this->hasOne(TrendingNews::class);
    }

   

  
    public function featuredNews()
    {
        return $this->hasOne(FeaturedNews::class);
    }

    public function categoryPostNews() {
        return $this->hasMany(CategoryPostNews::class);
    }
    

    public function shareInteractions()
{
    return $this->hasMany(ShareInteraction::class);
}

public function postViews()
{
    return $this->hasMany(PostView::class);
}

public function bookmarks()
{
    return $this->hasMany(Bookmark::class);
}

public function comments()
{
    return $this->hasMany(Comment::class);
}


protected $dates = ['date'];

public function getDateAttribute(mixed $value): Carbon
{
    return Carbon::parse($value);
}

public function getReadingTimeAttribute(?int $value): int
{
    if ($value !== null) {
        return $value;
    }
    // Fall back to on-the-fly calculation for posts saved before this feature
    return max(1, (int) ceil(str_word_count(strip_tags($this->content ?? '')) / 200));
}

protected static function booted(): void
{
    $clearCache = function () {
        foreach (['hp_top_news','hp_carousel','hp_featured','hp_trending',
                  'hp_popular','hp_latest','hp_categories','hp_tags'] as $key) {
            Cache::forget($key);
        }
    };

    // Calculate reading time before every save so it's always up-to-date
    static::saving(function (PostNews $post) {
        $post->reading_time = max(1, (int) ceil(
            str_word_count(strip_tags($post->content ?? '')) / 200
        ));
    });

    static::saved(function () use ($clearCache) {
        RegenerateSitemapJob::dispatch();
        $clearCache();
    });

    static::deleted(function () use ($clearCache) {
        RegenerateSitemapJob::dispatch();
        $clearCache();
    });
}



}