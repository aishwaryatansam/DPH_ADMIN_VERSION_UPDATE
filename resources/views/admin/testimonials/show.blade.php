@extends('admin.layouts.layout')
@section('title', 'View Testimonial')
@section('content')
<div class="container" style="margin-top: 90px;">
    <div class="container-fluid p-2" style="background-color:#f2f2f2;">
        <h5 style="margin-left: 20px;">Director Message View</h5>
    </div>
    <div class="container-fluid">
        <div class="page-inner">
            <!-- Details Layout -->
            <div class="col-md-12 col-lg-12 p-3">
                <div class="card border-primary shadow-sm">
                    <div class="card-body">
                        <!-- Heading -->
                        <h4 class="card-title mb-4 text-primary">Detail View</h4>

                        <!-- Row for Name -->
                        <div class="row mb-3 p-3">
                            <div class="col-md-2 font-weight-bold text-secondary">Name:</div>
                            <div class="col-md-8 border p-3 rounded bg-light">
                                {{$result->name}}
                            </div>
                        </div>

                        <!-- Row for Designation -->
                        <div class="row mb-3 p-3">
                            <div class="col-md-2 font-weight-bold text-secondary">Designation:</div>
                            <div class="col-md-8 border p-3 rounded bg-light">
                                {{$result->designation ?? '--'}}
                            </div>
                        </div>

                        <!-- Row for Content -->
                        <div class="row mb-3 p-3">
                            <div class="col-md-2 font-weight-bold text-secondary">Content:</div>
                            <div class="col-md-8 border p-3 rounded bg-light">
                                {!! $result->content ?? '--' !!}
                            </div>
                        </div>

                        <!-- Row for Profile Image -->
                        <div class="row mb-5 p-3">
                            <div class="col-md-2 font-weight-bold text-secondary">Profile Image:</div>
                            <div class="col-md-8 d-flex align-items-center">
                                <img src="{{fileLink($result->image_url)}}" alt=""
                                    class="img-fluid rounded"
                                    style="max-height: 150px; max-width: 150px; object-fit: cover;">
                            </div>
                        </div>

                        <!-- Row for Status -->
                        <div class="row mb-3 p-3">
                            <div class="col-md-2 font-weight-bold text-secondary">Status:</div>
                            <div class="col-md-8">
                                <span class="badge {{ $result->status ? 'bg-success' : 'bg-danger' }} text-light">{{findStatus($result->status)}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Details Layout end -->
        </div>
    </div>
</div>
@endsection