@extends('admin.layouts.layout')
@section('title', 'List Director Message')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color:#f2f2f2;">
            <h5 style="margin-left: 20px;">List Of Director Messages</h5>
        </div>
        <div class="container-fluid">
            <div class="page-inner mt-5">
                <!-- Table and Add Row Button -->
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Director Message</h4>
                                <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                    data-bs-target="#addRowModal" onclick="window.location.href='{{route('testimonials.create')}}';">
                                    <i class="fa fa-plus"></i> Add New
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Status</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($results) && $results->count())
                                            @foreach ($results as $result)
                                                <!-- Example Rows -->
                                                <tr>
                                                    <td>{{ $result->name ?? '' }}</td>
                                                    <td>
                                                        <p>{{ $result->designation ?? '--' }}</p>
                                                    </td>
                                                    <td class="text-success" style="font-weight: bold;">
                                                        @if (isset($result->status) && $result->status == 1)
                                                            <span class="text-success">Active</span>
                                                        @else
                                                            <span class="text-danger">In-Active</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="form-button-action">
                                                            <button type="button" class="btn btn-link btn-primary btn-lg"
                                                                onclick="window.location.href='{{ route('testimonials.edit', $result->id) }}';">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-link btn-danger"
                                                                onclick="window.location.href='{{ route('testimonials.show', $result->id) }}';">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td collspan="6">No Records Found..</td>
                                            </tr>
                                        @endif
                                        <!-- Additional rows can be added dynamically -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Table and Add Row Button end -->
            </div>
        </div>
    </div>
@endsection
