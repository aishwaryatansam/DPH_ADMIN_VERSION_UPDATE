<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacilityLevel extends Model
{
    protected $table = 'facility_level';
    public $fillable = ['name'];

    public static function getFacilityLevelData(){
        return self::query()->whereIn('id', [1, 2, 3, 4, 5, 6])->get();
    }
}
