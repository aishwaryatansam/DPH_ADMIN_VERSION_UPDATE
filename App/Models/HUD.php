<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Block;
use App\Models\District;

class HUD extends Model
{
	protected $table = 'huds';

     protected $fillable = [
        'name',
        'status',
        'tags',
        'district_id',
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
	 public function scopeFilter($query) {

         if($keyword = request('keyword')) {
             $query->where('name','like','%'.$keyword.'%');
            } 
        if($district_id = request('district_id')) {
             $query->where('district_id',$district_id);
            }

        if (isHud()){
             $query->where('status', _active())->where('id', auth()->user()->hud_id);
        }
         return $query;
     }

	 public static function getQueriedResult() {

     	$page_length = getPagelength();

     	list($sortfield,$sorttype) = getSorting();

     	$result = static::with(['district'])->filter();

     	$sortfield = ($sortfield == 'name')?'name':$sortfield;
     	

     	return $result->orderBy($sortfield,$sorttype)->get();
     	// return $result->orderBy($sortfield,$sorttype)->paginate($page_length);
    }

    // public static function getHudData($district_id = NULL, $hud_id = NULL) {

    //     $huds = static::with(['hud_contact'=>function($sub){
    //         $sub->with('designation')->whereNotNull('user_id')->where('status',_active());
    //     }])->where('status',_active());

    //     if($district_id) {
    //          $huds =  $huds->where('district_id',$district_id);
    //     }

    //     if($hud_id) {
    //          $huds =  $huds->where('id',$hud_id);
    //     }


    //     // if(isHud()) {
    //     //     $huds =  $huds->where('id',auth()->user()->hud_id);
    //     // }

    //     return $huds->orderBy('name','asc')->get();
    // }

    public static function getHudData($district_id = null, $hud_id = null)
    {
        // Fetch facility hierarchy data for HUDs
        $hudFacilities = FacilityHierarchy::with([
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
        ->where('facility_type_id', 2) // HUD type
        ->where('status', _active());

        // Filter by district ID if provided
        if ($district_id) {
            $hudFacilities->where('district_id', $district_id);
        }

        // Filter by HUD ID if provided
        if ($hud_id) {
            $hudFacilities->where('id', $hud_id);
        }

        return $hudFacilities->orderBy('facility_name', 'asc')->get();
    }

    public static function collectHudData($district_id = null, $hud_id = NULL) {

        $huds = static::with(['hud_contacts'=>function($sub){
            $sub->with('designation')->whereNull('user_id')->whereNotNull('hud_id')->whereNull('block_id')->whereNull('phc_id')->whereNull('hsc_id')->where('status',_active());
        }])->where('status',_active());


        if ($district_id) {
            $huds->where('district_id', $district_id);
        }

        if($hud_id) {
            $huds->where('hud_id',$hud_id);
        }

        return $huds->orderBy('name','asc')->get();
    }





    public static function getHUDChildCountData() {

        return static::select('huds.id','huds.name')->selectRaw('COUNT(cblocks.id) as block_contacts_updated_count,COUNT(cphcs.id) as phc_contacts_updated_count,COUNT(chsc.id) as hsc_contacts_updated_count')
                    ->leftjoin('contacts as cblocks',function($cblocks) {
                        $cblocks->on('cblocks.block_id','blocks.id');
                        $cblocks->whereNull('cblocks.user_id');
                        $cblocks->whereNotNull('cblocks.hud_id');
                        $cblocks->whereNotNull('cblocks.block_id');
                        $cblocks->whereNull('cblocks.phc_id');
                        $cblocks->whereNull('cblocks.hsc_id');
                        $cblocks->whereNull('cblocks.hsc_id');
                        $cblocks->where('cblocks.status',_active());
                    })
                    ->leftjoin('contacts as cphcs',function($cphcs) {
                        $cphcs->on('cphcs.phc_id','p_h_c_s.id');
                        $cphcs->whereNull('cphcs.user_id');
                        $cphcs->whereNotNull('cphcs.hud_id');
                        $cphcs->whereNotNull('cphcs.block_id');
                        $cphcs->whereNotNull('cphcs.phc_id');
                        $cphcs->whereNull('cphcs.hsc_id');
                        $cphcs->where('cphcs.status',_active());
                    })
                    ->leftjoin('contacts as chsc',function($chsc) {
                        $chsc->on('chsc.hsc_id','hsc.id');
                        $chsc->whereNull('chsc.user_id');
                        $chsc->whereNotNull('chsc.hud_id');
                        $chsc->whereNotNull('chsc.block_id');
                        $chsc->whereNotNull('chsc.phc_id');
                        $chsc->whereNotNull('chsc.hsc_id');
                        $chsc->where('chsc.status',_active());
                    })
                    ->where('huds.status',_active())
                    ->groupBy('huds.id','huds.name')
                    ->get();
    }

    public function blocks() {
        return $this->hasMany(Block::class,'hud_id')->where('status',_active());
    }

    public function district() {
        return $this->belongsTo(District::class);
    }

    public function hud_contact() {
        return $this->hasOne(Contact::class,'hud_id')->where('contact_type',_hudContactType());
    }

    public function hud_contacts() 
    {
        return $this->hasMany(Contact::class,'hud_id')->where('contact_type',_hudContactType())->where('status',_active());
    }
}
