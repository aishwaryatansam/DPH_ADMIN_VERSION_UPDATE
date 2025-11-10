<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Exports\HudsExport;
use App\Exports\HirerachyDetailedReport;
use App\Models\HUD;
use App\Models\District;
use Validator;
use App\Services\FileService;
use App\Http\Resources\Dropdown\HUDResource as DDHUDResource;
use App\Exports\ConsolidateHudReport;
use App\Exports\ConsolidateBlockReport;
use App\Exports\ConsolidatePHCReport;
use App\Exports\ConsolidateHSCReport;
use App\Models\FetchTag;

class HudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
public function index(Request $request)
{
    $query = HUD::with('district')->orderBy('name');

    // Filter by District (dropdown)
    if ($request->filled('district_id')) {
        $query->where('district_id', $request->district_id);
    }

    // Keyword search
    if ($request->filled('keyword')) {
        $keyword = $request->keyword;
        $query->where('name', 'like', "%{$keyword}%")
              ->orWhereHas('district', function ($q) use ($keyword) {
                  $q->where('name', 'like', "%{$keyword}%");
              });
    }

    // Pagination with user-selected length
    $results = $query->paginate($request->get('pageLength', 10))
                     ->appends($request->query());
foreach ($results as $result) {
    // Fetch active tags (consistent with your existing code)
    $tags = FetchTag::where('status', 1)->orderBy('name')->get(['id', 'name']);
    
    // Get tag IDs (from the result)
    $tagIds = explode(',', $result->tags);

    // Fetch tag names by matching the tag IDs
    $tagNames = $tags->whereIn('id', $tagIds)->pluck('name')->toArray();

    // Store the tag names as a comma-separated string
    $result->tag_names = implode(', ', $tagNames);
}

    $districts = District::where('status', _active())
                        ->orderBy('name')
                        ->get();

    return view('admin.masters.huds.list', compact('results', 'districts'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
        $districts = District::getDistrictData();
        $is_urban = _isUrban();
           $tags = FetchTag::where('status', 1)->orderBy('name')->get(['id', 'name']);
        return view('admin.masters.huds.create',compact('districts','statuses', 'is_urban','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(),$this->rules(),$this->messages(),$this->attributes());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                        ->withInput();
        }

        $input = [
                'name' => $request->name,
                'district_id' => $request->district_id,
                // 'location_url' => $request->location_url,
                // 'video_url' => $request->video_url,
                // 'is_urban' => $request->is_urban,
                'status' => $request->status ?? 0,
                 'tags' => is_array($request->tags) ? implode(',', $request->tags) : $request->tags,

            ];
            
           
        if($request->hasFile('hud_image') && $file = $request->file('hud_image')) {

            if($file->isValid()) {
                $storedFileArray = FileService::storeFile($file);

                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if($request->hasFile('property_document') && $file = $request->file('property_document')) {

            if($file->isValid()) {
                $storedFileArray = FileService::storeFile($file);

                $input['property_document_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }
        
        $result = HUD::create($input);

        createdResponse("HUD Created Successfully");

        return redirect()->route('huds.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = HUD::with(['district'])->find($id);
        return view('admin.masters.huds.show',compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = HUD::with(['district'])->find($id);
        $statuses = _getGlobalStatus();
        $districts = District::getDistrictData();
        $is_urban = _isUrban();
         $tags =FetchTag::where('status', _active())->orderBy('name')->pluck('name', 'id');
$selectedTags = $result->tags ? explode(',', $result->tags) : [];
  
        return view('admin.masters.huds.edit',compact('result','districts','statuses', 'tags', 'selectedTags','is_urban'));
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
        $validator = Validator::make($request->all(),$this->rules($id),$this->messages(),$this->attributes());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                        ->withInput();
        }

        $hud = HUD::find($id);

        $input = array();
        $input = [
                'name' => $request->name,
                'district_id' => $request->district_id,
                // 'location_url' => $request->location_url,
                // 'video_url' => $request->video_url,
                // 'is_urban' => $request->is_urban,
                'status' => $request->status ?? 0,
                 'tags' => is_array($request->tags) ? implode(',', $request->tags) : $request->tags
            ];

            

        if($request->hasFile('hud_image') && $file = $request->file('hud_image')) {
            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file,'/',$hud->image_url);
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }
        if($request->hasFile('property_document') && $file = $request->file('property_document')) {
            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file,'/',$hud->property_document_url);
                $input['property_document_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = $hud->update($input);

        updatedResponse("HUD Updated Successfully");

        return redirect()->route('huds.index');
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

    public function destroyDocument($id)
    {        
        // Delete the property document
        $hud = HUD::find($id);
        if ($hud->property_document_url) {
            $hud->update(['property_document_url' => null]);
        }

        return redirect()->back()->with('success', 'Land Document deleted successfully.');
    }

    public function rules($id="") {

        $rules = array();

         if($id) {
            $rules['name'] = "required|unique:huds,name,{$id},id,district_id,{request('district_id')}|min:2|max:99";
        } else {
            $rules['name'] = "required|unique:huds,name,null,id,district_id,{request('district_id')}|min:2|max:99";
        }

        $rules['district_id'] = 'required';
        $rules['hud_image'] = 'sometimes|mimes:png,jpg,jpeg|max:4096';
        $rules['location_url'] = 'sometimes|nullable|url';
        $rules['video_url'] = 'sometimes|nullable|url';
        // $rules['status'] = 'required|boolean';
        // $rules['is_urban'] = 'required';
        $rules['property_document'] = 'sometimes|mimes:pdf|max:8192';

        return $rules;
    }

    public function messages() {
        return [];
    }

    public function attributes() {
        return [];
    }

    public function listHUD(Request $request) {
        $validator = Validator::make($request->all(),[
            'hud_id' => 'sometimes',
            'district_id' => 'sometimes'
        ]);

        if($validator->fails()) {
            return sendError($validator->errors());
        }
        $huds = HUD::collectHudData($request->district_id,$request->hud_id);
        return sendResponse(DDHUDResource::collection($huds));
    }

    public function export(Request $request){
        $filename = 'huds-list-'.date('d-M-Y').'.xlsx';
        return Excel::download(new HudsExport, $filename);
    }

    public function consolidateReport(Request $request) {
        if(!$request->type)
        {
            errorResponse("Invalid Export Request");

            return redirect()->back();
        }

        ini_set('max_execution_time', 500);

        $filename = 'consolidate-'.$request->type.'-report-'.date('d-M-Y').'.xlsx';

        $report = '';

        switch ($request->type) {
            case 'hud':
                $report = Excel::download(new ConsolidateHUDReport, $filename);
                break;
            case 'block':
                $report = Excel::download(new ConsolidateBlockReport, $filename);
                break;
            case 'phc':
                $report = Excel::download(new ConsolidatePHCReport, $filename);
                break;
            case 'hsc':
                $report = Excel::download(new ConsolidateHSCReport, $filename);
                break;
        }
        return $report;

        // return Excel::download(new HirerachyDetailedReport($request->type), $filename);   
    }

}
