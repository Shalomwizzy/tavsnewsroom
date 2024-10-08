<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";

    protected $fillable = ['name', 'slug', 'image', 'show_on_homepage'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });

        static::updating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function categoryPostNews() {
        return $this->hasMany(CategoryPostNews::class);
    }

    public function postNews()
    {
        return $this->hasMany(PostNews::class); // Assuming PostNews model has category_id foreign key
    }

    public function isSelected()
    {
        return $this->categoryPostNews()->exists();
    }


    public function navbarItem()
    {
        return $this->hasOne(NavbarItem::class);
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