<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ApprovalWorkflows;
use App\Models\Contact;
use App\Models\FacilityBuildingDetails;
use App\Models\FacilityDocuments;
use App\Models\FacilityHierarchy;
use App\Models\FacilityImages;
use App\Models\FacilityProfile;
use App\Services\FileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FacilityProfileController extends Controller
{
    private $facility_profile_images = '/facility_profile/images';
    private $facility_profile_documents = '/facility_profile/documents';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = FacilityProfile::getQueriedResult();
        // dd($results->toArray());
        return view('admin.facility-profile.list', compact('results'));
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd($id);
        $result = FacilityProfile::with([
            'facility_hierarchy',
            'facilityImages',
            'facilityDocuments',
            'contacts',
        ])->find($id);

        if ($result && $result->status == 1) {
            $result->load([
                'facilityImages' => function ($query) {
                    $query->where('status', 1);
                },
                'facilityDocuments' => function ($query) {
                    $query->where('status', 1); 
                },
            ]);
        }

        $approvalResult = ApprovalWorkflows::where('model_id', $id)
            ->where('model_type', 'App\Models\FacilityProfile')
            ->first();
        // dd($result->toArray());
        // Fetch facilityBuilding using facility_profile_id and facility_hierarchy_id
        $facilityBuilding = FacilityBuildingDetails::whereHas('facility_profile', function ($query) use ($result) {
            $query->where('facility_hierarchy_id', $result->facility_hierarchy->id);
        })->where('is_active', 1)->first();
        // dd($facilityBuilding->toArray());
        // Decode JSON fields and generate file links for facilityBuilding if found
        if ($facilityBuilding) {
            $result->source_of_funding = $facilityBuilding->source_of_funding ? json_decode($facilityBuilding->source_of_funding, true) : [];
            $result->electric_connections = $facilityBuilding->electric_connections ? json_decode($facilityBuilding->electric_connections, true) : [];
            $facilityBuilding->public_permission_letter = fileLink($facilityBuilding->public_permission_letter);
            $facilityBuilding->rented_lease_document_path = fileLink($facilityBuilding->rented_lease_document_path);
            $facilityBuilding->rent_free_permission_letter = fileLink($facilityBuilding->rent_free_permission_letter);
            $facilityBuilding->inauguration_images = fileLink($facilityBuilding->inauguration_images);
            $facilityBuilding->ready_current_images = fileLink($facilityBuilding->ready_current_images);
            $facilityBuilding->own_go_ms_no_pdf_path = fileLink($facilityBuilding->own_go_ms_no_pdf_path);
        }

        // Process construction images
        $constructionImages = collect($result->facilityImages)->whereBetween('image_type', [10, 19])->all();
        $currentConstructionStatus = $facilityBuilding->under_construction_type ?? null;
        $currentConstructionImages = [];
        $oldConstructionImages = [];

        foreach ($constructionImages as $image) {
            $image->image_url = fileLink($image->image_url);

            if ($image->under_construction_status == $currentConstructionStatus) {
                $currentConstructionImages[] = $image;
            } else {
                if (!isset($oldConstructionImages[$image->under_construction_status])) {
                    $oldConstructionImages[$image->under_construction_status] = [];
                }
                $oldConstructionImages[$image->under_construction_status][] = $image;
            }
        }

        // Fetch specific facility images
        $entranceImage = collect($result->facilityImages)->firstWhere('image_type', 1);
        $waitingAreaImage = collect($result->facilityImages)->firstWhere('image_type', 2);
        $otherImage = collect($result->facilityImages)->firstWhere('image_type', 3);
        $generalImage = collect($result->facilityImages)->firstWhere('image_type', 4);
        $opImage = collect($result->facilityImages)->firstWhere('image_type', 5);
        $ipImage = collect($result->facilityImages)->firstWhere('image_type', 6);
        $pharmacyImage = collect($result->facilityImages)->firstWhere('image_type', 7);
        $labImage = collect($result->facilityImages)->firstWhere('image_type', 8);
        $clinicAreaImage = collect($result->facilityImages)->firstWhere('image_type', 9);

        return view('admin.facility-profile.show', compact(
            'result',
            'facilityBuilding',
            'entranceImage',
            'waitingAreaImage',
            'otherImage',
            'generalImage',
            'opImage',
            'ipImage',
            'pharmacyImage',
            'labImage',
            'clinicAreaImage',
            'currentConstructionImages',
            'oldConstructionImages',
            'approvalResult'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = FacilityProfile::with([
            'facility_hierarchy',
            'facilityImages',
            'facilityDocuments' => function ($query) {
                $query->where('status', 1);
            },
            'contacts',
            'facilityBuilding' => function ($query) {
                $query->where('is_active', 1);
            },
        ])
            ->where('status', _active())
            ->find($id);

        $result->source_of_funding = $result->facilityBuilding->source_of_funding ? json_decode($result->facilityBuilding->source_of_funding, true) : [];
        $result->electric_connections = $result->facilityBuilding->electric_connections ? json_decode($result->facilityBuilding->electric_connections, true) : [];
        $result->facilityBuilding->public_permission_letter = fileLink($result->facilityBuilding->public_permission_letter);
        $result->facilityBuilding->rented_lease_document_path = fileLink($result->facilityBuilding->rented_lease_document_path);
        $result->facilityBuilding->rent_free_permission_letter = fileLink($result->facilityBuilding->rent_free_permission_letter);
        $result->facilityBuilding->inauguration_images = fileLink($result->facilityBuilding->inauguration_images);
        $result->facilityBuilding->ready_current_images = fileLink($result->facilityBuilding->ready_current_images);
        $result->facilityBuilding->culvert_image_path = fileLink($result->facilityBuilding->culvert_image_path);
        $result->facilityBuilding->own_go_ms_no_pdf_path = fileLink($result->facilityBuilding->own_go_ms_no_pdf_path);
        $constructionImages = collect($result->facilityImages)->whereBetween('image_type', [10, 19])->all();
        $currentConstructionStatus = $result->facilityBuilding->under_construction_type;
        // dd($result->toArray());
        // dd($currentConstructionStatus);
        $currentConstructionImages = [];
        $oldConstructionImages = [];

        foreach ($constructionImages as $image) {
            $image->image_url = fileLink($image->image_url);

            if ($image->under_construction_status == $currentConstructionStatus) {
                $currentConstructionImages[] = $image;
            } else {
                if (!isset($oldConstructionImages[$image->under_construction_status])) {
                    $oldConstructionImages[$image->under_construction_status] = [];
                }
                $oldConstructionImages[$image->under_construction_status][] = $image;
            }
        }
        // dd($oldConstructionImages);
        // dd($currentConstructionImages);

        // dd($result->toarray());
        $entranceImage = collect($result->facilityImages)->where('status', _active())->firstWhere('image_type', 1);
        $waitingAreaImage = collect($result->facilityImages)->where('status', _active())->firstWhere('image_type', 2);
        $otherImage = collect($result->facilityImages)->where('status', _active())->firstWhere('image_type', 3);
        $generalImage = collect($result->facilityImages)->where('status', _active())->firstWhere('image_type', 4);
        $opImage = collect($result->facilityImages)->where('status', _active())->firstWhere('image_type', 5);
        $ipImage = collect($result->facilityImages)->where('status', _active())->firstWhere('image_type', 6);
        $pharmacyImage = collect($result->facilityImages)->where('status', _active())->firstWhere('image_type', 7);
        // dd($pharmcyImage->toarray());
        $labImage = collect($result->facilityImages)->where('status', _active())->firstWhere('image_type', 8);
        $clinicAreaImage = collect($result->facilityImages)->where('status', _active())->firstWhere('image_type', 9);
        $toiletAreaImage = collect($result->facilityImages)->where('status', _active())->firstWhere('image_type', 20);
        // dd($result->toArray());
        return view('admin.facility-profile.edit', compact( 
            'result', 
            'entranceImage', 
            'waitingAreaImage', 
            'otherImage', 
            'generalImage', 
            'opImage', 
            'ipImage', 
            'pharmacyImage', 
            'labImage', 
            'clinicAreaImage',
            'toiletAreaImage',
            'currentConstructionImages', 
            'oldConstructionImages'
        ));
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

        // dd($request->toArray());

        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());
        // dd($request->toArray());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }


        $facilityProfile = FacilityProfile::find($id);
        // if (isset($request->area_type)) {
        //     $facilityHierarchyId = $facilityProfile->facility_hierarchy_id;
        //     if (isset($facilityHierarchyId)) {
        //         $facilityHierarchy = FacilityHierarchy::find($facilityHierarchyId);
        //         $facilityHierarchy->area_type = $request->area_type ?? 0;
        //         $facilityHierarchy->save();
        //     }
        // }


        $input = [
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'pincode' => $request->pincode,
            'latitude' => $request->latitude,
            'longitude'  => $request->longitude,
            'video_url'  => $request->video_url,
            'abdm_facility_number'  => $request->abdm_facility_number,
            'nin_number'  => $request->nin_number,
            'hmis' => $request->hmis,
            'picme'  => $request->picme,
            'mobile_number'  => $request->mobile_number,
            'landline_number'  => $request->landline_number,
            'email_id'  => $request->email_id,
            'fax'  => $request->fax,
            'area_type' => $request->area_type ? 1 : 0,
            'user_id' => Auth::user()->id,
        ];

        if (Auth::user()->user_type_id == 7) {
            $facilityProfile->update($input);
            $draftProfile = $facilityProfile;
            // dd($draftProfile->id);
            $oldFacility = $facilityProfile->replicate();
            $oldFacility->status = 0; 
            $oldFacility->save();
    
            $this->archiveFacilityImages($facilityProfile, $oldFacility);
            $this->archiveFacilityDocuments($facilityProfile, $oldFacility);

            $this->handleImageUpload('entrance', $request, $input, $facilityProfile, $oldFacility);
            $this->handleImageUpload('waiting_area', $request, $input, $facilityProfile, $oldFacility);
            $this->handleImageUpload('other', $request, $input, $facilityProfile, $oldFacility);
            $this->handleImageUpload('general', $request, $input, $facilityProfile, $oldFacility);
            $this->handleImageUpload('op', $request, $input, $facilityProfile, $oldFacility);
            $this->handleImageUpload('ip', $request, $input, $facilityProfile, $oldFacility);
            $this->handleImageUpload('pharmacy', $request, $input, $facilityProfile, $oldFacility);
            $this->handleImageUpload('lab', $request, $input, $facilityProfile, $oldFacility);
            $this->handleImageUpload('clinic_area', $request, $input, $facilityProfile, $oldFacility);
            $this->handleImageUpload('toilet_area', $request, $input, $facilityProfile, $oldFacility);
    
            $this->handleDocumentUpload('land1', $request, $input, $facilityProfile, $oldFacility);
            $this->handleDocumentUpload('land2', $request, $input, $facilityProfile, $oldFacility);
            $this->handleDocumentUpload('land3', $request, $input, $facilityProfile, $oldFacility);

            $draftProfile->facilityImages()->update(['status' => 2]);
            $draftProfile->facilityDocuments()->update(['status' => 2]);
                    
            $oldFacility->facilityImages()->update(['facility_profile_id' => $facilityProfile->id, 'status' => 1]);
            $oldFacility->facilityDocuments()->update(['facility_profile_id' => $facilityProfile->id, 'status' => 1]);
    
            createdResponse("Facility Profile Updated and Published Successfully");
            return redirect()->route('facility-profile.index');
        }

        if ($facilityProfile->status == 1) {
            $newDraft = $facilityProfile->replicate();
            $newDraft->fill($input);
            $newDraft->status = 0;
            $newDraft->save();
            $draftProfile = $newDraft;

            // Replicate related images
            foreach ($facilityProfile->facilityImages as $image) {
                if ($image->status == 1) {
                    $newDraft->facilityImages()->create([
                        'image_url' => $image->image_url,
                        'description' => $image->description,
                        'image_type' => $image->image_type,
                        'under_construction_status' => $image->under_construction_status,
                        'facility_profile_id' => $newDraft->id, // Set the new facility_profile_id
                    ]);
                }
            }

            // Replicate related documents
            foreach ($facilityProfile->facilityDocuments as $document) {
                if ($document->status == 1) {
                    $newDraft->facilityDocuments()->create([
                        'document_url' => $document->document_url,
                        'document_type' => $document->document_type,
                        'facility_profile_id' => $newDraft->id, // Set the new facility_profile_id
                    ]);
                }
            }
        } else {
            $facilityProfile->update($input);
            $draftProfile = $facilityProfile;
        }

        $approvalData = getApprovalData();

        ApprovalWorkflows::updateOrCreate(
            [
                'model_type' => FacilityProfile::class,
                'model_id' => $draftProfile->id,
            ],
            [
                'uploaded_by' => Auth::user()->id,
                'current_stage' => $approvalData['current_stage'],
                'super_admin_id' => $approvalData['super_admin_id'],
                'state_approve_id' => $approvalData['state_approve_id'],
                'hud_approve_id' => $approvalData['hud_approve_id'],
                'block_approve_id' => $approvalData['block_approve_id'],
                'phc_verify_id' => $approvalData['phc_verify_id'],
                'block_verify_id' => $approvalData['block_verify_id'],
                'hud_verify_id' => $approvalData['hud_verify_id'],
                'state_verify_id' => $approvalData['state_verify_id'],
            ]
        );

        $input = [
            'mobile_number' => $request->mobile_number,
            'fax' => $request->fax,
            'landline_number' => $request->landline_number,
            'email_id' => $request->email_id,
        ];

        // Facility Contacts

        // $contact_id = $request->contacts_id;
        // // dd($contacts_id);
        // if ($contact_id) {
        //     $facilityContact = Contact::find($contact_id);
        //     $result = $facilityContact->update($input);
        // } else {
        //     $result = Contact::create(array_merge($input, ['facility_id' => $facilityProfile->facility_hierarchy_id]));
        // }

        // Facility Building Details
        $electricConnections = [];
        $numConnections = $request->input('numConnections');

        for ($i = 1; $i <= $numConnections; $i++) {
            $electricConnections[] = [
                'building_name' => $request->input("building_name_{$i}"),
                'service_number' => $request->input("service_number_{$i}"),
                'electricity_type' => $request->input("electricity_type_{$i}"),
                'kva_capacity' => $request->input("kva_capacity_{$i}"),
                'year_of_installation' => $request->input("year_installation_{$i}"),
            ];
        }
        $facility_building_detail = FacilityBuildingDetails::where('facility_profile_id', $facilityProfile->id)
            ->where('is_active', 1)
            ->first();
        // dd($facility_building_detail);
        $newBuildingStatus = $request->building_status;

        $input = [
            'building_status' => $request->building_status ?? $facility_building_detail->building_status,
            'own_go_ms_no' => $request->own_go_ms_no ?? $facility_building_detail->own_go_ms_no,
            'own_date' => $request->own_date ?? $facility_building_detail->own_date,
            'own_total_amount' => $request->own_total_amount ?? $facility_building_detail->own_total_amount,
            'rent_free_allocated_by' => $request->rent_free_allocated_by ?? $facility_building_detail->rent_free_allocated_by,
            'rent_free_date' => $request->rent_free_date ?? $facility_building_detail->rent_free_date,
            'rent_free_no_of_years' => $request->rent_free_no_of_years ?? $facility_building_detail->rent_free_no_of_years,
            'rented_payment_frequency' => $request->rented_payment_frequency ?? $facility_building_detail->rented_payment_frequency,
            'rented_amount' => $request->rented_amount ?? $facility_building_detail->rented_amount,
            'public_allocated_by' => $request->public_allocated_by ?? $facility_building_detail->public_allocated_by,
            'public_date' => $request->public_date ?? $facility_building_detail->public_date,
            'public_no_of_years' => $request->public_no_of_years ?? $facility_building_detail->public_no_of_years,
            'under_construction_type' => $request->under_construction_type ?? $facility_building_detail->under_construction_type,
            'electric_service_number' => $request->electric_service_number ?? $facility_building_detail->electric_service_number,
            'electricity_wiring_status' => $request->electricity_wiring_status ?? $facility_building_detail->electricity_wiring_status,
            'electricity_fittings_fans' => $request->electricity_fittings_fans ?? $facility_building_detail->electricity_fittings_fans,
            'electricity_fittings_lights' => $request->electricity_fittings_lights ?? $facility_building_detail->electricity_fittings_lights,
            'electricity_fittings_leds' => $request->electricity_fittings_leds ?? $facility_building_detail->electricity_fittings_leds,
            'electricity_fittings_normals' => $request->electricity_fittings_normals ?? $facility_building_detail->electricity_fittings_normals,
            'water_connected' => $request->water_connected == 'yes' ? true : ($request->water_connected === 'no' ? false : $facility_building_detail->water_connected),
            'water_connection_details' => $request->water_connection_details ?? $facility_building_detail->water_connection_details,
            'water_connection_date' => $request->water_connection_date ?? $facility_building_detail->water_connection_date,
            'carpentry_doors' => $request->carpentry_doors ?? $facility_building_detail->carpentry_doors,
            'carpentry_windows' => $request->carpentry_windows ?? $facility_building_detail->carpentry_windows,
            'carpentry_cupboards' => $request->carpentry_cupboards ?? $facility_building_detail->carpentry_cupboards,
            'source_of_funding' => json_encode($request->source_of_funding, true) ?? $facility_building_detail->source_of_funding,
            'building_paint_status' => $request->building_paint_status ?? $facility_building_detail->building_paint_status,
            'paint_incomplete_type' => $request->paint_incomplete_type ?? $facility_building_detail->paint_incomplete_type,
            'work_completed_status' => $request->work_completed_status == 'yes' ? true : ($request->work_completed_status === 'no' ? false : $facility_building_detail->work_completed_status),
            'work_completed_by' => $request->work_completed_by ?? $facility_building_detail->work_completed_by,
            'work_completed_details' => $request->work_completed_details ?? $facility_building_detail->work_completed_details,
            'work_completed_date' => $request->work_completed_date ?? $facility_building_detail->work_completed_date,
            'inauguration_status' => $request->inauguration_status ?? $facility_building_detail->inauguration_status,
            'inauguration_by' => $request->inauguration_by ?? $facility_building_detail->inauguration_by,
            'inauguration_date' => $request->inauguration_date ?? $facility_building_detail->inauguration_date,
            'ready_who_inaugurate' => $request->ready_who_inaugurate ?? $facility_building_detail->ready_who_inaugurate,
            'ready_inaugurate_fixed_date' => $request->ready_inaugurate_fixed_date ?? $facility_building_detail->ready_inaugurate_fixed_date,
            'culvert_status' => $request->culvert_status == 'yes' ? true : ($request->culvert_status === 'no' ? false : $facility_building_detail->culvert_status),
            'culvert_date_of_installation' => $request->culvert_date_of_installation ?? $facility_building_detail->culvert_date_of_installation,
            'handed_over' => $request->handed_over == 'yes' ? true : ($request->handed_over === 'no' ? false : $facility_building_detail->handed_over),
            'handed_over_type' => $request->handed_over_type ?? $facility_building_detail->handed_over_type,
            'handed_over_whom' => $request->handed_over_whom ?? $facility_building_detail->handed_over_whom,
            'handed_over_date' => $request->handed_over_date ?? $facility_building_detail->handed_over_date,
            'occupied_date' => $request->occupied_date ?? $facility_building_detail->occupied_date,
            'compound_wall_status' => $request->compound_wall_status ?? $facility_building_detail->compound_wall_status,
            'water_tank_status' => $request->water_tank_status == 'yes' ? true : ($request->water_tank_status === 'no' ? false : $facility_building_detail->water_tank_status),
            'water_tank_capacity' => $request->water_tank_capacity ?? $facility_building_detail->water_tank_capacity,
            'sump_status' => $request->sump_status == 'yes' ? true : ($request->sump_status === 'no' ? false : $facility_building_detail->sump_status),
            'sump_capacity' => $request->sump_capacity ?? $facility_building_detail->sump_capacity,
            'oht_status' => $request->oht_status == 'yes' ? true : ($request->oht_status === 'no' ? false : $facility_building_detail->oht_status),
            'oht_capacity' => $request->oht_capacity ?? $facility_building_detail->oht_capacity,
            'ro_water_availability' => $request->ro_water_availability == 'yes' ? true : ($request->ro_water_availability === 'no' ? false : $facility_building_detail->ro_water_availability),
            'ro_water_make' => $request->ro_water_make ?? $facility_building_detail->ro_water_make,
            'ro_water_capacity' => $request->ro_water_capacity ?? $facility_building_detail->ro_water_capacity,
            'approach_road_status' => $request->approach_road_status == 'yes' ? true : ($request->approach_road_status === 'no' ? false : $facility_building_detail->approach_road_status),
            'approach_road_type' => $request->approach_road_type ?? $facility_building_detail->approach_road_type,
            'electric_connections' => $request->numConnections ? json_encode($electricConnections) : $facility_building_detail->electric_connections,
            'additional_power_source' => $request->additional_power_source == 'yes' ? true : ($request->additional_power_source === 'no' ? false : $facility_building_detail->additional_power_source),
            'generator_make' => $request->generator_make ?? $facility_building_detail->generator_make,
            'generator_capacity' => $request->generator_capacity ?? $facility_building_detail->generator_capacity,
            'generator_year_of_installation' => $request->generator_year_of_installation ?? $facility_building_detail->generator_year_of_installation,
            'ups_make' => $request->ups_make ?? $facility_building_detail->ups_make,
            'ups_capacity' => $request->ups_capacity ?? $facility_building_detail->ups_capacity,
            'ups_year_of_installation' => $request->ups_year_of_installation ?? $facility_building_detail->ups_year_of_installation,
            'internet_connection' => $request->internet_connection == 'yes' ? true : ($request->internet_connection === 'no' ? false : $facility_building_detail->internet_connection),
            'internet_brand_name' => $request->internet_brand_name ?? $facility_building_detail->internet_brand_name,
            'internet_payment_frequency' => $request->internet_payment_frequency ?? $facility_building_detail->internet_payment_frequency,
            'internet_payment_cost' => $request->internet_payment_cost ?? $facility_building_detail->internet_payment_cost,
            'landline_connection' => $request->landline_connection == 'yes' ? true : ($request->landline_connection === 'no' ? false : $facility_building_detail->landline_connection),
            'landline_service_provider' => $request->landline_service_provider ?? $facility_building_detail->landline_service_provider,
            'landline_location' => $request->landline_location ?? $facility_building_detail->landline_location,
            'landline_plan_details' => $request->landline_plan_details ?? $facility_building_detail->landline_plan_details,
            'landline_payment_frequency' => $request->landline_payment_frequency ?? $facility_building_detail->landline_payment_frequency,
            'landline_payment_cost' => $request->landline_payment_cost ?? $facility_building_detail->landline_payment_cost,
            'fax_connection' => $request->fax_connection == 'yes' ? true : ($request->fax_connection === 'no' ? false : $facility_building_detail->fax_connection),
            'fax_service_provider' => $request->fax_service_provider ?? $facility_building_detail->fax_service_provider,
            'fax_location' => $request->fax_location ?? $facility_building_detail->fax_location,
            'fax_plan_details' => $request->fax_plan_details ?? $facility_building_detail->buildinfax_plan_detailsg_status,
            'fax_payment_frequency' => $request->fax_payment_frequency ?? $facility_building_detail->fax_payment_frequency,
            'fax_payment_cost' => $request->fax_payment_cost ?? $facility_building_detail->fax_payment_cost,

        ];

        // dd($input);

        if ($request->hasFile('own_go_ms_no_pdf_path') && $file = $request->own_go_ms_no_pdf_path) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->own_go_ms_no_pdf_path, $this->facility_profile_documents, $facility_building_detail->own_go_ms_no_pdf_path);
                $input['own_go_ms_no_pdf_path'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('rented_lease_document_path') && $file = $request->rented_lease_document_path) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->rented_lease_document_path, $this->facility_profile_documents, $facility_building_detail->rented_lease_document_path);
                $input['rented_lease_document_path'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('public_permission_letter') && $file = $request->public_permission_letter) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->public_permission_letter, $this->facility_profile_documents, $facility_building_detail->public_permission_letter);
                $input['public_permission_letter'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('rent_free_permission_letter') && $file = $request->rent_free_permission_letter) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->rent_free_permission_letter, $this->facility_profile_documents, $facility_building_detail->rent_free_permission_letter);
                $input['rent_free_permission_letter'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('inauguration_images') && $file = $request->inauguration_images) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->inauguration_images, $this->facility_profile_images, $facility_building_detail->inauguration_images);
                $input['inauguration_images'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('ready_current_images') && $file = $request->ready_current_images) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->ready_current_images, $this->facility_profile_images, $facility_building_detail->ready_current_images);
                $input['ready_current_images'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('culvert_image') && $file = $request->culvert_image) {
            if ($file->isValid()) {
                $storedFile = FileService::updateAndStoreFile($request->culvert_image, $this->facility_profile_images, $facility_building_detail->culvert_image_path);
                $input['culvert_image_path'] = $storedFile['stored_file_path'] ?? '';
            }
        }

        if ($facility_building_detail) {
            $currentBuildingStatus = $facility_building_detail->building_status;

            if (is_null($currentBuildingStatus) && !empty($newBuildingStatus)) {
                $result = $facility_building_detail->update($input);
            } elseif ($currentBuildingStatus !== $newBuildingStatus) {
                $result = $facility_building_detail->update(['is_active' => 0]);

                $input['facility_profile_id'] = $facilityProfile->id;
                $result = FacilityBuildingDetails::create($input);
            }
        }
        // dd($input);
        $result = $facility_building_detail->update($input);


        $imageFields = [
            'under_construction_image1',
            'under_construction_image2',
            'under_construction_image3',
            'under_construction_image4',
            'under_construction_image5',
            'under_construction_image6',
            'under_construction_image7',
            'under_construction_image8',
            'under_construction_image9',
            'under_construction_image10'
        ];
        $imageType = 10;
        foreach ($imageFields as $field) {
            if ($request->has($field)) {
                $imageIdField = "{$field}_id"; // Assuming the ID of the image is passed with `_id` suffix
                $imageId = $request->$imageIdField;


                // Check if image exists
                if (isset($imageId) && $request->under_construction_type == $facilityProfile->under_construction_type) {
                    $existingImage = FacilityImages::findOrFail($imageId);

                    if ($request->hasFile($field) && ($file = $request->file($field)) && $file->isValid()) {
                        $storedFile = FileService::updateAndStoreFile($file, $this->facility_profile_images, $existingImage->image_url);
                        $existingImage->update([
                            'image_url' => $storedFile['stored_file_path'] ?? '',
                            'image_type' => $imageType,
                            'under_construction_status' => $request->under_construction_type
                        ]);
                    }
                } else {
                    if ($request->hasFile($field) && ($file = $request->file($field)) && $file->isValid()) {
                        // Create new image
                        $storedFileArray = FileService::storeFile($file, $this->facility_profile_images);

                        FacilityImages::create([
                            'facility_profile_id' => $facilityProfile->id,
                            'image_url' => $storedFileArray['stored_file_path'] ?? '',
                            'image_type' => $imageType,
                            'under_construction_status' => $request->under_construction_type
                        ]);
                    }
                }
            }
            $imageType++;
        }


        // Facility Images

        $result = $this->handleImageUpload('entrance', $request, $input, $facilityProfile, $draftProfile);
        $result = $this->handleImageUpload('waiting_area', $request, $input, $facilityProfile, $draftProfile);
        $result = $this->handleImageUpload('other', $request, $input, $facilityProfile, $draftProfile);
        $result = $this->handleImageUpload('general', $request, $input, $facilityProfile, $draftProfile);
        $result = $this->handleImageUpload('op', $request, $input, $facilityProfile, $draftProfile);
        $result = $this->handleImageUpload('ip', $request, $input, $facilityProfile, $draftProfile);
        $result = $this->handleImageUpload('pharmacy', $request, $input, $facilityProfile, $draftProfile);
        $result = $this->handleImageUpload('lab', $request, $input, $facilityProfile, $draftProfile);
        $result = $this->handleImageUpload('clinic_area', $request, $input, $facilityProfile, $draftProfile);


        // Facility Documents
        $result = $this->handleDocumentUpload('land1', $request, $input, $facilityProfile, $draftProfile);
        $result = $this->handleDocumentUpload('land2', $request, $input, $facilityProfile, $draftProfile);
        $result = $this->handleDocumentUpload('land3', $request, $input, $facilityProfile, $draftProfile);

        // $entrance_image_id = $request->entrance_image_id;

        // if (isset($entrance_image_id)) {
        //     $entranceImage = FacilityImages::findOrFail($entrance_image_id);

        //     if ($request->hasFile('entrance_image') && $file = $request->entrance_image) {
        //         if ($file->isValid()) {
        //             $storedFile = FileService::updateAndStoreFile($request->entrance_image, $this->facility_profile_images, $entranceImage->image_url);
        //             $input['image_url'] = $storedFile['stored_file_path'] ?? '';
        //             $input['description'] = $request->entrance_description;
        //         }
        //     }
        //     $result = $entranceImage->update($input);
        // } else {
        //     if (isset($request->entrance_image) && ($request->entrance_image)->isValid()) {
        //         $storedFileArray = FileService::storeFile($request->entrance_image, $this->facility_profile_images);
        //         $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
        //         $input['image_type'] = 1;
        //         $input['description'] = $request->entrance_description;
        //     }
        //     $result = FacilityImages::create(array_merge($input, ['facility_profile_id' => $facilityProfile->id]));
        // }

        // $waiting_area_image_id = $request->waiting_area_image_id;

        // if (isset($waiting_area_image_id)) {
        //     $waitingAreaImage = FacilityImages::findOrFail($waiting_area_image_id);

        //     if ($request->hasFile('waiting_area_image') && $file = $request->waiting_area_image) {
        //         if ($file->isValid()) {
        //             $storedFile = FileService::updateAndStoreFile($request->waiting_area_image, $this->facility_profile_images, $waitingAreaImage->image_url);
        //             $input['image_url'] = $storedFile['stored_file_path'] ?? '';
        //             $input['image_type'] = 2;
        //             $input['description'] = $request->waiting_area_description;
        //         }
        //     }
        //     $result = $waitingAreaImage->update($input);
        // } else {
        //     if (isset($request->waiting_area_image) && ($request->waiting_area_image)->isValid()) {
        //         $storedFileArray = FileService::storeFile($request->waiting_area_image, $this->facility_profile_images);
        //         $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
        //         $input['image_type'] = 2;
        //         $input['description'] = $request->waiting_area_description;
        //     }
        //     $result = FacilityImages::create(array_merge($input, ['facility_profile_id' => $facilityProfile->id]));
        // }

        // $other_image_id = $request->other_image_id;

        // if (isset($other_image_id)) {
        //     $otherImage = FacilityImages::findOrFail($other_image_id);

        //     if ($request->hasFile('other_image') && $file = $request->other_image) {
        //         if ($file->isValid()) {
        //             $storedFile = FileService::updateAndStoreFile($request->other_image, $this->facility_profile_images, $otherImage->image_url);
        //             $input['image_url'] = $storedFile['stored_file_path'] ?? '';
        //             $input['image_type'] = 3;
        //             $input['description'] = $request->other_iamge_description;
        //         }
        //     }
        //     $result = $otherImage->update($input);
        // } else {
        //     if (isset($request->other_image) && ($request->other_image)->isValid()) {
        //         $storedFileArray = FileService::storeFile($request->other_image, $this->facility_profile_images);
        //         $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
        //         $input['image_type'] = 3;
        //         $input['description'] = $request->other_iamge_description;
        //     }
        //     $result = FacilityImages::create(array_merge($input, ['facility_profile_id' => $facilityProfile->id]));
        // }

        // $general_image_id = $request->general_image_id;

        // if (isset($general_image_id)) {
        //     $generalImage = FacilityImages::findOrFail($general_image_id);

        //     if ($request->hasFile('general_image') && $file = $request->general_image) {
        //         if ($file->isValid()) {
        //             $storedFile = FileService::updateAndStoreFile($request->general_image, $this->facility_profile_images, $generalImage->image_url);
        //             $input['image_url'] = $storedFile['stored_file_path'] ?? '';
        //             $input['image_type'] = 4;
        //             $input['description'] = $request->general_image_description;
        //         }
        //     }
        //     $result = $generalImage->update($input);
        // } else {
        //     if (isset($request->general_image) && ($request->general_image)->isValid()) {
        //         $storedFileArray = FileService::storeFile($request->general_image, $this->facility_profile_images);
        //         $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
        //         $input['image_type'] = 4;
        //         $input['description'] = $request->general_image_description;
        //     }
        //     $result = FacilityImages::create(array_merge($input, ['facility_profile_id' => $facilityProfile->id]));
        // }



        // Facility Profile Land Documents
        // $land_document1_id = $request->land_document1_id;

        // if (isset($land_document1_id)) {
        //     $landDocument1 = FacilityDocuments::findOrFail($land_document1_id);

        //     if ($request->hasFile('land_document1') && $file = $request->land_document1) {
        //         if ($file->isValid()) {
        //             $storedFile = FileService::updateAndStoreFile($request->land_document1, $this->facility_profile_documents, $landDocument1->document_url);
        //             $input['document_url'] = $storedFile['stored_file_path'] ?? '';
        //         }
        //         $result = $landDocument1->update($input);
        //     }
        // } else {
        // if (isset($request->land_document1) && ($request->land_document1)->isValid()) {
        //     $storedFileArray = FileService::storeFile($request->land_document1, $this->facility_profile_documents);
        //     $input['document_url'] = $storedFileArray['stored_file_path'] ?? '';
        //     $result = FacilityDocuments::create(array_merge($input, ['facility_profile_id' => $facilityProfile->id]));
        // }
        // }


        // $land_document2_id = $request->land_document2_id;

        // if (isset($land_document2_id)) {
        //     $landDocument2 = FacilityDocuments::findOrFail($land_document2_id);

        //     if ($request->hasFile('land_document2') && $file = $request->land_document2) {
        //         if ($file->isValid()) {
        //             $storedFile = FileService::updateAndStoreFile($request->land_document2, $this->facility_profile_documents, $landDocument2->document_url);
        //             $input['document_url'] = $storedFile['stored_file_path'] ?? '';
        //         }
        //         $result = $landDocument2->update($input);
        //     }
        // } else {
        // if (isset($request->land_document2) && ($request->land_document2)->isValid()) {
        //     $storedFileArray = FileService::storeFile($request->land_document2, $this->facility_profile_documents);
        //     $input['document_url'] = $storedFileArray['stored_file_path'] ?? '';
        //     $result = FacilityDocuments::create(array_merge($input, ['facility_profile_id' => $facilityProfile->id]));
        // }
        // }


        // $land_document3_id = $request->land_document3_id;

        // if (isset($land_document3_id)) {
        //     $landDocument3 = FacilityDocuments::findOrFail($land_document3_id);

        //     if ($request->hasFile('land_document3') && $file = $request->land_document3) {
        //         if ($file->isValid()) {
        //             $storedFile = FileService::updateAndStoreFile($request->land_document3, $this->facility_profile_documents, $landDocument3->document_url);
        //             $input['document_url'] = $storedFile['stored_file_path'] ?? '';
        //         }
        //         $result = $landDocument3->update($input);
        //     }
        // } else {
        // if (isset($request->land_document3) && ($request->land_document3)->isValid()) {
        //     $storedFileArray = FileService::storeFile($request->land_document3, $this->facility_profile_documents);
        //     $input['document_url'] = $storedFileArray['stored_file_path'] ?? '';
        //     $result = FacilityDocuments::create(array_merge($input, ['facility_profile_id' => $facilityProfile->id]));
        // }
        // }

        createdResponse("Facility Profile Updated Successfully");

        return redirect()->route('facility-profile.index');
    }

    public function handleImageUpload($imageType, $request, $input, $facilityProfile, $draftProfile)
    {
        $imageId = $request->get("{$imageType}_image_id");
        $imageField = "{$imageType}_image";
        $descriptionField = "{$imageType}_description";

        $draftProfile = FacilityProfile::where('status', 0)->where('id', $draftProfile->id)->first();

        if ($draftProfile && isset($imageId)) {
            $originalImage = FacilityImages::where('facility_profile_id', $facilityProfile->id)
                ->where('id', $imageId)
                ->first();


            if ($originalImage) {
                $draftImage = FacilityImages::where('facility_profile_id', $draftProfile->id)
                    ->where('image_type', $originalImage->image_type)
                    ->first();
                if ($draftImage) {
                    if ($request->hasFile($imageField) && $file = $request->$imageField) {
                        if ($file->isValid()) {
                            $storedFile = FileService::storeFile($file, $this->facility_profile_images);
                            $input['image_url'] = $storedFile['stored_file_path'] ?? '';
                        }
                    }
                    if ($request->has($descriptionField)) {
                        $input['description'] = $request->$descriptionField;
                    }
                    $draftImage->update($input);
                } else {
                    if ($request->hasFile($imageField) && ($request->$imageField)->isValid()) {
                        $storedFile = FileService::storeFile($request->$imageField, $this->facility_profile_images);
                        $input['image_url'] = $storedFile['stored_file_path'] ?? '';
                        $input['image_type'] = $originalImage->image_type; // Use the original image type
                        $input['description'] = $request->$descriptionField ?? '';

                        FacilityImages::create(array_merge($input, ['facility_profile_id' => $draftProfile->id]));
                    }
                }

                // Update the draft image
                $draftImage->update($input);
            }
        } elseif ($draftProfile) {
            if ($request->hasFile($imageField) && ($request->$imageField)->isValid()) {
                $storedFile = FileService::storeFile($request->$imageField, $this->facility_profile_images);
                $input['image_url'] = $storedFile['stored_file_path'] ?? '';
                $input['image_type'] = getImageType($imageField);
                $input['description'] = $request->$descriptionField ?? '';
                FacilityImages::create(array_merge($input, ['facility_profile_id' => $draftProfile->id]));
            }
        }

    }

    public function handleDocumentUpload($documentType, $request, $input, $facilityProfile, $draftProfile)
    {
        $documentId = $request->get("{$documentType}_document_id");
        $documentField = "{$documentType}_document";

        $draftProfile = FacilityProfile::where('status', 0)->where('id', $draftProfile->id)->first();

        if ($draftProfile && isset($documentId)) {
            $originalDocument = FacilityDocuments::where('facility_profile_id', $facilityProfile->id)
                ->where('id', $documentId)
                ->first();

            if ($originalDocument) {
                $draftDocument = FacilityDocuments::where('facility_profile_id', $draftProfile->id)
                    ->where('document_type', $originalDocument->document_type) // Match the document name
                    ->first();

                if ($draftDocument) {
                    if ($request->hasFile($documentField) && $file = $request->$documentField) {
                        if ($file->isValid()) {
                            $storedFile = FileService::updateAndStoreFile($file, $this->facility_profile_documents, $draftDocument->document_url);
                            $input['document_url'] = $storedFile['stored_file_path'] ?? '';
                        }
                    }
                    $draftDocument->update($input);
                } else {
                    if ($request->hasFile($documentField) && ($request->$documentField)->isValid()) {
                        $storedFile = FileService::storeFile($request->$documentField, $this->facility_profile_documents);
                        $input['document_url'] = $storedFile['stored_file_path'] ?? '';
                        $input['document_type'] = $originalDocument->document_type;
                        FacilityDocuments::create(array_merge($input, ['facility_profile_id' => $draftProfile->id]));
                    }
                }
            }
        } elseif ($draftProfile) {
            if ($request->hasFile($documentField) && ($request->$documentField)->isValid()) {
                $storedFile = FileService::storeFile($request->$documentField, $this->facility_profile_documents);
                $input['document_url'] = $storedFile['stored_file_path'] ?? '';
                $input['document_type'] = getDocumentType($documentField);
                FacilityDocuments::create(array_merge($input, ['facility_profile_id' => $draftProfile->id]));
            }
        }

    }

    private function archiveFacilityImages($facilityProfile, $oldFacility)
    {
        foreach ($facilityProfile->facilityImages as $image) {
            if ($image->status == 1) {  // If the image is active
                $oldFacility->facilityImages()->create([
                    'image_url' => $image->image_url,
                    'description' => $image->description,
                    'image_type' => $image->image_type,
                    'under_construction_status' => $image->under_construction_status,
                    'facility_profile_id' => $oldFacility->id,
                    'status' => 2,  // Mark as archived
                ]);
            }
        }
    }

    private function archiveFacilityDocuments($facilityProfile, $oldFacility)
    {
        foreach ($facilityProfile->facilityDocuments as $document) {
            if ($document->status == 1) {  // If the document is active
                $oldFacility->facilityDocuments()->create([
                    'document_url' => $document->document_url,
                    'document_type' => $document->document_type,
                    'facility_profile_id' => $oldFacility->id,
                    'status' => 2,  // Mark as archived
                ]);
            }
        }
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

        $rules['address_line1'] = 'nullable|string|max:255';
        $rules['address_line2'] = 'nullable|string|max:255';
        $rules['pincode'] = 'required|digits:6';
        $rules['latitude'] = 'required|numeric';
        $rules['longitude'] = 'required|numeric';
        $rules['video_url'] = 'required|url|regex:/^https:\/\/drive\.google\.com\/.*$/';
        $rules['abdm_facility_number'] = 'nullable|string|max:255';
        $rules['nin_number'] = 'nullable|string|max:255';
        $rules['picme'] = 'nullable|string|max:255';
        $rules['hmis'] = 'nullable|string|max:255';

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
    public function export(Request $request)
    {
        $filename = 'facility-profile' . date('d-m-Y') . '.xlsx';
        return Excel::download(new CustomersExport, $filename);
    }
}
