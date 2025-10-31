@extends('admin.layouts.layout')
@section('title', 'View Document')
@section('content')
    <!-- Modal for Remarks Input -->
    <div class="modal fade" id="remarksModal" tabindex="-1" aria-labelledby="remarksModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="remarksModalLabel">Return with Remarks</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="remarksInput" class="form-label">Remarks</label>
                        <textarea class="form-control" id="remarksInput" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitRemarks()">Submit
                        Remarks</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Documents</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Documents</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View Documents</li>
                    </ol>
                </nav>

            </div>
        </div>
        <div class="container-fluid">
            <div class="page-inner">
                <div class="container-fluid mt-2">
                    <div class="row">
                        <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                            <!-- insert the contents Here start -->

                            <div class="card-body">
                                <!-- Heading -->
                                <h4 class="card-title mb-4 text-primary">View Document Details</h4>
                                <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">

                                    <!-- Type of Document -->
                                    <div>
                                        <div class="font-weight-bold text-secondary">Type of Document:</div>
                                        <div class="border p-3 rounded bg-light">{{ $result->document_type->name ?? '' }}
                                        </div>
                                    </div>


                                    <!-- Mapping Section -->
                                    @if (!in_array($result->document_type_id, [4, 15, 7, 8, 9, 10, 11, 12, 14]))
                                        <div>
                                            <div class="font-weight-bold text-secondary">Scheme:</div>
                                            <div class="border p-3 rounded bg-light">{{ $result->scheme->name ?? '--' }}
                                            </div>
                                        </div>
                                    @endif

                                    @if ($result->scetion_id)
                                        <!-- Mapping Section -->
                                        <div>
                                            <div class="font-weight-bold text-secondary">Section:</div>
                                            <div class="border p-3 rounded bg-light">{{ $result->section->name ?? '--' }}
                                            </div>
                                        </div>
                                    @endif

                                    @if (in_array($result->document_type_id, [5]))
                                        <!-- Publication -->
                                        <div>
                                            <div class="font-weight-bold text-secondary">Publication Type:</div>
                                            <div class="border p-3 rounded bg-light">
                                                {{ $result->publication->name ?? '--' }}</div>
                                        </div>
                                    @endif

                                    @if (in_array($result->document_type_id, [12]))
                                        <!-- Notification -->
                                        <div>
                                            <div class="font-weight-bold text-secondary">Notification Type:</div>
                                            <div class="border p-3 rounded bg-light">
                                                {{ $result->notification->name ?? '--' }}</div>
                                        </div>
                                    @endif

                                    <!-- Name of Document -->
                                    <div>
                                        <div class="font-weight-bold text-secondary">Name of Document:</div>
                                        <div class="border p-3 rounded bg-light">{{ $result->name }}</div>
                                    </div>

                                    <!-- Description -->
                                    @if (!in_array($result->document_type_id, [8, 9]))
                                        <div>
                                            <div class="font-weight-bold text-secondary">Description:</div>
                                            <div class="border p-3 rounded bg-light">{{ $result->description ?? '--' }}
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Reference No. -->
                                    @if (!in_array($result->document_type_id, [8, 9, 10, 11, 12, 13, 14]))
                                        <div>
                                            <div class="font-weight-bold text-secondary">Reference No:</div>
                                            <div class="border p-3 rounded bg-light">{{ $result->reference_no ?? '--' }}
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Financial Year -->
                                    @if (in_array($result->document_type_id, [8, 9]))
                                        <div>
                                            <div class="font-weight-bold text-secondary">Financial Year:</div>
                                            <div class="border p-3 rounded bg-light">{{ $result->financial_year ?? '--' }}
                                            </div>
                                        </div>
                                    @endif

                                    {{-- File --}}
                                    @if (!in_array($result->document_type_id, [4, 15, 14]))
                                        <div>
                                            <div class="font-weight-bold text-secondary">File:</div>
                                            <div class="border p-3 rounded bg-light"><a class="text-primary"
                                                    href="{{ fileLink($result->document_url) }}" target="_blank">View</a>
                                            </div>
                                        </div>

                                        {{-- Language --}}
                                        <div>
                                            <div class="font-weight-bold text-secondary">File Language:</div>
                                            <div class="border p-3 rounded bg-light">{{ $result->language->name ?? '--' }}
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Image --}}
                                    @if (in_array($result->document_type_id, [12, 13, 14]))
                                        <div>
                                            <div class="font-weight-bold text-secondary">Image:</div>
                                            <div class="border p-3 rounded bg-light"><a class="text-primary"
                                                    href="{{ fileLink($result->image_url) }}" target="_blank">View</a>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Link Url -->
                                    @if (in_array($result->document_type_id, [5, 11, 12, 13, 14]))
                                        <div>
                                            <div class="font-weight-bold text-secondary">Link Url:</div>
                                            <div class="border p-3 rounded bg-light"><a href="{{ $result->link }}"
                                                    target="_blank">{{ $result->link ?? '--' }}</a></div>
                                        </div>

                                        <!-- Link Title -->
                                        <div>
                                            <div class="font-weight-bold text-secondary">Link Title:</div>
                                            <div class="border p-3 rounded bg-light">{{ $result->link_title ?? '--' }}
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Start Date -->
                                    @if (in_array($result->document_type_id, [13]))
                                        <div>
                                            <div class="font-weight-bold text-secondary">Start Date:</div>
                                            <div class="border p-3 rounded bg-light">{{ $result->start_date }}</div>
                                        </div>

                                        <!-- End Date -->
                                        <div>
                                            <div class="font-weight-bold text-secondary">End Date:</div>
                                            <div class="border p-3 rounded bg-light">{{ $result->end_date }}</div>
                                        </div>
                                    @endif

                                    <!-- Expiry Date -->
                                    @if (in_array($result->document_type_id, [12]))
                                        <div>
                                            <div class="font-weight-bold text-secondary">Expiry Date:</div>
                                            <div class="border p-3 rounded bg-light">{{ $result->expiry_date }}</div>
                                        </div>
                                    @endif

                                    <!-- Dated -->
                                    @if (!in_array($result->document_type_id, [8, 9, 13, 14]))
                                        <div>
                                            <div class="font-weight-bold text-secondary">Dated:</div>
                                            <div class="border p-3 rounded bg-light">{{ $result->dated }}</div>
                                        </div>
                                    @endif

                                    <!-- Uploaded By -->
                                    <div>
                                        <div class="font-weight-bold text-secondary">Uploaded By:</div>
                                        <div class="border p-3 rounded bg-light">{{ $result->user->name }}</div>
                                    </div>

                                    <!-- Created At -->
                                    <div>
                                        <div class="font-weight-bold text-secondary">Created At:</div>
                                        <div class="border p-3 rounded bg-light"> {{ dateOf($result->created_at) ?? '' }}
                                        </div>
                                    </div>



                                    <!-- Visisble to public -->
                                    <div>
                                        <div class="font-weight-bold text-secondary">Visible to Public:</div>
                                        <div class="border p-3 rounded bg-light"><span
                                                class="badge {{ $result->visible_to_public == 1 ? 'bg-success' : 'bg-danger' }} text-light">
                                                {{ $result->visible_to_public == 1 ? 'Yes' : 'No' }}</span></div>
                                    </div>
                                    <!-- Status -->
                                    <div>
                                        <div class="font-weight-bold text-secondary">Status:</div>
                                        <div class="border p-3 rounded bg-light">
                                            <span
                                                class="badge {{ $result->status == 1 ? 'bg-success' : 'bg-danger' }} text-light">
                                                {{ findStatus($result->status) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Back Button -->
                                <div class="d-flex gap-3">
                                    @if (isset($approvalResult) && $approvalResult->current_stage)
                                        @if (isAdmin())
                                            <button class="btn btn-success"
                                                @if ($approvalResult->current_stage !== 'state_approve') style="display: none !important;" @endif
                                                onclick="performAction('publish', {{ $approvalResult->id }})">Publish</button>
                                            <button class="btn btn-warning"
                                                @if ($approvalResult->current_stage !== 'state_approve') style="display: none !important;" @endif
                                                onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return
                                                with
                                                Remarks</button>
                                            <button class="btn btn-danger"
                                                @if ($approvalResult->current_stage !== 'state_approve') style="display: none !important;" @endif
                                                onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject
                                                with
                                                Remarks</button>
                                        @elseif (isState() && isApprover())
                                            <button class="btn btn-success"
                                                @if ($approvalResult->current_stage !== 'state_verify') style="display: none !important;" @endif
                                                onclick="performAction('state_approve', {{ $approvalResult->id }})">Approve</button>
                                            <button class="btn btn-warning"
                                                @if ($approvalResult->current_stage !== 'state_verify') style="display: none !important;" @endif
                                                onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return
                                                with
                                                Remarks</button>
                                            <button class="btn btn-danger"
                                                @if ($approvalResult->current_stage !== 'state_verify') style="display: none !important;" @endif
                                                onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject
                                                with
                                                Remarks</button>
                                        @elseif (isBlock() && isApprover())
                                            <button class="btn btn-success"
                                                @if (!in_array($approvalResult->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif
                                                onclick="performAction('block_approve', {{ $approvalResult->id }})">Approve</button>
                                            <button class="btn btn-warning"
                                                @if (!in_array($approvalResult->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif
                                                onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return
                                                with
                                                Remarks</button>
                                            <button class="btn btn-danger"
                                                @if (!in_array($approvalResult->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif
                                                onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject
                                                with
                                                Remarks</button>
                                        @elseif (isHUD() && isApprover())
                                            <button class="btn btn-success"
                                                @if ($approvalResult->current_stage !== 'hud_verify') style="display: none !important;" @endif
                                                onclick="performAction('hud_approve', {{ $approvalResult->id }})">Approve</button>
                                            <button class="btn btn-warning"
                                                @if ($approvalResult->current_stage !== 'hud_verify') style="display: none !important;" @endif
                                                onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return
                                                with
                                                Remarks</button>
                                            <button class="btn btn-danger"
                                                @if ($approvalResult->current_stage !== 'hud_verify') style="display: none !important;" @endif
                                                onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject
                                                with
                                                Remarks</button>
                                        @elseif(isVerifier() && isPHC())
                                            <button class="btn btn-success"
                                                @if (!in_array($approvalResult->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif
                                                onclick="performAction('phc_verify', {{ $approvalResult->id }})">Verify</button>
                                            <button class="btn btn-warning"
                                                @if (!in_array($approvalResult->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif
                                                onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return
                                                with
                                                Remarks</button>
                                            <button class="btn btn-danger"
                                                @if (!in_array($approvalResult->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif
                                                onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject
                                                with
                                                Remarks</button>
                                        @elseif(isVerifier() && isBlock())
                                            <button class="btn btn-success"
                                                @if ($approvalResult->current_stage !== 'block_upload') style="display: none !important;" @endif
                                                onclick="performAction('block_verify', {{ $approvalResult->id }})">Verify</button>
                                            <button class="btn btn-warning"
                                                @if ($approvalResult->current_stage !== 'block_upload') style="display: none !important;" @endif
                                                onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return
                                                with
                                                Remarks</button>
                                            <button class="btn btn-danger"
                                                @if ($approvalResult->current_stage !== 'block_upload') style="display: none !important;" @endif
                                                onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject
                                                with
                                                Remarks</button>
                                        @elseif(isVerifier() && isHUD())
                                            <button class="btn btn-success"
                                                @if (!in_array($approvalResult->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif
                                                onclick="performAction('hud_verify', {{ $approvalResult->id }})">Verify</button>
                                            <button class="btn btn-warning"
                                                @if (!in_array($approvalResult->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif
                                                onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return
                                                with
                                                Remarks</button>
                                            <button class="btn btn-danger"
                                                @if (!in_array($approvalResult->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif
                                                onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject
                                                with
                                                Remarks</button>
                                        @elseif(isVerifier() && isState())
                                            <button class="btn btn-success"
                                                @if (!in_array($approvalResult->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif
                                                onclick="performAction('state_verify', {{ $approvalResult->id }})">Verify</button>
                                            <button class="btn btn-warning"
                                                @if (!in_array($approvalResult->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif
                                                onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return
                                                with
                                                Remarks</button>
                                            <button class="btn btn-danger"
                                                @if (!in_array($approvalResult->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif
                                                onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject
                                                with
                                                Remarks</button>
                                        @endif
                                    @endif

                                    <a href="{{ route('new-documents.index') }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                            <!-- Edit Document Layout end -->
                            <!-- Edit Document Details End -->
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

                fetch('documents/bulk-action', {
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
            fetch(`{{ url('approval/documents/bulk-action') }}`, {
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
                fetch(`{{ url('approval/documents/') }}/${currentDocumentId}/${actionType}`, {
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
            fetch(`{{ url('approval/documents/') }}/${id}/${action}`, {
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

        // document.addEventListener('DOMContentLoaded', function() {
        //     const tableRows = document.querySelectorAll('table tbody tr');

        //     tableRows.forEach(row => {
        //         row.addEventListener('click', function() {
        //             const data = JSON.parse(this.getAttribute('data-entry'));
        //             console.log(data);
        //             document.getElementById('document-title').innerText = data.model.event.name;
        //             console.log(data.model.event.name);

        //             document.getElementById('modal-uploaded-by').innerText = 'Uploaded By: ' + data.user.name ;
        //             document.getElementById('uploaded-by-date-time').innerText = data.created_at;
        //             document.getElementById('modal-current-stage').innerText = data.current_stage;

        //             // Example for verification details
        //             const verificationDetails = document.getElementById(
        //                 'modal-verification-details');
        //             verificationDetails.innerHTML = ''; // Clear existing content

        //             // Populate list dynamically
        //             const stages = ['phc_verify_id', 'block_verify_id', 'hud_verify_id',
        //                 'state_verify_id'
        //             ];
        //             stages.forEach(stage => {
        //                 const li = document.createElement('li');
        //                 li.innerText =
        //                     `${stage.replace('_', ' ')}: ${data[stage] || 'Pending'}`;
        //                 verificationDetails.appendChild(li);
        //             });
        //         });
        //     });
        // });
    </script>
@endsection
