<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProgramDetailsExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dropdown\ProgramResource;
use App\Models\Program;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ProgramController extends Controller
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

        $results = Program::getQueriedResult();
        
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
        return view('admin.masters.programs.list',compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
        return view('admin.masters.programs.create',compact('statuses'));
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
                'short_code' => strtoupper($request->short_code),
                'order_no' => $request->order_no,
                'status' => $request->status ?? 0,
                
            ];

        $result = Program::create($input);

        createdResponse("Program Created Successfully");

        return redirect()->route('programs.index');
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
        $result = Program::with([])->find($id);
        $statuses = _getGlobalStatus();
        
        return view('admin.masters.programs.edit',compact('result','statuses'));
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

        $program = Program::find($id);

        $input = array();
        $input = [
                'name' => $request->name,
                'short_code' => strtoupper($request->short_code),
                'order_no' => $request->order_no,
                'status' => $request->status ?? 0
            ];

        $result = $program->update($input);

        updatedResponse("Program Updated Successfully");

        return redirect()->route('programs.index');
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

        if ($id) {
            $rules['name'] = "required|unique:programs,name,{$id},id|min:2|max:99";
            $rules['order_no'] = "required|integer|unique:programs,order_no,{$id},id"; // Ensuring order_no is unique during update
        } else {
            $rules['name'] = "required|unique:programs,name|min:2|max:99";
            $rules['order_no'] = "required|integer|unique:programs,order_no"; // Ensuring order_no is unique during store
        }

        $rules['short_code'] = 'sometimes|nullable';
        // $rules['status'] = 'required|boolean';

        return $rules;
    }

    public function messages() {
        return [
            'order_no.unique' => 'This Order No is in used. Pick another number.',
            'order_no.required' => 'Order No is required.',
            'name.unique' => 'Program name is already taken. Please choose another.',
        ];
    }

    public function attributes() {
        return [];
    }

    public function listProgram() {

        $program = Program::getProgramData();
        return sendResponse(ProgramResource::collection($program));
    }

    public function export()
    {
        return Excel::download(new ProgramDetailsExport, 'program_details.xlsx');
    }
}
