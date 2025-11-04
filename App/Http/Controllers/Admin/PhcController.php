<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PHC;
use App\Models\HUD;
use App\Models\Block;
use Validator;
use App\Services\FileService;
use App\Http\Resources\Dropdown\PHCResource as DDPHCResource;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PHCExport;

class PhcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//   public function index()
// {
//     // You can specify per page, e.g., 10 or use request('pageLength', 10)
//     $results = PHC::getQueriedResult()->paginate(10); // If getQueriedResult is a query builder

//     $huds = HUD::with(['blocks:id,name,hud_id'])
//         ->filter()
//         ->where('status', _active())
//         ->orderBy('name')
//         ->get();

//     return view('admin.masters.phc.list', compact('results', 'huds'));
// }

public function index(Request $request)
{
    // Default per-page value (from dropdown)
    $perPage = $request->get('pageLength', 10);

    $query = PHC::with('block');

    // Filter by block_id
    if ($request->filled('block_id')) {
        $query->where('block_id', $request->block_id);
    }

    // Search by name or block name
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhereHas('block', function ($b) use ($search) {
                  $b->where('name', 'like', "%{$search}%");
              });
        });
    }

    // Pagination with dynamic per-page
    $results = $query->paginate($perPage)->appends($request->query());

    // Load HUDs + Blocks for filter dropdown
    $huds = HUD::with(['blocks:id,name,hud_id'])
        ->where('status', _active())
        ->orderBy('name')
        ->get();

    return view('admin.masters.phc.list', compact('results', 'huds'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
    {
        $statuses = _getGlobalStatus();
        $huds = HUD::collectHudData();
        $blocks = Block::collectBlockData();
        $is_urban = _isUrban();
        return view('admin.masters.phc.create',compact('blocks','statuses', 'huds', 'is_urban'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(),$this->rules(),$this->messages(),$this->attributes());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                        ->withInput();
        }

        $input = [
                'name' => $request->name,
                'block_id' => $request->block_id,
                // 'location_url' => $request->location_url,
                // 'video_url' => $request->video_url,
                // 'is_urban' => $request->is_urban,
                'status' => $request->status ?? 0
            ];

            

            if($request->hasFile('phc_image') && $file = $request->file('phc_image')) {

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

        $result = PHC::create($input);

        createdResponse("PHC Created Successfully");

        return redirect()->route('phc.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = PHC::with([])->find($id);
        return view('admin.masters.phc.show',compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function edit($id)
    {
        $result = PHC::with([])->find($id);
        $statuses = _getGlobalStatus();
        $huds = HUD::collectHudData();
        $blocks = Block::collectBlockData();
        $is_urban = _isUrban();
        return view('admin.masters.phc.edit',compact('result','blocks','statuses', 'huds', 'is_urban'));
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

        $phc = PHC::find($id);

        $input = array();
        $input = [
                'name' => $request->name,
                'block_id' => $request->block_id,   
                // 'location_url' => $request->location_url, 
                // 'video_url' => $request->video_url,
                // 'is_urban' => $request->is_urban,           
                'status' => $request->status ?? 0
            ];

          

        if($request->hasFile('phc_image') && $file = $request->file('phc_image')) {
            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file,'/',$phc->image_url);
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if($request->hasFile('property_document') && $file = $request->file('property_document')) {
            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file,'/',$phc->property_document_url);
                $input['property_document_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }


        $result = $phc->update($input);

        updatedResponse("PHC Updated Successfully");

        return redirect()->route('phc.index');
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
        $phc = PHC::find($id);

        if ($phc->property_document_url) {
            $phc->update(['property_document_url' => null]);
        }

        return redirect()->back()->with('success', 'Land Document deleted successfully.');
    }

    public function rules($id="") {

        $rules = array();

        if($id) {
            $rules['name'] = "required|unique:p_h_c_s,name,{$id},id,block_id,{request('block_id')}|min:2|max:99";
        } else {
            $rules['name'] = "required|unique:p_h_c_s,name,null,id,block_id,{request('block_id')}|min:2|max:99";
        }

        $rules['block_id'] = 'required';
        $rules['phc_image'] = 'sometimes|mimes:png,jpg,jpeg|max:4096';
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

    public function listPHC(Request $request) {
        $validator = Validator::make($request->all(),[
            'block_id' => 'sometimes|exists:blocks,id,status,'._active(),
        ]);

        if($validator->fails()) {
            return sendError($validator->errors());
        }
        $phcs = PHC::collectPhcData($request->block_id);
        // dd($phcs);
        return sendResponse(DDPHCResource::collection($phcs));
    }
    public function export(Request $request)
{
    $blockId = $request->get('block_id');
    return Excel::download(new PHCExport($blockId), 'phc-list.xlsx');
}
}
