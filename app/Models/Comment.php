<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['post_news_id', 'user_id', 'name', 'email', 'body', 'is_approved'];

    protected $casts = ['is_approved' => 'boolean'];

    public function postNews()
    {
        return $this->belongsTo(PostNews::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }
}
