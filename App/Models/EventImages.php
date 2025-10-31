<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventImages extends Model
{
    protected $fillable = ['event_uploads_id', 'image_url'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function event_upload()
    {
        return $this->belongsTo(EventUpload::class, 'event_uploads_id');
    }
}
