<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;

class PostNews extends Model
{
    use HasFactory;

    protected $fillable = ['headline',  'slug','category_id', 'date', 'image_url', 'content','is_top_news','seo_score','seo_suggestions','meta_title','meta_description','meta_keywords','status','scheduled_for'
];

    public function category()
    {
        return $this->belongsTo(Category::class);
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


protected $dates = ['date'];

public function getDateAttribute($value)
{
    return Carbon::parse($value);
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