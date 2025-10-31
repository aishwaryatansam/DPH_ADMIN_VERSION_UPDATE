<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dropdown\FacilityResource;
use App\Models\ApprovalWorkflows;
use App\Models\FacilityHierarchy;
use App\Models\FacilityLevel;
use App\Models\HUD;
use App\Models\Block;
use App\Models\District;
use App\Models\FacilityBuildingDetails;
use App\Models\FacilityProfile;
use App\Models\FacilityType;
use App\Models\PHC;
use App\Models\HSC;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FacilityHierarchyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('hiiii');
        $facility_levels = FacilityLevel::getFacilityLevelData();

        $huds = HUD::filter()->where('status', _active())->orderBy('name')->get();

        $blocks = [];
        if ($hud_id = request('hud_id')) {
            $blocks = Block::filter()->where('status', _active())->orderBy('name')->get();
        }
        $phcs = array();

        if ($block_id = request('block_id')) {
            $phcs = PHC::filter()->where('status', _active())->orderBy('name')->get();
        }
        $hscs = [];
        if ($phc_id = request('phc_id')) {
            $hscs = HSC::filter()->where('status', _active())->orderBy('name')->get();
        }
        $results = FacilityHierarchy::getQueriedResult();
        // dd($results);
        return view('admin.masters.facilityhierarchy.list', compact('results', 'facility_levels', 'huds', 'blocks', 'phcs', 'hscs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
        $facility_levels = FacilityLevel::getFacilityLevelData();
        $facility_types = FacilityType::getFacilityTypeData();
        $districts = $huds = $blocks = $phc = $hsc = $designation = [];
        return view('admin.masters.facilityhierarchy.create', compact('districts', 'huds', 'blocks', 'phc', 'hsc', 'statuses', 'facility_levels', 'facility_types'));
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

        // dd($request->toArray());

        $input = [
            'facility_name' => $request->name,
            'facility_code' => $request->code,
            'facility_type_id' => $request->facility_type_id,
            'facility_level_id' => $request->facility_level_id,
            'district_id'  => $request->district_id,
            'hud_id'  => $request->hud_id,
            'block_id'  => $request->block_id,
            'phc_id'  => $request->phc_id,
            'hsc_id'  => $request->hsc_id,
            'area_type' => $request->area_type ?? 0,
            'status' => $request->status ?? 0
        ];
        $result = FacilityHierarchy::create($input);
        $facilityProfile = FacilityProfile::create(['facility_hierarchy_id' => $result->id]);
        $facilityBuilding = FacilityBuildingDetails::create(['facility_profile_id' => $facilityProfile->id]);

        ApprovalWorkflows::create([
            'model_type' => FacilityProfile::class,        
            'model_id' => $facilityProfile->id,
        ]);

        createdResponse("Facility Created Successfully");
        return redirect()->route('facility_hierarchy.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = FacilityHierarchy::with([])->find($id);
        $facility_levels = FacilityLevel::getFacilityLevelData();
        $facility_types = FacilityType::getFacilityTypeData();
        $districts = District::getDistrictData();
        $huds = HUD::collectHudData();
        $blocks = Block::collectBlockData();
        $phc = PHC::collectPhcData();
        $hsc = HSC::collectHscData();
        return view('admin.masters.facilityhierarchy.show', compact('result', 'districts', 'huds', 'blocks', 'phc', 'hsc', 'facility_levels', 'facility_types'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = FacilityHierarchy::with([])->find($id);
        $facility_levels = FacilityLevel::getFacilityLevelData();
        $facility_types = FacilityType::getFacilityTypeData();
        $districts = District::getDistrictData();
        $huds = HUD::collectHudData();
        $blocks = Block::collectBlockData();
        $phc = PHC::collectPhcData();
        $hsc = HSC::collectHscData();
        // dd($result->toArray());
        return view('admin.masters.facilityhierarchy.edit', compact('result', 'districts', 'huds', 'blocks', 'phc', 'hsc', 'facility_levels', 'facility_types'));
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
        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());
        // dd($request->toArray());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }
        $facilityhierarchy = FacilityHierarchy::find($id);
        $input = [
            'facility_name' => $request->name,
            'facility_code' => $request->code,
            'facility_type_id' => $request->facility_type_id,
            'facility_level_id' => $request->facility_level_id,
            'district_id'  => $request->district_id,
            'hud_id'  => $request->hud_id,
            'block_id'  => $request->block_id,
            'phc_id'  => $request->phc_id,
            'hsc_id'  => $request->hsc_id,
            'area_type' => $request->area_type ?? 0,
            'status' => $request->status ?? 0
        ];
        // dd($input);
        $result = $facilityhierarchy->update($input);
        createdResponse("Facility Updated Successfully");
        return redirect()->route('facility_hierarchy.index');
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
        $rules['name'] = "required|nullable|min:2|max:99";
        $rules['code'] = 'sometimes|nullable|min:5|unique:facility_hierarchy,facility_code';
        $rules['facility_type_id'] = 'sometimes|nullable';
        $rules['facility_level_id'] = 'required';
        $rules['hud_id'] = 'required_if:facility_level_id,==,3';
        $rules['block_id'] = 'required_if:facility_level_id,==,4';
        $rules['phc_id'] = 'required_if:facility_level_id,==,5';
        $rules['hsc_id'] = 'required_if:facility_level_id,==,6';

        return $rules;
    }

    public function messages()
    {
        return [
            'designation_id.unique' => 'Contact already exists under the selected designation, please update the details.',
        ];
    }

    public function attributes()
    {
        return [];
    }

    public function listFacilities(Request $request)
    {
        // $validator = Validator::make($request->all(),[
        //     'facility_type_id' => 'sometimes|exists:facility_type,id,status,'._active(),
        // ]);

        // if($validator->fails()) {
        //     return sendError($validator->errors());
        // }

        $filters = [
            'facility_level_id' => $request->facility_level_id,
            'facility_type_id' => $request->facility_type_id,
            'district_id' => $request->district_id,
            'hud_id' => $request->hud_id,
            'block_id' => $request->block_id,
            'phc_id' => $request->phc_id,
            'hsc_id' => $request->hsc_id,
        ];

        $facilities = FacilityHierarchy::getFacilityHierarchyData($filters);
        // dd($phcs);
        return sendResponse(FacilityResource::collection($facilities));
    }
    public function export(Request $request)
    {
        // Filters based on request parameters
        $filters = [
            'facility_type_id' => $request->facility_type_id,
            'district_id' => $request->district_id,
            'hud_id' => $request->hud_id,
            'block_id' => $request->block_id,
            'phc_id' => $request->phc_id,
            'hsc_id' => $request->hsc_id,
        ];
        // Fetch all facility data without pagination
        $facilities = FacilityHierarchy::getFacilityHierarchyData($filters)->get(); // Use `get()` instead of pagination.
        // Export the data as an Excel file
        return Excel::download(new class($facilities) implements FromCollection, WithHeadings {

            protected $facilities;

            // Pass the data to the class
            public function __construct($facilities)
            {
                $this->facilities = $facilities;
            }
            // Return the collection of facilities
            public function collection()
            {
                return $this->facilities->map(function ($facility) {
                    return [
                        $facility->facility_name,
                        $facility->facility_code,
                        $facility->facility_level->name ?? '--',
                        $facility->district->name ?? '--',
                        $facility->hud->name ?? '--',
                        $facility->block->name ?? '--',
                        $facility->phc->name ?? '--',
                        $facility->hsc->name ?? '--',
                        $facility->area_type,
                        $facility->status == 1 ? 'Active' : 'Inactive',
                    ];
                });
            }
            // Define the headers for the export
            public function headings(): array
            {
                return [
                    'Facility Name',
                    'Facility Code',
                    'Level',
                    'District',
                    'HUD',
                    'Block',
                    'PHC',
                    'HSC',
                    'Area Type',
                    'Status'
                ];
            }
        }, 'facility_hierarchy_' . date('d-m-Y') . '.xlsx');
    }
}
