@extends('admin.layouts.layout')
@section('title', 'Edit User')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Users</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Users</li>
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
                                <div class="col-lg-12 py-5 px-5" style="background-color: #ffffff; border-radius: 10px;">
                                    <form id="contactForm" action="{{ route('users.update', $result->id) }}"
                                        enctype="multipart/form-data" method="post">
                                        {{ csrf_field() }}
                                        @method('PUT')
                                        <div class="container-fluid">
                                            <h4 class="card-title mb-4 text-primary">Update Users</h4>

                                            <!-- All Fields in One Div using d-grid -->
                                            <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">


                                                <!-- User Type -->
                                                <div>
                                                    <label for="designation" class="form-label text-secondary">User Type
                                                        <span style="color: red;">*</span></label>
                                                    <select class="form-select" id="userType" name="user_type" disabled
                                                        required>
                                                        <option value="">Select User Type</option>
                                                        @foreach (getUserType() as $key => $type)
                                                            <option value="{{ $key }}"
                                                                data-value="{{ $type }}"
                                                                {{ SELECT($key, $result->user_type_id) }}>
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
                                                            <option value="{{ $key }}"
                                                                data-value="{{ $role }}"
                                                                {{ SELECT($key, $result->user_role_id) }}>
                                                                {{ $role }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Program -->
                                                @if ($result->programs_id)
                                                    <div id="program_div">
                                                        <label for="userType" class="form-label text-secondary">Program<span
                                                                style="color: red;">*</span></label>
                                                        <select class="form-select" id="program" name="program">
                                                            <option value="">Select Program</option>
                                                            @foreach ($programs as $program)
                                                                <option value="{{ $program->id }}"
                                                                    {{ SELECT($program->id, $result->programs_id) }}>
                                                                    {{ $program->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif

                                                <!--Section -->
                                                @if ($result->sections_id)
                                                    <div id="section_div">
                                                        <label for="userType" class="form-label text-secondary">Section<span
                                                                style="color: red;">*</span></label>
                                                        <select class="form-select" id="section" name="section">
                                                            <option value="">Select Section</option>
                                                            @foreach ($sections as $section)
                                                                <option value="{{ $section->id }}"
                                                                    {{ SELECT($section->id, $result->sections_id) }}>
                                                                    {{ $section->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif

                                                @if (isset($result->facility_hierarchy) && $result->facility_hierarchy_id)
                                                    <!--Facility Level -->
                                                    <div id="facility_level_div">
                                                        <label for="facilityLevel"
                                                            class="form-label text-secondary">Facility
                                                            Level</label>
                                                        <select class="form-select" id="facility_level"
                                                            name="facility_level_id">
                                                            <option value="">Select Facility Level</option>
                                                            @foreach ($facility_levels as $facility_level)
                                                                <option value="{{ $facility_level->id }}"
                                                                    data-value="{{ $facility_level->name }}"
                                                                    {{ SELECT($facility_level->id, $result->facility_hierarchy->facility_level_id ?? '') }}>
                                                                    {{ $facility_level->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif

                                                <!--District -->
                                                @if (isset($result->facility_hierarchy) && $result->facility_hierarchy->facility_level_id == 2)
                                                    <div id="district_div">
                                                        <label for="userType"
                                                            class="form-label text-secondary">District</label>
                                                        <select class="form-select" id="district_id" name="district"
                                                            required>
                                                            <option value="">Select District</option>
                                                            @foreach ($districts as $district)
                                                                <option value="{{ $district->id }}"
                                                                    {{ SELECT($district->id, $result->facility_hierarchy->district_id ?? '') }}>
                                                                    {{ $district->name }}

                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif

                                                <!--HUD -->
                                                @if (isset($result->facility_hierarchy) && $result->facility_hierarchy->facility_level_id == 3)
                                                    <div id="hud_div">
                                                        <label for="userType" class="form-label text-secondary">HUD</label>
                                                        <select class="form-select" id="hud_id" name="hud" required>
                                                            <option value="">Select HUD</option>
                                                            @foreach ($huds as $hud)
                                                                <option value="{{ $hud->id }}"
                                                                    {{ SELECT($hud->id, $result->facility_hierarchy->hud_id ?? '') }}>
                                                                    {{ $hud->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif

                                                <!--Block -->
                                                @if (isset($result->facility_hierarchy) && $result->facility_hierarchy->facility_level_id == 4)
                                                    <div id="block_div">
                                                        <label for="userType"
                                                            class="form-label text-secondary">Block</label>
                                                        <select class="form-select" id="block_id" name="block" required>
                                                            <option value="">Select Block</option>
                                                            @foreach ($blocks as $block)
                                                                <option value="{{ $block->id }}"
                                                                    {{ SELECT($block->id, $result->facility_hierarchy->block_id ?? '') }}>
                                                                    {{ $block->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif

                                                <!--PHC -->
                                                @if (isset($result->facility_hierarchy) && $result->facility_hierarchy->facility_level_id == 5)
                                                    <div id="phc_div">
                                                        <label for="userType" class="form-label text-secondary">PHC</label>
                                                        <select class="form-select" id="phc_id" name="phc"
                                                            required>
                                                            <option value="">Select PHC</option>
                                                            @foreach ($phcs as $phc)
                                                                <option value="{{ $phc->id }}"
                                                                    {{ SELECT($phc->id, $result->facility_hierarchy->phc_id ?? '') }}>
                                                                    {{ $phc->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif

                                                <!--HSC -->
                                                @if (isset($result->facility_hierarchy) && $result->facility_hierarchy->facility_level_id == 6)
                                                    <div id="hsc_div">
                                                        <label for="userType"
                                                            class="form-label text-secondary">HSC</label>
                                                        <select class="form-select" id="hsc_id" name="hsc"
                                                            required>
                                                            <option value="">Select HSC</option>
                                                            @foreach ($hscs as $hsc)
                                                                <option value="{{ $hsc->id }}"
                                                                    {{ SELECT($hsc->id, $result->facility_hierarchy->hsc_id ?? '') }}>
                                                                    {{ $hsc->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif

                                                <div id="facility_filter_div" class="mb-3">
                                                    <!-- Facility ID Input with Validate Button inside the input -->
                                                    <label for="facility_id_input" class="form-label">Enter Facility
                                                        ID</label>
                                                    <div class="input-group">
                                                        <input type="text" id="facility_id_input" class="form-control"
                                                            placeholder="Enter Facility ID">
                                                        <button class="btn btn-primary" type="button"
                                                            onclick="validateFacilityId()">Validate</button>
                                                    </div>
                                                </div>

                                                @if (isset($result->facility_hierarchy) && $result->facility_hierarchy_id)
                                                    <div id="facility_div">
                                                        <label for="facility" class="form-label">Select Facility<span
                                                                style="color: red;">*</span></label>
                                                        <select name="facility_id" id="facility_id" class="form-select">
                                                            <option value="">-- Select Facility -- </option>
                                                            @foreach ($facilities as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                    {{ SELECT($value->id, $result->facility_hierarchy_id ?? '') }}>
                                                                    {{ $value->facility_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif





                                                <!-- Name Row -->
                                                <div>
                                                    <label for="name" class="form-label text-secondary">Name <span
                                                            style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" id="name"
                                                        placeholder="Enter name" name="name"
                                                        value="{{ $result->name }}" required>
                                                </div>

                                                <!-- Username Row -->
                                                <div>
                                                    <label for="username" class="form-label text-secondary">Username <span
                                                            style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" id="username"
                                                        placeholder="Enter username" name="username"
                                                        value="{{ $result->username }}" required>
                                                </div>

                                                <!-- Designation Row -->
                                                <div>
                                                    <label for="designation" class="form-label text-secondary">Designation
                                                        <span style="color: red;">*</span></label>
                                                    <select class="form-select" id="designation" name="designations_id">
                                                        <option value="">Select Designation</option>
                                                        @foreach ($designations as $key => $designation)
                                                            <option value="{{ $designation->id }}"
                                                                {{ SELECT($designation->id, $result->designations_id) }}>
                                                                {{ $designation->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                                <!-- Contact Number Row -->
                                                <div>
                                                    <label for="contactNumber" class="form-label text-secondary">Contact
                                                        Number
                                                        <span style="color: red;">*</span></label>
                                                    <input type="tel" class="form-control" id="contactNumber"
                                                        placeholder="Enter contact number" name="contact_number"
                                                        value="{{ $result->contact_number }}">
                                                </div>

                                                <!-- Email Row -->
                                                <div>
                                                    <label for="email" class="form-label text-secondary">Email ID <span
                                                            style="color: red;">*</span></label>
                                                    <input type="email" class="form-control" name="email"
                                                        value="{{ $result->email }}" id="email"
                                                        placeholder="Enter email">
                                                </div>

                                                <!-- Status Row -->
                                                <div>
                                                    <label for="status" class="form-label">Status</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="status" type="checkbox"
                                                            id="toggleStatus" value="1"
                                                            {{ CHECKBOX('status', $result->status) }}
                                                            onchange="toggleStatusText('statusLabel', this)">
                                                        <label class="form-check-label" for="toggleStatus"
                                                            id="statusLabel">{{ $result->status == 1 ? 'Active' : 'In-Active' }}</label>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="d-flex mt-2">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="button" style="margin-left: 10px;"
                                                    onclick="history.back()" class="btn btn-danger">Cancel</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <script src="{{ asset('packa/custom/user.js') }}"></script>
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
