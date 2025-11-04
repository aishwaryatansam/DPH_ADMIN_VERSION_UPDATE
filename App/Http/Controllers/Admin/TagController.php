<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FetchTag;
use Validator;
use App\Services\FileService;
use App\Http\Resources\Dropdown\BlockResource as DDBlockResource;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



public function index(Request $request)
{
    $keyword = $request->input('keyword');

    // Basic search only by 'name'
    if ($keyword) {
        $results = FetchTag::where('name', 'like', "%{$keyword}%")->paginate($request->input('pageLength', 10));
    } else {
        $results = FetchTag::paginate($request->input('pageLength', 10));
    }

    return view('admin.masters.tags.list', compact('results'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
      
       
        return view('admin.masters.tags.create',compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function store(Request $request)
{
  
    $request->validate([
        'name' => 'required|min:2|max:99',
         
    ]);

   
    FetchTag::create([
        'name' => $request->name,
        'status' => $request->status,
    ]);

    
    return redirect()->route('tags.index')->with('success', 'Tag created successfully!');
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show($id)
    {
     $result = FetchTag::findOrFail($id);
        return view('admin.masters.tags.show',compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function edit($id)
{
  
    $result = FetchTag::findOrFail($id);

   
    $statuses = _getGlobalStatus();
    $is_urban = _isUrban();

 
    return view('admin.masters.tags.edit', compact('result', 'statuses'));
}
public function update(Request $request, $id)
{
    
    $request->validate([
        'name' => 'required|min:2|max:99',
     
    ]);

    $result = FetchTag::findOrFail($id);

    
    $result->update([
        'name' => $request->name,
        'status' => $request->status ?? 1,
    ]);

    
    return redirect()->route('tags.index')->with('success', 'Tag updated successfully!');
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd('ss');
    }

   
    // public function destroyDocument($id)
    // {        
    //     $block = Block::find($id);

    //     // Delete the property document
    //     if ($block->property_document_url) {
    //         $block->update(['property_document_url' => null]);
    //     }

    //     return redirect()->back()->with('success', 'Land Document deleted successfully.');
    // }


    public function rules($id="") {

        $rules = array();

        if($id) {
            $rules['name'] = "required|unique:blocks,name,{$id},id,|min:2|max:99";
        } else {
            $rules['name'] = "required|unique:blocks,name,null,id,|min:2|max:99";
        }

        
        return $rules;
    }

    public function messages() {
        return [];
    }

    public function attributes() {
        return [];
    }


    public function export(Request $request){
    	$filename = 'tags'.date('d-m-Y').'.xlsx';
    	return Excel::download(new CustomersExport, $filename);
    	
    }
}
