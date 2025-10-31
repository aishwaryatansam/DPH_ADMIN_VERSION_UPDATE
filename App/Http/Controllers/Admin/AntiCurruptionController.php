<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AntiCurruption;
use Illuminate\Support\Facades\Validator;

class AntiCurruptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = AntiCurruption::getQueriedResult();
        // dd($results);
        $statuses = _getGlobalStatus();
        return view('admin.configurations.anti-curruption.list', compact('results', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
        return view('admin.configurations.anti-curruption.create', compact('statuses'));
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
            // 'description' => $request->description,
            // 'address' => $request->address,
            // 'fax_number' => $request->fax_number,
            // 'phone_number' => $request->phone_number,
            // 'website' => $request->website,

            'tamildescription' => $request->tamildescription,
            'englishdescription' => $request->englishdescription,
            'tamiladdress' => $request->tamiladdress,
            'englishaddress'  => $request->englishaddress,
            'website'  => $request->website,
            'fax_number' => $request->fax_number,
            'phone_number' => $request->phone_number,
            'status' => $request->status ?? 0,
        ];

        $result = AntiCurruption::create($input);

        createdResponse("Anti Curruption Created Successfully");

        return redirect()->route('anti-curruption.index');
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
        $result = AntiCurruption::find($id);
        $statuses = _getGlobalStatus();
        return view('admin.configurations.anti-curruption.edit', compact('result', 'statuses'));
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
        $anti_curruption = AntiCurruption::find($id);
        // dd($request->toArray());
        $input = [
            'tamildescription' => $request->tamildescription,
            'englishdescription' => $request->englishdescription,
            'tamiladdress' => $request->tamiladdress,
            'englishaddress'  => $request->englishaddress,
            'website'  => $request->website,
            'fax_number' => $request->fax_number,
            'phone_number' => $request->phone_number,
            'status' => $request->status ?? 0,
        ];

        $result = $anti_curruption->update($input);

        createdResponse("Anti Curruption Updated Successfully");

        return redirect()->route('anti-curruption.index');
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

        $rules['tamildescription'] = 'required';
        $rules['englishdescription'] = 'required';
        $rules['tamiladdress'] = 'required';
        $rules['englishaddress'] = 'required';
        $rules['status'] = 'sometimes|boolean';
        $rules['fax_number'] = 'sometimes|nullable|string';
        $rules['phone_number'] = 'sometimes|nullable|string';
        $rules['website'] = 'sometimes|nullable|string';

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
