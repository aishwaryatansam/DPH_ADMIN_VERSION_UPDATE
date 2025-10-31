<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class Navigation extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'order_no', 'slug_key', 'status'];


    public static function getNavigationDocument() {

        return static::with(['documents' => function($query){
            $query->when(Auth::user()->user_type_id == _employeeUserTypeId(), function ($subQuery) {
                $subQuery->where('uploaded_by', Auth::user()->id);
            })->where('status',_active());
        }])->where('status',_active())->orderBy('order_no')->get();

    }

    public function documents(){
        return $this->hasMany(Document::class);
    }

  

}
