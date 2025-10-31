<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Navigation;
use App\Models\Tag;
use App\Models\Contact;
use App\Models\DocumentType;
use App\Models\NewDocument;
use App\Models\Section;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function dashboard()
    {

        $documentCount = $totalEmployeeCount = $activeEmployeeCount = $inActiveEmployeeCount = $totalContactCount = $activeContactCount = $inActiveContactCount = 0;

        $navigationDocs = $sectionDocs = collect();

        $documentCount = NewDocument::getQueriedResult()->count();
        // dd($documentCount);

        if (isAdmin() || isHud() || isBlock() || isState() || isDistrict() || isPHC() || isHSC()) {
            // $navigationDocs = Navigation::getNavigationDocument();
            $navigationDocs = DocumentType::getDocumentType();
            $sectionDocs = Tag::getTagDocument();
        }
        $navigationDocsJson = $navigationDocs->map(function ($doc) {
            return [
                'name' => $doc->name,
                'document_count' => $doc->new_documents->count(),
                'order_no' => $doc->order_no,
                "status" => $doc->status,
                'created_at' => $doc->created_at,
                'updated_at' => $doc->updated_at,
                'slug_key' => $doc->slug_key,
            ];
        });


        if (isEmployee()) {
            $users = User::whereIn('user_type_id', [_employeeUserTypeId(), _hudUserTypeId(), _stateAdminUserTypeId(), _districtAdminUserTypeId(), _hudAdminUserTypeId(), _blockAdminUserTypeId(), _phcAdminUserTypeId(), _hscAdminUserTypeId()])->select('id', 'status')->get();
            $totalEmployeeCount = $users->count();
            $activeEmployeeCount = $users->where('status', _active())->count();
            $inActiveEmployeeCount = $users->where('status', _inactive())->count();
        } elseif (isHud()) {
            $contacts = Contact::where('hud_id', auth()->user()->hud_id)->whereNull('user_id')->select('id', 'status')->get();
            $totalContactCount = $contacts->count();
            $activeContactCount = $contacts->where('status', _active())->count();
            $inActiveContactCount = $contacts->where('status', _inactive())->count();
        } elseif (isState()) {
            $users = User::whereIn('user_type_id', [_stateAdminUserTypeId()])->select('id', 'status')->get();
            $totalEmployeeCount = $users->count();
            $activeEmployeeCount = $users->where('status', _active())->count();
            $inActiveEmployeeCount = $users->where('status', _inactive())->count();
        } elseif (isDistrict()) {
            $users = User::whereIn('user_type_id', [_districtAdminUserTypeId()])->select('id', 'status')->get();
            $totalEmployeeCount = $users->count();
            $activeEmployeeCount = $users->where('status', _active())->count();
            $inActiveEmployeeCount = $users->where('status', _inactive())->count();
        }
        elseif (isHUD()) {
            $users = User::whereIn('user_type_id', [_hudAdminUserTypeId()])->select('id', 'status')->get();
            $totalEmployeeCount = $users->count();
            $activeEmployeeCount = $users->where('status', _active())->count();
            $inActiveEmployeeCount = $users->where('status', _inactive())->count();
        }
        elseif (isBlock()) {
            $users = User::whereIn('user_type_id', [_blockAdminUserTypeId()])->select('id', 'status')->get();
            $totalEmployeeCount = $users->count();
            $activeEmployeeCount = $users->where('status', _active())->count();
            $inActiveEmployeeCount = $users->where('status', _inactive())->count();
        }
        elseif (isPHC()) {
            $users = User::whereIn('user_type_id', [_phcAdminUserTypeId()])->select('id', 'status')->get();
            $totalEmployeeCount = $users->count();
            $activeEmployeeCount = $users->where('status', _active())->count();
            $inActiveEmployeeCount = $users->where('status', _inactive())->count();
        }
        elseif (isHSC()) {
            $users = User::whereIn('user_type_id', [_hscAdminUserTypeId()])->select('id', 'status')->get();
            $totalEmployeeCount = $users->count();
            $activeEmployeeCount = $users->where('status', _active())->count();
            $inActiveEmployeeCount = $users->where('status', _inactive())->count();
        } 
        else {
            $users = User::whereIn('user_type_id', [_employeeUserTypeId(), _hudUserTypeId(), _stateAdminUserTypeId(), _districtAdminUserTypeId(), _hudAdminUserTypeId(), _blockAdminUserTypeId(), _phcAdminUserTypeId(), _hscAdminUserTypeId()])->select('id', 'status')->get();
            $totalEmployeeCount = $users->count();
            $activeEmployeeCount = $users->where('status', _active())->count();
            $inActiveEmployeeCount = $users->where('status', _inactive())->count();
        }
        // $user_detail = Auth::user();
        return view('admin.dashboard', compact('totalEmployeeCount', 'activeEmployeeCount', 'inActiveEmployeeCount', 'documentCount', 'navigationDocs', 'sectionDocs', 'totalContactCount', 'activeContactCount', 'inActiveContactCount', 'navigationDocsJson'));
    }

    public function userProfile()
    {
        $result = Auth::user();
        return view('admin.profile', compact('result'));
    }

    public function updateUserProfile(Request $request, $id)
    {

        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());
        // dd($request->toArray());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }


        $userProfile = User::find($id);

        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
        ];

        $result = $userProfile->update($input);

        createdResponse("User Profile Updated Successfully");

        return redirect()->route('admin.userProfile');
    }

    public function rules($id = "")
    {

        $rules = array();

        $rules['name'] = 'required|string|max:255';
        $rules['email'] = 'required|email|max:255';
        $rules['contact_number'] = 'required|string|max:15';

        return $rules;
    }
    
    public function messages()
    {
        return [];
    }

    public function attributes()
    {
        return [];
    }
}
