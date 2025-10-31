@extends('admin.layouts.layout')
@section('title', 'List Director Message')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Edit Welcome Banner</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Welcome Banner</li>
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
                <div>

                    <!-- insert the contents Here start -->

                    <div class="container mt-2">
                        <div class="row">
                            <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                                <form id="myForm" action="{{ route('welcome-banner.update', $result->id) }}"
                                    enctype="multipart/form-data" method="post">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <div class="container">
                                        <h4 class="card-title mb-4 text-primary">Edit Welcome Banner</h4>

                                        <!-- Name Row -->
                                        <div class="row mb-3">
                                            <!-- Label Column with reduced width -->
                                            <div class="col-12 col-md-3">
                                                <label for="name" class="form-label">Name <span
                                                        class="sizeoftextred">*</span></label>
                                            </div>
                                            <!-- Input Column -->
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control" id="name" name="name"
                                                    placeholder="Enter name" value="{{ old('name', $result->name) }}" required>
                                            </div>
                                        </div>

                                        <!-- Link Row -->
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="link" class="form-label">Link <span
                                                        class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="url" class="form-control" id="link"
                                                    placeholder="Enter link URL" required name="link"
                                                    value="{{ old('link', $result->link) }}">
                                            </div>
                                        </div>

                                        <!-- Logo Row -->
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="logo" class="form-label">Image <span
                                                        class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="file" class="form-control" id="logo" accept="image/*"
                                                    value="{{ old('image_url', $result->image_url) }}"
                                                    name="welcome_image">
                                                <small class="sizeoftextred">Accepted .jpg/.jpeg/.png format & allowed max
                                                    size is 5MB</small>
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <img id="imagePreview" alt="Image Preview" class="img-fluid"
                                                    src="{{ fileLink($result->image_url) }}"
                                                    style="max-width: 100px; display: {{ fileLink($result->image_url) ? 'block' : 'none' }}; border: 1px solid #ccc; border-radius: 10px; padding: 5px; cursor: pointer;">
                                            </div>
                                        </div>

                                        <!-- Status Row -->
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="status" class="form-label">Status <span
                                                        class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="status"
                                                        id="toggleProfileDocument" value="1"
                                                        {{ CHECKBOX('status', $result->status) }}
                                                        onchange="toggleStatusText('statusLabel', this)">
                                                    <label class="form-check-label" for="toggleProfileDocument"
                                                        id="statusLabel">{{ $result->status == 1 ? 'Active' : 'In-Active' }}</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Buttons -->
                                    <div class="d-flex mt-2 pl-5">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="button" style="margin-left: 10px;"
                                        onclick="window.location.href='{{url('/partner')}}';"
                                            class="btn btn-danger">Cancel</button>
                                    </div>
                                </form>



                                <!-- Image Modal -->
                                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img id="modalImage" src="#" alt="Image Preview"
                                                    class="img-fluid" style="max-width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Image Modal End -->

                                <!-- Confirmation Modal -->
                                <div class="modal fade" id="confirmationModal" tabindex="-1"
                                    aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header justify-content-center position-relative">
                                                <h5 class="modal-title" id="confirmationModalLabel">Confirm Submission
                                                </h5>
                                                <button type="button" class="btn-close position-absolute end-0 me-3"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <div class="confirmation-icon mb-4">
                                                    <i class="fas fa-check-circle fa-4x text-success"></i>
                                                </div>
                                                <p class="mb-4">Are you sure you want to submit the form?</p>
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-success"
                                                    onclick="submitForm()">Yes, Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Confirmation Modal End -->
                            </div>
                        </div>
                    </div>


                    <!-- insert the contents Here end -->
                </div>
                <!-- page inner end-->
            </div>
            <!-- database table end -->
        </div>

        <!-- content end here -->


        <!-- main panel end -->
    </div>
    <script>
        // Function to show image modal
        function showImageModal(imagePreviewId) {
            var image = document.getElementById(imagePreviewId);
            var modalImage = document.getElementById('modalImage');

            modalImage.src = image.src;

            var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        }
    </script>
@endsection
