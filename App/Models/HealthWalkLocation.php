<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\District;

class HealthWalkLocation extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['contact_number', 'address', 'location_url', 'status', 'hud_id', 'area', 'description', 'start_point', 'end_point', 'visible_to_public'];


    public function scopeFilter($query) {

        if($keyword = request('keyword')) {
            $query->where('name','like','%'.$keyword.'%');
           }
        return $query;
    }

    public static function getQueriedResult() {

        list($sortfield,$sorttype) = getSorting();

        $result = static::with([])->filter();

        $sortfield = ($sortfield == 'name')?'name':$sortfield;
        

        return $result->orderBy($sortfield,$sorttype)->get();
   }


    public function hud()
    {
        return $this->belongsTo(HUD::class, 'hud_id');
    }

    public static function getLocationData()
    {
        return static::where('status', _active())->orderBy('id', 'asc')->get();
    }
}
