@extends('admin.layouts.layout')
@section('title', 'Create HUD')
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Select2 CSS & JS from CDN -->

<script>
$(document).ready(function() {
    $('#tags').select2({
        placeholder: "-- Select --",
        allowClear: true,
        width: '100%'
    });
});
</script>
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">HUD</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">HUD</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create HUD</li>
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
                            <form action="{{route('huds.store')}}" enctype="multipart/form-data" method="post">
                                {{csrf_field()}}
                                <div class="container">
                                    <h4 class="card-title mb-4 text-primary">HUD (Health Unit District)</h4>

                                    <!-- Is Urban (Toggle Switch) Row -->
                                    <div class="row mb-3">
                                        <!-- <div class="col-12 col-md-3">
                                            <label for="isUrban" class="form-label">Is Urban? <span style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="isUrban" checked
                                                    onchange="toggleUrbanStatus('urbanLabel', this)">
                                                <label class="form-check-label" for="isUrban" id="urbanLabel">Yes</label>
                                            </div>
                                        </div> -->
                                    </div>

                                    <!-- name Row -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="hudname" class="form-label">Name</label>
                                        </div>
                                        <div class="col-12 col-md-10">
                                            <input type="text" class="form-control" name="name" id="hudname"
                                                placeholder="Enter name">
                                        </div>
                                    </div>

                                    <!-- District Row as Dropdown -->
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="district" class="form-label">District <span
                                                    style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-10">
                                            <select name="district_id" id="district_id" class="form-control">
                                                <option value="">-- Select District -- </option>
                                                @foreach ($districts as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ SELECT($value->id, old('district_id')) }}>{{ $value->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>



                                    <!-- Status Row -->
                                    <div class="row mb-3">
                                        <div class="col-12 mt-2 col-md-3">
                                            <label for="status" class="form-label">Status</label>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" name="status" type="checkbox"
                                                    id="toggleStatus" value="1" {{ CHECKBOX('document_status') }}
                                                    onchange="toggleStatusText('statusLabel', this)">
                                                <label class="form-check-label" for="toggleStatus"
                                                    id="statusLabel">In-Active</label>
                                            </div>
                                        </div>
                                    </div>

            <tr>
    <td class="col-12 col-md-3">
        <label for="tags" class="form-label">Tags</label>
    </td>
    <td class="col-12 col-md-9">
        {{-- FIX: Corrected the 'multiple' attribute syntax and name attribute --}}
      <select class="form-select select-dropdown" id="tags" name="tags[]" multiple>
    <option value=""> -- Select --</option>
    @foreach ($tags as $tag)
        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
    @endforeach
</select>

    </td>
</tr>  

                                    <!-- Select Image Row -->
                                    <!-- <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="selectImage" class="form-label">Select Image</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="file" class="form-control" id="selectImage" accept="image/*">
                                        </div>
                                    </div> -->

                                    <!-- Video URL Row -->
                                    <!-- <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="videoUrl" class="form-label">Video URL</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="url" class="form-control" id="videoUrl" placeholder="Enter video URL">
                                        </div>
                                    </div> -->

                                    <!-- Map Location URL Row -->
                                    <!-- <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="mapLocation" class="form-label">Map Location URL</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="url" class="form-control" id="mapLocation" placeholder="Enter map location URL">
                                        </div>
                                    </div> -->

                                    <!-- Land Document Row -->
                                    <!-- <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="landDocument" class="form-label">Land Document</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="file" class="form-control" id="landDocument" accept=".pdf, .doc, .docx">
                                        </div>
                                    </div> -->

                                    <!-- Buttons -->
                                    <div class="d-flex mt-2">
                                        <button type="submit" class="btn btn-primary"
                                            onclick="validateForm()">Submit</button>
                                        <button type="button" style="margin-left: 10px;"
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
