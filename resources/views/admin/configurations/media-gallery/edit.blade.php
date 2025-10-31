@extends('admin.layouts.layout')
@section('title', 'Edit Media Gallery')
@section('content')
<div class="container" style="margin-top: 90px;">
    <div class="container-fluid">
        <div class="page-inner">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <div class="container mt-2">
                    <div class="row">
                        <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                            <form action="{{ route('media-gallery.update', $mediaGallery->id) }}" enctype="multipart/form-data" method="post" id="myForm">
                                @csrf
                                @method('PUT') <!-- We use PUT for updating data -->

                                <div class="container">
                                    <h4 class="card-title mb-4 text-primary">Edit Media Gallery</h4>

                                    <!-- Media Type Row -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="media_gallery" class="form-label">Select Media Type <span class="sizeoftextred">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <select class="form-control" id="media_gallery" name="media_gallery" onchange="toggleMediaFields()">
                                                <option value="" disabled>Select a Media Gallery</option>
                                                @foreach ($media_gallery as $key => $type)
                                                    <option value="{{ $key }}" {{ $mediaGallery->media_gallery == $key ? 'selected' : '' }}>{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Media Fields -->
                                    <div id="mediaFieldsContainer">
                                        <!-- Based on the selected media type, the appropriate fields will be populated -->
                                    </div>

                                    <!-- Common Fields: Title, Description, Date -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="title" class="form-label">Title <span class="sizeoftextred">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $mediaGallery->title) }}" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="description" class="form-label">Description <span class="sizeoftextred">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $mediaGallery->description) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="date" class="form-label">Date <span class="sizeoftextred">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="date" name="date" id="date" class="form-control" value="{{ old('date', $mediaGallery->date) }}" required>
                                        </div>
                                    </div>

                                    <!-- Status Row -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="status" class="form-label">Status <span class="sizeoftextred">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" name="status" type="checkbox" id="toggleStatus" value="1" {{ $mediaGallery->status ? 'checked' : '' }} onchange="toggleStatusText('statusLabel', this)">
                                                <label class="form-check-label" for="toggleStatus" id="statusLabel">{{ $mediaGallery->status ? 'Active' : 'In-Active' }}</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Buttons -->
                                <div class="d-flex mt-2 pl-5">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <button type="button" class="btn btn-danger" onclick="history.back()" style="margin-left: 10px;">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // This function will handle the logic to show/hide fields based on selected media type
    function toggleMediaFields() {
        let mediaGallery = document.getElementById("media_gallery").value;
        let mediaFieldsContainer = document.getElementById("mediaFieldsContainer");

        mediaFieldsContainer.innerHTML = ''; // Reset fields container

        if (mediaGallery == 1) { // Image
            mediaFieldsContainer.innerHTML = `
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="image" class="form-label">Select Image <span class="sizeoftextred">*</span></label>
                    </div>
                    <div class="col-12 col-md-7">
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    </div>
                </div>
            `;
        } else if (mediaGallery == 2 || mediaGallery == 3) { // Audio or Video
            mediaFieldsContainer.innerHTML = `
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="url" class="form-label">Enter URL <span class="sizeoftextred">*</span></label>
                    </div>
                    <div class="col-12 col-md-7">
                        <input type="url" name="url" id="url" class="form-control" placeholder="https://example.com" value="{{ old('url', $mediaGallery->url) }}" required>
                    </div>
                </div>
            `;
        }
    }

    // Initialize media fields on page load based on selected media type
    window.onload = function() {
        toggleMediaFields();
    };
</script>
<script>
    tinymce.init({
    selector: '#description', // Target the textarea by its ID
    height: 300, // Set the height of the editor
    menubar: false, // Disable the menubar (optional)
    plugins: 'lists link image table code help', // Add plugins as needed
    toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code | help', // Customize the toolbar
    });
</script>
@endsection
