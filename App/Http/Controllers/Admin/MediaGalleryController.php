<?php


namespace App\Http\Controllers\Admin;
use App\Models\MediaGallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MediaGalleryResource;
use App\Models\Configuration;
use App\Services\FileService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\FetchTag;
class MediaGalleryController extends Controller
{
    private $media_gallery_path = '/media_gallery';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $search = $request->get('search');
    $perPage = $request->get('pageLength', 10); // match your HTML select name

        
        $results = MediaGallery::all();
               if (!empty($search)) {
        $results = $results->filter(function ($item) use ($search) {
            return stripos($item->name ?? '', $search) !== false;
        });
    }    if (method_exists($results, 'paginate')) {
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
    }foreach ($results as $result) {
    // Fetch active tags (consistent with your existing code)
     $tags = FetchTag::where('status', 1)->orderBy('name')->get(['id', 'name']);
    
    // Get tag IDs (from the result)
    $tagIds = explode(',', $result->tags);

    // Fetch tag names by matching the tag IDs
    $tagNames = $tags->whereIn('id', $tagIds)->pluck('name')->toArray();

    // Store the tag names as a comma-separated string
    $result->tag_names = implode(', ', $tagNames);
}


        
        $statuses = _getGlobalStatus();
        return view('admin.configurations.media-gallery.list', compact('results', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
        $media_gallery = config('constant.media_gallery');
         $tags = FetchTag::where('status', 1)->orderBy('name')->get(['id', 'name']);
        // $menu_to_show = getMenuToShow();
        return view('admin.configurations.media-gallery.create', compact('statuses', 'media_gallery', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Determine the selected media type
        $mediaType = $request->input('media_gallery');

        // Base validation rules
        $rules = [
            'media_gallery' => 'required|integer',
            
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'date' => 'required|date',
            'status' => 'nullable|boolean',
        ];

        // Conditional validation for media type
        if ($mediaType == 1) { // Image
            $rules['image'] = 'required|mimes:jpeg,png,jpg|max:4096';
        } elseif (in_array($mediaType, [2, 3])) { // Audio or Video
            $rules['url'] = 'required|url';
        }

        // Validate the request
        $validated = $request->validate($rules);

        // Create a new MediaGallery instance
        $mediaGallery = new MediaGallery();
        $mediaGallery->media_gallery = $mediaType;
         $mediaGallery->tags = is_array($request->tags) ? implode(',', $request->tags) : $request->tags;

        $mediaGallery->title = $request->title;
        $mediaGallery->description = $request->description;
        $mediaGallery->date = $request->date;
        $mediaGallery->status = $request->status ? 1 : 0;
        $mediaGallery->url = $request->url;

        // Handle file upload for images
        if ($mediaType == 1 && $request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {
                $storedFileArray = FileService::storeFile($file, $this->media_gallery_path);
                $mediaGallery->image = $storedFileArray['stored_file_path'] ?? '';
            }
        }

        $mediaGallery->save();

        return redirect()->route('media-gallery.index')->with('success', 'Media Gallery Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = MediaGallery::find($id);
        return view('admin.configurations.media-gallery.show',compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find the MediaGallery item by ID
        $mediaGallery = MediaGallery::findOrFail($id);
        $statuses = _getGlobalStatus();
        $media_gallery = config('constant.media_gallery');
          $tags = FetchTag::where('status', _active())->orderBy('name')->pluck('name', 'id');
    $selectedTags = $mediaGallery->tags ? explode(',', $mediaGallery->tags) : [];
    return view('admin.configurations.media-gallery.edit', compact('mediaGallery', 'statuses', 'media_gallery', 'tags', 'selectedTags'));
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
        // Retrieve the current MediaGallery item
        $mediaGallery = MediaGallery::findOrFail($id);

        // Determine the media type
        $mediaType = $request->input('media_gallery');

        // Define base validation rules
        $rules = [
            'media_gallery' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'date' => 'required|date',
            'status' => 'nullable|boolean',
            //   'tags' => is_array($request->tags) ? implode(',', $request->tags) : $request->tags,
        ];

        // Conditional validation based on media type
        if ($mediaType == 1) { // Image
            $rules['image'] = 'nullable|mimes:jpeg,png,jpg|max:5120'; // Image validation
        } elseif (in_array($mediaType, [2, 3])) { // Audio or Video
            $rules['url'] = 'required|url'; // URL validation for audio/video
        }

        // Validate the request
        $request->validate($rules);

        // Update the common fields
        $mediaGallery->media_gallery = $mediaType;
           $mediaGallery->tags = is_array($request->tags) ? implode(',', $request->tags) : $request->tags;

        $mediaGallery->title = $request->title;
        $mediaGallery->description = $request->description;
        $mediaGallery->date = $request->date;
        $mediaGallery->status = $request->status ? 1 : 0;

        // Handle URL updates for audio or video types
        if (in_array($mediaType, [2, 3])) {
            $mediaGallery->url = $request->url;
        }

        // Handle image upload for image type
        if ($mediaType == 1 && $request->hasFile('image')) {
            $file = $request->file('image');

            if ($file->isValid()) {
                // Store the new image and update the image path
                $storedFileArray = FileService::storeFile($file, $this->media_gallery_path);
                $mediaGallery->image = $storedFileArray['stored_file_path'] ?? '';
            } else {
                return back()->withErrors(['image' => 'Please upload a valid image file (jpeg, jpg, png).']);
            }
        }

        // Save the updated media gallery
        $mediaGallery->save();

        // Redirect to the media gallery index with a success message
        return redirect()->route('media-gallery.index')->with('success', 'Media Gallery Updated Successfully!');
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
}
