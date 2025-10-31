@extends('admin.layouts.layout')
@section('title', 'List Programs')
@section('content')
<style>
    .buttons{
        display: flex;
        flex-direction: row;

    }
</style>
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">List of Program & Divisions</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List Program & Divisions</li>
                    </ol>
                </nav>

            </div>
        </div>

        <div class="container-fluid">
            <div class="page-inner mt-2">
                <!-- Table and Add Row Button -->
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                                <h4 class="card-title mb-2 mb-md-0">Program & Divisions</h4>
                                <div class="buttons d-flex flex-column flex-sm-row gap-2">
                                    @if ($user_detail->user_type_id == '7')
                                    <button class="btn btn-success w-100 w-sm-auto" onclick="window.location.href='{{ route('programsdetail.export')}}';">
                                        Download
                                    </button>
                                    @endif
                                    <button class="btn btn-primary btn-round w-100 w-sm-auto" onclick="window.location.href='{{ route('programdetails.create') }}';">
                                        <i class="fa fa-plus"></i> Create
                                    </button>
                                </div>
                            </div>
                            

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Program Title</th>
                                            <th>Status</th>
                                            <th class="text-center" style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($results as $result)
                                            <!-- Example Row -->
                                            <tr>
                                                <td>{{ $result->id ?? '' }}</td>
                                                <td>{{ $result->program->name ?? '' }}</td>
                                                <td style="font-weight: bold;">
                                                    @if (isset($result->status) && $result->status == 1)
                                                        <span class="text-success">Active</span>
                                                    @else
                                                        <span class="text-danger">In-Active</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-button-action">
                                                        @if (
                                                            ($user_detail->user_type_id == '7') || 
                                                            ($result->approvalWorkflow && $result->approvalWorkflow->current_stage !== 'published' && $result->approvalWorkflow->uploaded_by !== $user_detail->id)||
                                                            ($result->approvalWorkflow && $result->approvalWorkflow->current_stage == 'returned_with_remarks' && $result->approvalWorkflow->uploaded_by === $user_detail->id)
                                                        )
                                                        <button type="button" class="btn btn-link btn-primary btn-lg"
                                                            onclick="window.location.href='{{ route('programdetails.edit', $result->id) }}';"
                                                            data-bs-toggle="tooltip" title="Edit">
                                                            <i class="fa fa-edit" title="Edit"></i>
                                                        </button>
                                                        @endif
                                                        <button type="button" class="btn btn-link btn-danger"
                                                            onclick="window.location.href='{{ route('programdetails.show', $result->id) }}';"
                                                            data-bs-toggle="tooltip" title="View">
                                                            <i class="fa fa-eye" title="View"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach


                                        <!-- Add more rows as needed -->
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                    <!-- Table and Add Row Button end -->
                </div>
            </div>
        </div>


        <!-- officials start -->
        {{-- <div class="container-fluid">
            <div class="page-inner mt-2">
                <!-- Officers Table and Add Button -->
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Officers</h4>
                                <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                    data-bs-target="#addOfficialModal">
                                    <i class="fa fa-plus"></i> Add Official
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%;">Name</th>
                                            <th style="width: 20%;">Qualification</th>
                                            <th style="width: 20%;">Designation</th>
                                            <th style="width: 15%;">Image</th>
                                            <th style="width: 15%;">Status</th>
                                            <th style="width: 10%;" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="officialsTableBody">
                                        @foreach ($programofficers as $result)
                                            <!-- Example Officer Row -->
                                            <tr>
                                                <td>{{ $result->name ?? '' }}</td>
                                                <td>{{ $result->qualification ?? '' }}</td>
                                                <td>{{ $result->designation->name ?? '' }}</td>
                                                <td class="text-center">
                                                    <!-- Image Preview Button -->
                                                    <button type="button" class="btn btn-link btn-primary"
                                                        data-bs-toggle="modal" data-bs-target="#imagePreviewModal"
                                                        onclick="showImagePreview('{{ fileLink($result->image) }}')">
                                                        <img src="{{ fileLink($result->image) }}" alt="Official Image"
                                                            style="max-width: 100px;" />
                                                    </button>
                                                </td>
                                                <td class="text-success" style="font-weight: bold;">
                                                    @if (isset($result->status) && $result->status == 1)
                                                        <span class="text-success">Active</span>
                                                    @else
                                                        <span class="text-danger">In-Active</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <!-- Action buttons -->
                                                    <div class="form-button-action">
                                                        <button type="button" class="btn btn-link btn-primary"
                                                            data-bs-toggle="modal" data-bs-target="#editOfficialModal"
                                                            onclick="editOfficer('{{ $result->id }}', '{{ $result->name }}', '{{ $result->link }}', '{{ $result->status }}')">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- officials end -->


        <!-- Add Official Modal -->
        <div class="modal fade" id="addOfficialModal" tabindex="-1" aria-labelledby="addOfficialModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addOfficialModalLabel">Add
                            Officers</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>


                    <div class="modal-body">
                        <form id="addOfficialForm">
                            <!-- Program & Division Dropdown -->
                            <div class="mb-3">
                                <label for="mainmenu" class="form-label">Program
                                    Title<span style="color: red;">*</span></label>
                                <select class="form-select" id="mainmenu" required>
                                    <option value="" disabled selected>Select
                                        Program Title</option>
                                    <option value="administration">Administration
                                    </option>
                                    <option value="primaryhealthcentre">Primary
                                        Health Centre</option>
                                    <option value="maternalchildhealth">Maternal
                                        Child Health</option>
                                </select>
                            </div>

                            <!-- Name Field -->
                            <div class="mb-3">
                                <label for="officialName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="officialName"
                                    placeholder="Enter official's name" required>
                            </div>


                            <!-- Qualification Field -->
                            <div class="mb-3">
                                <label for="officialQualification" class="form-label">Qualification</label>
                                <input type="text" class="form-control" id="officialQualification"
                                    placeholder="Enter qualification" required>
                            </div>

                            <!-- Designation Field -->
                            <div class="mb-3">
                                <label for="officialDesignation" class="form-label">Designation</label>
                                <input type="text" class="form-control" id="officialDesignation"
                                    placeholder="Enter designation" required>
                            </div>

                            <!-- Image Upload with Preview -->
                            <div class="mb-3">
                                <label for="officialImage" class="form-label">Image</label>
                                <input type="file" class="form-control" id="officialImage" accept="image/*"
                                    onchange="previewImage(event)">
                                <img id="imagePreview" src="#" alt="Image Preview"
                                    style="display:none; max-width: 100px; margin-top: 10px;" />
                                <small class="sizeoftextred">Accepted formats: .png, Max size:
                                    5MB</small>
                            </div>

                            <!-- Status Toggle -->
                            <div class="mb-3">
                                <label for="officialStatus" class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" onclick="" type="checkbox" id="officialStatus"
                                        checked>
                                    <label class="form-check-label" for="officialStatus">Active</label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-danger" onclick="history.back()" style="margin-left: 10px;">
                                Cancel
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Image Preview -->
        <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imagePreviewModalLabel">Image
                            Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="#" alt="Preview Image" style="max-width: 100%;" />
                    </div>
                    <small class="sizeoftextred">Accepted formats: .png, Max size:
                        5MB</small>
                </div>
            </div>
        </div>

        <!-- Edit Official Modal -->
        <div class="modal fade" id="editOfficialModal" tabindex="-1" aria-labelledby="editOfficialModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editOfficialModalLabel">Edit
                            Official</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editOfficialForm">
                            <!-- Name Field -->
                            <div class="mb-3">
                                <label for="editOfficialName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="editOfficialName" required>
                            </div>

                            <!-- Qualification Field -->
                            <div class="mb-3">
                                <label for="editOfficialQualification" class="form-label">Qualification</label>
                                <input type="text" class="form-control" id="editOfficialQualification" required>
                            </div>

                            <!-- Designation Field -->
                            <div class="mb-3">
                                <label for="editOfficialDesignation" class="form-label">Designation</label>
                                <input type="text" class="form-control" id="editOfficialDesignation" required>
                            </div>

                            <!-- Image Upload with Preview -->
                            <div class="mb-3">
                                <label for="editOfficialImage" class="form-label">Image</label>
                                <input type="file" class="form-control" id="editOfficialImage" accept="image/*"
                                    onchange="previewImage(event, 'editImagePreview')">
                                <small class="sizeoftextred">Accepted formats: .png, Max size:
                                    5MB</small>
                                <img id="editImagePreview" src="#" alt="Image Preview"
                                    style="display:none; max-width: 100px; margin-top: 10px;" />

                            </div>

                            <!-- Status Toggle -->
                            <div class="mb-3">
                                <label for="editOfficialStatus" onclick="toggleEditStatusText(this)"
                                    class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="editOfficialStatus">
                                    <label class="form-check-label" for="editOfficialStatus">Active</label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Save
                                Changes
                            </button>
                            <button type="button" class="btn btn-danger" onclick="history.back()" style="margin-left: 10px;">
                                Cancel
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Officials Section End ==================================================================================================================================-->



        <!-- main panel end -->
    </div>
    <script>
        $(document).ready(function() {
            var tableData = @json($results);
            if (tableData.length > 0) {
                $('#add-row').DataTable({
                    "paging": true,
                    "searching": true,
                    "lengthChange": true,
                    "pageLength": 10,
                    "info": true,
                    "autoWidth": false,
                });
            } else {
                $('#add-row').DataTable({
                    "data": [],
                    "paging": true,
                    "searching": true,
                    "lengthChange": true,
                    "pageLength": 10,
                    "info": true,
                    "autoWidth": false
                });
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            setPageUrl('/programs?');
        });
    </script>
    <script>
        function showImagePreview(imagePath) {
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imagePath;
        }

        function editOfficer(name, qualification, designation, imagePath, isActive) {
            document.getElementById('editOfficialName').value = name;
            document.getElementById('editOfficialQualification').value = qualification;
            document.getElementById('editOfficialDesignation').value = designation;
            document.getElementById('editImagePreview').src = imagePath;
            document.getElementById('editImagePreview').style.display = 'block';
            $('#editOfficialModal').modal('show');
        }   

        function previewImage(event, previewId = 'imagePreview') {
            const input = event.target;
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
