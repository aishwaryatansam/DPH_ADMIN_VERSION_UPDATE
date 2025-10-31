<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContentMembers extends Model
{
    protected $table = 'site_content_members';
    protected $fillable = [
        'site_content_id',
        'designations',
        'name',
        'qualification',
        'institution',
        'affiliation',
        'order_no',
        'status',
        'position',
        'is_head'
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
    }

    public static function getSiteContentMembers($id = '')
    {
        return static::where('site_content_id', $id)
            ->orderBy('id', 'asc')
            ->get();
    }

    public static function getSiteContentHeadMembers($id = '')
    {
        return static::where('site_content_id', $id)
            ->where('is_head', '1')
            ->orderBy('id', 'asc')
            ->get();
    }

    public function site_content()
    {
        return $this->belongsTo(SiteContent::class, 'site_content_id');
    }

    public function designations()
    {
        return $this->belongsTo(Designation::class, 'designations_id');
    }

    public static function getMembersData($id)
    {

        $members = static::where('status', _active())->where('site_content_id', $id)->where('is_head', '0');

        return $members->orderBy('order_no', 'asc')->get();
    }

    public static function getHeadMembersData($id)
    {

        $members = static::where('status', _active())->where('site_content_id', $id)->where('is_head', '1');

        return $members->orderBy('order_no', 'asc')->get();
    }
}
