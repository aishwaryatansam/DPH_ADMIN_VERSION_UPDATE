<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ApprovalWorkflows;
use App\Models\Designation;
use App\Models\Program;
use App\Models\ProgramDetail;
use App\Models\ProgramOfficer;
use App\Models\Section;
use Illuminate\Support\Facades\Validator;
use App\Services\FileService;
use Illuminate\Support\Facades\Auth;

class ProgramDetailController extends Controller
{
    private $program_details_image_path = '/program_details/images';
    private $program_details_icon_path = '/program_details/icons';
    private $program_officers_image_path = '/program_details/officers/images';
    private $program_details_document_path = '/scheme_details/documents';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isState()){
            $programs_id = auth()->user()->programs_id;
            $sections_id = auth()->user()->sections_id;
            if ($programs_id) {
                $results = ProgramDetail::where('programs_id', $programs_id)->get();
            } elseif ($sections_id) {
                $section = Section::find($sections_id);
                if ($section) {
                    $results = ProgramDetail::where('programs_id', $section->programs_id)->get();
                } else {
                    $results = collect();
                }
            } else {
                $results = collect();
            }
        }
        else{
            $results = ProgramDetail::getQueriedResult();
        }
        
        $programofficers = ProgramOfficer::getQueriedResult();
        return view('admin.program-details.list', compact('results', 'programofficers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
        if (isState()) {
            $userRole = auth()->user()->user_role_id;
    
            if ($userRole == 1 || $userRole == 2) {
                $programs = Program::where('id', auth()->user()->programs_id)->get();
            } 
            elseif ($userRole == 3) {
                $sectionsId = auth()->user()->sections_id;
                
                $section = Section::find($sectionsId);
    
                if ($section) {
                    $programs = Program::where('id', $section->programs_id)->get();
                } else {
                    $programs = collect();
                }
            } else {
                $programs = collect();
            }
        } 
        else {
            $programs = Program::getProgramData();
        }
        $designations = Designation::where('status', _active())->get();
        return view('admin.program-details.create', compact('statuses', 'programs', 'designations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->toArray());

        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $input = [
            'description' => $request->description,
            'programs_id' => $request->program_id,
            'status' => $request->status ?? 0,
            'user_id' => Auth::user()->id,
            // 'visible_to_public' => $request->visible_to_public ?? 0,
        ];



        if ($request->hasFile('images')) {
            $images = $request->file('images');

            if (isset($images[0]) && $images[0]->isValid()) {
                $storedFileArray = FileService::storeFile($images[0], $this->program_details_image_path);
                $input['image_one'] = $storedFileArray['stored_file_path'] ?? '';
            }

            if (isset($images[1]) && $images[1]->isValid()) {
                $storedFileArray = FileService::storeFile($images[1], $this->program_details_image_path);
                $input['image_two'] = $storedFileArray['stored_file_path'] ?? '';
            }
            if (isset($images[2]) && $images[2]->isValid()) {
                $storedFileArray = FileService::storeFile($images[2], $this->program_details_image_path);
                $input['image_three'] = $storedFileArray['stored_file_path'] ?? '';
            }
            if (isset($images[3]) && $images[3]->isValid()) {
                $storedFileArray = FileService::storeFile($images[3], $this->program_details_image_path);
                $input['image_four'] = $storedFileArray['stored_file_path'] ?? '';
            }
            if (isset($images[4]) && $images[4]->isValid()) {
                $storedFileArray = FileService::storeFile($images[4], $this->program_details_image_path);
                $input['image_five'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('icon') && $file = $request->file('icon')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, $this->program_details_icon_path);

                $input['icon_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('document') && $file = $request->file('document')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, $this->program_details_document_path);

                $input['document'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = ProgramDetail::create($input);

        if ($request->has('officers')) {
            foreach ($request->officers as $officerData) {
                $officerInput = [
                    'name' => $officerData['officer_name'],
                    'qualification' => $officerData['officer_qualification'],
                    'designations_id' => $officerData['officer_designation'],
                    'programs_id' => $request->program_id, // Link to the created program detail
                    'status' => $officerData['officer_status'] ?? 0,
                    'order_no' => $officerData['officer_order'],
                    'level' => $officerData['officer_level'],
                ];

                // Handle officer image upload
                if (isset($officerData['officer_image']) && $officerData['officer_image']->isValid()) {
                    $storedFileArray = FileService::storeFile($officerData['officer_image'], $this->program_officers_image_path);
                    $officerInput['image'] = $storedFileArray['stored_file_path'] ?? '';
                }

                // Create the officer record in the database
                ProgramOfficer::create($officerInput);
            }
        }

        $approvalData = getApprovalData();

        ApprovalWorkflows::create([
            'model_type' => ProgramDetail::class,        
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

        createdResponse("Program Details Created Successfully");

        return redirect()->route('programdetails.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = ProgramDetail::findOrFail($programs_id = $id);
        $officers = ProgramOfficer::where('programs_id', $result->programs_id)->get();
        $approvalResult = ApprovalWorkflows::where('model_id', $id)
        ->where('model_type', 'App\Models\ProgramDetail')
        ->first();
        // dd($officers ->toArray(),$result ->toArray());
        return view('admin.program-details.show', compact('result', 'officers', 'approvalResult'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = ProgramDetail::findOrFail($programs_id = $id);
        $statuses = _getGlobalStatus();
        $officers = ProgramOfficer::where('programs_id', $result->programs_id)->get();
        $designations = Designation::where('status', _active())->get();
        // dd($officers ->toArray(),$result ->toArray());
        return view('admin.program-details.edit', compact('result', 'officers', 'statuses', 'designations'));
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
        // dd($request->toArray());

        // Validate the request
        $validator = Validator::make($request->all(), $this->rules($id), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $programDetail = ProgramDetail::findOrFail($id);

        $input = [
            'description' => $request->description,
            'programs_id' => $request->program_id,
            'status' => $request->status ?? 0,
            // 'visible_to_public' => $request->visible_to_public ?? 0,
        ];

        // Handle image uploads (if any)
        if ($request->hasFile('images.0') && $file = $request->file('images.0')) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->file('images.0'), $this->program_details_image_path, $programDetail->image_one);
                $input['image_one'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('images.1') && $file = $request->file('images.1')) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->file('images.1'), $this->program_details_image_path, $programDetail->image_two);
                $input['image_two'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('images.2') && $file = $request->file('images.2')) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->file('images.2'), $this->program_details_image_path, $programDetail->image_three);
                $input['image_three'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('images.3') && $file = $request->file('images.3')) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->file('images.3'), $this->program_details_image_path, $programDetail->image_four);
                $input['image_four'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('images.4') && $file = $request->file('images.4')) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->file('images.4'), $this->program_details_image_path, $programDetail->image_five);
                $input['image_five'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        // Handle document upload (if any)
        if ($request->hasFile('icon') && $file = $request->file('icon')) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->file('icon'), $this->program_details_icon_path, $programDetail->icon_url);
                $input['icon_url'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('document') && $file = $request->file('document')) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->file('document'), $this->program_details_document_path, $programDetail->document_url);
                $input['document'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        $programDetail->update($input);

        if ($request->has('officers')) {
            foreach ($request->officers as $officerData) {
                // Create an input array for the officer
                $officerInput = [
                    'name' => $officerData['officer_name'],
                    'qualification' => $officerData['officer_qualification'],
                    'designations_id' => $officerData['officer_designation'],
                    'programs_id' => $programDetail->programs_id, // Link to the updated program detail
                    'status' => $officerData['officer_status'] ?? 0,
                    'order_no' => $officerData['officer_order'],
                    'level' => $officerData['officer_level'],
                ];

                if (isset($officerData['officer_id'])) {
                    $officer = ProgramOfficer::find($officerData['officer_id']);
                    if ($officer) {
                        // Check if there's a new officer image and update it
                        if (isset($officerData['officer_image']) && $officerData['officer_image']->isValid()) {
                            $storedFile = FileService::updateAndStoreFile($officerData['officer_image'],$this->program_officers_image_path, $officer->image );
                            $officerInput['image'] = $storedFile['stored_file_path'] ?? '';
                        }

                        // Update the existing officer with new data
                        $officer->update($officerInput);
                    }
                } else {
                    // Handle officer image upload for new officer
                    if (isset($officerData['officer_image']) && $officerData['officer_image']->isValid()) {
                        $storedFileArray = FileService::storeFile($officerData['officer_image'], $this->program_officers_image_path);
                        $officerInput['image'] = $storedFileArray['stored_file_path'] ?? '';
                    }

                    // Create a new officer if officer_id is not provided
                    ProgramOfficer::create($officerInput);
                }
            }
        }

        createdResponse("Program Details Updated Successfully");

        

        return redirect()->route('programdetails.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $programDetail = ProgramDetail::find($id);

        if (!$programDetail) {
            return response()->json(['message' => 'Scheme not found'], 404);
        }

        $imageField = $request->input('image_field');
        // return dd($programDetail->$imageField);
        if ($programDetail->$imageField) {
            $storedFile = FileService::deleteDiskFile($programDetail->$imageField, '/');

            $programDetail->$imageField = null; // Set the image field to null
            $programDetail->save(); // Save changes
        };
        createdResponse("Image Deleted Successfully");
    }

    public function rules($id = "")
    {

        $rules = array();

        $rules['description'] = 'required|string';
        $rules['program_id'] = 'required|integer';
        $rules['status'] = 'nullable|boolean';
        $rules['visible_to_public'] = 'nullable|boolean';
        $rules['images.*'] = 'sometimes|mimes:jpeg,png,jpg|max:4096';
        $rules['icon_url'] = 'nullable|mimes:png|max:4096';
        $rules['document'] = 'nullable|mimes:pdf|max:5120';
        $rules['officers.*.officer_name'] = 'sometimes|string';
        $rules['officers.*.officer_qualification'] = 'sometimes|string';
        $rules['officers.*.officer_designation'] = 'sometimes|string';
        $rules['officers.*.officer_status'] = 'nullable|boolean';
        $rules['officers.*.officer_image'] = 'sometimes|mimes:jpeg,png,jpg|max:4096';
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

    public function export(Request $request){
    	$filename = 'programs'.date('d-m-Y').'.xlsx';
    	return Excel::download(new CustomersExport, $filename);
    	
    }
}
