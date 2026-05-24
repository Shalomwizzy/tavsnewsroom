<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostView extends Model
{
    public $timestamps = false;

    protected $fillable = ['post_news_id', 'ip_address', 'viewed_date'];

    protected $casts = ['viewed_date' => 'date'];

    public function postNews()
    {
        return $this->belongsTo(PostNews::class);
    }
}
