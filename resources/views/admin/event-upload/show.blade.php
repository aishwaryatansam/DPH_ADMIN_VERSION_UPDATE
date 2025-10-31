@extends('admin.layouts.layout')
@section('title', 'View Document')
@section('content')
    <style>
        .readonly {
            pointer-events: none;
            background-color: #e9ecef;
        }

        .img-thumbs {
            background: #eee;
            border: 1px solid #ccc;
            border-radius: 0.25rem;
            margin: 1.5rem 0;
            padding: 0.75rem;
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
    </style>


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
                        <li class="breadcrumb-item"><a href="#">Events</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View Event Details</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container-fluid">
            <div class="page-inner">
                <div class="container mt-2">
                    <div class="row">
                        <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                            <h4 class="card-title mb-4 text-primary">View Event Details</h4>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="col-12 col-md-3">
                                            <label for="eventType" class="form-label">Event</label>
                                        </td>
                                        <td class="col-12 col-md-9">
                                            <input type="text" class="form-control readonly"
                                                value="{{ $result->event->name }}" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="existingImages" class="form-label">Existing Images</label>
                                        </td>
                                        <td>
                                            @if (!empty($images) && count($images) > 0)
                                                <div class="img-thumbs">
                                                    @foreach ($images as $image)
                                                        <div class="wrapper-thumb">
                                                            <img src="{{ fileLink($image->image_url) }}"
                                                                class="img-preview-thumb" alt="Image">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="mt-2 text-muted">No images uploaded yet.</p>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="createDocument" class="form-label">Uploaded File</label>
                                        </td>
                                        <td>
                                            @if ($result->document_url)
                                                <a href="{{ filelink($result->document_url) }}" target="_blank"
                                                    class="btn btn-info btn-sm">
                                                    View Document
                                                </a>
                                            @else
                                                <p class="mt-2 text-muted">No file uploaded.</p>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="fileName" class="form-label">Video URL</label>
                                        </td>
                                        <td>
                                            @if ($result->video_url)
                                                <a href="{{ $result->video_url }}"
                                                    target="_blank">{{ $result->video_url }}</a>
                                            @else
                                                <p class="mt-2 text-muted">No video URL provided.</p>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="status" class="form-label">Status</label>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control readonly"
                                                value="{{ $result->status == 1 ? 'Active' : 'In-Active' }}" readonly>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="mt-4">
                                <h5 class="mb-3">Actions</h5>
                                <div class="d-flex gap-3">
                                    @if (isAdmin())
                                        <button class="btn btn-success"
                                            @if ($approvalResult->current_stage !== 'state_approve') style="display: none !important;" @endif
                                            onclick="performAction('publish', {{ $approvalResult->id }})">Publish</button>
                                        <button class="btn btn-warning"
                                            @if ($approvalResult->current_stage !== 'state_approve') style="display: none !important;" @endif
                                            onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return with
                                            Remarks</button>
                                        <button class="btn btn-danger"
                                            @if ($approvalResult->current_stage !== 'state_approve') style="display: none !important;" @endif
                                            onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject with
                                            Remarks</button>
                                    @elseif (isState() && isApprover())
                                        <button class="btn btn-success"
                                            @if ($approvalResult->current_stage !== 'state_verify') style="display: none !important;" @endif
                                            onclick="performAction('state_approve', {{ $approvalResult->id }})">Approve</button>
                                        <button class="btn btn-warning"
                                            @if ($approvalResult->current_stage !== 'state_verify') style="display: none !important;" @endif
                                            onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return with
                                            Remarks</button>
                                        <button class="btn btn-danger"
                                            @if ($approvalResult->current_stage !== 'state_verify') style="display: none !important;" @endif
                                            onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject with
                                            Remarks</button>
                                    @elseif (isBlock() && isApprover())
                                        <button class="btn btn-success"
                                            @if (!in_array($approvalResult->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif
                                            onclick="performAction('block_approve', {{ $approvalResult->id }})">Approve</button>
                                        <button class="btn btn-warning"
                                            @if (!in_array($approvalResult->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif
                                            onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return with
                                            Remarks</button>
                                        <button class="btn btn-danger"
                                            @if (!in_array($approvalResult->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif
                                            onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject with
                                            Remarks</button>
                                    @elseif (isHUD() && isApprover())
                                        <button class="btn btn-success"
                                            @if ($approvalResult->current_stage !== 'hud_verify') style="display: none !important;" @endif
                                            onclick="performAction('hud_approve', {{ $approvalResult->id }})">Approve</button>
                                        <button class="btn btn-warning"
                                            @if ($approvalResult->current_stage !== 'hud_verify') style="display: none !important;" @endif
                                            onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return with
                                            Remarks</button>
                                        <button class="btn btn-danger"
                                            @if ($approvalResult->current_stage !== 'hud_verify') style="display: none !important;" @endif
                                            onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject with
                                            Remarks</button>
                                    @elseif(isVerifier() && isPHC())
                                        <button class="btn btn-success"
                                            @if (!in_array($approvalResult->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif
                                            onclick="performAction('phc_verify', {{ $approvalResult->id }})">Verify</button>
                                        <button class="btn btn-warning"
                                            @if (!in_array($approvalResult->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif
                                            onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return with
                                            Remarks</button>
                                        <button class="btn btn-danger"
                                            @if (!in_array($approvalResult->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif
                                            onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject with
                                            Remarks</button>
                                    @elseif(isVerifier() && isBlock())
                                        <button class="btn btn-success"
                                            @if ($approvalResult->current_stage !== 'block_upload') style="display: none !important;" @endif
                                            onclick="performAction('block_verify', {{ $approvalResult->id }})">Verify</button>
                                        <button class="btn btn-warning"
                                            @if ($approvalResult->current_stage !== 'block_upload') style="display: none !important;" @endif
                                            onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return with
                                            Remarks</button>
                                        <button class="btn btn-danger"
                                            @if ($approvalResult->current_stage !== 'block_upload') style="display: none !important;" @endif
                                            onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject with
                                            Remarks</button>
                                    @elseif(isVerifier() && isHUD())
                                        <button class="btn btn-success"
                                            @if (!in_array($approvalResult->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif
                                            onclick="performAction('hud_verify', {{ $approvalResult->id }})">Verify</button>
                                        <button class="btn btn-warning"
                                            @if (!in_array($approvalResult->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif
                                            onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return with
                                            Remarks</button>
                                        <button class="btn btn-danger"
                                            @if (!in_array($approvalResult->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif
                                            onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject with
                                            Remarks</button>
                                    @elseif(isVerifier() && isState())
                                        <button class="btn btn-success"
                                            @if (!in_array($approvalResult->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif
                                            onclick="performAction('state_verify', {{ $approvalResult->id }})">Verify</button>
                                        <button class="btn btn-warning"
                                            @if (!in_array($approvalResult->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif
                                            onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return with
                                            Remarks</button>
                                        <button class="btn btn-danger"
                                            @if (!in_array($approvalResult->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif
                                            onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject with
                                            Remarks</button>
                                    @endif
                                    <a href="{{ route('event-upload.index') }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

                fetch('uploadevent/bulk-action', {
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
            fetch(`{{ url('approval/uploadevent/bulk-action') }}`, {
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
                fetch(`{{ url('approval/uploadevent/') }}/${currentDocumentId}/${actionType}`, {
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
            fetch(`{{ url('approval/uploadevent/') }}/${id}/${action}`, {
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
