<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HUD;
use App\Models\District;
use Validator;
use App\Services\FileService;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = District::getQueriedResult();

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
        return view('admin.masters.districts.create', compact('statuses'));
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

        return view('admin.masters.districts.edit', compact('result', 'statuses'));
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
            'status' => $request->status ?? 0
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

        // Fetch data for districts
        $districts = District::select('id', 'name', 'status')->get();

        // Convert status to readable format
        $districts = $districts->map(function ($district) {
            $district->status = $district->status ? 'Active' : 'Inactive';
            return $district;
        });

        // Create and return the Excel file
        return Excel::download(new class($districts) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $data;

            public function __construct($data)
            {
                $this->data = $data;
            }

            public function collection()
            {
                return $this->data;
            }

            public function headings(): array
            {
                return [
                    'ID',
                    'Name',
                    'Status',
                ];
            }
        }, $fileName);
    }
}
