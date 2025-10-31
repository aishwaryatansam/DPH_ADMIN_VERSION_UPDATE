<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NewDocument;
use Illuminate\Support\Facades\Auth;

class DocumentType extends Model
{

    protected $table = 'document_type';

    protected $fillable = ['name', 'order_no', 'slug_key', 'status'];


    public static function getDocumentType() {

        return static::with(['new_documents' => function($query){
            $query->when(Auth::user()->user_type_id == _stateAdminUserTypeId(), function ($subQuery) {
                // For state-level admin, only fetch documents uploaded by the logged-in user
                $subQuery->where('user_id', Auth::user()->id);
            })
            ->when(Auth::user()->user_type_id == _districtAdminUserTypeId(), function ($subQuery) {
                $subQuery->whereHas('user', function ($userQuery) {
                    $userQuery->where('user_type_id', _districtAdminUserTypeId());
                });
            
            })
            ->when(Auth::user()->user_type_id == _hudAdminUserTypeId(), function ($subQuery) {
                $subQuery->whereHas('user', function ($userQuery) {
                    $userQuery->where('user_type_id', _hudAdminUserTypeId());
                });
            
            })
            ->when(Auth::user()->user_type_id == _blockAdminUserTypeId(), function ($subQuery) {
                $subQuery->whereHas('user', function ($userQuery) {
                    $userQuery->where('user_type_id', _blockAdminUserTypeId());
                });
            
            })
            ->when(Auth::user()->user_type_id == _phcAdminUserTypeId(), function ($subQuery) {
                $subQuery->whereHas('user', function ($userQuery) {
                    $userQuery->where('user_type_id', _phcAdminUserTypeId());
                });
            
            })
            ->when(Auth::user()->user_type_id == _hscAdminUserTypeId(), function ($subQuery) {
                $subQuery->whereHas('user', function ($userQuery) {
                    $userQuery->where('user_type_id', _hscAdminUserTypeId());
                });
            
            });
        }])->where('status',_active())->orderBy('order_no')->get();

    }

    public function new_documents(){
        return $this->hasMany(NewDocument::class);
    }

}
