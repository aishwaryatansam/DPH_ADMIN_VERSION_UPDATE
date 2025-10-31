<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tag extends Model
{
    protected $fillable = ['name', 'slug_key', 'status'];

    public static function getTagDocument() {

        return static::with(['documents' =>function($query){
            $query->when(Auth::user()->user_type_id == _employeeUserTypeId(), function ($subQuery) {
                $subQuery->where('uploaded_by', Auth::user()->id);
            })->where('status',_active());
        }])->where('status',_active())->orderBy('name')->get();

    }

    public function documents(){
        return $this->hasMany(Document::class, 'tag_id');
    }
}
