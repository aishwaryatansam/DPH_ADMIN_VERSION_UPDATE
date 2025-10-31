<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\Division;
use App\Services\FileService;
use Illuminate\Support\Facades\Validator;

class DivisionController extends Controller
{

    private $head_person_image_path = '/division/division_head_profile';
    private $division_icon_image_path = '/division/division_icon';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get queried result and pass it to the view
        $results = Division::getQueriedResult();
        return view('admin.divisions.list', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get global status and parent divisions and pass them to the view
        $statuses = _getGlobalStatus();
        $parent_division = Division::where(['parent_division_id' => _inactive(), 'status' => _active()])->get();
        $designations = Designation::where('status', _active())->get();
        return view('admin.divisions.create', compact('statuses', 'parent_division','designations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

                // Prepare input data
        $input = [
            'name' => $request->name,
            'division_head_name_one' => $request->division_head_name_one,
            'division_head_name_two' => $request->division_head_name_two,
            'division_head_name_three' => $request->division_head_name_three,
            'division_head_status_one' => $request->division_head_status_one ?? '0',
            'division_head_status_two' => $request->division_head_status_two ?? '0',
            'division_head_status_three' => $request->division_head_status_three ?? '0',
            'designation_id_one' => $request->designation_id_one ?? null,
            'designation_id_two' => $request->designation_id_two ?? null,
            'designation_id_three' => $request->designation_id_three ?? null,
            'status' => $request->status,
        ];

        // Set parent division ID based on request
        $input['parent_division_id'] = ($request->parent_division_id == _inactive()) ? _inactive() : $request->parent_division_id;

        // Store division icon file if provided
        if ($request->hasFile('division_icon') && $file = $request->file('division_icon')) {
            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, $this->division_icon_image_path);
                $input['division_icon'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        // Store division image file if provided
        if ($request->hasFile('division_head_image_one') && $file = $request->file('division_head_image_one')) {
            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, $this->head_person_image_path);
                $input['division_head_image_one'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('division_head_image_two') && $file = $request->file('division_head_image_two')) {
            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, $this->head_person_image_path);
                $input['division_head_image_two'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('division_head_image_three') && $file = $request->file('division_head_image_three')) {
            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, $this->head_person_image_path);
                $input['division_head_image_three'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        // Create a new division record
        $result = Division::create($input);

        // Flash success message and redirect
        createdResponse("Division Created Successfully");
        return redirect()->route('divisions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Retrieve and pass division data to the view
        $result = Division::find($id);
        $parent_division = Division::select('name')->find($result->parent_division_id);
        return view('admin.divisions.show', compact('result', 'parent_division'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Retrieve division data and related information for editing
        $result = Division::with([])->find($id);
        $parent_divisions = Division::where(['parent_division_id' => _inactive()])
            ->where('id', '!=', $id)
            ->get();
        $statuses = _getGlobalStatus();
        $designations = Designation::where('status', _active())->get();
        return view('admin.divisions.edit', compact('result', 'parent_divisions', 'statuses','designations'));
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
        // Validate the request
        $validator = Validator::make($request->all(), $this->rules($id), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }
        
        // Retrieve the division for updating
        $division = Division::find($id);
        $input = [
            'name' => $request->name,
            'division_head_name_one' => $request->division_head_name_one,
            'division_head_name_two' => $request->division_head_name_two,
            'division_head_name_three' => $request->division_head_name_three,
            'division_head_status_one' => $request->division_head_status_one ?? '0',
            'division_head_status_two' => $request->division_head_status_two ?? '0',
            'division_head_status_three' => $request->division_head_status_three ?? '0',
            'designation_id_one' => $request->designation_id_one ?? null,
            'designation_id_two' => $request->designation_id_two ?? null,
            'designation_id_three' => $request->designation_id_three ?? null,
            'status' => $request->status,
        ];

        // Set parent division ID based on request
        $input['parent_division_id'] = ($request->parent_division_id == _inactive()) ? _inactive() : $request->parent_division_id;

        // Update division icon file if provided
        if ($request->hasFile('division_icon') && $file = $request->file('division_icon')) {
            if ($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, $this->division_icon_image_path, $division->division_icon);
                $input['division_icon'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        // Update division image file if provided
        if ($request->hasFile('division_head_image_one') && $file = $request->file('division_head_image_one')) {
            if ($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, $this->head_person_image_path, $division->division_head_image_one);
                $input['division_head_image_one'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('division_head_image_two') && $file = $request->file('division_head_image_two')) {
            if ($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, $this->head_person_image_path, $division->division_head_image_two);
                $input['division_head_image_two'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('division_head_image_three') && $file = $request->file('division_head_image_three')) {
            if ($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, $this->head_person_image_path, $division->division_head_image_three);
                $input['division_head_image_three'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        // Update the division record
        $result = $division->update($input);

        // Flash success message and redirect
        updatedResponse("Division Updated Successfully");
        return redirect()->route('divisions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Implementation for destroying a resource (not provided in the original code)
        // ...
    }

    /**
     * Define validation rules for the Division model.
     *
     * @param  string  $id
     * @return array
     */
    public function rules($id = "")
    {
        $rules = [];

        $rules['name'] = "required|min:2|max:99|unique:divisions,name,{$id},id";
        $rules['division_icon'] = 'sometimes|mimes:png,jpg,jpeg|max:4096';

        $rules['division_head_name_one'] = 'sometimes|nullable|min:2|max:99';
        $rules['division_head_name_two'] = 'sometimes|nullable|min:2|max:99';
        $rules['division_head_name_three'] = 'sometimes|nullable|min:2|max:99';

        $rules['division_head_image_one'] = 'sometimes|mimes:png,jpg,jpeg|max:1024';
        $rules['division_head_image_two'] = 'sometimes|mimes:png,jpg,jpeg|max:1024';
        $rules['division_head_image_three'] = 'sometimes|mimes:png,jpg,jpeg|max:1024';

        $rules['status'] = 'required|boolean';

        return $rules;
    }

    /**
     * Get custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * Get custom attribute names for validation.
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }
    
}
