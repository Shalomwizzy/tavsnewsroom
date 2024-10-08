<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value','logo_path'];

    public static function getValue($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function setValue($key, $value)
{
    if ($value !== null) {
        return static::updateOrCreate(['key' => $key], ['value' => $value]);
    } else {
        // If $value is null, set a default value or handle it as per your requirement
        $defaultValue = ''; // Example: Set an empty string as default value
        return static::updateOrCreate(['key' => $key], ['value' => $defaultValue]);
    }
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