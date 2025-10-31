@extends('admin.layouts.layout')
@section('title', 'List HEalth Walk')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Documents</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create HealthWalk</li>
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
                    <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                        <form id="healthwalkForm" action="{{ route('health-walk.store') }}" enctype="multipart/form-data"
                            method="post" id="myForm">
                            {{ csrf_field() }}
                            <h4 class="card-title mb-4 text-primary">Create Health Walk</h4>

                            <!-- All Fields in One Div using d-grid -->
                            <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                {{-- <div>
                                    <label for="district" class="form-label">District <span
                                            style="color: red;">*</span></label>
                                    <select name="district_id" id="district_id" class="form-control">
                                        <option value="">-- Select District -- </option>
                                        @foreach ($districts as $key => $value)
                                            <option value="{{ $value->id }}"
                                                {{ SELECT($value->id, old('district_id')) }}>{{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div>
                                    <label for="hud" class="form-label">HUD <span style="color: red;">*</span></label>
                                    <select name="hud_id" id="hud_id" class="form-control">
                                        <option value="">-- Select HUD -- </option>
                                        @foreach ($huds as $key => $value)
                                            <option value="{{ $value->id }}" {{ SELECT($value->id, old('hud_id')) }}>
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="eventDescription" class="form-label">Description <span
                                            style="color: red;">*</span></label>
                                    <textarea class="form-control" id="eventDescription" placeholder="Enter description" name="description" required></textarea>
                                </div>
                                <div>
                                    <label for="location" class="form-label">Health Walk Location Area <span
                                            style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="location"
                                        placeholder="Enter location area" name="area" required>
                                </div>
                                <div>
                                    <label for="startingPoint" class="form-label">Starting Point <span
                                            style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="startingPoint"
                                        placeholder="Enter starting point" name="start_point" required>
                                </div>
                                <div>
                                    <label for="endingPoint" class="form-label">Ending Point <span
                                            style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="endingPoint"
                                        placeholder="Enter ending point" name="end_point" required>
                                </div>
                                <div>
                                    <label for="contact" class="form-label">Contact Number <span
                                            style="color: red;">*</span></label>
                                    <input type="tel" class="form-control" id="contact"
                                        placeholder="Enter contact number" name="contact" required>
                                </div>
                                <div>
                                    <label for="googleMapLink" class="form-label">Google Map Link</label>
                                    <input type="url" class="form-control" id="googleMapLink"
                                        placeholder="Enter Google Map link" name="link" required>
                                </div>
                                <div>
                                    <label for="status" class="form-label">Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="status" type="checkbox" id="toggleStatus"
                                            value="1" {{ CHECKBOX('document_status') }}
                                            onchange="toggleStatusText('statusLabel', this)">
                                        <label class="form-check-label" for="toggleStatus"
                                            id="statusLabel">In-Active</label>
                                    </div>
                                </div>
                                <div>
                                    <label for="visibleToPublic" class="form-label">Visible to Public</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="visible_to_public" type="checkbox"
                                            id="toggleVisibleToPublic" value="1"
                                            {{ CHECKBOX('document_visible_to_public') }}
                                            onchange="toggleVisibleText('visibleToPublicLabel', this)">
                                        <label class="form-check-label" for="toggleVisibleToPublic"
                                            id="visibleToPublicLabel">No</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex mt-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-danger" style="margin-left: 10px;">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <!-- database table end -->
    </div>
@endsection
