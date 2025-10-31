<?php

namespace App\Http\Controllers\Admin;

use App\Models\ConfigurationDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\FileService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SocialMediaController extends Controller
{
    private $configurations_image_path = '/configurations/social_media';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = ConfigurationDetails::getConfigurationDetailsData($id = 5);
        //$result = DB::table('configurations')->where('id', $id)->first();
        $statuses = _getGlobalStatus();
        return view('admin.configurations.social-media.list', compact('results', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
        return view('admin.configurations.social-media.create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
         $validator = Validator::make($request->all(),$this->rules(),$this->messages(),$this->attributes());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                        ->withInput();
        }
        
        $input = [
                'name' => $request->name,
                'link' => $request->link,
                'configuration_content_type_id' => 5,           // 5 - social media
                'status' => $request->status ?? 0
            ];

          

        if($request->hasFile('social_media_image') && $file = $request->file('social_media_image')) {

            if($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, $this->configurations_image_path);

                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = ConfigurationDetails::create($input);

        createdResponse("Social Media Created Successfully");

        return redirect()->route('social-media.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = ConfigurationDetails::find($id);
        return view('admin.configurations.social-media.show',compact('result'));
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
        return view('admin.configurations.social-media.edit',compact('result', 'statuses'));
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
        $config_social_media = ConfigurationDetails::find($id);
        $input = [
                'name' => $request->name,
                'link' => $request->link,
                'status' => $request->status ?? 0
            ];

          

        if($request->hasFile('social_media_image') && $file = $request->file('social_media_image')) {

            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, $this->configurations_image_path, $config_social_media->image_url );
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = $config_social_media->update($input);

        createdResponse("Social Media Updated Successfully");

        return redirect()->route('social-media.index');
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
        $rules['configuration_image'] = 'sometimes|mimes:png,jpg,jpeg|max:4096';
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
