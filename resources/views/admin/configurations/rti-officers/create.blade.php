@extends('admin.layouts.layout')
@section('title', 'List Rti Officers')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Create Social Media</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Social Media</li>
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
                <div>
                    <!-- insert the contents Here start -->

                    <div class="container mt-2">
                        <div class="row">
                            <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                                <form action="{{ route('rti-officer.store') }}" enctype="multipart/form-data" method="post" id="myForm">
                                    {{ csrf_field() }}
                                    <div class="container">
                                        <h4 class="card-title mb-4 text-primary">Create Rti Officer</h4>

                                        <!-- Name Row -->
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-4">
                                                <label for="name" class="form-label">Title <span
                                                        class="sizeoftextred">*</span></label>
                                                        <input type=text  class="form-control" name="title" placeholder="Enter Title" required>
                                            </div>

                                            <!-- Label Columnwith reduced width -->
                                            <div class="col-12 col-md-4">
                                                <label for="name" class="form-label">Name <span
                                                        class="sizeoftextred">*</span></label>
                                                        <input type=text  class="form-control" name="name" placeholder="Enter Name"  required>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label for="name" class="form-label">E-mail ID <span
                                                        class="sizeoftextred">*</span></label>
                                                        <input type=text  class="form-control" name="email" placeholder="Enter Email-ID" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-4">
                                                <label for="name" class="form-label">Mobile Number <span
                                                        class="sizeoftextred">*</span></label>
                                                        <input type="text" class="form-control" name="mobile_number" placeholder="Enter Mobile Number" required>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label for="name" class="form-label">Landline Number<span
                                                        class="sizeoftextred">*</span></label>
                                                        <input type=text  class="form-control" name="landline_number" placeholder="Enter Landline Number" required>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label for="name" class="form-label">Extn<span
                                                        class="sizeoftextred">*</span></label>
                                                        <input type=text  class="form-control" name="extn" placeholder="Enter landline extn number" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-4">
                                                <label for="name" class="form-label">Fax<span
                                                        class="sizeoftextred">*</span></label>
                                                        <input type=text  class="form-control" name="fax" placeholder="Enter Fax Number" required>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label for="name" class="form-label">Address<span
                                                        class="sizeoftextred">*</span></label>
                                                        <input type="text"  class="form-control" name="address" placeholder="Enter Address" required>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label for="designation_id" class="form-label">Designation<span
                                                        class="sizeoftextred">*</span></label>
                                                        <select name="designations_id" id="designation_id" class="form-control">
                                                            <option value="">-- Select Designation -- </option>
                                                            @foreach ($designations as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                    {{ SELECT($value->id, old('designation_id')) }}>
                                                                    {{ $value->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                            </div>


                                            <div class="col-12 col-md-4">
                                                <label for="status" class="form-label">Status <span
                                                        class="sizeoftextred">*</span></label>


                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" name="status" type="checkbox"
                                                            id="toggleStatus" value="1"
                                                            {{ CHECKBOX('document_status') }}
                                                            onchange="toggleStatusText('statusLabel', this)">
                                                        <label class="form-check-label" for="toggleStatus"
                                                            id="statusLabel">In-Active</label>

                                            </div>
                                        </div>
                                    </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="d-flex mt-2 pl-5">
                                        <button type="submit" class="btn btn-primary"
                                            onclick="validateForm()">Submit</button>
                                        <button type="button" style="margin-left: 10px;"
                                            class="btn btn-danger" >Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- insert the contents Here end -->
                </div>
                <!-- page inner end-->
            </div>
            <!-- database table end -->
        </div>
        <!-- content end here -->


        <!-- main panel end -->
    </div>
    <script>
      </script>
@endsection
