<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContentCertificates extends Model
{
    protected $table = 'site_content_certificates';
     protected $fillable = [
        'site_content_id',
        'image_url',
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

    public static function getSiteContentCertificates($id = '') {
        return static::where('site_content_id', $id)
        ->orderBy('id', 'asc')
        ->get();
    }

    public static function getCertificatesData($id = '') {
        return static::where('site_content_id', $id)
        ->where('status',_active())
        ->orderBy('order_no', 'asc')
        ->get();
    }

    public function site_content(){
        return $this->belongsTo(SiteContent::class,'site_content_id');
    }
}
