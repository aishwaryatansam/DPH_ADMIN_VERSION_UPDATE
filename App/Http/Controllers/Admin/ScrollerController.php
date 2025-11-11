<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ConfigurationDetails;
use Illuminate\Support\Facades\Validator;

class ScrollerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = ConfigurationDetails::getConfigurationDetailsData($id = 11);
        //$result = DB::table('configurations')->where('id', $id)->first();
        $statuses = _getGlobalStatus();
        return view('admin.configurations.scroller-notif.list', compact('results', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
        return view('admin.configurations.scroller-notif.create', compact('statuses'));
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
            'title' => $request->title,
                'name' => $request->name,
                'link' => $request->link,
                'configuration_content_type_id' => 11,           // 11 - Scroller Notification
                'status' => $request->status ?? 0
            ];


        $result = ConfigurationDetails::create($input);

        createdResponse("Scroller Notification Created Successfully");

        return redirect()->route('scroller-notif.index');
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
        return view('admin.configurations.scroller-notif.edit',compact('result', 'statuses'));
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
        $result = ConfigurationDetails::find($id);
        $input = [
            'title' => $request->title,
                'name' => $request->name,
                'link' => $request->link,
                'status' => $request->status ?? 0
            ];


        $result = $result->update($input);

        createdResponse("Scroller Notification Updated Successfully");

        return redirect()->route('scroller-notif.index');
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
        $rules['status'] = 'sometimes|boolean';

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
