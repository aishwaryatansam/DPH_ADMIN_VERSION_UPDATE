@extends('admin.layouts.layout')
@section('title', 'View Programs')
@section('content')
    <div class="container" id="maincontent">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">View Program & Divisions</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Program & Divisions View</li>
                    </ol>
                </nav>

            </div>
        </div>

        <div class="container-fluid">
            <div class="page-inner">
                <div class="container mt-2">
                    <!-- insert the contents Here start -->

                    <div class="col-md-12 col-lg-12 p-3">
                        <div class="card border-primary shadow-sm">
                            <div class="card-body">
                                <!-- Heading -->
                                <h4 class="card-title mb-4 text-primary">View Program & Divisions</h4>

                                <!-- Row for Program Title -->
                                <div class="row mb-3 p-3">
                                    <div class="col-md-2 font-weight-bold text-secondary">Program Title:</div>
                                    <div class="col-md-8 border p-3 rounded bg-light">
                                        {{ $result->program->name }}
                                    </div>
                                </div>

                                <!-- Row for Description -->
                                <div class="row mb-3 p-3">
                                    <div class="col-md-2 font-weight-bold text-secondary">Description:</div>
                                    <div class="col-md-8 border p-3 rounded bg-light">
                                        {!! $result->description !!}
                                    </div>
                                </div>

                                <!-- Row for Uploaded Document Name -->
                                <div class="row mb-3 p-3">
                                    <div class="col-md-2 font-weight-bold text-secondary">Uploaded Document Name:</div>
                                    <div class="col-md-8 border p-3 rounded bg-light">
                                        {{ $result->document }}
                                    </div>
                                    <div class="col-md-3">
                                        <!-- Use an anchor tag with the download attribute for downloading -->
                                        <a href="{{ filelink($result->document) }}" target="_blank"
                                            class="btn btn-primary">View Document</a>
                                    </div>
                                </div>



                                <!-- Row for Related Images -->
                                <div class="row mb-3 p-3">
                                    <div class="col-md-2 font-weight-bold text-secondary">Related Images:</div>
                                    <div class="col-md-8 d-flex flex-wrap gap-3">
                                        @if ($result->image_one)
                                            <img src="{{ filelink($result->image_one) }}" alt="Related Image 1"
                                                class="img-fluid rounded" style="max-width: 100px; object-fit: cover;">
                                        @endif

                                        @if ($result->image_two)
                                            <img src="{{ filelink($result->image_two) }}" alt="Related Image 2"
                                                class="img-fluid rounded" style="max-width: 100px; object-fit: cover;">
                                        @endif

                                        @if ($result->image_three)
                                            <img src="{{ filelink($result->image_three) }}" alt="Related Image 3"
                                                class="img-fluid rounded" style="max-width: 100px; object-fit: cover;">
                                        @endif

                                        @if ($result->image_four)
                                            <img src="{{ filelink($result->image_four) }}" alt="Related Image 4"
                                                class="img-fluid rounded" style="max-width: 100px; object-fit: cover;">
                                        @endif

                                        @if ($result->image_five)
                                            <img src="{{ filelink($result->image_five) }}" alt="Related Image 5"
                                                class="img-fluid rounded" style="max-width: 100px; object-fit: cover;">
                                        @endif
                                    </div>
                                </div>

                                <!-- Row for Status -->
                                <div class="row mb-3 p-3">
                                    <div class="col-md-2 font-weight-bold text-secondary">Status:</div>
                                    <div class="col-md-8">
                                       <span class="badge {{ $result->status == 1 ? 'bg-success' : 'bg-danger' }} text-light"> {{ $result->status == 1 ? 'Active' : 'Inactive' }}</span>
                                    </div>
                                </div>

                                <div class="row">
                                 @foreach($officers as $officer)
                                     <div class="col-md-6 col-lg-4 mb-4">
                                         <div class="card border-primary shadow-sm">
                                             <div class="card-body">
                             
                                                 <!-- Official Image -->
                                                 <img src="{{ fileLink($officer->image) }}" alt="{{ $officer->name }}" class="img-fluid rounded mb-3"
                                                     style="max-height: 150px; max-width: 150px; object-fit: cover;">
                                                 <!-- Official Name -->
                                                 <h5 class="card-title">{{ $officer->name }}</h5>
                                                 <!-- Qualification -->
                                                 <p><strong>Qualification:</strong> {{ $officer->qualification }}</p>
                                                 <!-- Designation -->
                                                 <p><strong>Designation:</strong> {{ $officer->designation->name }}</p>
                                                 <!-- Status -->
                                                 <p><strong>Status:</strong> <span class="badge {{ $officer->status === 1 ? 'bg-success' : 'bg-danger' }}">
                                                     {{ $officer->status === 1 ? 'Active' : 'Inactive' }}</span></p>
                                             </div>
                                         </div>
                                     </div>
                                 @endforeach
                             
                                 <!-- Add more official cards as needed -->
                             </div>
                             
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

                                <a href="{{ route('programdetails.index') }}" class="btn btn-secondary">Back</a>
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

                fetch('programdetails/bulk-action', {
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
            fetch(`{{ url('approval/programdetails/bulk-action') }}`, {
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
                fetch(`{{ url('approval/programdetails/') }}/${currentDocumentId}/${actionType}`, {
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
            fetch(`{{ url('approval/programdetails/') }}/${id}/${action}`, {
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
