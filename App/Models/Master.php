<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    protected $fillable = ['name','master_type_id','status'];


    public function scopeFilter($query)
    {
        
        if ($keyword = request('keyword')) {
            $query->where('name', 'like', '%' . $keyword . '%');
            $query->orWhere('reference_no', 'like', '%' . $keyword . '%');
        }

        if ($master_type = request('master_type')) {
            $query->where('master_type_id', $master_type);
        }

        return $query;

    }
    public static function getMasterData() {
        return static::filter()->get();
    }
    public static function getLanguagesData() {
        return static::where('status',_active())->where('master_type_id', 1)->pluck('name', 'id');
    }
    public static function getPublicationsData() {
        return static::where('status',_active())->where('master_type_id', 2)->pluck('name', 'id');
    }
    public static function getNotifacationsData() {
        return static::where('status',_active())->where('master_type_id', 3)->pluck('name', 'id');
    }
    public static function getEventsData() {
        return static::where('status',_active())->where('master_type_id', 4)->pluck('name', 'id');
    }

    public function master_type()
    {
        return $this->belongsTo(MasterType::class, 'master_type_id');
    }


}
