<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\DocumentType;
use App\Services\FileService;
use App\Models\Tag;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DocumentsExport;
use App\Models\ApprovalWorkflows;
use App\Models\Master;
use App\Models\NewDocument;
use App\Models\Program;
use App\Models\Scheme;
use App\Models\Section;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToArray;

class NewDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = NewDocument::getQueriedResult();


        $sections = Section::where('status', _active())->get();
        $document_types = DocumentType::where('status', _active())->get();
        $statuses = _getGlobalStatus();

        return view('admin.documents.list', compact('results', 'sections', 'document_types', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
        $languages = Master::getLanguagesData();
        $document_types = DocumentType::where('status', _active())->orderBy('order_no')->get();
        if (isState()) {
            $programs_id = auth()->user()->programs_id;
            $sections_id = auth()->user()->sections_id;
            if ($programs_id) {
                $schemes = Scheme::where('status', _active())->where('programs_id', $programs_id)->orderBy('name')->pluck('name', 'id');
                $sections = Section::where('status', _active())->where('programs_id', $programs_id)->orderBy('name')->pluck('name', 'id');
            } elseif ($sections_id) {
                $programs_id = Section::where('status', _active())->where('id', $sections_id)->pluck('programs_id');
                $schemes = Scheme::where('status', _active())->where('programs_id', $programs_id)->orderBy('name')->pluck('name', 'id');
                $sections = Section::where('status', _active())->where('id', $sections_id)->orderBy('name')->pluck('name', 'id');
            }
        } else {
            $schemes = Scheme::where('status', _active())->orderBy('name')->pluck('name', 'id');
            $sections = Section::where('status', _active())->orderBy('name')->pluck('name', 'id');
        }

        $programs = Program::where('status', _active())->orderBy('name')->pluck('name', 'id');

        $publications = Master::getPublicationsData();
        $notifications = Master::getNotifacationsData();
        $events_type = Master::getEventsData();

        return view('admin.documents.create', compact('statuses', 'document_types', 'sections', 'programs', 'schemes', 'languages', 'publications', 'notifications', 'events_type'));
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
        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $approvalStage = null;
        // dd('its correct');

        if (Auth::user()->user_type_id == 7) {
            $approvalStage = 'published'; // Replace with the actual stage name for user type 1
        } elseif (in_array(Auth::user()->user_type_id, [1,2,3,4,5,6])) {
            // dd('its correct');
            if (Auth::user()->user_role_id == 1) {
                $approvalStage = 'approved';
            } elseif (Auth::user()->user_role_id == 2) {
                $approvalStage = 'verified';
            }
        }

        $input = [
            'document_type_id' => $request->document_type_id,
            'name' => $request->name,
            'scheme_id' => $request->scheme_id,
            'section_id' => $request->section_id,
            'status' => $request->status ?? 0,
            'reference_no' => $request->reference_no,
            'description' => $request->description,
            'financial_year' => $request->financial_year,
            'link' => $request->link,
            'link_title' => $request->link_title,
            'notification_type_id' => $request->notification_type_id,
            'expiry_date' => $request->expiry_date,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'visible_to_public' => $request->visible_to_public ?? 0,
            'publication_type_id' => $request->publication_type_id,
            'event_type_id' => $request->event_type_id,
            'dated' => dateOf($request->dated, 'Y-m-d h:i:s'),
            'user_id' => Auth::user()->id,
            'language_id' => $request->language,
        ];

        if ($request->hasFile('document') && $file = $request->file('document')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file);

                $input['document_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('image') && $file = $request->file('image')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file);

                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }


        $result = NewDocument::create($input);

        $approvalData = getApprovalData();

        ApprovalWorkflows::create([
            'model_type' => NewDocument::class,        
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

        createdResponse("Document Uploaded Successfully");

        return redirect()->route('new-documents.index', ['document_type' => $request->document_type_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = new NewDocument();
        $result = $document->getDocument($id);
        $approvalResult = ApprovalWorkflows::where('model_id', $id)
        ->where('model_type', 'App\Models\NewDocument')
        ->first();
        // dd($result->notification->name);
        return view('admin.documents.show', compact('result', 'approvalResult'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = NewDocument::with('document_type')->find($id);
        //dd($result->toArray());
        $statuses = _getGlobalStatus();
        $programs = Program::where('status', _active())->orderBy('name')->pluck('name', 'id');
        $languages = Master::getLanguagesData();
        $publications = Master::getPublicationsData();
        $notifications = Master::getNotifacationsData();
        $sections = Section::where('status', _active())->orderBy('name')->pluck('name', 'id');
        $documents_type = DocumentType::where('status', _active())->orderBy('order_no')->get();
        $events_type = Master::getEventsData();
        $schemes = Scheme::where('status', _active())->orderBy('name')->pluck('name', 'id');
        return view('admin.documents.edit', compact('result', 'statuses', 'documents_type', 'schemes', 'programs', 'languages', 'publications', 'sections', 'notifications', 'events_type'));
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
        $validator = Validator::make($request->all(), $this->rules($id), $this->messages(), $this->attributes());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $document = NewDocument::find($id);
        $input = array();
        $input = [
            'document_type_id' => $request->document_type_id,
            'name' => $request->name,
            'scheme_id' => $request->scheme_id,
            'status' => $request->status ?? 0,
            'reference_no' => $request->reference_no,
            'section_id' => $request->section_id,
            'description' => $request->description,
            'financial_year' => $request->financial_year,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'link' => $request->link,
            'link_title' => $request->link_title,
            'event_type_id' => $request->event_type_id,
            'notification_type_id' => $request->notification_type_id,
            'expiry_date' => $request->expiry_date,
            'visible_to_public' => $request->visible_to_public ?? 0,
            'publication_type_id' => $request->publication_type_id,
            'dated' => dateOf($request->dated, 'Y-m-d h:i:s'),
            'user_id' => Auth::user()->id,
            'language_id' => $request->language,
        ];

        if ($request->hasFile('document') && $file = $request->file('document')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, '/', $document->image_url);

                $input['document_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('image') && $file = $request->file('image')) {
            if ($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, '/', $document->image_url);
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = $document->update($input);

        updatedResponse("Document Updated Successfully");

        return redirect()->route('new-documents.index', ['document_type' => $request->document_type_id]);
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
        if (!$id) {
            $rules['document'] = "required_if:document_type_id,1,2,3,5,6,7,8,11|mimes:pdf|max:5120";
            $rules['document_type_id'] = "required";

            if (request('document_type_id') == '13') {
                $rules['document'] = "sometimes|mimes:pdf|max:15360";
            }
        }


        $rules['name'] = "sometimes|nullable|min:2|max:300";
        $rules['image'] = 'sometimes|mimes:png,jpg,jpeg|max:2048';
        $rules['scheme_id'] = "required_if:document_type_id,1,2,3,5,6,7";
        $rules['status'] = "sometimes";
        $rules['reference_no'] = "required_if:document_type_id,1,2,3,5,6,7";
        $rules['visible_to_public'] = "sometimes";
        $rules['dated'] = "required_if:document_type_id,1,2,3,5,6,7,11";
        $rules['description'] = 'sometimes|nullable';
        $rules['link_title'] = 'sometimes|nullable';

        return $rules;
    }

    public function messages()
    {
        return ['navigation_id' => 'Type of Document'];
    }

    public function attributes()
    {
        return [];
    }
}
