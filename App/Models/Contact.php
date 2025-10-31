<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Designation;
use App\Models\DesignationType;
use App\Models\FacilityHierarchy;
use App\Models\HUD;
use App\Models\Block;
use App\Models\PHC;
use App\Models\HSC;
use Illuminate\Support\Facades\Auth;

class Contact extends Model
{
    protected $table = 'contacts';
    protected $fillable = [
        'name',
        'status',
        'designation_id',
        'mobile_number',
        'landline_number',
        'email_id',
        'fax',
        'image_url',
        'location_url',
        'contact_type',
        'hud_id',
        'block_id',
        'phc_id',
        'hsc_id',
        'user_id',
        'is_post_vacant',
        'order_no',
        'facility_id',
        'qualification',
        'programs_id',
        'approval_stage',
        'remarks',
        'verified_at',
        'approved_at',
        'published_at'

    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

	 public function scopeFilter($query) {

         if($keyword = request('keyword')) {
             $query->where('name','like','%'.$keyword.'%');
             $query->orWhere('mobile_number','like','%'.$keyword.'%');
             $query->orWhere('email_id','like','%'.$keyword.'%');
            }
        if($contact_type = request('contact_type')) {
             $query->where('contact_type',$contact_type);
        }

        if(isHud())
        {
            $query->where('hud_id', auth()->user()->hud_id);
        }

         return $query;
    }

	
    public static function getQueriedResult() {

        $page_length = getPagelength();

        list($sortfield, $sorttype) = getSorting();

        $result = static::with(['contactType', 'designation', 'approvalWorkflow'])->filter();

        if (isHud()) {
            $result = $result->where('hud_id', auth()->user()->hud_id)->whereNull('user_id');
        }

        if ($hud_id = request('hud_id')) {
            $result = $result->where('hud_id', $hud_id);
        }
        if ($block_id = request('block_id')) {
            $result = $result->where('block_id', $block_id);
        }
        if ($phc_id = request('phc_id')) {
            $result = $result->where('phc_id', $phc_id);
        }
        if ($hsc_id = request('hsc_id')) {
            $result = $result->where('hsc_id', $hsc_id);
        }

        $result = static::with(['user', 'program'])->filter()
            ->when(Auth::user()->user_type_id == _stateAdminUserTypeId(), function ($query) {
                if (Auth::user()->programs_id) {
                    $query->where('programs_id', Auth::user()->programs_id);
                } else {
                    // dd(Auth::user()->sections->programs_id);
                    $query->where('programs_id', Auth::user()->sections->programs_id);
                }
            })
            ->when(Auth::user()->user_type_id == _districtAdminUserTypeId(), function ($query) {
                $query->whereHas('facility', function ($subQuery) {
                    $subQuery->where('district_id', Auth::user()->facility_hierarchy->district_id);
                });
            })
            ->when(Auth::user()->user_type_id == _hudAdminUserTypeId(), function ($query) {
                $query->whereHas('facility', function ($subQuery) {
                    $subQuery->where('hud_id', Auth::user()->facility_hierarchy->hud_id);
                });
            })
            ->when(Auth::user()->user_type_id == _blockAdminUserTypeId(), function ($query) {
                $query->whereHas('facility', function ($subQuery) {
                    $subQuery->where('block_id', Auth::user()->facility_hierarchy->block_id);
                });
            })
            ->when(Auth::user()->user_type_id == _phcAdminUserTypeId(), function ($query) {
                $query->whereHas('facility', function ($subQuery) {
                    $subQuery->where('phc_id', Auth::user()->facility_hierarchy->phc_id);
                });
            })
            ->when(Auth::user()->user_type_id == _hscAdminUserTypeId(), function ($query) {
                $query->whereHas('facility', function ($subQuery) {
                    $subQuery->where('hsc_id', Auth::user()->facility_hierarchy->hsc_id);
                });
            });


        $sortfield = ($sortfield == 'name') ? 'name' : $sortfield;
        $sortfield = ($sortfield == 'email') ? 'email_id' : $sortfield;


        return $result->orderBy($sortfield, $sorttype)->paginate($page_length);
    }



    public static function getContactData($designation_id = NULL) {
        $contacts = static::select(
            'contacts.id',
            'contacts.name',
            'contacts.designation_id',
            'contacts.mobile_number',
            'contacts.landline_number',
            'contacts.email_id',
            'contacts.fax',
            'contacts.image_url',
            'contacts.location_url',
            'contacts.contact_type',
            'contacts.facility_id',
            'contacts.is_post_vacant',
            'contacts.status',
            'designations.name as designation_name',
            'designations.designation_type_id',
            'designations.order_no',
            'designations.status'
        )
        ->with(['contactType', 'designation', 'facility']) // Eager load relationships
        // ->whereNull('contacts.user_id')
        ->where('contacts.status', _active())
        ->leftJoin('designations', 'contacts.designation_id', '=', 'designations.id');
    
        // // Apply filters based on contact type
        // if ($contact_type = request('contact_type')) {
        //     if ($contact_type == 'state') {
        //         $contacts = $contacts->where('contacts.contact_type', 2);
        //     } elseif ($contact_type == 'hud') {
        //         $contacts = $contacts->where('contacts.contact_type', 4);
        //         if ($hud_id = request('contact_sub_type')) {
        //             $facility_ids = FacilityHierarchy::where('hud_id', $hud_id)->pluck('id');
        //             $contacts = $contacts->whereIn('contacts.facility_id', $facility_ids);
        //         }
        //     } elseif ($contact_type == 'block') {
        //         $contacts = $contacts->where('contacts.contact_type', 8);
        //         if ($hud_id = request('contact_sub_type')) {
        //             $block_ids = Block::getBlockId($hud_id); // You may need to adjust this based on `facility` mapping.
        //             $facility_ids = FacilityHierarchy::whereIn('block_id', $block_ids)->pluck('id');
        //             $contacts = $contacts->whereIn('contacts.facility_id', $facility_ids);
        //         }
        //     } elseif ($contact_type == 'ivcz') {
        //         $contacts = $contacts->where('contacts.contact_type', 5);
        //     }
        // }

        // Filter by designation ID if provided
        if ($designation_id) {
            $contacts = $contacts->where('contacts.designation_id', $designation_id);
        }

        // Return ordered results
        return $contacts->orderBy('contacts.order_no')
            ->orderBy('designations.order_no', 'asc')
            ->get();
    }


    public function createNewHUDContact($hud_data, $user) {

        $contact_type = DesignationType::where('slug_key', 'hud')->first();
        $contact_type = DesignationType::where('slug_key', 'hud')->first();

        $input = [
            "status" => _active(),
            "contact_type" => $contact_type->id,
            "hud_id" => $hud_data->id,
            "mobile_number" => '-----',
            "landline_number" => '-----',
            "email_id" => '-----',
            "fax" => '-----',
            "location_url" => '-----',
            'name' => $user->name,
            'user_id' => $user->id,
            'is_post_vacant' => 0,
        ];

        $this->create($input);
    }

    public static function isHUdSelfUpdateCompleted($user_id)
    {

        return static::where('user_id', $user_id)->where('mobile_number', '-----')->where('email_id', '-----')->count();
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function hud()
    {
        return $this->belongsTo(HUD::class);
    }
    public function block()
    {
        return $this->belongsTo(Block::class);
    }
    public function phc()
    {
        return $this->belongsTo(PHC::class);
    }
    public function hsc()
    {
        return $this->belongsTo(HSC::class);
    }

    public function contactType()
    {
        return $this->belongsTo(DesignationType::class, 'contact_type');
    }

    public function facility()
    {
        return $this->belongsTo(FacilityHierarchy::class, 'facility_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'programs_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approvalWorkflow()
    {
        return $this->morphOne(ApprovalWorkflows::class, 'model');
    }


    public static function isHscContactExist($hsc_id)
    {

        $hsc_count = Contact::where('hsc_id', $hsc_id)->where('status', _active())->count();


        return $hsc_count;
    }
}
