@extends('admin.layouts.layout')
@section('title', 'Edit Document')
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .select2-container {
            width: 100% !important;
            /* Or set a fixed width, e.g., 300px */
        }
    </style>

    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Documents</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit {{ $result->document_type->name }}</li>
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
                        <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                            <!-- new form start ============================================-->
                            <form id="documentForm" action="{{ route('new-documents.update', $result->id) }}"
                                enctype="multipart/form-data" method="post">
                                {{ csrf_field() }}
                                @method('PUT')
                                <div class="card-body">
                                    <h4 class="card-title mb-4 text-primary">Edit {{ $result->document_type->name }}</h4>
                                    <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">

                                        @if (!in_array($result->document_type_id, [4, 15]))
                                            <input type="hidden" name="document_type_id"
                                                value="{{ $result->document_type_id }}">
                                        @endif
                                        @if (in_array($result->document_type_id, [4, 15]))
                                            <div class="font-weight-bold text-secondary">Select Type<span
                                                    style="color: red;">*</span>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="acts"
                                                    name="document_type_id" value="4"
                                                    {{ CHECKBOX('document_type_id', $result->document_type_id == 4) }}
                                                    required>
                                                <label class="form-check-label" for="acts">Acts</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="rules"
                                                    name="document_type_id" value="15"
                                                    {{ CHECKBOX('document_type_id', $result->document_type_id == 15) }}
                                                    required>
                                                <label class="form-check-label" for="rules">Rules</label>
                                            </div>
                                        @endif

                                        @if (in_array($result->document_type_id, [7]))


                                            <div class="font-weight-bold text-secondary">Select Option<span
                                                    style="color: red;">*</span>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="selectionOption"
                                                    value="section" id="sectionOption" required
                                                    {{ CHECKBOX('section_id', $result->section_id) }}>
                                                <label class="form-check-label" for="sectionOption">Section</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="selectionOption"
                                                    value="scheme" id="schemeOption"
                                                    {{ CHECKBOX('scheme_id', $result->scheme_id) }} required>
                                                <label class="form-check-label" for="schemeOption">Scheme</label>
                                            </div>


                                            <div id="sectionRow" style="display: none">
                                                <div class="font-weight-bold text-secondary">Select Sections </div>
                                                <select class="form-select select-dropdown" id="sectionDropdown"
                                                    name="section_id">
                                                    <option value=""> -- Select --</option>
                                                    @foreach ($sections as $key => $value)
                                                        <option value="{{ $key }}"
                                                            {{ SELECT($key, old('scetions')) }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div id="programDivisionsRow" style="display: none;">
                                                <div class="font-weight-bold text-secondary">Select Program Divisions
                                                </div>
                                                <select class="form-control select-dropdown" id="programDivisions">
                                                    <option value=""> -- Select --</option>
                                                    @foreach ($programs as $key => $value)
                                                        <option value="{{ $key }}"
                                                            {{ SELECT($key, $result->scheme->programs_id) }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <!-- Select Schemes -->
                                            <div id="schemesRow" style="display: none;">
                                                <div class="font-weight-bold text-secondary">Select Schemes <span
                                                        style="color: red;">*</span></div>
                                                <select class="form-control select-dropdown" id="schemes" name="scheme_id"
                                                    required>
                                                    <option> -- Select --</option>
                                                    @foreach ($schemes as $key => $value)
                                                        <option value="{{ $key }}"
                                                            {{ SELECT($key, $result->scheme_id) }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        @endif
                                        @if (!in_array($result->document_type_id, [4, 15, 7, 8, 9, 10, 11, 12, 14]))

                                            <!-- Program Divisions -->
                                            <div>
                                                <div class="font-weight-bold text-secondary">Select Program Divisions</div>
                                                <select class="form-control select-dropdown" id="programDivisions">
                                                    <option value=""> -- Select --</option>
                                                    @foreach ($programs as $key => $value)
                                                        <option value="{{ $key }}"
                                                            {{ SELECT($key, optional($result->scheme)->programs_id) }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <!-- Select Schemes -->
                                            <div>
                                                <div class="font-weight-bold text-secondary">Select Schemes <span
                                                        style="color: red;">*</span></div>
                                                <select class="form-control select-dropdown" id="schemes" name="scheme_id"
                                                    required>
                                                    <option> -- Select --</option>
                                                    @foreach ($schemes as $key => $value)
                                                        <option value="{{ $key }}"
                                                            {{ SELECT($key, $result->scheme_id) }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif

                                        @if (in_array(request('document_type'), [13]))
                                                <tr>
                                                    <td class="col-12 col-md-3">
                                                        <label for="eventType" class="form-label">Select Event
                                                            Type</label>
                                                    </td>
                                                    <td class="col-12 col-md-9">
                                                        <div class="position-relative">
                                                            <div class="select-wrapper">
                                                                <select class="form-select select-dropdown"
                                                                    id="eventType" name="event_type_id">
                                                                    <option> -- Select --</option>
                                                                    @foreach ($events_type as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            {{ SELECT($key, $result->event_type_id) }}>
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                    </td>
                                                </tr>
                                            @endif

                                        @if (in_array($result->document_type_id, [12]))
                                            <div>
                                                <div class="font-weight-bold text-secondary">Select Notification Type <span
                                                        style="color: red;">*</span></div>
                                                <select class="form-control select-dropdown" id="notificationTypeId"
                                                    name="notification_type_id" required>
                                                    <option> -- Select --</option>
                                                    @foreach ($notifications as $key => $value)
                                                        <option value="{{ $key }}"
                                                            {{ SELECT($key, $result->notification_type_id) }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif

                                        @if (in_array($result->document_type_id, [5]))
                                            <div>
                                                <div class="font-weight-bold text-secondary">Select Publication Type <span
                                                        style="color: red;">*</span></div>
                                                <select class="form-control select-dropdown" id="publicationTypeId"
                                                    name="publication_type_id" required>
                                                    <option> -- Select --</option>
                                                    @foreach ($publications as $key => $value)
                                                        <option value="{{ $key }}"
                                                            {{ SELECT($key, $result->publication_type_id) }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif




                                        <!-- Name -->
                                        <div>
                                            <label class="font-weight-bold text-secondary">Name</label>
                                            <input type="text" class="form-control" id="orderTitle"
                                                placeholder="Enter Name" name="name" value="{{ $result->name }}"
                                                required>
                                        </div>

                                        @if (in_array($result->document_type_id, [8, 9]))
                                        <div>
                                            
                                                <label class="font-weight-bold text-secondary">Finacial Year</label>
                                                <div class="input-group">
                                                <input type="text" id="yearInput" class="form-control"
                                                    placeholder="Enter Year" value="{{$result->financial_year}}" required>
                                                <span id="formattedYear" class="input-group-text"
                                                    style="display: none; color: black;"></span>
                                                <input type="hidden" name="financial_year" value="{{$result->financial_year}}" id="financialYearHidden">
                                            </div>
                                        </div>
                                        @endif

                                        <!-- Description -->
                                        @if (!in_array($result->document_type_id, [8, 9]))
                                            <div>
                                                <div class="font-weight-bold text-secondary">Description</div>
                                                <textarea class="form-control" id="fileDescription" placeholder="Enter file description" name="description">{{ $result->description }}</textarea>
                                            </div>
                                        @endif

                                            {{-- Image Upload --}}
                                        @if (in_array($result->document_type_id, [12, 13, 14]))
                                            <div>
                                                <div class="font-weight-bold text-secondary">Image Upload</div>
                                                <div class="input-group">
                                                    <!-- Image Upload Input -->
                                                    <input type="file" class="form-control" name="image"
                                                        id="imageUpload">

                                                    <!-- View Image Button -->
                                                    <div class="input-group-append">
                                                        <a href="{{ fileLink($result->image_url) }}" target="_blank"
                                                            class="btn btn-primary">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <small style="color: red;">Accepted .jpg .jpeg .png format & Allowed max size in
                                                    5MB</small>
                                            </div>
                                        @endif

                                        <!-- File Upload -->
                                        @if (!in_array($result->document_type_id, [4, 15, 14]))
                                            <div>
                                                <div class="font-weight-bold text-secondary">File Upload</div>
                                                <div class="input-group">
                                                    <!-- File Upload Input -->
                                                    <input type="file" class="form-control" name="document"
                                                        id="fileUpload">

                                                    <!-- View Document Button -->
                                                    <div class="input-group-append">
                                                        <a href="{{ fileLink($result->document_url) }}" target="_blank"
                                                            class="btn btn-primary">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <small style="color: red;">Accepted Only .pdf format & Allowed max size in
                                                    5MB</small>
                                            </div>
                                        @endif





                                        <!-- Language of Document -->
                                        @if (!in_array($result->document_type_id, [4, 15, 14]))
                                            <div>
                                                <div class="font-weight-bold text-secondary">Language of Document</div>
                                                <select class="form-select select-dropdown" id="language"
                                                    name="language">
                                                    <option value=""> -- Select --</option>
                                                    @foreach ($languages as $key => $value)
                                                        <option value="{{ $key }}"
                                                            {{ SELECT($key, $result->language_id) }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
@if (!in_array($result->document_type_id, [4, 15, 14]))
<div>
    <div class="font-weight-bold text-secondary">Tags</div>
    <select class="form-control select2" id="tags" name="tags[]" multiple>
        @foreach ($tags as $id => $name)
            <option value="{{ $id }}" {{ in_array($id, $selectedTags) ? 'selected' : '' }}>
                {{ $name }}
            </option>
        @endforeach
    </select>
</div>


@endif

                                        <!-- Reference Number -->
                                        @if (!in_array($result->document_type_id, [8, 9, 10, 11, 12, 13, 14]))
                                            <div>
                                                <div class="font-weight-bold text-secondary">Reference Number</div>
                                                <input type="text" class="form-control" id="referenceNumber"
                                                    name="reference_no" value="{{ $result->reference_no }}"
                                                    placeholder="Enter reference number" required>
                                            </div>
                                        @endif

                                        @if (in_array($result->document_type_id, [5, 11, 12, 13, 14]))
                                            {{-- Link --}}
                                            <div>
                                                <div class="font-weight-bold text-secondary">Link</div>
                                                <input type="text" class="form-control" name="link"
                                                    value="{{ $result->link }}" id="link"
                                                    placeholder="Enter link URL">
                                            </div>

                                            {{-- Link Title --}}
                                            <div>
                                                <div class="font-weight-bold text-secondary">Link Title</div>
                                                <input type="text" class="form-control" name="link_title"
                                                    value="{{ $result->link_title }}" id="linkTitle"
                                                    placeholder="Enter link title">
                                            </div>
                                        @endif

                                        <!-- Start Date -->
                                        @if (in_array($result->document_type_id, [13]))
                                            <div>
                                                <div class="font-weight-bold text-secondary">Start Date
                                                </div>
                                                <input type="date" class="form-control" name="start_date" id="startDate"
                                                    value="{{ $result->start_date }}" required>
                                            </div>

                                        <!--End Date -->
                                            <div>
                                                <div class="font-weight-bold text-secondary">End Date
                                                </div>
                                                <input type="date" class="form-control" name="end_date" id="endDate"
                                                    value="{{ $result->end_date }}" required>
                                            </div>
                                        @endif

                                        <!-- Date -->
                                        @if (!in_array($result->document_type_id, [8, 9, 13, 14]))
                                            <div>
                                                <div class="font-weight-bold text-secondary">Date
                                                </div>
                                                <input type="date" class="form-control" name="dated" id="dateOfGo"
                                                    value="{{ $result->dated }}" required>
                                            </div>
                                        @endif

                                        <!--Expiry Date -->
                                        @if (in_array($result->document_type_id, [12]))
                                            <div>
                                                <div class="font-weight-bold text-secondary">Expiry Date
                                                </div>
                                                <input type="date" class="form-control" name="expiry_date" id="expiryDateOfGo"
                                                    value="{{ $result->expiry_date }}" required>
                                            </div>
                                        @endif

                                        @if (isAdmin())
                                        <!-- Status -->
                                        <div>
                                            <div class="font-weight-bold text-secondary">Status</div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input " name="status" type="checkbox"
                                                    id="toggleStatus" value="1"
                                                    {{ CHECKBOX('status', $result->status) }}
                                                    onchange="toggleStatusText('statusLabel', this)">
                                                <label class="form-check-label" for="toggleStatus"
                                                    id="statusLabel">{{ $result->status == 1 ? 'Active' : 'In-Active' }}</label>
                                            </div>
                                        </div>

                                        <!-- Visible to Public -->
                                        <div>
                                            <div class="font-weight-bold text-secondary">Visible to Public</div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input " name="visible_to_public" type="checkbox"
                                                    id="toggleVisibleToPublic" value="1"
                                                    {{ CHECKBOX('visible_to_public', $result->visible_to_public) }}
                                                    onchange="toggleVisibleText('visibleToPublicLabel', this)">
                                                <label class="form-check-label" for="toggleVisibleToPublic"
                                                    id="visibleToPublicLabel">{{ $result->visible_to_public == 1 ? 'Yes' : 'No' }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <!-- Buttons -->
                                    <div class="d-flex mt-2">
                                        <button id="submitBtn" type="submit" class="btn btn-primary">Submit</button>
                                        <button type="button" style="margin-left: 10px;"
                                            class="btn btn-danger">Cancel</button>
                                    </div>
                                </div>
                        </div>
                        </form>
                        <!-- new form end ============================================-->
                    </div>
                </div>
            </div>
            <!-- insert the contents Here end -->
        </div>
        <!-- page inner end-->
    </div>

    <!-- database table end -->
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the radio buttons
            const sectionOption = document.getElementById('sectionOption');
            const schemeOption = document.getElementById('schemeOption');

            // Get the rows to show/hide
            const sectionRow = document.getElementById('sectionRow');
            const programDivisionsRow = document.getElementById('programDivisionsRow');
            const schemesRow = document.getElementById('schemesRow');

            // Function to toggle visibility
            function toggleVisibility() {
                // Make sure the elements exist before changing styles
                if (sectionOption && sectionOption.checked) {
                    if (sectionRow) sectionRow.style.display = ''; // Show section
                    if (programDivisionsRow) programDivisionsRow.style.display = 'none'; // Hide program divisions
                    if (schemesRow) schemesRow.style.display = 'none'; // Hide schemes
                } else if (schemeOption && schemeOption.checked) {
                    if (sectionRow) sectionRow.style.display = 'none'; // Hide section
                    if (programDivisionsRow) programDivisionsRow.style.display = ''; // Show program divisions
                    if (schemesRow) schemesRow.style.display = ''; // Show schemes
                }
            }

            // Attach event listeners to radio buttons if they exist
            if (sectionOption && schemeOption) {
                sectionOption.addEventListener('change', toggleVisibility);
                schemeOption.addEventListener('change', toggleVisibility);

                // Initial call to set the correct visibility based on current selection
                toggleVisibility();
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.mydatepicker, #datepicker').datepicker();
            $('.disable_submit').on('keyup keypress', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });
        });


        $(function() {
            $("#display_filename").keypress(function(e) {
                var keyCode = e.keyCode || e.which;

                $("#lblError").html("");

                //Regex for Valid Characters i.e. Alphabets and Numbers.
                var regex = /^[a-z\d\-_\s]+$/i;

                //Validate TextBox value against the Regex.
                var isValid = regex.test(String.fromCharCode(keyCode));
                if (!isValid) {
                    $("#lblError").html("Only Alphabets and Numbers allowed.");
                }
                return isValid;
            });
        });
    </script>
     <script>
        document.getElementById('yearInput').addEventListener('input', function() {
            // Allow only numeric input
            this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
    
            // Limit input to four digits
            if (this.value.length > 4) {
                this.value = this.value.slice(0, 4); // Trim to the first four characters
            }
    
            const inputYear = this.value;
            const year = parseInt(inputYear);
            const formattedYearSpan = document.getElementById('formattedYear');
            const hiddenYearInput = document.getElementById('financialYearHidden'); // Hidden input for final value
    
            // Only proceed if input is a valid year
            if (!isNaN(year) && year >= 1800 && year <= 2099) { // Adjust range as necessary
                const nextYear = year + 1;
                const formattedFinancialYear = `${year}-${nextYear}`;
                formattedYearSpan.style.display = 'inline'; // Show the formatted year span
                formattedYearSpan.innerHTML = `${year} - <span style="color:black;">${nextYear}</span>`;
    
                // Update hidden input with the financial year value
                hiddenYearInput.value = formattedFinancialYear;
            } else if (inputYear === '') {
                formattedYearSpan.style.display = 'none'; // Hide if input is empty
                hiddenYearInput.value = ''; // Clear hidden input
            } else {
                formattedYearSpan.style.display = 'none'; // Hide on invalid input
                hiddenYearInput.value = ''; // Clear hidden input
            }
        });
    
       
    </script>
    <script>
        $(document).ready(function() {
    $('.select2').select2({
        width: '100%',
        placeholder: "Select tags",
        allowClear: true
    });
});

    </script>
    <script src="{{ asset('packa/custom/document.js') }}"></script>
@endsection
