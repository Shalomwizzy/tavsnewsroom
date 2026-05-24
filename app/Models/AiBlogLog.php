<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiBlogLog extends Model
{
    protected $fillable = [
        'topic', 'headline', 'status', 'attempts',
        'humanness_score', 'word_count', 'post_news_id', 'error',
    ];

    public function post()
    {
        return $this->belongsTo(PostNews::class, 'post_news_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'completed'  => 'Published',
            'failed'     => 'Failed',
            'generating',
            'writing',
            'picking_topic',
            'humanizing_attempt_1',
            'humanizing_attempt_2',
            'humanizing_attempt_3',
            'generating_meta',
            'fetching_image',
            'saving'     => 'In Progress',
            default      => ucfirst($this->status),
        };
    }
}
