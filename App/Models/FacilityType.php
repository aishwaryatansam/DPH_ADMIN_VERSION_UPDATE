<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PHC;


class FacilityType extends Model
{
    protected $table = 'facility_type';

     protected $fillable = [
        'name',
        'status',
        'slug_key'
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

        // $page_length = getPagelength();

        list($sortfield,$sorttype) = getSorting();

        $result = static::with([])->filter();

        $sortfield = ($sortfield == 'name')?'name':$sortfield;
        

        return $result->orderBy($sortfield,$sorttype)->get();
    }

    public static function getFacilityTypeData() {
        return static::where('status',_active())->orderBy('name','asc')->get();
    }

    


   


}
