@extends('admin.layouts.layout')
@section('title', 'Create Scheme Details')
@section('content')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .drag-drop-container {
            border: 2px dashed #6c757d;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            background-color: #f8f9fa;
            position: relative;
            transition: all 0.3s ease;
        }

        .drag-drop-container:hover {
            background-color: #e9ecef;
            border-color: #adb5bd;
        }

        .drag-drop-container .drag-drop-text {
            color: #6c757d;
            font-size: 1rem;
            margin: 0;
        }

        .drag-drop-container .drag-drop-text span {
            color: #007bff;
            font-weight: bold;
            cursor: pointer;
        }


        .upload-container {
            position: relative;
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
        }

        .upload-label {
            background: #f1f1f1;
            color: #6c757d;
            border: 2px dashed #ced4da;
            padding: 20px;
            cursor: pointer;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .upload-label:hover {
            background: #e9ecef;
            border-color: #adb5bd;
        }

        .upload-input {
            display: none;
        }

        .upload-container img {
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .remove-button {
            font-size: 1.2rem;
            line-height: 1;
            cursor: pointer;
            display: inline-block;
            text-align: center;
            vertical-align: middle;
            z-index: 10;
        }

        
    </style><script>
    $(document).ready(function() {
        $('#tags').select2({
            placeholder: "Select tags",
            width: '100%',
            allowClear: true
        });
    });
</script>
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Schemes</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Schemes Create</li>
                    </ol>
                </nav>

            </div>
        </div>

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
                <!-- insert the contents Here start -->

                <!-- description start============================================================ -->
                <div class="container mt-2">
                    <div class="row">
                        <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                            <form id="combinedForm" action="{{ route('schemedetails.store') }}"
                                enctype="multipart/form-data" method="post">
                                {{ csrf_field() }}
                                <div class="container">
                                    <h4 class="card-title mb-4 text-primary">Create Scheme Details</h4>

                                    <!-- Main Menu Dropdown Row -->
                                    @if (isAdmin())
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="mainmenu" class="form-label">Programs & Division</label>
                                            </div>
                                            <div class="col-12 col-md-8">
<select name="programs_id" id="programs_id" class="form-control" >
    <option value="">-- Select Program -- </option>
    @foreach ($programs as $key => $value)
        <option value="{{ $value->id }}"
            {{ (old('programs_id', $selectedProgramId ?? '') == $value->id) ? 'selected' : '' }}>
            {{ $value->name }}
        </option>
    @endforeach
</select>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Main Menu Dropdown Row -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="mainmenu" class="form-label">Schemes<span
                                                    style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                        <select name="scheme_id" id="scheme_id" class="form-control">
    <option value="">-- Select Scheme -- </option>
    @foreach ($schemes as $key => $value)
        <option value="{{ $value->id }}"
            {{ old('scheme_id') == $value->id ? 'selected' : '' }}>
            {{ $value->name }}
        </option>
    @endforeach
</select>
                                        </div>
                                    </div>

                                    <!-- Description Text Area -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="description" class="form-label">Description <span
                                                    style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <textarea class="form-control" id="description" rows="4" placeholder="Enter description" name="description"></textarea>
                                        </div>
                                    </div>

                                    <!-- Image Upload Section -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="imageUploads" class="form-label">Select Images <span
                                                    style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <input type="file" id="imageUploads" name="images[]" class="form-control"
                                                accept="image/*" multiple onchange="previewImages()" required>
                                        </div>
                                    </div>

                                    <!-- Image Preview Section -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-7 offset-md-3">
                                            <div id="imagePreviews" class="d-flex flex-wrap"></div>
                                            <small class="sizeoftextred">Upload upto 5 images only, Accepted formats: .jpg
                                                .jpeg .png, Max size: 5MB</small>
                                        </div>
                                    </div>

                                    <!-- Upload Document Row -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="document" class="form-label">Upload Document</label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <input type="file" class="form-control" id="document" name="document"
                                                accept=".pdf,.doc,.docx">
                                            <small class="sizeoftextred">Accepted formats: .pdf, Max size: 5MB</small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                  <div class="col-12 col-md-3">
                              
                         </div>
<div class="row mb-3">
    <div class="col-12 col-md-3">
        <label for="tags" class="form-label">Tags</label>
    </div>
    <div class="col-12 col-md-8">
        <select name="tags[]" id="tags" class="form-control" multiple>
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
            @endforeach
        </select>
        <small class="text-muted">Select one or more tags</small>
    </div>
</div>

                        </div>

                                    <!-- Upload Icon Row -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="icon" class="form-label">Upload Icon<span
                                                style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <input type="file" class="form-control" id="icon" name="icon"
                                                accept=".png" required>
                                            <small class="sizeoftextred">Accepted formats: .png, Max size: 5MB</small>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">Performance Report Images</label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            @foreach (['report_image_one', 'report_image_two', 'report_image_three', 'report_image_four', 'report_image_five'] as $key => $field)
                                                <div class="upload-container mb-3">
                                                    <!-- Upload label -->
                                                    <label for="{{ $field }}"
                                                        class="upload-label d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-upload me-2"></i> Upload Image {{ $key + 1 }}
                                                    </label>

                                                    <!-- File input -->
                                                    <input type="file" id="{{ $field }}" class="upload-input"
                                                        name="{{ $field }}" accept="image/*"
                                                        onchange="reportPreviewImages('{{ $field }}')">

                                                    <!-- Image preview section -->
                                                    <div id="{{ $field }}_preview" class="mt-2">
                                                        <!-- Image preview placeholder -->
                                                        <div class="position-relative"
                                                            style="width: 150px; height: 150px;">
                                                            <img id="{{ $field }}_img" class="img-thumbnail"
                                                                style="width: 100%; height: 100%; display:none;">
                                                            <span onclick="removeImage('{{ $field }}')"
                                                                class="remove-button position-absolute top-0 end-0 p-1 text-white bg-danger rounded-circle cursor-pointer"
                                                                style="display:none;">&times;</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>


                                    @if (isAdmin())
                                        <!-- Status Row -->
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="status" class="form-label">Status <span
                                                        style="color: red;">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="toggleStatus"
                                                        value="1" name="status" onchange="toggleStatusText('statusLabel', this)">
                                                    <label class="form-check-label" for="toggleStatus"
                                                        id="statusLabel">In-Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <!-- Buttons -->
                                    <div class="d-flex mt-2 pl-5">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <!-- <button type="button" style="margin-left: 10px;" class="btn btn-danger">Cancel</button> -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- insert the contents Here end -->
        </div>
        <!-- page inner end-->
    </div>
    <script>
        function previewImages() {
            const imagePreview = document.getElementById("imagePreviews");
            const files = document.getElementById("imageUploads").files;

            // Loop through all selected files
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Create a wrapper div for image and close button
                    const previewWrapper = document.createElement("div");
                    previewWrapper.classList.add("position-relative", "m-2");
                    previewWrapper.style.width = "150px";
                    previewWrapper.style.height = "150px";

                    // Create the image element
                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.classList.add("img-thumbnail");
                    img.style.width = "100%";
                    img.style.height = "100%";

                    // Create the close button
                    const closeButton = document.createElement("span");
                    closeButton.innerHTML = "&times;";
                    closeButton.classList.add("remove-button");

                    // Add event listener to remove the image on clicking the close button
                    closeButton.onclick = function() {
                        imagePreview.removeChild(previewWrapper);
                    };

                    // Append the image and close button to the wrapper div
                    previewWrapper.appendChild(img);
                    previewWrapper.appendChild(closeButton);

                    // Append the wrapper div to the image preview container
                    imagePreview.appendChild(previewWrapper);
                };

                reader.readAsDataURL(file);
            }
        }

        // This function will handle the image preview and display it when a user selects an image
        function reportPreviewImages(field) {
            const fileInput = document.getElementById(field); // Get the file input element
            const previewContainer = document.getElementById(field + "_preview"); // Get the preview container
            const imgElement = document.getElementById(field + "_img"); // Get the img element for preview
            const removeButton = previewContainer.querySelector('.remove-button'); // Get the remove button

            // Clear any previous preview
            imgElement.style.display = "none";
            removeButton.style.display = "none";

            // Check if the user has selected a file
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                // Once the file is read, update the preview
                reader.onload = function(e) {
                    imgElement.src = e.target.result; // Set the image source to the file content
                    imgElement.style.display = "block"; // Display the image
                    removeButton.style.display = "block"; // Show the remove button
                };

                reader.readAsDataURL(fileInput.files[0]); // Read the file as a data URL
            }
        }

        // This function will remove the image preview and reset the file input
        function removeImage(field) {
            const fileInput = document.getElementById(field); // Get the file input element
            const previewContainer = document.getElementById(field + "_preview"); // Get the preview container
            const imgElement = document.getElementById(field + "_img"); // Get the img element for preview
            const removeButton = previewContainer.querySelector('.remove-button'); // Get the remove button

            // Reset the file input and hide the preview
            fileInput.value = "";
            imgElement.style.display = "none"; // Hide the image
            removeButton.style.display = "none"; // Hide the remove button
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

        document.querySelector('form').addEventListener('submit', function (e) {
            const description = tinymce.get('description').getContent();
            
            if (!description.trim()) { // Check if the content is empty
                e.preventDefault(); // Prevent form submission
                alert("Description is required!");
            }
        });
      </script>
      <script>
const programSelect = document.getElementById('programs_id');
const schemeSelect = document.getElementById('scheme_id');

programSelect.addEventListener('change', () => {
    const programId = programSelect.value;
    schemeSelect.innerHTML = '<option value="">-- Select Scheme --</option>';

    if (!programId) return;

    fetch('{{ route('list-scheme') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ program_id: programId }),
    })
    .then(res => res.json())
    .then(data => {
        data.data.forEach(scheme => {
            const option = document.createElement('option');
            option.value = scheme.id;
            option.textContent = scheme.name;
            schemeSelect.appendChild(option);
        });
    })
    .catch(console.error);
});
</script>


@endsection
