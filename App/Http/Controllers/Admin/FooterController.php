<?php

namespace App\Http\Controllers\admin;

use App\Models\ConfigurationDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Http\Resources\ConfigurationResource;
use App\Services\FileService;
use Illuminate\Support\Facades\Validator;

class FooterController extends Controller
{
    private $footer_image_path = '/configurations/footer_logo';
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
        //
    }

    public function storeLink(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $input = [
            'name' => $request->name,
            'link' => $request->link,
            'configuration_content_type_id' => $request->configuration_content_type_id,           // 6 - Important Link
            'status' => $request->status ?? 0
        ];


        $result = ConfigurationDetails::create($input);

        createdResponse("Footer Link Created Successfully");

        return redirect('/footer');
    }
    public function storeLogo(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $input = [
            'name' => $request->name,
            'configuration_content_type_id' => 4,           // 4 - Footer Logo
            'status' => $request->status ?? 0
        ];



        if ($request->hasFile('footer_logo_image') && $file = $request->file('footer_logo_image')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, $this->footer_image_path);

                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = ConfigurationDetails::create($input);

        createdResponse("Footer Logo Created Successfully");

        return redirect('/footer');
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
        $result = Configuration::getLatestConfig();
        //$result = DB::table('configurations')->where('id', $id)->first();
        $footer_logos = ConfigurationDetails::getConfigurationDetailsData($id = 4);
        $footer_detail = Configuration::getConfigurationDetail($id = 3);   // 3 - Footer details
        $footer_jd = Configuration::getConfigurationDetail($id = 4);   // 4 - Footer details
        $important_links = ConfigurationDetails::getConfigurationDetailsData($id = 6);   // 6 - Important links
        $quick_links = ConfigurationDetails::getConfigurationDetailsData($id = 7);      // 7 - Quick Links
        $public_links = ConfigurationDetails::getConfigurationDetailsData($id = 8);      // 8 - Publick Links
        $resources = ConfigurationDetails::getConfigurationDetailsData($id = 9);      // 9 - Resource
        $emergency_contacts = ConfigurationDetails::getConfigurationDetailsData($id = 10);      // 10 - Emergency Contacts

        // dd($footer_detail->toArray());
        $statuses = _getGlobalStatus();
        return view('admin.configurations.footer',compact('result','statuses', 'footer_logos', 'footer_detail', 'footer_jd', 'important_links', 'quick_links', 'public_links', 'resources', 'emergency_contacts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateFooter(Request $request, $id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(),$this->rules($id),$this->messages(),$this->attributes());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                        ->withInput();
        }

        $notification = Configuration::find($id);


        $input = array();
        $input = [
                'dph_address' => $request->dph_address,
                'dph_zip_code' => $request->dph_zip_code,
                'dph_city' => $request->dph_city,
                'dph_state' => $request->dph_state,
                'dph_phone' => $request->dph_phone,
                'dph_email' => $request->dph_email,
                'joint_director_designation' => $request->joint_director_designation,
                'joint_director_email' => $request->joint_director_email,
                'joint_director_phone' => $request->joint_director_phone,
                'dph_full_form_tamil' => $request->footer_gov_name_tamil,
            ];
        // dd($input);



        // if($request->hasFile('footer_logo_one') && $file = $request->file('footer_logo_one')) {
        //     if($file->isValid()) {
        //         $storedFileArray = FileService::updateAndStoreFile($file,'/footer_logo',$notification->footer_logo_one);
        //         $input['footer_logo_one'] = $storedFileArray['stored_file_path'] ?? '';
        //     }
        // } else {
        //     $input['footer_logo_one'] = $notification->footer_logo_one;
        // }


        // dd($input);
        $result = $notification->update($input);

        updatedResponse("Footer Updated Successfully!");

        return redirect('/footer');
    }

    public function updateFooterLink(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $validator = Validator::make($request->all(),$this->rules($id),$this->messages(),$this->attributes());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                        ->withInput();
        }
        // dd($request->all());

        $notification = ConfigurationDetails::find($id);
        // dd($notification->toArray());

        $input = array();
        $input = [
            'name' => $request->name,
            'link' => $request->link,
            'status' => $request->status ?? 0

            ];
        // dd($input);



        // if($request->hasFile('footer_logo_one') && $file = $request->file('footer_logo_one')) {
        //     if($file->isValid()) {
        //         $storedFileArray = FileService::updateAndStoreFile($file,'/footer_logo',$notification->footer_logo_one);
        //         $input['footer_logo_one'] = $storedFileArray['stored_file_path'] ?? '';
        //     }
        // } else {
        //     $input['footer_logo_one'] = $notification->footer_logo_one;
        // }


        // dd($input);
        $result = $notification->update($input);

        updatedResponse("Footer Link Updated Successfully!");

        return redirect('/footer');
    }

    public function updateFooterLogo(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $validator = Validator::make($request->all(), $this->rules($id), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $footer_logo = ConfigurationDetails::find($id);
        // dd($notification->toArray());


        $input = array();
        $input = [

            'name' => $request->name ?? $footer_logo->name,
            'status' => $request->status ?? 0,
        ];

        if($request->hasFile('footer_logo_image') && $file = $request->file('footer_logo_image')) {

            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, $this->footer_image_path, $footer_logo->image_url );
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }




        $result = $footer_logo->update($input);

        updatedResponse("Footer Logo Updated Successfully");
        return redirect('/footer');
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


        $rules['footer_logo_image'] = 'sometimes|mimes:png,jpg,jpeg|max:1024*5';
        $rules['name'] = 'sometimes|nullable';
        $rules['status'] = 'sometimes|boolean';
        $rules['dph_address'] = 'sometimes|nullable|min:3|max:100';
        $rules['dph_zip_code'] = 'sometimes|nullable|min:3|max:100';
        $rules['dph_city'] = 'sometimes|nullable|min:3|max:100';
        $rules['dph_state'] = 'sometimes|nullable|min:3|max:100';
        $rules['dph_phone'] = 'sometimes|nullable|min:3|max:100';
        $rules['joint_director_email'] = 'sometimes|nullable|min:3|max:100';
        $rules['joint_director_phone'] = 'sometimes|nullable|min:3|max:100';
        $rules['footer_gov_name_tamil'] = 'sometimes|nullable|min:3|max:100';

        return $rules;
    }

     public function messages() {
        return [];
    }

    public function attributes() {
        return [];
    }

    public function getConfiguration(){

        $resource = Configuration::getConfigurationData();
        return sendResponse(ConfigurationResource::collection(collect($resource)));


    }
}
