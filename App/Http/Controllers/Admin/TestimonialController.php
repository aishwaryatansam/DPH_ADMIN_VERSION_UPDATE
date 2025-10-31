<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\FileService;
use App\Models\Testimonial;
use Illuminate\Support\Str;
use App\Http\Resources\TestimonialResource;
use App\Models\Tag;


class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Testimonial::getQueriedResult();
        return view('admin.testimonials.list',compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
        $testimonial_type = getTestimonialType();
        return view('admin.testimonials.create',compact('statuses', 'testimonial_type'));
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
                'name' => $request->name,
                'designation' => $request->designation,
                'is_current_director' =>$request->is_current_director ?? 0,
                'qualification' => $request->qualification,
                'start_year' => $request->start,
                'end_year' => $request->end,
                'content' => $request->content,
                'unique_key' => $unique_key = Str::uuid()->toString(),
                'status' => $request->status ?? 0,
                'role' => $request->role ?? 0,
            ];

          

        if($request->hasFile('testimonial_image') && $file = $request->file('testimonial_image')) {

            if($file->isValid()) {
                $storedFileArray = FileService::storeFile($file);

                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if($request->hasFile('testimonial_document') && $file = $request->file('testimonial_document')) {

            if($file->isValid()) {
                $storedFileArray = FileService::storeFile($file);

                $input['testimonial_document_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = Testimonial::create($input);

        createdResponse("Testimonial Created Successfully");

        return redirect()->route($request->is_current_director == '1' ? 'testimonials.index': 'about-us.create');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = Testimonial::find($id);
        return view('admin.testimonials.show',compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = Testimonial::find($id);
        $statuses = _getGlobalStatus();
        return view('admin.testimonials.edit',compact('result', 'statuses'));
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

        $testimonial = Testimonial::find($id);

        $input = array();
        $input = [

                'name' => $request->name,
                'designation' => $request->designation,
                'qualification' => $request->qualification,
                'start_year' => $request->start,
                'end_year' => $request->end,
                'content' => $request->content,
                'status' => $request->status ?? 0
            ];

        if($request->hasFile('testimonial_image') && $file = $request->file('testimonial_image')) {
            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file,'/',$testimonial->image_url);
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if($request->hasFile('testimonial_document') && $file = $request->file('testimonial_document')) {
            if($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file,'/',$testimonial->testimonial_document_url);
                $input['testimonial_document_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = $testimonial->update($input);

        updatedResponse("Testimonial Updated Successfully");

        return redirect()->route($testimonial->is_current_director == '1' ? 'testimonials.index' : 'about-us.index');
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
        $rules['testimonial_image'] = 'sometimes|mimes:png,jpg,jpeg|max:4096';
        $rules['designation'] = 'sometimes|nullable';
        $rules['content'] = 'sometimes|nullable';  
        $rules['status'] = 'sometimes|boolean';

        return $rules;
    }

    public function messages() {
        return [];
    }

    public function attributes() {
        return [];
    }

     public function listTestimonial(Request $request) {
 
        $resource = Testimonial::getTestimonialData();
        return sendResponse(TestimonialResource::collection(collect($resource)));
    }

    
}
