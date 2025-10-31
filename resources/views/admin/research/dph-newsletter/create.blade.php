@extends('admin.layouts.layout')
@section('title', 'Create Programs Details')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Documents</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create NewsLetter</li>
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
                <div class="container-fluid mt-2">
                    <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                        <form id="newsletterForm" action="{{route('dph-newsletter.store')}}" enctype="multipart/form-data" method="post">
                            {{csrf_field()}}
                            <h4 class="card-title mb-4 text-primary">Create Newsletter</h4>

                            <!-- All Fields in One Div using d-grid -->
                            <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                <!-- Title -->
                                <div>
                                    <label for="newsletterTitle" class="form-label">Title <span
                                            style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="newsletterTitle"
                                        placeholder="Enter Title" name="name">
                                </div>

                                <!-- File Upload -->
                                <div>
                                    <label for="newsletterFile" class="form-label">Newsletter PDF Upload</label>
                                    <input type="file" class="form-control" id="newsletterFile" accept=".pdf" name="document">
                                    <small style="color: red;">Accepted formats: .pdf, max size 5MB</small>
                                </div>

                                <!-- thumbnail Upload -->
                                <div>
                                    <label for="thumbnailImage" class="form-label">Upload Thumbnail Image</label>
                                    <input type="file" class="form-control" id="thumbnailImage"
                                        accept=".jpg, .jpeg, .png" name="image">
                                    <small style="color: red;">Accepted formats: .jpg, .jpeg, .png, max size 5MB</small>
                                </div>

                                <!-- Date -->
                                <div>
                                    <label for="publishDate" class="form-label">Publish Date <span
                                            style="color: red;">*</span></label>
                                    <input type="date" class="form-control" id="publishDate" name="date">
                                </div>

                                <!-- Volume -->
                                <div>
                                    <label for="volume" class="form-label">Volume <span
                                            style="color: red;">*</span></label>
                                    <input type="number" class="form-control" id="volume"
                                        placeholder="Enter Volume Number" name="volume">
                                </div>

                                <!-- Issues -->
                                <div>
                                    <label for="issues" class="form-label">Issues <span
                                            style="color: red;">*</span></label>
                                    <input type="number" class="form-control" id="issues"
                                        placeholder="Enter Issue Number" name="issue">
                                </div>

                                

                                <!-- Status -->
                                <div>
                                    <label for="status" class="form-label">Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="toggleStatus" value="1" name="status"
                                            onchange="toggleStatusText('statusLabel', this)">
                                        <label class="form-check-label" for="toggleStatus" id="statusLabel">Active</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="md-3">
                                <label for="newsletterDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="newsletterDescription" placeholder="Enter Description" name="description"></textarea>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex mt-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-danger" onclick="history.back()" style="margin-left: 10px;">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- database table end -->
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("newsletterForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent the form from submitting
        const requiredFields = [
            { id: "newsletterTitle", label: "Title" },
            { id: "newsletterDescription", label: "Description" },
            { id: "publishDate", label: "Publish Date" },
            { id: "volume", label: "Volume" },
            { id: "issues", label: "Issues" },
            { id: "newsletterFile", label: "newsletterFile"}
        ];

        let isValid = true;
        let missingFields = [];

        requiredFields.forEach((field) => {
            const input = document.getElementById(field.id);

            // Check if the field is empty
            if (!input.value.trim()) {
                isValid = false;
                missingFields.push(field.label);

                // Set border to red if field is invalid
                input.style.border = "2px solid red";
            } else {
                // Reset border if field is valid
                input.style.border = "";
            }
        });

        if (!isValid) {
            // Show an alert with the missing fields
            alert(`Please fill in the following fields: ${missingFields.join(", ")}`);
        } else {
            // Submit the form if all fields are valid
            form.submit();
        }
    });
});

    </script>

    <script>
        tinymce.init({
        selector: '#newsletterDescription', // Target the textarea by its ID
        height: 300, // Set the height of the editor
        menubar: false, // Disable the menubar (optional)
        plugins: 'lists link image table code help', // Add plugins as needed
        toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code | help', // Customize the toolbar
        });
    </script>

@endsection
