<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareInteraction extends Model
{
    use HasFactory;


    protected $table = 'share_interactions';

    protected $fillable = [
        'post_news_id',
        'share_type',
    ];

 

    public function postNews()
    {
        return $this->belongsTo(PostNews::class,'post_news_id');
    }
}

