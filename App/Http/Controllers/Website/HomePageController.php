<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Navigation;
use App\Models\Tag;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\District;
use App\Models\HUD;
use App\Models\Block;
use App\Models\PHC;
use App\Models\HSC;
use App\Models\Contact;

use App\Http\Resources\WebsiteDocumentResource;
use App\Http\Resources\HUDResource;
use App\Http\Resources\BlockResource;
use App\Http\Resources\PHCResource;
use App\Http\Resources\HSCResource;
use App\Http\Resources\ContactResource;
use App\Http\Resources\DocumentTypeResource;
use App\Http\Resources\MediaGalleryResource;
use App\Models\DocumentType;
use App\Models\EventUpload;
use App\Models\MediaGallery;
use App\Models\NewDocument;
use App\Models\Program;
use App\Models\ProgramDetail;
use App\Models\ProgramOfficer;
use App\Models\Scheme;
use App\Models\SchemeDetail;

class HomePageController extends Controller
{

    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function utilities(Request $request)
    {

        $navigations = Navigation::where('status', _active())->select('id', 'name')->get();
        $sections = Tag::where('status', _active())->select('id', 'name')->get();
        return sendResponse(['navigations' => $navigations, 'sections' => $sections]);
    }

    public function getNavFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'navigation_id' => 'sometimes|exists:navigations,id,status,' . _active(),
            'section_id' => 'sometimes|exists:tags,id,status,' . _active(),
        ]);

        if ($validator->fails()) {
            return sendError($validator->errors());
        }


        $documentTypes = DocumentType::where('status', _active())->whereIn('id', [1, 2, 3, 4, 6, 7, 8, 9, 10, 11, 13])->get();
        $sidebarItems = DocumentTypeResource::collection($documentTypes);

        $documents = NewDocument::getNavigationDocument($request->navigation_id);
        // dd($documents->toArray());
        $contentItems = WebsiteDocumentResource::collection($documents)->groupBy('document_type_id');

        // dd([
        //     'sidebarItems' => $sidebarItems->toJson(JSON_PRETTY_PRINT),
        //     'contentItems' => $contentItems->toJson(JSON_PRETTY_PRINT)
        // ]);
        // dd($documents->toArray());
        return sendResponse([
            'sidebarItems' => $sidebarItems,
            'contentItems' => $contentItems
        ]);
    }

    public function getEvents(Request $request)
    {

        $documents = NewDocument::getNavigationDocument(13);
        // dd($documents->toArray());
        $contentItems = WebsiteDocumentResource::collection($documents);

        // dd([
        //     'sidebarItems' => $sidebarItems->toJson(JSON_PRETTY_PRINT),
        //     'contentItems' => $contentItems->toJson(JSON_PRETTY_PRINT)
        // ]);
        // dd($documents->toArray());
        return sendResponse($contentItems);
    }

    public function getDistricts(Request $request)
    {
        $districts = District::getDistrictData();
        return sendResponse($districts);
    }

    public function getHuds(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'district_id' => 'sometimes|exists:districts,id,status,' . _active(),
        ]);

        if ($validator->fails()) {
            return sendError($validator->errors());
        }

        $huds = HUD::getHudData($request->district_id);
        // dd($huds->toarray());
        return sendResponse(HUDResource::collection($huds));
    }

    public function getBlocks(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hud_id' => 'sometimes|exists:huds,id,status,' . _active(),
        ]);

        if ($validator->fails()) {
            return sendError($validator->errors());
        }

        $blocks = Block::getBlockData($request->hud_id);
        return sendResponse(BlockResource::collection($blocks));
    }

    public function getPHC(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'block_id' => 'sometimes|exists:blocks,id,status,' . _active(),
        ]);

        if ($validator->fails()) {
            return sendError($validator->errors());
        }

        $phc = PHC::getPhcData($request->block_id);
        return sendResponse(PHCResource::collection($phc));
    }

    public function getHSC(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phc_id' => 'sometimes|exists:p_h_c_s,id,status,' . _active(),
        ]);

        if ($validator->fails()) {
            return sendError($validator->errors());
        }

        $hsc = HSC::getHscData($request->phc_id);
        return sendResponse(HSCResource::collection($hsc));
    }

    public function getContacts(Request $request)
    {
        $contacts = Contact::getContactData();
        return sendResponse(ContactResource::collection($contacts));
    }

    public function  getPrograms(Request $request)
    {
        // Fetch all programs
        $programs = Program::where('status', _active())->orderBy('order_no', 'asc')->get();

        // Prepare tabKeys
        $tabKeys = $programs->pluck('name')->toArray();

        // Prepare tabData
        $tabData = [];
        foreach ($programs as $program) {
            // Fetch program detail associated with the program
            $programDetail = ProgramDetail::where('programs_id', $program->id)->first();

            // Fetch all program officers for this program
            $programOfficers = ProgramOfficer::where('programs_id', $program->id)->orderBy('order_no', 'asc')->get();

            $documents = NewDocument::whereHas('scheme', function ($query) use ($program) {
                $query->where('programs_id', $program->id);
            })->get();

            $docsArray = [
                'gos' => WebsiteDocumentResource::collection($documents->where('document_type_id', 1)),
                'circulars' => WebsiteDocumentResource::collection($documents->where('document_type_id', 2)),
                'events' => WebsiteDocumentResource::collection($documents->where('document_type_id', 13)),
            ];

            // Populate tabData for each program
            $tabData[$program->name] = [
                'iconUrl' => fileLink($programDetail->icon_url ?? ''),
                'docs' => $docsArray,
                'document_url' => fileLink($programDetail && $programDetail->document ? $programDetail->document : ''),
                'description' => $programDetail->description ?? '',
                'program_officers' => $programOfficers->map(function ($officer) {
                    return [
                        'name' => $officer->name ?? '',
                        'imageUrl' => fileLink($officer->image ?? ''),
                        'designation' => $officer->designation->name ?? '',
                        'level' => $officer->level ?? '',

                    ];
                }),
            ];
        }

        // $baseUrl = 'https://test.tndphpm.com/admin/tndphpmfiles/';
        // Prepare sliderImages
        $sliderImages = [];
        foreach ($programs as $program) {
            $programDetail = ProgramDetail::where('programs_id', $program->id)->where('status',  _active())->first();

            if ($programDetail) {
                $sliderImages[$program->name] = array_filter([
                    $programDetail->image_one ?  fileLink($programDetail->image_one) : null,
                    $programDetail->image_two ? fileLink($programDetail->image_two) : null,
                    $programDetail->image_three ? fileLink($programDetail->image_three) : null,
                    $programDetail->image_four ? fileLink($programDetail->image_four) : null,
                    $programDetail->image_five ? fileLink($programDetail->image_five) : null,
                ]);
            } else {
                $sliderImages[$program->name] = [];
            }
        }

        // Prepare submenuItems (schemes)
        $submenuItems = [];
        foreach ($programs as $program) {
            $schemes = Scheme::where('programs_id', $program->id)->where('status',  _active())->get();


            $submenuItems[$program->name] = [];
            foreach ($schemes as $scheme) {
                $schemeDetail = SchemeDetail::where('schemes_id', $scheme->id)->where('status',  _active())->first();

                $documents = NewDocument::where('scheme_id', $scheme->id)->get();

                $docsArray = [
                    'gos' => WebsiteDocumentResource::collection($documents->where('document_type_id', 1)),
                    'circulars' => WebsiteDocumentResource::collection($documents->where('document_type_id', 2)),
                    'events' => WebsiteDocumentResource::collection($documents->where('document_type_id', 13)),
                ];

                $submenuItems[$program->name][] = [
                    'title' => $scheme->name,
                    'iconUrl' => fileLink($schemeDetail && $schemeDetail->icon_url ? $schemeDetail->icon_url : ''), // Adjust path
                    'banner_images' => array_filter([
                        fileLink($schemeDetail && $schemeDetail->image_one ? $schemeDetail->image_one : null),
                        fileLink($schemeDetail && $schemeDetail->image_two ? $schemeDetail->image_two : null),
                        fileLink($schemeDetail && $schemeDetail->image_three ? $schemeDetail->image_three : null),
                        fileLink($schemeDetail && $schemeDetail->image_four ? $schemeDetail->image_four : null),
                        fileLink($schemeDetail && $schemeDetail->image_five ? $schemeDetail->image_five : null),
                    ]),
                    'report_images' => array_filter([
                        fileLink($schemeDetail && $schemeDetail->report_image_one ? $schemeDetail->report_image_one : null),
                        fileLink($schemeDetail && $schemeDetail->report_image_two ? $schemeDetail->report_image_two : null),
                        fileLink($schemeDetail && $schemeDetail->report_image_three ? $schemeDetail->report_image_three : null),
                        fileLink($schemeDetail && $schemeDetail->report_image_four ? $schemeDetail->report_image_four : null),
                        fileLink($schemeDetail && $schemeDetail->report_image_five ? $schemeDetail->report_image_five : null),
                    ]),
                    'document_url' => fileLink($schemeDetail && $schemeDetail->document_url ? $schemeDetail->document_url : ''),
                    'description' => $schemeDetail->description ?? '',
                    'docs' => $docsArray,
                ];
            }
        }

        // Combine all the data into the desired format
        $responseData = [
            'tabKeys' => $tabKeys,
            'tabData' => $tabData,
            'sliderImages' => $sliderImages,
            'submenuItems' => $submenuItems,
        ];

        return response()->json($responseData);
    }

    public function getMediaGallery(Request $request)
    {
        $eventGallery = EventUpload::getEventGalleryData();
        $programGallery = ProgramDetail::getProgramGalleryData();
        $schemeGallery = SchemeDetail::getSchemerGalleryData();
        $mediaGallery = MediaGallery::getMediaGalleryData();

        $mergedMediaGallery = $eventGallery->concat($programGallery)->concat($schemeGallery)->concat($mediaGallery);

        $sortedMediaGallery = $mergedMediaGallery->sortByDesc('created_at');

        return sendResponse(MediaGalleryResource::collection($sortedMediaGallery));
    }
}
