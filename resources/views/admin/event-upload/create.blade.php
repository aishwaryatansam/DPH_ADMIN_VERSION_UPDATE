@extends('admin.layouts.layout')
@section('title', 'Upload Document')
@section('content')
    <style>
        #typeofdoc.readonly {
            pointer-events: none;
            background-color: #e9ecef;
        }

        .select2-container {
            width: 100% !important;
            /* Or set a fixed width, e.g., 300px */
        }

        .img-thumbs {
            background: #eee;
            border: 1px solid #ccc;
            border-radius: 0.25rem;
            margin: 1.5rem 0;
            padding: 0.75rem;
        }

        .img-thumbs-hidden {
            display: none;
        }

        .wrapper-thumb {
            position: relative;
            display: inline-block;
            margin: 1rem 0;
            justify-content: space-around;
        }

        .img-preview-thumb {
            background: #fff;
            border: 1px solid none;
            border-radius: 0.25rem;
            box-shadow: 0.125rem 0.125rem 0.0625rem rgba(0, 0, 0, 0.12);
            margin-right: 1rem;
            max-width: 140px;
            padding: 0.25rem;
        }

        .remove-btn {
            position: absolute;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: .7rem;
            top: -5px;
            right: 10px;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
        }

        .remove-btn:hover {
            box-shadow: 0px 0px 3px grey;
            transition: all .3s ease-in-out;
        }
    </style>
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Documents</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Documents</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Upload Events
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

                <div class="container mt-2">
                    <div class="row">
                        <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                            <form id="documentForm" form action="{{ route('event-upload.store') }}"
                                enctype="multipart/form-data" method="post" class="disable_submit">
                                {{ csrf_field() }}
                                <div class="table-responsive">
                                    <h4 class="card-title mb-4 text-primary">Upload Events Data
                                    </h4>
                                    <table class="table table-borderless">
                                        <tbody>


                                            <tr>
                                                <td class="col-12 col-md-3">
                                                    <label for="eventType" class="form-label">Select Events<span
                                                        style="color: red;">*</span</label>
                                                </td>
                                                <td class="col-12 col-md-9">
                                                    <div class="position-relative">
                                                        <div class="select-wrapper">
                                                            <select class="form-select select-dropdown" id="eventType"
                                                                name="event_id">
                                                                <option value=""> -- Select --</option>
                                                                @foreach ($events as $key => $value)
                                                                    <option value="{{ $value }}"
                                                                        {{ SELECT($key, old('events')) }}>
                                                                        {{ $key }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <label for="createImage" class="form-label">Upload Images<span
                                                        style="color: red;">*</span</label>
                                                </td>
                                                <td>
                                                    <input type="file" name="images[]" multiple accept="image/*"
                                                    id="upload-img" class="form-control" id="createImage" required>
                                                    <small style="color: red;">Accepted .jpg .jpeg .png format &
                                                        allowed max size is
                                                        5MB</small>
                                                        <div class="img-thumbs img-thumbs-hidden" id="img-preview"></div>
                                                </td>
                                                <td>
                                                    <img id="imagePreview" src="#" alt="Image Preview"
                                                        class="img-fluid"
                                                        style="max-width: 100px; display: none; border: 1px solid #ccc; border-radius: 10px; padding: 5px; cursor: pointer;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="createDocument" class="form-label">Upload File</label>
                                                </td>
                                                <td>
                                                    <input type="file" name="document" class="form-control"
                                                        id="upload-document" placeholder="Enter document title">
                                                    <small style="color: red;">Accepted .pdf format &
                                                        allowed max size is
                                                        5MB</small>
                                                    
                                                </td>
                                            </tr>


                                            <tr>
                                                <td>
                                                    <label for="fileName" class="form-label">Video Url</label>
                                                </td>
                                                <td>
                                                    <input name="video" type="text" class="form-control" id="videoUrl"
                                                        placeholder="Enter Video Url">
                                                    <small style="color: red;">Please provide google drive link
                                                        only.</small>
                                                </td>
                                            </tr>





                                            @if (isAdmin())
                                            <!-- Status -->
                                            <tr>
                                                <td>
                                                    <label for="status" class="form-label">Status</label>
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="status" type="checkbox"
                                                            id="toggleStatus" value="1"
                                                            {{ CHECKBOX('document_status') }}
                                                            onchange="toggleStatusText('statusLabel', this)">
                                                        <label class="form-check-label" for="toggleStatus"
                                                            id="statusLabel">In-Active</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Buttons -->
                                <div class="d-flex mt-2">
                                    <button type="submit" id="submitBtn" class="btn btn-primary">Submit</button>
                                    <button type="button" style="margin-left: 10px;"
                                        class="btn btn-danger">Cancel</button>
                                </div>

                            </form>
                            <!-- popup for submitting confirmation start -->
                            <!-- Confirmation Modal -->
                            <div class="modal fade" id="confirmationModal" tabindex="-1"
                                aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header justify-content-center position-relative">
                                            <h5 class="modal-title" id="confirmationModalLabel">Confirm
                                                Submission</h5>
                                            <button type="button" class="btn-close position-absolute end-0 me-3"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <div class="confirmation-icon mb-4">
                                                <i class="fas fa-question-circle fa-4x text-danger"></i>
                                            </div>
                                            <p class="mb-4">Are you sure you want to submit the form?</p>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="button" class="btn btn-outline-danger"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-success" onclick="submitForm()">Yes,
                                                Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- popup for submitting confirmation end -->
                            <!-- insert the contents Here end -->
                        </div>
                    </div>
                </div>

            </div>
            <!-- page inner end-->
        </div>
        <!-- database table end -->
    </div>
    <script>
        var imgUpload = document.getElementById("upload-img"),
            imgPreview = document.getElementById("img-preview"),
            totalFiles,
            previewTitle,
            previewTitleText,
            img;

        imgUpload.addEventListener("change", previewImgs, true);
        console.log(imgUpload.files);
        function previewImgs(event) {
            totalFiles = imgUpload.files.length;

            if (!!totalFiles) {
                imgPreview.classList.remove("img-thumbs-hidden");
            }

            for (var i = 0; i < totalFiles; i++) {
                wrapper = document.createElement("div");
                wrapper.classList.add("wrapper-thumb");
                removeBtn = document.createElement("span");
                nodeRemove = document.createTextNode("x");
                removeBtn.classList.add("remove-btn");
                removeBtn.appendChild(nodeRemove);
                img = document.createElement("img");
                img.src = URL.createObjectURL(event.target.files[i]);
                img.classList.add("img-preview-thumb");
                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);
                imgPreview.appendChild(wrapper);

                $(".remove-btn").click(function() {
                    $(this).parent(".wrapper-thumb").remove();
                });
            }
        }
    </script>

    <script src="{{ asset('packa/custom/document.js') }}"></script>
@endsection
