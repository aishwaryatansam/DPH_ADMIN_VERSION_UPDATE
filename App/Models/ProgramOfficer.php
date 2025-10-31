<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramOfficer extends Model
{
    protected $table = 'programofficer';
    protected $fillable = [
        'name',
        'image',
        'qualification',
        'designations_id',
        'programs_id',
        'status',
        'order_no',
        'approval_stage',
        'reamrks',
        'verified_at',
        'approved_at',
        'published_at',
        'level'
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


    public static function getProgramOfficersData() {
        return static::where('status',_active())->orderBy('id','asc')->get();
    }

    public function program() {
        return $this->belongsTo(Program::class, 'schemes_id')->select('id', 'name');
    }

    public function designation() {
        return $this->belongsTo(Designation::class, 'designations_id')->select('id', 'name');
    }
}
