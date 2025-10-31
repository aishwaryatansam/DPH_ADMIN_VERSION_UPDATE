<?php

namespace App\Http\Controllers\Admin;

use App\Models\ConfigurationDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConfigurationDetailsResource;
use App\Http\Resources\ConfigurationResource;
use App\Models\Configuration;
use App\Services\FileService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SocialMediaPostController extends Controller
{
    private $configurations_image_path = '/configurations/social_media_post';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = ConfigurationDetails::getConfigurationDetailsData($id = 28);
        //$result = DB::table('configurations')->where('id', $id)->first();
        $statuses = _getGlobalStatus();
        return view('admin.configurations.social-media-post.list', compact('results', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $statuses = _getGlobalStatus();
        $social_media_type = getSocialMediaType();
        $menu_to_show = getMenuToShow();
        return view('admin.configurations.social-media-post.create', compact('statuses', 'social_media_type', 'menu_to_show'));
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
                'menu_to_show' => $request->menu_to_show,
                'link' => $request->link,
                'configuration_content_type_id' => 28,
                'status' => $request->status ?? 0
            ];



        if($request->hasFile('social_media_post_image') && $file = $request->file('social_media_post_image')) {

            if($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, $this->configurations_image_path);

                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = ConfigurationDetails::create($input);

        createdResponse("Social Media Created Successfully");

        return redirect()->route('social-media-post.index');
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
        return view('admin.configurations.social-media-post.show',compact('result'));
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
        $social_media_type = getSocialMediaType();
        $menu_to_show = getMenuToShow();
        return view('admin.configurations.social-media-post.edit',compact('result', 'statuses', 'social_media_type', 'menu_to_show'));
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
        $config_social_media_post = ConfigurationDetails::find($id);
        $input = [
                'name' => $request->name,
                'link' => $request->link,
                'menu_to_show' => $request->menu_to_show,
                'status' => $request->status ?? 0
            ];



        if($request->hasFile('social_media_post_image') && $file = $request->file('social_media_post_image')) {

            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, $this->configurations_image_path, $config_social_media_post->image_url );
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = $config_social_media_post->update($input);

        createdResponse("Social Media Post Updated Successfully");

        return redirect()->route('social-media-post.index');
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

    public function getSocialMediaPost(){
        $resources = Configuration::getConfigurationData();
        $configDetails = ConfigurationDetails::all();

        if ($resources->isEmpty()) {
            return sendResponse([], 'Configuration not found', 404);
        }

        $filteredDetails = $configDetails
        ->where('configuration_content_type_id', 28)
        ->where('status', 1)
        ->whereIn('menu_to_show', [2,3])
        ->values();

    // Use ConfigurationDetailsResource for the filtered data
    $response = ConfigurationDetailsResource::collection($filteredDetails);

    return sendResponse($response);
    }
}
