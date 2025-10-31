@extends('admin.layouts.layout')
@section('title', 'List Rti Officers')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Edit Rti Officer</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit RTI Officer</li>
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
                                <form id="myForm" action="{{ route('rti-officer.update', $result->id) }}" enctype="multipart/form-data"
                                    method="post">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <div class="container">
                                        <h4 class="card-title mb-4 text-primary">Edit RTI Officer</h4>

                                        <!-- Name Row -->
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="name" class="form-label">Title<span
                                                        class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control" id="title"
                                                    placeholder="Enter name" name="title"
                                                    value="{{ old('name', $result->title) }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="name" class="form-label">Name <span
                                                        class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control" id="name"
                                                    placeholder="Enter name" name="name"
                                                    value="{{ old('name', $result->name) }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="name" class="form-label">E-Mail ID <span
                                                        class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control" id="name"
                                                    placeholder="Enter name" name="email"
                                                    value="{{ old('name', $result->email) }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="name" class="form-label">Mobile Number<span
                                                        class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control" id="name"
                                                    placeholder="Enter name" name="mobile_number"
                                                    value="{{ old('name', $result->mobile_number) }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="name" class="form-label">Landline Number<span
                                                        class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control" id="name"
                                                    placeholder="Enter name" name="landline_number"
                                                    value="{{ old('name', $result->landline_number) }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="name" class="form-label">Extn<span
                                                        class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control" id="extn"
                                                    placeholder="Enter name" name="extn"
                                                    value="{{ old('name', $result->extn) }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="name" class="form-label">Fax<span
                                                        class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control" id="name"
                                                    placeholder="Enter name" name="fax"
                                                    value="{{ old('name', $result->fax) }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="name" class="form-label">Address<span
                                                        class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control" id="name"
                                                    placeholder="Enter name" name="address"
                                                    value="{{ old('name', $result->address) }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="name" class="form-label">Designation<span
                                                        class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                    <select name="designations_id" id="designation_id" class="form-control">
                                                        <option value="">-- Select Designation -- </option>
                                                        @foreach ($designations as $key => $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ SELECT($value->id, $result->designations_id) }}>
                                                                {{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
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
                                                    <input class="form-check-input " name="status" type="checkbox"
                                                    id="toggleStatus" value="1"
                                                    {{ CHECKBOX('status', $result->status) }}
                                                    onchange="toggleStatusText('statusLabel', this)">
                                                <label class="form-check-label" for="toggleStatus"
                                                    id="statusLabel">{{ $result->status == 1 ? 'Active' : 'In-Active' }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="d-flex mt-2 pl-5">
                                        <button type="submit" class="btn btn-primary"
                                            onclick="validateForm()">Submit</button>
                                        <button type="button" style="margin-left: 10px;" onclick="history.back()"
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
                            </div>
                        </div>
                    </div>

                    <!-- Image Modal -->
                    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img id="modalImage" src="#" alt="Image Preview" class="img-fluid">
                                </div>
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
