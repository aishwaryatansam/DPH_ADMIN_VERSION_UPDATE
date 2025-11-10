<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HUD;
use App\Models\District;
use Validator;
use App\Services\FileService;
use App\Exports\DistrictExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\FetchTag;
class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
public function index(Request $request)
{
    // Start query with optional relationships
    $query = District::orderBy('name');

    // ✅ Keyword search
    if ($request->filled('keyword')) {
        $keyword = $request->keyword;
        $query->where('name', 'like', "%{$keyword}%");
    }

    // ✅ Pagination (default 10 per page, customizable via dropdown)
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

    return view('admin.masters.districts.list', compact('results'));
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
         $tags = FetchTag::where('status', 1)->orderBy('name')->get(['id', 'name']);
        return view('admin.masters.districts.create', compact('statuses', 'tags'));
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

        $input = [
            'name' => $request->name,
            'status' => $request->status ?? 0,
            'tags' => is_array($request->tags) ? implode(',', $request->tags) : $request->tags,

            // 'location_url' => $request->location_url,

        ];
        if ($request->hasFile('district_image') && $file = $request->file('district_image')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file);

                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = District::create($input);

        createdResponse("District Created Successfully");

        return redirect()->route('districts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = District::with([])->find($id);
        $district = new District();
        return view('admin.masters.districts.show', compact('result'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = District::with([])->find($id);
        $statuses = _getGlobalStatus();
 $tags =FetchTag::where('status', _active())->orderBy('name')->pluck('name', 'id');
$selectedTags = $result->tags ? explode(',', $result->tags) : [];
        return view('admin.masters.districts.edit', compact('result', 'statuses','tags', 'selectedTags'));
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

        $district = District::find($id);

        $input = array();
        $input = [
            'name' => $request->name,
            'location_url' => $request->location_url,
            'status' => $request->status ?? 0,
             'tags' => is_array($request->tags) ? implode(',', $request->tags) : $request->tags,
        ];

        if ($request->hasFile('district_image') && $file = $request->file('district_image')) {
            if ($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, '/', $district->image_url);
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = $district->update($input);

        updatedResponse("District Updated Successfully");

        return redirect()->route('districts.index');
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

        if ($id) {
            $rules['name'] = "required|unique:districts,name,{$id},id|min:2|max:99";
        } else {
            $rules['name'] = "required|unique:districts,name|min:2|max:99";
        }

        $rules['district_image'] = 'sometimes|mimes:png,jpg,jpeg|max:4096';
        $rules['location_url'] = 'sometimes|nullable|url';
        // $rules['status'] = 'required|boolean';

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

    public function listDistrict()
    {

        $districts = District::getDistrictData();
        return sendResponse($districts);
    }

public function export()
{
    $fileName = 'Districts_' . date('Y-m-d') . '.xlsx';
    return Excel::download(new DistrictExport, $fileName);
}
}
