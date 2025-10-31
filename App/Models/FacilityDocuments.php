<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacilityDocuments extends Model
{
    protected $table = 'facility_documents';

    protected $fillable = [
        'facility_profile_id',
        'document_url',
        'document_type',
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

        $result = static::with([])->filter();


        $sortfield = ($sortfield == 'name') ? 'name' : $sortfield;


        return $result->orderBy($sortfield, $sorttype)->paginate($page_length);
    }

    public function facility_profile()
    {
        return $this->belongsTo(FacilityProfile::class, 'facility_profile_id');
    }
}
