<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Tag;
use Hash;
use Illuminate\Support\Facades\Auth as Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'user_type_id',
        'contact_number',
        'country_code',
        'otp',
        'last_otp_verified_at',
        'status',
        'section',
        'designation',
        'facility_hierarchy_id',
        'user_role_id',
        'programs_id',
        'sections_id',
        'designations_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function username()
    {
        return 'email';
    }

    public function getUserData($id)
    {

        return $this->with(['tag'])->find($id);
    }

    public function scopeFilter($query)
    {

        if ($keyword = request('keyword')) {
            $query->where('name', 'like', '%' . $keyword . '%');
            $query->orWhere('contact_number', 'like', '%' . $keyword . '%');
            $query->orWhere('email', 'like', '%' . $keyword . '%');
            $query->orWhere('designation', 'like', '%' . $keyword . '%');
        }
        return $query;
    }


    public static function getQueriedResult()
    {

        $page_length = getPagelength();

        list($sortfield, $sorttype) = getSorting();

        $result = static::with(['tag'])->filter()
            ->when(Auth::user()->user_type_id == _stateAdminUserTypeId(), function ($query) {
                $userProgramsId = Auth::user()->programs_id;
                $query->where(function ($innerQuery) use ($userProgramsId) {
                    $innerQuery->where('programs_id', $userProgramsId) 
                        ->orWhereHas('sections', function ($sectionQuery) use ($userProgramsId) {
                            $sectionQuery->where('programs_id', $userProgramsId);
                        });
                });
            })
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
            })
            ->when(Auth::user()->user_type_id == _hscAdminUserTypeId(), function ($query) {
                $query->whereHas('facility_hierarchy', function ($subQuery) {
                    $subQuery->where('hsc_id', Auth::user()->facility_hierarchy->hsc_id);
                });
            });

        $sortfield = ($sortfield == 'name') ? 'name' : $sortfield;
        $sortfield = ($sortfield == 'contact_number') ? 'contact_number' : $sortfield;
        $sortfield = ($sortfield == 'email') ? 'email' : $sortfield;
        $sortfield = ($sortfield == 'designation') ? 'designation' : $sortfield;

        return $result->orderBy($sortfield, $sorttype)->paginate($page_length);
    }

    public function createHUDUser($hud_data)
    {

        $password = config('constant.default_user_password');
        $username = prepareUsername($hud_data->name . addTrialZero($hud_data->id));
        $input = [
            'name' => $hud_data->name,
            'username' => $username,
            'contact_number' => $hud_data->contact_number ?? null,
            'email' => $hud_data->email ?? null,
            'section' => $hud_data->section ?? '0',
            'designation' => $hud_data->designation ?? null,
            'country_code' => defaultCountryCode(),
            'user_type_id' => _hudUserTypeId(),
            'status' => $hud_data->status,
            'password' => Hash::make($password),
            'is_hud' => _active(),
            'hud_id' => $hud_data->id,
        ];
        return $this->create($input);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'section');
    }

    public function facility_hierarchy()
    {
        return $this->belongsTo(FacilityHierarchy::class, 'facility_hierarchy_id');
    }

    public function designations()
    {
        return $this->belongsTo(Designation::class, 'designations_id');
    }

    public function sections()
    {
        return $this->belongsTo(Section::class, 'sections_id');
    }

    public function programs()
    {
        return $this->belongsTo(Program::class, 'programs_id');
    }
}
