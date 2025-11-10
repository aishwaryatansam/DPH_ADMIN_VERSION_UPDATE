<?php

namespace App\Models;

use App\Models\Scheme;
use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Master;

class NewDocument extends Model
{
    // use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'document_url',
        'document_type_id',
        'name',
        'section_id',
        'user_id',
        'status',
        'visible_to_public',
        'reference_no',
        'dated',
        'image_url',
        'description',
        'scheme_id',
        'link',
        'link_title',
        'publication_type_id',
        'notification_type_id',
        'event_type_id',
        'expiry_date',
        'start_date',
        'end_date',
        'financial_year',
        'language_id',
        'tags',
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


    /**
     * @param $query
     * @return mixed
     */

    // public function getUpdatedAtAttribute($date)
    // {
    //     return convertUTCToLocal($date);
    // }
    public function scopeFilter($query)
    {

        if ($keyword = request('keyword')) {
            $query->where('name', 'like', '%' . $keyword . '%');
            $query->orWhere('reference_no', 'like', '%' . $keyword . '%');
        }

        if ($document_type = request('document_type')) {
            $query->where('document_type_id', $document_type);
        }

        if ($section = request('section')) {
            $query->where('section_id', $section);
        }

        if ($from = request('from')) {
            $query->whereDate('dated', '>=', dateOf($from, 'Y-m-d'));
        }

        if ($to = request('to')) {
            $query->whereDate('dated', '<=', dateOf($to, 'Y-m-d'));
        }
        if ($visible_to_public = request('visible_to_public')) {
            $query->when($visible_to_public == 'yes', function ($sub) {
                $sub->where('visible_to_public', _active());
            });
            $query->when($visible_to_public == 'no', function ($sub) {
                $sub->where('visible_to_public', _inactive());
            });
        }
        if ($status = request('status')) {
            $query->when($status == 'Active', function ($sub) {
                $sub->where('status', _active());
            });
            $query->when($status == 'InActive', function ($sub) {
                $sub->where('status', _inactive());
            });
        }
        if (isHud()) {
            $query->where('status', _active())->where('visible_to_public', _active());
        }

        return $query;
    }

    /**
     * @param $id
     */
    public function getDocument($id)
    {

        $result = $this->with('document_type', 'user', 'section', 'publication', 'notification')->find($id);
        return $result;
    }

    /**
     * @return mixed
     */
    public static function getQueriedResult($additionalFilters = null)
    {

        $page_length = getPagelength();

        list($sortfield, $sorttype) = getSorting();
        $result = static::with(['document_type', 'user', 'approvalWorkflow', 'section', 'scheme.program'])->filter();

        $user = Auth::user();
        if ($user) {
            switch ($user->user_role_id) {
                case '3':
                    $result = $result->where('user_id', $user->id);
                    break;

                case '2':
                    if ($user->user_type_id == 2) {
                        $userDistrictId = $user->facility_hierarchy->district_id; // Get the district ID of the logged-in user
                        // dd($userDistrictId);
                        $result = $result->where(function ($q) use ($user, $userDistrictId) {
                            $q->where('user_id', $user->id) // Include documents directly owned by the user
                                ->orWhereHas('facility_hierarchy', function ($query) use ($userDistrictId) {
                                    $query->where('district_id', $userDistrictId); // Match district ID with the logged-in user's district
                                });
                        });
                    }
                    if ($user->user_type_id == 3) {

                        // dd($userDistrictId);
                        $result = $result->where(function ($query) {
                            $userHudId = Auth::user()->facility_hierarchy->hud_id; // Get the district ID of the logged-in user
                            $query->whereHas('user', function ($userQuery) use ($userHudId) {
                                $userQuery->whereHas('facility_hierarchy', function ($facilityQuery) use ($userHudId) {
                                    $facilityQuery->where('hud_id', $userHudId);
                                });
                            });
                        });
                    }
                    if ($user->user_type_id == 4) {
                        $result = $result->where(function ($query) {
                            $userBlockId = Auth::user()->facility_hierarchy->block_id; // Get the district ID of the logged-in user
                            $query->whereHas('user', function ($userQuery) use ($userBlockId) {
                                $userQuery->whereHas('facility_hierarchy', function ($facilityQuery) use ($userBlockId) {
                                    $facilityQuery->where('block_id', $userBlockId);
                                });
                            });
                        });
                    }
                    if ($user->user_type_id == 5) {
                        // dd($userDistrictId);
                        $result = $result->where(function ($query) {
                            $userPHCkId = Auth::user()->facility_hierarchy->phc_id; // Get the district ID of the logged-in user
                            $query->whereHas('user', function ($userQuery) use ($userPHCkId) {
                                $userQuery->whereHas('facility_hierarchy', function ($facilityQuery) use ($userPHCkId) {
                                    $facilityQuery->where('phc_id', $userPHCkId);
                                });
                            });
                        });
                    }
                    if ($user->user_type_id == 6) {
                        // dd($userDistrictId);
                        $result = $result->where(function ($query) {
                            $userHSCId = Auth::user()->facility_hierarchy->hsc_id; // Get the district ID of the logged-in user
                            $query->whereHas('user', function ($userQuery) use ($userHSCId) {
                                $userQuery->whereHas('facility_hierarchy', function ($facilityQuery) use ($userHSCId) {
                                    $facilityQuery->where('hsc_id', $userHSCId);
                                });
                            });
                        });
                    }
                    if ($user->user_type_id == 1) {
                        $result = $result->where(function ($q) use ($user) {
                            $q->where('user_id', $user->id)
                                ->orWhereHas('scheme', function ($query) use ($user) {
                                    $query->where('programS_id', $user->programs_id);
                                });
                        });
                    }
                    break;

                case '1':
                    if ($user->user_type_id == 2) {
                        // dd($userDistrictId);
                        $result = $result->where(function ($query) {
                            $userDistrictId = Auth::user()->facility_hierarchy->district_id; // Get the district ID of the logged-in user
                            $query->whereHas('user', function ($userQuery) use ($userDistrictId) {
                                $userQuery->whereHas('facility_hierarchy', function ($facilityQuery) use ($userDistrictId) {
                                    $facilityQuery->where('district_id', $userDistrictId);
                                });
                            });
                        });
                    }
                    if ($user->user_type_id == 3) {
                        // dd($userDistrictId);
                        $result = $result->where(function ($query) {
                            $userHudId = Auth::user()->facility_hierarchy->hud_id; // Get the district ID of the logged-in user
                            $query->whereHas('user', function ($userQuery) use ($userHudId) {
                                $userQuery->whereHas('facility_hierarchy', function ($facilityQuery) use ($userHudId) {
                                    $facilityQuery->where('hud_id', $userHudId);
                                });
                            });
                        });
                    }
                    if ($user->user_type_id == 4) {
                        // dd($userDistrictId);
                        $result = $result->where(function ($query) {
                            $userBlockId = Auth::user()->facility_hierarchy->block_id; // Get the district ID of the logged-in user
                            $query->whereHas('user', function ($userQuery) use ($userBlockId) {
                                $userQuery->whereHas('facility_hierarchy', function ($facilityQuery) use ($userBlockId) {
                                    $facilityQuery->where('block_id', $userBlockId);
                                });
                            });
                        });
                    }
                    if ($user->user_type_id == 5) {
                        // dd($userDistrictId);
                        $result = $result->where(function ($query) {
                            $userPHCkId = Auth::user()->facility_hierarchy->phc_id; // Get the district ID of the logged-in user
                            $query->whereHas('user', function ($userQuery) use ($userPHCkId) {
                                $userQuery->whereHas('facility_hierarchy', function ($facilityQuery) use ($userPHCkId) {
                                    $facilityQuery->where('phc_id', $userPHCkId);
                                });
                            });
                        });
                    }
                    if ($user->user_type_id == 6) {
                        // dd($userDistrictId);
                        $result = $result->where(function ($query) {
                            $userHSCId = Auth::user()->facility_hierarchy->hsc_id; // Get the district ID of the logged-in user
                            $query->whereHas('user', function ($userQuery) use ($userHSCId) {
                                $userQuery->whereHas('facility_hierarchy', function ($facilityQuery) use ($userHSCId) {
                                    $facilityQuery->where('hsc_id', $userHSCId);
                                });
                            });
                        });
                    }
                    if ($user->user_type_id == 1) {
                        $result = $result->where(function ($q) use ($user) {
                            $q->where('user_id', $user->id)
                                ->orWhereHas('scheme', function ($query) use ($user) {
                                    $query->where('programs_id', $user->program_id);
                                })
                                ->orWhereHas('user', function ($query) {
                                    $query->whereIn('user_role_id', ['2', '3']);
                                });
                        });
                    }
                    break;

                case 'super_admin':
                    break;

                default:
                    break;
            }
        }

        if ($additionalFilters) {
            foreach ($additionalFilters as $filter) {
                $result = $result->whereHas($filter['relation'], $filter['callback']);
            }
        }
        $sortfield = ($sortfield == 'name') ? 'name' : $sortfield;
        // dd($result);
        // dd($result->toSql(), $result->getBindings());
        return $result->orderBy('id', 'desc')->get();
    }

    public static function getNavigationDocument($navigationId = '')
    {
        return static::with([
                'document_type',
                'upload_events' => function ($query) {
                    $query->where('status', _active())->with('event_images');
                }
            ])
            ->where('status', _active())
            // ->where('visible_to_public', _active())
            ->when(request('section_id'), function ($query) {
                $query->where('section_id', request('section_id'));
            })
            ->when($navigationId, function ($query) use ($navigationId) {
                $query->where('document_type_id', $navigationId);
            })
            ->orderBy('id', 'desc')
            ->get();
    }
    /**
     * @return mixed
     */
    public function document_type()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class,  'section_id');
    }
    public function scheme()
    {
        return $this->belongsTo(Scheme::class, 'scheme_id');
    }

    public function language()
    {
        return $this->belongsTo(Master::class, 'language_id');
    }

    public function publication()
    {
        return $this->belongsTo(Master::class, 'publication_type_id');
    }

    public function notification()
    {
        return $this->belongsTo(Master::class, 'notification_type_id');
    }

    public function event()
    {
        return $this->belongsTo(Master::class, 'event_type_id');
    }


    public function upload_events()
    {
        return $this->hasMany(EventUpload::class, 'event_id', 'id')->with(['event_images', 'user.facility_hierarchy']);
    }
    public function approvalWorkflow()
    {
        return $this->morphOne(ApprovalWorkflows::class, 'model');
    }
}
