<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignationType extends Model
{
    protected $fillable = ['name','slug_key','status'];

    public static function getDesignationTypeData() {
        return static::where('status',_active())->get();
    }

    public static function getDesignationTypeForContactCreateInAdmin() {
        // ->whereIn('slug_key',['state','ivcz'])
        return static::where('status',_active())->get();
    }

    public static function getDesignationTypeForContactCreateInHUD() {
        return static::where('status',_active())->whereIn('slug_key',['hud','block','phc','hsc'])->get();
    }

    public static function getDesignationTypeForContactCreateInState() {
        return static::where('status',_active())->whereIn('slug_key',['state','hud','block','phc','hsc'])->get();
    }

    public static function getDesignationTypeForContactCreateInBlock() {
        return static::where('status',_active())->whereIn('slug_key',['block','phc','hsc'])->get();
    }

    public static function getDesignationTypeForContactCreateInPHC() {
        return static::where('status',_active())->whereIn('slug_key',['phc','hsc'])->get();
    }

    public static function getDesignationTypeForContactCreateInHSC() {
        return static::where('status',_active())->whereIn('slug_key',['hsc'])->get();
    }
}

