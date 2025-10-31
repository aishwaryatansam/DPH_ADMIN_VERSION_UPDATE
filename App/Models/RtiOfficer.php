<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RtiOfficer extends Model
{
    protected $fillable = [
        'title',
        'name',
        'email',
        'mobile_number',
        'landline_number',
        'extn',
        'fax',
        'address',
        'designations_id',
        'status'
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

    public function scopeFilter($query)
    {

        if ($keyword = request('keyword')) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }
        return $query;
    }

    public static function getQueriedResult()
    {

        $page_length = getPagelength();

        list($sortfield, $sorttype) = getSorting();

        $result = static::with([])->filter();

        $sortfield = ($sortfield == 'name') ? 'name' : $sortfield;


        return $result->orderBy($sortfield, $sorttype)->get();
        // return $result->orderBy($sortfield,$sorttype)->paginate($page_length);

    }


    public static function getRtiOffersData()
    {
        $query = static::where('status', _active());
        return $query->orderBy('name', 'asc')->get();
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designations_id')->select('id', 'name');
    }

    // In RtiOfficer model
public function latestPdf()
{
    return $this->hasOne(RTI_PDF::class)->latest();  // Assuming latest() sorts by upload_date or created_at
}

}
