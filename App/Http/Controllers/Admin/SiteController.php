<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\WebsiteDocumentResource;
use App\Models\Designation;
use App\Models\NewDocument;
use App\Models\SiteContent;
use App\Models\SiteContentBanners;
use App\Models\SiteContentCertificates;
use App\Models\SiteContentMembers;
use App\Services\FileService;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    public function getEhicsCommittee()
    {
        $result = SiteContent::where('configuration_content_type_id', 23)->first();
        // dd($result->name);
        $banner_images = SiteContentBanners::getSiteContentBanners($result->id);
        $certificates = SiteContentCertificates::getSiteContentCertificates($result->id);
        $members = SiteContentMembers::getSiteContentMembers($result->id);  
        // dd($members->toArray());
        $designations = Designation::where('status', _active())->get();

        return view('admin.research.ethics-committee.create',compact('result', 'designations', 'banner_images', 'certificates', 'members'));
    }

    public function updateEhicsCommittee(Request $request)
    {
        // dd('its wroking');
        


        $validator = Validator::make($request->all(),$this->rules(),$this->messages(),$this->attributes());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                        ->withInput();
        }

        $ethics_committee = SiteContent::where('configuration_content_type_id', 23)->first();

        
        $input = array();
        $input = [

                'name' => $request->name,
                'scroller_notification_name' => $request->scroller_notification_name,
                'scroller_notification_link' => $request->scroller_notification_link,
                'description' => $request->description,
                'contact_description' => $request->contact_description,
                'email' => $request->email,
            ];

       

        if($request->hasFile('scroller_notification_image') && $file = $request->file('scroller_notification_image')) {
            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file,'/ethics_committee',$ethics_committee->image_url);
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        } else {
            $input['image_url'] = $ethics_committee->image_url;
        }

        if($request->hasFile('document') && $file = $request->file('document')) {
            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file,'/ethics_committee',$ethics_committee->document_url);
                $input['document_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        } else {
            $input['document_url'] = $ethics_committee->document_url;
        }

        
        // dd($input);
        $result = $ethics_committee->update($input);

        updatedResponse("Ethics Committee Updated Successfully!");

        return redirect('/ethics-committee');
    }

    public function updateScientificAdvisoryCommittee(Request $request)
    {
        // dd('its wroking');
        


        $validator = Validator::make($request->all(),$this->rules(),$this->messages(),$this->attributes());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                        ->withInput();
        }

        $scientific_advisory = SiteContent::where('configuration_content_type_id', 24)->first();

        
        $input = array();
        $input = [

                'name' => $request->name,
                'description' => $request->description,
            ];
        
        // dd($input);
        $result = $scientific_advisory->update($input);

        updatedResponse("Scientific Advisory Committee Updated Successfully!");

        return redirect('/scientific-advisory-committee');
    }


    public function storeBanner(Request $request)
    {
        // dd('its wroking');
        


        $validator = Validator::make($request->all(),$this->rules(),$this->messages(),$this->attributes());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                        ->withInput();
        }
        $site_content_id = SiteContent::where('configuration_content_type_id', $request->configuration_content_type_id)->value('id');
        // dd($site_content_id);
        $input = array();
        $input = [

                'name' => $request->name,
                'order_no' => $request->order_no,
                'status' => $request->status ?? 0,
                'site_content_id' => $site_content_id
            ];

       

        if($request->hasFile('banner_iamge') && $file = $request->file('banner_iamge')) {
            if($file->isValid()) {
                $storedFileArray = FileService::storeFile($file,'/ethics_committee');
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        
        // dd($input);
        $result = SiteContentBanners::create($input);

        updatedResponse("Banner Immage Stored Successfully!");

        return redirect($request->configuration_content_type_id == '23' ? '/ethics-committee' : '/scientific-advisory-committee');
    }

    public function storeCertificate(Request $request)
    {
        // dd('its wroking');
        


        $validator = Validator::make($request->all(),$this->rules(),$this->messages(),$this->attributes());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                        ->withInput();
        }
        $site_content_id = SiteContent::where('configuration_content_type_id', $request->configuration_content_type_id)->value('id');
        // dd($site_content_id);
        $input = array();
        $input = [
                'order_no' => $request->order_no,
                'status' => $request->status ?? 0,
                'site_content_id' => $site_content_id
            ];

       

        if($request->hasFile('certificate_image') && $file = $request->file('certificate_image')) {
            if($file->isValid()) {
                $storedFileArray = FileService::storeFile($file,'/ethics_committee');
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        
        // dd($input);
        $result = SiteContentCertificates::create($input);

        updatedResponse("Certificate Image Stored Successfully!");

        return redirect('/ethics-committee');
    }

    public function storeMember(Request $request)
    {
        // dd('its wroking');
        


        $validator = Validator::make($request->all(),$this->rules(),$this->messages(),$this->attributes());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                        ->withInput();
        }
        $site_content_id = SiteContent::where('configuration_content_type_id', $request->configuration_content_type_id)->value('id');
        // dd($site_content_id);
        $input = array();
        $input = [

                'name' => $request->name,
                'order_no' => $request->order_no,
                'qualification' => $request->qualification,
                'institution' => $request->institution,
                'position' => $request->position,
                'designations' => $request->designations,
                'affiliation' => $request->affiliation ?? 0,
                'status' => $request->status ?? 0,
                'is_head' => $request->is_head ?? 0,
                'site_content_id' => $site_content_id
            ];

        
        // dd($input);
        $result = SiteContentMembers::create($input);

        updatedResponse("Member Stored Successfully!");

        return redirect($request->configuration_content_type_id == '23' ? '/ethics-committee' : '/scientific-advisory-committee');
    }

    public function updateMember(Request $request)
    {
        // dd('its wroking');
        

        $id = $request->id;
        $validator = Validator::make($request->all(),$this->rules(),$this->messages(),$this->attributes());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                        ->withInput();
        }
        $member = SiteContentMembers::find($id);
        // dd($site_content_id);
        $input = array();
        $input = [

                'name' => $request->name,
                'order_no' => $request->order_no,
                'qualification' => $request->qualification,
                'institution' => $request->institution,
                'position' => $request->position,
                'designations' => $request->designations,
                'affiliation' => $request->affiliation ?? 0,
                'status' => $request->status ?? 0,
            ];

        
        // dd($input);
        $result = $member->update($input);

        updatedResponse("Member Updated Successfully!");

        return redirect($member->site_content->configuration_content_type->id == '23' ? '/ethics-committee' : '/scientific-advisory-committee');
    }

    public function updateBanner(Request $request)
    {
        // dd('its wroking');
        

        $id = $request->id;
        $validator = Validator::make($request->all(),$this->rules(),$this->messages(),$this->attributes());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                        ->withInput();
        }
        $banner_image = SiteContentBanners::find($id);
        // dd($site_content_id);
        $input = array();
        $input = [

                'name' => $request->name,
                'order_no' => $request->order_no,
                'status' => $request->status ?? 0,
            ];

       

        if($request->hasFile('banner_image') && $file = $request->file('banner_image')) {
            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file,'/ethics_committee', $banner_image->image_url);
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

    
        $result = $banner_image->update($input);

        updatedResponse("Banner Image Updated Successfully!");

        return redirect($banner_image->site_content->configuration_content_type->id == '23' ? '/ethics-committee' : '/scientific-advisory-committee');
    }

    public function updateCertificate(Request $request)
    {
        // dd('its wroking');
        

        $id = $request->id;
        $validator = Validator::make($request->all(),$this->rules(),$this->messages(),$this->attributes());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                        ->withInput();
        }
        $certificate_image = SiteContentCertificates::find($id);
        // dd($site_content_id);
        $input = array();
        $input = [

                'order_no' => $request->order_no,
                'status' => $request->status ?? 0,
            ];

       

        if($request->hasFile('certificate_image') && $file = $request->file('certificate_image')) {
            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file,'/ethics_committee', $certificate_image->image_url);
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

    
        $result = $certificate_image->update($input);

        updatedResponse("Certificate Image Updated Successfully!");

        return redirect('/ethics-committee');
    }

    public function getScientificAdvisoryCommittee()
    {
        $result = SiteContent::where('configuration_content_type_id', 24)->first();
        $designations = Designation::where('status', _active())->get();
        $banner_images = SiteContentBanners::getSiteContentBanners($result->id);
        // dd($banner_images->toArray());
        $members = SiteContentMembers::getSiteContentMembers($result->id);
        $head_members = SiteContentMembers::getSiteContentHeadMembers($result->id);  
        return view('admin.research.scientific-advisory-committee.create',compact('result', 'designations', 'banner_images', 'members', 'head_members'));
    }

    public function rules($id="") {

        $rules = array();


        $rules['footer_logo_image'] = 'sometimes|mimes:png,jpg,jpeg|max:1024*5';
        $rules['name'] = 'sometimes|nullable';
        $rules['status'] = 'sometimes|boolean';
        $rules['description'] = 'sometimes|nullable';
        $rules['contact_description'] = 'sometimes|nullable|min:2|max:200';
        $rules['email'] = 'sometimes|nullable|email|max:99';
        
        return $rules;
    }

     public function messages() {
        return [];
    }

    public function attributes() {
        return [];
    }

    public function getEthicsCommittee()  {
        
        $ethicsCommittee = SiteContent::getSiteContentData(23);
        $response = [
            'title' => $ethicsCommittee ? $ethicsCommittee->name : '',
            'description' => $ethicsCommittee ? $ethicsCommittee->description : '',
            'notification_icon' => $ethicsCommittee ? fileLink($ethicsCommittee->image_url) : '',
            'notification_title' => $ethicsCommittee ? $ethicsCommittee->scroller_notification_name : '',
            'notification_link' => $ethicsCommittee ? $ethicsCommittee->scroller_notification_link : '',
            'document' => $ethicsCommittee ? fileLink($ethicsCommittee->document_url) : '',
            'contact_description' => $ethicsCommittee ? $ethicsCommittee->contact_description : '',
            'contact_email' => $ethicsCommittee ? $ethicsCommittee->email : '',
            'members' => [],
            'banners' => [],
            'certificates' => []
        ];

        if ($ethicsCommittee) {
            $members = SiteContentMembers::getMembersData($ethicsCommittee->id);
    
            // Format members data
            foreach ($members as $member) {
                $response['members'][] = [
                    'name' => $member->name,
                    'qualification' => $member->qualification,
                    'institution' => $member->institution,
                    'designation' => $member->designations,
                    'affiliation' => $member->affiliation,
                ];
            }
    
            // Fetch Banners related to the Ethics Committee
            $banners = SiteContentBanners::getBannersData($ethicsCommittee->id);
    
            // Format banners data (for 'images' section)
            foreach ($banners as $banner) {
                $response['banners'][] = [
                    'image' => fileLink($banner->image_url),
                    'title' => $banner->name,
                ];
            }
    
            // Fetch Certificates related to the Ethics Committee
            $certificates = SiteContentCertificates::getCertificatesData($ethicsCommittee->id);
    
            // Format certificates data (for 'images1' section)
            foreach ($certificates as $certificate) {
                $response['certificates'][] = [
                    'image' => fileLink($certificate->image_url),
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => $response,
        ]);

    }

    public function getScientificCommittee()  {
        
        $ethicsCommittee = SiteContent::getSiteContentData(24);
        $response = [
            'title' => $ethicsCommittee ? $ethicsCommittee->name : '',
            'description' => $ethicsCommittee ? $ethicsCommittee->description : '',
            'members' => [],
            'head_members' => [],
            'banners' => [],
        ];

        if ($ethicsCommittee) {
            $members = SiteContentMembers::getMembersData($ethicsCommittee->id);
    
            // Format members data
            foreach ($members as $member) {
                $response['members'][] = [
                    'name' => $member->name,
                    'qualification' => $member->qualification,
                    'institution' => $member->institution,
                    'designation' => $member->designations,
                    'affiliation' => $member->affiliation,
                ];
            }

            $head_members = SiteContentMembers::getHeadMembersData($ethicsCommittee->id);
    
            // Format members data
            foreach ($head_members as $member) {
                $response['head_members'][] = [
                    'name' => $member->name,
                    'qualification' => $member->qualification,
                    'position' => $member->position,
                    'designation' => $member->designations,
                ];
            }

            
    
            // Fetch Banners related to the Ethics Committee
            $banners = SiteContentBanners::getBannersData($ethicsCommittee->id);
    
            // Format banners data (for 'images' section)
            foreach ($banners as $banner) {
                $response['banners'][] = [
                    'image' => fileLink($banner->image_url),
                    'title' => $banner->name,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => $response,
        ]);

    }

    public function getDphNewsletter()  {
        
        $newsletters = SiteContent::getManySiteContentData(25);
        $response = $newsletters->map(function ($newsletter) {
            return [
                'title' => $newsletter->name ?? '',
                'description' => $newsletter->description ?? '',
                'document' => fileLink($newsletter->document_url) ?? '',
                'image' => fileLink($newsletter->image_url) ?? '',
                'date' => $newsletter->date ?? '',
                'volume' => $newsletter->volume ?? '',
                'issue' => $newsletter->issue ?? '',
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $response,
        ]);

    }


    public function getPublication(){
        $documents = NewDocument::getNavigationDocument(5);
        return sendResponse(WebsiteDocumentResource::collection($documents));
    }

}
