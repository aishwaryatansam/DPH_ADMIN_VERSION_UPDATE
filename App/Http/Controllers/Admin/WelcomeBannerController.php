<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\FileService;
use App\Models\ConfigurationDetails;

class WelcomeBannerController extends Controller
{
    private $welcome_banner_image_path = '/configurations/partner';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = ConfigurationDetails::getConfigurationDetailsData($id = 12);
        //$result = DB::table('configurations')->where('id', $id)->first();
        $statuses = _getGlobalStatus();
        return view('admin.configurations.welcome-banner.list', compact('results', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
        return view('admin.configurations.welcome-banner.create', compact('statuses'));
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
                'configuration_content_type_id' => 12,           // 12 - Welcome Image
                'status' => $request->status ?? 0
            ];

          

        if($request->hasFile('welcome_image') && $file = $request->file('welcome_image')) {

            if($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, $this->welcome_banner_image_path);

                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = ConfigurationDetails::create($input);

        createdResponse("Welcome Banner Created Successfully");

        return redirect()->route('welcome-banner.index');
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
        return view('admin.configurations.welcome-banner.edit',compact('result', 'statuses'));
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
        $input = [
                'name' => $request->name,
                'link' => $request->link,
                'status' => $request->status ?? 0
            ];

          

        if($request->hasFile('welcome_image') && $file = $request->file('welcome_image')) {

            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, $this->welcome_banner_image_path, $partner->image_url );
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = $partner->update($input);

        createdResponse("Welcome Banner Updated Successfully");

        return redirect()->route('welcome-banner.index');
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
        $rules['welcome_image'] = 'sometimes|mimes:png,jpg,jpeg|max:4096';
        $rules['link'] = 'sometimes|nullable';
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
