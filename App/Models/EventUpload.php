<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EventUpload extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'document_url',
        'video_url',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    public function scopeFilter($query)
    {
        if ($event_id = request('event_id')) {
            $query->where('event_id', $event_id);
        }

        if ($keyword = request('keyword')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('document_url', 'like', '%' . $keyword . '%')
                    ->orWhere('video_url', 'like', '%' . $keyword . '%');
            });
        }
        if ($date = request('date')) {
            $query->whereDate('created_at', $date);
        }


        return $query;
    }


    public static function getQueriedResult()
    {

        $page_length = getPagelength();

        list($sortfield, $sorttype) = getSorting();
        $result = static::with(['user', 'event', 'approvalWorkflow'])
            ->when(Auth::user()->user_type_id == _stateAdminUserTypeId(), function ($query) {
                if (Auth::user()->programs_id) {
                    $query->whereHas('event.scheme', function ($schemeQuery) {
                        $schemeQuery->where('programs_id', Auth::user()->programs_id);
                    });
                } else {
                    $query->whereHas('event.scheme', function ($schemeQuery) {
                        $schemeQuery->where('programs_id', Auth::user()->sections->programs_id);
                    });
                }
            })
            ->when(Auth::user()->user_type_id == _districtAdminUserTypeId(), function ($query) {
                $query->whereHas('user.facility_hierarchy', function ($subQuery) {
                    $subQuery->where('district_id', Auth::user()->facility_hierarchy->district_id);
                });
            })
            ->when(Auth::user()->user_type_id == _hudAdminUserTypeId(), function ($query) {
                $query->whereHas('user.facility_hierarchy', function ($subQuery) {
                    $subQuery->where('hud_id', Auth::user()->facility_hierarchy->hud_id);
                });
            })
            ->when(Auth::user()->user_type_id == _blockAdminUserTypeId(), function ($query) {
                $query->whereHas('user.facility_hierarchy', function ($subQuery) {
                    $subQuery->where('block_id', Auth::user()->facility_hierarchy->block_id);
                });
            })
            ->when(Auth::user()->user_type_id == _phcAdminUserTypeId(), function ($query) {
                $query->whereHas('user.facility_hierarchy', function ($subQuery) {
                    $subQuery->where('phc_id', Auth::user()->facility_hierarchy->phc_id);
                });
            })
            ->when(Auth::user()->user_type_id == _hscAdminUserTypeId(), function ($query) {
                $query->whereHas('user.facility_hierarchy', function ($subQuery) {
                    $subQuery->where('hsc_id', Auth::user()->facility_hierarchy->hsc_id);
                });
            });
        $sortfield = ($sortfield == 'name') ? 'name' : $sortfield;
        return $result->orderBy('id', 'desc')->get();
    }


    public static function getEventGalleryData()
    {
        return static::with([
            'user',
            'event_images',
            'event'
        ])
            ->where('status', _active())
            ->when(request('event_id'), function ($query) {
                $query->where('event_id', request('event_id'));
            })
            ->when(request('date'), function ($query) {
                $query->where('created_at', request('date'));
            })
            ->orderBy('id', 'desc')
            ->get();
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(NewDocument::class, 'event_id');
    }

    public function event_images()
    {
        return $this->hasMany(EventImages::class, 'event_uploads_id', 'id');
    }

    public function approvalWorkflow()
    {
        return $this->morphOne(ApprovalWorkflows::class, 'model');
    }
}
