@extends('admin.layouts.layout')
@section('title', 'Create Media Gallery')
@section('content')
<div class="container" style="margin-top: 90px;">
    <!-- Your existing code for breadcrumb and content -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
                            <form action="{{ route('media-gallery.store') }}" enctype="multipart/form-data" method="post" id="myForm">
                                {{ csrf_field() }}
                                <div class="container">
                                    <h4 class="card-title mb-4 text-primary">Create Media Gallery</h4>

                                    <!-- Media Type Row -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="media_gallery" class="form-label">Select Media Type <span class="sizeoftextred">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <select class="form-control" id="media_gallery" name="media_gallery" onchange="toggleMediaFields()">
                                                <option value="" disabled selected>Select a Media Gallery</option>
                                                @foreach ($media_gallery as $key => $type)
                                                    <option value="{{ $key }}" data-value="{{ $type }}">{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                  <div class="row mb-3">
    <!-- Label Column with reduced width -->
   

                                    <!-- Media Fields -->
                                    <div id="mediaFieldsContainer"></div>
                                  

                                    <!-- Common Fields: Title, Description, Date -->
 <div class="row mb-3"></div>
                                       <div class="col-12 col-md-3">
        <label for="tags" class="form-label">Tags<span class="sizeoftextred">*</span></label>
    </div>
    <!-- Input Column -->
<div class="col-12 col-md-7"> 
    <select class="form-control" id="tags" name="tags[]" multiple>
        <option value="" disabled>Select Tags</option>
        @foreach ($tags as $tag)
            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
        @endforeach
    </select>
</div></div>

                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="title" class="form-label">Title <span class="sizeoftextred">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" name="title" id="title" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="description" class="form-label">Description <span class="sizeoftextred">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="date" class="form-label">Date <span class="sizeoftextred">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="date" name="date" id="date" class="form-control" required>
                                        </div>
                                    </div>

                                    <!-- Status Row -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="status" class="form-label">Status <span class="sizeoftextred">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" name="status" type="checkbox" id="toggleStatus" value="1" onchange="toggleStatusText('statusLabel', this)">
                                                <label class="form-check-label" for="toggleStatus" id="statusLabel">In-Active</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Buttons -->
                                <div class="d-flex mt-2 pl-5">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
                        <input type="file" name="image" id="image" class="form-control" accept="image/jpeg, image/png, image/jpg" onchange="previewImage(event)" required>
                        <small class="sizeoftextred">Accepted .jpg/.jpeg/.png format & allowed max size is 5MB</small>
                        <br>
                        <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 300px; display: none;"/>
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
                        <input type="url" name="url" id="url" class="form-control" placeholder="https://example.com" required>
                    </div>
                </div>
            `;
        }
    }

    // Client-side form validation
    function validateForm(event) {
        let title = document.getElementById("title");
        let description = document.getElementById("description");
        let date = document.getElementById("date");
        let mediaGallery = document.getElementById("media_gallery").value;
        let image = document.getElementById("image");
        let url = document.getElementById("url");

        // Check if title is filled
        if (title.value.trim() === "") {
            alert("Title is required!");
            event.preventDefault(); // Prevent form submission
            return false;
        }

        // Check if description is filled
        if (description.value.trim() === "") {
            alert("Description is required!");
            event.preventDefault(); // Prevent form submission
            return false;
        }

        // Check if date is filled
        if (date.value.trim() === "") {
            alert("Date is required!");
            event.preventDefault(); // Prevent form submission
            return false;
        }

        // Additional media gallery specific validation
        if (mediaGallery == 1 && !image.files.length) { // Image
            alert("Image is required!");
            event.preventDefault(); // Prevent form submission
            return false;
        }

        if ((mediaGallery == 2 || mediaGallery == 3) && url.value.trim() === "") { // Audio or Video
            alert("URL is required!");
            event.preventDefault(); // Prevent form submission
            return false;
        }

        return true; // If all validations pass, form will be submitted
    }

    // Attach the validateForm function to the form's submit event
    document.getElementById("myForm").onsubmit = validateForm;

    //Image validation
    function previewImage(event) {
    let output = document.getElementById('imagePreview');
    let file = event.target.files[0];

    // Log the file type to the console for debugging
    console.log("Selected file:", file);
    console.log("File type:", file.type);

    // Check if the file is an image
    if (file && file.type.startsWith('image/')) {
        let reader = new FileReader();

        reader.onload = function(e) {
            output.src = e.target.result;
            output.style.display = 'block';  // Show the image preview
        };

        reader.readAsDataURL(file);
    } else {
        alert('Please upload a valid image file (jpeg, png, jpg)');
        output.style.display = 'none'; // Hide the preview if the file is invalid
    }
}

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
    <script>
    $(document).ready(function() {
        $('#tags').select2({
            placeholder: "Select Tags",
            allowClear: true
        });
    });
</script>
@endsection
