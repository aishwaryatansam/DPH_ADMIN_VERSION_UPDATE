<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dropdown\SchemeResource;
use App\Models\ApprovalWorkflows;
use App\Models\Contact;
use App\Models\Program;
use App\Models\Scheme;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use \App\Exports\SchemeDetailExport;
use Maatwebsite\Excel\Facades\Excel;
class SchemeController extends Controller
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

        $results = Scheme::getQueriedResult();
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
        return view('admin.masters.schemes.list', compact('results', 'programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
public function create(Request $request)
{
    $statuses = _getGlobalStatus();
    $sections = Section::getSectionData();
    $programs = Program::getProgramData();

    // Get selected program ID from old input or from GET for POST-back
    $selectedProgramId = old('programs_id', $request->get('programs_id'));

    if ($selectedProgramId) {
        // Only get schemes belonging to the selected program for the dropdown
        $schemes = Scheme::where('programs_id', $selectedProgramId)->get();
    } else {
        $schemes = collect(); // Empty or maybe all schemes if that's your fallback
    }

    return view('admin.masters.schemes.create', compact('statuses', 'programs', 'sections', 'schemes', 'selectedProgramId'));
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
            return redirect()->back()->withErrors($validator) ->withInput();
        }

        $input = [
            'name' => $request->name,
            'short_code' => strtoupper($request->short_code),
            'programs_id' => $request->programs_id,
            'sections_id' => $request->section_id,
            'order_no' => $request->order_no,
            'status' => $request->status ?? 0,

        ];

        $result = Scheme::create($input);

        $approvalData = getApprovalData();

        ApprovalWorkflows::create([
            'model_type' => Contact::class,        
            'model_id' => $result->id,
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
        ]);

        createdResponse("Scheme Created Successfully");

        return redirect()->route('schemes.index');
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
        $result = Scheme::with([])->find($id);
        $programs = Program::getProgramData();
        $sections = Section::getSectionData();
        $statuses = _getGlobalStatus();

        return view('admin.masters.schemes.edit', compact('result', 'statuses', 'programs', 'sections'));
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

        $scheme = Scheme::find($id);

        $input = array();
        $input = [
                'name' => $request->name,
                'short_code' => strtoupper($request->short_code),
                'programs_id' =>$request->programs_id,
                'sections_id' =>$request->section_id,
                'order_no' => $request->order_no,
                'status' => $request->status ?? 0
            ];

        $result = $scheme->update($input);

        updatedResponse("Scheme Updated Successfully");

        return redirect()->route('schemes.index');
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
        
        if ($id) {
            $rules['order_no'] = "required|integer|unique:schemes,order_no,{$id},id"; // Update table name to programs
        } else {
            $rules['order_no'] = "required|integer|unique:schemes,order_no"; // Update table name to programs
        }
        // $rules['status'] = 'required|boolean';

        return $rules;
    }

    public function messages() {
        return [
            'order_no.unique' => 'This Order No is in used. Pick another number.',
        ];
    }

    public function attributes() {
        return [];
    }

    public function listScheme(Request $request) {
        $validator = Validator::make($request->all(),[
            'program_id' => 'required|exists:programs,id,status,'._active(),
        ]);

        if($validator->fails()) {
            return sendError($validator->errors());
        }
        $scheme = Scheme::getSchemeData($request->program_id);
        return sendResponse(SchemeResource::collection($scheme));
    }
public function export()
{
    try {
        // ✅ Fetch all Scheme records with their related Program
        $data = \App\Models\Scheme::with('program')->get();

        // ✅ Pass the data to the export class
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\SchemeDetailsExport($data),
            'scheme_details.xlsx'
        );
    } catch (\Exception $e) {
        dd($e->getMessage());
    }
}

}
