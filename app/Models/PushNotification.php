<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    protected $fillable = [
        'title', 'message', 'url', 'image_url', 'type', 'recipients', 'sent_by',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}
