@extends('admin.layouts.layout')
@section('title', 'List Director Message')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">List of Welcome Banners</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List Welcome Banners</li>
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
                                <h4 class="card-title">Welcome Banners</h4>
                                <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                    data-bs-target="#addRowModal"
                                    onclick="window.location.href='{{ route('welcome-banner.create') }}';">
                                    <i class="fa fa-plus"></i> Add Welcome Banner
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Link</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th class="text-center" style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($results as $result)
                                            <!-- Example Rows -->
                                            <tr>
                                                <td>{{ $result->name ?? '' }}</td>
                                                <td>
                                                    <a href="{{ $result->link ?? '' }}"
                                                        target="_blank">{{ $result->link ?? '' }}</a>
                                                </td>
                                                <td>
                                                    <!-- Assuming the Logo is an image, adjust the src attribute as needed -->
                                                    <img src="{{ fileLink($result->image_url) }}" alt="Logo"
                                                        style="max-width: 100px;">
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
                                                        <button type="button" class="btn btn-link btn-primary btn-lg"
                                                            onclick="window.location.href='{{ route('welcome-banner.edit', $result->id) }}';"
                                                            data-bs-toggle="tooltip" title="Edit Partner Logo">
                                                            <i class="fa fa-edit" title="Edit Partner Logo"></i>
                                                        </button>
                                                        {{-- <button type="button" class="btn btn-link btn-danger"
                                                            onclick="window.location.href='Partnerlogos_view.html';"
                                                            data-bs-toggle="tooltip" title="View Partner Logo">
                                                            <i class="fa fa-eye" title="View Partner Logo"></i>
                                                        </button> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Additional rows can be added dynamically -->
                                            @endforeach
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
@endsection
