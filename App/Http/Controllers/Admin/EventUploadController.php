<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ApprovalWorkflows;
use App\Models\EventImages;
use App\Models\EventUpload;
use App\Models\Master;
use App\Models\NewDocument;
use App\Services\FileService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventUploadController extends Controller
{

    private $event_image_path = '/event/images';
    private $event_documents_path = '/event/documents';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = EventUpload::getQueriedResult();
        // dd($results->toArray());
        $statuses = _getGlobalStatus();

        return view('admin.event-upload.list', compact('results', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events = [];
        $today = Carbon::now();
        $languages = Master::getLanguagesData();
        $statuses = _getGlobalStatus();
        $events = NewDocument::where('document_type_id', 13)
            ->where('status', _active())
            ->where('start_date', '<=', $today) // Include events where the start date has passed
            ->whereRaw('DATE_ADD(end_date, INTERVAL 7 DAY) >= ?', [$today])
            ->orderBy('updated_at')
            ->pluck('id', 'name');
        
        return view('admin.event-upload.create', compact('events', 'languages', 'statuses'));
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
            'video_url' => $request->video,
            'event_id' => $request->event_id,
            'status' => $request->status ?? 0,
            'user_id' => Auth::user()->id,
        ];

        $result = EventUpload::create($input);


        if ($request->hasFile('document') && $file = $request->file('document')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, $this->event_documents_path);

                $input['document_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {

                    $storedFileArray = FileService::storeFile($image, $this->event_image_path);
                    EventImages::create([
                        'event_uploads_id' => $result->id,
                        'image_url' => $storedFileArray['stored_file_path'],
                    ]);
                }
            }
        }
        $approvalData = getApprovalData();

        ApprovalWorkflows::create([
            'model_type' => EventUpload::class,        
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

        createdResponse("Events Data Uploaded Successfully");

        return redirect()->route('event-upload.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = EventUpload::with('event')->find($id);
        $approvalResult = ApprovalWorkflows::where('model_id', $id)
                                            ->where('model_type', 'App\Models\EventUpload')
                                            ->first();
        $images = EventImages::where('event_uploads_id', $id)->get();
        // dd($images->toArray());
        $events = [];
        $today = Carbon::now();
        $statuses = _getGlobalStatus();
        if (isState()) {
            $events = NewDocument::where('document_type_id', 13)
                ->where('status', _active())
                ->where('start_date', '<=', $today) // Include events where the start date has passed
                ->whereRaw('DATE_ADD(end_date, INTERVAL 7 DAY) >= ?', [$today])
                ->orderBy('updated_at')
                ->pluck('id', 'name');
        }
        return view('admin.event-upload.show', compact('events', 'statuses', 'result', 'images', 'approvalResult'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = EventUpload::with('event')->find($id);
        $images = EventImages::where('event_uploads_id', $id)->get();
        // dd($images->toArray());
        $events = [];
        $today = Carbon::now();
        $languages = Master::getLanguagesData();
        $statuses = _getGlobalStatus();
        if (isState()) {
            $events = NewDocument::where('document_type_id', 13)
                ->where('status', _active())
                ->where('start_date', '<=', $today) // Include events where the start date has passed
                ->whereRaw('DATE_ADD(end_date, INTERVAL 7 DAY) >= ?', [$today])
                ->orderBy('updated_at')
                ->pluck('id', 'name');
        }
        return view('admin.event-upload.edit', compact('events', 'languages', 'statuses', 'result', 'images'));
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


        $upload_event_details = EventUpload::find($id);

        $input = [
            'video_url' => $request->video,
            'event_id' => $request->event_id,
            'status' => $request->status ?? 0,
            'user_id' => Auth::user()->id,
        ];

        if ($request->deleted_images) {
            $deletedImages = json_decode($request->deleted_images, true);
            foreach ($deletedImages as $imageId) {
                $image = EventImages::find($imageId);
                if ($image) {
                    $storedFile = FileService::deleteDiskFile($image->image_url,'/');
                    $image->delete();
                }
            }
        }


        if ($request->hasFile('document') && $file = $request->file('document')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, $this->event_documents_path, $upload_event_details->image_url);

                $input['document_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {

                    $storedFileArray = FileService::storeFile($image, $this->event_image_path);
                    EventImages::create([
                        'event_uploads_id' => $id,
                        'image_url' => $storedFileArray['stored_file_path'],
                    ]);
                }
            }
        }

        $result = $upload_event_details->update($input);

        createdResponse("Upload Events Updated Successfully");

        return redirect()->route('event-upload.index');
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

        $rules['images.*'] = 'sometimes|mimes:png,jpg,jpeg|max:4096';
        $rules['documents'] = 'sometimes|mimes:pdf|max:5120';
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
