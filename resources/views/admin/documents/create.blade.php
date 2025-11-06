@extends('admin.layouts.layout')
@section('title', 'Upload Document')
@section('content')
    <style>
        #typeofdoc.readonly {
            pointer-events: none;
            background-color: #e9ecef;
        }

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
                        <li class="breadcrumb-item"><a href="#">Documents</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create
                            {{ $document_types->firstWhere('id', request('document_type'))->name ?? 'Documents' }}</li>
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
                            <form id="documentForm" form action="{{ route('new-documents.store') }}"
                                enctype="multipart/form-data" method="post" class="disable_submit">
                                {{ csrf_field() }}
                                <div class="table-responsive">
                                    <h4 class="card-title mb-4 text-primary">Create
                                        {{ $document_types->firstWhere('id', request('document_type'))->name ?? 'Documents' }}
                                    </h4>
                                    <table class="table table-borderless">
                                        <tbody>
                                            <!-- Select Type of Document  -->
                                            @if (!in_array(request('document_type'), [4, 6]))
                                                <tr class="d-none">
                                                    <td>
                                                        <label for="typeofdoc" class="form-label">Select
                                                            Type Of Document <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <select class="form-select" id="typeofdoc" name="document_type_id">
                                                            @foreach ($document_types as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                    data-value="{{ $value->slug_key }}"
                                                                    {{ SELECT($value->id, request('document_type')) }}>
                                                                    {{ $value->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            @endif
                                            <!-- Select RTI type -->
                                            @if (in_array(request('document_type'), [7]))
                                                <tr>
                                                    <td>
                                                        <label class="form-label">Select Option <span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="selectionOption" value="section" id="sectionOption"
                                                                required>
                                                            <label class="form-check-label"
                                                                for="sectionOption">Section</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="selectionOption" value="scheme" id="schemeOption"
                                                                checked required>
                                                            <label class="form-check-label"
                                                                for="schemeOption">Scheme</label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr id="sectionRow" style="display: none">
                                                    <td class="col-12 col-md-3">
                                                        <label for="sectionInput" class="form-label">Select Sections</label>
                                                    </td>
                                                    <td class="col-12 col-md-9">
                                                        <div class="position-relative">
                                                            <div class="select-wrapper">
                                                                <select class="form-select select-dropdown"
                                                                    id="sectionDropdown" name="section_id">
                                                                    <option value=""> -- Select --</option>
                                                                    @foreach ($sections as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            {{ SELECT($key, old('scetions')) }}>
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                    </td>
                                                </tr>
                                                @if (!isState())
                                                    <tr id="programDivisionsRow" style="display: none;">
                                                        <td class="col-12 col-md-3">
                                                            <label for="programDivisionsInput" class="form-label">Select
                                                                Program
                                                                Divisions</label>
                                                        </td>
                                                        <td class="col-12 col-md-9">
                                                            <div class="position-relative">
                                                                <div class="select-wrapper">
                                                                    <select class="form-select select-dropdown"
                                                                        id="programDivisions">
                                                                        <option> -- Select --</option>
                                                                        @foreach ($programs as $key => $value)
                                                                            <option value="{{ $key }}"
                                                                                {{ SELECT($key, old('programs')) }}>
                                                                                {{ $value }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                        </td>
                                                    </tr>
                                                @endif

                                                <!-- Select Schemes -->
                                                <tr id="schemesRow" style="display: none;">
                                                    <td class="col-12 col-md-3">
                                                        <label for="SchemesInput" class="form-label ">Select Schemes <span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td class="col-12 col-md-9">
                                                        <div class="position-relative">
                                                            <div class="select-wrapper">
                                                                <select class="form-select select-dropdown" id="schemes"
                                                                    name="scheme_id" required>
                                                                    <option> -- Select --</option>
                                                                    @foreach ($schemes as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            {{ SELECT($key, old('schemes')) }}>
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif



                                            <!-- Select Program Divisions -->

                                            @if (!in_array(request('document_type'), [4, 6, 7, 8, 9, 10, 11, 12, 14, 16]))

                                                @if (!isState())
                                                    <tr>
                                                        <td class="col-12 col-md-3">
                                                            <label for="programDivisionsInput" class="form-label">Select
                                                                Program
                                                                Divisions</label>
                                                        </td>
                                                        <td class="col-12 col-md-9">
                                                            <div class="position-relative">
                                                                <div class="select-wrapper">
                                                              <select name="programs_id" id="programs_id" class="form-control" >
    <option value="">-- Select Program -- </option>
   @foreach ($programs as $id => $name)
    <option value="{{ $id }}">
        {{ $name }}
    </option>
@endforeach

</select>
                                                                </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                <!-- Select Schemes -->
                                                <tr>
                                                    <td class="col-12 col-md-3">
                                                        <label for="SchemesInput" class="form-label ">Select Schemes <span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td class="col-12 col-md-9">
                                                        <div class="position-relative">
                                                            <div class="select-wrapper">
                                                               <select name="scheme_id" id="scheme_id" class="form-control">
    <option value="">-- Select Scheme -- </option>
@foreach ($schemes as $id => $name)
    <option value="{{ $id }}"
        {{ old('scheme_id') == $id ? 'selected' : '' }}>
        {{ $name }}
    </option>
@endforeach
</select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
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
                                                                    <option value=""> -- Select --</option>
                                                                    @foreach ($events_type as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            {{ SELECT($key, old('event_types')) }}>
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if (in_array(request('document_type'), [5]))
                                                <tr>
                                                    <td class="col-12 col-md-3">
                                                        <label for="publicationType" class="form-label">Select Publication
                                                            Type</label>
                                                    </td>
                                                    <td class="col-12 col-md-9">
                                                        <div class="position-relative">
                                                            <div class="select-wrapper">
                                                                <select class="form-select select-dropdown"
                                                                    id="publicationType" name="publication_type_id">
                                                                    <option> -- Select --</option>
                                                                    @foreach ($publications as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            {{ SELECT($key, old('publications')) }}>
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if (in_array(request('document_type'), [12]))
                                                <tr>
                                                    <td class="col-12 col-md-3">
                                                        <label for="notificationType" class="form-label">Select
                                                            Notification Type</label>
                                                    </td>
                                                    <td class="col-12 col-md-9">
                                                        <div class="position-relative">
                                                            <div class="select-wrapper">
                                                                <select class="form-select select-dropdown"
                                                                    id="notificationType" name="notification_type_id">
                                                                    <option value=""> -- Select --</option>
                                                                    @foreach ($notifications as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            {{ SELECT($key, old('notifications')) }}>
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                    </td>
                                                </tr>
                                            @endif

                                            <!-- Select Events -->
                                            @if (in_array(request('document_type'), [16]))
                                                <tr>
                                                    <td class="col-12 col-md-3">
                                                        <label for="eventType" class="form-label">Select Events</label>
                                                    </td>
                                                    <td class="col-12 col-md-9">
                                                        <div class="position-relative">
                                                            <div class="select-wrapper">
                                                                <select class="form-select select-dropdown"
                                                                    id="eventType" name="event_id">
                                                                    <option value=""> -- Select --</option>
                                                                    @foreach ($events as $key => $value)
                                                                        <option value="{{ $value }}"
                                                                            {{ SELECT($key, old('events')) }}>
                                                                            {{ $key }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                    </td>
                                                </tr>
                                            @endif

                                            <!-- Select Acts or Rules -->
                                            @if (in_array(request('document_type'), [4, 6]))
                                                <tr>
                                                    <td>
                                                        <label class="form-label">Select Type <span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="document_type_id" id="acts" value="4"
                                                                required>
                                                            <label class="form-check-label" for="acts">Acts</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="document_type_id" id="rules" value="6"
                                                                required>
                                                            <label class="form-check-label" for="rules">Rules</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif


                                            @if (!in_array(request('document_type'), [4, 6]))
                                                <!-- Enter File Name to Display -->
                                                <tr>
                                                    <td>
                                                        <label for="fileName" class="form-label">Name<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input name="name" type="text" class="form-control"
                                                            id="fileName" placeholder="Enter file name" required>
                                                    </td>
                                                </tr>
                                            @endif
                                            <!-- Enter Financial Year -->
                                            @if (in_array(request('document_type'), [8, 9]))
                                                <tr>
                                                    <td>
                                                        <label for="fileName" class="form-label">Financial Year<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="yearInput"
                                                                placeholder="Enter Financial Year" name="financial_year"
                                                                required>
                                                            <span id="formattedYear" class="input-group-text"
                                                                style="display: none; color: black;"></span>
                                                            <input type="hidden" name="financial_year"
                                                                id="financialYearHidden">
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                            <!-- Add File Description -->
                                            @if (!in_array(request('document_type'), [8, 9]))
                                                <tr>
                                                    <td class="col-12 col-md-3">
                                                        <label for="fileDescription"
                                                            class="form-label">Description</label>
                                                    </td>
                                                    <td class="col-12 col-md-9">
                                                        <textarea class="form-control" id="fileDescription" placeholder="Enter file description" name="description"></textarea>
                                                    </td>
                                                </tr>
                                            @endif

                                            <!-- Start Date -->
                                            @if (in_array(request('document_type'), [13]))
                                                <tr>
                                                    <td>
                                                        <label for="date" class="form-label">Start Date<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input type="date" class="form-control" name="start_date"
                                                            id="startDate" required>
                                                    </td>
                                                </tr>

                                                <!-- End Date -->
                                                <tr>
                                                    <td>
                                                        <label for="date" class="form-label">End Date<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input type="date" class="form-control" name="end_date"
                                                            id="endDate" required>
                                                    </td>
                                                </tr>
                                            @endif


                                            <!-- Create Image -->
                                            @if (in_array(request('document_type'), [12, 13, 14]))
                                                <tr>
                                                    <td>
                                                        <label for="createImage" class="form-label">Upload Image</label>
                                                    </td>
                                                    <td>
                                                        <input type="file" name="image" accept="image/*"
                                                            class="form-control" id="createImage">
                                                        <small style="color: red;">Accepted .jpg .jpeg .png format &
                                                            allowed max size is
                                                            5MB</small>
                                                    </td>
                                                    <td>
                                                        <img id="imagePreview" src="#" alt="Image Preview"
                                                            class="img-fluid"
                                                            style="max-width: 100px; display: none; border: 1px solid #ccc; border-radius: 10px; padding: 5px; cursor: pointer;">
                                                    </td>
                                                </tr>
                                            @endif
                                            <!-- Create Document -->
                                            @if (!in_array(request('document_type'), [4, 6, 14]))
                                                <tr>
                                                    <td>
                                                        <label for="createDocument" class="form-label">Upload File</label>
                                                    </td>
                                                    <td>
                                                        <input type="file" name="document" class="form-control"
                                                            id="createDocument" placeholder="Enter document title">
                                                        <small style="color: red;">Accepted .pdf format &
                                                            allowed max size is
                                                            5MB</small>
                                                    </td>
                                                </tr>



                                                <!-- Language of Document -->

                                                <tr>
                                                    <td class="col-12 col-md-3">
                                                        <label for="language" class="form-label">Language of Document</label>
                                                    </td>
                                                    <td class="col-12 col-md-9">
                                                        <select class="form-select select-dropdown" id="language"
                                                            name="language">
                                                            <option value=""> -- Select --</option>
                                                            @foreach ($languages as $key => $value)
                                                                <option value="{{ $key }}">
                                                                    {{ $value }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endif




                                            <!-- Enter GO's/Letter/Reference Number -->
                                            @if (!in_array(request('document_type'), [8, 9, 10, 11, 12, 13, 14, 16]))
                                                <tr>
                                                    <td>
                                                        <label for="referenceNumber" class="form-label">Reference Number
                                                            <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="referenceNumber"
                                                            name="reference_no" placeholder="Enter reference number">
                                                    </td>

                                                    <td></td>
                                                </tr>
                                            @endif

                                            @if (in_array(request('document_type'), [5, 11, 13, 14]))
                                                <!-- Link -->
                                                <tr>
                                                    <td>
                                                        <label for="link" class="form-label">Link</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="link"
                                                            name="link" placeholder="Enter Link">
                                                    </td>
                                                </tr>
                                                <!-- Link Title -->
                                                <tr>
                                                    <td>
                                                        <label for="linkTitle" class="form-label">Link Title</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="linkTitle"
                                                            name="link_title" placeholder="Enter Link Title">
                                                    </td>
                                                </tr>
                                            @endif
                                            <!-- Date -->
                                            @if (!in_array(request('document_type'), [8, 9, 13, 14, 16]))
                                                <tr>
                                                    <td>
                                                        <label for="date" class="form-label">Date<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input type="date" class="form-control" name="dated"
                                                            id="date">
                                                    </td>
                                                </tr>
                                            @endif

                                            <!-- Date -->
                                            @if (in_array(request('document_type'), [12]))
                                                <tr>
                                                    <td>
                                                        <label for="date" class="form-label">Expiry Date<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input type="date" class="form-control" name="expiry_date"
                                                            id="date">
                                                    </td>
                                                </tr>
                                            @endif



                                            @if (isAdmin())
                                            <!-- Visible to public -->
                                            <tr>
                                                <td>
                                                    <label for="status" class="form-label">Visible to
                                                        Public</label>
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" name="visible_to_public"
                                                            type="checkbox" id="toggleVisibleToPublic" value="1"
                                                            {{ CHECKBOX('document_visible_to_public') }}
                                                            onchange="toggleVisibleText('visibleToPublicLabel', this)">
                                                        <label class="form-check-label" for="toggleVisibleToPublic"
                                                            id="visibleToPublicLabel">No</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Status -->
                                            <tr>
                                                <td>
                                                    <label for="status" class="form-label">Status</label>
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
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Buttons -->
                                <div class="d-flex mt-2">
                                    <button type="submit" id="submitBtn" class="btn btn-primary"
                                        onclick="validateForm()">Submit</button>
                                    <button type="button" class="btn btn-danger" onclick="history.back()" style="margin-left: 10px;">
                                        Cancel
                                    </button>

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

        // Optionally, ensure the financial year is set before form submission
        document.getElementById('submitBtn').addEventListener('click', function(e) {
            const hiddenYearInput = document.getElementById('financialYearHidden').value;
            if (!hiddenYearInput) {
                alert('Please enter a valid financial year.');
                e.preventDefault(); // Prevent form submission if no valid financial year is set
            }
        });
    </script>
    <script>
        document.getElementById('createImage').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = URL.createObjectURL(file);
                imagePreview.style.display = 'block';
            }
        });
    </script>
    <script>
     
const programSelect = document.getElementById('programs_id');
const schemeSelect = document.getElementById('scheme_id');

programSelect.addEventListener('change', () => {
    const programId = programSelect.value;
    schemeSelect.innerHTML = '<option value="">-- Select Scheme --</option>';

    if (!programId) return;

    fetch('{{ route('list-scheme') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ program_id: programId }),
    })
    .then(res => res.json())
    .then(data => {
        data.data.forEach(scheme => {
            const option = document.createElement('option');
            option.value = scheme.id;
            option.textContent = scheme.name;
            schemeSelect.appendChild(option);
        });
    })
    .catch(console.error);
});
</script>
    
    <script>
        document.getElementById('typeofdoc').classList.add('readonly');
    </script>
    <script src="{{ asset('packa/custom/document.js') }}"></script>
@endsection
