<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
    protected $table = 'submenu';
    protected $fillable = [
        'name',
        'configuration_content_type_id',
        'slug',
        'order',
        'status',
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

    public function configuration_content_type(){
        return $this->belongsTo(ConfigurationContentType::class,'configuration_content_type_id');
    }

    public static function getSubmenuData($id = '')  {
        
        return static::where('status', _active())
        ->where('configuration_content_type_id', $id)
        ->orderBy('id', 'asc')
        ->get();
    }
}
