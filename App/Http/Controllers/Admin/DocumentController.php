<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\Navigation;
use App\Services\FileService;
use App\Models\Tag;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DocumentsExport;


class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Document::getQueriedResult();
        // dd($results);
        $sections = Tag::where('status',_active())->get();
        $navigations = Navigation::where('status',_active())->get();
        $statuses = _getGlobalStatus();

        return view('admin.documents.list',compact('results','sections','navigations','statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
        $navigations = Navigation::where('status',_active())->orderBy('order_no')->get();
        $tags = Tag::where('status',_active())->orderBy('name')->pluck('name','id');


        return view('admin.documents.create', compact('statuses','navigations','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(),$this->rules(),$this->messages(),$this->attributes());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                        ->withInput();
        }

        $input = [
                'navigation_id' => $request->navigation_id,
                'display_filename' => $request->display_filename,
                'tag_id' => $request->tags,
                'status' => $request->status,
                'reference_no' => $request->reference_no,
                'visible_to_public' => $request->visible_to_public,
                'dated' => dateOf($request->dated,'Y-m-d h:i:s'),
                'uploaded_by'=> Auth::user()->id,
                'link_title'=>$request->link_title,
                'link_url' => $request->link_url,
            ];

        if($request->hasFile('document') && $file = $request->file('document')) {

            if($file->isValid()) {
                $storedFileArray = FileService::storeFile($file);

                $input['document_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if($request->hasFile('document_image') && $file = $request->file('document_image')) {

            if($file->isValid()) {
                $storedFileArray = FileService::storeFile($file);

                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

       
        $result = Document::create($input);

        createdResponse("Document Uploaded Successfully");

        return redirect()->route('documents.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = new Document();
        $result = $document->getDocument($id);
        return view('admin.documents.show',compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = Document::with('navigation')->find($id);
        //dd($result->toArray());
        $statuses = _getGlobalStatus();
        $navigations = Navigation::where('status',_active())->orderBy('order_no')->get();
        $tags = Tag::where('status',_active())->orderBy('name')->pluck('name','id');
        return view('admin.documents.edit',compact('result','statuses','navigations','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),$this->rules($id),$this->messages(),$this->attributes());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                        ->withInput();
        }

        $document = Document::find($id);

        $input = array();
        $input = [
                'display_filename' => $request->display_filename,
                //'navigation_id' => $request->navigation_id,
                'tag_id' => $request->tags,
                'status' => $request->status,
                'reference_no' => $request->reference_no,
                'visible_to_public' => $request->visible_to_public,
                'link_title'=>$request->link_title,
                'link_url' => $request->link_url,
                'dated' => dateOf($request->dated,'Y-m-d h:i:s'),
            ];

        if($request->hasFile('document_image') && $file = $request->file('document_image')) {
            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file,'/',$document->image_url);
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }


       
        $result = $document->update($input);

        updatedResponse("Document Updated Successfully");

        return redirect()->route('documents.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

       
        $document = Document::destroy($id);
        updatedResponse("Document Deleted Successfully");
        return redirect()->route('documents.index');  
        
    }
    public function rules($id="") {	
        $rules = array();
        if(!$id) {
            $rules['document'] = "required_if:navigation_id,1,2,3,4,5,6,7,8,11|mimes:pdf|max:5120";
            $rules['navigation_id'] = "required";
            
            if(request('navigation_id') == '13') {
		$rules['document'] = "sometimes|mimes:pdf|max:15360";
	    }
        }

       
        $rules['display_filename'] = "sometimes|nullable|min:2|max:300";
        $rules['document_image'] = 'required_if:navigation_id,12|mimes:png,jpg,jpeg|max:2048';
        $rules['tags'] = "required_if:navigation_id,1,2,3,4,5,6,7,11";
        $rules['status'] = "required";
        $rules['reference_no'] = "required_if:navigation_id,1,2,3,4,5,6,7,11";
        $rules['visible_to_public'] = "required";
        $rules['dated'] = "required_if:navigation_id,1,2,3,4,5,6,7,11";
        $rules['link_url'] = 'sometimes|nullable|url';
        $rules['link_title'] = 'sometimes|nullable';
        
        return $rules;
    }

    public function messages() {
        return ['navigation_id' => 'Type of Document'];
    }

    public function attributes() {
        return [];
    }

    
    public function export(Request $request){
    	$filename = 'documents-list-'.date('d-m-Y').'.xlsx';
    	return Excel::download(new CustomersExport, $filename);
    	
    }
    

    public function export1(Request $request){
        $filename = 'documents-list-'.date('d-m-Y').'.xlsx';
        return Excel::download(new DocumentsExport, $filename);
        
    }
}
