<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\DesignationType;
use Validator;
use App\Http\Resources\DesignationResource;
use App\Models\Tag;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Designation::getQueriedResult();

        return view('admin.masters.designation.list',compact('results'));
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
        $designation_types = DesignationType::getDesignationTypeData();
        return view('admin.masters.designation.create',compact('statuses','designation_types'));
        
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
                'designation_type_id' => $request->designation_type_id,
                'status' => $request->status ?? 0
                
            ];
             
        $result = Designation::create($input);

        createdResponse("Designation Created Successfully");

        return redirect()->route('designations.index');

         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $result = Designation::with(['designation_type'])->find($id);
      $designation = new Designation();
        return view('admin.masters.designation.show',compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
    {
        $result = Designation::with([])->find($id);
        $designation_types = DesignationType::getDesignationTypeData();
        $statuses = _getGlobalStatus();
        
        return view('admin.masters.designation.edit',compact('result','statuses','designation_types'));
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

        $designation = Designation::find($id);

        $input = array();
        $input = [
                'name' => $request->name,
                'designation_type_id' => $request->designation_type_id,
                'status' => $request->status ?? 0
            ];

        $result = $designation->update($input);

        updatedResponse("Designation Updated Successfully");

        return redirect()->route('designations.index');
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

     public function rules($id="") {

        $rules = array();

        if($id) {
            $rules['name'] = "required|unique:designations,name,{$id},id|min:2|max:99";
        } else {
            $rules['name'] = "required|unique:designations,name|min:2|max:99";
        }

       
        $rules['designation_type_id'] = 'sometimes|integer|exists:designation_types,id';
        $rules['status'] = 'sometimes|boolean';

        return $rules;
    }

    public function messages() {
        return [];
    }

    public function attributes() {
        return ['designation_type_id' => 'Designation Type'];
    }

    public function listDesignations(Request $request) {
        $validator = Validator::make($request->all(),[
            'contact_type' => 'required|exists:designation_types,id,status,'._active(),
        ]);

        if($validator->fails()) {
            return sendError($validator->errors());
        }
        $designations = Designation::getDesignationData($request->contact_type);
        return sendResponse(DesignationResource::collection($designations));
    }


    
}
