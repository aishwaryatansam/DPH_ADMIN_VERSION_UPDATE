@extends('admin.layouts.layout')
@section('title', 'Create Contact')
@section('content')

<style>
    /* Frame card styles */
    .frame-card {
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        width: 100%;
    }

    .frame-card.blue {
        background-color: #F0F8FF;
    }

    .frame-card.green {
        background-color: #F0F8FF;
    }
    .frame-card {
        margin-top: 30px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        position: relative;
    }

    .frame-title {
        position: absolute;
        top: -12px;
        left: 15px;
        background-color: #fff;
        padding: 0 10px;
        font-weight: bold;
        color: #007bff;
    }

</style>

    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Contacts</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Contacts</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create contact</li>
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
                        <div class="col-lg-12 py-5 px-5" style="background-color: #ffffff; border-radius: 10px;">
                            <form id="contactForm" action="{{ route('contacts.store') }}" enctype="multipart/form-data"
                                method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="hidden_hud_id" id="hidden_hud_id"
                                    value="{{ auth()->user()->hud_id }}">
                                <div class="container">
                                    <h4 class="card-title mb-4 text-primary">Create Contact</h4>
                                    <div >
                                        <!-- Contact Type Row -->


                                            <div  id="frame1" class="frame-card blue d-grid gap-5 mb-3 grid-3 grid-2 grid-1">

                                                <div class="frame-title">Find Facility</div>
                                                <!-- Is Post Vacant Row -->
                                                <div>
                                                    <label for="isPostVacant" class="form-label">Is Post Vacant? <span
                                                            style="color: red;">*</span></label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="is_post_vacant"
                                                            name="is_post_vacant" value="1"
                                                            {{ CHECKBOX('is_post_vacant', old('is_post_vacant')) }}
                                                            onchange="toggleVisibleText('postvacantLabel', this)">
                                                        <label class="form-check-label" for="isPostVacant"
                                                            id="postvacantLabel">No</label>
                                                    </div>
                                                </div>

                                                <div>
                                                    <label for="facilityType" class="form-label">Facility Type</label>
                                                    <select name="facility_type" id="facility_type" class="form-select">
                                                        <option value="">-- Select Facility Type -- </option>
                                                        @foreach ($facility_types as $key => $value)
                                                            <option value="{{ $value->id }}" data-value="{{ $value->slug_key }}"
                                                                {{ SELECT($value->id, old('facility_type')) }}>{{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div id="hud_div">
                                                    <label for="hud_id">HUD</label>
                                                    <select name="hud_id" id="hud_id" class="form-control">
                                                        <option value="">-- Select HUD -- </option>
                                                        @foreach ($huds as $key => $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ SELECT($value->id, old('hud_id')) }}>{{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div id="block_div">
                                                    <label for="block_id">Block</label>
                                                    <select name="block_id" id="block_id" class="form-control">
                                                        <option value="">-- Select Block -- </option>
                                                        @foreach ($blocks as $key => $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ SELECT($value->id, old('block_id')) }}>{{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div id="phc_div">
                                                    <label for="phc_id">PHC</label>
                                                    <select name="phc_id" id="phc_id" class="form-control">
                                                        <option value="">-- Select PHC -- </option>
                                                        @foreach ($phc as $key => $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ SELECT($value->id, old('phc_id')) }}>{{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div id="hsc_div">
                                                    <label for="hsc_id">HSC</label>
                                                    <select name="hsc_id" id="hsc_id" class="form-control">
                                                        <option value="">-- Select HSC -- </option>
                                                        @foreach ($hsc as $key => $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ SELECT($value->id, old('hsc_id')) }}>{{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <!-- Facility ID Input with Validate Button inside the input -->
                                                    <label for="facility_id_input" class="form-label">Enter Facility ID</label>
                                                    <div class="input-group">
                                                        <input type="text" id="facility_id_input" class="form-control"
                                                            placeholder="Enter Facility ID">
                                                        <button class="btn btn-primary" type="button"
                                                            onclick="validateFacilityId()">Validate</button>
                                                    </div>
                                                </div>

                                                <div>
                                                    <label for="facility" class="form-label">Select Facility<span
                                                            style="color: red;">*</span></label>
                                                    <select name="facility_id" id="facility_id" class="form-select">
                                                        <option value="">-- Select Facility -- </option>
                                                        @foreach ($facilities as $key => $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ SELECT($value->id, old('facility')) }}>
                                                                {{ $value->facility_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                @if (isState())
                                                    <div>
                                                        <label for="program" class="form-label">Select Program<span
                                                                style="color: red;">*</span></label>
                                                        <select name="programs_id" id="program_id" class="form-select">
                                                            <option value="">-- Select Program -- </option>
                                                            @foreach ($programs as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                    {{ SELECT($value->id, old('program')) }}>{{ $value->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif

                                                <div>
                                                    <label for="orderNo" class="form-label">Order No</label>
                                                    <input type="number" name="order_no" class="form-control" id="order_no"
                                                        placeholder="Enter Order No" value="{{ old('order_no') }}">
                                                </div>

                                                <div>
                                                    <label for="contactType" class="form-label">Designation Type <span
                                                            style="color: red;">*</span></label>
                                                    <select name="contact_type" id="contact_type" class="form-select">
                                                        <option value="">-- Select Designation Type -- </option>
                                                        @foreach ($contact_types as $key => $value)
                                                            <option value="{{ $value->id }}"
                                                                data-value="{{ $value->slug_key }}"
                                                                {{ SELECT($value->id, old('contact_type')) }}>{{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Designation Row -->
                                                <div id="designation_div">
                                                    <label for="designation" class="form-label">Designation <span
                                                            style="color: red;">*</span></label>
                                                    <select name="designation_id" id="designation_id" class="form-control">
                                                        <option value="">-- Select Designation -- </option>
                                                        @foreach ($designation as $key => $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ SELECT($value->id, old('designation_id')) }}>
                                                                {{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div id="frame2" class="frame-card green frame-card blue d-grid gap-5 mb-3 grid-3 grid-2 grid-1">
                                                <div class="frame-title">Contact Details</div>
                                                <!-- Name Row -->
                                                <div id="name_div">
                                                    <label for="name" class="form-label">Name <span
                                                            style="color: red;">*</span></label>
                                                    <input type="text" name="name" class="form-control" id="name"
                                                        placeholder="Enter Name" value="{{ old('name') }}">
                                                </div>

                                                <!-- Qualification Row -->
                                                <div id="qualification_div">
                                                    <label for="qualification" class="form-label">Qualification</label>
                                                    <input type="text" name="qualification" class="form-control"
                                                        id="qualification" placeholder="Enter Qualification"
                                                        value="{{ old('qualification') }}">
                                                </div>

                                                <!-- Mobile Number Row -->
                                                <div id="mobile_number_div">
                                                    <label for="mobileNumber" class="form-label">Mobile Number <span
                                                            style="color: red;">*</span></label>
                                                    <input type="text" name="mobile_number" class="form-control"
                                                        id="mobile_number" placeholder="Enter Mobile Number"
                                                        value="{{ old('mobile_number') }}">
                                                </div>

                                                <!-- Landline Number Row -->
                                                <div id="landline_number_div">
                                                    <label for="landlineNumber" class="form-label">Landline
                                                        Number</label>
                                                    <input type="text" name="landline_number" class="form-control"
                                                        id="landline_number" placeholder="Enter Landline Number"
                                                        value="{{ old('landline_number') }}">
                                                </div>

                                                <!-- Email Row -->
                                                <div id="email_id_div">
                                                    <label for="email" class="form-label">Email ID <span
                                                            style="color: red;">*</span></label>
                                                    <input type="text" name="email_id" class="form-control" id="email_id"
                                                        placeholder="Enter Email Id" value="{{ old('email_id') }}">
                                                </div>

                                                <!-- Fax Row -->
                                                <div id="fax_div">
                                                    <label for="fax" class="form-label">Fax</label>
                                                    <input type="text" name="fax" class="form-control" id="fax"
                                                        placeholder="Enter Fax" value="{{ old('fax') }}">
                                                </div>
                                            </div>
                                    </div>


                                    <!-- Status Row -->
                                    @if (isAdmin())
                                        <div>
                                            <div class="col-12 col-md-3">
                                                <label for="status" class="form-label">Status</label>
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
                                    @endif

                                    <!-- Buttons -->
                                    <div class="d-flex mt-2">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
    <script src="{{ asset('packa/custom/contact.js') }}"></script>
    <script>
        function validateFacilityId() {
            var facilityId = document.getElementById('facility_id_input').value;

            var facilityDropdown = document.getElementById('facility_id');
            var optionToSelect = Array.from(facilityDropdown.options).find(option => option.value == facilityId);

            if (optionToSelect) {
                facilityDropdown.value = facilityId;
            } else {
                alert('Facility ID not found.');
            }
        }
    </script>
    <script>
        function toggleFrameCardColor(checkbox) {
            const frame1 = document.getElementById('frame1');
            const frame2 = document.getElementById('frame2');

            if (checkbox.checked) {
                frame1.classList.replace('blue', 'green');
                frame2.classList.replace('green', 'blue');
            } else {
                frame1.classList.replace('green', 'blue');
                frame2.classList.replace('blue', 'green');
            }
        }
    </script>
@endsection
