<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PHC;
use App\Models\hsc;
use App\Models\BLOCK;
use App\Models\STATE;
use App\Models\Country;
use App\Models\District;
use App\Models\HUD;
use App\Models\FacilityLevel;
use phpDocumentor\Reflection\Types\Null_;

class FacilityHierarchy extends Model
{
    protected $table = 'facility_hierarchy';

    protected $fillable = [
        'facility_name',
        'facility_code',
        'facility_level_id',
        'facility_type_id',
        'country_id',
        'state_id',
        'district_id',
        'hud_id',
        'block_id',
        'phc_id',
        'hsc_id',
        'status',
        'area_type'
    ];
    public function scopeFilter($query)
    {

        if ($keyword = request('keyword')) {
            $query->where('facility_name', 'like', '%' . $keyword . '%');
        }

        if ($facility_level_id = request('facility_level_id')) {
            $query->where('facility_level_id', $facility_level_id); // Added filter for facility_level_id
        }
        return $query;
    }

    public static function getQueriedResult()
    {
        $page_length = getPagelength();

        list($sortfield, $sorttype) = getSorting();
        // dd('hiiii');

        $result = static::with([])->filter();

        if($hud_id = request('hud_id')) {
            $result = $result->where('hud_id',$hud_id);
        } 
        if($block_id = request('block_id')) {
            $result = $result->where('block_id',$block_id);
        } 
        if($phc_id = request('phc_id')) {
            $result = $result->where('phc_id',$phc_id);
        }
        if($hsc_id = request('hsc_id')) {
            $result = $result->where('hsc_id',$hsc_id);
        }

        $sortfield = ($sortfield == 'name') ? 'name' : $sortfield;


        return $result->orderBy($sortfield, $sorttype)->paginate($page_length);
    }

    public static function getFacilityHierarchyData($filters = []) {

        $query = static::where('status', _active())->orderBy('facility_name', 'asc');

        if (!empty($filters['facility_level_id'])) {
            $query->where('facility_level_id', $filters['facility_level_id']);
        }

        if (!empty($filters['facility_type_id'])) {
            $query->where('facility_type_id', $filters['facility_type_id']);
        }
    
        if (!empty($filters['district_id'])) {
            $query->where('district_id', $filters['district_id']);
        }
    
        if (!empty($filters['hud_id'])) {
            $query->where('hud_id', $filters['hud_id']);
        }
    
        if (!empty($filters['block_id'])) {
            $query->where('block_id', $filters['block_id']);
        }
    
        if (!empty($filters['phc_id'])) {
            $query->where('phc_id', $filters['phc_id']);
        }
    
        if (!empty($filters['hsc_id'])) {
            $query->where('hsc_id', $filters['hsc_id']);
        }
    
        return $query->get();
    }

    public function facility_type()
    {
        return $this->belongsTo(FacilityType::class, 'facility_type_id');
    }

    public function facility_level()
    {
        return $this->belongsTo(FacilityLevel::class, 'facility_level_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function hud()
    {
        return $this->belongsTo(Hud::class, 'hud_id');
    }

    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id');
    }

    public function phc()
    {
        return $this->belongsTo(Phc::class, 'phc_id');
    }

    public function hsc()
    {
        return $this->belongsTo(Hsc::class, 'hsc_id');
    }

    public function facilityProfile()
    {
        return $this->hasOne(FacilityProfile::class, 'facility_hierarchy_id')
                    ->where('status', _active());
    }
}
