@extends('admin.layouts.layout')

@section('title', 'Edit Configuration')

@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Footer Configuration</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Configuration</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Footer</li>
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



                <div class="container-fluid mt-3">
                    <div class="row justify-content-center">
                        <div class="col-lg-12"
                            style="background: linear-gradient(to right, #ffffff, #ffffff); border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">


                            <!-- Table Layout -->

                            <!-- logo in footer start =========================================================================================================== -->
                            <div class="table-responsive mt-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5>Logo In Footer</h5>
                                    <!-- Add Link Button -->
                                    <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                        data-bs-target="#addLogoModal">
                                        <i class="fa fa-plus"></i> Add Logo
                                    </button>
                                </div>
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
                                                @foreach ($footer_logos as $footer_logo)
                                                    <!-- logo 1 start -->
                                                    <tr>
                                                        <td>{{ $footer_logo->name ?? '' }}</td>
                                                        <td>
                                                            <img src="{{ fileLink($footer_logo->image_url) }}"
                                                                alt="Logo" style="max-width: 100px;">
                                                        </td>
                                                        <td>{{ $footer_logo->getOriginal('updated_at') ?? '' }}</td>
                                                        <td class="text-success" style="font-weight: bold;">
                                                            @if (isset($footer_logo->status) && $footer_logo->status == 1)
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
                                                                    data-bs-toggle="modal" data-bs-target="#editLogoModal"
                                                                    onclick="editLogo('{{ $footer_logo->id }}', '{{ $footer_logo->name }}', '{{ fileLink($footer_logo->image_url) }}', '{{ $footer_logo->status }}')">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <!-- logo 1 end -->
                                                    <!-- Repeat similar rows for logo 2, 3, 4, etc. -->
                                            </tbody>
                                            @endforeach
                                        </table>
                                    </div>
                                </form>
                            </div>
                            <!-- Modal Popup for Adding footer logo ====================================================================-->
                            <div class="modal fade" id="addLogoModal" tabindex="-1" aria-labelledby="addLogoModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addLogoModalLabel">Add Footer Logo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="addLogoForm" action="{{ route('footer.storelogo') }}"
                                                enctype="multipart/form-data" method="post">
                                                {{ csrf_field() }}
                                                <!-- Logo Title Field -->
                                                <div class="mb-3">
                                                    <label for="logoTitle" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="logoTitle"
                                                        placeholder="Enter logo title" name="name" required>
                                                </div>

                                                <!-- Link Input Field -->
                                                <div class="mb-3">
                                                    <label for="logoLink" class="form-label">Link</label>
                                                    <input type="file" class="form-control" id="logoImage"
                                                        name="footer_logo_image" accept="image/*" required
                                                        onchange="previewImage(event)">
                                                    <small class="form-text text-danger">Accepted formats: .png, max size:
                                                        5MB</small>
                                                </div>

                                                <!-- Image Preview -->
                                                <div class="mb-3 text-center">
                                                    <img id="footerLogoPreview" src="" alt="Image Preview"
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
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- important links adding model end ================================================================-->
                            <!--edit start model  -->
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
                                            <form id="editLogoForm" action="{{ route('footer.updatelogo') }}"
                                                enctype="multipart/form-data" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" id="footerLogoId" name="id">
                                                <!-- Logo Title -->
                                                <div class="mb-3">
                                                    <label for="editLogoTitle" class="form-label">Logo Title</label>
                                                    <input type="text" class="form-control" id="editFooterLogoTitle"
                                                        placeholder="Enter logo title" name="name">
                                                </div>
                                                <!-- Current Logo Preview -->
                                                <div class="mb-3">
                                                    <label class="form-label">Current Logo</label>
                                                    <img id="currentFooterLogoPreview" src="" alt="Current Logo"
                                                        style="max-width: 100px;" class="d-block mb-2">
                                                </div>
                                                <!-- New Logo Image Preview -->
                                                <div class="mb-3">
                                                    <label for="editLogoImage" class="form-label">New Logo Image</label>
                                                    <input type="file" class="form-control" id="editLogoImage"
                                                        onchange="previewNewImage(event)" name="footer_logo_image"
                                                        value="1" name="status">
                                                    <small class="text-muted">Select a new image to update.</small>
                                                    <img id="newFooterLogoPreview" src="" alt="New Logo Preview"
                                                        style="max-width: 100px; display: none;" class="d-block mt-2">
                                                </div>
                                                <!-- Status Toggle -->
                                                <div class="mb-3">
                                                    <label for="editLogoStatus" class="form-label">Status</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="editFooterLogoStatus" value="1" name="status"
                                                            onchange="toggleStatusText('footerLogoStatusLabel', this)">
                                                        <label class="form-check-label" for="editLogoStatus"
                                                            id="footerLogoStatusLabel">Active</label>
                                                    </div>
                                                </div>
                                                <!-- Submit Button -->
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                                <button class="btn btn-danger">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--edit end model  -->

                            <!-- Image Modal for edit footer logo start-->
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
                            <!-- Image Modal for edit footer logo end-->






                            <!-- logo footer end ===========================================================================================================-->

                            <hr>



                            <!-- Separate div for Government and DPH Names -->
                            <div class="mb-4 pt-4">
                                <h5 class="mb-4">Footer Details</h5>
                                <form id="footerDetailsForm" action="{{ url('footer/update/' . 3) }}"
                                    enctype="multipart/form-data" method="post">
                                    {{ csrf_field() }}
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="govNameTamilfooter" class="form-label font-weight-bold">
                                                Government Name (Tamil) <span style="color: red;">*</span>
                                            </label>
                                            <input type="text" class="form-control shadow-sm" id="govNameTamilfooter"
                                                name="footer_gov_name_tamil" placeholder="Enter government name in Tamil"
                                                value="{{ $footer_detail->dph_full_form_tamil  }}">
                                        </div>
                                        <!-- Telephone Start -->
                                        <div class="col-md-6">
                                            <label for="Footertelephone" class="form-label font-weight-bold">
                                                Office Telephone <span style="color: red;">*</span>
                                            </label>
                                            <input type="tel" class="form-control shadow-sm" id="Footertelephone"
                                                name="dph_phone" placeholder="Enter Telephone Number"
                                                value="{{ old('dph_phone', $footer_detail->dph_phone) }}">
                                        </div>
                                    </div>

                                    <!-- Address Start -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="FooterAddress" class="form-label font-weight-bold">
                                                Address <span style="color: red;">*</span>
                                            </label>
                                            <textarea class="form-control shadow-sm" id="FooterAddress" name="dph_address" placeholder="Enter Address"
                                                rows="2">{{ old('dph_address', $footer_detail->dph_address) }}</textarea>
                                        </div>
                                        <!-- City Start -->
                                        <div class="col-md-6">
                                            <label for="FooterCity" class="form-label font-weight-bold">
                                                City <span style="color: red;">*</span>
                                            </label>
                                            <input type="text" class="form-control shadow-sm" id="FooterCity"
                                                name="dph_city" placeholder="Enter City"
                                                value="{{ old('dph_city', $footer_detail->dph_city) }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <!-- State Start -->
                                        <div class="col-md-6">
                                            <label for="FooterState" class="form-label font-weight-bold">
                                                State <span style="color: red;">*</span>
                                            </label>
                                            <input type="text" class="form-control shadow-sm" id="FooterState"
                                                name="dph_state" placeholder="Enter State"
                                                value="{{ old('dph_state', $footer_detail->dph_state) }}">
                                        </div>
                                        <!-- Zip Code Start -->
                                        <div class="col-md-6">
                                            <label for="FooterZipcode" class="form-label font-weight-bold">
                                                Zipcode <span style="color: red;">*</span>
                                            </label>
                                            <input type="text" class="form-control shadow-sm" id="FooterZipcode"
                                                name="dph_zip_code" placeholder="Enter Zipcode"  pattern="^\d{6}$" maxlength="6" minlength="6"  title="Zipcode must be exactly 6 digits."
                                                value="{{ old('dph_zip_code', $footer_detail->dph_zip_code) }}" required>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label for="DPHFooteremail" class="form-label font-weight-bold">
                                                Email <span style="color: red;">*</span>
                                            </label>
                                            <input type="email" class="form-control shadow-sm" id="DPHFooteremail"
                                                name="dph_email" placeholder="DPH Email Address"
                                                value="{{ old('dph_email', $footer_detail->dph_email) }}">
                                        </div>
                                        <!-- <div class="col-md-6 mt-2">
                                            <label for="DPHFooteremail" class="form-label font-weight-bold">
                                               Location <span style="color: red;">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="location_url" value="{{ old('location_url', $footer_detail->location_url) }}" required>
                                        </div> -->
                                    </div>
                                    <!-- Address End -->
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        <div>
                                            <p>Last Updated : {{ $footer_detail->getOriginal('updated_at') }}</p>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <hr>

                            <!-- Separate div for web info start-->
                            <div class="mb-5 pt-4">
                                <h5 class="mb-4">Web Information Manager</h5>

                                <!-- Form Start -->
                                <form id="webInfoForm" action="{{ url('footer/update/' . 4) }}"
                                    enctype="multipart/form-data" method="post">
                                    {{ csrf_field() }}
                                    <!-- Mobile Start -->
                                    <div class="row mb-3">

                                        <!-- Designation Start -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="designation" class="form-label font-weight-bold">
                                                    Designation <span style="color: red;">*</span>
                                                </label>
                                                <input type="text" class="form-control shadow-sm" id="designation"
                                                    name="joint_director_designation" placeholder="Enter Designation"
                                                    value="{{ old('joint_director_designation', $footer_jd->joint_director_designation) }}">
                                            </div>
                                        </div>
                                        <!-- Designation End -->

                                        <div class="col-md-6">
                                            <label for="Footertelephone" class="form-label font-weight-bold">
                                                Mobile <span style="color: red;">*</span>
                                            </label>
                                            <input type="tel" class="form-control shadow-sm" id="Footertelephone"
                                                name="joint_director_phone" placeholder="Enter Telephone Number" pattern="^\d{10}$" maxlength="10" minlength="10" title="Mobile No must be exactly 10 digits."
                                                value="{{ old('joint_director_phone', $footer_jd->joint_director_phone) }}" required>
                                        </div>
                                    </div>
                                    <!-- Mobile End -->

                                    <!-- Email Start -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="Footeremail" class="form-label font-weight-bold">
                                                Email <span style="color: red;">*</span>
                                            </label>
                                            <input type="email" class="form-control shadow-sm" id="Footeremail"
                                                name="joint_director_email" placeholder="Enter Email Address"
                                                value="{{ old('joint_director_email', $footer_jd->joint_director_email) }}">
                                        </div>
                                        <!-- <div class="col-md-6 d-flex align-items-end">
                                  <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="emailfooter" name="emailfooter" checked
                                      onchange="toggleStatusText('statusLabelEmail', this)">
                                    <label class="form-check-label" for="emailfooter" id="statusLabelEmail">Active</label>
                                  </div>
                                </div> -->
                                    </div>
                                    <!-- Email End -->



                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        <div>
                                            <p>Last Updated : {{ $footer_jd->getOriginal('updated_at') }}</p>
                                        </div>

                                    </div>

                                </form>
                                <!-- Form End -->
                            </div>
                            <hr>

                            <!-- important links start ==================================================================================================================================-->
                            <div class="table-responsive mt-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5>Important Links</h5>

                                    <!-- Add Link Button -->
                                    <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                        data-bs-target="#addImpoLinkModal">
                                        <i class="fa fa-plus"></i> Add Links
                                    </button>

                                </div>

                                <form>
                                    <!-- Table Layout -->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30%;">Name</th>
                                                    <th style="width: 40%;">Link</th>
                                                    <th style="width: 20%;">Status</th>
                                                    <th style="width: 10%;" class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="linkTableBody">
                                                @foreach ($important_links as $important_link)
                                                    <!-- Example Link Row (can be populated dynamically) -->
                                                    <tr>
                                                        <td>{{ $important_link->name ?? '' }}</td>
                                                        <td>
                                                            <a href="{{ $important_link->link ?? '' }}"
                                                                target="_blank">{{ $important_link->link ?? '' }}</a>
                                                        </td>
                                                        <td style="font-weight: bold;">
                                                            @if (isset($important_link->status) && $important_link->status == 1)
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
                                                                    data-bs-toggle="modal" data-bs-target="#editLinkModal"
                                                                    onclick="editLink('{{ $important_link->id }}', '{{ $important_link->name }}', '{{ $important_link->link }}', '{{ $important_link->status }}')">
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


                            <!-- Modal Popup for Adding Important Link ====================================================================-->
                            <div class="modal fade" id="addImpoLinkModal" tabindex="-1" aria-labelledby="addImpoLinkModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addImpoLinkModalLabel">Add Important Links</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="addImpoLinkForm" action="{{ route('footer.storelink') }}"
                                            enctype="multipart/form-data" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" value="6" name="configuration_content_type_id">
                                                <!-- Logo Title Field -->
                                                <div class="mb-3">
                                                    <label for="impoLinkTitle" class="form-label">Name Of the Link</label>
                                                    <input type="text" class="form-control" id="logoTitle"
                                                        placeholder="Enter logo title" name="name" required>
                                                </div>

                                                <!-- Link Input Field -->
                                                <div class="mb-3">
                                                    <label for="impoLinkLink" class="form-label">Link</label>
                                                    <input type="url" class="form-control" id="logoLink"
                                                        placeholder="Enter logo link" name="link"  pattern="https?://.*"  title="Please enter a valid URL starting with http:// or https://"
                                                        required>
                                                </div>

                                                <!-- Status Toggle -->
                                                <div class="mb-3">
                                                    <label for="impoLinkStatus" class="form-label">Status</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="status" type="checkbox"
                                                            id="impoLinkToggleStatus" value="1"
                                                            {{ CHECKBOX('document_status') }}
                                                            onchange="toggleStatusText('impoLinkStatusLabel', this)">
                                                        <label class="form-check-label" for="toggleStatus"
                                                            id="impoLinkStatusLabel">In-Active</label>
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

                            <!-- important links adding model end ================================================================-->

                            <!-- edit important link model start -->
                            <!-- Edit Modal Popup for Link -->
                            <div class="modal fade" id="editLinkModal" tabindex="-1"
                                aria-labelledby="editLinkModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editLinkModalLabel">Edit Link</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editLinkForm" action="{{ route('footer.updatelink') }}"
                                            enctype="multipart/form-data" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" id="editLinkId">
                                                <!-- Link Name Field -->
                                                <div class="mb-3">
                                                    <label for="editLinkName" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="editLinkName"
                                                        placeholder="Enter link name" name="name" required>
                                                </div>

                                                <!-- Link Input Field -->
                                                <div class="mb-3">
                                                    <label for="editLinkURL" class="form-label">Link</label>
                                                    <input type="text" class="form-control" id="editLinkUrl"
                                                        pattern="https?://.*"
                                                        placeholder="Enter link URL" name="link" required>
                                                </div>

                                                <!-- Status Toggle -->
                                                <div class="mb-3">
                                                    <label for="editLinkStatus" class="form-label">Status</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="status" value="1"
                                                            id="editLinkStatus" onchange="toggleStatusText('editLinkStatusLabel', this)">
                                                        <label class="form-check-label" for="editLinkStatusLabel"
                                                            id="editLinkStatusLabel">Active</label>
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
                            <!-- edit important link model end -->

                            <!-- important links end ======================================================================================================================================-->

                            <hr>


                            <!-- Quick Links Start ==================================================================================================================================-->
                            <div class="table-responsive mt-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5>Quick Links</h5>

                                    <!-- Add Link Button -->
                                    <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                        data-bs-target="#addQuickLinkModal">
                                        <i class="fa fa-plus"></i> Add Links
                                    </button>
                                </div>

                                <form>
                                    <!-- Table Layout -->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30%;">Name</th>
                                                    <th style="width: 40%;">Link</th>
                                                    <th style="width: 20%;">Status</th>
                                                    <th style="width: 10%;" class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="quickLinkTableBody">
                                                @foreach ($quick_links as $quick_link)
                                                <!-- Example Link Row (can be populated dynamically) -->
                                                <tr>
                                                    <td>{{ $quick_link->name ?? '' }}</td>
                                                    <td>
                                                        <a href="{{ $quick_link->link ?? '' }}"
                                                            target="_blank">{{ $quick_link->link ?? '' }}</a>
                                                    </td>
                                                    <td style="font-weight: bold;">
                                                        @if (isset($quick_link->status) && $quick_link->status == 1)
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
                                                                data-bs-target="#editQuickLinkModal"
                                                                onclick="editQuickLink('{{ $quick_link->id }}', '{{ $quick_link->name }}', '{{ $quick_link->link }}', '{{ $quick_link->status }}')">
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
                            <!-- Quick Links End ==================================================================================================================================-->

                            <!-- Modal Popup for Adding Quick Link ====================================================================-->
                            <div class="modal fade" id="addQuickLinkModal" tabindex="-1"
                                aria-labelledby="addQuickLinkModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addQuickLinkModalLabel">Add New Quick Link</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="addQuickLinkForm" action="{{ route('footer.storelink') }}"
                                            enctype="multipart/form-data" method="post">
                                            {{ csrf_field() }}
                                                <!-- Link Name Field -->
                                                <input type="hidden" value="7" name="configuration_content_type_id">
                                                <div class="mb-3">
                                                    <label for="quickLinkName" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="quickLinkName"
                                                        placeholder="Enter quick link name" name="name" required>
                                                </div>

                                                <!-- Link Input Field -->
                                                <div class="mb-3">
                                                    <label for="quickLinkURL" class="form-label">Link</label>
                                                    <input type="url" class="form-control" id="quickLinkURL"
                                                        placeholder="Enter quick link URL" name="link"
                                                        pattern="https?://.*" required>
                                                </div>

                                                <!-- Status Toggle -->
                                                <div class="mb-3">
                                                    <label for="quickLinkStatus" class="form-label">Status</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="status" type="checkbox"
                                                            id="quickLinkStatus" value="1"
                                                            {{ CHECKBOX('document_status') }}
                                                            onchange="toggleStatusText('quickLinkStatusLabel', this)">
                                                        <label class="form-check-label" for="toggleStatus"
                                                            id="quickLinkStatusLabel">In-Active</label>
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
                            <!-- Modal Popup for Adding Quick Link End ====================================================================-->

                            <!-- Edit Modal Popup for Quick Link -->
                            <div class="modal fade" id="editQuickLinkModal" tabindex="-1"
                                aria-labelledby="editQuickLinkModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editQuickLinkModalLabel">Edit Quick Link</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editQuickLinkForm" action="{{ route('footer.updatelink') }}"
                                            enctype="multipart/form-data" method="post">
                                            {{ csrf_field() }}
                                                <!-- Link Name Field -->
                                                <input type="hidden" id="editQuickLinkId" name="id">
                                                <div class="mb-3">
                                                    <label for="editQuickLinkName" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="editQuickLinkName"
                                                        placeholder="Enter quick link name" name="name" required>
                                                </div>

                                                <!-- Link Input Field -->
                                                <div class="mb-3">
                                                    <label for="editQuickLinkURL" class="form-label">Link</label>
                                                    <input type="url" class="form-control" id="editQuickLinkUrl"
                                                        placeholder="Enter quick link URL" name="link"
                                                        pattern="https?://.*" required>
                                                </div>

                                                <!-- Status Toggle -->
                                                <div class="mb-3">
                                                    <label for="editQuickLinkStatus" class="form-label">Status</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="status" value="1"
                                                            id="editQuickLinkStatus" onchange="toggleStatusText('editQuickLinkStatusLabel', this)">
                                                        <label class="form-check-label" for="editQuickLinkStatusLabel"
                                                            id="editQuickLinkStatusLabel">Active</label>
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
                            <!-- Edit Modal Popup for Quick Link End -->

                            <!-- Quick Links end ======================================================================================================================================== -->

                            <hr>


                            <!-- Public Links Start ==================================================================================================================================-->
                            <div class="table-responsive mt-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5>Public Links</h5>

                                    <!-- Add Link Button -->
                                    <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                        data-bs-target="#addPublicLinkModal">
                                        <i class="fa fa-plus"></i> Add Links
                                    </button>
                                </div>

                                <form>
                                    <!-- Table Layout -->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30%;">Name</th>
                                                    <th style="width: 40%;">Link</th>
                                                    <th style="width: 20%;">Status</th>
                                                    <th style="width: 10%;" class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="publicLinkTableBody">
                                                @foreach ($public_links as $public_link)
                                                <!-- Example Link Row (can be populated dynamically) -->
                                                <tr>
                                                    <td>{{ $public_link->name ?? '' }}</td>
                                                    <td>
                                                        <a href="{{ $public_link->name ?? '' }}"
                                                            target="_blank">{{ $public_link->name ?? '' }}</a>
                                                    </td>
                                                    <td style="font-weight: bold;">
                                                        @if (isset($public_link->status) && $public_link->status == 1)
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
                                                                data-bs-target="#editPublicLinkModal"
                                                                onclick="editPublickLink('{{ $public_link->id }}', '{{ $public_link->name }}', '{{ $public_link->link }}', '{{ $public_link->status }}')">
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

                            <!-- Modal Popup for Adding Public Link ====================================================================-->
                            <div class="modal fade" id="addPublicLinkModal" tabindex="-1"
                                aria-labelledby="addPublicLinkModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addPublicLinkModalLabel">Add New Public Link</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="addPublicLinkForm" action="{{ route('footer.storelink') }}"
                                            enctype="multipart/form-data" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" value="8" name="configuration_content_type_id">
                                                <!-- Link Name Field -->
                                                <div class="mb-3">
                                                    <label for="publicLinkName" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="publicLinkName"
                                                        placeholder="Enter public link name" name="name" required>
                                                </div>

                                                <!-- Link Input Field -->
                                                <div class="mb-3">
                                                    <label for="publicLinkURL" class="form-label">Link</label>
                                                    <input type="url" class="form-control" id="publicLinkURL"
                                                        placeholder="Enter public link URL" name="link"
                                                        pattern="https?://.*" required>
                                                </div>

                                                <!-- Status Toggle -->
                                                <div class="mb-3">
                                                    <label for="publicLinkStatus" class="form-label">Status</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="status" type="checkbox"
                                                            id="publicLinkToggleStatus" value="1"
                                                            {{ CHECKBOX('document_status') }}
                                                            onchange="toggleStatusText('publicLinkStatusLabel', this)">
                                                        <label class="form-check-label" for="toggleStatus"
                                                            id="publicLinkStatusLabel">In-Active</label>
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
                            <!-- Modal Popup for Adding Public Link End ====================================================================-->





                            <!-- Edit Modal Popup for Public Link -->
                            <div class="modal fade" id="editPublicLinkModal" tabindex="-1"
                                aria-labelledby="editPublicLinkModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editPublicLinkModalLabel">Edit Public Link</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editPublicLinkForm" action="{{ route('footer.updatelink') }}"
                                            enctype="multipart/form-data" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" id="editPublicLinkId">
                                                <!-- Link Name Field -->
                                                <div class="mb-3">
                                                    <label for="editPublicLinkName" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="editPublicLinkName"
                                                        placeholder="Enter public link name" name="name" required>
                                                </div>

                                                <!-- Link Input Field -->
                                                <div class="mb-3">
                                                    <label for="editPublicLinkURL" class="form-label">Link</label>
                                                    <input type="url" class="form-control" id="editPublicLinkUrl"
                                                        placeholder="Enter public link URL" name="link"
                                                        pattern="https?://.*" required>
                                                </div>

                                                <!-- Status Toggle -->
                                                <div class="mb-3">
                                                    <label for="editPublicLinkStatus" class="form-label">Status</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="status" value="1"
                                                            id="editPublicLinkStatus" onchange="toggleStatusText('editPublicLinkStatusLabel', this)">
                                                        <label class="form-check-label" for="editLinkStatusLabel"
                                                            id="editPublicLinkStatusLabel">Active</label>
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
                            <!-- Edit Modal Popup for Public Link End -->

                            <!-- Public Links End ==================================================================================================================================-->


                            <hr>





                            <!-- Resources Start ==================================================================================================================================-->
                            <div class="table-responsive mt-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5>Resources</h5>

                                    <!-- Add Resource Button -->
                                    <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                        data-bs-target="#addResourceModal">
                                        <i class="fa fa-plus"></i> Add Resource
                                    </button>
                                </div>

                                <form>
                                    <!-- Table Layout -->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30%;">Name</th>
                                                    <th style="width: 40%;">Link</th>
                                                    <th style="width: 20%;">Status</th>
                                                    <th style="width: 10%;" class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="resourceTableBody">
                                                @foreach ($resources as $resource)
                                                <!-- Example Resource Row (can be populated dynamically) -->
                                                <tr>
                                                    <td>{{ $resource->name ?? '' }}</td>
                                                    <td>
                                                        <a href="{{ $resource->name ?? '' }}"
                                                            target="_blank">{{ $resource->name ?? '' }}</a>
                                                    </td>
                                                    <td style="font-weight: bold;">
                                                        @if (isset($resource->status) && $resource->status == 1)
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
                                                                data-bs-toggle="modal" data-bs-target="#editResourceModal"
                                                                onclick="editResource('{{ $resource->id }}', {{ json_encode($resource->name) }}, '{{ $resource->link }}', '{{ $resource->status }}')">
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

                            <!-- Modal Popup for Adding Resource ====================================================================-->
                            <div class="modal fade" id="addResourceModal" tabindex="-1"
                                aria-labelledby="addResourceModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addResourceModalLabel">Add New Resource</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="addResourceForm" action="{{ route('footer.storelink') }}"
                                            enctype="multipart/form-data" method="post">
                                            {{ csrf_field() }}
                                                <!-- Resource Name Field -->
                                                <input type="hidden" value="9" name="configuration_content_type_id">
                                                <div class="mb-3">
                                                    <label for="resourceName" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="resourceName"
                                                        placeholder="Enter resource name" name="name" required>
                                                </div>

                                                <!-- Resource Link Input Field -->
                                                <div class="mb-3">
                                                    <label for="resourceURL" class="form-label">Link</label>
                                                    <input type="url" class="form-control" id="resourceURL"
                                                        placeholder="Enter resource URL" name="link"
                                                        pattern="https?://.*" required>
                                                </div>

                                                <!-- Status Toggle -->
                                                <div class="mb-3">
                                                    <label for="resourceStatus" class="form-label">Status</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="status" type="checkbox"
                                                            id="resourceStatus" value="1"
                                                            onchange="toggleStatusText('resourceStatusLabel', this)">
                                                        <label class="form-check-label" for="toggleStatus"
                                                            id="resourceStatusLabel">In-Active</label>
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
                            <!-- Modal Popup for Adding Resource End ====================================================================-->

                            <!-- Edit Modal Popup for Resource -->
                            <div class="modal fade" id="editResourceModal" tabindex="-1"
                                aria-labelledby="editResourceModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editResourceModalLabel">Edit Resource</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editResourceForm" action="{{ route('footer.updatelink') }}"
                                            enctype="multipart/form-data" method="post">
                                            {{ csrf_field() }}
                                                <!-- Resource Name Field -->
                                                <input type="hidden" name="id" id="editResourceId">
                                                <div class="mb-3">
                                                    <label for="editResourceName" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="editResourceName"
                                                        placeholder="Enter resource name" name="name" required>
                                                </div>

                                                <!-- Resource Link Input Field -->
                                                <div class="mb-3">
                                                    <label for="editResourceURL" class="form-label">Link</label>
                                                    <input type="url" class="form-control" id="editResourceUrl"
                                                        placeholder="Enter resource URL" name="link"
                                                        pattern="https?://.*" required>
                                                </div>

                                                <!-- Status Toggle -->
                                                <div class="mb-3">
                                                    <label for="editResourceStatus" class="form-label">Status</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="status" value="1"
                                                            id="editResourceStatus" onchange="toggleStatusText('editResourceStatusLabel', this)">
                                                        <label class="form-check-label" for="editResourceStatusLabel"
                                                            id="editResourceStatusLabel">Active</label>
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
                            <!-- Edit Modal Popup for Resource End -->

                            <!-- Resources End ==================================================================================================================================-->

                            <hr>

                            <!-- Emergency Contact Start ==================================================================================================================================-->
                            <div class="table-responsive mt-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5>Emergency Contacts</h5>

                                    <!-- Add Emergency Contact Button -->
                                    <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                        data-bs-target="#addEmergencyContactModal">
                                        <i class="fa fa-plus"></i> Add Emergency Contact
                                    </button>
                                </div>

                                <form>
                                    <!-- Table Layout -->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30%;">Name</th>
                                                    <th style="width: 40%;">Number</th>
                                                    <th style="width: 20%;">Status</th>
                                                    <th style="width: 10%;" class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="emergencyContactTableBody">
                                                @foreach ($emergency_contacts as $emergency_contact)
                                                <!-- Example Emergency Contact Row (can be populated dynamically) -->
                                                <tr>
                                                    <td>{{ $emergency_contact->name ?? '' }}</td>
                                                    <td>{{ $emergency_contact->link ?? '' }}</td>
                                                    <td class="text-success" style="font-weight: bold;">
                                                        @if (isset($emergency_contact->status) && $emergency_contact->status == 1)
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
                                                                data-bs-target="#editEmergencyContactModal"
                                                                onclick="editEmergencyContact('{{ $emergency_contact->id }}', '{{ $emergency_contact->name }}', '{{ $emergency_contact->link }}', '{{ $emergency_contact->status }}')">
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

                            <!-- Modal Popup for Adding Emergency Contact -->
                            <div class="modal fade" id="addEmergencyContactModal" tabindex="-1"
                                aria-labelledby="addEmergencyContactModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addEmergencyContactModalLabel">Add New Emergency
                                                Contact</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="addEmergencyContactForm" action="{{ route('footer.storelink') }}"
                                            enctype="multipart/form-data" method="post">
                                            {{ csrf_field() }}
                                                <!-- Emergency Contact Name Field -->
                                                <input type="hidden" value="10" name="configuration_content_type_id">
                                                <div class="mb-3">
                                                    <label for="emergencyContactName" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="emergencyContactName"
                                                        placeholder="Enter contact name" name="name" required>
                                                </div>

                                                <!-- Emergency Contact Number Field -->
                                                <div class="mb-3">
                                                    <label for="emergencyContactNumber" class="form-label">Number</label>
                                                    <input type="tel" class="form-control"
                                                        id="emergencyContactNumber" placeholder="Enter contact number" title="Please enter a 3 to 10-digit contact number (numbers only)"
                                                        name="link" pattern="^\d{3}$" maxlength="10" minlength="3" required>
                                                </div>

                                                <!-- Status Toggle -->
                                                <div class="mb-3">
                                                    <label for="emergencyContactStatus" class="form-label">Status</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="status" type="checkbox"
                                                            id="emergencyContactToggleStatus" value="1"
                                                            {{ CHECKBOX('document_status') }}
                                                            onchange="toggleStatusText('emergencyContactStatusLabel', this)">
                                                        <label class="form-check-label" for="toggleStatus"
                                                            id="emergencyContactStatusLabel">In-Active</label>
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

                            <!-- Modal Popup for Editing Emergency Contact -->
                            <div class="modal fade" id="editEmergencyContactModal" tabindex="-1"
                                aria-labelledby="editEmergencyContactModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editEmergencyContactModalLabel">Edit Emergency
                                                Contact</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editEmergencyContactForm" action="{{ route('footer.updatelink') }}"
                                            enctype="multipart/form-data" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" id="editEmergencyContactId">
                                                <!-- Emergency Contact Name Field -->
                                                <div class="mb-3">
                                                    <label for="editEmergencyContactName" class="form-label">Name</label>
                                                    <input type="text" class="form-control"
                                                        id="editEmergencyContactName" placeholder="Enter contact name"
                                                        name="name" required>
                                                </div>

                                                <!-- Emergency Contact Number Field -->
                                                <div class="mb-3">
                                                    <label for="editEmergencyContactNumber"
                                                        class="form-label">Number</label>
                                                    <input type="tel" class="form-control"
                                                        id="editEmergencyContactUrl" placeholder="Enter contact number" title="Please enter a 3 to 10-digit contact number (numbers only)"
                                                        name="link" pattern="^\d{3}$" maxlength="10" minlength="3" required>
                                                </div>

                                                <!-- Status Toggle -->
                                                <div class="mb-3">
                                                    <label for="editEmergencyContactStatus"
                                                        class="form-label">Status</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="status" value="1"
                                                        id="editEmergencyContactStatus" onchange="toggleStatusText('EmergencyContact', this)">
                                                    <label class="form-check-label" for="editLinkStatusLabel"
                                                        id="editEmergencyContactStatusLabel">Active</label>
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
                            <!-- Emergency Contact End ==================================================================================================================================-->
                        </div>
                    </div>
                </div>

                <!-- insert the contents Here end -->
            </div>
            <!-- page inner end-->
        </div>
        <!-- database table end -->
    </div>
    <!--JavaScript for image preview start -->
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const footerLogoPreview = document.getElementById('footerLogoPreview');
                footerLogoPreview.src = reader.result;
                footerLogoPreview.style.display = 'block'; // Show the preview
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function previewNewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const newFooterLogoPreview = document.getElementById('newFooterLogoPreview');
                newFooterLogoPreview.src = reader.result;
                newFooterLogoPreview.style.display = 'block'; // Show the preview
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function editLogo(id, name, imageUrl, logoStatus) {
            document.getElementById('footerLogoId').value = id; // Set the ID for the hidden input
            document.getElementById('editFooterLogoTitle').value = name; // Set the name
            document.getElementById('currentFooterLogoPreview').src = imageUrl; // Set the image preview
            document.getElementById('editFooterLogoStatus').checked = logoStatus == 1; // Check if the status is active
            document.getElementById('footerLogoStatusLabel').textContent = logoStatus == 1 ? 'Active' : 'In-Active';

            console.log(logoStatus);
            $('#editFooterLogoModal').modal('show');

        }

        function editLink(id, name, link, status) {
            document.getElementById('editLinkId').value = id; // Set the ID for the hidden input
            document.getElementById('editLinkName').value = name; // Set the name
            document.getElementById('editLinkUrl').value = link; // Set the image preview
            document.getElementById('editLinkStatus').checked = status == 1; // Check if the status is active
            document.getElementById('editLinkStatusLabel').textContent = status == 1 ? 'Active' : 'In-Active';
            $('#editLinkModal').modal('show');
        }
        function editQuickLink(id, name, link, status) {
            document.getElementById('editQuickLinkId').value = id; // Set the ID for the hidden input
            document.getElementById('editQuickLinkName').value = name; // Set the name
            document.getElementById('editQuickLinkUrl').value = link; // Set the image preview
            document.getElementById('editQuickLinkStatus').checked = status == 1; // Check if the status is active
            document.getElementById('editQuickLinkStatusLabel').textContent = status == 1 ? 'Active' : 'In-Active';
            $('#editQuickLinkModal').modal('show');

        }
        function editPublickLink(id, name, link, status) {
            document.getElementById('editPublicLinkId').value = id; // Set the ID for the hidden input
            document.getElementById('editPublicLinkName').value = name; // Set the name
            document.getElementById('editPublicLinkUrl').value = link; // Set the image preview
            document.getElementById('editPublicLinkStatus').checked = status == 1; // Check if the status is active
            document.getElementById('editPublicLinkStatusLabel').textContent = status == 1 ? 'Active' : 'In-Active';
            $('#editPublicLinkModal').modal('show');

        }
        function editResource(id, name, link, status) {
            document.getElementById('editResourceId').value = id; // Set the ID for the hidden input
            document.getElementById('editResourceName').value = name; // Set the name
            document.getElementById('editResourceUrl').value = link; // Set the image preview
            document.getElementById('editResourceStatus').checked = status == 1; // Check if the status is active
            document.getElementById('editResourceStatusLabel').textContent = status == 1 ? 'Active' : 'In-Active';
            $('#editResourceModal').modal('show');

        }
        function editEmergencyContact(id, name, link, status) {
            document.getElementById('editEmergencyContactId').value = id; // Set the ID for the hidden input
            document.getElementById('editEmergencyContactName').value = name; // Set the name
            document.getElementById('editEmergencyContactUrl').value = link; // Set the image preview
            document.getElementById('editEmergencyContactStatus').checked = status == 1; // Check if the status is active
            document.getElementById('editEmergencyContactStatusLabel').textContent = status == 1 ? 'Active' : 'In-Active';
            $('#editEmergencyContactModal').modal('show');

        }
    </script>

    <!-- script for allowing only number end -->
    <script>
        // Function to preview image
        // function previewImage(event, imagePreviewId) {
        //     var input = event.target;
        //     var reader = new FileReader();

        //     reader.onload = function () {
        //         var dataURL = reader.result;
        //         var output = document.getElementById(imagePreviewId);
        //         var container = document.getElementById('imagePreviewContainer');

        //         output.src = dataURL;
        //         output.style.display = 'block';
        //         container.style.display = 'block';
        //     };

        //     reader.readAsDataURL(input.files[0]);
        // }

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
