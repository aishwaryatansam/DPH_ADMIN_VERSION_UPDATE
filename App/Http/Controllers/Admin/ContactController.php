<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Designation;
use App\Models\DesignationType;
use App\Models\HUD;
use App\Models\Block;
use App\Models\PHC;
use App\Models\HSC;
use Illuminate\Support\Facades\Validator;
use App\Services\FileService;
use App\Http\Resources\Dropdown\BlockResource as DDBlockResource;
use App\Http\Resources\BlockResource;
use App\Models\ApprovalWorkflows;
use App\Models\FacilityHierarchy;
use App\Models\FacilityType;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isHud()) {
            $isUpdatePending = Contact::isHUdSelfUpdateCompleted(auth()->user()->id);
            if ($isUpdatePending) {
                warningResponse('Please update profile before continue further.');
                return redirect('profile/update');
            }
        }
        $contact_types = [];

        $huds = HUD::filter()->where('status', _active())->orderBy('name')->get();


        $blocks = [];
        if ($hud_id = request('hud_id')) {
            $blocks = Block::filter()->where('status', _active())->orderBy('name')->get();
        }

        $phcs = array();

        if ($block_id = request('block_id')) {
            $phcs = PHC::filter()->where('status', _active())->orderBy('name')->get();
        }

        $hscs = [];
        if ($phc_id = request('phc_id')) {
            $hscs = HSC::filter()->where('status', _active())->orderBy('name')->get();
        }

        


        $results = Contact::getQueriedResult();
        if (isAdmin()) {
            $contact_types = DesignationType::getDesignationTypeForContactCreateInAdmin();
        } elseif (isHud()) {
            $contact_types = DesignationType::getDesignationTypeForContactCreateInHUD();
        }

        return view('admin.contacts.list', compact('results', 'contact_types', 'huds', 'blocks', 'phcs', 'hscs'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
        $is_post_vacants = _isPostVacant();
        $facility_types = FacilityType::getFacilityTypeData();
        $facilities = FacilityHierarchy::getFacilityHierarchyData();
        $contact_types = $designation = [];
        $huds = HUD::collectHudData();
        $blocks = Block::collectBlockData();
        $phc = PHC::collectPhcData();
        $hsc = HSC::collectHscData();
        $hud_id = auth()->user()->hud_id;
        $programs = Program::getProgramData();

        if (isAdmin()) {
            $contact_types = DesignationType::getDesignationTypeForContactCreateInAdmin();
        } 
        elseif (isHud()) {
            $contact_types = DesignationType::getDesignationTypeForContactCreateInHUD();
        }
        elseif (isState()){
            $contact_types = DesignationType::getDesignationTypeForContactCreateInState();
        }
        elseif (isBlock()){
            $contact_types = DesignationType::getDesignationTypeForContactCreateInBlock();
        }
        elseif (isPHC()){
            $contact_types = DesignationType::getDesignationTypeForContactCreateInPHC();
        }
        elseif (isHSC()){
            $contact_types = DesignationType::getDesignationTypeForContactCreateInHSC();
        }
        return view('admin.contacts.create', compact('designation', 'huds', 'blocks', 'phc', 'hsc', 'statuses', 'contact_types', 'is_post_vacants', 'hud_id', 'facility_types', 'facilities', 'programs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        if (request('contact_type') == '10' && request('hsc_id')) {
            $isHscContactExist = Contact::isHscContactExist(request('hsc_id'));

            if ($isHscContactExist) {
                return redirect()->back()->withErrors(['error' => 'Already contact exists for this hsc.'])->withInput();
            }
        }


        $hud_id = $request->hud_id;
        if (isHud()) {
            $hud_id = auth()->user()->hud_id;
        }

        $input = [
            'name' => $request->name,
            'designation_id' => $request->designation_id,
            'email_id' => $request->email_id,
            'mobile_number' => $request->mobile_number,
            'landline_number' => $request->landline_number,
            'fax' => $request->fax,
            'qualification' => $request->qualification,
            'contact_type' => $request->contact_type,
            'facility_id' => $request->facility_id,
            'order_no' => $request->order_no,
            'programs_id' => $request->programs_id,
            'user_id' => Auth::user()->id,
            'hud_id'  => $hud_id,
            'block_id'  => $request->block_id,
            'phc_id'  => $request->phc_id,
            'hsc_id'  => $request->hsc_id,
            'is_post_vacant' => $request->is_post_vacant ?? 0,
            'status' => $request->status ?? 0
        ];
        dd($input);

        $result = Contact::create($input);

        $approvalData = getApprovalData();

        ApprovalWorkflows::create([
            'model_type' => Contact::class,        
            'model_id' => $result->id,
            'uploaded_by' => Auth::user()->id,
            'current_stage' => $approvalData['current_stage'],
            'super_admin_id' => $approvalData['super_admin_id'],
            'state_approve_id' => $approvalData['state_approve_id'],
            'hud_approve_id' => $approvalData['hud_approve_id'],
            'block_approve_id' => $approvalData['block_approve_id'],
            'phc_verify_id' => $approvalData['phc_verify_id'],
            'block_verify_id' => $approvalData['block_verify_id'],
            'hud_verify_id' => $approvalData['hud_verify_id'],
            'state_verify_id' => $approvalData['state_verify_id'],
        ]);

        createdResponse("Contact Created Successfully");

        

        return redirect()->route('contacts.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = Contact::with(['contactType', 'designation', 'hud', 'phc', 'hsc'])->find($id);
        $approvalResult = ApprovalWorkflows::where('model_id', $id)
        ->where('model_type', 'App\Models\Contact')
        ->first();
        // dd($approvalResult->toarray());
        return view('admin.contacts.show', compact('result', 'approvalResult'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = Contact::with(['contactType'])->find($id);
        // dd($result->toArray());
        $statuses = _getGlobalStatus();
        $is_post_vacants = _isPostVacant();
        $facility_types = FacilityType::getFacilityTypeData();
        $facilities = FacilityHierarchy::getFacilityHierarchyData();
        $blocks = $huds = $phc = $hsc = $designation = [];
        $hud_id = auth()->user()->hud_id;
        $contact_types = [];
        if (isAdmin()) {
            $contact_types = DesignationType::getDesignationTypeForContactCreateInAdmin();
        } elseif (isHud()) {
            $contact_types = DesignationType::getDesignationTypeForContactCreateInHUD();
        }
        elseif (isState()) {
            $contact_types = DesignationType::getDesignationTypeForContactCreateInState();
        }
        $huds = HUD::collectHudData();
        $blocks = Block::collectBlockData($result->hud_id);
        $phc = PHC::collectPhcData($result->block_id);
        $hsc = HSC::collectHscData($result->phc_id);
        $programs = Program::getProgramData();


        $designation = Designation::getDesignationData($result->contact_type);
        return view('admin.contacts.edit', compact(
            'result',
            'designation',
            'huds',
            'blocks',
            'phc',
            'hsc',
            'statuses',
            'is_post_vacants',
            'hud_id',
            'facility_types',
            'facilities',
            'contact_types',
            'programs'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules($id), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }
        /*
        if(request('contact_type') == '10' && request('hsc_id')) {
        	$isHscContactExist = Contact::isHscContactExist(request('hsc_id'));
        	
		if ($isHscContactExist) {
			return redirect()->back()->withErrors(['error' => 'Already contact exists for this hsc.'])->withInput();
	    	}
        }*/

        $contact = Contact::find($id);

        $input = array();

        $input = [

            'name' => $request->name,
            'designation_id' => $request->designation_id,
            'email_id' => $request->email_id,
            'mobile_number' => $request->mobile_number,
            'landline_number' => $request->landline_number,
            'fax' => $request->fax,
            'qualification' => $request->qualification,
            'facility_id' => $request->facility_id,
            'order_no' => $request->order_no,
            'programs_id' => $request->programs_id,
            'hud_id'  => $request->hud_id,
            'block_id'  => $request->block_id,
            'phc_id'  => $request->phc_id,
            'hsc_id'  => $request->hsc_id,
            'is_post_vacant' => $request->is_post_vacant ?? 0,
            'status' => $request->status ?? 0
        ];

        if ($request->is_post_vacant == '1') {
            $input['name'] = NULL;
            $input['email_id'] = NULL;
            $input['mobile_number'] = NULL;
            $input['landline_number'] = NULL;
            $input['fax'] = NULL;
            $input['qualification'] = NULL;
        }


        if ($request->hasFile('contact_image') && $file = $request->file('contact_image')) {
            if ($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, '/', $contact->image_url);
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = $contact->update($input);

        if ($request->has('profile_update')) {
            updatedResponse("Profile Updated Successfully");
            return redirect('dashboard');
        }
        updatedResponse("Contact Updated Successfully");

        return redirect()->route('contacts.index');
    }


    public function getDesignation(Request $request)
{
    $validator = Validator::make($request->all(), [
        'contact_type' => 'required|exists:designation_types,id',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    $designations = \App\Models\Designation::where('designation_type_id', $request->contact_type)
        ->where('status', _active())
        ->orderBy('name')
        ->get(['id', 'name']);

    return response()->json(['data' => $designations]);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function rules($id = "")
    {

        $rules = array();
        $rules['facility_id'] = 'required | exists:facility_hierarchy,id';
        
        if ($id) {
            $rules['name'] = "required_if:is_post_vacant,==,no|nullable|min:2|max:99";
        } else {
            $rules['name'] = "required_if:is_post_vacant,==,no|nullable|min:2|max:99";
        }
        $rules['contact_type'] = 'required|exists:designation_types,id,status,' . _active();        
        if ($id) {
            // Add an exception for the current contact being updated
            $rules['designation_id'] = 'required|exists:designations,id|unique:contacts,designation_id,' . $id . ',id,contact_type,' . request('contact_type') . ',hud_id,' . request('hud_id') . ',block_id,' . request('block_id') . ',phc_id,' . request('phc_id') . ',hsc_id,' . request('hsc_id');
        } else {
            // Standard uniqueness rule for creating a new contact
            $rules['designation_id'] = 'required|exists:designations,id|unique:contacts,designation_id,NULL,id,contact_type,' . request('contact_type') . ',hud_id,' . request('hud_id') . ',block_id,' . request('block_id') . ',phc_id,' . request('phc_id') . ',hsc_id,' . request('hsc_id');
        }
    
        $rules['mobile_number'] = 'required_if:is_post_vacant,==,no|nullable|min:10';
        $rules['landline_number'] = 'sometimes|nullable|min:5';
        $rules['email_id'] = 'required_if:is_post_vacant,==,no|nullable|email';
        if ($contact_type = request('contact_type')) {

            if (in_array($contact_type, ['10'])) {
                $rules['email_id'] = 'sometimes|nullable|email';
            }
        }

        $rules['fax'] = 'sometimes|nullable';
        $rules['location_url'] = 'sometimes|nullable|url';
        $rules['contact_image'] = 'sometimes|mimes:png,jpg,jpeg|max:1024';
        if ($id) {
            $rules['order_no'] = "required|integer|unique:contacts,order_no,{$id},id"; // Ensuring order_no is unique during update
        } else {
            $rules['order_no'] = "required|integer|unique:contacts,order_no"; // Ensuring order_no is unique during store
        }

        // $rules['hud_id'] = 'required_if:contact_type,==,4';
        // $rules['block_id'] = 'required_if:contact_type,==,8';
        // $rules['phc_id'] = 'required_if:contact_type,==,9';
        // $rules['hsc_id'] = 'required_if:contact_type,==,10';

        // $rules['is_post_vacant'] = 'required';

        return $rules;
    }

    public function messages()
    {
        return [
            'designation_id.unique' => 'Contact already exists under the selected designation, please update the details.',
        ];
    }

    public function attributes()
    {
        return [];
    }

    public function updateSelfContact()
    {
        $isProfileUpdate = True;
        $hud_id = auth()->user()->hud_id;
        $result = Contact::with(['contactType'])->where('hud_id', $hud_id)->where('contact_type', 4)->whereNull('block_id')->whereNotNull('user_id')->latest()->first();
        $statuses = _getGlobalStatus();
        $huds = $blocks = $phc = $hsc = $designation = [];

        if (isHud()) {
            $huds = HUD::collectHudData();
            $blocks = Block::collectBlockData($result->hud_id);
            $phc = PHC::collectPhcData($result->block_id);
            $hsc = HSC::collectHscData($result->phc_id);
        }

        $designation = Designation::getDesignationData($result->contact_type);
        return view('admin.contacts.edit', compact('result', 'huds', 'designation', 'blocks', 'phc', 'hsc', 'statuses', 'isProfileUpdate', 'hud_id'));
    }

    public function listBlockContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hud_id' => 'required|exists:huds,id,status,' . _active(),
        ]);

        if ($validator->fails()) {
            return sendError($validator->errors());
        }
        $blocks = Block::collectBlockData($request->hud_id);
        return sendResponse(BlockResource::collection($blocks));
    }
}
