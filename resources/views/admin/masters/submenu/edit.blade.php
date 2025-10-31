@extends('admin.layouts.layout')
@section('title', 'Edit Submenu')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Submenu</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Submenu</li>
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
                <div class="container-fluid  mt-2">
                    <div class="row">
                        <!-- insert the contents Here start -->

                        <div class="row">
                            <div class="col-lg-8 p-5" style="background-color: #ffffff; border-radius: 10px;">
                                <form id="contactForm" action="{{ route('submenu.update', $result->id) }}"
                                    enctype="multipart/form-data" method="post">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <div class="container">
                                        <h4 class="card-title mb-4 text-primary">Edit Submenu</h4>

                                        <!-- Name Row -->
                                        <div class="row mb-3">
                                            <!-- Label Column with reduced width -->
                                            <div class="col-12 col-md-3">
                                                <label for="name" class="form-label">Name <span
                                                        style="color: red;">*</span></label>
                                            </div>
                                            <!-- Input Column -->
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control" id="name"
                                                    placeholder="Enter name" name="name"
                                                    value="{{ old('name', $result->name) }}" required>
                                            </div>
                                        </div>

                                        <!-- Order No Row -->
                                        <div class="row mb-3">
                                            <!-- Label Column with reduced width -->
                                            <div class="col-12 col-md-3">
                                                <label for="order_no" class="form-label">Order No <span
                                                        style="color: red;">*</span></label>
                                            </div>
                                            <!-- Input Column -->
                                            <div class="col-12 col-md-7">
                                                <input type="number" class="form-control" id="order_no"
                                                    placeholder="Enter Order Number" name="order_no"
                                                    value="{{ old('order_no', $result->order) }}" required>
                                            </div>
                                        </div>

                                        <!-- Status Row -->
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="status" class="form-label">Status <span
                                                        style="color: red;">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input " name="status" type="checkbox"
                                                        id="toggleStatus" value="1"
                                                        {{ CHECKBOX('status', $result->status) }}
                                                        onchange="toggleStatusText('statusLabel', this)">
                                                    <label class="form-check-label" for="toggleStatus"
                                                        id="statusLabel">{{ $result->status == 1 ? 'Active' : 'In-Active' }}</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="d-flex mt-2 pl-5">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="button" class="btn btn-danger" onclick="history.back()"
                                                style="margin-left: 10px;">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- insert the contents Here end -->
                    </div>
                </div>

            </div>
            <!-- page inner end-->
        </div>
        <!-- database table end -->
    </div>
@endsection
