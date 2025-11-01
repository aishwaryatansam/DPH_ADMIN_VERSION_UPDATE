@extends('admin.layouts.layout')
@section('title', 'Create Tags')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Tags</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Tags</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Tags</li>
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
                <!-- insert the contents Here start -->

                <div class="container-fluid mt-2">
                    <div class="row">
                        <div class="col-lg-5 py-5 px-5" style="background-color: #ffffff; border-radius: 10px;">
                            <form id="urbanForm" action="{{route('tags.store')}}" enctype="multipart/form-data" method="post">
                                {{csrf_field()}}
                                <div class="container">
                                    <h4 class="card-title mb-4 text-primary">Tags</h4>

                                   
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="blockname" class="form-label">Name</label>
                                        </div>
                                        <div class="col-12 col-md-10">
                                            <input type="text" class="form-control" name="name" id="tagname"
                                                placeholder="Enter name">
                                        </div>
                                    </div>

                                    <!-- District Row as Dropdown -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="district" class="form-label">Tags<span
                                                    style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-10">
                                            <input type="text" class="form-control" name="name" id="status"
                                                placeholder="Enter status">
                                        </div>
                                    </div>

                              

                                    <!-- Buttons -->
                                    <div class="d-flex mt-2">
                                        <button type="submit" class="btn btn-primary"
                                            onclick="validateForm()">Submit</button>
                                        <button onclick="window.location.href='{{url('/tags')}}';" type="button" style="margin-left: 10px;"
                                            class="btn btn-danger">Cancel</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Confirmation Modal -->
                            <div class="modal fade" id="confirmationModal" tabindex="-1"
                                aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header justify-content-center position-relative">
                                            <h5 class="modal-title" id="confirmationModalLabel">Confirm
                                                Submission</h5>
                                            <button type="button" class="btn-close position-absolute end-0 me-3"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <div class="confirmation-icon mb-4">
                                                <i class="fas fa-question-circle fa-4x text-danger"></i>
                                            </div>
                                            <p class="mb-4">Are you sure you want to submit the form?</p>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="button" class="btn btn-outline-danger"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-success" onclick="submitForm()">Yes,
                                                Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>










            </div>
            <!-- page inner end-->
        </div>
        <!-- database table end -->
    </div>
@endsection
