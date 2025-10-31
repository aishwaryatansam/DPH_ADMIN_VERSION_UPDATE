@extends('admin.layouts.layout')

@section('title', 'Edit Configuration')

@section('content')
    <style>
        .sizeoftextred {
            color: red;
        }
    </style>
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Header Configuration</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Configuration</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Header</li>
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

                <div class="container-fluid mt-2">
                    <div class="row justify-content-center">
                        <div class="col-lg-12"
                            style="background: linear-gradient(to right, #ffffff, #ffffff); border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">


                            <div class="container-fluid p-1 mt-3" style="background-color: #ffffff; border-radius: 10px;">
                                <h2 class="mb-4">Government Information</h2>

                                <div class="table-responsive">
                                    <!-- Form for Government Names and DPH Names -->
                                    <form id="governmentForm" action="{{ url('header/update/' . 2) }}"
                                        enctype="multipart/form-data" method="post">
                                        {{ csrf_field() }}
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20%;">Field</th>
                                                    <th style="width: 40%;">Input</th>
                                                    <th style="width: 10%;">Last Updated</th>
                                                    <th style="width: 10%;" id="editHeader">Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Government Name (Tamil) -->
                                                <tr>
                                                    <td><label for="govNameTamil"
                                                            class="form-label font-weight-bold">Government Name
                                                            (Tamil)</label></td>
                                                    <td><input type="text" class="form-control shadow-sm text-dark"
                                                            id="govNameTamil" placeholder="Enter government name in Tamil"
                                                            value="{{ old('tamilnadu_government_title_tamil', $result->tamilnadu_government_title_tamil) }}"
                                                            name="tamilnadu_government_title_tamil" disabled></td>
                                                    <td>{{ $result->getOriginal('updated_at') }}</td>
                                                    <td class="edit-column"><button class="btn btn-primary btn-sm"
                                                            type="button" onclick="toggleEdit(this)">Edit</button></td>
                                                </tr>

                                                <!-- Government Name (English) -->
                                                <tr>
                                                    <td><label for="govNameEnglish"
                                                            class="form-label font-weight-bold">Government Name
                                                            (English)</label></td>
                                                    <td><input type="text" class="form-control shadow-sm text-dark"
                                                            id="govNameEnglish"
                                                            placeholder="Enter government name in English"
                                                            name="tamilnadu_government_title_english"
                                                            value="{{ old('tamilnadu_government_title_english', $result->tamilnadu_government_title_english) }} "
                                                            disabled></td>
                                                    <td>{{ $result->getOriginal('updated_at') }}</td>
                                                    <td class="edit-column"><button class="btn btn-primary btn-sm"
                                                            type="button" onclick="toggleEdit(this)">Edit</button></td>
                                                </tr>

                                                <!-- DPH Name (Tamil) -->
                                                <tr>
                                                    <td><label for="dphNameTamil" class="form-label font-weight-bold">DPH
                                                            Name (Tamil)</label>
                                                    </td>
                                                    <td><input type="text" class="form-control shadow-sm text-dark"
                                                            id="dphNameTamil" placeholder="Enter DPH name in Tamil"
                                                            name="dph_full_form_tamil"
                                                            value="{{ old('dph_full_form_tamil', $result->dph_full_form_tamil) }}"
                                                            disabled></td>
                                                    <td>{{ $result->getOriginal('updated_at') }}</td>
                                                    <td class="edit-column"><button class="btn btn-primary btn-sm"
                                                            type="button" onclick="toggleEdit(this)">Edit</button></td>
                                                </tr>

                                                <!-- DPH Name (English) -->
                                                <tr>
                                                    <td><label for="dphNameEnglish" class="form-label font-weight-bold">DPH
                                                            Name
                                                            (English)</label></td>
                                                    <td><input type="text" class="form-control shadow-sm text-dark"
                                                            id="dphNameEnglish" placeholder="Enter DPH name in English"
                                                            value="{{ old('dph_full_form_english', $result->dph_full_form_english) }}"
                                                            name="dph_full_form_english" disabled></td>
                                                    <td>{{ $result->getOriginal('updated_at') }}</td>

                                                    <td class="edit-column"><button class="btn btn-primary btn-sm"
                                                            type="button" onclick="toggleEdit(this)">Edit</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- Button trigger modal -->
                                        <!-- <div class="d-flex justify-content-between align-items-center">
                                                      <button type="button" class="btn btn-primary mt-3 mb-5" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal">
                                                        submit
                                                      </button>

                                                      <h6 class="me-5 text-muted">Last Update : <small class="">2024-05-03, 12:39:11</small></h6>
                                                    </div> -->





                                    </form>
                                </div>
                            </div>
                            <hr>

                            <!-- logos start  -->

                            <div class="container-fluid p-1 mt-3">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h4 class="card-title">Logos In Header</h4>
                                            <!-- Add Logo Button -->
                                            <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                                data-bs-target="#addLogoModal">
                                                <i class="fa fa-plus"></i> Add Logo
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <!-- Table Layout -->
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 20%;">Logo Title</th>
                                                            <th style="width: 20%;">Input</th>
                                                            <th style="width: 20%;">Last Update</th>
                                                            <th style="width: 8%;">Status</th>
                                                            <th style="width: 10%;" class="text-center">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($header_logos as $header_logo)
                                                            <!-- logo 1 start -->
                                                            <tr>
                                                                <td>{{ $header_logo->name ?? '' }}</td>
                                                                <td>
                                                                    <img src="{{ fileLink($header_logo->image_url) }}"
                                                                        alt="Logo" style="max-width: 100px;">
                                                                </td>
                                                                <td>{{ $header_logo->getOriginal('updated_at') }}</td>
                                                                <td style="font-weight: bold;">
                                                                    @if (isset($header_logo->status) && $header_logo->status == 1)
                                                                        <span class="text-success">Active</span>
                                                                    @else
                                                                        <span class="text-danger">In-Active</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <!-- Actions with icons -->
                                                                    <div class="form-button-action">
                                                                        <button type="button"
                                                                            class="btn btn-link btn-primary text-center"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#editLogoModal"
                                                                            onclick="editLogo('{{ $header_logo->id }}', '{{ $header_logo->name }}', '{{ fileLink($header_logo->image_url) }}', '{{ $header_logo->status }}')">
                                                                            <i class="fa fa-edit"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <!-- logo 1 end -->
                                                        <!-- Repeat similar rows for logo 2, 3, 4, etc. -->
                                                    </tbody>
                                                </table>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Popup for Adding Logo -->
                            <div class="modal fade" id="addLogoModal" tabindex="-1" aria-labelledby="addLogoModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addLogoModalLabel">Add New Logo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="addLogoForm" action="{{ route('header.store') }}"
                                                enctype="multipart/form-data" method="post">
                                                {{ csrf_field() }}
                                                <!-- Logo Title Field -->
                                                <div class="mb-3">
                                                    <label for="logoTitle" class="form-label">Logo Title</label>
                                                    <input type="text" class="form-control" id="logoTitle"
                                                        name="name" placeholder="Enter logo title" required>
                                                </div>

                                                <!-- Select Image Field with Preview -->
                                                <div class="mb-3">
                                                    <label for="logoImage" class="form-label">Select Logo Image</label>
                                                    <input type="file" class="form-control" id="logoImage"
                                                        name="header_logo_image" accept="image/*" required
                                                        onchange="previewImage(event)">
                                                    <small class="form-text text-danger">Accepted formats: .png, max size:
                                                        5MB</small>
                                                </div>

                                                <!-- Image Preview -->
                                                <div class="mb-3 text-center">
                                                    <img id="logoPreview" src="" alt="Image Preview"
                                                        style="display:none; max-width: 100px; margin-top: 10px;" />
                                                </div>

                                                <!-- Status Toggle -->
                                                <div class="mb-3">
                                                    <label for="logoStatus" class="form-label">Status</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="status" type="checkbox"
                                                            id="toggleStatus" value="1"
                                                            {{ CHECKBOX('document_status') }}
                                                            onchange="toggleStatusText('statusLabel', this)">
                                                        <label class="form-check-label" for="toggleStatus"
                                                            id="statusLabel">In-Active</label>
                                                    </div>
                                                </div>

                                                <!-- Submit Button -->
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- logos end  -->


                            <!-- Edit Logo Modal -->
                            <div class="modal fade" id="editLogoModal" tabindex="-1"
                                aria-labelledby="editLogoModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editLogoModalLabel">Edit Logo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editLogoForm" action="{{ route('header.updatelogo') }}"
                                                enctype="multipart/form-data" method="post">
                                                {{ csrf_field() }}
                                                <!-- Logo Title -->
                                                <input type="hidden" id="logoId" name="id">
                                                <div class="mb-3">
                                                    <label for="editLogoName" class="form-label">Logo Title</label>
                                                    <input type="text" class="form-control" id="editLogoName"
                                                        placeholder="Enter logo title" name="name">
                                                </div>
                                                <!-- Current Logo Preview -->
                                                <div class="mb-3">
                                                    <label class="form-label">Current Logo</label>
                                                    <img id="editLogoImagePreview" alt="Current Logo"
                                                        style="max-width: 100px;" class="d-block mb-2">
                                                </div>
                                                <!-- New Logo Image Preview -->
                                                <div class="mb-3">
                                                    <label for="editLogoImage" class="form-label">New Logo Image</label>
                                                    <input type="file" class="form-control" id="editLogoImage"
                                                        onchange="previewNewImage()" name="header_logo_image">
                                                    <small class="text-muted">Select a new image to update.</small>
                                                    <img id="newLogoPreview" src="" alt="New Logo Preview"
                                                        style="max-width: 100px; display: none;" class="d-block mt-2">
                                                </div>
                                                <!-- Status Toggle -->
                                                <div class="mb-3">
                                                    <label for="editLogoStatus" class="form-label">Status</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="status" type="checkbox"
                                                            id="editLogoStatus" value="1"
                                                            {{ CHECKBOX('document_status') }}
                                                            onchange="toggleStatusText('editStatusLabel', this)">
                                                        <label class="form-check-label" for="toggleStatus"
                                                            id="editStatusLabel"></label>
                                                    </div>
                                                </div>
                                                <!-- Submit Button -->
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                <button class="btn btn-danger">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- banner image start=======================================================================================================-->
                            <div class="container-fluid p-1 mt-3">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h4 class="card-title">Banner Images</h4>
                                            <!-- Add Banner Button -->
                                            <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                                data-bs-target="#addBannerModal">
                                                <i class="fa fa-plus"></i> Add Banner
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <!-- Table Layout -->
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 20%;">Banner Title</th>
                                                            <th style="width: 20%;">Image</th>
                                                            <th style="width: 20%">Description</th>
                                                            <th style="width: 20%">Date</th>
                                                            <th style="width: 20%;">Last Update</th>
                                                            <th style="width: 8%;">Status</th>
                                                            <th style="width: 10%;" class="text-center">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($banners as $banner)
                                                            <!-- Banner 1 start -->
                                                            <tr>
                                                                <td>{{ $banner->name ?? '' }}</td>
                                                                <td>
                                                                    <img src="{{ fileLink($banner->image_url) }}"
                                                                        alt="Logo" style="max-width: 100px;">
                                                                </td>
                                                                <td>{{ $banner->description ?? '' }}</td>
                                                                <td>{{ $banner->date ?? '' }}</td>
                                                                <td>{{ $banner->getOriginal('updated_at') ?? '' }}</td>
                                                                <td style="font-weight: bold;">
                                                                    @if (isset($banner->status) && $banner->status == 1)
                                                                        <span class="text-success">Active</span>
                                                                    @else
                                                                        <span class="text-danger">In-Active</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <!-- Actions with icons -->
                                                                    <div class="form-button-action">
                                                                        <button type="button"
                                                                            class="btn btn-link btn-primary text-center"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#editBannerModal"
                                                                            onclick="editBanner('{{ $banner->id }}', '{{ $banner->name }}', '{{ fileLink($banner->image_url) }}', '{{ $banner->status }}')">
                                                                            <i class="fa fa-edit"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <!-- Banner 1 end -->
                                                            <!-- Repeat similar rows for additional banners -->
                                                    </tbody>
                                                    @endforeach
                                                </table>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- banner image end=====================================================================================================-->



                            <!-- modal for adding banner start -->
                            <!-- Modal Popup for Adding Banner -->
                            <div class="modal fade" id="addBannerModal" tabindex="-1"
                                aria-labelledby="addBannerModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addBannerModalLabel">Add New Banner</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="addBannerForm" action="{{ route('header.storebanner') }}"
                                                enctype="multipart/form-data" method="post">
                                                {{ csrf_field() }}

                                                <!-- Banner Title Field -->
                                                <div class="mb-3">
                                                    <label for="bannerTitle" class="form-label">Banner Title</label>
                                                    <input type="text" class="form-control" id="bannerTitle"
                                                        placeholder="Enter banner title" name="name">
                                                </div>

                                                <!-- Select Image Field with Preview -->
                                                <div class="mb-3">
                                                    <label for="bannerImage" class="form-label">Select Banner
                                                        Image</label>
                                                    <input type="file" class="form-control" id="bannerImage"
                                                        accept="image/*" name="header_banner_image"
                                                        onchange="previewBannerImage(event)">
                                                    <small class="form-text text-danger">Accepted formats: .jpg, .jpeg,
                                                        .png, max size:
                                                        5MB</small>
                                                </div>

                                                <!-- Image Preview -->
                                                <div class="mb-3 text-center">
                                                    <img id="bannerPreview" src="" alt="Image Preview"
                                                        style="display:none; max-width: 100px; margin-top: 10px;" />
                                                </div>

                                                <!-- Description -->
                                                <div class="mb-3">
                                                    <label for="bannerDescription" class="form-label">Description</label>
                                                    <textarea type="text" class="form-control textarea_editor" id="bannerDescription"
                                                        placeholder="Enter Description do not add image in this field" name="description" row="10"></textarea>
                                                </div>

                                                <!-- Date -->
                                                <div class="mb-3">
                                                    <label for="bannerDate" class="form-label">Date</label>
                                                    <input type="date" class="form-control" id="bannerDate"
                                                        placeholder="Enter Banner Image Date" name="date">
                                                </div>

                                                <!-- Status Toggle -->
                                                <div class="mb-3">
                                                    <label for="bannerStatus" class="form-label">Status</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="bannerStatus"
                                                            {{ CHECKBOX('document_status') }} value="1" name="status"
                                                            onchange="toggleStatusText('addBannerStatusLabel', this)">
                                                        <label class="form-check-label" for="bannerStatus"
                                                            id="addBannerStatusLabel">In-Active</label>
                                                    </div>
                                                </div>

                                                <!-- Submit Button -->
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal for adding banner end -->


                            <!-- model for edit banner start -->
                            <!-- Edit Banner Modal -->
                            <!-- Edit Banner Modal -->
                            <div class="modal fade" id="editBannerModal" tabindex="-1"
                                aria-labelledby="editBannerModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editBannerModalLabel">Edit Banner</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editBannerForm" action="{{ route('header.updatebanner') }}"
                                            enctype="multipart/form-data" method="post">

                                            {{ csrf_field() }}
                                            <input type="hidden" id="bannerId" name="id">
                                                <!-- Banner Title -->
                                                <div class="mb-3">
                                                    <label for="editBannerTitle" class="form-label">Banner Title</label>
                                                    <input type="text" class="form-control" id="editBannerTitle"
                                                        placeholder="Enter banner title" name="name">
                                                </div>

                                                <!-- Current Banner Preview -->
                                                <div class="mb-3">
                                                    <label class="form-label">Current Banner</label>
                                                    <img id="currentBannerPreview" src="" alt="Current Banner"
                                                        style="max-width: 100px;" class="d-block mb-2">
                                                </div>

                                                <!-- New Banner Image Preview -->
                                                <div class="mb-3">
                                                    <label for="editBannerImage" class="form-label">New Banner
                                                        Image</label>
                                                    <input type="file" class="form-control" id="editBannerImage"
                                                        onchange="previewNewBannerImage()" name="header_banner_image">
                                                    <small class="text-muted">Select a new image to update.</small>
                                                    <img id="newBannerPreview" src="" alt="New Banner Preview"
                                                        style="max-width: 100px; display: none;" class="d-block mt-2">
                                                </div>

                                                <!-- Description -->
                                                <div class="mb-3">
                                                    <label for="editBannerDescription" class="form-label">Description</label>
                                                    <textarea type="text" class="form-control textarea_editor" id="editBannerDescription"
                                                        placeholder="Enter Description do not add image in this field" name="description" row="20"></textarea>
                                                </div>

                                                <!-- Date -->
                                                <div class="mb-3">
                                                    <label for="editBannerDate" class="form-label">Date</label>Date
                                                    <input type="date" class="form-control" id="editBannerDate"
                                                        placeholder="Enter Banner Image Date (DD/MM/YYYY)" name="date">
                                                </div>

                                                <!-- Status Toggle -->
                                                <div class="mb-3">
                                                    <label for="editBannerStatus" class="form-label">Status</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="editBannerStatus" value="1" name="status"
                                                            onchange="toggleStatusText('bannerStatusLabel', this)">
                                                        <label class="form-check-label" for="editBannerStatus"
                                                            id="bannerStatusLabel"></label>
                                                    </div>
                                                </div>

                                                <!-- Submit Button -->
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- model for edit banner end -->



                            <!-- Dynamic Buttons start  -->

                            <div class="container-fluid p-1 mt-3">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h4 class="card-title">Buttons In Header</h4>
                                            <!-- Add Button List -->
                                            <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                                data-bs-target="#addButtonModal">
                                                <i class="fa fa-plus"></i> Add Buttons
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <!-- Table Layout -->
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 20%;">Title</th>
                                                            <th style="width: 20%;">Link</th>
                                                            <th style="width: 20%;">Last Update</th>
                                                            <th style="width: 20%">Colour status</th>
                                                            <th style="width: 8%;">Status</th>
                                                            <th style="width: 10%;" class="text-center">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($header_buttons as $header_button)
                                                            <tr>
                                                                <td>{{ $header_button->name ?? '' }}</td>
                                                                <td>
                                                                    <a href="{{ $header_button->link ?? '' }}">{{ $header_button->link ?? '' }}</a>
                                                                </td>
                                                                <td>{{ $header_button->getOriginal('updated_at') }}</td>
                                                                {{-- Color effect --}}
                                                                <td style="font-weight: bold;">
                                                                    @if (isset($header_button->coloreffect) && $header_button->coloreffect == 1)
                                                                        <span class="text-success">Active</span>
                                                                    @else
                                                                        <span class="text-danger">In-Active</span>
                                                                    @endif
                                                                </td>
                                                                <td style="font-weight: bold;">
                                                                    @if (isset($header_button->status) && $header_button->status == 1)
                                                                        <span class="text-success">Active</span>
                                                                    @else
                                                                        <span class="text-danger">In-Active</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <!-- Actions with icons -->
                                                                    <div class="form-button-action">
                                                                        <button type="button"
                                                                            class="btn btn-link btn-primary text-center"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#editButtonModal"
                                                                            onclick="editButton('{{ $header_button->id }}', '{{ $header_button->name }}', '{{ ($header_button->link) }}','{{ $header_button->status }}','{{ ($header_button->coloreffect) }}' )">
                                                                            <i class="fa fa-edit"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Popup for Adding Buttons -->
                            <div class="modal fade" id="addButtonModal" tabindex="-1" aria-labelledby="addButtonModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addButtonModalLabel">Add New Button</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="addButtonForm" action="{{ route('header.storeButton') }}"
                                                enctype="multipart/form-data" method="post">
                                                {{ csrf_field() }}
                                                <!-- Button Title Field -->
                                                <div class="mb-3">
                                                    <label for="buttonTitle" class="form-label">Title</label>
                                                    <input type="text" class="form-control" id="buttonTitle"
                                                        name="name" placeholder="Enter Button title" required>
                                                </div>

                                                <!-- Link -->
                                                <div class="mb-3">
                                                    <label for="buttonLink" class="form-label">Link</label>
                                                    <input type="text" class="form-control" id="buttonLink"  pattern="https?://.*"
                                                        name="link" title="Please enter a valid URL starting with http:// or https://" required>
                                                </div>
                                                <!-- Color Selection Toggle (Only one option now) -->
                                                <div class=" mb-3">
                                                    <label for="toggleColor1" class="form-label">Colour Effect</label>
                                                        <!-- Single Color Toggle -->
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="coloreffect" type="checkbox"
                                                                id="toggleColor1"
                                                                {{ CHECKBOX('color_status') }}  value="1"
                                                                onchange="toggleColor1Text('statusLabel', this)">
                                                            <label class="form-check-label" for="toggleColor1">Color</label>
                                                        </div>
                                                </div>

                                                <!-- Status Toggle -->
                                                <div class="mb-3">
                                                    <label for="buttonStatus" class="form-label">Status</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="status" type="checkbox"
                                                            id="toggleStatus" value="1"
                                                            {{ CHECKBOX('document_status') }}
                                                            onchange="toggleStatusText('statusLabel', this)">
                                                        <label class="form-check-label" for="toggleStatus"
                                                            id="statusLabel">In-Active</label>
                                                    </div>
                                                </div>

                                                <!-- Submit Button -->
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons end  -->


                            <!-- Edit Buttons Modal -->
                            <div class="modal fade" id="editButtonModal" tabindex="-1"
                                aria-labelledby="editButtonModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editButtonModalLabel">Edit Button</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editButtonForm" action="{{ route('header.updateButton') }}"
                                                enctype="multipart/form-data" method="post">
                                                {{ csrf_field() }}
                                                <!-- Button Title -->
                                                <input type="hidden" id="buttonId" name="id">
                                                <div class="mb-3">
                                                    <label for="editButtonName" class="form-label">Title</label>
                                                    <input type="text" class="form-control" id="editButtonTitle"
                                                        placeholder="Enter Button title" name="name">
                                                </div>

                                                <!-- Button Link -->
                                                <div class="mb-3">
                                                    <label for="editButtonName" class="form-label">Link</label>
                                                    <input type="text" class="form-control" id="editButtonLink"  pattern="https?://.*"
                                                        placeholder="Enter Button Link" name="link" title="Please enter a valid URL starting with http:// or https://" required>
                                                </div>
                                                {{-- Colour effect --}}
                                                <div class="row mb-3">
                                                    {{-- <div class="col-12 col-md-3"> --}}
                                                        <label for="coloreffect" class="form-label">Colour Effect</label>
                                                    {{-- </div> --}}
                                                    <div class="col-12 col-md-5">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input"
                                                                   name="coloreffect"
                                                                   type="checkbox"
                                                                   id="editColorStatus"
                                                                   value="1"
                                                                   >
                                                            <labelclass="form-check-label"
                                                            for="toggleColor1"
                                                            id="colorStatusLabel">
                                                            </labelclass=>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Status Toggle -->
                                                <div class="mb-3">
                                                    <label for="editButtonStatus" class="form-label">Status</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="status" type="checkbox"
                                                            id="editButtonStatus" value="1"
                                                            {{ CHECKBOX('document_status') }}
                                                            onchange="toggleStatusText('editStatusLabel', this)">
                                                        <label class="form-check-label" for="toggleStatus"
                                                            id="buttonStatusLabel"></label>
                                                    </div>
                                                </div>
                                                <!-- Submit Button -->
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                <button class="btn btn-danger">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- insert the contents Here end -->
        </div>
        <!-- page inner end-->
    </div>
    <!-- Logo Image Modal -->
    <div class="modal fade" id="logoImageModal" tabindex="-1" aria-labelledby="logoImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="logoImageModalImage" src="#" alt="Logo Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>



    <!-- Banner Image Modal -->
    <div class="modal fade" id="bannerImageModal" tabindex="-1" aria-labelledby="bannerImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="bannerImageModalImage" src="#" alt="Banner Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    <script>
        function editLogo(id, name, imageUrl, logoStatus) {
            document.getElementById('logoId').value = id; // Set the ID for the hidden input
            document.getElementById('editLogoName').value = name; // Set the name
            document.getElementById('editLogoImagePreview').src = imageUrl; // Set the image preview
            document.getElementById('editLogoStatus').checked = logoStatus == 1; // Check if the status is active
            document.getElementById('editStatusLabel').textContent = logoStatus == 1 ? 'Active' : 'In-Active';

            console.log(logoStatus);
            $('#editLogoModal').modal('show');

        }

        function editBanner(id, name, imageUrl, logoStatus) {
            document.getElementById('bannerId').value = id; // Set the ID for the hidden input
            document.getElementById('editBannerTitle').value = name; // Set the name
            document.getElementById('editBannerDescription').value = description;
            document.getElementById('editBannerDate').value = date;
            document.getElementById('currentBannerPreview').src = imageUrl; // Set the image preview
            document.getElementById('editBannerStatus').checked = logoStatus == 1; // Check if the status is active
            document.getElementById('bannerStatusLabel').textContent = logoStatus == 1 ? 'Active' : 'In-Active';

            console.log(logoStatus);
            $('#editBannerModal').modal('show');

        }

        function editButton(id, name, link, buttonStatus, colorStatus) {
            document.getElementById('buttonId').value = id; // Set the ID for the hidden input
            document.getElementById('editButtonTitle').value = name; // Set the name
            document.getElementById('editButtonLink').value = link; // Set the link
            document.getElementById('editButtonStatus').checked = buttonStatus == 1; // Check if the status is active
            document.getElementById("editColorStatus").checked = colorStatus == 1;
            document.getElementById('colorStatusLabel').textContent = colorStatus == 1 ? 'Active' : 'In-Active';
            document.getElementById('buttonStatusLabel').textContent = buttonStatus == 1 ? 'Active' : 'In-Active';

            console.log(buttonStatus);
            $('#editButtonModal').modal('show');

        }


        function toggleEdit(button) {
            const row = button.closest('tr');
            const inputs = row.querySelectorAll('input');

            // If inputs are disabled, enable them for editing
            if (inputs[0].disabled) {
                inputs.forEach(input => input.disabled = false);
                button.textContent = 'Save';
            } else {
                // If inputs are enabled, disable them and save the data
                inputs.forEach(input => input.disabled = false);
                button.textContent = 'Edit';

                const form = document.getElementById('governmentForm');
                form.submit();
            }
        }

        // Function to preview logo image
        function previewNewImage() {
            const fileInput = document.getElementById('editLogoImage');
            const newLogoPreview = document.getElementById('newLogoPreview');

            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                newLogoPreview.src = e.target.result; // Update preview with new image
                newLogoPreview.style.display = 'block'; // Show the new image preview
            };

            if (file) {
                reader.readAsDataURL(file); // Trigger preview
            }
        }

        // Function to show banner image modal
        function showBannerImageModal(imagePreviewId) {
            var image = document.getElementById(imagePreviewId);
            var modalImage = document.getElementById('bannerImageModalImage');
            modalImage.src = image.src;
        }

        // Function to show logo image modal
        function showLogoImageModal(imagePreviewId) {
            var image = document.getElementById(imagePreviewId);
            var modalImage = document.getElementById('logoImageModalImage');
            modalImage.src = image.src;
        }

        function previewBannerImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const bannerPreview = document.getElementById('bannerPreview');
                bannerPreview.src = reader.result;
                bannerPreview.style.display = 'block'; // Show the preview
            }
            reader.readAsDataURL(event.target.files[0]);
        }

    </script>

    <script src="{{ asset('packa/theme/assets/node_modules/html5-editor/wysihtml5-0.3.0.js') }}"></script>
    <script src="{{ asset('packa/theme/assets/node_modules/html5-editor/bootstrap-wysihtml5.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('.textarea_editor').wysihtml5();
        });
    </script>
@endsection
