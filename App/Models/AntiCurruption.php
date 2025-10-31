<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntiCurruption extends Model
{
    protected $table = 'anti_curruption';
    protected $fillable = [

        'tamildescription',
        'englishdescription',
        'tamiladdress',
        'englishaddress',
        'website',
        'fax_number',
        'phone_number',
        'status',

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

    public function scopeFilter($query) {

        if($keyword = request('keyword')) {
            $query->where('description','like','%'.$keyword.'%');
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
}
