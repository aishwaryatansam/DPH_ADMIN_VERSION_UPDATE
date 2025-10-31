<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use App\Services\FileService;
use App\Models\Complimentary;
use App\Models\QuantityType;

class ComplimentaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $quantityTypeModel;


    public function __construct() {
        $this->quantityTypeModel = new QuantityType();

    }

    public function index()
    {
        $results = Complimentary::getQueriedResult();

        return view('admin.complimentaries.list',compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();

        $quantityTypes = $this->quantityTypeModel->getActiveRecord();

        return view('admin.complimentaries.create',compact('statuses','quantityTypes'));
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
                'lang1_name' => $request->lang1_name,
                'description' => $request->description,
                'lang1_name' => $request->lang1_name,
                'lang1_description' => $request->lang1_description,
                'quantity_type_id' => $request->quantity_type,

                'is_visible' => $request->is_visible,
                'status' => $request->status,
                'created_by'=> Auth::user()->id
            ];

        if($request->hasFile('image') && $file = $request->file('image')) {

            if($file->isValid()) {
                $storedFileArray = FileService::storeFile($file);

                $input['image_path'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = Complimentary::create($input);

        createdResponse("Complimentary Created Successfully");

        return redirect()->route('complimentaries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Complimentary  $complimentary
     * @return \Illuminate\Http\Response
     */
    public function show(Complimentary $complimentary)
    {
        $result = $complimentary;
        return view('admin.complimentaries.show',compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Complimentary  $complimentary
     * @return \Illuminate\Http\Response
     */
    public function edit(Complimentary $complimentary)
    {
        $result = $complimentary;
        $statuses = _getGlobalStatus();
        $quantityTypes = $this->quantityTypeModel->getActiveRecord();
        return view('admin.complimentaries.edit',compact('result','quantityTypes','statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Complimentary  $complimentary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),$this->rules($id),$this->messages(),$this->attributes());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                        ->withInput();
        }

        $complimentary = Complimentary::find($id);

        $input = array();
        $input = [
                'name' => $request->name,
                'lang1_name' => $request->lang1_name,
                'description' => $request->description,
                'lang1_description' => $request->lang1_description,
                'lang1_name' => $request->lang1_name,
                'quantity_type_id' => $request->quantity_type,
                'is_visible' => $request->is_visible,
                'status' => $request->status,
            ];

        if($request->hasFile('image') && $file = $request->file('image')) {
            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file,'/',$complimentary->image_path);
                $input['image_path'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = $complimentary->update($input);

        updatedResponse("Complimentary Updated Successfully");

        return redirect()->route('complimentaries.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Complimentary  $complimentary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Complimentary $complimentary)
    {
        //
    }

    public function rules($id="") {

        $rules = array();

        if($id) {
            $rules['name'] = "required|unique:complimentaries,name,{$id},id|min:2|max:99";
            $rules['lang1_name'] = "required|unique:complimentaries,lang1_name,{$id},id|min:2|max:99";

        } else {
            $rules['name'] = "required|unique:complimentaries,name|min:2|max:99";
            $rules['lang1_name'] = "required|unique:complimentaries,lang1_name|min:2|max:99";
        }

        $rules['description'] = 'sometimes|nullable|min:2|max:200';
        $rules['lang1_description'] = 'sometimes|nullable|min:2|max:200';
        $rules['image'] = 'sometimes|nullable|file|mimes:png,jpeg,jpg|max:5026';
        $rules['quantity_type'] = 'required|exists:quantity_types,id,status,'._active();
        $rules['is_visible'] = 'required|boolean';
        $rules['status'] = 'required|boolean';

        return $rules;
    }

    public function messages() {
        return [];
    }

    public function attributes() {
        return [];
    }
}
