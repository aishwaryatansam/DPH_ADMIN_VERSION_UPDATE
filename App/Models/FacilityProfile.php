<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FacilityProfile extends Model
{
    protected $table = 'facility_profile';

    protected $fillable = [
        'facility_hierarchy_id',
        'address_line1',
        'address_line2',
        'pincode',
        'latitude',
        'longitude',
        'video_url',
        'abdm_facility_number',
        'nin_number',
        'picme',
        'hmis',
        'mobile_number',
        'landline_number',
        'email_id',
        'fax',
        'area_type',
        'user_id',
        'location_url',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    public function getCreatedAtAttribute($date)
    {
        return convertUTCToLocal($date);
    }

    public function getUpdatedAtAttribute($date)
    {
        return convertUTCToLocal($date);
    }

    public function scopeFilter($query)
    {

        $query->whereHas('facility_hierarchy', function ($query) {
            $query->where('status', 1);
        });

        if ($keyword = request('keyword')) {
            $query->where('facility_name', 'like', '%' . $keyword . '%');
        }

        if ($facility_level_id = request('facility_level_id')) {
            $query->where('facility_level_id', $facility_level_id); // Added filter for facility_level_id
        }
        return $query;
    }

    public static function getQueriedResult($filterByApprovalStage = null)
    {
        $page_length = getPagelength();

        list($sortfield, $sorttype) = getSorting();

        $result = static::with(['facilityImages', 'facilityDocuments', 'contacts'])->where('status', _active())->filter()
            ->when(Auth::user()->user_type_id == _districtAdminUserTypeId(), function ($query) {
                $query->whereHas('facility_hierarchy', function ($subQuery) {
                    $subQuery->where('district_id', Auth::user()->facility_hierarchy->district_id);
                });
            })
            ->when(Auth::user()->user_type_id == _hudAdminUserTypeId(), function ($query) {
                $query->whereHas('facility_hierarchy', function ($subQuery) {
                    $subQuery->where('hud_id', Auth::user()->facility_hierarchy->hud_id);
                });
            })
            ->when(Auth::user()->user_type_id == _blockAdminUserTypeId(), function ($query) {
                $query->whereHas('facility_hierarchy', function ($subQuery) {
                    $subQuery->where('block_id', Auth::user()->facility_hierarchy->block_id);
                });
            })
            ->when(Auth::user()->user_type_id == _phcAdminUserTypeId(), function ($query) {
                $query->whereHas('facility_hierarchy', function ($subQuery) {
                    $subQuery->where('phc_id', Auth::user()->facility_hierarchy->phc_id);
                });
            })->when(Auth::user()->user_type_id == _hscAdminUserTypeId(), function ($query) {
                $query->whereHas('facility_hierarchy', function ($subQuery) {
                    $subQuery->where('hsc_id', Auth::user()->facility_hierarchy->hsc_id);
                });
            });



        $sortfield = in_array($sortfield, ['name', 'id']) ? $sortfield : 'id';
        $result = $result->orderBy($sortfield, $sorttype);





        $paginatedResult = $result->paginate($page_length);

        // dd($result->toSql());


        return [
            'paginatedResult' => $paginatedResult,
        ];
    }

    public function facility_hierarchy()
    {
        return $this->belongsTo(FacilityHierarchy::class, 'facility_hierarchy_id');
    }

    public function facilityBuilding()
    {
        return $this->hasOne(FacilityBuildingDetails::class, 'facility_profile_id');
    }

    public function facilityImages()
    {
        return $this->hasMany(FacilityImages::class);
    }

    public function facilityDocuments()
    {
        return $this->hasMany(FacilityDocuments::class);
    }

    public function images()
    {
        return $this->hasMany(FacilityImages::class, 'facility_profile_id')
                    ->where('status', _active());
    }

    public function documents()
    {
        return $this->hasMany(FacilityDocuments::class, 'facility_profile_id')
                    ->where('status', _active());
    }

    public function contacts()
    {
        return $this->hasOneThrough(
            Contact::class,
            FacilityHierarchy::class,
            'id',
            'facility_id',
            'facility_hierarchy_id',
            'id'
        );
    }
}
