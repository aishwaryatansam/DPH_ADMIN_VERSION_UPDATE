@extends('admin.layouts.layout')
@section('title', 'Edit Program Details')
@section('content')
    <div class="container" id="maincontent">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Edit programmsAnddivisions</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">programmsAnddivisions Edit</li>
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

                            <form id="programForm" class="mb-3" onsubmit="handleSubmit(event)"
                                action="{{ route('programdetails.update', $result->id) }}" enctype="multipart/form-data"
                                method="post">
                                {{ csrf_field() }}
                                @method('PUT')
                                <div class="container">
                                    <h4 class="card-title mb-4 text-primary">Edit Program and Divisions</h4>

                                    <!-- Program & division Dropdown Row -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="mainmenu" class="form-label">Program Title<span
                                                    style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <select name="program_id" id="programs_id" class="form-control">
                                                <option value="{{ $result->programs_id }}"
                                                    {{ SELECT($result->programs_id, old('programs_id', $result->programs_id)) }}>
                                                    {{ $result->program->name ?? 'N/A' }}</option>
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
                                            @foreach (range(1, 5) as $index)
                                                <div class="col-12 col-sm-6 col-md-2 mb-2">
                                                    <button id="addOfficial{{ $index }}"
                                                        class="btn btn-primary w-100"
                                                        onclick="showOfficialForm({{ $index }})"
                                                        @if (isset($officers[$index - 1])) disabled @endif>
                                                        @if (isset($officers[$index - 1]))
                                                            Edit Officer {{ $index }}
                                                        @else
                                                            Add Officer {{ $index }}
                                                        @endif
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div id="officialsContainer">
                                        @foreach ($officers as $index => $officer)
                                            <div class="official-container mb-4 border p-3 position-relative"
                                                id="official_{{ $index + 1 }}">
                                                <button class="btn-close position-absolute top-0 end-0"
                                                    onclick="closeOfficialForm({{ $index + 1 }})"></button>
                                                <h4>Officer #{{ $index + 1 }}</h4>
                                                <div class="row mb-3">
                                                    <input type="hidden" name="officers[{{ $index + 1 }}][officer_id]"
                                                        class="form-control" id="officialOrder_{{ $index + 1 }}"
                                                        value="{{ $officer->id }}">
                                                    <input type="hidden"
                                                        name="officers[{{ $index + 1 }}][officer_order]"
                                                        class="form-control" id="officialOrder_{{ $index + 1 }}"
                                                        value="{{ $officer->order_no }}">
                                                    <div class="col-12 col-md-3">
                                                        <label for="officialName_{{ $index + 1 }}"
                                                            class="form-label">Name</label>
                                                    </div>
                                                    <div class="col-12 col-md-8">
                                                        <input type="text"
                                                            name="officers[{{ $index + 1 }}][officer_name]"
                                                            class="form-control" id="officialName_{{ $index + 1 }}"
                                                            value="{{ $officer->name }}" placeholder="Enter official name"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-12 col-md-3">
                                                        <label for="qualification_{{ $index + 1 }}"
                                                            class="form-label">Qualification</label>
                                                    </div>
                                                    <div class="col-12 col-md-8">
                                                        <input type="text" class="form-control"
                                                            name="officers[{{ $index + 1 }}][officer_qualification]"
                                                            id="qualification_{{ $index + 1 }}"
                                                            value="{{ $officer->qualification }}"
                                                            placeholder="Enter qualification" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-12 col-md-3">
                                                        <label for="designation_{{ $index + 1 }}"
                                                            class="form-label">Designation</label>
                                                    </div>
                                                    <div class="col-12 col-md-8">
                                                        <select name="officers[{{ $index + 1 }}][officer_designation]"
                                                            id="designation_{{ $index + 1 }}" class="form-control">
                                                            <option value="0">-- None --</option>
                                                            @foreach ($designations as $key => $designation)
                                                                <option value="{{ $designation->id }}"
                                                                    {{ $designation->id == $officer->designations_id ? 'selected' : '' }}>
                                                                    {{ $designation->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-12 col-md-3">
                                                        <label for="level_${officialNumber}" class="form-label">Level</label>
                                                    </div>
                                                    <div class="col-12 col-md-8">
                                                        <select name="officers[{{ $index + 1 }}][officer_level]" id="level_{{ $index + 1 }}" class="form-control">
                                                            <option value="1">Level 1</option>
                                                            <option value="2">Level 2</option>
                                                            <option value="3">Level 3</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-12 col-md-3">
                                                        <label for="image_{{ $index + 1 }}" class="form-label">Upload
                                                            Image</label>
                                                    </div>
                                                    <div class="col-12 col-md-8">
                                                        <input type="file" class="form-control"
                                                            name="officers[{{ $index + 1 }}][officer_image]"
                                                            id="image_{{ $index + 1 }}" accept="image/*"
                                                            onchange="previewOfficialImage({{ $index + 1 }})">
                                                        <img id="imagePreview_{{ $index + 1 }}"
                                                            src="{{ fileLink($officer->image) }}"
                                                            style="max-width: 150px; display: {{ $officer->image ? 'block' : 'none' }}; margin-top: 10px;" />
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label">Status</label>
                                                    </div>
                                                    <div class="col-12 col-md-5">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="officers[{{ $index + 1 }}][officer_status]"
                                                                id="status_{{ $index + 1 }}" value="1"
                                                                {{ $officer->status === 1 ? 'checked' : '' }}
                                                                onchange="toggleStatusText('statusLabel_{{ $index + 1 }}', this)">
                                                            <label class="form-check-label"
                                                                id="statusLabel_{{ $index + 1 }}">{{ $officer->status === 1 ? 'Active' : 'In-Active' }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Official Details End -->

                                    <!-- Program Description -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="description" class="form-label">Description <span
                                                    style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <textarea class="form-control" id="description" rows="4" placeholder="Enter description" name="description"
                                                required>{{ $result->description }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Multi-select Images -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="imageUploads" class="form-label">Select Images <span
                                                    style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <input type="file" id="imageUploads" class="form-control"
                                                accept="image/*" multiple onchange="previewImages()" name="images[]">
                                            <small class="sizeoftextred">Upload Max 5 Images,Accepted file types
                                                .jpg/.jpeg/.png/.Doc</small>
                                        </div>
                                    </div>

                                    <!-- Image Previews for Program -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-8 offset-md-3">
                                            <div id="imagePreviews" class="d-flex flex-wrap"></div>
                                            @foreach (['image_one', 'image_two', 'image_three', 'image_four', 'image_five'] as $imageField)
                                                @if ($result->$imageField)
                                                    <div class="position-relative m-2"
                                                        style="width: 150px; height: 150px;">
                                                        <img src="{{ filelink($result->$imageField) }}"
                                                            class="img-thumbnail" style="width: 100%; height: 100%;">
                                                        <span
                                                            onclick="removeImage('{{ $imageField }}', '{{ $result->id }}')"
                                                            class="remove-button position-absolute top-0 end-0 p-1 text-white bg-danger rounded-circle cursor-pointer">&times;</span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Document Upload -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="document" class="form-label">Upload Document</label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="document"
                                                    name="document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                                @if ($result->document)
                                                    <a href="{{ filelink($result->document) }}" target="_blank"
                                                        class="btn btn-info">
                                                        View
                                                    </a>
                                                @endif
                                            </div>
                                            <small class="sizeoftextred">Accepted file types:
                                                .jpg/.jpeg/.png/.doc/.pdf/.docx</small>
                                        </div>
                                    </div>


                                    <!-- Icon Upload -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="icon" class="form-label">Upload Icon</label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="icon" name="icon"
                                                    accept=".png">
                                                @if ($result->icon_url)
                                                    <a href="{{ filelink($result->icon_url) }}" target="_blank"
                                                        class="btn btn-info">
                                                        View
                                                    </a>
                                                @endif
                                            </div>
                                            <small class="sizeoftextred">Accepted file types .png</small>
                                        </div>
                                    </div>


                                    <!-- Program Status Row -->
                                    @if (isAdmin())
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label class="form-label">Status</label>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="programStatus"
                                                        name="status" value="1"
                                                        {{ CHECKBOX('status', $result->status) }}
                                                        onchange="toggleStatusText('programStatusLabel', this)">
                                                    <label class="form-check-label" id="programStatusLabel"
                                                        for="programStatus">{{ $result->status == 1 ? 'Active' : 'In-Active' }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Visible to Public Toggle -->
                                    {{-- <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="visibleToPublic" class="form-label">Visible to
                                                Public</label>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="visibleToPublic"
                                                    onchange="toggleVisibilityText()">
                                                <label class="form-check-label" id="visibilityStatusLabel"
                                                    for="visibleToPublic">No</label>
                                            </div>
                                        </div>
                                    </div> --}}

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
        let addedOfficials = new Set(); // Track added officials

        function showOfficialForm(officialNumber, officerData = null) {
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

            // Create form inputs
            officialSection.innerHTML = `
                <h4>Officer #${officialNumber}</h4>
                <div class="row mb-3">
                    <input type="hidden" name="officers[${officialNumber}][officer_order]" class="form-control" id="officialOrder_${officialNumber}" value="${officialNumber}">
                    <div class="col-12 col-md-3">
                        <label for="officialName_${officialNumber}" class="form-label">Name</label>
                    </div>
                    <div class="col-12 col-md-8">
                        <input type="text" name="officers[${officialNumber}][officer_name]" class="form-control" id="officialName_${officialNumber}" placeholder="Enter official name" required ${officerData ? `value="${officerData.officer_name}"` : ''}>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="qualification_${officialNumber}" class="form-label">Qualification</label>
                    </div>
                    <div class="col-12 col-md-8">
                        <input type="text" class="form-control" name="officers[${officialNumber}][officer_qualification]" id="qualification_${officialNumber}" placeholder="Enter qualification" required ${officerData ? `value="${officerData.officer_qualification}"` : ''}>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label for="designation_${officialNumber}" class="form-label">Designation</label>
                    </div>
                    <div class="col-12 col-md-8">
                        <select name="officers[${officialNumber}][officer_designation]" id="designation_${officialNumber}" class="form-control">
                            <option value="0">-- None --</option>
                            @foreach ($designations as $key => $designation)
                                <option value="{{ $designation->id }}" ${officerData && officerData.officer_designation == '{{ $designation->id }}' ? 'selected' : ''}>{{ $designation->name }}</option>
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
                        <input type="file" class="form-control" name="officers[${officialNumber}][officer_image]" id="image_${officialNumber}" accept="image/*" onchange="previewOfficialImage(${officialNumber})">
                        <img id="imagePreview_${officialNumber}" style="max-width: 150px; display: none; margin-top: 10px;" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <label class="form-label">Status</label>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="officers[${officialNumber}][officer_status]" id="status_${officialNumber}" value="1" ${officerData && officerData.officer_status ? 'checked' : ''} onchange="toggleStatusText('statusLabel_${officialNumber}', this)">
                            <label class="form-check-label" id="statusLabel_${officialNumber}">${officerData && officerData.officer_status ? 'Active' : 'In-Active'}</label>
                        </div>
                    </div>
                </div>
            `;

            // Append the close button
            officialSection.prepend(closeButton);

            // Append the official section to the container
            document.getElementById('officialsContainer').appendChild(officialSection);

            // Show the image preview if there's an existing image
            if (officerData && officerData.officer_image) {
                document.getElementById(`imagePreview_${officialNumber}`).src = officerData.officer_image;
                document.getElementById(`imagePreview_${officialNumber}`).style.display = 'block';
            }
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

        function removeImage(imageField, programDetailsId) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/programdetails/${programDetailsId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                    },
                    body: JSON.stringify({
                        image_field: imageField
                    }) // Send image field to remove
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    // Check if there is a response body
                    return response.text();
                })
                .then(data => {
                    if (data) {
                        console.log('Response data:', data);
                    } else {
                        console.log('No response data received');
                    }
                    // Reload the page upon successful image removal
                    location.reload();
                })
                .catch(error => {
                    console.error('Error removing image:', error);
                    alert('An error occurred while removing the image. Please try again.');
                });
        }

        let selectedFiles = [];

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
                selectedFiles.push(file);

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
                        const fileIndex = selectedFiles.indexOf(file);
                        if (fileIndex > -1) {
                            selectedFiles.splice(fileIndex, 1);
                        }

                        // Optionally clear the input field if no files are selected
                        if (selectedFiles.length === 0) {
                            document.getElementById("imageUploads").value = '';
                        }
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
