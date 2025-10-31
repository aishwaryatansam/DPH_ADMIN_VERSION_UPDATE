@extends('admin.layouts.layout')
@section('title', 'List Programs')
@section('content')
    <style>
        .nav-link.active .notification-badge {
            background-color: white;
            color: rgb(100, 118, 255);
        }

        .nav-tabs .nav-link.active {
            background-color: #007bff !important;
            /* Primary background color */
            color: white !important;
            /* White text color */
        }

        .nav-tabs .nav-link.active .badge {
            background-color: #ffffff;
            /* White badge background for active tab */
            color: #007bff;
            /* Primary color text inside badge */
        }

        .nav-tabs .nav-link .badge {
            background-color: #6c757d;
            /* Default badge color */
        }

        .bg-purple {
            background-color: #6f42c1 !important;
            /* Bootstrap's purple color */
            color: #fff !important;
            /* White text */
        }
    </style>
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Manage Scheme Details</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Scheme Details</li>
                    </ol>
                </nav>

            </div>
        </div>
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="d-flex justify-content-end mt-5">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#approvalGuidelineModal">
                        Approval Guideline
                    </button>
                </div>

                <!-- Modal for approval guideline -->
                <div class="modal fade" id="approvalGuidelineModal" tabindex="-1"
                    aria-labelledby="approvalGuidelineModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="approvalGuidelineModalLabel">Approval Guideline</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="./assets/img/dphadmin/ApprovalWorkflow.webp" alt="Approval Guideline"
                                    class="img-fluid" />
                                <!-- Replace 'path_to_your_image.jpg' with the actual path to your image -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="page-inner">
                <!-- DataTable Start -->
                <div class="container-fluid ps-4 bg-white py-4" style="border-radius: 8px;">
                    <div class="card-body">
                        <!-- Bulk Approval -->
                        <div class="d-flex justify-content-between align-items-center mb-lg-5">
                            <h4 class="card-title mb-5 text-primary text-start">Manage Scheme Details</h4>
                            @if (isAdmin())
                                <div class="mb-5">
                                    <small style="font-weight: bold; color: #888; margin-right: 10px;">Bulk Select:</small>
                                    <button id="publishBtn" class="btn btn-success"
                                        onclick="performBulkAction('publish')">Publish</button>
                                    <button id="approveBtn" class="btn btn-info"
                                        onclick="performBulkAction('approve')">Approve</button>
                                    <button id="verifyBtn" class="btn btn-secondary"
                                        onclick="performBulkAction('verify')">Verify</button>
                                    <button id="returnBtn" class="btn btn-warning"
                                        onclick="showRemarksModal('return')">Return
                                        with
                                        Remarks</button>
                                    <button id="rejectBtn" class="btn btn-danger"
                                        onclick="showRemarksModal('reject')">Reject
                                        with
                                        Remarks</button>
                                </div>
                            @endif

                            {{-- @if (isState() && isApprover())
                                <div class="mb-5">
                                    <small style="font-weight: bold; color: #888; margin-right: 10px;">Bulk Select:</small>
                                    <button id="approveBtn" class="btn btn-info" 
                                        onclick="performBulkAction('approve')">Approve</button>
                                    <button id="verifyBtn" class="btn btn-secondary"
                                        onclick="performBulkAction('verify')">Verify</button>
                                    <button id="returnBtn" class="btn btn-warning"
                                        onclick="showRemarksModal('return')">Return
                                        with
                                        Remarks</button>
                                    <button id="rejectBtn" class="btn btn-danger"
                                        onclick="showRemarksModal('reject')">Reject
                                        with
                                        Remarks</button>
                                </div>
                            @endif

                            @if (isState() && isVerifier())
                                <div class="mb-5">
                                    <small style="font-weight: bold; color: #888; margin-right: 10px;">Bulk Select:</small>
                                    <button id="verifyBtn" class="btn btn-secondary"
                                        onclick="performBulkAction('verify')">Verify</button>
                                    <button id="returnBtn" class="btn btn-warning"
                                        onclick="showRemarksModal('return')">Return
                                        with
                                        Remarks</button>
                                    <button id="rejectBtn" class="btn btn-danger"
                                        onclick="showRemarksModal('reject')">Reject
                                        with
                                        Remarks</button>
                                </div>
                            @endif --}}
                        </div>

                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <!-- All Tab -->

                                <button class="nav-link d-flex align-items-center active custom-activealldoc"
                                    id="nav-All-tab" data-bs-toggle="tab" data-bs-target="#nav-All" type="button"
                                    role="tab" aria-controls="nav-All" aria-selected="true">
                                    All Documents
                                    <span class="notification badge ms-2 px-3 py-1">{{ $results['totalCount'] }}</span>
                                </button>

                                <!-- Pushed Tab -->
                                <button class="nav-link custom-activepushed" id="nav-Pushed-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-Pushed" type="button" role="tab" aria-controls="nav-Pushed"
                                    aria-selected="false">
                                    Pushed
                                    <span class="notification badge ms-2 px-3 py-1">{{ $results['pushed'] }}</span>
                                </button>

                                <!-- Approved Tab -->
                                <button class="nav-link custom-activeapproved" id="nav-Approved-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-Approved" type="button" role="tab"
                                    aria-controls="nav-Approved" aria-selected="false">
                                    Approved
                                    <span class="notification badge ms-2 px-3 py-1">{{ $results['approved'] }}</span>
                                </button>

                                <!-- Pending Tab -->
                                <button class="nav-link custom-activepending" id="nav-Pending-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-Pending" type="button" role="tab"
                                    aria-controls="nav-Pending" aria-selected="false">
                                    Pending
                                    <span class="notification badge ms-2 px-3 py-1">{{ $results['pending'] }}</span>
                                </button>

                                <!-- Return With Remarks Tab -->
                                <button class="nav-link custom-activereturnwithremark" id="nav-Return-tab"
                                    data-bs-toggle="tab" data-bs-target="#nav-Return" type="button" role="tab"
                                    aria-controls="nav-Return" aria-selected="false">
                                    Return
                                    <span class="notification badge ms-2 px-3 py-1">{{ $results['returned'] }}</span>
                                </button>

                                <!-- Reject With Remarks Tab -->
                                <button class="nav-link custom-activerejectwithremark" id="nav-Rejected-tab"
                                    data-bs-toggle="tab" data-bs-target="#nav-Rejected" type="button" role="tab"
                                    aria-controls="nav-Rejected" aria-selected="false">
                                    Reject
                                    <span class="notification badge ms-2 px-3 py-1">{{ $results['rejected'] }}</span>
                                </button>


                            </div>
                        </nav>

                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active mt-5" id="nav-All" role="tabpanel"
                                aria-labelledby="nav-All-tab" tabindex="0">

                                <div class="table-responsive">
                                    <table id="add-row"
                                        class="data-table display table table-striped table-hover doc-table"
                                        style="width:100%;" data-results='@json($results)'>
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="selectAll"
                                                        onclick="toggleSelectAll(this)"></th>
                                                <th>Scheme Name</th>
                                                <th>Uploader Name</th>
                                                <th>Processed By</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                                <th>Last Action</th>
                                                <th class="text-center" style="width: 10%">Actions</th>
                                                <!-- Actions Column -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($results['paginatedResult']->isEmpty())
                                                <tr>
                                                    <td colspan="8" class="text-center">No Schemes</td>
                                                </tr>
                                            @else
                                                @foreach ($results['paginatedResult'] as $result)
                                                    <tr>
                                                        <td><input type="checkbox"
                                                                class="form-check-input documentCheckbox"
                                                                value="{{ $result->id }}"></td>
                                                        <td><a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#approvalModa">{{ $result->model->scheme->name ?? '' }}</a>
                                                        </td>
                                                        <td>{{ $result->user->name ?? '' }}</td>
                                                        <td>{{ findProcessedBy($result->current_stage, $result->id) }}</td>
                                                        <td>
                                                            {!! getStageBadge($result->current_stage) !!}
                                                        </td>
                                                        <td>{{ $result->remarks }}</td>
                                                        <td>{{ $result->updated_at }}</td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-primary dropdown-toggle"
                                                                    type="button" id="actionDropdown1"
                                                                    data-bs-toggle="dropdown"
                                                                    aria-expanded="false">Actions</button>
                                                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg p-2"
                                                                    aria-labelledby="actionDropdown1">
                                                                    @if (isAdmin())
                                                                        {{-- <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="performAction('publish', {{ $result->id }})"
                                                                            @if ($result->current_stage !== 'state_approve') style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-cloud-upload me-2 text-success"></i>
                                                                            Publish
                                                                        </a>
                                                                    </li> --}}
                                                                        {{-- <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="performAction('approve', {{ $result->id }})"
                                                                            @if ($result->current_stage !== 'verified') style="display: none !important;" @endif>

                                                                            <i
                                                                                class="bi bi-check-circle me-2 text-success"></i>
                                                                            Approve
                                                                        </a>
                                                                    </li> --}}
                                                                        {{-- <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="performAction('verify', {{ $result->id }})"
                                                                            @if ($result->current_stage !== 'pending_verification') style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-check2-square me-2 text-primary"></i>
                                                                            Verify
                                                                        </a>
                                                                    </li> --}}
                                                                        {{-- <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="showRemarksModal('return', {{ $result->id }})"
                                                                            @if ($result->current_stage !== 'state_approve') style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                            Return with Remarks
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                            @if ($result->current_stage !== 'state_approve') style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-x-circle me-2 text-danger"></i>
                                                                            Reject with Remarks
                                                                        </a>
                                                                    </li> --}}

                                                                        <li>
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                                onclick="performAction('view')">
                                                                                <i class="bi bi-eye me-2 text-info"></i>
                                                                                View
                                                                            </a>
                                                                        </li>
                                                                        {{-- <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="performAction('resubmit', {{ $result->id }})"
                                                                            @if ($result->current_stage !== 'returned_with_remarks') style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                            Resubmit
                                                                        </a>
                                                                    </li> --}}
                                                                    @elseif (isState() && isApprover())
                                                                        {{-- <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="performAction('state_approve', {{ $result->id }})"
                                                                            @if ($result->current_stage !== 'state_verify') style="display: none !important;" @endif>

                                                                            <i
                                                                                class="bi bi-check-circle me-2 text-success"></i>
                                                                            Approve
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="showRemarksModal('return', {{ $result->id }})"
                                                                            @if ($result->current_stage !== 'state_verify') style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                            Return with Remarks
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                            @if ($result->current_stage !== 'state_verify') style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-x-circle me-2 text-danger"></i>
                                                                            Reject with Remarks
                                                                        </a>
                                                                    </li> --}}

                                                                        <li>
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                                onclick="performAction('view')">
                                                                                <i class="bi bi-eye me-2 text-info"></i>
                                                                                View
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                                <a class="dropdown-item d-flex align-items-center"
                                                                                    href="#"
                                                                                    onclick="performAction('resubmit', {{ $result->id }})">
                                                                                    <i
                                                                                        class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                    Resubmit
                                                                                </a>
                                                                            @endif
                                                                        </li>
                                                                    @elseif (isBlock() && isApprover())
                                                                        {{-- <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="performAction('block_approve', {{ $result->id }})"
                                                                            @if (!in_array($result->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif>

                                                                            <i
                                                                                class="bi bi-check-circle me-2 text-success"></i>
                                                                            Approve
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="showRemarksModal('return', {{ $result->id }})"
                                                                            @if (!in_array($result->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                            Return with Remarks
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                            @if (!in_array($result->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-x-circle me-2 text-danger"></i>
                                                                            Reject with Remarks
                                                                        </a>
                                                                    </li> --}}

                                                                        <li>
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                                onclick="performAction('view')">
                                                                                <i class="bi bi-eye me-2 text-info"></i>
                                                                                View
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                                <a class="dropdown-item d-flex align-items-center"
                                                                                    href="#"
                                                                                    onclick="performAction('resubmit', {{ $result->id }})">
                                                                                    <i
                                                                                        class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                    Resubmit
                                                                                </a>
                                                                            @endif
                                                                        </li>
                                                                    @elseif (isHUD() && isApprover())
                                                                        {{-- <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="performAction('hud_approve', {{ $result->id }})"
                                                                            @if ($result->current_stage !== 'hud_verify') style="display: none !important;" @endif>

                                                                            <i
                                                                                class="bi bi-check-circle me-2 text-success"></i>
                                                                            Approve
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="showRemarksModal('hud_approve', {{ $result->id }})"
                                                                            @if ($result->current_stage !== 'hud_verify') style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                            Return with Remarks
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="showRemarksModal('hud_approve', {{ $result->id }})"
                                                                            @if ($result->current_stage !== 'hud_verify') style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-x-circle me-2 text-danger"></i>
                                                                            Reject with Remarks
                                                                        </a>
                                                                    </li> --}}

                                                                        <li>
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                                onclick="performAction('view')">
                                                                                <i class="bi bi-eye me-2 text-info"></i>
                                                                                View
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                                <a class="dropdown-item d-flex align-items-center"
                                                                                    href="#"
                                                                                    onclick="performAction('resubmit', {{ $result->id }})">
                                                                                    <i
                                                                                        class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                    Resubmit
                                                                                </a>
                                                                            @endif
                                                                        </li>
                                                                    @elseif(isVerifier() && isPHC())
                                                                        {{-- <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="performAction('phc_verify', {{ $result->id }})"
                                                                            @if (!in_array($result->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-check2-square me-2 text-primary"></i>
                                                                            Verify
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="showRemarksModal('return', {{ $result->id }})"
                                                                            @if (!in_array($result->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                            Return with Remarks
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                            @if (!in_array($result->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-x-circle me-2 text-danger"></i>
                                                                            Reject with Remarks
                                                                        </a>
                                                                    </li> --}}

                                                                        <li>
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                                onclick="performAction('view')">
                                                                                <i class="bi bi-eye me-2 text-info"></i>
                                                                                View
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                                <a class="dropdown-item d-flex align-items-center"
                                                                                    href="#"
                                                                                    onclick="performAction('resubmit', {{ $result->id }})">
                                                                                    <i
                                                                                        class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                    Resubmit
                                                                                </a>
                                                                            @endif
                                                                        </li>
                                                                    @elseif(isVerifier() && isBlock())
                                                                        {{-- <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="performAction('block_verify', {{ $result->id }})"
                                                                            @if ($result->current_stage !== 'block_upload') style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-check2-square me-2 text-primary"></i>
                                                                            Verify
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="showRemarksModal('return', {{ $result->id }})"
                                                                            @if ($result->current_stage !== 'block_upload') style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                            Return with Remarks
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                            @if ($result->current_stage !== 'block_upload') style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-x-circle me-2 text-danger"></i>
                                                                            Reject with Remarks
                                                                        </a>
                                                                    </li> --}}

                                                                        <li>
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                                onclick="performAction('view')">
                                                                                <i class="bi bi-eye me-2 text-info"></i>
                                                                                View
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                                <a class="dropdown-item d-flex align-items-center"
                                                                                    href="#"
                                                                                    onclick="performAction('resubmit', {{ $result->id }})">
                                                                                    <i
                                                                                        class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                    Resubmit
                                                                                </a>
                                                                            @endif
                                                                        </li>
                                                                    @elseif(isVerifier() && isHUD())
                                                                        {{-- <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="performAction('hud_verify', {{ $result->id }})"
                                                                            @if (!in_array($result->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-check2-square me-2 text-primary"></i>
                                                                            Verify
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="showRemarksModal('return', {{ $result->id }})"
                                                                            @if (!in_array($result->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                            Return with Remarks
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                            @if (!in_array($result->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-x-circle me-2 text-danger"></i>
                                                                            Reject with Remarks
                                                                        </a>
                                                                    </li> --}}

                                                                        <li>
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                                onclick="performAction('view')">
                                                                                <i class="bi bi-eye me-2 text-info"></i>
                                                                                View
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                                <a class="dropdown-item d-flex align-items-center"
                                                                                    href="#"
                                                                                    onclick="performAction('resubmit', {{ $result->id }})">
                                                                                    <i
                                                                                        class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                    Resubmit
                                                                                </a>
                                                                            @endif
                                                                        </li>
                                                                    @elseif(isVerifier() && isState())
                                                                        {{-- <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="performAction('state_verify', {{ $result->id }})"
                                                                            @if (!in_array($result->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-check2-square me-2 text-primary"></i>
                                                                            Verify
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="showRemarksModal('return', {{ $result->id }})"
                                                                            @if (!in_array($result->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                            Return with Remarks
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="#"
                                                                            onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                            @if (!in_array($result->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif>
                                                                            <i
                                                                                class="bi bi-x-circle me-2 text-danger"></i>
                                                                            Reject with Remarks
                                                                        </a>
                                                                    </li> --}}

                                                                        <li>
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                                onclick="performAction('view')">
                                                                                <i class="bi bi-eye me-2 text-info"></i>
                                                                                View
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                                <a class="dropdown-item d-flex align-items-center"
                                                                                    href="#"
                                                                                    onclick="performAction('resubmit', {{ $result->id }})">
                                                                                    <i
                                                                                        class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                    Resubmit
                                                                                </a>
                                                                            @endif
                                                                        </li>
                                                                    @elseif(isUser())
                                                                        <li>
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="{{ route('schemedetails.show', $result->model->id) }}">
                                                                                <i class="bi bi-eye me-2 text-info"></i>
                                                                                View
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                                <a class="dropdown-item d-flex align-items-center"
                                                                                    href="#"
                                                                                    onclick="performAction('resubmit', {{ $result->id }})">
                                                                                    <i
                                                                                        class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                    Resubmit
                                                                                </a>
                                                                            @endif
                                                                        </li>
                                                                    @endif
                                                                </ul>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <!-- Add more rows as needed -->
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center">
                                        {{ $results['paginatedResult']->links() }}
                                    </div>
                                </div>
                            </div>

                            <!-- Modal for Remarks Input -->
                            <div class="modal fade" id="remarksModal" tabindex="-1" aria-labelledby="remarksModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="remarksModalLabel">Return with Remarks</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="remarksInput" class="form-label">Remarks</label>
                                                <textarea class="form-control" id="remarksInput" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="submitRemarks()">Submit
                                                Remarks</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- pushed start -->
                            <div class="tab-pane fade mt-5" id="nav-Pushed" role="tabpanel"
                                aria-labelledby="nav-Pushed-tab">

                                <div class="table-responsive">
                                    <table class="data-table display table table-striped table-hover doc-table"
                                        style="width:100%;" data-results='@json($pushedDocs)'>
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="selectAll"
                                                        onclick="toggleSelectAll(this)"></th>
                                                <th>Scheme Name</th>
                                                <th>Uploader Name</th>
                                                <th>Processed By</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                                <th>Last Action</th>
                                                <th class="text-center" style="width: 10%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($pushedDocs['paginatedResult']->isEmpty())
                                                <tr>
                                                    <td colspan="8" class="text-center">No Schemes</td>
                                                </tr>
                                            @else
                                                @foreach ($pushedDocs['paginatedResult'] as $result)
                                                <tr>
                                                    <td><input type="checkbox"
                                                            class="form-check-input documentCheckbox"
                                                            value="{{ $result->id }}"></td>
                                                    <td><a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#approvalModa">{{ $result->model->scheme->name ?? '' }}</a>
                                                    </td>
                                                    <td>{{ $result->user->name ?? '' }}</td>
                                                    <td>{{ findProcessedBy($result->current_stage, $result->id) }}</td>
                                                    <td>
                                                        {!! getStageBadge($result->current_stage) !!}
                                                    </td>
                                                    <td>{{ $result->remarks }}</td>
                                                    <td>{{ $result->updated_at }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary dropdown-toggle"
                                                                type="button" id="actionDropdown1"
                                                                data-bs-toggle="dropdown"
                                                                aria-expanded="false">Actions</button>
                                                                <ul class="dropdown-menu dropdown-menu-end shadow-lg p-2"
                                                                aria-labelledby="actionDropdown1">
                                                                @if (isAdmin())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('publish', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_approve') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-cloud-upload me-2 text-success"></i>
                                                                        Publish
                                                                    </a>
                                                                </li> --}}
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'verified') style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li> --}}
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('verify', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'pending_verification') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li> --}}
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_approve') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_approve') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('resubmit', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'returned_with_remarks') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                        Resubmit
                                                                    </a>
                                                                </li> --}}
                                                                @elseif (isState() && isApprover())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('state_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_verify') style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif (isBlock() && isApprover())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('block_approve', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif (isHUD() && isApprover())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('hud_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'hud_verify') style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('hud_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'hud_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('hud_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'hud_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isPHC())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('phc_verify', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isBlock())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('block_verify', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'block_upload') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'block_upload') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'block_upload') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isHUD())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('hud_verify', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isState())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('state_verify', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isUser())
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @endif
                                                            </ul>

                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
                                            <!-- Additional rows as needed -->
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center">
                                        {{ $pushedDocs['paginatedResult']->links() }}
                                    </div>
                                </div>

                            </div>
                            <!-- approved end -->

                            <!-- approved start -->
                            <div class="tab-pane fade mt-5" id="nav-Approved" role="tabpanel"
                                aria-labelledby="nav-Approved-tab">

                                <div class="table-responsive">
                                    <table class="data-table display table table-striped table-hover doc-table"
                                        style="width:100%;" data-results='@json($approvedDocs)'>
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="selectAll"
                                                        onclick="toggleSelectAll(this)"></th>
                                                <th>Scheme Name</th>
                                                <th>Uploader Name</th>
                                                <th>Processed By</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                                <th>Last Action</th>
                                                <th class="text-center" style="width: 10%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($approvedDocs['paginatedResult']->isEmpty())
                                                <tr>
                                                    <td colspan="8" class="text-center">No Schemes</td>
                                                </tr>
                                            @else
                                                @foreach ($approvedDocs['paginatedResult'] as $result)
                                                <tr>
                                                    <td><input type="checkbox"
                                                            class="form-check-input documentCheckbox"
                                                            value="{{ $result->id }}"></td>
                                                    <td><a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#approvalModa">{{ $result->model->scheme->name ?? '' }}</a>
                                                    </td>
                                                    <td>{{ $result->user->name ?? '' }}</td>
                                                    <td>{{ findProcessedBy($result->current_stage, $result->id) }}</td>
                                                    <td>
                                                        {!! getStageBadge($result->current_stage) !!}
                                                    </td>
                                                    <td>{{ $result->remarks }}</td>
                                                    <td>{{ $result->updated_at }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary dropdown-toggle"
                                                                type="button" id="actionDropdown1"
                                                                data-bs-toggle="dropdown"
                                                                aria-expanded="false">Actions</button>
                                                                <ul class="dropdown-menu dropdown-menu-end shadow-lg p-2"
                                                                aria-labelledby="actionDropdown1">
                                                                @if (isAdmin())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('publish', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_approve') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-cloud-upload me-2 text-success"></i>
                                                                        Publish
                                                                    </a>
                                                                </li> --}}
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'verified') style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li> --}}
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('verify', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'pending_verification') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li> --}}
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_approve') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_approve') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('resubmit', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'returned_with_remarks') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                        Resubmit
                                                                    </a>
                                                                </li> --}}
                                                                @elseif (isState() && isApprover())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('state_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_verify') style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif (isBlock() && isApprover())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('block_approve', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif (isHUD() && isApprover())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('hud_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'hud_verify') style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('hud_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'hud_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('hud_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'hud_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isPHC())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('phc_verify', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isBlock())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('block_verify', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'block_upload') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'block_upload') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'block_upload') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isHUD())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('hud_verify', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isState())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('state_verify', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isUser())
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @endif
                                                            </ul>

                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
                                            <!-- Additional rows as needed -->
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center">
                                        {{ $approvedDocs['paginatedResult']->links() }}
                                    </div>
                                </div>

                            </div>
                            <!-- approved end -->

                            <!-- Pending start -->
                            <div class="tab-pane fade mt-5" id="nav-Pending" role="tabpanel"
                                aria-labelledby="nav-Pending-tab" tabindex="0">

                                <div class="table-responsive">
                                    <table class="data-table display table table-striped table-hover doc-table"
                                        style="width:100%;" data-results='@json($pendingDocs)'>
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="selectAll"
                                                        onclick="toggleSelectAll(this)"></th>
                                                <th>Scheme Name</th>
                                                <th>Uploader Name</th>
                                                <th>Processed By</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                                <th>Last Action</th>
                                                <th class="text-center" style="width: 10%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($pendingDocs['paginatedResult']->isEmpty())
                                                <tr>
                                                    <td colspan="8" class="text-center">No Schemes</td>
                                                </tr>
                                            @else
                                                @foreach ($pendingDocs['paginatedResult'] as $result)
                                                <tr>
                                                    <td><input type="checkbox"
                                                            class="form-check-input documentCheckbox"
                                                            value="{{ $result->id }}"></td>
                                                    <td><a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#approvalModa">{{ $result->model->scheme->name ?? '' }}</a>
                                                    </td>
                                                    <td>{{ $result->user->name ?? '' }}</td>
                                                    <td>{{ findProcessedBy($result->current_stage, $result->id) }}</td>
                                                    <td>
                                                        {!! getStageBadge($result->current_stage) !!}
                                                    </td>
                                                    <td>{{ $result->remarks }}</td>
                                                    <td>{{ $result->updated_at }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary dropdown-toggle"
                                                                type="button" id="actionDropdown1"
                                                                data-bs-toggle="dropdown"
                                                                aria-expanded="false">Actions</button>
                                                                <ul class="dropdown-menu dropdown-menu-end shadow-lg p-2"
                                                                aria-labelledby="actionDropdown1">
                                                                @if (isAdmin())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('publish', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_approve') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-cloud-upload me-2 text-success"></i>
                                                                        Publish
                                                                    </a>
                                                                </li> --}}
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'verified') style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li> --}}
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('verify', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'pending_verification') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li> --}}
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_approve') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_approve') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('resubmit', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'returned_with_remarks') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                        Resubmit
                                                                    </a>
                                                                </li> --}}
                                                                @elseif (isState() && isApprover())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('state_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_verify') style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif (isBlock() && isApprover())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('block_approve', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif (isHUD() && isApprover())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('hud_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'hud_verify') style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('hud_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'hud_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('hud_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'hud_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isPHC())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('phc_verify', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isBlock())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('block_verify', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'block_upload') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'block_upload') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'block_upload') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isHUD())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('hud_verify', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isState())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('state_verify', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isUser())
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @endif
                                                            </ul>

                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
                                            <!-- Additional rows as needed -->
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center">
                                        {{ $pendingDocs['paginatedResult']->links() }}
                                    </div>
                                </div>


                            </div>
                            <!-- Pending end -->

                            <!-- return with remarks start -->
                            <div class="tab-pane fade mt-5" id="nav-Return" role="tabpanel"
                                aria-labelledby="nav-Return-tab" tabindex="0">

                                <div class="table-responsive">
                                    <table class="data-table display table table-striped table-hover doc-table"
                                        style="width:100%;" data-results='@json($returnedDocs)'>
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="selectAll"
                                                        onclick="toggleSelectAll(this)"></th>
                                                <th>Scheme Name</th>
                                                <th>Uploader Name</th>
                                                <th>Processed By</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                                <th>Last Action</th>
                                                <th class="text-center" style="width: 10%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($returnedDocs['paginatedResult']->isEmpty())
                                                <tr>
                                                    <td colspan="8" class="text-center">No Schemes</td>
                                                </tr>
                                            @else
                                                @foreach ($returnedDocs['paginatedResult'] as $result)
                                                <tr>
                                                    <td><input type="checkbox"
                                                            class="form-check-input documentCheckbox"
                                                            value="{{ $result->id }}"></td>
                                                    <td><a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#approvalModa">{{ $result->model->scheme->name ?? '' }}</a>
                                                    </td>
                                                    <td>{{ $result->user->name ?? '' }}</td>
                                                    <td>{{ findProcessedBy($result->current_stage, $result->id) }}</td>
                                                    <td>
                                                        {!! getStageBadge($result->current_stage) !!}
                                                    </td>
                                                    <td>{{ $result->remarks }}</td>
                                                    <td>{{ $result->updated_at }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary dropdown-toggle"
                                                                type="button" id="actionDropdown1"
                                                                data-bs-toggle="dropdown"
                                                                aria-expanded="false">Actions</button>
                                                                <ul class="dropdown-menu dropdown-menu-end shadow-lg p-2"
                                                                aria-labelledby="actionDropdown1">
                                                                @if (isAdmin())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('publish', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_approve') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-cloud-upload me-2 text-success"></i>
                                                                        Publish
                                                                    </a>
                                                                </li> --}}
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'verified') style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li> --}}
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('verify', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'pending_verification') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li> --}}
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_approve') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_approve') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('resubmit', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'returned_with_remarks') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                        Resubmit
                                                                    </a>
                                                                </li> --}}
                                                                @elseif (isState() && isApprover())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('state_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_verify') style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif (isBlock() && isApprover())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('block_approve', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif (isHUD() && isApprover())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('hud_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'hud_verify') style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('hud_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'hud_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('hud_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'hud_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isPHC())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('phc_verify', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isBlock())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('block_verify', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'block_upload') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'block_upload') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'block_upload') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isHUD())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('hud_verify', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isState())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('state_verify', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isUser())
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @endif
                                                            </ul>

                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
                                            <!-- Additional rows as needed -->
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center">
                                        {{ $returnedDocs['paginatedResult']->links() }}
                                    </div>
                                </div>


                            </div>
                            <!-- return with remarks end -->

                            <!-- reject with remarks start -->
                            <div class="tab-pane fade mt-5" id="nav-Rejected" role="tabpanel"
                                aria-labelledby="nav-Rejected-tab" tabindex="0">

                                <div class="table-responsive">
                                    <table class="data-table display table table-striped table-hover doc-table"
                                        style="width:100%;" data-results='@json($rejectedDocs)'>
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="selectAll"
                                                        onclick="toggleSelectAll(this)"></th>
                                                <th>Scheme Name</th>
                                                <th>Uploader Name</th>
                                                <th>Processed By</th>
                                                <th>Status</th>
                                                <th>Reamrks</th>
                                                <th>Last Action</th>
                                                <th class="text-center" style="width: 10%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($rejectedDocs['paginatedResult']->isEmpty())
                                                <tr>
                                                    <td colspan="8" class="text-center">No Schemes</td>
                                                </tr>
                                            @else
                                                @foreach ($rejectedDocs['paginatedResult'] as $result)
                                                <tr>
                                                    <td><input type="checkbox"
                                                            class="form-check-input documentCheckbox"
                                                            value="{{ $result->id }}"></td>
                                                    <td><a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#approvalModa">{{ $result->model->scheme->name ?? '' }}</a>
                                                    </td>
                                                    <td>{{ $result->user->name ?? '' }}</td>
                                                    <td>{{ findProcessedBy($result->current_stage, $result->id) }}</td>
                                                    <td>
                                                        {!! getStageBadge($result->current_stage) !!}
                                                    </td>
                                                    <td>{{ $result->remarks }}</td>
                                                    <td>{{ $result->updated_at }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary dropdown-toggle"
                                                                type="button" id="actionDropdown1"
                                                                data-bs-toggle="dropdown"
                                                                aria-expanded="false">Actions</button>
                                                                <ul class="dropdown-menu dropdown-menu-end shadow-lg p-2"
                                                                aria-labelledby="actionDropdown1">
                                                                @if (isAdmin())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('publish', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_approve') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-cloud-upload me-2 text-success"></i>
                                                                        Publish
                                                                    </a>
                                                                </li> --}}
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'verified') style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li> --}}
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('verify', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'pending_verification') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li> --}}
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_approve') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_approve') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('resubmit', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'returned_with_remarks') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                        Resubmit
                                                                    </a>
                                                                </li> --}}
                                                                @elseif (isState() && isApprover())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('state_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_verify') style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'state_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif (isBlock() && isApprover())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('block_approve', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif (isHUD() && isApprover())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('hud_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'hud_verify') style="display: none !important;" @endif>

                                                                        <i
                                                                            class="bi bi-check-circle me-2 text-success"></i>
                                                                        Approve
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('hud_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'hud_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('hud_approve', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'hud_verify') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isPHC())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('phc_verify', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isBlock())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('block_verify', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'block_upload') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'block_upload') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if ($result->current_stage !== 'block_upload') style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isHUD())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('hud_verify', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isVerifier() && isState())
                                                                    {{-- <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="performAction('state_verify', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-check2-square me-2 text-primary"></i>
                                                                        Verify
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('return', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-arrow-return-left me-2 text-warning"></i>
                                                                        Return with Remarks
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center"
                                                                        href="#"
                                                                        onclick="showRemarksModal('reject', {{ $result->id }})"
                                                                        @if (!in_array($result->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif>
                                                                        <i
                                                                            class="bi bi-x-circle me-2 text-danger"></i>
                                                                        Reject with Remarks
                                                                    </a>
                                                                </li> --}}

                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}"
                                                                            onclick="performAction('view')">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @elseif(isUser())
                                                                    <li>
                                                                        <a class="dropdown-item d-flex align-items-center"
                                                                            href="{{ route('schemedetails.show', $result->model->id) }}">
                                                                            <i class="bi bi-eye me-2 text-info"></i>
                                                                            View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        @if ($result->current_stage === 'returned_with_remarks' && $result->uploaded_by === $userId)
                                                                            <a class="dropdown-item d-flex align-items-center"
                                                                                href="#"
                                                                                onclick="performAction('resubmit', {{ $result->id }})">
                                                                                <i
                                                                                    class="bi bi-arrow-repeat me-2 text-warning"></i>
                                                                                Resubmit
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @endif
                                                            </ul>

                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
                                            <!-- Additional rows as needed -->
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center">
                                        {{ $rejectedDocs['paginatedResult']->links() }}
                                    </div>
                                </div>
                            </div>
                            <!-- reject with remarks end -->

                            <!-- Additional rows as needed -->
                            </tbody>
                            </table>
                        </div>
                    </div>


                    <!-- Modal for approval status start -->
                    <div class="modal fade" id="approvalModa" tabindex="-1" aria-labelledby="approvalModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="approvalModalLabel">Approval Process History</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <span class="mt-5 text-center">
                                    <h5 style="color: #6c757d;">Document Name: <span
                                            style="font-weight: bold; color: #1572e8;">Document Title Here</span></h5>
                                </span>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="page-inner">
                                            <div class="container-fluid mt-0">
                                                <div class="col-lg-12"
                                                    style="background-color: #ffffff; border-radius: 10px;">
                                                    <div class="container py-0">
                                                        <div class="row">
                                                            <div class="col-md-12 col-lg-12">
                                                                <div id="tracking">
                                                                    <div class="tracking-list p-lg-5">
                                                                        <!-- Super Admin Final Approval (Muted) -->
                                                                        <div class="tracking-item final muted">
                                                                            <div class="tracking-icon status-final">
                                                                                <i class="bi bi-lock-fill"></i>
                                                                            </div>
                                                                            <div class="tracking-content">
                                                                                <p>Final Approval <span>Status</span></p>
                                                                                <div
                                                                                    class="d-flex justify-content-between">
                                                                                    <div class="tracking-user">Finalized
                                                                                        by: Super Admin</div>
                                                                                    <span class="tracking-date">Date and
                                                                                        Time</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Sub Admin Verification (Muted) -->
                                                                        <div class="tracking-item verification muted">
                                                                            <div class="tracking-icon status-verification">
                                                                                <i class="bi bi-shield-lock"></i>
                                                                            </div>
                                                                            <div class="tracking-content">
                                                                                <strong>Document Name: Document Title
                                                                                    Here</strong>
                                                                                <p>Document <span>Pending</span></p>
                                                                                <div
                                                                                    class="d-flex justify-content-between">
                                                                                    <div class="tracking-user">Verified by:
                                                                                        Sub Admin</div>
                                                                                    <span class="tracking-date">Date and
                                                                                        Time</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- State Approver Approval (Pending - Orange) -->
                                                                        <div class="tracking-item approved pending">
                                                                            <div class="tracking-icon status-approved">
                                                                                <i class="bi bi-file-earmark-check"></i>
                                                                            </div>
                                                                            <div class="tracking-content">
                                                                                <strong>Document Name: Document Title
                                                                                    Here</strong>
                                                                                <p>Document Approval <span>Verified</span>
                                                                                </p>
                                                                                <div
                                                                                    class="d-flex justify-content-between">
                                                                                    <div class="tracking-user">Pending
                                                                                        approval from: State Approver</div>
                                                                                    <span class="tracking-date">Date and
                                                                                        Time</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- State Verifier Verification -->
                                                                        <div class="tracking-item verified">
                                                                            <div class="tracking-icon status-verified">
                                                                                <i class="bi bi-check-circle"></i>
                                                                            </div>
                                                                            <div class="tracking-content">
                                                                                <strong>Document Name: Document Title
                                                                                    Here</strong>
                                                                                <p>Document <span>Verified</span></p>
                                                                                <div
                                                                                    class="d-flex justify-content-between">
                                                                                    <div class="tracking-user">Verified by:
                                                                                        State Verifier</div>
                                                                                    <span class="tracking-date">Date and
                                                                                        Time</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- HUD Approver Approval -->
                                                                        <div class="tracking-item approved">
                                                                            <div class="tracking-icon status-approved">
                                                                                <i class="bi bi-file-earmark-check"></i>
                                                                            </div>
                                                                            <div class="tracking-content">
                                                                                <strong>Document Name: Document Title
                                                                                    Here</strong>
                                                                                <p>Document <span>Approved</span></p>
                                                                                <div
                                                                                    class="d-flex justify-content-between">
                                                                                    <div class="tracking-user">Approved by:
                                                                                        HUD Approver</div>
                                                                                    <span class="tracking-date">Date and
                                                                                        Time</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- HUD Verifier Verification -->
                                                                        <div class="tracking-item verified">
                                                                            <div class="tracking-icon status-verified">
                                                                                <i class="bi bi-check-circle"></i>
                                                                            </div>
                                                                            <div class="tracking-content">
                                                                                <strong>Document Name: Document Title
                                                                                    Here</strong>
                                                                                <p>Document <span>Verified</span></p>
                                                                                <div
                                                                                    class="d-flex justify-content-between">
                                                                                    <div class="tracking-user">Verified by:
                                                                                        HUD Verifier</div>
                                                                                    <span class="tracking-date">Date and
                                                                                        Time</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Block Approver Approval -->
                                                                        <div class="tracking-item approved">
                                                                            <div class="tracking-icon status-approved">
                                                                                <i class="bi bi-file-earmark-check"></i>
                                                                            </div>
                                                                            <div class="tracking-content">
                                                                                <strong>Document Name: Document Title
                                                                                    Here</strong>
                                                                                <p>Document <span>Approved</span></p>
                                                                                <div
                                                                                    class="d-flex justify-content-between">
                                                                                    <div class="tracking-user">Approved by:
                                                                                        Block Approver</div>
                                                                                    <span class="tracking-date">Date and
                                                                                        Time</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Block Verifier Verification -->
                                                                        <div class="tracking-item verified">
                                                                            <div class="tracking-icon status-verified">
                                                                                <i class="bi bi-check-circle"></i>
                                                                            </div>
                                                                            <div class="tracking-content">
                                                                                <strong>Document Name: Document Title
                                                                                    Here</strong>
                                                                                <p>Document <span>Pending</span></p>
                                                                                <div
                                                                                    class="d-flex justify-content-between">
                                                                                    <div class="tracking-user">Verified by:
                                                                                        Block Verifier</div>
                                                                                    <span class="tracking-date">Date and
                                                                                        Time</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- PHC Verifier Verification -->
                                                                        <div class="tracking-item verified">
                                                                            <div class="tracking-icon status-verified">
                                                                                <i class="bi bi-check-circle"></i>
                                                                            </div>
                                                                            <div class="tracking-content">
                                                                                <strong>Document Name: Document Title
                                                                                    Here</strong>
                                                                                <p>Document <span>Verified</span></p>
                                                                                <div
                                                                                    class="d-flex justify-content-between">
                                                                                    <div class="tracking-user">Verified by:
                                                                                        PHC Verifier</div>
                                                                                    <span class="tracking-date">Date and
                                                                                        Time</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- HSC User Upload -->
                                                                        <div class="tracking-item pending">
                                                                            <div class="tracking-icon status-upload">
                                                                                <i class="bi bi-upload"></i>
                                                                            </div>
                                                                            <div class="tracking-content">
                                                                                <strong>Document Name: Document Title
                                                                                    Here</strong>
                                                                                <p>Document <span>Uploaded</span></p>
                                                                                <div
                                                                                    class="d-flex justify-content-between">
                                                                                    <div class="tracking-user">Uploaded by:
                                                                                        HSC User</div>
                                                                                    <span class="tracking-date">Date and
                                                                                        Time</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal for approval status end -->


                </div>
            </div>
        </div>
        <!-- forwarded end -->

    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            setPageUrl('/programs?');
        });
    </script>
    <script>
        function toggleSelectAll(selectAllCheckbox) {
            const checkboxes = document.querySelectorAll('.form-check-input');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            updateButtonLabels();
        }

        let actionType = '';
        let isBulkAction = false; // Flag to determine if it's a bulk action
        let selectedDocumentIds = []; // Stores IDs for bulk actions
        let currentDocumentId = null; // Stores the ID for single actions

        function showRemarksModal(action, documentId = null) {
            actionType = action;
            if (documentId) {
                // Single action
                isBulkAction = false;
                currentDocumentId = documentId;
            } else {
                // Bulk action
                isBulkAction = true;
                selectedDocumentIds = Array.from(document.querySelectorAll('.documentCheckbox:checked'))
                    .map(checkbox => checkbox.value);

                if (selectedDocumentIds.length === 0) {
                    alert('Please select at least one document.');
                    return;
                }
            }

            const modalLabel = document.getElementById('remarksModalLabel');
            modalLabel.textContent = action === 'return' ? 'Return with Remarks' : 'Reject with Remarks';
            const remarksInput = document.getElementById('remarksInput');
            remarksInput.value = ''; // Clear previous remarks
            const modal = new bootstrap.Modal(document.getElementById('remarksModal'));
            modal.show();
        }


        function performBulkAction(action) {
            const selectedDocuments = Array.from(document.querySelectorAll('.documentCheckbox:checked'))
                .map(checkbox => checkbox.value);
            console.log(selectedDocuments)

            if (selectedDocuments.length === 0) {
                alert('Please select at least one document.');
                return;
            }

            if (!confirm(`Are you sure you want to ${action} the selected documents?`)) {
                return;
            }

            if (action === 'publish' || action === 'approve' || action === 'verify') {

                fetch('schemedetails/bulk-action', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({
                            action,
                            documentIds: selectedDocuments
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(`${action.charAt(0).toUpperCase() + action.slice(1)} action completed successfully!`);
                            location.reload();
                        } else {
                            alert('An error occurred while performing the action.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while performing the action.');
                    });
            }
        }

        function submitBulkRemarks(remarks) {
            fetch(`{{ url('approval/schemedetails/bulk-action') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content') // CSRF token
                    },
                    body: JSON.stringify({
                        documentIds: selectedDocumentIds, // Bulk document IDs
                        action: actionType,
                        remarks: remarks
                    })
                })
                .then(response => {
                    if (response.ok) {
                        location.reload(); // Reload the page or handle the UI update
                    } else {
                        console.error('Error performing bulk action');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function submitRemarks() {
            const remarks = document.getElementById('remarksInput').value;
            if (!remarks.trim()) {
                alert('Remarks are required!');
                return;
            }

            if (isBulkAction) {
                // Bulk submission logic
                submitBulkRemarks(remarks);
            } else {
                // Single submission logic
                fetch(`{{ url('approval/schemedetails/') }}/${currentDocumentId}/${actionType}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content') // CSRF token
                        },
                        body: JSON.stringify({
                            remarks: remarks
                        })
                    })
                    .then(response => {
                        if (response.ok) {
                            location.reload(); // Reload the page or handle the UI update
                        } else {
                            console.error('Error submitting remarks');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        const checkboxes = document.querySelectorAll('.form-check-input');
        const publishBtn = document.getElementById('publishBtn');
        const approveBtn = document.getElementById('approveBtn');
        const verifyBtn = document.getElementById('verifyBtn');
        const returnBtn = document.getElementById('returnBtn');
        const rejectBtn = document.getElementById('rejectBtn');

        // Update button text with selected document count
        function updateButtonLabels() {
            const selectedCount = document.querySelectorAll('.form-check-input:checked').length;
            publishBtn.textContent = `Publish (${selectedCount})`;
            approveBtn.textContent = `Approve (${selectedCount})`;
            verifyBtn.textContent = `Verify (${selectedCount})`;
            returnBtn.textContent = `Return (${selectedCount})`;
            rejectBtn.textContent = `Reject (${selectedCount})`;
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateButtonLabels);
        });

        updateButtonLabels(); // Initial call on page load
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trackingItems = document.querySelectorAll('.tracking-item');

            trackingItems.forEach((item, index) => {
                const statusSpan = item.querySelector('.tracking-content span');
                const statusText = statusSpan ? statusSpan.textContent.trim() : '';

                if (statusText === 'Verified' || statusText === 'Approved' || statusText === 'Uploaded') {
                    // Apply styles for Verified, Approved, or Uploaded
                    item.style.borderLeft = '4px solid #00ba0d'; // Green
                    const trackingIcon = item.querySelector('.tracking-icon');
                    trackingIcon.style.backgroundColor = '#e9f8ea'; // Light green background for the icon
                    trackingIcon.style.color = '#007bff'; // Blue for icon color
                } else if (statusText === 'Pending') {
                    // Apply styles for Pending
                    item.style.borderLeft = '4px solid #f0ba09'; // Amber
                    const trackingIcon = item.querySelector('.tracking-icon');
                    trackingIcon.style.backgroundColor = '#f8eee9'; // Light amber background for the icon
                    trackingIcon.style.color = '#ffc400'; // Amber for icon color

                    // Muting all previous items
                    for (let i = 0; i < index; i++) {
                        const previousItem = trackingItems[i];
                        previousItem.classList.add('muted');
                        previousItem.style.opacity =
                            '0.5'; // Optional: reduce opacity to visually indicate muted status
                        previousItem.style.borderLeft = '4px solid #e9e5e4'; // Light gray for muted items

                        // Change icon color and background for muted items
                        const mutedIcon = previousItem.querySelector('.tracking-icon');
                        if (mutedIcon) {
                            mutedIcon.style.color = '#989695'; // Set muted icon color
                            mutedIcon.style.backgroundColor = '#d2d2d2'; // Set muted icon background color
                        }
                    }
                } else if (item.classList.contains('muted')) {
                    // Apply muted style for items that have the muted class
                    item.style.borderLeft = '4px solid #e9e5e4'; // Light gray for muted
                    const mutedIcon = item.querySelector('.tracking-icon');
                    if (mutedIcon) {
                        mutedIcon.style.color = '#989695'; // Set muted icon color
                        mutedIcon.style.backgroundColor = '#d2d2d2'; // Set muted icon background color
                    }
                } else {
                    // Apply default style for other statuses
                    item.style.borderLeft = '4px solid #f0ba09'; // Amber
                }
            });
        });


        function performAction(action, id) {
            fetch(`{{ url('approval/schemedetails/') }}/${id}/${action}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token for security
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({}),
                })
                .then(response => {
                    if (response.ok) {
                        location.reload(); // Reload the page or handle the UI update
                    } else {
                        console.error('Error approving document');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
