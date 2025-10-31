@extends('admin.layouts.layout')
@section('title', 'List Programs')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Documents</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">DPH NewsLetter</li>
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

                <!-- Filter Card -->
                <div>
                    <!-- <div class="card mb-0 mt-2">
                        <div class="card-body">
                            <form>
                                <div class="row">

                                    <div class="col">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" placeholder="Enter Title">
                                        </div>
                                    </div>

                                    
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="date" class="form-control">
                                        </div>
                                    </div>

                                    
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control">
                                                <option>Active</option>
                                                <option>Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Visible to Public</label>
                                            <select class="form-control">
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col d-flex justify-content-end align-items-center mt-2">
                                        <div class="form-group d-flex">
                                            <button type="button" class="btn btn-primary me-2"
                                                style="border-radius: 10px;">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <button type="reset" class="btn btn-secondary" style="border-radius: 10px;">
                                                <i class="fas fa-redo"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> -->

                    <!-- DataTable Start -->
                    <div class="container-fluid mt-2">
                        <div class="col-md-12 col-lg-12 mt-lg-5 mt-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Newsletters</h4>
                                        <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="tooltip"
                                            title="Add" onclick="window.location.href='{{ route('dph-newsletter.create') }}'">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        <!-- <button class="btn btn-secondary btn-round ms-2" data-bs-toggle="tooltip"
                                            title="Download">
                                            <i class="fa fa-download"></i>
                                        </button> -->
                                    </div>
                                </div>

                                <!-- Table Card -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="add-row" class="display table table-striped table-hover"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th class="text-center" style="width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($results as $result)
                                                    <tr>
                                                        <td>{{ $result->name ?? '' }}</td>
                                                        <td>{{ $result->date ?? '' }}</td>
                                                        @if (isset($result->status) && $result->status == 1)
                                                            <td class="text-success" style="font-weight: bold;">Active</td>
                                                        @else
                                                            <td class="text-danger" style="font-weight: bold;">In-Active
                                                            </td>
                                                        @endif
                                                        <td>
                                                            <div class="form-button-action">
                                                                <button type="button"
                                                                    class="btn btn-link btn-primary btn-lg"
                                                                    data-bs-toggle="tooltip" title="Edit"
                                                                    onclick="window.location.href='{{route('dph-newsletter.edit', $result->id)}}'">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-link btn-danger"
                                                                    data-bs-toggle="tooltip" title="View"
                                                                    onclick="window.location.href='{{route('dph-newsletter.show', $result->id)}}'">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <!-- More rows as needed -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DataTable End -->
                </div>
            </div>
        </div>










        <!-- content end here -->








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
