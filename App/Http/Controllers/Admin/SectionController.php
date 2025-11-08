<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dropdown\SectionResource;
use App\Models\Program;
use App\Models\Section;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
          $search = $request->get('search');
    $perPage = $request->get('pageLength', 10); // match your HTML select name

        $results = Section::getQueriedResult();
         if (!empty($search)) {
        $results = $results->filter(function ($item) use ($search) {
            return stripos($item->name ?? '', $search) !== false;
        });
    }

    // 🧾 Pagination logic (keep your original code)
    if (method_exists($results, 'paginate')) {
        $results = $results->paginate($perPage);
    } else if ($results instanceof \Illuminate\Support\Collection) {
        $page = $request->get('page', 1);
        $results = new \Illuminate\Pagination\LengthAwarePaginator(
            $results->forPage($page, $perPage), 
            $results->count(), 
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }
        // dd($results->toArray());
        $programs = Program::getProgramData();
        return view('admin.masters.sections.list',compact('results', 'programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
        $programs = Program::getProgramData();
        return view('admin.masters.sections.create',compact('statuses', 'programs'));
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
                'short_code' => $request->short_code,
                'programs_id' =>$request->program_id,
                'status' => $request->status ?? 0,
                
            ];

        $result = Section::create($input);

        createdResponse("Section Created Successfully");

        return redirect()->route('sections.index');
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
            $result = Section::with([])->find($id);
            $programs = Program::getProgramData();
            $statuses = _getGlobalStatus();
            
            return view('admin.masters.sections.edit',compact('result','statuses', 'programs'));
        
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

        $section = Section::find($id);

        $input = array();
        $input = [
                'name' => $request->name,
                'short_code' => $request->short_code,
                'programs_id' =>$request->program_id,
                'status' => $request->status ?? 0
            ];

        $result = $section->update($input);

        updatedResponse("Section Updated Successfully");

        return redirect()->route('sections.index');
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

        $rules['name'] = 'required';
        $rules['program_id'] = 'required';
        $rules['short_code'] = 'required|nullable';
        // $rules['status'] = 'required|boolean';

        return $rules;
    }

    public function messages() {
        return [];
    }

    public function attributes() {
        return [];
    }

    public function listSection() {

        $section = Section::getSectionData();
        return sendResponse(SectionResource::collection($section));
    }
    public function export(Request $request){
    	$filename = 'sections'.date('d-m-Y').'.xlsx';
    	return Excel::download(new CustomersExport, $filename);
    	
    }
}
