<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigurationContentType extends Model
{
    protected $table = 'configuration_content_type';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     * */

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'status',
        'slug_key'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];


    public static function getConfigurationTypeData($ids = NULL) {
        if (is_array($ids) && !empty($ids)) {
            return static::whereIn('id', $ids)->get();
        }
        return static::all();
    }

    // Motters To Use Created To data Only
    public function getCreatedAtAttribute($date)
    {
        return convertUTCToLocal($date);
    }

    public function getUpdatedAtAttribute($date)
    {
        return convertUTCToLocal($date);
    }
}
