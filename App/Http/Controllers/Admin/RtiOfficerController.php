<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RtiOfficerResource;
use App\Models\Designation;
use App\Models\RTI_PDF;
use App\Models\RtiOfficer;
use App\Services\FileService;
use Illuminate\Support\Facades\Validator;

class RtiOfficerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $rti_pdf_document_path = '/rti_pdf';

    public function index()
    {
        $results = RtiOfficer::getQueriedResult();
        $pdfs = \App\Models\RTI_PDF::all(); // Fetch the uploaded PDFs
        return view('admin.configurations.rti-officers.list', compact('results', 'pdfs'));

        $results = RtiOfficer::getQueriedResult();
        return view('admin.configurations.rti-officers.list', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $designations = Designation::getDesignationData();
        return view('admin.configurations.rti-officers.create', compact('designations'));
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

        $input = [
            'title' => $request->title,
            'name' => $request->name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'landline_number' => $request->landline_number,
            'extn' => $request->extn,
            'fax' => $request->fax,
            'address' => $request->address,
            'designations_id' => $request->designations_id,
            'status' => $request->status ?? 0
        ];

        $result = RtiOfficer::create($input);

        createdResponse("RTI Officer Created Successfully");

        return redirect()->route('rti-officer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = RtiOfficer::findOrFail($id);
        return view('admin.configurations.rti-officers.show', compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = RtiOfficer::findOrFail($id);
        $designations = Designation::getDesignationData();
        return view('admin.configurations.rti-officers.edit', compact('result', 'designations'));
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

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $result = RtiOfficer::find($id);
        $input = [
            'title' => $request->title,
            'name' => $request->name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'landline_number' => $request->landline_number,
            'extn' => $request->extn,
            'fax' => $request->fax,
            'address' => $request->address,
            'designations_id' => $request->designations_id,
            'status' => $request->status ?? 0
        ];


        $result->update($input);

        createdResponse("RTI Officer Updated Successfully");

        return redirect()->route('rti-officer.index');
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

        $rules['title'] = 'required';
        $rules['name'] = 'required';
        $rules['email'] = 'required';
        $rules['mobile_number'] = 'required';
        $rules['landline_number'] = 'required';
        $rules['extn'] = 'required';
        $rules['fax'] = 'required';
        $rules['address'] = 'required';
        $rules['designations_id'] = 'required|exists:designations,id';
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

    public function getRtiOfficer(Request $request)
    {
        // $validator = Validator::make($request->all(),[
        //     'program_id' => 'required|exists:programs,id,status,'._active(),
        // ]);

        // if($validator->fails()) {
        //     return sendError($validator->errors());
        // }
        $rti_officer = RtiOfficer::getRtiOffersData();
        $rti_pdf = RTI_PDF::getRtiPdfData();
        return sendResponse([
            'rti_officers' => RtiOfficerResource::collection($rti_officer),
            'rti_pdf' => $rti_pdf ? [
                'id' => $rti_pdf->id,
                'file_name' => $rti_pdf->file_name,
                'file_path' => fileLink($rti_pdf->file_path),
                'upload_date' => $rti_pdf->upload_date,
            ] : null,
        ]);
    }

    public function RTI_Contact_PDF(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'pdf_file' => 'required|mimes:pdf|max:2048',
                'upload_date' => 'required|date',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('pdf_file')) {
                $file = $request->file('pdf_file');
                $fileName = time() . '_' . $file->getClientOriginalName();

                if ($file->isValid()) {
                    $storedFileArray = FileService::storeFile($file, $this->rti_pdf_document_path);

                    $fileUrl = $storedFileArray['stored_file_path'] ?? '';
                }
                
                RTI_PDF::create([
                    'file_name' => $fileName,
                    'file_path' => $fileUrl,
                    'upload_date' => $request->upload_date,
                ]);

                return redirect()->back()->with('success', 'PDF uploaded successfully.');
            }

            return redirect()->back()->with('error', 'Failed to upload the PDF.');
        }

        return redirect()->route('rti-officer.index');
    }
}
