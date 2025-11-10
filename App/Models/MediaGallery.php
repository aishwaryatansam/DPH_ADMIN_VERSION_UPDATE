<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaGallery extends Model
{
    //
    protected $fillable = [
        'media_gallery',
        'tags', // Integer: 1 for image, 2 for audio, 3 for video
        'title',          // String: Title of the media
        'description',    // String: Description of the media
        'date',           // Date: Date when the media was added
        'status',         // Integer: 0 or 1 for status (active or inactive)
        'image',          // String: Image path, if media is of type 'image'
        'url',            // String: URL, if media is of type 'audio' or 'video'
    ];
    protected $casts = [
        'status' => 'boolean',
        'date' => 'date', // Cast date fields to proper date type
    ];

    public static function getMediaGalleryData()
    {
        return static::with([])
            ->where('status', _active())
            ->orderBy('id', 'desc')
            ->get();
    }

}
