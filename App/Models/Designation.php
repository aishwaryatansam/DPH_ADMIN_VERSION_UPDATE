<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DesignationType;

class Designation extends Model
{
     protected $table = 'designations';
     protected $fillable = [
        'name',
        'designation_type_id',
        'status',
        'order_no'
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
    }


    public static function getDesignationData($designation_type_id = null) {
        $result = static::where('status',_active());

        if($designation_type_id) {
            $result = $result->where('designation_type_id', $designation_type_id);
        }
        return $result->orderBy('name','asc')->get();
    }

     public function contact() {
        return $this->hasMany(Contact::class);
    }

    public function designation_type() {
        return $this->belongsTo(DesignationType::class);
    }


}
