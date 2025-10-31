<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Http\Resources\ConfigurationResource;
use App\Models\ConfigurationDetails;
use App\Services\FileService;
use Illuminate\Support\Facades\Validator;

class HeaderController extends Controller
{
    private $configurations_image_path = '/configurations/header_logo';
    private $banner_image_path = '/configurations/banner';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => $request->name,
            'configuration_content_type_id' => 1,           // 1 - Header Logo
            'status' => $request->status ?? 0
        ];



        if ($request->hasFile('header_logo_image') && $file = $request->file('header_logo_image')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, $this->configurations_image_path);

                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = ConfigurationDetails::create($input);

        createdResponse("Header Logo Created Successfully");

        return redirect('/header');
    }

    public function storeBanner(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $input = [
            'name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'configuration_content_type_id' => 2,           // 2 - Header Banner
            'status' => $request->status ?? 0
        ];



        if ($request->hasFile('header_banner_image') && $file = $request->file('header_banner_image')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, $this->banner_image_path);

                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = ConfigurationDetails::create($input);

        createdResponse("banner Created Successfully");

        return redirect('/header');
    }

    public function storeButton(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $input = [
            'name' => $request->name,
            'link' => $request->link,
            'configuration_content_type_id' => 14,           // 14 - Header Button
            'status' => $request->status ?? 0
        ];



        $result = ConfigurationDetails::create($input);

        createdResponse("Button Created Successfully");

        return redirect('/header');
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
    public function edit()
    {
        $result = Configuration::getHeaderConfig();
        $header_logos = ConfigurationDetails::getHeaderLogoConfig();
        $banners = ConfigurationDetails::getConfigurationDetailsData($id = 2);
        $header_buttons = ConfigurationDetails::getConfigurationDetailsData($id = 14);
        // dd($result->getOriginal('updated_at'));
        //$result = DB::table('configurations')->where('id', $id)->first();
        $statuses = _getGlobalStatus();
        return view('admin.configurations.header', compact('result', 'statuses', 'header_logos', 'banners', 'header_buttons'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateHeaderLogo(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $validator = Validator::make($request->all(), $this->rules($id), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $header_logo = ConfigurationDetails::find($id);
        // dd($notification->toArray());


        $input = array();
        $input = [

            'name' => $request->name ?? $header_logo->name,
            'status' => $request->status ?? 0,
        ];

        if($request->hasFile('header_logo_image') && $file = $request->file('header_logo_image')) {

            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, $this->configurations_image_path, $header_logo->image_url );
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }



        $result = $header_logo->update($input);

        updatedResponse("Header Logo Updated Successfully");
        return redirect('/header');
    }

    public function updateBanner(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $validator = Validator::make($request->all(), $this->rules($id), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $haeder_banner = ConfigurationDetails::find($id);
        // dd($notification->toArray());


        $input = array();
        $input = [

            'name' => $request->name ?? $haeder_banner->name,
            'description' => $request->description ?? $haeder_banner->description,
            'date' => $request->date ?? $haeder_banner->date,
            'status' => $request->status ?? 0,
        ];

        if($request->hasFile('header_banner_image') && $file = $request->file('header_banner_image')) {

            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, $this->banner_image_path, $haeder_banner->image_url );
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }



        $result = $haeder_banner->update($input);

        updatedResponse("Banner Updated Successfully");
        return redirect('/header');
    }

    public function updateButton(Request $request)
    {
        $id = $request->id;
        $validator = Validator::make($request->all(), $this->rules($id), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $haeder_button = ConfigurationDetails::find($id);


        $input = array();
        $input = [

            'name' => $request->name ?? $haeder_button->name,
            'link' => $request->link ?? $haeder_button->link,
            'coloreffect' => $request->coloreffect ?? 0,
            'status' => $request->status ?? 0,
        ];



        $result = $haeder_button->update($input);

        updatedResponse("Button Updated Successfully");
        return redirect('/header');
    }

    public function updateHeader(Request $request, $id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), $this->rules($id), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $notification = Configuration::find($id);
        // dd($notification->toArray());


        $input = array();
        $input = [
            'tamilnadu_government_title_tamil' => $request->tamilnadu_government_title_tamil ?? $notification->tamilnadu_government_title_tamil,
            'tamilnadu_government_title_english' => $request->tamilnadu_government_title_english ?? $notification->tamilnadu_government_title_english,
            'dph_full_form_tamil' => $request->dph_full_form_tamil ?? $notification->dph_full_form_tamil,
            'dph_full_form_english' => $request->dph_full_form_english ?? $notification->dph_full_form_english,
        ];

        $result = $notification->update($input);

        updatedResponse("Header Updated Successfully");

        return redirect('/header');
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
        $rules['name'] = 'sometimes|nullable';
        $rules['description'] = 'sometimes|nullable';
        $rules['date'] = 'sometimes|nullable';
        $rules['status'] = 'sometimes|boolean';
        $rules['header_banner_image'] = 'sometimes|mimes:png,jpg,jpeg|max:5120';
        $rules['header_logo_image'] = 'sometimes|mimes:png,jpg,jpeg|max:5120';
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

    public function getConfiguration()
    {

        $resource = Configuration::getConfigurationData();
        return sendResponse(ConfigurationResource::collection(collect($resource)));
    }
}
