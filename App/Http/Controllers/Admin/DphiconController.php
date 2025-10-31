<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ConfigurationDetails;
use Illuminate\Support\Facades\Validator;

class DphiconController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = ConfigurationDetails::getConfigurationDetailsData($id = 13);
        // dd($results);
        $statuses = _getGlobalStatus();
        return view('admin.configurations.dph-icon.list', compact('results', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
        return view('admin.configurations.dph-icon.create', compact('statuses'));
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
                'link' => $request->link,
                'configuration_content_type_id' => 13,           // 13 - DPH icon
                'status' => $request->status ?? 0,
                'coloreffct' => $request->coloreffect ?? 0, // Save selected colors
            ];

        $result = ConfigurationDetails::create($input);

        createdResponse("DPH Icon Created Successfully");

        return redirect()->route('dph-icon.index');
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
        $result = ConfigurationDetails::find($id);
        $statuses = _getGlobalStatus();
        return view('admin.configurations.dph-icon.edit',compact('result', 'statuses'));
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
        $partner = ConfigurationDetails::find($id);
        // dd($request->toArray());
        $input = [
                'name' => $request->name,
                'link' => $request->link,
                'status' => $request->status ?? 0,
                'coloreffect' => $request->coloreffect ?? 0, // Save selected colors
            ];

        $result = $partner->update($input);

        createdResponse("DPH Icon Updated Successfully");

        return redirect()->route('dph-icon.index');
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

        $rules['name'] = 'required';
        $rules['link'] = 'sometimes|nullable';
        $rules['status'] = 'sometimes|boolean';
        $rules['coloreffect'] = 'sometimes|boolean';

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
}
