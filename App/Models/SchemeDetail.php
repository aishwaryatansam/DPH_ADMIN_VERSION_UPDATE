<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SchemeDetail extends Model
{
    protected $fillable = [
        'schemes_id',
        'description',
        'document_url',
        'image_one',
        'image_two',
        'image_three',
        'image_four',
        'image_five',
        'report_image_one',
        'report_image_two',
        'report_image_three',
        'report_image_four',
        'report_image_five',
        'visible_to_public',
        'status',
        'user_id',
        'approval_stage',
        'remarks',
        'verified_at',
        'approved_at',
        'published_at',
        'icon_url'
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
         return $query;
     }

	 public static function getQueriedResult() {

     	$page_length = getPagelength();

     	list($sortfield,$sorttype) = getSorting();
        
     	$result = static::with(['user', 'scheme', 'approvalWorkflow'])->filter()->when(Auth::user()->user_type_id == _stateAdminUserTypeId(), function ($query) {
            // dd(Auth::user()->user_type_id);
            if (Auth::user()->programs_id) {
                $query->whereHas('scheme', function ($schemeQuery) {
                    $schemeQuery->where('programs_id', Auth::user()->programs_id);
                });
            } else {
                $query->whereHas('scheme', function ($schemeQuery) {
                    $schemeQuery->where('programs_id', Auth::user()->sections->programs_id);
                });
            }
        });

     	$sortfield = ($sortfield == 'name')?'name':$sortfield;
     	

     	return $result->orderBy($sortfield,$sorttype)->get();
     	// return $result->orderBy($sortfield,$sorttype)->paginate($page_length);

    }

    public static function getSchemerGalleryData()
    {
        return static::with([
            'user',
        ])
            ->where('status', _active())
            ->orderBy('id', 'desc')
            ->get();
    }


    public static function getSchemedetailsData() {
        return static::where('status',_active())->orderBy('name','asc')->get();
    }

    public function scheme() {
        return $this->belongsTo(Scheme::class, 'schemes_id')->select('id', 'name', 'programs_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approvalWorkflow()
    {
        return $this->morphOne(ApprovalWorkflows::class, 'model');
    }
}
