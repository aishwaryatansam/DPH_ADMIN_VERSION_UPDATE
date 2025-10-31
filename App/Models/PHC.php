<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HSC;
use App\Models\Block;
use App\Models\Contact;
use App\Models\FacilityType;

class PHC extends Model
{
	protected $table = 'p_h_c_s';
	protected $fillable = [
        'name',
        'status',
        'block_id',
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
            $query->where('block_id',$block_id);
        }


         return $query;
     }

	 public static function getQueriedResult() {

     	$page_length = getPagelength();

     	list($sortfield,$sorttype) = getSorting();

     	$result = static::with([])->filter();

        if (isHud()){
            $block_ids = Block::getBlockId(auth()->user()->hud_id);
            $result = $result->whereIn('block_id', $block_ids);

        }

     	$sortfield = ($sortfield == 'name')?'name':$sortfield;


     	

     	// return $result->orderBy($sortfield,$sorttype)->paginate($page_length);
        return $result->orderBy($sortfield,$sorttype)->get();
    }
     public static function getPhcData($block_id = NULL) {

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
        ->where('facility_type_id', 4) // HUD type
        ->where('status', _active());

        // Filter by Block ID if provided
        if ($block_id) {
            $phcFacilities->where('block_id', $block_id);
        }

        return $phcFacilities->orderBy('facility_name', 'asc')->get();
    }

    public static function collectPhcData($block_id = NULL) {

        $phcs = static::with(['phc_contacts'=>function($sub){
            $sub->with('designation')->whereNull('user_id')->whereNotNull('hud_id')->whereNotNull('block_id')->whereNotNull('phc_id')->whereNull('hsc_id')->where('status',_active());
        }])->where('status',_active());

        if($block_id) {
             $phcs =  $phcs->where('block_id',$block_id);
        }

        return $phcs->orderBy('name','asc')->get();
    }

    public static function getPhcId(Array $block_ids){
        
       return static::whereIn('block_id', $block_ids)->where('status', _active())->pluck('id')->toArray();
    }

    public function hscs() {
        return $this->hasMany(HSC::class,'phc_id');
    }

    public function block() {
        return $this->belongsTo(Block::class);
    }

    public function phc_contact() {
        return $this->hasOne(Contact::class,'phc_id')->where('contact_type', _phcContactType())->whereHas('designation', function ($query) {
                $query->where('name', 'phc medical officer');
            });
    }

    public function phc_contacts() {
        return $this->hasMany(Contact::class,'phc_id')->where('status',_active())->where('contact_type',_phcContactType())->whereHas('designation', function ($query) {
                $query->where('name','!=', 'phc medical officer')->orderBy('name');
            });
    }

    public function phc_contacts_report() {
        return $this->hasMany(Contact::class,'phc_id')->where('status',_active())->where('contact_type',_phcContactType());
    }

    // public function facility_type() {
    //     return $this->hasOne(FacilityType::class,'phc_id');
    // }
}
