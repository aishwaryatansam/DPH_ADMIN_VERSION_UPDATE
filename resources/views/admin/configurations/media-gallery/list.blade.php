@extends('admin.layouts.layout')
@section('title', 'List Media Gallery')
@section('content')
<div class="container" style="margin-top: 90px;">
    <div class="container-fluid p-2" style="background-color: #f2f2f2;">
        <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
            <h5 class="mb-0">List of Media Gallery</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">List Media Gallery</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container-fluid">
        <div class="page-inner mt-2">
            <!-- Display Success Message -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Table and Add Row Button -->
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Media Gallery</h4>
                            <button class="btn btn-primary btn-round ms-auto"
                                onclick="window.location.href='{{ route('media-gallery.create') }}';">
                                <i class="fa fa-plus"></i> Add Media Gallery
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="add-row" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Sl.no</th>
                                        <th>Media Type</th>
                                         <th>Tags</th>
                                        <th>Media Title</th>
                                        <th>Media Description</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($results as $index => $result)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ config('constant.media_gallery.' . $result->media_gallery) ?? 'Unknown' }}</td>
                                         <td>{{ $result->tag_names }}</td>
                                        <td>{{ $result->title ?? '' }}</td>
                                        <td>{{ $result->description ?? '' }}</td>
                                        <td>{{ $result->date ? \Carbon\Carbon::parse($result->date)->format('d/m/Y') : '' }}</td>
                                        <td style="font-weight: bold;">
                                            @if ($result->status == 1)
                                                <span class="text-success">Active</span>
                                            @else
                                                <span class="text-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <button class="btn btn-link btn-primary btn-lg"
                                                    onclick="window.location.href='{{ route('media-gallery.edit', $result->id) }}';">
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
                <!-- Table and Add Row Button end -->
            </div>
        </div>
    </div>
</div>
@push('scripts')
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
@endpush
@endsection
