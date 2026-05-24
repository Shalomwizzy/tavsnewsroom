<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'post_news_id'];

    public function postNews()
    {
        return $this->belongsTo(PostNews::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
