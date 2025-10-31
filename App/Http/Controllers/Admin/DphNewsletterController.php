<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SiteContent;
use App\Services\FileService;
use Illuminate\Support\Facades\Validator;

class DphNewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = SiteContent::where('configuration_content_type_id', 25)->get();
        // dd($results->toArray());
        return view('admin.research.dph-newsletter.list', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.research.dph-newsletter.create');
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
                'description' => $request->description,
                'volume' => $request->volume,
                'date' => $request->date,
                'issue' => $request->issue,
                'configuration_content_type_id' => 25,           // 25 - DPH Newsletter
                'status' => $request->status ?? 0
            ];


        if ($request->hasFile('image') && $file = $request->file('image')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, '/research/scientific_advisory');

                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('document') && $file = $request->file('document')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, '/research/scientific_advisory');

                $input['document_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }
        $result = SiteContent::create($input);

        createdResponse("DPH Newsletter Created Successfully");

        return redirect()->route('dph-newsletter.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = SiteContent::findOrFail($id = $id);
        return view('admin.research.dph-newsletter.show', compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = SiteContent::findOrFail($id);
    // dd($result->toArray());
        return view('admin.research.dph-newsletter.edit', compact('result'));
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
        $validator = Validator::make($request->all(),$this->rules(),$this->messages(),$this->attributes());

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                        ->withInput();
        }

        $scientific_advisory = SiteContent::findOrFail($id);
        
        $input = [
                'name' => $request->name,
                'description' => $request->description,
                'volume' => $request->volume,
                'date' => $request->date,
                'issue' => $request->issue,
                'configuration_content_type_id' => 25,           // 25 - DPH Newsletter
                'status' => $request->status ?? 0
            ];


        if ($request->hasFile('image') && $file = $request->file('image')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, '/research/scientific_advisory', $scientific_advisory->image_url);

                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('document') && $file = $request->file('document')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, '/research/scientific_advisory', $scientific_advisory->document_url);

                $input['document_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }
        $result = $scientific_advisory->update($input);

        createdResponse("DPH Newsletter Updated Successfully");

        return redirect()->route('dph-newsletter.index');
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

        $rules['image'] = 'sometimes|mimes:png,jpg,jpeg|max:4096';
        $rules['document'] = 'sometimes|mimes:pdf|max:5120';
        $rules['description'] = 'sometimes|nullable';
        $rules['name'] = 'sometimes|nullable';
        $rules['volume'] = 'sometimes|nullable';
        $rules['issue'] = 'sometimes|nullable';
        $rules['status'] = 'sometimes|boolean';

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

}
