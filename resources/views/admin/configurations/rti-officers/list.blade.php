@extends('admin.layouts.layout')
@section('title', 'List Rti Officers')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">List of Rti Officers</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List Rti Officers</li>
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
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">RTI Officers</h4>
                                <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                    data-bs-target="#addRowModal"
                                    onclick="window.location.href='{{ route('rti-officer.create') }}';">
                                    <i class="fa fa-plus"></i> Add Rti Officers
                                </button>
                                <button class="btn btn-secondary btn-round ms-2" data-bs-toggle="modal" data-bs-target="#uploadPdfModal">
                                    <i class="fa fa-upload"></i> Upload PDF
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Name</th>
                                            <th>E-mail ID</th>
                                            <th>Mobile Number</th>
                                            <th>Status</th>
                                            <th class="text-center" style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($results as $result)
                                            <tr>
                                                <td>{{ $result->title ?? '' }}</td>
                                                <td>{{ $result->name ?? '' }}</td>
                                                <td>{{ $result->email ?? '' }}</td>
                                                <td>{{ $result->mobile_number ?? '' }}</td>
                                                <td style="font-weight: bold;">
                                                    @if (isset($result->status) && $result->status == 1)
                                                        <span class="text-success">Active</span>
                                                    @else
                                                        <span class="text-danger">In-Active</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-button-action">
                                                        <button type="button" class="btn btn-link btn-primary btn-lg"
                                                            onclick="window.location.href='{{ route('rti-officer.edit', $result->id) }}';"
                                                            data-bs-toggle="tooltip" title="Edit RTI Officer">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-link btn-danger"
                                                            onclick="window.location.href='{{ route('rti-officer.show', $result->id) }}';"
                                                            data-bs-toggle="tooltip" title="View RTI Officer">
                                                            <i class="fa fa-eye"></i>
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

                <!-- New Table for Uploaded PDFs -->
                <div class="col-md-12 col-lg-12 mt-5">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Uploaded RTI PDFs</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>File Name</th>
                                            <th>File Path</th>
                                            <th>Upload Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pdfs as $pdf)
                                            <tr>
                                                <td>{{ $pdf->file_name ?? '' }}</td>
                                                <td>{{ $pdf->file_path ?? '' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($pdf->upload_date)->format('d-m-Y') ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for PDF Upload -->
    <div class="modal fade" id="uploadPdfModal" tabindex="-1" aria-labelledby="uploadPdfModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadPdfModalLabel">Upload RTI Contact PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rti-contact-pdf') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="pdf_file" class="form-label">Select PDF</label>
                            <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept=".pdf" required>
                        </div>
                        <div class="mb-3">
                            <label for="upload_date" class="form-label">Upload Date</label>
                            <input type="date" class="form-control" id="upload_date" name="upload_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Upload</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
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
@endsection
