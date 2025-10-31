<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Exports\CustomersExport;
use App\Models\Block;
use App\Models\Designation;
use App\Models\DesignationType;
use App\Models\District;
use App\Models\FacilityHierarchy;
use App\Models\FacilityLevel;
use App\Models\HSC;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Tag;
use App\Models\HUD;
use App\Models\PHC;
use App\Models\Program;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = User::getQueriedResult();
        // $results = User::all(); 


        return view('admin.employees.list', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = Auth::user();
        $statuses = _getGlobalStatus();
        $allUserTypes = getUserType();
        $allFacilityLevels = FacilityLevel::getFacilityLevelData();
        $userRoles = getUserRole();
        // dd($userTypes);
        $facilities = FacilityHierarchy::getFacilityHierarchyData();
        $programs = Program::where('status', _active())->get();
        $sections = Section::where('status', _active())->get();
        $districts = District::getDistrictData();
        $huds = HUD::collectHudData();
        $blocks = Block::collectBlockData();
        $phcs = PHC::collectPhcData();
        $hscs = HSC::collectHscData();
        $designations = Designation::getDesignationData();

        $contact_types = DesignationType::getDesignationTypeForContactCreateInAdmin();

        if (isState()) {
            $programs = Program::where('status', _active())->where('id', $user->programs_id)->get();
            $userTypes = array_intersect_key($allUserTypes, array_flip([1, 2, 3, 4, 5, 6]));
            $facility_levels = $allFacilityLevels->whereIn('id', [1, 2, 3, 4, 5, 6]);
            $contact_types = DesignationType::getDesignationTypeForContactCreateInState();
        } elseif (isHUD()) {
            $userTypes = array_intersect_key($allUserTypes, array_flip([3,4,5,6]));
            $facility_levels = $allFacilityLevels->whereIn('id', [3, 4, 5, 6]);
            $contact_types = DesignationType::getDesignationTypeForContactCreateInHUD();
        } elseif (isBlock()) {
            $userTypes = array_intersect_key($allUserTypes, array_flip([4,5,6]));
            $facility_levels = $allFacilityLevels->whereIn('id', [4, 5, 6]);
            $contact_types = DesignationType::getDesignationTypeForContactCreateInBlock();
        } elseif (isPHC()) {
            $userTypes = array_intersect_key($allUserTypes, array_flip([5,6]));
            $facility_levels = $allFacilityLevels->whereIn('id', [5, 6]);
            $contact_types = DesignationType::getDesignationTypeForContactCreateInPHC();
        } elseif (isHSC()) {
            $userTypes = array_intersect_key($allUserTypes, array_flip([6]));
            $facility_levels = $allFacilityLevels->whereIn('id', [6]);
            $contact_types = DesignationType::getDesignationTypeForContactCreateInHSC();
        } else {
            $userTypes = $allUserTypes;
            $facility_levels = $allFacilityLevels;
        }
        // dd($facility_levels);
        return view('admin.employees.create', compact('statuses', 'sections', 'userTypes', 'userRoles', 'designations', 'programs', 'districts', 'huds', 'blocks', 'phcs', 'hscs', 'facilities', 'facility_levels', 'contact_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $password = config('constant.default_user_password');
        $input = [
            'name' => $request->name,
            'username' => prepareUsername($request->username),
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'programs_id' => $request->program,
            'sections_id' => $request->section,
            'designations_id' => $request->designations_id,
            'country_code' => defaultCountryCode(),
            'user_type_id' => $request->user_type,
            'user_role_id' => $request->user_role,
            'user_type_id' => $request->user_type,
            'programs_id' => $request->program,
            'sections_id' => $request->section,
            'facility_hierarchy_id' => $request->facility_id,
            'designations_id' => $request->designations_id,
            'status' => $request->status ?? 0,
            'password' => Hash::make($password),
        ];


        $result = User::create($input);
        createdResponse("Customer Created Successfully");

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = User::with('tag')->find($id);
        $statuses = _getGlobalStatus();

        $userTypes = getUserType();
        $userRoles = getUserRole();

        $programs = Program::where('status', _active())->get();
        $sections = Section::where('status', _active())->get();

        $districts = District::getDistrictData();
        $huds = HUD::collectHudData();
        $blocks = Block::collectBlockData();
        $phcs = PHC::collectPhcData();
        $hscs = HSC::collectHscData();
        $designations = Designation::getDesignationData();
        $facilities = FacilityHierarchy::getFacilityHierarchyData();
        $facility_levels = FacilityLevel::getFacilityLevelData();
        return view('admin.employees.show', compact('result', 'statuses', 'sections', 'userTypes', 'userRoles', 'designations', 'programs', 'districts', 'huds', 'blocks', 'phcs', 'hscs', 'facilities', 'facility_levels'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = User::with('tag')->find($id);
        $statuses = _getGlobalStatus();

        $userTypes = getUserType();
        $userRoles = getUserRole();
        // dd($userTypes);
        $programs = Program::where('status', _active())->get();
        $sections = Section::where('status', _active())->get();
        $districts = District::getDistrictData();
        $huds = HUD::collectHudData();
        $blocks = Block::collectBlockData();
        $phcs = PHC::collectPhcData();
        $hscs = HSC::collectHscData();
        $designations = Designation::getDesignationData();
        $facilities = FacilityHierarchy::getFacilityHierarchyData();
        $facility_levels = FacilityLevel::getFacilityLevelData();
        return view('admin.employees.edit', compact('result', 'statuses', 'sections', 'userTypes', 'userRoles', 'designations', 'programs', 'districts', 'huds', 'blocks', 'phcs', 'hscs', 'facilities', 'facility_levels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules($id), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $user = User::find($id);

        $input = array();
        $input = [
            'name' => $request->name,
            'username' => $request->username,
            'contact_number' => $request->contact_number ?? null,
            'email' => $request->email,
            'status' => $request->status ?? 0,
            'user_type_id' => $request->user_type,
            'user_role_id' => $request->user_role,
            'user_type_id' => $request->user_type,
            'programs_id' => $request->program,
            'sections_id' => $request->section,
            'designations_id' => $request->designations_id,
            'designation' => $request->designation ?? null,
            'facility_hierarchy_id' => $request->facility_id,
        ];

        $result = $user->update($input);

        updatedResponse("User Updated Successfully");

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function rules($id = "")
    {

        $rules = array();

        if ($id) {
            $rules['name'] = "required|min:2|max:99";
            $rules['username'] = "required|nullable|unique:users,username,{$id},id|max:99";
            $rules['email'] = "sometimes|nullable|email|unique:users,email,{$id},id|max:99";
            $rules['contact_number'] = "sometimes|nullable|min:8|max:15";
            $rules['section'] = "sometimes";
            $rules['designation'] = "sometimes";
        } else {
            $rules['name'] = "required|unique:users,name|min:2|max:99";
            $rules['username'] = "required|nullable|unique:users,username|max:99";
            // $rules['email'] = "sometimes|nullable|email|unique:users,email|max:99";
            $rules['contact_number'] = "sometimes|nullable|min:8|max:15";
            $rules['section'] = "sometimes";
            $rules['designations_id'] = "required|min:2|max:99";
        }


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


    public function export(Request $request)
    {
        $users = User::all(); // Get all users
        $filename = 'user_details' . date('d-m-Y') . '.xlsx';
        return Excel::download(new UsersExport($users), $filename);
    }
}
