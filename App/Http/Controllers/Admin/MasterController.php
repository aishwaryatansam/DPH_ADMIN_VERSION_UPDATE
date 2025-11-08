<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Master;
use App\Models\MasterType;
use Illuminate\Support\Facades\Validator;

class MasterController extends Controller
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

        $results = Master::getMasterData();
        $master_types = MasterType::getMasterTypeData();
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
        return view('admin.masters.referance-tables.list',compact('results', 'master_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $master_type = MasterType::getMasterTypeData();
        return view('admin.masters.referance-tables.create', compact('master_type'));
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->toArray());
        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $input = [
            'name' => $request->name,
            'master_type_id' => $request->master_type_id,
            'status' => $request->status ?? 0,

        ];

        $result = Master::create($input);

        createdResponse("Master Created Successfully");

        return redirect()->route('masters.index', ['master_type' => $request->master_type_id]);
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
        $result = Master::with('master_type')->find($id);
        return view('admin.masters.referance-tables.edit', compact('result'));
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

        $master = Master::find($id);

        $input = array();
        $input = [
                'name' => $request->name,
                'status' => $request->status ?? 0
            ];

        $result = $master->update($input);

        updatedResponse("Master Updated Successfully");

        return redirect()->route('masters.index', ['master_type' => $master->master_type_id]);
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
        if (empty($id)) {
            $rules['master_type_id'] = 'required';
        } else {
            $rules['master_type_id'] = 'nullable';
        }
        $rules['status'] = 'sometimes|boolean';

        return $rules;
    }

    public function messages() {
        return [];
    }

    public function attributes() {
        return [];
    }

    public function export(Request $request)
    {
        $masterType = $request->get('master_type');
        $results = Master::where('master_type_id', $masterType)->get();
    
        if ($results->isEmpty()) {
            return response()->json(['message' => 'No data available for export'], 404);
        }
    
        $filename = 'masters-' . $masterType . '-' . date('d-m-Y') . '.xlsx';
        return Excel::download(new MastersExport($results), $filename);
    }
    
}
