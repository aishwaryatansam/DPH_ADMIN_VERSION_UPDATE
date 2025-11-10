<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PHC;


class HSC extends Model
{
	protected $table = 'hsc';

     protected $fillable = [
        'name',
        'status',
        // 'tags',
        'phc_id',
        'image_url',
        'location_url',
        'video_url',
        'is_urban',
        'property_document_url'
        
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
	if($block_id = request('block_id')) {
	    $phc_ids = PHC::getPhcId([$block_id]);
            $query->whereIn('phc_id',$phc_ids);
        }
        if($phc_id = request('phc_id')) {
            $query->where('phc_id',$phc_id);
        }
        return $query;
    }

	public static function getQueriedResult() {

     	$page_length = getPagelength();

     	list($sortfield,$sorttype) = getSorting();

     	$result = static::with([])->filter();

        if (isHud()){
            $block_ids = Block::getBlockId(auth()->user()->hud_id);
            $phc_ids = PHC::getPhcId($block_ids);
            $result = $result->whereIn('phc_id', $phc_ids);

        }

     	$sortfield = ($sortfield == 'name')?'name':$sortfield;
     	

     	// return $result->orderBy($sortfield,$sorttype)->get();
     	return $result->orderBy($sortfield,$sorttype)->paginate($page_length);

    }

    public static function getHscData($phc_id = NULL) {

        $phcFacilities = FacilityHierarchy::with([
            'facilityProfile' => function ($query) {
                $query->where('status', _active())
                    ->with(['images' => function ($imageQuery) {
                        $imageQuery->where('status', _active());
                    }, 'documents' => function ($docQuery) {
                        $docQuery->where('status', _active());
                    }]);
            },
            'facility_level'
        ])
        ->where('facility_type_id', 5) 
        ->where('status', _active());

        if ($phc_id) {
            $phcFacilities->where('phc_id', $phc_id);
        }

        return $phcFacilities->orderBy('facility_name', 'asc')->get();
    }

    public static function collectHscData($phc_id = NULL) {

        $hscs = static::with(['hsc_contacts'=>function($sub){
            $sub->with('designation')->whereNull('user_id')->whereNotNull('hud_id')->whereNotNull('block_id')->whereNotNull('phc_id')->whereNotNull('hsc_id')->where('status',_active());
        }])->where('status',_active());

        if($phc_id) {
             $hscs =  $hscs->where('phc_id',$phc_id);
        }

        return $hscs->orderBy('name','asc')->get();
    }

    

    public function phc() {
        return $this->belongsTo(PHC::class);
    }

    public function hsc_contact() {
        return $this->hasOne(Contact::class,'hsc_id')
                    ->where('contact_type', _hscContactType());
    }

    public function hsc_contacts() {
        return $this->hasMany(Contact::class,'hsc_id')->where('status',_active())->where('contact_type',_hscContactType());
    }


}
