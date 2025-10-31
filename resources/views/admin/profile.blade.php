@extends('admin.layouts.layout')
@section('title', env('APP_GLOBAL_NAME'))
@section('content')

<div class="container">
    <div class="page-inner">
        <div class="container mt-5">
            <!-- Card Section -->
            <div id="editableCard" class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>User Profile</h5>
                    <!-- Edit Button -->
                    <button id="editButton" type="button" class="btn btn-primary">Edit</button>
                </div>
                <div class="card-body">
                    <form id="userDetailsForm" method="POST" action="{{ route('admin.updateUserProfile', $result->id) }}">
                        @csrf

                        <div class="row mb-3">
                            <!-- Name -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ $result->name }}" disabled>
                            </div>

                            <!-- Username -->
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" class="form-control" value="{{ $result->username }}" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ $result->email }}" disabled>
                            </div>

                            <!-- Designation -->
                            <div class="col-md-6">
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" id="designation" class="form-control" value="{{ $result->designations->name ?? '' }}" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Contact Number -->
                            <div class="col-md-6">
                                <label for="contact" class="form-label">Contact Number</label>
                                <div class="input-group">
                                    <span class="input-group-text">+91</span>
                                    <input type="text" id="contact" name="contact_number" class="form-control" value="{{ str_replace('+91', '', $result->contact_number ?? '') }}" maxlength="10" disabled>
                                </div>
                            </div>


                            <!-- User Type -->
                            <div class="col-md-6">
                                <label for="userType" class="form-label">User Type</label>
                                <input type="text" id="userType" class="form-control" value="{{ findUserType($result->user_type_id) }}" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- User Role -->
                            <div class="col-md-6">
                                <label for="userRole" class="form-label">User Role</label>
                                <input type="text" id="userRole" class="form-control" value="{{ findUserRole($result->user_role_id) ?? '' }}" disabled>
                            </div>

                            <!-- Facility Name -->
                            <div class="col-md-6">
                                <label for="facilityName" class="form-label">Facility Name</label>
                                <input type="text" id="facilityName" class="form-control" value="{{ $result->facility_hierarchy->facility_name ?? '' }}" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Program Name -->
                            @if(isState() && isUser())
                            <div class="col-md-6">
                                <label for="programName" class="form-label">Program Name</label>
                                <input type="text" id="programName" class="form-control" value="{{ $result->sections->program->name ?? 'General' }}" disabled>
                            </div>
                            @else
                            <div class="col-md-6">
                                <label for="programName" class="form-label">Program Name</label>
                                <input type="text" id="programName" class="form-control" value="{{ $result->programs->name ?? 'General' }}" disabled>
                            </div>
                            @endif
                        </div>

                        <!-- Save and Cancel Buttons -->
                        <div class="text-end">
                            <button type="submit" id="saveButton" class="btn btn-success" style="display: none;">Save</button>
                            <button type="button" onclick="window.location.href='{{ route('admin.dashboard') }}';" class="btn btn-danger">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const editButton = document.getElementById('editButton');
    const saveButton = document.getElementById('saveButton');
    const form = document.getElementById('userDetailsForm');
    const contactInput = document.getElementById('contact');
    const inputsToEdit = ['name', 'email', 'contact'];

    // Toggle Edit Mode
    editButton.addEventListener('click', () => {
        inputsToEdit.forEach(id => {
            const input = document.getElementById(id);
            if (input) input.disabled = !input.disabled;
        });

        // Toggle Buttons
        saveButton.style.display = saveButton.style.display === 'none' ? 'inline-block' : 'none';
        editButton.innerText = editButton.innerText === 'Edit' ? 'Cancel' : 'Edit';
    });

    // Restrict Contact Input to Digits
    contactInput.addEventListener('input', () => {
        contactInput.value = contactInput.value.replace(/\D/g, ''); // Allow digits only
        if (contactInput.value.length > 10) {
            contactInput.value = contactInput.value.slice(0, 10); // Truncate to 10 digits
        }
    });

    // Add Validation
    form.addEventListener('submit', (e) => {
        let isValid = true;
        let errorMessage = '';

        // Validate Email
        const emailInput = document.getElementById('email');
        if (emailInput && !validateEmail(emailInput.value)) {
            isValid = false;
            errorMessage += 'Please enter a valid email address.\n';
        }

        // Validate Contact Number
        if (contactInput && contactInput.value.length !== 10) {
            isValid = false;
            errorMessage += 'Please enter a valid 10-digit contact number.\n';
        }

        if (!isValid) {
            alert(errorMessage);
            e.preventDefault(); // Prevent form submission
        } else {
            // Prepend country code before submitting
            contactInput.value = `+91${contactInput.value}`;
        }
    });

    // Email Validation Function
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});

</script>

@endsection
