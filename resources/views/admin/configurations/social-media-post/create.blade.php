@extends('admin.layouts.layout')
@section('title', 'List Director Message')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Create Social Media Post</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Social Media Post</li>
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
                                <form action="{{ route('social-media-post.store') }}" enctype="multipart/form-data"
                                    method="post" id="myForm">
                                    {{ csrf_field() }}
                                    <div class="container">
                                        <h4 class="card-title mb-4 text-primary">Create Social Media Post</h4>

                                        <!-- Socail Media Type Row -->
                                        <div class="row mb-3">
                                            <!-- Label Column with reduced width -->
                                            <div class="col-12 col-md-3">
                                                <label for="name" class="form-label">Social Media Type <span
                                                        class="sizeoftextred">*</span></label>
                                            </div>
                                            <!-- Input Column -->
                                            <div class="col-12 col-md-7">
                                                <select class="form-control" id="platform" name="name">
                                                    <option value="" disabled selected>Select a Social Media Type
                                                    </option>
                                                    @foreach (getSocialMediaType() as $key => $type)
                                                        <option value="{{ $key }}"
                                                            data-value="{{ $type }}">
                                                            {{ $type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Menu to Show Row -->
                                        <div class="row mb-3">
                                            <!-- Label Column with reduced width -->
                                            <div class="col-12 col-md-3">
                                                <label for="name" class="form-label">Menu to show<span
                                                        class="sizeoftextred">*</span></label>
                                            </div>
                                            <!-- Input Column -->
                                            <div class="col-12 col-md-7">
                                                <select class="form-control" id="platform" name="menu_to_show">
                                                    <option value="" disabled selected>Select a Menu</option>
                                                    @foreach (getMenuToShow() as $key => $type)
                                                        <option value="{{ $key }}"
                                                            data-value="{{ $type }}">
                                                            {{ $type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Link Row -->
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="link" class="form-label">Link <span
                                                        class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control" id="link"
                                                    placeholder="Enter link URL" name="link">
                                            </div>
                                        </div>

                                        <!-- Logo and Preview Row -->
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="profileImage" class="form-label">Social Media Post Image<span
                                                        class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="file" class="form-control" id="profileImage"
                                                    accept="image/*" name="social_media_post_image">
                                                <small class="sizeoftextred">Accepted .jpg/.jpeg/.png format & allowed max
                                                    size is
                                                    5MB</small>
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <img id="imagePreview" src="#" alt="Image Preview" class="img-fluid"
                                                    style="max-width: 100px; display: none; border: 1px solid #ccc; border-radius: 10px; padding: 5px; cursor: pointer;">
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
                                                    <input class="form-check-input" name="status" type="checkbox"
                                                        id="toggleStatus" value="1" {{ CHECKBOX('document_status') }}
                                                        onchange="toggleStatusText('statusLabel', this)">
                                                    <label class="form-check-label" for="toggleStatus"
                                                        id="statusLabel">In-Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="d-flex mt-2 pl-5">
                                        <button type="submit" class="btn btn-primary"
                                            onclick="validateForm()">Submit</button>
                                            <button type="button" class="btn btn-danger" onclick="history.back()" style="margin-left: 10px;">
                                                Cancel
                                            </button>

                                    </div>
                                </form>



                                <!-- Image Modal -->
                                <div class="modal fade" id="imageModal1" tabindex="-1"
                                    aria-labelledby="imageModalLabel1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imageModalLabel1">Image Preview</h5>
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
        document.getElementById('profileImage').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = URL.createObjectURL(file);
                imagePreview.style.display = 'block';
            }
        });
    </script>
@endsection
