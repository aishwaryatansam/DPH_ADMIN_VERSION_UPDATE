<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
	 protected $table = 'testimonials';
	 protected $fillable = [
        'name',
        'designation',
        'content',
        'image_url',
        'testimonial_document_url',
        'unique_key',
        'status',
        'qualification',
        'start_year',
        'end_year',
        'is_current_director',
        'role'
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

        $result = static::with([])->filter()->where('is_current_director', 1);

        $sortfield = ($sortfield == 'name')?'name':$sortfield;
        
        

        return $result->orderBy($sortfield,$sorttype)->paginate($page_length);
    }

     public static function getTestimonialData() {

        $testimonial = static::where('status',_active())->where('is_current_director', '1');    

        return $testimonial->orderBy('role','asc')->get();
    }

    public static function getPreviousDirectorData() {

        $testimonial = static::where('status',_active())->where('is_current_director', '0');    

        return $testimonial->orderBy('id','asc')->get();
    }
}
