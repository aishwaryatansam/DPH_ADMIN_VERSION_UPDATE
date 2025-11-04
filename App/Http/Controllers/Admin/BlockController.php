<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\HUD;
use Validator;
use App\Services\FileService;
use App\Http\Resources\Dropdown\BlockResource as DDBlockResource;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BlockExport;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
// public function index(Request $request)
// {
//     $perPage = (int) $request->get('pageLength', 10);
//     if ($perPage <= 0) $perPage = 10;

//     $keyword = $request->get('keyword');

//     $query = Block::with('hud')->orderBy('name');

//     // 🔍 Search filter
//     if (!empty($keyword)) {
//         $query->where(function ($q) use ($keyword) {
//             $q->where('name', 'like', "%{$keyword}%")
//               ->orWhereHas('hud', function ($q2) use ($keyword) {
//                   $q2->where('name', 'like', "%{$keyword}%");
//               });
//         });
//     }

//     $results = $query->paginate($perPage)->appends($request->query());

//     $huds = HUD::where('status', _active())->orderBy('name')->get();

//     return view('admin.masters.blocks.list', compact('results', 'huds'));
// }

public function index(Request $request)
{
    $query = Block::with('hud')->orderBy('name');

    // Keyword search (if you have a search box)
    if ($request->filled('keyword')) {
        $keyword = $request->keyword;
        $query->where('name', 'like', "%{$keyword}%")
              ->orWhereHas('hud', function ($q) use ($keyword) {
                  $q->where('name', 'like', "%{$keyword}%");
              });
    }

    // ✅ HUD filter
    if ($request->filled('hud_id')) {
        $query->where('hud_id', $request->hud_id);
    }

    // ✅ Pagination
    $results = $query->paginate($request->get('pageLength', 10))->appends($request->query());

    // HUD dropdown data
    $huds = HUD::where('status', _active())->orderBy('name')->get();

    return view('admin.masters.blocks.list', compact('results', 'huds'));
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
        $is_urban = _isUrban();
        return view('admin.masters.blocks.create',compact('huds','statuses', 'is_urban'));
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
                'hud_id' => $request->hud_id,
                // 'location_url' => $request->location_url,
                // 'video_url' => $request->video_url,
                // 'is_urban' => $request->is_urban,
                'status' => $request->status ?? 0
            ];


        if($request->hasFile('block_image') && $file = $request->file('block_image')) {

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

        $result = Block::create($input);

        createdResponse("Block Created Successfully");

        return redirect()->route('blocks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show($id)
    {
        $result = Block::with(['hud'])->find($id);
        return view('admin.masters.blocks.show',compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = Block::with(['hud'])->find($id);
        $statuses = _getGlobalStatus();
        $huds = Hud::collectHudData();
        $is_urban = _isUrban();
        return view('admin.masters.blocks.edit',compact('result','huds','statuses', 'is_urban'));
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

        $block = Block::find($id);

        $input = array();
        $input = [
                'name' => $request->name,
                'hud_id' => $request->hud_id,
                // 'location_url' => $request->location_url,
                // 'video_url' => $request->video_url,
                // 'is_urban' => $request->is_urban,
                'status' => $request->status ?? 0
            ];

             

        if($request->hasFile('block_image') && $file = $request->file('block_image')) {
            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file,'/',$block->image_url);
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if($request->hasFile('property_document') && $file = $request->file('property_document')) {
            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file,'/',$block->property_document_url);
                $input['property_document_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = $block->update($input);

        updatedResponse("Block Updated Successfully");

        return redirect()->route('blocks.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd('ss');
    }

   
    public function destroyDocument($id)
    {        
        $block = Block::find($id);

        // Delete the property document
        if ($block->property_document_url) {
            $block->update(['property_document_url' => null]);
        }

        return redirect()->back()->with('success', 'Land Document deleted successfully.');
    }


    public function rules($id="") {

        $rules = array();

        if($id) {
            $rules['name'] = "required|unique:blocks,name,{$id},id,hud_id,{request('hud_id')}|min:2|max:99";
        } else {
            $rules['name'] = "required|unique:blocks,name,null,id,hud_id,{request('hud_id')}|min:2|max:99";
        }

        $rules['hud_id'] = 'required';
        $rules['block_image'] = 'sometimes|mimes:png,jpg,jpeg|max:4096';
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

     public function listBlock(Request $request) {
        $validator = Validator::make($request->all(),[
            'hud_id' => 'sometimes|exists:huds,id,status,'._active(),
        ]);

        if($validator->fails()) {
            return sendError($validator->errors());
        }
        $blocks = Block::collectBlockData($request->hud_id);
        return sendResponse(DDBlockResource::collection($blocks));
    }
    public function export(Request $request)
{
    $filename = 'blocks-' . date('d-m-Y') . '.xlsx';
    return Excel::download(new BlockExport, $filename);
}

}
