@extends('admin.layouts.layout')
@section('title', 'Create User')
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
                <h5 class="mb-0">Users</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Users</li>
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
                            <form id="contactForm" action="{{ route('users.store') }}" enctype="multipart/form-data"
                                method="post">
                                {{ csrf_field() }}
                                <div class="container-fluid">
                                    <h4 class="card-title mb-4 text-primary">Create Users</h4>

                                    <!-- All Fields in One Div using d-grid -->
                                    <div >


                                        <div id="frame1" class="frame-card blue d-grid gap-5 mb-3 grid-3 grid-2 grid-1">

                                            <div class="frame-title">Find Facility</div>
                                            <!-- User Type -->
                                            <div>
                                                <label for="designation" class="form-label text-secondary">User Type <span
                                                        style="color: red;">*</span></label>
                                                <select class="form-select" id="userType" name="user_type" required>
                                                    <option value="">Select User Type</option>
                                                    @foreach ($userTypes as $key => $type)
                                                        <option value="{{ $key }}" data-value="{{ $type }}">
                                                            {{ $type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- User Roles -->
                                            <div>
                                                <label for="userRole" class="form-label text-secondary">User Roles<span
                                                        style="color: red;">*</span></label>
                                                <select class="form-select" id="userRole" name="user_role" required>
                                                    <option value="">Select User Role</option>
                                                    @foreach (getUserRole() as $key => $role)
                                                        <option value="{{ $key }}" data-value="{{ $role }}">
                                                            {{ $role }} </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Program -->
                                            <div id="program_div">
                                                <label for="userType" class="form-label text-secondary">Program<span
                                                        style="color: red;">*</span></label>
                                                <select class="form-select" id="program" name="program">
                                                    <option value="">Select Program</option>
                                                    @foreach ($programs as $program)
                                                        <option value="{{ $program->id }}">{{ $program->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!--Section -->
                                            <div id="section_div">
                                                <label for="userType" class="form-label text-secondary">Section<span
                                                        style="color: red;">*</span></label>
                                                <select class="form-select" id="section" name="section">
                                                    <option value="">Select Section</option>
                                                    @foreach ($sections as $section)
                                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        {{-- <!--Facility Level -->
                                        <div id="facility_level_div">
                                            <label for="facilityLevel" class="form-label text-secondary">Facility Level</label>
                                            <select class="form-select" id="facility_level" name="facility_level_id">
                                                <option value="">Select Facility Level</option>
                                                @foreach ($facility_levels as $facility_level)
                                                <option value="{{ $facility_level->id }}"
                                                    data-value="{{ $facility_level->name }}"
                                                    {{ SELECT($facility_level->id, request('facility_level_id')) }}>
                                                    {{ $facility_level->name }}</option>
                                                @endforeach
                                            </select>
                                        </div> --}}

                                            <!--District -->
                                            <div id="district_div">
                                                <label for="userType" class="form-label text-secondary">District</label>
                                                <select class="form-select" id="district_id" name="district">
                                                    <option value="">Select District</option>
                                                    @foreach ($districts as $district)
                                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!--HUD -->
                                            <div id="hud_div">
                                                <label for="userType" class="form-label text-secondary">HUD</label>
                                                <select class="form-select" id="hud_id" name="hud">
                                                    <option value="">Select HUD</option>
                                                    @foreach ($huds as $hud)
                                                        <option value="{{ $hud->id }}">{{ $hud->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!--Block -->
                                            <div id="block_div">
                                                <label for="userType" class="form-label text-secondary">Block</label>
                                                <select class="form-select" id="block_id" name="block">
                                                    <option value="">Select Block</option>
                                                    @foreach ($blocks as $block)
                                                        <option value="{{ $block->id }}">{{ $block->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!--PHC -->
                                            <div id="phc_div">
                                                <label for="userType" class="form-label text-secondary">PHC</label>
                                                <select class="form-select" id="phc_id" name="phc">
                                                    <option value="">Select PHC</option>
                                                    @foreach ($phcs as $phc)
                                                        <option value="{{ $phc->id }}">{{ $phc->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        <!--HSC -->
                                        <div id="hsc_div">
                                            <label for="userType" class="form-label text-secondary">HSC</label>
                                            <select class="form-select" id="hsc_id" name="hsc">
                                                <option value="">Select HSC</option>
                                                @foreach ($hscs as $hsc)
                                                    <option value="{{ $hsc->id }}">{{ $hsc->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div id="facility_filter_div">
                                            <!-- Facility ID Input with Validate Button inside the input -->
                                            <label for="facility_id_input" class="form-label">Enter Facility ID</label>
                                            <div class="input-group">
                                                <input type="text" id="facility_id_input" class="form-control"
                                                    placeholder="Enter Facility ID">
                                                <button class="btn btn-primary" type="button"
                                                    onclick="validateFacilityId()">Validate</button>
                                            </div>
                                        </div>

                                            <div id="facility_div">
                                                <label for="facility" class="form-label">Select Facility</label>
                                                <select name="facility_id" id="facility_id" class="form-select">
                                                    <option value="">-- Select Facility -- </option>
                                                    @foreach ($facilities as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ SELECT($value->id, old('facility')) }}>{{ $value->facility_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div  id="frame2" class="frame-card green frame-card blue d-grid gap-5 mb-3 grid-3 grid-2 grid-1">

                                            <div class="frame-title">Personal Details</div>
                                            <!-- Name Row -->
                                            <div>
                                                <label for="name" class="form-label text-secondary">Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="name"
                                                    placeholder="Enter name" name="name" required>
                                            </div>

                                        <!-- Username Row -->
                                        <div>
                                            <label for="username" class="form-label text-secondary">Username <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="username"
                                                placeholder="Enter username" name="username" required>
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
                                        <div>
                                            <label for="designation" class="form-label text-secondary">Designation <span
                                                    style="color: red;">*</span></label>
                                            <select class="form-select" id="designation_id" name="designations_id">
                                                <option value="">Select Designation</option>
                                                @foreach ($designations as $key => $designation)
                                                    <option value="{{ $designation->id }}"
                                                        {{ SELECT($designation, old('status')) }}>{{ $designation->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                            <!-- User Institution Row -->
                                            {{-- <div>
                                                <label for="userType" class="form-label text-secondary">User Institution <span
                                                        style="color: red;">*</span></label>
                                                <select class="form-select" id="userType" required>
                                                    <option value="">Select User Type</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="editor">Editor</option>
                                                    <option value="viewer">Viewer</option>
                                                </select>
                                            </div> --}}

                                            <!-- Section Row -->
                                            {{-- <div>
                                                <label for="section" class="form-label text-secondary">Section <span
                                                        style="color: red;">*</span></label>
                                                <select class="form-select" id="section" required>
                                                    <option value="">Select Section</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="editor">Editor</option>
                                                    <option value="viewer">Viewer</option>
                                                </select>
                                            </div> --}}

                                            <!-- Contact Number Row -->
                                            <div>
                                                <label for="contactNumber" class="form-label text-secondary">Contact Number
                                                    <span style="color: red;">*</span></label>
                                                <input type="tel" class="form-control" id="contactNumber" name="contact_number"
                                                    placeholder="Enter contact number" required>
                                            </div>

                                            <!-- Email Row -->
                                            <div>
                                                <label for="email" class="form-label text-secondary">Email ID <span
                                                        style="color: red;">*</span></label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="Enter email" required>
                                            </div>
                                        </div>

                                        <!-- Status Row -->
                                        <div>
                                            <label for="status" class="form-label">Status</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" name="status" type="checkbox" id="toggleStatus" value="1"
                                                    onchange="toggleStatusText('statusLabel', this)">
                                                <label class="form-check-label" for="toggleStatus"
                                                    id="statusLabel">In-Active</label>
                                            </div>
                                        </div>
                                        {{-- <div>
                                            <label for="visibleToPublic" class="form-label">Visible to Public</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    id="toggleVisibleToPublic" checked
                                                    onchange="toggleVisibilityText('publicStatusLabel', this)">
                                                <label class="form-check-label" for="toggleVisibleToPublic"
                                                    id="publicStatusLabel">Yes</label>
                                            </div>
                                        </div> --}}

                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex mt-2">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="button" style="margin-left: 10px;" onclick="history.back()"
                                            class="btn btn-danger">Cancel</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- database table end -->
    </div>

    <script src="{{ asset('packa/custom/user.js') }}"></script>
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
@endsection
