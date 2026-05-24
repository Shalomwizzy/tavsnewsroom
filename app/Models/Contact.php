<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'subject', 'message'];

    protected static function booted()
    {
        static::saved(function () {
            try {
                Artisan::call('app:generate-sitemap');
            } catch (\Throwable $e) {
                //
            }
        });

        static::deleted(function () {
            try {
                Artisan::call('app:generate-sitemap');
            } catch (\Throwable $e) {
                //
            }
        });
    }

}
