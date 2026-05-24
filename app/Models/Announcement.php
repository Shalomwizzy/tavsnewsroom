<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Announcement extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'message',
        'active',
    ];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('hp_announcements');
        });

        static::deleted(function () {
            Cache::forget('hp_announcements');
        });
    }
}
