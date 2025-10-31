@extends('admin.layouts.layout')
@section('title', 'Create Programs')
@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('packa/theme/assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}" />
    </head>
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Documents</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ethics Commitee</li>
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
                        <!-- <form id="eventForm"> -->
                        <h4 class="card-title mb-4 text-primary">Ethics Committee</h4>

                        <!-- Form Structure -->
                        <div class="mt-3 mb-3 p-3" style="background-color: #f7f7f7;">
                            <form id="ethicscommitteeform" class="mb-3" method="POST"
                                action="{{ url('ethics_committee/update') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row mb-3">
                                    <!-- Title-->
                                    <div class="col-lg-6">
                                        <label for="Title" class="form-label">Title<span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="Title" placeholder="Enter Title"
                                            name="name" value="{{ $result->name ?? '' }}">
                                    </div>

                                    <!-- Document Upload -->
                                    <div class="col-lg-6">
                                        <label for="iconUpload" class="form-label">ScrollerNotification Icon (PNG Only)<span
                                                style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="iconUpload" accept=".png"
                                                name="scroller_notification_image">
                                            <a href="{{ fileLink($result->image_url ?? '') }}" target="_blank"
                                                class="btn btn-primary input-group-text">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                        <small style="color: red;">Accepted formats: .PNG, max size 5MB</small>
                                    </div>
                                </div>



                                <div class="row mb-3">
                                    <!-- Scroller Notification -->
                                    <div class="col-lg-6">
                                        <label for="scrollerNotification" class="form-label">Scroller Notification <span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="scrollerNotification"
                                            name="scroller_notification_name" placeholder="Enter scroller notification"
                                            value="{{ $result->scroller_notification_name ?? '' }}">
                                    </div>

                                    <!-- Document Upload -->
                                    <div class="col-lg-6">
                                        <label for="scrollerNotification" class="form-label">Scroller Notification Link<span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="scrollerNotification"  pattern="https?://.*" title="Please enter a valid URL starting with http:// or https://"
                                            name="scroller_notification_link" placeholder="Enter scroller notification Link"
                                            value="{{ $result->scroller_notification_link ?? '' }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">

                                    <!-- Document Upload -->
                                    <div class="col-lg-6">
                                        <label for="documentUpload" class="form-label">Upload Document (EC Guidelines)<span
                                                style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="documentUpload" name="document">
                                            <a href="{{ fileLink($result->document_url ?? '') }}" target="_blank"
                                                class="btn btn-primary input-group-text">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>

                                        <small style="color: red;">Accepted formats: .pdf, max size 5MB</small>
                                    </div>

                                    <!-- Scroller Notification -->
                                    <div class="col-lg-6">
                                        <label for="eventDescription" class="form-label">Description <span
                                                style="color: red;">*</span></label>
                                        <textarea class="form-control textarea_editor" style="width: 100%" id="eventDescription" placeholder="Enter description" name="description" rows="10">{{ $result->description ?? '' }}</textarea>
                                    </div>


                                </div>

                                <!-- <hr style="color: #c7c7c7;"> -->


                                <!-- Contact Details -->
                                <h5 class="mb-3 mt-3">Contact Details</h5>
                                <div class="row mb-5 mt-4">
                                    <div class="col-lg-6">
                                        <label for="contactDescription" class="form-label">Description <span
                                                style="color: red;">*</span></label>
                                        <textarea class="form-control" id="contactDescription" placeholder="Enter contact description"
                                            name="contact_description" rows="5">{{ $result->contact_description ?? '' }}</textarea>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="contactEmail" class="form-label">Email <span
                                                style="color: red;">*</span></label>
                                        <input type="email" class="form-control" id="contactEmail" name="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                                            placeholder="Enter email" value="{{ $result->email ?? '' }}" title="Please enter a valid email address (e.g., user@domain.com)" required>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <!-- <button type="button" class="btn btn-danger" style="margin-left: 10px;" data-bs-dismiss="modal">Cancel</button> -->
                                </div>
                            </form>
                        </div>

                        <!-- <hr style="color: #c7c7c7;"> -->



                        <!-- Image Upload for Banners -->
                        <!-- banner image start=======================================================================================================-->
                        <div class="container-fluid mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Ethics Committee Banner Images</h4>
                                        <!-- Add Banner Button -->
                                        <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                            data-bs-target="#addBannerModal">
                                            <i class="fa fa-plus"></i> Add
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
                                                        <th style="width: 20%;">Order ID</th>
                                                        <th style="width: 20%;">Banner Title</th>
                                                        <th style="width: 20%;">Input</th>
                                                        <th style="width: 20%;">Last Update</th>
                                                        <th style="width: 8%;">Status</th>
                                                        <th style="width: 10%;" class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($banner_images as $banner_image)
                                                        <!-- Banner 1 start -->
                                                        <tr>
                                                            <td>{{ $banner_image->order_no }}</td>
                                                            <td>{{ $banner_image->name }}</td>
                                                            <td>
                                                                <img src="{{ fileLink($banner_image->image_url) }}"
                                                                    alt="Logo" style="max-width: 100px;">
                                                            </td>
                                                            <td>{{ $banner_image->updated_at }}</td>
                                                            <td class="text-{{ $banner_image->status == 1 ? 'success' : 'danger' }}"
                                                                style="font-weight: bold;">
                                                                {{ $banner_image->status == 1 ? 'Active' : 'In-Active' }}
                                                            </td>
                                                            <td class="text-center">
                                                                <!-- Actions with icons -->
                                                                <div class="form-button-action">
                                                                    <button type="button"
                                                                        class="btn btn-link btn-primary text-center"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editBannerModal"
                                                                        onclick="editBanner('{{ $banner_image->id }}', '{{ $banner_image->order_no }}', '{{ $banner_image->name }}', '{{ fileLink($banner_image->image_url) }}', '{{ $banner_image->status }}')">
                                                                        <i class="fa fa-edit"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <!-- Banner 1 end -->
                                                    <!-- Repeat similar rows for additional banners -->
                                                </tbody>
                                            </table>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- banner image end=====================================================================================================-->

                        <!-- modal for adding banner start -->
                        <!-- Modal Popup for Adding Banner -->
                        <div class="modal fade" id="addBannerModal" tabindex="-1" aria-labelledby="addBannerModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addBannerModalLabel">Add New Banner</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addBannerForm" action="{{ url('ethics_committee/store_banner') }}"
                                            method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="configuration_content_type_id" value="23">
                                            <!-- Order ID -->
                                            <div class="mb-3">
                                                <label for="editOrderId" class="form-label">Order ID</label>
                                                <input type="text" class="form-control" id="addBannerOrderId"
                                                    placeholder="Enter order ID" name="order_no" required>
                                            </div>

                                            <!-- Banner Title Field -->
                                            <div class="mb-3">
                                                <label for="bannerTitle" class="form-label">Banner Title</label>
                                                <input type="text" class="form-control" id="bannerTitle"
                                                    placeholder="Enter banner title" name="name" required>
                                            </div>

                                            <!-- Select Image Field with Preview -->
                                            <div class="mb-3">
                                                <label for="bannerImage" class="form-label">Select Banner Image</label>
                                                <input type="file" class="form-control" id="bannerImage"
                                                    accept="image/*" required onchange="previewBannerImage(event)"
                                                    name="banner_iamge">
                                                <small class="form-text text-danger">Accepted formats: .jpg, .jpeg, .png,
                                                    max size:
                                                    5MB</small>
                                            </div>

                                            <!-- Status Toggle -->
                                            <div class="mb-3">
                                                <label for="bannerStatus" class="form-label">Status</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="bannerStatus"
                                                        name="status" value="1"
                                                        onchange="toggleStatusText('bannerStatusText', this)">
                                                    <label class="form-check-label" for="bannerStatus"
                                                        id="bannerStatusText">Active</label>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="button" class="btn btn-danger" style="margin-left: 10px;"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- modal for adding banner end -->

                        <!-- model for edit banner start -->
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
                                        <form id="editBannerForm" action="{{ url('ethics_committee/update_banner') }}"
                                            method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden" id="ethicsBannerId" name="id">
                                            <!-- Order ID -->
                                            <div class="mb-3">
                                                <label for="editOrderId" class="form-label">Order ID</label>
                                                <input type="text" class="form-control" id="editBannerOrderId"
                                                    placeholder="Enter order ID" name="order_no" required>
                                            </div>

                                            <!-- Banner Title -->
                                            <div class="mb-3">
                                                <label for="editBannerTitle" class="form-label">Banner Title</label>
                                                <input type="text" class="form-control" id="editBannerTitle"
                                                    placeholder="Enter banner title" name="name" required>
                                            </div>

                                            <!-- New Banner Image Preview -->
                                            <div class="mb-3">
                                                <label for="editBannerImage" class="form-label">New Banner Image</label>
                                                <div class="input-group">
                                                    <input type="file" class="form-control" id="editBannerImage"
                                                        onchange="previewNewBannerImage()" name="banner_image">
                                                    <a href="" target="_blank" id="currentBannerPreview"
                                                        class="btn btn-primary input-group-text">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                                <small class="text-muted">Select a new image to update.</small>
                                            </div>

                                            <!-- Status Toggle -->
                                            <div class="mb-3">
                                                <label for="editBannerStatus" class="form-label">Status</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        id="editBannerStatus" name="status"
                                                        onchange="toggleStatusText('editBannerStatusLabel', this)">
                                                    <label class="form-check-label" for="editBannerStatus"
                                                        id="editBannerStatusLabel">Active</label>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="button" class="btn btn-danger" style="margin-left: 10px;"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- model for edit banner end -->

                        <!-- member list start ============================================================================================================================ -->
                        <div class="container-fluid mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Member List</h4>
                                        <!-- Add Member Button -->
                                        <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                            data-bs-target="#addMemberModal">
                                            <i class="fa fa-plus"></i> Add
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
                                                        <th style="width: 20%;">Order ID</th>
                                                        <th style="width: 20%;">Name</th>
                                                        <th style="width: 20%;">Qualification</th>
                                                        <th style="width: 20%;">Institution</th>
                                                        <th style="width: 15%;">Designation</th>
                                                        <th style="width: 15%;">Affiliation</th>
                                                        <th style="width: 10%;" class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($members as $member)
                                                        <tr>

                                                            <td>{{ $member->order_no }}</td>
                                                            <td>{{ $member->name }}</td>
                                                            <td>{{ $member->qualification }}</td>
                                                            <td>{{ $member->institution }}</td>
                                                            <td>{{ $member->designations }}</td>
                                                            <td> {{ $member->affiliation == 1 ? 'Affiliated' : 'Not Affiliated' }}
                                                            </td>
                                                            <td class="text-center">
                                                                <!-- Actions with icons -->
                                                                <div class="form-button-action">
                                                                    <button type="button"
                                                                        class="btn btn-link btn-primary text-center"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editMemberModal"
                                                                        onclick="editMember('{{ $member->id }}', '{{ $member->order_no }}', '{{ $member->name }}', '{{ $member->qualification }}', '{{ $member->institution }}', '{{ $member->designations }}', '{{ $member->status }}', '{{ $member->affiliation }}')">
                                                                        <i class="fa fa-edit"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <!-- Member Row start -->

                                                    <!-- Member Row end -->
                                                    <!-- Repeat similar rows for additional members -->
                                                </tbody>
                                            </table>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- member list end =========================================================================================================================== -->

                        <!-- modal for adding member start -->
                        <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addMemberModalLabel">Add New Member</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addMemberForm" action="{{ url('ethics_committee/store_member') }}"
                                            method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}

                                            <input type="hidden" name="configuration_content_type_id" value="23">
                                            <!-- Order ID -->
                                            <div class="mb-3">
                                                <label for="editOrderId" class="form-label">Order ID</label>
                                                <input type="text" class="form-control" id="editOrderId"
                                                    placeholder="Enter order ID" name="order_no" required>
                                            </div>

                                            <!-- Name Field -->
                                            <div class="mb-3">
                                                <label for="memberName" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="memberName"
                                                    placeholder="Enter member name" name="name" required>
                                            </div>

                                            <!-- Qualification Field -->
                                            <div class="mb-3">
                                                <label for="memberQualification" class="form-label">Qualification</label>
                                                <input type="text" class="form-control" id="memberQualification"
                                                    placeholder="Enter qualification" name="qualification" required>
                                            </div>

                                            <!-- Institution Field -->
                                            <div class="mb-3">
                                                <label for="memberInstitution" class="form-label">Institution</label>
                                                <input type="text" class="form-control" id="memberInstitution"
                                                    placeholder="Enter institution" name="institution" required>
                                            </div>

                                            <!-- Designation Field -->
                                            <div class="mb-3">
                                                <label for="memberDesignation" class="form-label">Designation</label>
                                                <input type="text" class="form-control" id="addDesignationsId"
                                                    placeholder="Enter Designation" name="designations" required>
                                                {{-- <select name="designations_id" id="addDesignationsId"
                                                    class="form-control" required>
                                                    <option value="0" disabled selected>-- None -- </option>
                                                    @foreach ($designations as $key => $designation)
                                                        <option value="{{ $designation->id }}">{{ $designation->name }}
                                                        </option>
                                                    @endforeach
                                                </select> --}}
                                            </div>

                                            <!-- Affiliation Toggle -->
                                            <div class="mb-3">
                                                <label for="addMemberAffiliation" class="form-label">Affiliation</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="addMemberAffiliation" value="1" name="affiliation"
                                                        onchange="toggleAffiliationText('addMemberAffiliationLabel', this)">
                                                    <label class="form-check-label" for="addMemberAffiliation"
                                                        id="addMemberAffiliationLabel">No Affiliation</label>
                                                </div>
                                            </div>

                                            <!-- Status Toggle -->
                                            <div class="mb-3">
                                                <label for="memberStatus" class="form-label">Status</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="memberStatus"
                                                        value="1" name="status"
                                                        onchange="toggleStatusText('memberStatusLabel', this)">
                                                    <label class="form-check-label" for="memberStatus"
                                                        id="memberStatusLabel">Active</label>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="button" class="btn btn-danger" style="margin-left: 10px;"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- modal for adding member end -->

                        <!-- modal for edit member start -->
                        <div class="modal fade" id="editMemberModal" tabindex="-1"
                            aria-labelledby="editMemberModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editMemberModalLabel">Edit Member</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editMemberForm" action="{{ url('ethics_committee/update_member') }}"
                                            method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" id="ethicsMemberId">
                                            <!-- Order ID -->
                                            <div class="mb-3">
                                                <label for="editOrderId" class="form-label">Order ID</label>
                                                <input type="text" class="form-control" id="editMemberOrderId"
                                                    placeholder="Enter order ID" name="order_no">
                                            </div>


                                            <!-- Name Field -->
                                            <div class="mb-3">
                                                <label for="editMemberName" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="editMemberName"
                                                    placeholder="Enter member name" name="name">
                                            </div>

                                            <!-- Qualification Field -->
                                            <div class="mb-3">
                                                <label for="editMemberQualification"
                                                    class="form-label">Qualification</label>
                                                <input type="text" class="form-control" id="editMemberQualification"
                                                    placeholder="Enter qualification" name="qualification">
                                            </div>

                                            <!-- Institution Field -->
                                            <div class="mb-3">
                                                <label for="editMemberInstitution" class="form-label">Institution</label>
                                                <input type="text" class="form-control" id="editMemberInstitution"
                                                    placeholder="Enter institution" name="institution">
                                            </div>

                                            <!-- Designation Field -->
                                            <div class="mb-3">
                                                <label for="editMemberDesignation" class="form-label">Designation</label>
                                                <input type="text" class="form-control" id="editMemberDesignationsId"
                                                    placeholder="Enter Designation" name="designations">
                                                {{-- <select name="designations_id" id="editMemberDesignationsId"
                                                    class="form-control">
                                                    <option value="0">-- None -- </option>
                                                    @foreach ($designations as $key => $designation)
                                                        <option value="{{ $designation->id }}">{{ $designation->name }}
                                                        </option>
                                                    @endforeach
                                                </select> --}}
                                            </div>

                                            <!-- Affiliation Toggle -->
                                            <div class="mb-3">
                                                <label for="editMemberAffiliationToggle"
                                                    class="form-label">Affiliation</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="editmemberAffiliation" value="1" name="affiliation"
                                                        onchange="toggleAffiliationText('editMemberAffiliationLabel', this)">
                                                    <label class="form-check-label" for="editMemberAffiliationToggle"
                                                        id="editMemberAffiliationLabel">No Affiliation</label>
                                                </div>
                                            </div>

                                            <!-- Status Toggle -->
                                            <div class="mb-3">
                                                <label for="editMemberStatus" class="form-label">Status</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="editmemberStatus"
                                                        name="status" value="1"
                                                        onchange="toggleStatusText('editMemberStatusLabel', this)">
                                                    <label class="form-check-label" for="editMemberStatus"
                                                        id="editMemberStatusLabel">Active</label>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="button" class="btn btn-danger" style="margin-left: 10px;"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- modal for edit member end -->

                        <!-- Certificate Images Upload start==================================================================================-->
                        <div class="container-fluid mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Certificate Image List</h4>
                                        <!-- Add Image Button -->
                                        <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                            data-bs-target="#addImageModal">
                                            <i class="fa fa-plus"></i> Add
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
                                                        <th style="width: 20%;">Order ID</th>
                                                        <th style="width: 20%;">Image</th>
                                                        <th style="width: 20%;">Last Update</th>
                                                        <th style="width: 15%;">Status</th>
                                                        <th style="width: 10%;" class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Image Row start -->
                                                    @foreach ($certificates as $certificate)
                                                        <tr>
                                                            <td>{{ $certificate->order_no }}</td>
                                                            <td>
                                                                <img src="{{ fileLink($certificate->image_url) }}"
                                                                    alt="Sample Image" style="max-width: 100px;">
                                                            </td>
                                                            <td>{{ $certificate->updated_at }}</td>
                                                            <td class="text-{{ $certificate->status == 1 ? 'success' : 'danger' }}"
                                                                style="font-weight: bold;">
                                                                {{ $certificate->status == 1 ? 'Active' : 'In-Active' }}
                                                            </td>
                                                            <td class="text-center">
                                                                <!-- Actions with icons -->
                                                                <div class="form-button-action">
                                                                    <button type="button"
                                                                        class="btn btn-link btn-primary text-center"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editImageModal"
                                                                        onclick="editCertificate('{{ $certificate->id }}', '{{ $certificate->order_no }}', '{{ fileLink($certificate->image_url) }}', '{{ $certificate->status }}')">
                                                                        <i class="fa fa-edit"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <!-- Image Row end -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <!-- Modal for Adding Image -->
                        <div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="addImageModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addImageModalLabel">Add New Image</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addImageForm" action="{{ url('ethics_committee/store_certificate') }}"
                                            method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="configuration_content_type_id" value="23">
                                            <!-- Order ID -->
                                            <div class="mb-3">
                                                <label for="orderId" class="form-label">Order ID</label>
                                                <input type="text" class="form-control" id="orderId"
                                                    placeholder="Enter order ID" name="order_no">
                                            </div>

                                            <!-- Image Upload -->
                                            <div class="mb-3">
                                                <label for="imageUpload" class="form-label">Upload Image</label>
                                                <input type="file" class="form-control" id="imageUpload"
                                                    accept="image/*" name="certificate_image">
                                                <small class="form-text text-danger">Accepted formats: .jpg, .jpeg, .png,
                                                    max size:
                                                    5MB</small>
                                            </div>

                                            <!-- Status Toggle -->
                                            <div class="mb-3">
                                                <label for="imageStatus" class="form-label">Status</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="imageStatus"
                                                        value="1" name="status"
                                                        onchange="toggleStatusText('imageStatusLabel', this)">
                                                    <label class="form-check-label" for="imageStatus"
                                                        id="imageStatusLabel">In-Active</label>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="button" class="btn btn-danger" style="margin-left: 10px;"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for Editing Image -->
                        <div class="modal fade" id="editImageModal" tabindex="-1" aria-labelledby="editImageModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editImageModalLabel">Edit Image</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editImageForm" action="{{ url('ethics_committee/update_certificate') }}"
                                        method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                            <input type="hidden" name="id" id="ethicsCertificateId">
                                            <!-- Order ID -->
                                            <div class="mb-3">
                                                <label for="editOrderId" class="form-label">Order ID</label>
                                                <input type="text" class="form-control" id="editCertificateOrderId"
                                                    name="order_no" placeholder="Enter order ID">
                                            </div>

                                            <!-- New Image Upload -->
                                            <div class="mb-3">
                                                <label for="editImageUpload" class="form-label">New Image Upload</label>
                                                <div class="input-group">
                                                    <input type="file" class="form-control" name="certificate_image" id="editImageUpload">
                                                    <a href="" target="_blank" id="currentCertificatePreview"
                                                        class="btn btn-primary input-group-text">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                                <small class="text-muted">Select a new image to update.</small>
                                            </div>

                                            <!-- Status Toggle -->
                                            <div class="mb-3">
                                                <label for="editImageStatus" class="form-label">Status</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="editCertificateStatus" value="1"
                                                        onchange="toggleStatusText('editImageStatusLabel', this)" name="status">
                                                    <label class="form-check-label" for="editImageStatus"
                                                        id="editCertificateStatusLabel">Active</label>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="button" class="btn btn-danger" style="margin-left: 10px;"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Buttons -->
                                  <!-- <div class="d-flex mt-2">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-danger" style="margin-left: 10px;">Cancel</button>
                                  </div> -->
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- database table end -->
    </div>
    <script>
        function editBanner(id, order_no, name, imageUrl, Status) {
            console.log(order_no);
            document.getElementById('ethicsBannerId').value = id; // Set the ID for the hidden input
            document.getElementById('editBannerOrderId').value = order_no; // Set the ID for the hidden input
            document.getElementById('editBannerTitle').value = name; // Set the name
            document.getElementById('currentBannerPreview').href = imageUrl; // Set the image preview
            document.getElementById('editBannerStatus').checked = Status == 1; // Check if the status is active
            document.getElementById('editBannerStatusLabel').textContent = Status == 1 ? 'Active' : 'In-Active';

            $('#editBannerModal').modal('show');

        }

        function editMember(id, order_no, name, qualification, institution, designations, affiliation, Status) {
            console.log(order_no);
            document.getElementById('ethicsMemberId').value = id; // Set the ID for the hidden input
            document.getElementById('editMemberOrderId').value = order_no; // Set the ID for the hidden input
            document.getElementById('editMemberName').value = name; // Set the name
            document.getElementById('editMemberQualification').value = qualification; // Set the image preview
            document.getElementById('editMemberInstitution').value = institution; // Set the image preview
            document.getElementById('editMemberDesignationsId').value = designations; // Set the image preview
            document.getElementById('editmemberStatus').checked = Status == 1; // Check if the status is active
            document.getElementById('editMemberStatusLabel').textContent = Status == 1 ? 'Active' : 'In-Active';
            document.getElementById('editmemberAffiliation').checked = affiliation == 1; // Check if the status is active
            document.getElementById('editMemberAffiliationLabel').textContent = affiliation == 1 ? 'Affiliated' :
                'Not Affiliated';

            $('#editMemberModal').modal('show');

        }

        function editCertificate(id, order_no, imageUrl, Status) {
            console.log(order_no);
            document.getElementById('ethicsCertificateId').value = id; // Set the ID for the hidden input
            document.getElementById('editCertificateOrderId').value = order_no; // Set the ID for the hidden input
            document.getElementById('currentCertificatePreview').href = imageUrl; // Set the image preview
            document.getElementById('editCertificateStatus').checked = Status == 1; // Check if the status is active
            document.getElementById('editCertificateStatusLabel').textContent = Status == 1 ? 'Active' : 'In-Active';

            $('#editCertificateModal').modal('show');

        }
    </script>
    <script src="{{ asset('packa/theme/assets/node_modules/html5-editor/wysihtml5-0.3.0.js') }}"></script>
    <script src="{{ asset('packa/theme/assets/node_modules/html5-editor/bootstrap-wysihtml5.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('.textarea_editor').wysihtml5();
        });
    </script>
    <script src="{{ asset('packa/custom/about-us.js') }}"></script>
@endsection
