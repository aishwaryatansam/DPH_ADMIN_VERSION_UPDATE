<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SchemeDetailsExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ApprovalWorkflows;
use App\Models\Program;
use App\Models\Scheme;
use App\Models\SchemeDetail;
use App\Models\Section;
use Illuminate\Support\Str;
use App\Services\FileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\FetchTag;
class SchemeDetailController extends Controller
{
    private $scheme_details_image_path = '/scheme_details/images';
    private $scheme_details_icon_path = '/scheme_details/icons';
    private $scheme_details_report_image_path = '/scheme_details/report_images';
    private $scheme_details_document_path = '/scheme_details/documents';

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
                $results = SchemeDetail::whereHas('scheme', function($query) use ($programs_id) {
                    $query->where('programs_id', $programs_id);
                })
                ->with('approvalWorkflow')
                ->get();
            } elseif ($sections_id) {
                $section = Section::find($sections_id);
                if ($section) {
                    $results = SchemeDetail::whereHas('scheme', function($query) use ($section) {
                        $query->where('programs_id', $section->programs_id);
                    })
                    ->with('approvalWorkflow')
                    ->get();
                } else {
                    $results = collect();
                }
            } else {
                $results = collect();
            }
        }
        else{
            $results = SchemeDetail::getQueriedResult();
        }
        // dd($results->toArray());
        $schemes = Scheme::getSchemeData();
        
        return view('admin.scheme-details.list', compact('results', 'schemes'));
    }

    /** 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
        $programs_id = auth()->user()->programs_id;
        $sections_id = auth()->user()->sections_id;
        $section = Section::find($sections_id);
   
        // dd($section->programs_id);
        $programs = collect();
        if (isState()) {
            // dd('working');
            if ($programs_id) {
                $schemes = Scheme::where('programs_id', $programs_id)->get();
            } elseif ($sections_id) {
                $schemes = Scheme::where('programs_id', $section->programs_id)->get();
            } else {
                $schemes = collect();
            }
        }
        else {
            $schemes = Scheme::getSchemeData();
            $programs = Program::getProgramData();
        }
         $tags = FetchTag::where('status', 1)->orderBy('name')->get(['id', 'name']);
        return view('admin.scheme-details.create', compact('statuses', 'schemes', 'programs',  'tags'));
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
            'schemes_id' => $request->scheme_id,
            'status' => $request->status ?? 0,
            'tags' => is_array($request->tags) ? implode(',', $request->tags) : $request->tags,
            'visible_to_public' => $request->visible_to_public ?? 0,
            'user_id' => Auth::user()->id,
        ];



        if ($request->hasFile('images')) {
            $images = $request->file('images');

            if (isset($images[0]) && $images[0]->isValid()) {
                $storedFileArray = FileService::storeFile($images[0], $this->scheme_details_image_path);
                $input['image_one'] = $storedFileArray['stored_file_path'] ?? '';
            }

            if (isset($images[1]) && $images[1]->isValid()) {
                $storedFileArray = FileService::storeFile($images[1], $this->scheme_details_image_path);
                $input['image_two'] = $storedFileArray['stored_file_path'] ?? '';
            }
            if (isset($images[2]) && $images[2]->isValid()) {
                $storedFileArray = FileService::storeFile($images[2], $this->scheme_details_image_path);
                $input['image_three'] = $storedFileArray['stored_file_path'] ?? '';
            }
            if (isset($images[3]) && $images[3]->isValid()) {
                $storedFileArray = FileService::storeFile($images[3], $this->scheme_details_image_path);
                $input['image_four'] = $storedFileArray['stored_file_path'] ?? '';
            }
            if (isset($images[4]) && $images[4]->isValid()) {
                $storedFileArray = FileService::storeFile($images[4], $this->scheme_details_image_path);
                $input['image_five'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        foreach (['report_image_one', 'report_image_two', 'report_image_three', 'report_image_four', 'report_image_five'] as $field) {
            if ($request->hasFile($field)) {
                $reportImage = $request->file($field);
                if ($reportImage->isValid()) {
                    $storedFileArray = FileService::storeFile($reportImage, $this->scheme_details_report_image_path);
                    $input[$field] = $storedFileArray['stored_file_path'] ?? '';  // Store the file path in the input array
                }
            }
        }

        if ($request->hasFile('icon') && $file = $request->file('icon')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, $this->scheme_details_icon_path);

                $input['icon_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('document') && $file = $request->file('document')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, $this->scheme_details_document_path);

                $input['document_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

           $result = SchemeDetail::create($input);
             

        $approvalData = getApprovalData();

        ApprovalWorkflows::create([
            'model_type' => SchemeDetail::class,        
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

        createdResponse("Scheme Details Created Successfully");

        return redirect()->route('schemedetails.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = SchemeDetail::findOrFail($id);
        $approvalResult = ApprovalWorkflows::where('model_id', $id)
        ->where('model_type', 'App\Models\SchemeDetail')
        ->first();
        return view('admin.scheme-details.show', compact('result', 'approvalResult'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = SchemeDetail::findOrFail($id);
        // dd($result->toArray());
        $statuses = _getGlobalStatus();
        $programs = Program::getProgramData();
        $schemes = Scheme::getSchemeData();
        return view('admin.scheme-details.edit', compact('result', 'statuses', 'schemes', 'programs'));
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
     
$validator = Validator::make($request->all(), $this->rules($id), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $result = SchemeDetail::find($id);
        $input = array();
        $input = [
            'description' => $request->description,
            'schemes_id' => $request->scheme_id,
            'status' => $request->status ?? 0,
            'visible_to_public' => $request->visible_to_public ?? 0,
        ];
        // dd($input);


        if ($request->hasFile('images.0') && $file = $request->file('images.0')) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->file('images.0'), $this->scheme_details_image_path, $result->image_one);
                $input['image_one'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('images.1') && $file = $request->file('images.1')) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->file('images.1'), $this->scheme_details_image_path, $result->image_two);
                $input['image_two'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('images.2') && $file = $request->file('images.2')) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->file('images.2'), $this->scheme_details_image_path, $result->image_three);
                $input['image_three'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('images.3') && $file = $request->file('images.3')) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->file('images.3'), $this->scheme_details_image_path, $result->image_four);
                $input['image_four'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('images.4') && $file = $request->file('images.4')) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->file('images.4'), $this->scheme_details_image_path, $result->image_five);
                $input['image_five'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        $imageFields = [
            'report_image_one',
            'report_image_two',
            'report_image_three',
            'report_image_four',
            'report_image_five'
        ];
        
        foreach ($imageFields as $field) {
            if ($request->hasFile($field) && $file = $request->file($field)) {
                if ($file->isValid()) {
                    $storedFile = FileService::updateAndStoreFile($file, $this->scheme_details_report_image_path, $result->$field);
                    
                    $input[$field] = $storedFile['stored_file_path'] ?? '';
                }
            }
        }

        if ($request->hasFile('icon') && $file = $request->file('icon')) {
            if ($file->isValid()) {
            $storedFile = FileService::updateAndStoreFile($request->file('icon'), $this->scheme_details_icon_path, $result->icon_url);
            $input['icon_url'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('document') && $file = $request->file('document')) {
            if ($file->isValid()) {
            $storedFile = FileService::updateAndStoreFile($request->file('document'), $this->scheme_details_document_path, $result->document_url);
            $input['document_url'] = $storedFile['stored_file_path'] ?? '';
            }
        }
        // dd($input);
        $result->update($input);

        createdResponse("Scheme Details Updated Successfully");

        return redirect()->route('schemedetails.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $schemeDetail = SchemeDetail::find($id);
    
        if (!$schemeDetail) {
            return response()->json(['message' => 'Scheme not found'], 404);
        }
        
        $imageField = $request->input('image_field');
        // return dd($schemeDetail->$imageField);
        if ($schemeDetail->$imageField) {
            $storedFile = FileService::deleteDiskFile($schemeDetail->$imageField, $this->scheme_details_report_image_path);
            
            $schemeDetail->$imageField = null; // Set the image field to null
            $schemeDetail->save(); // Save changes
        };
        createdResponse("Image Deleted Successfully");
    }

public function rules($id = "")
{
    $rules = [];

    $rules['images.*'] = 'sometimes|mimes:png,jpg,jpeg|max:4096';
    $rules['report_images.*'] = 'sometimes|mimes:png,jpg,jpeg|max:4096';
    $rules['documents'] = 'sometimes|mimes:pdf|max:5120';
    $rules['description'] = 'sometimes|nullable';
    $rules['scheme_id'] = 'required|unique:scheme_details,schemes_id,' . $id . ',id';
    
    $rules['status'] = 'sometimes|boolean';
    $rules['visible_to_public'] = 'sometimes|boolean';

    return $rules;
}


public function messages()
{
    return [
        'scheme_id.unique' => 'This Scheme already has details added.',
    ];
}


    public function attributes()
    {
        return [];
    }

    public function export()
    {
        return Excel::download(new SchemeDetailsExport, 'scheme_details.xlsx');
    }
}
