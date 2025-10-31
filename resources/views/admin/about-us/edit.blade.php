@extends('admin.layouts.layout')
@section('title', 'Edit Programs')
@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('packa/theme/assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}" />
    </head>
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Documents</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit AboutUs</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="container-fluid">
            <div class="page-inner">
                <div class="container-fluid mt-2">
                    <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                        <form id="eventForm" action="{{ route('about-us.update', $result->id) }}"
                            enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            @method('PUT')
                            <h4 class="card-title mb-4 text-primary">Edit AboutUs</h4>

                            <!-- All Fields in One Div using d-grid -->
                            <div class="d-grid gap-3 mb-3 grid-3 grid-2 grid-1">

                                <div>
                                    <label for="contentType" class="form-label">Content Type</label>
                                    <select name="submenu_id" id="content_type" class="form-select" disabled>
                                        <option value="">-- Select Content Type -- </option>
                                        @foreach ($configuration_content_types as $key => $value)
                                            <option value="{{ $value->id }}" data-value="{{ $value->slug }}"
                                                {{ SELECT($value->id, $result->submenu_id) }}>
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="EventName" class="form-label">Title<span
                                            style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="EventName" name="name"
                                        value="{{ $result->name }}" placeholder="Enter Title">
                                </div>

                                <div id="order_div">
                                    <label for="orderNumber" class="form-label">Order<span
                                            style="color: red;">*</span></label>
                                    <input type="number" class="form-control" id="orderNumber" name="order"
                                        value="{{ $result->order_no }}" placeholder="Enter Order Number">
                                </div>

                                <!-- Optional PDF Upload Section -->
                                <div id="document_div">
                                    <label for="eventPdf" class="form-label">Upload PDF</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="eventPdf" name="document">
                                        <!-- View Document Button -->
                                        <a href="{{ fileLink($result->document_url) }}" target="_blank"
                                            class="btn btn-primary input-group-text">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                    <small style="color: red;">Accepted formats: .pdf, max size 5MB</small>
                                </div>

                                <div id="image_div">
                                    <label for="imageUpload" class="form-label">Upload Image<span
                                            style="color: red;">*</span></label>
                                    <div class="input-group">
                                        <!-- File Upload Input -->
                                        <input type="file" class="form-control" id="imageUpload" name="image"
                                            accept="image/*">
                                        <!-- View Document Button -->
                                        <a href="{{ fileLink($result->image_url) }}" target="_blank"
                                            class="btn btn-primary input-group-text">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                    <small style="color: red;">Accepted formats: .jpg, .png, .jpeg</small>
                                </div>


                                <div id="thumbnail_div"> <!-- Smaller width for Thumbnail -->
                                    <label for="Thumbnail" class="form-label">Thumbnail<span
                                            style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="Thumbnail"
                                        value="{{ $result->thumbnail_name }}" placeholder="Enter Title"
                                        name="thumbnail_name">
                                </div>

                                <div id="souvenir_div"> <!-- Adjusted width for souvenir -->
                                    <label for="souvenir" class="form-label">Souvenir <span
                                            style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="souvenir"
                                        value="{{ $result->souvenir_name }}" placeholder="Enter Title"
                                        name="souvenir_name">
                                </div>

                            </div>
                            <div> <!-- Larger width for Description -->
                                <label for="eventDescription" class="form-label">Description <span
                                        style="color: red;">*</span></label>
                                <div class="d-flex flex-column">
                                    <textarea class="textarea_editor form-control" rows="15" id="content" name="description"
                                        placeholder="Enter description">{{ $result->description }}</textarea>
                                </div>
                            </div>




                            <!-- Status -->
                            <div class="col-md-4">
                                <div class="font-weight-bold text-secondary">Status:</div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="status" type="checkbox" id="toggleStatus"
                                        value="1" {{ CHECKBOX('status', $result->status) }}
                                        onchange="toggleStatusText('statusLabel', this)">
                                    <label class="form-check-label" for="toggleStatus"
                                        id="statusLabel">{{ $result->status == 1 ? 'Active' : 'In-Active' }}</label>
                                </div>
                            </div>

                            <!-- Visible to Public -->
                            {{-- <div class="col-md-4">
                                <div class="font-weight-bold text-secondary">Visible to Public:</div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="visible_to_public"
                                        id="toggleVisibleToPublic"
                                        {{ CHECKBOX('visible_to_public', $result->visible_to_public) }} value="1"
                                        onchange="toggleVisibilityText('publicStatusLabel', this)">
                                    <label class="form-check-label" for="toggleVisibleToPublic"
                                        id="publicStatusLabel">{{ $result->visible_to_public == 1 ? 'Yes' : 'No' }}</label>
                                </div>
                            </div> --}}

                            <!-- Buttons -->
                            <div class="d-flex mt-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-danger" onclick="history.back()" style="margin-left: 10px;">
                                    Cancel
                                </button>

                            </div>
                            
                    </form>

                    <div id="previous_directors_div">

                        <div class="container-fluid mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Previous Directors List</h4>
                                        <!-- Add Director Button -->
                                        <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                            data-bs-target="#addDirectorModal">
                                            <i class="fa fa-plus"></i> Add
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <!-- Table Layout -->
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 20%;">Name</th>
                                                        <th style="width: 20%;">Image</th>
                                                        <th style="width: 20%;">Qualification</th>
                                                        <th style="width: 20%;">Year</th>
                                                        <th style="width: 8%;">Status</th>
                                                        <th style="width: 10%;" class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($previous_directors as $previous_director)
                                                        <!-- Director 1 start -->
                                                        <tr>
                                                            <td>{{ $previous_director->name }}</td>
                                                            <td>
                                                                <img src="{{ fileLink($previous_director->image_url) }}"
                                                                    alt="Logo" style="max-width: 100px;">
                                                            </td>
                                                            <td>{{ $previous_director->qualification }}</td>
                                                            <td>{{ $previous_director->start_year }} -
                                                                {{ $previous_director->end_year }}</td>
                                                            <td class="text-{{ $previous_director->status == 1 ? 'success' : 'danger' }}"
                                                                style="font-weight: bold;">
                                                                {{ $previous_director->status == 1 ? 'Active' : 'In-Active' }}
                                                            </td>
                                                            <td class="text-center">
                                                                <!-- Actions with icons -->
                                                                <div class="form-button-action">
                                                                    <button type="button"
                                                                        class="btn btn-link btn-primary text-center"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editPreviousDirectorModal"
                                                                        onclick="editPrviousDirector('{{ $previous_director->id }}', '{{ $previous_director->qualification }}', '{{ $previous_director->name }}', '{{ $previous_director->start_year }}', '{{ $previous_director->end_year }}', '{{ fileLink($previous_director->image_url) }}', '{{ $previous_director->status }}')">
                                                                        <i class="fa fa-edit"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <!-- Director 1 end -->
                                                    <!-- Repeat similar rows for additional directors -->
                                                </tbody>
                                            </table>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- director image end=====================================================================================================-->

                        <!-- modal for adding Director start -->
                        <!-- Modal Popup for Adding Director -->
                        <div class="modal fade" id="addDirectorModal" tabindex="-1"
                            aria-labelledby="addDirectorModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addDirectorModalLabel">Add New Director</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('testimonials.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="configuration_content_type_id"
                                                value="23">

                                            <!-- Name Title Field -->
                                            <div class="mb-3">
                                                <label for="directorTitle" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="DirectorTitle"
                                                    placeholder="Enter Director Name" name="name">
                                            </div>

                                            <!-- Select Image Field with Preview -->
                                            <div class="mb-3">
                                                <label for="directorImage" class="form-label">Select Director
                                                    Image</label>
                                                <input type="file" class="form-control" id="DirectorImage"
                                                    accept="image/*" required name="testimonial_image">
                                                <small class="form-text text-danger">Accepted formats: .jpg, .jpeg,
                                                    .png,
                                                    max size:
                                                    5MB</small>
                                            </div>

                                            <!-- Qualification Title Field -->
                                            <div class="mb-3">
                                                <label for="qualificationTitle"
                                                    class="form-label">Qualification</label>
                                                <input type="text" class="form-control" id="qualficationTitle"
                                                    placeholder="Enter Director Qualification" name="qualification">
                                            </div>

                                            <!-- Start Year Field -->
                                            <div class="mb-3">
                                                <label for="startTitle" class="form-label">Start Year</label>
                                                <input type="text" class="form-control" id="startTitle"
                                                    placeholder="Enter Director Start Year" name="start">
                                            </div>

                                            <!-- End Year Field -->
                                            <div class="mb-3">
                                                <label for="endrTitle" class="form-label">End Year</label>
                                                <input type="text" class="form-control" id="endTitle"
                                                    placeholder="Enter Director ENd Year" name="end">
                                            </div>

                                            <!-- Status Toggle -->
                                            <div class="mb-3">
                                                <label for="directorStatus" class="form-label">Status</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="directorStatus" name="status" value="1"
                                                        onchange="toggleStatusText('directorStatusText', this)">
                                                    <label class="form-check-label" for="directorStatus"
                                                        id="directorStatusText">Active</label>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="button" class="btn btn-danger" onclick="history.back()" style="margin-left: 10px;">
                                                    Cancel
                                                </button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- modal for adding director end -->

                        <!-- model for edit director start -->
                        <!-- Edit Director Modal -->
                        <div class="modal fade" id="editDirectorModal" tabindex="-1"
                            aria-labelledby="editDirectorModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editDirectorModalLabel">Edit Director</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editDirectorForm" action="{{ route('testimonials.update', ':id') }}" enctype="multipart/form-data"
                                            method="post">
                                            {{ csrf_field() }} @method('PUT')
                                            <input type="hidden" id="directorId" name="id">

                                            <!-- Director Title -->
                                            <div class="mb-3">
                                                <label for="editDirectorTitle" class="form-label">Director Name</label>
                                                <input type="text" class="form-control" id="editDirectorTitle"
                                                    placeholder="Enter director title" name="name">
                                            </div>

                                            <!-- Qualification Title Field -->
                                            <div class="mb-3">
                                                <label for="qualificationTitle"
                                                    class="form-label">Qualification</label>
                                                <input type="text" class="form-control" id="editDirectorQualification"
                                                    placeholder="Enter Director Qualification" name="qualification">
                                            </div>

                                            <!-- Start Year Field -->
                                            <div class="mb-3">
                                                <label for="startTitle" class="form-label">Start Year</label>
                                                <input type="text" class="form-control" id="editDirectorStartYear"
                                                    placeholder="Enter Director Start Year" name="start">
                                            </div>

                                            <!-- End Year Field -->
                                            <div class="mb-3">
                                                <label for="endrTitle" class="form-label">End Year</label>
                                                <input type="text" class="form-control" id="editDirectorEndYear"
                                                    placeholder="Enter Director ENd Year" name="end">
                                            </div>

                                            <!-- New Director Image Preview -->
                                            <div class="mb-3">
                                                <label for="editDirectorImage" class="form-label">New Director
                                                    Image</label>
                                                <div class="input-group">
                                                    <input type="file" class="form-control" id="editDirectorImage" name="testimonial_image">
                                                    <a href="" target="_blank" id="currentDirectorPreview"
                                                        class="btn btn-primary input-group-text">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                                <small class="text-muted">Select a new image to update.</small>
                                            </div>

                                            <!-- Status Toggle -->
                                            <div class="mb-3">
                                                <label for="editDirectorStatus" class="form-label">Status</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        id="editDirectorStatus" name="status"
                                                        onchange="toggleStatusText('editDirectorStatusLabel', this)">
                                                    <label class="form-check-label" for="editDirectorStatus"
                                                        id="editDirectorStatusLabel">Active</label>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="button" class="btn btn-danger" onclick="history.back()" style="margin-left: 10px;">
                                                    Cancel
                                                </button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- model for edit director end -->

                    </div>
                    </div>


                </div>
            </div>
        </div>
        <!-- database table end -->
    </div>
    <script src="{{ asset('packa/theme/assets/node_modules/html5-editor/wysihtml5-0.3.0.js') }}"></script>
    <script src="{{ asset('packa/theme/assets/node_modules/html5-editor/bootstrap-wysihtml5.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('.textarea_editor').wysihtml5();
        });
    </script>
    <script src="{{ asset('packa/custom/about-us.js') }}"></script>
    <script>
        function editPrviousDirector(id, qualification, name, start, end, imageUrl, Status) {
            document.getElementById('directorId').value = id; // Set the ID for the hidden input
            document.getElementById('editDirectorQualification').value = qualification; // Set the ID for the hidden input
            document.getElementById('editDirectorTitle').value = name; // Set the name
            document.getElementById('editDirectorStartYear').value = start; // Set the name
            document.getElementById('editDirectorEndYear').value = end; // Set the name
            document.getElementById('currentDirectorPreview').href = imageUrl; // Set the image preview
            document.getElementById('editDirectorStatus').checked = Status == 1; // Check if the status is active
            document.getElementById('editDirectorStatusLabel').textContent = Status == 1 ? 'Active' : 'In-Active';

            $('#editDirectorModal').modal('show');

            const form = document.getElementById('editDirectorForm');
            form.action = form.action.replace(':id', id);

        }
    </script>
@endsection
