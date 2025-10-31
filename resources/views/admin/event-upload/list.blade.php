@extends('admin.layouts.layout')
@section('title', 'List Documents')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Uplaod Events</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Documents</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                                All Uploaded Events
                        </li>
                    </ol>
                </nav>

            </div>
        </div>
        <div class="container-fluid">
            <div class="page-inner">
                <!-- insert the contents Here start -->

                <!-- Filter Card -->
                <div>
                    <div class="card mb-0 mt-2">
                        {{-- <div class="card-body">
                        </div> --}}
                    </div>

                    <!-- DataTable Start -->
                    <div class="container-fluid mt-2">
                        <div class="col-md-12 col-lg-12 mt-lg-5 mt-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">
                                            All Uploaded Events
                                        </h4>
                                        <button class="btn btn-primary btn-round ms-auto"
                                            onclick="window.location.href='{{ route('event-upload.create') }}'">
                                            <i class="fa fa-plus"></i>
                                            Upload Events Data
                                        </button>
                                    </div>
                                </div>

                                <!-- Table Card -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="add-row" class="display table table-striped table-hover"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Uploaded Date</th>
                                                    <th>Approval Status</th>
                                                    <th>Public Status</th>
                                                    <th class="text-center" style="width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($results as $result)
                                                    <tr>
                                                        <td>{{ $result->event->name ?? '--' }}</td>
                                                        <td>{{ $result->created_at ?? '--' }}</td>
                                                        <td>
                                                            {!! getStageBadge($result->approvalWorkflow->current_stage ?? '') !!}
                                                        </td>
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
                                                                    ($result->approvalWorkflow && $result->approvalWorkflow->current_stage !== 'published' && $result->approvalWorkflow->uploaded_by !== $user_detail->id)
                                                                )
                                                                <button type="button" data-bs-toggle="tooltip"
                                                                    title="" class="btn btn-link btn-primary btn-lg"
                                                                    data-original-title="Edit Task"
                                                                    onclick="window.location.href='{{ route('event-upload.edit', $result->id) }}'"
                                                                    @if ($result->approval_stage !== 'returned_with_remarks') style="display: none !important;" @endif>
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                                @endif
                                                                <button type="button" class="btn btn-link btn-danger"
                                                                    onclick="window.location.href='{{route('event-upload.show',$result->id)}}'">
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


                    <!-- insert the contents Here end -->
                </div>
            </div>
        </div>
        <!-- content end here -->

    </div>
    <!-- script for the search and show entries start -->
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
            setPageUrl('/new-documents?');
        });
    </script>
@endsection
