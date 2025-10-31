@extends('admin.layouts.layout')
@section('title', 'Edit Hsc')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">HSC</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">HSC</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                <div class="container-fluid mt-2">
                    <div class="row">
                        <div class="col-lg-5 p-5" style="background-color: #ffffff; border-radius: 10px;">
                            <!-- insert the contents Here start -->

                            <div class="card-body">
                                <!-- Heading -->
                                <h4 class="card-title mb-4 text-primary">Edit HSC Details</h4>

                                <form action="{{ route('hsc.update', $result->id) }}" enctype="multipart/form-data"
                                    method="post">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <!-- Name -->
                                    <div class="row mb-3 p-3">
                                        <div class="col-md-10">
                                            <div class="font-weight-bold text-secondary">Name:</div>
                                            <input type="text" class="form-control" id="HSCName"
                                                value="{{ old('name', $result->name) }}" name="name">
                                        </div>

                                    </div>

                                    <!-- Block Row as Dropdown -->
                                    <div class="row mb-3 px-3">
                                        <div class="col-12 col-md-3">
                                            <label for="block" class="form-label">Block<span
                                                    style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-10">
                                            <select name="block_id" id="block_id" class="form-control">
                                                <option value="">-- Select Block -- </option>
                                                @foreach ($huds as $hud)
                                                    <optgroup label="{{ $hud->name }}">
                                                        @foreach ($hud->blocks as $block)
                                                            <option value="{{ $block->id }}"
                                                                {{ SELECT($block->id, old('block_id', $result->phc->block_id)) }}>
                                                                {{ $block->name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <!-- Block Row as Dropdown -->
                                    <div class="row mb-3 px-3">
                                        <div class="col-12 col-md-3">
                                            <label for="phc" class="form-label">PHC<span
                                                    style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-10">
                                            <select name="phc_id" id="phc_id" class="form-control">
                                                <option value="">-- Select PHC -- </option>
                                                @foreach ($phc as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ SELECT($value->id, old('phc_id', $result->phc_id)) }}>
                                                        {{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>



                                    <!-- <div class="row mb-3 p-3">
                                            <!-- Map Location --
                                            <div class="col-md-6">
                                                <div class="font-weight-bold text-secondary">Map Location</div>
                                                <input type="text" class="form-control" id="mapLocation" placeholder="Enter Map Location" required>
                                            </div>
                                            <!-- Image preview --
                                            <div class="col-md-6">
                                                <div class="font-weight-bold text-secondary">Image Preview:</div>
                                                <img id="imagePreview" src="#" alt="hud Image Preview" style="max-width: 150px; max-height: 150px; cursor: pointer; display: none;" data-bs-toggle="modal" data-bs-target="#imageModal">
                                            </div>
                                        </div> -->



                                    <!-- Status -->
                                    <div class="row mb-3 px-3">
                                        <div class="col-md-10">
                                            <div class="font-weight-bold text-secondary">Status:</div>
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
                                    <div class="text-start mt-4 px-3">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button onclick="window.location.href='{{url('/hsc')}}';" type="button" class="btn btn-danger">Cancel</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Modal for Image Preview -->
                            <!-- <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imageModalLabel">HSC Image</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img id="modalImage" src="#" alt="HSC Image" style="max-width: 100%; height: auto;">
                                            </div>
                                        </div>
                                    </div>
                                </div> -->





                            <!-- insert the contents Here end -->
                        </div>
                    </div>
                </div>








            </div>
            <!-- page inner end-->
        </div>
        <!-- database table end -->
    </div>
    <script src="{{ asset('packa/custom/hierarchy.js') }}"></script>

@endsection
