<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    protected $table = 'site_content';
    protected $fillable = [
        'name',
        'configuration_content_type_id',
        'submenu_id',
        'description',
        'thumbnail_name',
        'souvenir_name',
        'image_url',
        'document_url',
        'status',
        'visible_to_public',
        'order_no',
        'contact_description',
        'scroller_notification_name',
        'scroller_notification_link',  
        'email',
        'volume',
        'issue',
        'date'
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

    public function submenu(){
        return $this->belongsTo(Submenu::class,'submenu_id');
    }

    public static function getSiteContentData($id = '')  {
        
        return static::where('status', _active())
        ->where('configuration_content_type_id', $id)
        ->orderBy('id', 'asc')
        ->first();
    }

    public static function getManySiteContentData($id = '')  {
        
        return static::where('status', _active())
        ->where('configuration_content_type_id', $id)
        ->orderBy('order_no', 'asc')
        ->get();
    }
}
