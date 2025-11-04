@extends('admin.layouts.layout')
@section('title', 'Create Programs Details')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
    /* Inline Select2 styling */


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
                <h5 class="mb-0">program and Division Details</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">programmsAnddivisions Create</li>
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

                            <!-- new form start =================================================== -->

                            <form id="programForm" class="mb-3" action="{{ route('programdetails.store') }}"
                                enctype="multipart/form-data" method="post">
                                {{ csrf_field() }}
                                <div class="container">
                                    <h4 class="card-title mb-4 text-primary">Create Program and Divisions</h4>

                                    <!-- Program & division Dropdown Row -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="mainmenu" class="form-label">Program Title<span
                                                    style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <select name="program_id" id="program_id" class="form-control">
                                                <option value="">-- Select Program -- </option>
                                                @foreach ($programs as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ SELECT($value->id, old('program_id')) }}>
                                                        {{ $value->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <!-- Official Details Start -->
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="card-title text-primary my-3">Upload Officers</h5>
                                            </div>
                                        </div>

                                        <div class="row mt-3 mb-5" id="officialButtons">
                                            <div class="col-12 col-sm-6 col-md-2 mb-2">
                                                <button id="addOfficial1" class="btn btn-primary w-100"
                                                    onclick="showOfficialForm(1)">Add Officer 1</button>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-2 mb-2">
                                                <button id="addOfficial2" class="btn btn-primary w-100"
                                                    onclick="showOfficialForm(2)">Add Officer 2</button>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-2 mb-2">
                                                <button id="addOfficial3" class="btn btn-primary w-100"
                                                    onclick="showOfficialForm(3)">Add Officer 3</button>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-2 mb-2">
                                                <button id="addOfficial4" class="btn btn-primary w-100"
                                                    onclick="showOfficialForm(4)">Add Officer 4</button>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-2 mb-2">
                                                <button id="addOfficial5" class="btn btn-primary w-100"
                                                    onclick="showOfficialForm(5)">Add Officer 5</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="officialsContainer">
                                        <!-- Officials will be added dynamically here -->
                                    </div>
                                    <!-- Official Details End -->

                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                          <label for="description" class="form-label">Description <span style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                          <div class="editor-container">
                                            <textarea class="textarea_editor form-control" id="description" rows="4" placeholder="Enter description" name="description"></textarea>
                                          </div>
                                        </div>
                                      </div>

                                    <!-- Multi-select Images -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="imageUploads" class="form-label">Select Image<span
                                                    style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <input type="file" id="imageUploads" class="form-control" accept="image/*"
                                                multiple onchange="previewImages()" name="images[]">
                                            <small class="sizeoftextred">Upload Max 5 Images, Accepted file types
                                                .jpg/.jpeg/.png/.Doc</small>
                                        </div>
                                    </div>

                                    <!-- Image Previews for Program -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-8 offset-md-3">
                                            <div id="imagePreviews" class="d-flex flex-wrap"></div>
                                        </div>
                                    </div>

                                    <!-- Document Upload -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="document" class="form-label">Upload Document</label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <input type="file" class="form-control" id="document"
                                                accept=".pdf,.doc,.docx" name="document">
                                            <small class="sizeoftextred">Accepted file types .pdf</small>
                                        </div>
                                    </div>

                                    {{-- upload icon --}}
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="icon" class="form-label">Upload Icon</label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <input type="file" class="form-control" id="document" accept=".png"
                                                name="icon">
                                            <small class="sizeoftextred">Accepted file types .png</small>
                                        </div>
                                    </div>
                                    
    <!-- Tags Dropdown -->
<!-- Tags Dropdown -->
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

                      @if (isAdmin())
                                        <!-- Program Status Row -->
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label class="form-label">Program Detail Status</label>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="toggleStatus"
                                                        value="1" name="status"
                                                        onchange="toggleStatusText('PDStatusLabel', this)">
                                                    <label class="form-check-label" for="toggleStatus"
                                                        id="PDStatusLabel">In-Active</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Visible to Public Toggle -->
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="visibleToPublic" class="form-label">Visible to
                                                    Public</label>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="toggleStatus"
                                                        name="visible_to_public" value="1"
                                                        onchange="toggleStatusText('visibleToPublicLabel', this)">
                                                    <label class="form-check-label" for="toggleStatus"
                                                        id="visibleToPublicLabel">In-Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <!-- Submit Button -->
                                    <div class="d-flex mt-4">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="button" class="btn btn-danger" onclick="history.back()" style="margin-left: 10px;">
                                            Cancel
                                        </button>

                                    </div>
                                </div>
                            </form>


                            <!-- new form end =================================================== -->

                        </div>
                    </div>
                </div>
            </div>

            <!-- insert the contents Here end -->
        </div>
        <!-- page inner end-->
    </div>
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
        let addedOfficials = new Set(); // Track added officials

        function showOfficialForm(officialNumber) {
            // Check if the official form is already added
            if (addedOfficials.has(officialNumber)) {
                alert(`Official ${officialNumber} is already added!`);
                return;
            }

            // Add the official to the set
            addedOfficials.add(officialNumber);

            // Create the new official form section
            const officialSection = document.createElement('div');
            officialSection.classList.add('official-container', 'mb-4', 'border', 'p-3', 'position-relative');
            officialSection.id = `official_${officialNumber}`;

            // Add close button
            const closeButton = document.createElement('button');
            closeButton.classList.add('btn-close', 'position-absolute', 'top-0', 'end-0');
            closeButton.onclick = function() {
                closeOfficialForm(officialNumber);
            };

            officialSection.innerHTML = `
            <h4>Officer #${officialNumber}</h4>
            <div class="row mb-3">
                <input type="hidden" name="officers[${officialNumber}][officer_order]" class="form-control" id="officialOrder_${officialNumber}" value="${officialNumber}">
                <div class="col-12 col-md-3">
                    <label for="officialName_${officialNumber}" class="form-label">Name</label>
                </div>
                <div class="col-12 col-md-8">
                    <input type="text" name="officers[${officialNumber}][officer_name]" class="form-control" id="officialName_${officialNumber}" placeholder="Enter official name">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-3">
                    <label for="qualification_${officialNumber}" class="form-label">Qualification</label>
                </div>
                <div class="col-12 col-md-8">
                    <input type="text" class="form-control" name="officers[${officialNumber}][officer_qualification]" id="qualification_${officialNumber}" placeholder="Enter qualification">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-3">
                    <label for="designation_${officialNumber}" class="form-label">Designation</label>
                </div>
                <div class="col-12 col-md-8">
                    <select name="officers[${officialNumber}][officer_designation]" id="designation_${officialNumber}" class="form-control">
                        <option value="0" >-- None -- </option>
                        @foreach ($designations as $key => $designation)
                        <option value="{{ $designation->id }}" {{ SELECT($designation, old('status')) }}>{{ $designation->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-3">
                    <label for="level_${officialNumber}" class="form-label">Level</label>
                </div>
                <div class="col-12 col-md-8">
                    <select name="officers[${officialNumber}][officer_level]" id="level_${officialNumber}" class="form-control">
                        <option value="1">Level 1</option>
                        <option value="2">Level 2</option>
                        <option value="3">Level 3</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-3">
                    <label for="image_${officialNumber}" class="form-label">Upload Image</label>
                </div>
                <div class="col-12 col-md-8">
                    <input type="file" class="form-control"name="officers[${officialNumber}][officer_image]" id="image_${officialNumber}" accept="image/*" onchange="previewOfficialImage(${officialNumber})">
                    <img id="imagePreview_${officialNumber}" style="max-width: 150px; display: none; margin-top: 10px;" />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-3">
                    <label class="form-label">Status</label>
                </div>
                <div class="col-12 col-md-5">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="officers[${officialNumber}][officer_status]" id="status_${officialNumber}" value="1" onchange="toggleStatusText('statusLabel_${officialNumber}', this)">
                        <label class="form-check-label" id="statusLabel_${officialNumber}">In-Active</label>
                    </div>
                </div>
            </div>
        `;

            // Append the close button and the official form to the container
            officialSection.appendChild(closeButton);
            document.getElementById('officialsContainer').appendChild(officialSection);

            // Disable the button for the added official
            document.getElementById(`addOfficial${officialNumber}`).disabled = true;
        }

        function closeOfficialForm(officialNumber) {
            const officialSection = document.getElementById(`official_${officialNumber}`);
            if (officialSection) {
                officialSection.remove(); // Remove the section
                addedOfficials.delete(officialNumber); // Remove from the set
                document.getElementById(`addOfficial${officialNumber}`).disabled = false; // Re-enable the button
            }
        }

        // Preview Official Image function
        function previewOfficialImage(id) {
            const fileInput = document.getElementById(`image_${id}`);
            const imagePreview = document.getElementById(`imagePreview_${id}`);

            const file = fileInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
    <script>
        function previewImages() {
            const imagePreview = document.getElementById("imagePreviews");
            const files = document.getElementById("imageUploads").files;

            // Get the current number of previewed images
            const currentImageCount = imagePreview.childElementCount;

            // Check if the total number of images (current + new) exceeds 5
            if (currentImageCount + files.length > 5) {
                alert("You can upload a maximum of 5 images.");
                return; // Prevent further execution if limit exceeded
            }

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
    </script>
    
@endsection
