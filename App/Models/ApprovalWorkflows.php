<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApprovalWorkflows extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'uploaded_by',
        'phc_verify_id',
        'phc_verify_at',
        'block_verify_id',
        'block_verify_at',
        'block_approve_id',
        'block_approve_at',
        'hud_verify_id',
        'hud_verify_at',
        'hud_approve_id',
        'hud_approve_at',
        'state_verify_id',
        'state_verify_at',
        'state_approve_id',
        'state_approve_at',
        'super_admin_id',
        'returned_user_id',
        'rejected_user_id',
        'current_stage',
        'remarks',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    public static function getQueriedResult($modelType = null, $filterByApprovalStage = null)
    {

        $page_length = getPagelength();

        list($sortfield, $sorttype) = getSorting();
        
        $result = static::with(['user', 'model'])
            ->when($modelType === 'App\Models\EventUpload', function ($query) {
                $query->with('model.event'); 
            })
            ->when($modelType === 'App\Models\FacilityProfile', function ($query) {
                $query->with(['model.facilityDocuments', 'model.facilityImages', 'model.facility_hierarchy']); // Assuming 'facilityDetails' is a relationship of 'FacilityProfile'
            })
            ->when(Auth::user()->user_type_id == _stateAdminUserTypeId(), function ($query) use ($modelType) {
                $userProgramsId = Auth::user()->programs_id;
                if ($userProgramsId) {
                    if ($modelType == 'App\Models\EventUpload') {
                        $query->whereHasMorph('model', [$modelType], function ($morphQuery) use ($userProgramsId) {
                            $morphQuery->whereHas('event.scheme', function ($schemeQuery) use ($userProgramsId) {
                                $schemeQuery->where('programs_id', $userProgramsId);
                            });
                        });
                    } elseif ($modelType == 'App\Models\NewDocument') {
                        $query->whereHasMorph('model', [$modelType], function ($morphQuery) use ($userProgramsId) {
                            $morphQuery->whereHas('scheme', function ($schemeQuery) use ($userProgramsId) {
                                $schemeQuery->where('programs_id', $userProgramsId);
                            });
                        });
                    } elseif ($modelType == 'App\Models\ProgramDetail') {
                        $query->whereHasMorph('model', [$modelType], function ($morphQuery) use ($userProgramsId) {
                            $morphQuery->whereHas('program', function ($programQuery) use ($userProgramsId) {
                                $programQuery->where('programs_id', $userProgramsId);
                            });
                        });
                    } elseif ($modelType == 'App\Models\SchemeDetail') {
                        $query->whereHasMorph('model', [$modelType], function ($morphQuery) use ($userProgramsId) {
                            $morphQuery->whereHas('scheme', function ($schemeQuery) use ($userProgramsId) {
                                $schemeQuery->where('programs_id', $userProgramsId);
                            });
                        });
                    } elseif ($modelType == 'App\Models\Contact') {
                        $query->whereHasMorph('model', [$modelType], function ($morphQuery) use ($userProgramsId) {
                            $morphQuery->whereHas('program', function ($schemeQuery) use ($userProgramsId) {
                                $schemeQuery->where('programs_id', $userProgramsId);
                            });
                        });
                    }
                }
            })
            ->when(Auth::user()->user_role_id == _adminUserRole(), function ($query) {
                $query->where('uploaded_by', Auth::id());
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

            if ($modelType) {
                $result->where('model_type', $modelType);
            }
    
            if ($filterByApprovalStage) {
                $result = $result->whereIn('current_stage', $filterByApprovalStage);
            }

            
        $sortfield = ($sortfield == 'name') ? 'name' : $sortfield;
        $paginatedResult = $result->paginate($page_length);
        $totalCount = $result->count();
        $pendingCount = (clone $result)->whereIn('current_stage', ['hsc_upload', 'phc_upload', 'block_upload', 'hud_upload', 'state_upload'])->count();
        $verifiedCount = (clone $result)->whereIn('current_stage', ['phc_verify', 'block_verify', 'hud_verify', 'state_verify'])->count();
        $approvedCount = (clone $result)->whereIn('current_stage', ['phc_approve', 'block_approve', 'hud_approve', 'state_approve'])->count();
        $pushedCount = (clone $result)->whereIn('current_stage', ['published'])->count();
        $returnedCount = (clone $result)->whereIn('current_stage', ['returned_with_remarks'])->count();
        $rejectedCount = (clone $result)->whereIn('current_stage', ['rejected_with_remarks'])->count();

        return [
            'paginatedResult' => $paginatedResult,
            'totalCount' => $totalCount,
            'verified' => $verifiedCount,
            'approved' => $approvedCount,
            'pending' => $pendingCount,
            'returned' => $returnedCount,
            'rejected' => $rejectedCount,
            'pushed' => $pushedCount,
        ];
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
    public function phcVerifier()
    {
        return $this->belongsTo(User::class, 'phc_verify_id');
    }

    public function blockVerifier()
    {
        return $this->belongsTo(User::class, 'block_verify_id');
    }

    public function blockApprover()
    {
        return $this->belongsTo(User::class, 'block_approve_id');
    }

    public function hudVerifier()
    {
        return $this->belongsTo(User::class, 'hud_verify_id');
    }

    public function hudApprover()
    {
        return $this->belongsTo(User::class, 'hud_approve_id');
    }

    public function stateVerifier()
    {
        return $this->belongsTo(User::class, 'state_verify_id');
    }

    public function stateApprover()
    {
        return $this->belongsTo(User::class, 'state_approve_id');
    }

    public function superAdmin()
    {
        return $this->belongsTo(User::class, 'super_admin_id');
    }

    public function returnedUser()
    {
        return $this->belongsTo(User::class, 'returned_user_id');
    }

    public function rejectedUser()
    {
        return $this->belongsTo(User::class, 'rejected_user_id');
    }

    public function model()
    {
        return $this->morphTo();
    }

    public function document()
    {
        return $this->belongsTo(NewDocument::class, 'model_id')
            ->where('model_type', 'App\Models\NewDocument');
    }
}
