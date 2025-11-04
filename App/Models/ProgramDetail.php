<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProgramDetail extends Model
{
    protected $table = 'programdetail';
    protected $fillable = [
        'description',
        'document',
        'image_one',
        'image_two',
        'image_three',
        'image_four',
        'image_five',
        'programs_id',
        'status',
        'visible_to_public',
        'user_id',
            'tag_id',
    'tags',
        'approval_stage',
        'reamrks',
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
        $result = static::with(['user', 'program'])->filter()->when(Auth::user()->user_type_id == _stateAdminUserTypeId(), function ($query) {
            if (Auth::user()->programs_id) {
                $query->where('programs_id', Auth::user()->programs_id);
            } else {
                // dd(Auth::user()->sections->programs_id);
                $query->where('programs_id', Auth::user()->sections->programs_id);
            }
        });

        $sortfield = ($sortfield == 'name') ? 'name' : $sortfield;


        return $result->orderBy($sortfield, $sorttype)->get();
        // return $result->orderBy($sortfield,$sorttype)->paginate($page_length);

    }

    public static function getProgramGalleryData()
    {
        return static::with([
            'user',
        ])
            ->where('status', _active())
            ->orderBy('id', 'desc')
            ->get();
    }

    public static function getProgramdetailsData()
    {
        return static::where('status', _active())->orderBy('id', 'asc')->get();
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'programs_id')->select('id', 'name');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
