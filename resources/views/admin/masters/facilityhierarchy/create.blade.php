@extends('admin.layouts.layout')
@section('title', 'List Facility Type')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Facility Masters</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Facility Masters</li>
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

                <div class="container mt-2">
                    <div class="row">
                        <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                            <form id="facilityForm" action="{{ route('facility_hierarchy.store') }}"
                                enctype="multipart/form-data" method="post">
                                {{ csrf_field() }}
                                <div class="table-responsive">
                                    <h4 class="card-title mb-4 text-primary">Create Facility Details</h4>
                                    <table class="table table-borderless">
                                        <tbody>
                                            <!-- Facility ID -->

                                            <!-- Facility Type -->
                                            <tr>
                                                <td>
                                                    <label for="facilityType" class="form-label">Facility Type <span
                                                            style="color: red;">*</span></label>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="facility_type" name="facility_type_id">
                                                        <option value="">-- Select Type -- </option>
                                                        @foreach ($facility_types as $facility_type)
                                                            <option value="{{ $facility_type->id }}"
                                                                {{ SELECT($facility_type->id, request('facility_type')) }}>
                                                                {{ $facility_type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td></td>
                                            </tr>

                                            <!-- Facility Name -->
                                            <tr>
                                                <td>
                                                    <label for="facilityName" class="form-label">Facility Name <span
                                                            style="color: red;">*</span></label>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="name"
                                                        id="facilityName" placeholder="Enter facility name" required>
                                                </td>
                                                <td></td>
                                            </tr>

                                            <!-- Facility Code -->
                                            <tr>
                                                <td>
                                                    <label for="facilityCode" class="form-label">Facility Code <span
                                                            style="color: red;">*</span></label>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="code"
                                                        id="facilityCode" placeholder="Enter facility code" required>
                                                </td>
                                                <td></td>
                                            </tr>

                                            <!-- Facility Level -->
                                            <tr>
                                                <td>
                                                    <label for="facilityLevel" class="form-label">Facility Level <span
                                                            style="color: red;">*</span></label>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="facility_level"
                                                        name="facility_level_id">
                                                        <option value="">-- Select Level -- </option>
                                                        @foreach ($facility_levels as $facility_level)
                                                            <option value="{{ $facility_level->id }}"
                                                                data-value="{{ $facility_level->name }}"
                                                                {{ SELECT($facility_level->id, request('facility_level_id')) }}>
                                                                {{ $facility_level->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td></td>
                                            </tr>

                                            <!-- District ID -->
                                            <tr id="district_div" style="display:none;">
                                                <td>
                                                    <label for="districtId" class="form-label">District ID <span
                                                            style="color: red;">*</span></label>
                                                </td>
                                                <td>
                                                    <select name="district_id" id="district_id" class="form-control">
                                                        <option value="">-- Select District -- </option>
                                                        @foreach ($districts as $key => $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ SELECT($value->id, old('district_id')) }}>
                                                                {{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td></td>
                                            </tr>

                                            <!-- HUD ID -->
                                            <tr id="hud_div" style="display:none;">
                                                <td>
                                                    <label for="hudId" class="form-label">HUD ID <span
                                                            style="color: red;">*</span></label>
                                                </td>
                                                <td>
                                                    <select name="hud_id" id="hud_id" class="form-control">
                                                        <option value="">-- Select HUD -- </option>
                                                        @foreach ($huds as $key => $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ SELECT($value->id, old('hud_id')) }}>
                                                                {{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <!-- Block ID -->
                                            <tr id="block_div" style="display:none;">
                                                <td>
                                                    <label for="blockId" class="form-label">Block ID <span
                                                            style="color: red;">*</span></label>
                                                </td>
                                                <td>
                                                    <select name="block_id" id="block_id" class="form-control">
                                                        <option value="">-- Select Block -- </option>
                                                        @foreach ($blocks as $key => $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ SELECT($value->id, old('block_id')) }}>
                                                                {{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td></td>
                                            </tr>

                                            <!-- PHC ID -->
                                            <tr id="phc_div" style="display:none;">
                                                <td>
                                                    <label for="phcId" class="form-label">PHC ID <span
                                                            style="color: red;">*</span></label>
                                                </td>
                                                <td>
                                                    <select name="phc_id" id="phc_id" class="form-control">
                                                        <option value="">-- Select PHC -- </option>
                                                        @foreach ($phc as $key => $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ SELECT($value->id, old('phc_id')) }}>
                                                                {{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td></td>
                                            </tr>

                                            <!-- HSC ID -->
                                            <tr id="hsc_div" style="display:none;">
                                                <td>
                                                    <label for="hscId" class="form-label">HSC ID <span
                                                            style="color: red;">*</span></label>
                                                </td>
                                                <td>
                                                    <select name="hsc_id" id="hsc_id" class="form-control">
                                                        <option value="">-- Select HSC -- </option>
                                                        @foreach ($hsc as $key => $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ SELECT($value->id, old('hsc_id')) }}>
                                                                {{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>

                                            <!-- Urban/Rural -->
                                            <tr>
                                                <td>
                                                    <label for="areaType" class="form-label">Urban/Rural<span
                                                            style="color: red;">*</span></label>
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="area_type" type="checkbox"
                                                            id="toggleAreaType" value="1"
                                                            {{ CHECKBOX('area_type') }}
                                                            onchange="toggleAreaTypeText('areaTypeLabel', this)">
                                                        <label class="form-check-label" for="toggleAreaType"
                                                            id="areaTypeLabel">Rural</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Status -->
                                            <tr>
                                                <td>
                                                    <label for="status" class="form-label">Status<span
                                                            style="color: red;">*</span></label>
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="status" type="checkbox"
                                                            id="toggleStatus" value="1"
                                                            {{ CHECKBOX('document_status') }}
                                                            onchange="toggleStatusText('statusLabel', this)">
                                                        <label class="form-check-label" for="toggleStatus"
                                                            id="statusLabel">In-Active</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex mt-2">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button"
                                        onclick="window.location.href='{{ route('facility_hierarchy.index') }}'"
                                        style="margin-left: 10px;" class="btn btn-danger">Cancel</button>
                                </div>
                            </form>






                            <!-- popup for submitting confirmation start -->
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
                            <!-- popup for submitting confirmation end -->





                            <!-- insert the contents Here end -->
                        </div>
                    </div>
                </div>








            </div>
            <!-- page inner end-->
        </div>
        <!-- database table end -->
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            setPageUrl('/facility_hierarchy?');
        });
    </script>
    <script src="{{ asset('packa/custom/facility-hierarchy.js') }}"></script>
@endsection
