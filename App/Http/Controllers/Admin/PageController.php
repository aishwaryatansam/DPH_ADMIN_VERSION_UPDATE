<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ConfigurationContentType;
use App\Models\SiteContent;
use App\Models\Submenu;
use App\Models\Testimonial;
use App\Services\FileService;
use CreateConfigurationContentTypeTable;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    private $about_us_image_path = '/about_us';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contentTypeIds = Submenu::pluck('id')->toArray();
        $results = SiteContent::whereIn('submenu_id', $contentTypeIds)->get();
        $statuses = _getGlobalStatus();
        return view('admin.about-us.list', compact('results', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $configuration_content_types = ConfigurationContentType::getConfigurationTypeData([17, 18, 19, 20, 21, 22, 26]);

        $configuration_content_types = Submenu::getSubmenuData(17);
        $previous_directors = Testimonial::where('is_current_director', '0')->orderBy('id', 'asc')->get();
        // dd($previous_directors);
        $statuses = _getGlobalStatus();
        return view('admin.about-us.create', compact('configuration_content_types', 'previous_directors'));
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

        $input = [
            'name' => $request->name,
            'description' => $request->description,
            'thumbnail_name' => $request->thumbnail_name,
            'souvenir_name' => $request->souvenir_name,
            'configuration_content_type_id' => $request->content_type,
            'submenu_id' => $request->submenu_id,
            'order_no' => $request->order,
            'status' => $request->status ?? 0,
            'visible_to_public' => $request->visible_to_public ?? 0,


        ];

        if ($request->hasFile('document') && $file = $request->file('document')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, $this->about_us_image_path);

                $input['document_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('image') && $file = $request->file('image')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, $this->about_us_image_path);

                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = SiteContent::create($input);

        createdResponse("Page Created Successfully");

        return redirect()->route('about-us.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $configuration_content_types = Submenu::getSubmenuData(17);
        $statuses = _getGlobalStatus();
        $previous_directors = Testimonial::where('is_current_director', '0')->orderBy('id', 'asc')->get();
        $result = SiteContent::with('configuration_content_type')->find($id);
        return view('admin.about-us.show', compact('configuration_content_types', 'result', 'previous_directors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $configuration_content_types = Submenu::getSubmenuData(17);
        $previous_directors = Testimonial::where('is_current_director', '0')->orderBy('id', 'asc')->get();
        $statuses = _getGlobalStatus();
        $result = SiteContent::with('configuration_content_type', 'submenu')->find($id);
        return view('admin.about-us.edit', compact('configuration_content_types', 'result', 'previous_directors'));
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

        $sitecontent = SiteContent::find($id);
        $input = array();
        $input = [
            'name' => $request->name,
            'description' => $request->description,
            'thumbnail_name' => $request->thumbnail_name,
            'souvenir_name' => $request->souvenir_name,
            'order_no' => $request->order,
            'status' => $request->status ?? 0,
            'visible_to_public' => $request->visible_to_public ?? 0,
        ];

        if ($request->hasFile('document') && $file = $request->file('document')) {

            if ($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, $this->about_us_image_path, $sitecontent->image_url);

                $input['document_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        if ($request->hasFile('image') && $file = $request->file('image')) {
            if ($file->isValid()) {
                $storedFileArray = FileService::updateAndStoreFile($file, $this->about_us_image_path, $sitecontent->image_url);
                $input['image_url'] = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $result = $sitecontent->update($input);

        updatedResponse("Page Updated Successfully");

        return redirect()->route('about-us.index');
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
        $rules['name'] = "sometimes|nullable|min:2|max:300";
        $rules['image_'] = 'sometimes|mimes:png,jpg,jpeg|max:2048';
        $rules['document'] = "required_if:document_type_id,1,2,3,5,6,7";
        $rules['status'] = "sometimes";
        $rules['visible_to_public'] = "sometimes";
        $rules['description'] = 'sometimes|nullable';
        $rules['thumbnail_name'] = 'sometimes|nullable';
        $rules['souvenir_name'] = 'sometimes|nullable';
        $rules['order'] = 'sometimes|nullable';


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

    public function getAboutUs()
    {
        // Step 1: Fetch active submenus related to the About Us section
        $submenus = Submenu::where('status', 1) // Only active submenus
            ->orderBy('order', 'asc') // Sort by order
            ->get(['id', 'name', 'slug', 'configuration_content_type_id']);

        // Step 2: Fetch SiteContent data associated with the active submenus
        $submenuIds = $submenus->pluck('id')->toArray();
        $siteContents = SiteContent::whereIn('submenu_id', $submenuIds)
            ->where('status', 1) // Only active content
            ->orderBy('order_no', 'asc') // Sort content by order_no
            ->get();

        // Step 3: Structure the response data
        $menuItems = [];

        foreach ($submenus as $submenu) {
            $submenuContent = $siteContents->where('submenu_id', $submenu->id);

            // Prepare data based on submenu type
            $data = [];

            // If the submenu is 'Organogram', include images and descriptions as array
            if ($submenu->slug == 'organogram') {
                
                    $images = $submenuContent->map(function ($item) {
                        return [
                            'image_url' => fileLink($item->image_url),
                            'description' => $item->description,
                            'title' => $item->name
                        ];
                    })->sortBy('order_no')->values();
                    $data = ['images' => $images];
            } 
            // If the submenu is 'Previous Directors', include directors as array
            elseif ($submenu->slug == 'previous_directors') {
                $directors = Testimonial::where('is_current_director', 0)->get(); // Directors with status 0
                $directorsList = $directors->map(function ($director) {
                    return [
                        'name' => $director->name,
                        'qualification' => $director->qualification,
                        'startYear' => $director->start_year,
                        'endYear' => $director->end_year,
                        'image_url' => fileLink($director->image_url),
                    ];
                });

                $data = [
                    'description' => optional($submenuContent->first())->description,
                    'directors' => $directorsList,
                ];
            }
            // For other submenus, just return description inside data as an array
            else {
                foreach ($submenuContent as $content) {
                    $data = [
                        'description' => $content->description,
                    ];
                }
            }

            // Add submenu to menu items as an object
            $menuItems[] = [
                'title' => $submenu->name,
                'key' => $submenu->slug,
                'data' => $data, // Data is always in an array
            ];
        }

        // Step 4: Return the response as an object
        return response()->json([
            'success' => true,
            'menuItems' => $menuItems,
        ]);
    }


}
