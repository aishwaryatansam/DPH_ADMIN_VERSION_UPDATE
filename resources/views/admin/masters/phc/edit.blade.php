@extends('admin.layouts.layout')
@section('title', 'Edit Phc')
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script><script>
        $(document).ready(function() {
    $('.select2').select2({
        width: '100%',
        placeholder: "Select tags",
        allowClear: true
    });
});

    </script>
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">PHC</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">PHC</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>

            </div>
        </div>
        <div class="container-fluid">
            <div class="page-inner">
                <div class="container-fluid mt-2">
                    <div class="row">
                        <div class="col-lg-5 p-5" style="background-color: #ffffff; border-radius: 10px;">
                            <!-- insert the contents Here start -->

                            <div class="card-body">
                                <!-- Heading -->
                                <h4 class="card-title mb-4 text-primary">Edit PHC Details</h4>

                                <form action="{{route('phc.update',$result->id)}}" enctype="multipart/form-data" method="post">
                                    {{csrf_field()}}
                                    @method('PUT')
                                    <!-- Name -->
                                    <div class="row mb-3 p-3">
                                        <div class="col-md-10">
                                            <div class="font-weight-bold text-secondary">Name:</div>
                                            <input type="text" class="form-control" id="PHCName" value="{{old('name',$result->name)}}"
                                                name="name">
                                        </div>

                                    </div>

                                    <!-- Block Row as Dropdown -->
                                    <div class="row mb-3 px-3">
                                        <div class="col-12 col-md-3">
                                            <label for="block" class="form-label">Block <span
                                                    style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-10">
                                            <select class="form-control" id="block" name="block_id">
                                                <option value="">-- Select Block --</option>
                                                @foreach ($huds as $hud)
                                                    <optgroup label="{{ $hud->name }}">
                                                        @foreach ($hud->blocks as $block)
                                                            <option value="{{ $block->id }}"
                                                                {{ SELECT($block->id, old('block_id', $result->block_id)) }}>
                                                                {{ $block->name }}</option>
                                                        @endforeach
                                                    </optgroup>
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
 <div class="row mb-3 px-3">
    <div class="col-md-10">
   <label for="phc" class="form-label">Tags<span
                                                    style="color: red;">*</span></label>
                                        </div>
                                           <div class="col-12 col-md-10">
    <select class="form-control select2" id="tags" name="tags[]" multiple>
        @foreach ($tags as $id => $name)
            <option value="{{ $id }}" {{ in_array($id, $selectedTags) ? 'selected' : '' }}>
                {{ $name }}
            </option>
        @endforeach
    </select>
</div>
 </div>
                                    <!-- Buttons -->
                                    <div class="text-start mt-4 px-3">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button type="button" onclick="window.location.href='{{route('phc.index')}}';" class="btn btn-danger">Cancel</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Modal for Image Preview -->
                            <!-- <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imageModalLabel">PHC Image</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img id="modalImage" src="#" alt="PHC Image" style="max-width: 100%; height: auto;">
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
@endsection
