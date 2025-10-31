<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PHC;
use App\Models\HUD;
use App\Models\Contact;

class Block extends Model
{
	protected $table = 'blocks';
	 protected $fillable = [
        'name',
        'status',
        'hud_id',
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

             if($hud_id = request('hud_id')) {
             $query->where('hud_id',$hud_id);
            }

        if (isHud()){
             $query->where('status', _active())->where('hud_id', auth()->user()->hud_id);
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

    public static function getBlockData($hud_id = NULL) {

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
        ->where('facility_type_id', 3)
        ->where('status', _active());

        if ($hud_id) {
            $phcFacilities->where('hud_id', $hud_id);
        }

        return $phcFacilities->orderBy('facility_name', 'asc')->get();
    }

    public static function collectBlockData($hud_id = NULL) {

        $blocks = static::with(['block_contacts'=>function($sub){
            $sub->with('designation')->whereNull('user_id')->whereNotNull('hud_id')->whereNotNull('block_id')->whereNull('phc_id')->whereNull('hsc_id')->where('status',_active());
        }])->where('status',_active());

        if($hud_id) {
             $blocks =  $blocks->where('hud_id',$hud_id);
        }

        return $blocks->orderBy('name','asc')->get();
    }

    public static function getBlockCountReport()
    {
        return static::with(['hud','block_contacts'])->where('status',_active())->orderBy('name')->get();
    }

    public static function getBlockId($hud_id){
        
       return static::where('hud_id', $hud_id)->where('status', _active())->pluck('id')->toArray();
    }

    public function phcs() {
        return $this->hasMany(PHC::class,'block_id');
    }

    public function hud() {
        return $this->belongsTo(HUD::class);
    }

    // public function block_contact() {
    //     return $this->hasOne(Contact::class,'block_id')->where('contact_type',_blockContactType());
    // }

    public function block_contact() {
        return $this->hasOne(Contact::class, 'block_id')
            ->where('contact_type', _blockContactType())
            ->whereHas('designation', function ($query) {
                $query->where('name', 'block medical officer');
            });
    }

    public function block_contacts() {
        return $this->hasMany(Contact::class,'block_id')->where('status',_active())->where('contact_type',_blockContactType())
            ->whereHas('designation', function ($query) {
                $query->where('name','!=', 'block medical officer')->orderBy('name');
            });
    }

    public function block_contacts_report() {
        return $this->hasMany(Contact::class,'block_id')->where('status',_active())->where('contact_type',_blockContactType());
    }
}
