@extends('admin.layouts.layout')
@section('title', 'Create Scheme')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Schemes</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Schemes</li>
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
                                <form id="contactForm" action="{{route('schemes.store')}}" enctype="multipart/form-data" method="post">
                                    {{csrf_field()}}
                                    <div class="container">
                                        <h4 class="card-title mb-4 text-primary">Create Schemes</h4>

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
                                                    placeholder="Enter name" name="name" required>
                                            </div>
                                        </div>

                                        <!-- Program Divisions Dropdown Row -->
                                     <div class="row mb-3">
    <div class="col-12 col-md-3">
        <label for="programs_id" class="form-label">Program Division <span style="color:red">*</span></label>
    </div>
    <div class="col-12 col-md-7">
        <select name="programs_id" id="programs_id" class="form-control">
            <option value="">-- Select Program --</option>
            @foreach ($programs as $value)
                <option value="{{ $value->id }}" {{ SELECT($value->id, old('programs_id')) }}>
                    {{ $value->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>
                                        
                                        <!-- Sections Dropdown Row -->
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="section" class="form-label">Sections<span
                                                        style="color: red;">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <select name="section_id" id="section_id" class="form-control">
                                                    <option value="">-- Select section -- </option>
                                                    @foreach ($sections as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ SELECT($value->id, old('section_id')) }}>
                                                            {{ $value->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Short Code Row -->
                                        <div class="row mb-3">
                                            <!-- Label Column with reduced width -->
                                            <div class="col-12 col-md-3">
                                                <label for="short_code" class="form-label">Short Code <span
                                                        style="color: red;">*</span></label>
                                            </div>
                                            <!-- Input Column -->
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control" id="short_code"
                                                    placeholder="Enter Short Code" name="short_code" required>
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
                                                    placeholder="Enter Order Number" name="order_no" required>
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
                                                    <input class="form-check-input" name="status" type="checkbox"
                                                            id="toggleStatus" value="1"
                                                            {{ CHECKBOX('document_status') }}
                                                            onchange="toggleStatusText('statusLabel', this)">
                                                        <label class="form-check-label" for="toggleStatus"
                                                            id="statusLabel">In-Active</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="d-flex mt-2 pl-5">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="button" class="btn btn-danger" onclick="history.back()" style="margin-left: 10px;">
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
