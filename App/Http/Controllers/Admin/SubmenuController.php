<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Submenu;
use Illuminate\Support\Facades\Validator;

class SubmenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Submenu::getQueriedResult();
        return view('admin.masters.submenu.list',compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.masters.submenu.create');
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
                'order' => $request->order_no,
                'configuration_content_type_id' => 17,          
                'status' => $request->status ?? 0,
                'slug' => slugger($request->name, '_'),
            ];
        
            
            // dd($input);
        $result = Submenu::create($input);

        createdResponse("About Us Submenu Created Successfully");

        return redirect()->route('submenu.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = Submenu::find($id);
        return view('admin.masters.submenu.edit',compact('result'));
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

        $submenu = Submenu::find($id);

        $input = array();
        $input = [
                'name' => $request->name,
                'order' => $request->order_no,
                'status' => $request->status ?? 0
            ];

        $result = $submenu->update($input);

        updatedResponse("About Us Submenu Updated Successfully");

        return redirect()->route('submenu.index');
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

        $rules['name'] = 'required';
        if ($id) {
            $rules['order_no'] = "required|integer|unique:submenu,order,{$id},id"; // Ensuring order_no is unique during update
        } else {
            $rules['order_no'] = "required|integer|unique:submenu,order"; // Ensuring order_no is unique during store
        }

        return $rules;
    }

    public function messages() {
        return [];
    }

    public function attributes() {
        return [];
    }
}
