@extends('admin.layouts.layout')
@section('title', 'List Scheme Details')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">List Scheme Details</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List Scheme Details</li>
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
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <h4 class="card-title mb-2 mb-md-0">Schemes</h4>
                                <div class="d-flex gap-2">
                                    @if ($user_detail->user_type_id == '7')
                                    <button class="btn btn-success" onclick="window.location.href='{{ route('schemesdetail.export') }}';">
                                        Download
                                    </button>
                                    @endif
                                    <button class="btn btn-primary btn-round" onclick="window.location.href='{{ route('schemedetails.create') }}';">
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
                                            <th>Scheme</th>
                                            <th>Program & Divisions</th>
                                            <th>Status</th>
                                            <th class="text-center" style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($results as $result)
                                            <!-- Example Row -->
                                            <tr>
                                                <td>{{ $result->id ?? '' }}</td>
                                                <td>{{ $result->scheme->name ?? '' }}</td>
                                                <td>{{ optional($result->scheme->program)->name ?? '' }}</td>
                                                <td style="font-weight: bold;">
                                                    @if (isset($result->status) && $result->status == 1)
                                                        <span class="text-success">Active</span>
                                                    @else
                                                        <span class="text-danger">In-Active</span>
                                                    @endif
                                                </td>
                                                </td>
                                                <td>
                                                    <div class="form-button-action">
                                                        @if (
                                                            ($user_detail->user_type_id == '7') || 
                                                            ($result->approvalWorkflow && $result->approvalWorkflow->current_stage !== 'published' && $result->approvalWorkflow->uploaded_by !== $user_detail->id) ||
                                                            ($result->approvalWorkflow && $result->approvalWorkflow->current_stage == 'returned_with_remarks' && $result->approvalWorkflow->uploaded_by == $user_detail->id)
                                                        )
                                                        <button type="button" class="btn btn-link btn-primary btn-lg"
                                                            onclick="window.location.href='{{ route('schemedetails.edit', $result->id) }}';"
                                                            data-bs-toggle="tooltip" title="Edit">
                                                            <i class="fa fa-edit" title="Edit"></i>
                                                        </button>
                                                        @endif
                                                        <button type="button" class="btn btn-link btn-danger"
                                                            onclick="window.location.href='{{ route('schemedetails.show', $result->id) }}';"
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
            setPageUrl('/facilitytypes?');
        });
    </script>
@endsection
