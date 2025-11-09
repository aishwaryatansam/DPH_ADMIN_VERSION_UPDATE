<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HUD;

class District extends Model
{
     protected $fillable = [
        'name',
        'status',
        'tags',
        'image_url',
        'location_url'
        
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];


    // Motters To Use Created To data Only
    public function getCreatedAtAttribute($date)
    {
        return convertUTCToLocal($date);
    }

    public function getUpdatedAtAttribute($date)
    {
        return convertUTCToLocal($date);
    }

	 public function scopeFilter($query) {

         if($keyword = request('keyword')) {
             $query->where('name','like','%'.$keyword.'%');
            }
         return $query;
     }

	 public static function getQueriedResult() {

     	$page_length = getPagelength();

     	list($sortfield,$sorttype) = getSorting();

     	$result = static::with([])->filter();

     	$sortfield = ($sortfield == 'name')?'name':$sortfield;
     	

     	return $result->orderBy($sortfield,$sorttype)->get();
     	// return $result->orderBy($sortfield,$sorttype)->paginate($page_length);

    }


    public static function getDistrictData() {
        return static::where('status',_active())->orderBy('name','asc')->get();
    }

    public function hud() {
        return $this->hasMany(HUD::class);
    }

    public function healthWalkLocations()
    {
        return $this->hasMany(HealthWalkLocation::class);
    }


}
