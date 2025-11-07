<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigurationDetails extends Model
{
    protected $table = 'configuration_details';
    protected $fillable = [
        'name',
        'link',
        'image_url',
        'description',
        'date',
        'status',
        'coloreffect',
        'menu_to_show',
        'tags',
        'configuration_content_type_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];
    public function getCreatedAtAttribute($date)
    {
        return convertUTCToLocal($date);
    }

    public function getUpdatedAtAttribute($date)
    {
        return convertUTCToLocal($date);
    }

    public static function getConfigurationDetailsData($id)
    {

        return static::where('configuration_content_type_id', $id)
            ->orderBy('id', 'asc')
            ->get();
    }
    public static function getHeaderLogoConfig()
    {
        return static::where('configuration_content_type_id', 1)
            ->orderBy('id', 'asc')
            ->get();
    }
}
