<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\HealthWalkLocation;
use App\Models\HUD;
use HUDTableSeeder;
use Illuminate\Support\Facades\Validator;

class HealthWalkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
public function index(Request $request)
{
    $pageLength = $request->pageLength ?? 10; // default 10 if not provided
    
    $query = HealthWalkLocation::with(['hud', 'hud.district']);

    if ($request->has('search') && trim($request->search) !== '') {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->whereHas('hud', function ($q2) use ($search) {
                $q2->where('name', 'like', "%{$search}%")
                   ->orWhereHas('district', function ($q3) use ($search) {
                       $q3->where('name', 'like', "%{$search}%");
                   });
            })
            ->orWhere('contact', 'like', "%{$search}%");
        });
    }

    $results = $query->paginate($pageLength)->appends([
        'search' => $request->search,
        'pageLength' => $pageLength,
    ]);

    return view('admin.health-walk.list', compact('results'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $districts = District::getDistrictData();
        $huds = HUD::collectHudData();
        return view('admin.health-walk.create',compact('districts', 'huds'));
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
                'hud_id' => $request->hud_id,
                'description' => $request->description,
                'start_point' => $request->start_point,
                'end_point' => $request->end_point,
                'area' => $request->area,
                'location_url' => $request->location_url,
                'visible_to_public' => $request->visible_to_public ?? 0,
                'status' => $request->status ?? 0,
                
            ];

        $result = HealthWalkLocation::create($input);

        createdResponse("Health Walk Created Successfully");

        return redirect()->route('health-walk.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = HealthWalkLocation::with(['hud'])->find($id);
        return view('admin.health-walk.show',compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = HealthWalkLocation::with(['hud'])->find($id);
        $districts = District::getDistrictData();
        $huds = HUD::collectHudData();
        return view('admin.health-walk.edit',compact('districts', 'huds', 'result'));
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

        $healthwalk = HealthWalkLocation::find($id);

        $input = array();
        $input = [
                'hud_id' => $request->hud_id,
                'description' => $request->description,
                'start_point' => $request->start_point,
                'end_point' => $request->end_point,
                'area' => $request->area,
                'location_url' => $request->location_url,
                'visible_to_public' => $request->visible_to_public ?? 0,
                'status' => $request->status ?? 0,
            ];

        $result = $healthwalk->update($input);

        updatedResponse("Health Walk Updated Successfully");

        return redirect()->route('health-walk.index');
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

        $rules['hud_id'] = 'required';
        $rules['location_url'] = 'sometimes|nullable|url';
        $rules['start_point'] = 'sometimes|nullable';
        $rules['end_point'] = 'sometimes|nullable';
        $rules['description'] = 'sometimes|nullable';
        $rules['contact_number'] = 'sometimes|nullable';
        $rules['area'] = 'sometimes|nullable';
        // $rules['status'] = 'required|boolean';

        return $rules;
    }

    public function messages() {
        return [];
    }

    public function attributes() {
        return [];
    }
}
