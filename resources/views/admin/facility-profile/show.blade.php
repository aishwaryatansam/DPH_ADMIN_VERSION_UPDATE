@extends('admin.layouts.layout')
@section('title', 'Show Facility Profile')
@section('content')

    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Documents</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                    </ol>
                </nav>

            </div>
        </div>
        <div class="container-fluid">
            <div class="page-inner">
                <div class="container-fluid mt-2">
                    <div class="row">
                        <div class="col-lg-12 " style="border-radius: 10px;">
                            <!-- insert the contents Here start -->


                            <div class="card px-5 pt-0 pb-0 mt-3 mb-3">
                                <form id="msform" action="{{ route('facility-profile.update', $result->id) }}"
                                    enctype="multipart/form-data" method="post">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <!-- progressbar -->
                                    <!-- <ul id="progressbar" class="d-none d-md-flex">
                                            <li class="active" id="account"><strong>Facility Info</strong></li>
                                            <li id="personal"><strong>Contact Details</strong></li>
                                            <li id="payment"><strong>Address Information</strong></li>
                                            <li id="confirm"><strong>Photos</strong></li>
                                            <li id="UploadDetails"><strong>Upload Details</strong></li>
                                            <li id="idDetail"><strong>ID Details</strong></li>
                                            <li id="preview"><strong>Preview</strong></li>
                                        </ul> -->
                                    <br>
                                    <!-- Facility Info -->
                                    <!-- Facility Info -->
                                    <div class="mt-3"
                                        style="background-color: #f9f9f9; padding: 20px; border-radius: 8px;  max-width: 100%; margin: auto;">
                                        <fieldset>
                                            <span
                                                style="position:relative; top: -35px; left: 06px; background-color: #fff; padding: 5px 10px; font-size: 1.25rem; font-weight: bold; color: #333;">
                                                Facility Information
                                            </span>
                                            <div class="form-card">
                                                <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                                    <div>
                                                        <label for="facility_id" class="form-label">Facility Id <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="facility_id"
                                                            name="facility_id" value="{{ $result->facility_hierarchy_id }}"
                                                            placeholder="Enter Facility Id" readonly required />
                                                    </div>
                                                    <div>
                                                        <label for="facility_name" class="form-label">Facility Name <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="facility_name"
                                                            name="facility_name"
                                                            value="{{ $result->facility_hierarchy->facility_name }}"
                                                            placeholder="Enter Facility Name" readonly required />
                                                    </div>
                                                    <div>
                                                        <label for="facility_level" class="form-label">Facility Level <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="facility_level"
                                                            name="facility_level"
                                                            value="{{ $result->facility_hierarchy->facility_level->name }}"
                                                            placeholder="Enter Facility Level" readonly required />
                                                    </div>

                                                    @if ($result->facility_hierarchy->facility_level_id != 1)
                                                        <div>
                                                            <label for="district_id" class="form-label">District ID <span
                                                                    style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="district_id"
                                                                name="district_id"
                                                                value="{{ $result->facility_hierarchy->district_id }}"
                                                                placeholder="Enter District ID" disabled required />
                                                        </div>
                                                        <div>
                                                            <label for="district_name" class="form-label">District Name
                                                                <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" id="district_name"
                                                                value="{{ $result->facility_hierarchy->district->name }}"
                                                                name="district_name" placeholder="Enter District Name"
                                                                disabled required />
                                                        </div>
                                                        @if (in_array($result->facility_hierarchy->facility_level_id, [3, 4, 5, 6]))
                                                            <div>
                                                                <label for="hud_id" class="form-label">HUD ID <span
                                                                        style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" id="hud_id"
                                                                    name="hud_id"
                                                                    value="{{ $result->facility_hierarchy->hud_id }}"
                                                                    placeholder="Enter HUD ID" disabled required />
                                                            </div>
                                                            <div>
                                                                <label for="hud_name" class="form-label">HUD Name <span
                                                                        style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" id="hud_name"
                                                                    value="{{ $result->facility_hierarchy->hud->name }}"
                                                                    name="hud_name" placeholder="Enter HUD Name" disabled
                                                                    required />
                                                            </div>
                                                        @endif

                                                        @if (in_array($result->facility_hierarchy->facility_level_id, [4, 5, 6]))
                                                            <div>
                                                                <label for="block_id" class="form-label">Block ID <span
                                                                        style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" id="block_id"
                                                                    value="{{ $result->facility_hierarchy->block_id }}"
                                                                    name="block_id" placeholder="Enter Block ID" disabled
                                                                    required />
                                                            </div>
                                                            <div>
                                                                <label for="block_name" class="form-label">Block Name
                                                                    <span style="color: red;">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    id="block_name"
                                                                    value="{{ $result->facility_hierarchy->block->name }}"
                                                                    name="block_name" placeholder="Enter Block Name"
                                                                    disabled required />
                                                            </div>
                                                        @endif

                                                        @if (in_array($result->facility_hierarchy->facility_level_id, [5, 6]))
                                                            <div>
                                                                <label for="phc_id" class="form-label">PHC ID <span
                                                                        style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" id="phc_id"
                                                                    value="{{ $result->facility_hierarchy->phc_id }}"
                                                                    name="phc_id" placeholder="Enter PHC ID" disabled
                                                                    required />
                                                            </div>
                                                            <div>
                                                                <label for="phc_name" class="form-label">PHC Name <span
                                                                        style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" id="phc_name"
                                                                    value="{{ $result->facility_hierarchy->phc->name }}"
                                                                    name="phc_name" placeholder="Enter PHC Name" disabled
                                                                    required />
                                                            </div>
                                                        @endif

                                                        @if ($result->facility_hierarchy->facility_level_id == 6)
                                                            <div>
                                                                <label for="hsc_id" class="form-label">HSC ID <span
                                                                        style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" id="hsc_id"
                                                                    value="{{ $result->facility_hierarchy->hsc_id }}"
                                                                    name="hsc_id" placeholder="Enter HSC ID" disabled
                                                                    required />
                                                            </div>
                                                            <div>
                                                                <label for="hsc_name" class="form-label">HSC Name <span
                                                                        style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" id="hsc_name"
                                                                    value="{{ $result->facility_hierarchy->hsc->name }}"
                                                                    name="hsc_name" placeholder="Enter HSC Name" disabled
                                                                    required />
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                                <!-- <input type="button" name="next" class="next action-button" value="Next" /> -->
                                            </div>
                                        </fieldset>
                                    </div>



                                    <!-- Contact Details -->
                                    <div class="mt-3"
                                        style="background-color: #f9f9f9; padding: 20px; border-radius: 8px;  max-width: 100%; margin: auto">
                                        <fieldset>
                                            <span
                                                style="position:relative; top: -35px; left: 06px; background-color: #fff; padding: 5px 10px; font-size: 1.25rem; font-weight: bold; color: #333;">
                                                Contact Details
                                            </span>
                                            <div class="form-card">
                                                {{-- <input type="hidden" name="contacts_id"
                                                    value="{{ isset($result->contacts->id) }}"> --}}
                                                <!-- <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">Contact Details:</h2>
                                                    </div>
                                                    <div class="col-5">
                                                        <h2 class="steps">Step 2 - 6</h2>
                                                    </div>
                                                </div> -->
                                                <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                                    <div>
                                                        <label for="ruralorurban" class="form-label">Urban/Rural</label>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="toggleAreaType" value="1"
                                                                {{ CHECKBOX('area_type', $result->area_type) }}
                                                                onchange="toggleAreaTypeText('areaTypeLabel', this)"
                                                                name="area_type" disabled>
                                                            <label class="form-check-label" for="toggleAreaType"
                                                                id="areaTypeLabel">{{ $result->area_type == 1 ? 'Urban' : 'Rural' }}</label>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label for="mobile_number" class="form-label">Mobile Number
                                                            <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="mobile_number"
                                                            name="mobile_number"
                                                            value="{{ $result->mobile_number ?? '' }}"
                                                            placeholder="Enter Mobile Number" required readonly />
                                                    </div>
                                                    <div>
                                                        <label for="landline" class="form-label">Landline <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="landline"
                                                            value="{{ $result->landline_number ?? '' }}"
                                                            name="landline_number" placeholder="Enter Landline Number"
                                                            required readonly />
                                                    </div>
                                                    <div>
                                                        <label for="fax" class="form-label">Fax <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="fax"
                                                            value="{{ $result->fax ?? '' }}" name="fax"
                                                            placeholder="Enter Fax Number" required readonly />
                                                    </div>
                                                    <div>
                                                        <label for="email" class="form-label">Email <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="email"
                                                            value="{{ $result->email_id ?? '' }}"
                                                            name="email_id" placeholder="Enter Email" required readonly />
                                                    </div>
                                                </div>
                                                <!-- <input type="button" name="next" class="next action-button"
                                                    value="Next" />
                                                <input type="button" name="previous" class="previous action-button-previous"
                                                    value="Previous" /> -->
                                            </div>
                                        </fieldset>
                                    </div>


                                    <!-- Address Information -->
                                    <div class="mt-3"
                                        style="background-color: #f9f9f9; padding: 20px; border-radius: 8px;  max-width: 100%; margin: auto">
                                        <fieldset>
                                            <span
                                                style="position:relative; top: -35px; left: 06px; background-color: #fff; padding: 5px 10px; font-size: 1.25rem; font-weight: bold; color: #333;">
                                                Address Information
                                            </span>
                                            <div class="form-card">
                                                <!-- <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">Address Information:</h2>
                                                    </div>
                                                    <div class="col-5">
                                                        <h2 class="steps">Step 3 - 6</h2>
                                                    </div>
                                                </div> -->
                                                <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                                    <div>
                                                        <label for="address_line_1" class="form-label">Line 1 <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="address_line_1"
                                                            value="{{ $result->address_line1 ?? '' }}"
                                                            name="address_line1" placeholder="Street, Campus" required
                                                            readonly />
                                                    </div>
                                                    <div>
                                                        <label for="address_line_2" class="form-label">Line 2 <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="address_line_2"
                                                            value="{{ $result->address_line2 ?? '' }}"
                                                            name="address_line2" placeholder="City, District" required
                                                            readonly />
                                                    </div>
                                                    <div>
                                                        <label for="pincode" class="form-label">Pincode <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="pincode"
                                                            value="{{ $result->pincode ?? '' }}" name="pincode"
                                                            placeholder="Enter Pincode" required readonly />
                                                    </div>
                                                    <div>
                                                        <label for="latitude" class="form-label">Latitude <span
                                                                style="color: red;">*</span></label>
                                                        <input type="number" step="any" class="form-control"
                                                            value="{{ $result->latitude ?? '' }}" id="latitude"
                                                            name="latitude" placeholder="Enter Latitude" required
                                                            readonly />
                                                    </div>
                                                    <div>
                                                        <label for="longitude" class="form-label">Longitude <span
                                                                style="color: red;">*</span></label>
                                                        <input type="number" step="any" class="form-control"
                                                            value="{{ $result->longitude ?? '' }}" id="longitude"
                                                            name="longitude" placeholder="Enter Longitude" required
                                                            readonly />
                                                    </div>
                                                </div>
                                                <!-- <input type="button" name="next" class="next action-button"
                                                    value="Next" />
                                                <input type="button" name="previous" class="previous action-button-previous"
                                                    value="Previous" /> -->
                                            </div>
                                        </fieldset>
                                    </div>

                                    <!-- Building status -->
                                    <div class="mt-3"
                                        style="background-color: #f9f9f9; padding: 20px; border-radius: 8px;  max-width: 100%; margin: auto">
                                        <fieldset>
                                            <span
                                                style="position:relative; top: -35px; left: 06px; background-color: #fff; padding: 5px 10px; font-size: 1.25rem; font-weight: bold; color: #333;">
                                                Building status
                                            </span>
                                            <!-- Data place -->
                                            <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                                <div class="d-flex justify-content-start gap-4 mt-2"
                                                    style="margin-left: 40px;">
                                                    <label class="radio-label">
                                                        <input type="radio" name="building_status" value="own"
                                                            onchange="toggleInputs()"
                                                            {{ $facilityBuilding->building_status == 'own' ? 'checked' : '' }}
                                                            disabled>
                                                        Own
                                                    </label>
                                                    <label class="radio-label">
                                                        <input type="radio" name="building_status" value="rent_free"
                                                            onchange="toggleInputs()"
                                                            {{ $facilityBuilding->building_status == 'rent_free' ? 'checked' : '' }}
                                                            disabled>
                                                        Rent Free
                                                    </label>
                                                    <label class="radio-label">
                                                        <input type="radio" name="building_status" value="rented"
                                                            onchange="toggleInputs()"
                                                            {{ $facilityBuilding->building_status == 'rented' ? 'checked' : '' }}
                                                            disabled>
                                                        Rented
                                                    </label>
                                                    <label class="radio-label">
                                                        <input type="radio" name="building_status"
                                                            value="public_building" onchange="toggleInputs()"
                                                            {{ $facilityBuilding->building_status == 'public_building' ? 'checked' : '' }}
                                                            disabled>
                                                        Public Building
                                                    </label>
                                                    <label class="radio-label">
                                                        <input type="radio" name="building_status"
                                                            value="under_construction" onchange="toggleInputs()"
                                                            {{ $facilityBuilding->building_status == 'under_construction' ? 'checked' : '' }}
                                                            disabled>
                                                        Under Construction
                                                    </label>
                                                </div>
                                            </div>

                                        </fieldset>
                                    </div>

                                    <!-- Photos -->
                                    <div class="mt-3"
                                        style="background-color: #f9f9f9; padding: 20px; border-radius: 8px;  max-width: 100%; margin: auto">
                                        <fieldset>
                                            <span
                                                style="position:relative; top: -35px; left: 06px; background-color: #fff; padding: 5px 10px; font-size: 1.25rem; font-weight: bold; color: #333;">
                                                Facility Images
                                            </span>
                                            <div class="form-card">
                                                {{-- Common Images --}}
                                                @if (in_array($result->facility_hierarchy->facility_level_id, [1, 2, 3, 4]))
                                                    <!-- <div class="row">
                                                        <div class="col-7">
                                                            <h2 class="fs-title">Facility Images:</h2>
                                                        </div>
                                                        <div class="col-5">
                                                            <h2 class="steps">Step 4 - 6</h2>
                                                        </div>
                                                    </div> -->
                                                    <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                                        <div>
                                                            <label for="entrance_image" class="form-label">Entrance Image
                                                                <span style="color: red;">*</span></label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control"
                                                                    id="entrance_image" name="entrance_image"
                                                                    accept="image/*"
                                                                    @if (!isset($entranceImage->image_url)) required @endif
                                                                    value="{{ $entranceImage->image_url ?? '' }}"
                                                                    onchange="previewImage(this, 'EntrancePreview')"
                                                                    disabled />
                                                                @if (isset($entranceImage->image_url))
                                                                    <a href="{{ fileLink($entranceImage->image_url) }}"
                                                                        target="_blank"
                                                                        class="btn btn-primary input-group-text">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div style="position: relative;">
                                                                <textarea class="form-control mt-2" name="entrance_description" placeholder="Enter description for the image"
                                                                    readonly>{{ $entranceImage->description ?? '' }}</textarea>
                                                            </div>
                                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                                .jpeg, .png</small> -->
                                                        </div>
                                                        <div>
                                                            <label for="waiting_area_image" class="form-label">Waiting
                                                                Area Image <span style="color: red;">*</span></label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control"
                                                                    id="waiting_area_image" name="waiting_area_image"
                                                                    accept="image/*"
                                                                    @if (!isset($waitingAreaImage->image_url)) required @endif
                                                                    value="{{ $waitingAreaImage->image_url ?? '' }}"
                                                                    onchange="previewImage(this, 'waitingAreaPreview')"
                                                                    disabled />
                                                                @if (isset($waitingAreaImage->image_url))
                                                                    <a href="{{ fileLink($waitingAreaImage->image_url) }}"
                                                                        target="_blank"
                                                                        class="btn btn-primary input-group-text">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div style="position: relative;">
                                                                <textarea class="form-control mt-2" name="waiting_area_description" placeholder="Enter description for the image"
                                                                    readonly>{{ $waitingAreaImage->description ?? '' }}</textarea>
                                                            </div>
                                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                                .jpeg, .png</small> -->
                                                        </div>
                                                        <div>
                                                            <label for="other_image" class="form-label">Other Image
                                                                <span style="color: red;"></span></label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control"
                                                                    id="other_image" name="other_image" accept="image/*"
                                                                    value="{{ $otherImage->image_url ?? '' }}"
                                                                    onchange="previewImage(this, 'otherPreview')"
                                                                    disabled />
                                                                @if (isset($otherImage->image_url))
                                                                    <a href="{{ fileLink($otherImage->image_url) }}"
                                                                        target="_blank"
                                                                        class="btn btn-primary input-group-text">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div style="position: relative;">
                                                                <textarea class="form-control mt-2" name="other_iamge_description" placeholder="Enter description for the image"
                                                                    readonly>{{ $otherImage->description ?? '' }}</textarea>
                                                            </div>
                                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                                .jpeg, .png</small> -->
                                                        </div>
                                                        <div>
                                                            <label for="general_image" class="form-label">General Image
                                                                <span style="color: red;"></span></label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control"
                                                                    id="general_image" name="general_image"
                                                                    accept="image/*"
                                                                    value="{{ $generalImage->image_url ?? '' }}"
                                                                    onchange="previewImage(this, 'generalPreview')"
                                                                    disabled />
                                                                @if (isset($generalImage->image_url))
                                                                    <a href="{{ fileLink($generalImage->image_url) }}"
                                                                        target="_blank"
                                                                        class="btn btn-primary input-group-text">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div style="position: relative;">
                                                                <textarea class="form-control mt-2" name="general_image_description" placeholder="Enter description for the image"
                                                                    readonly>{{ $generalImage->description ?? '' }}</textarea>
                                                            </div>
                                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                                .jpeg, .png</small> -->
                                                        </div>

                                                        {{-- <div>
                                                        <label for="image1" class="form-label">Image 1
                                                            <span style="color: red;"></span></label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="image1"
                                                                name="image1" accept="image/*"
                                                                value="{{ $image1->image_url ?? '' }}"
                                                onchange="previewImage(this, 'generalPreview')" />
                                                @if (isset($image1->image_url))
                                                <a href="{{ fileLink($image1->image_url) }}"
                                                    target="_blank"
                                                    class="btn btn-primary input-group-text">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @endif
                                            </div>
                                            <div style="position: relative;">
                                                <textarea class="form-control mt-2" name="image1_description" placeholder="Enter description for the image">{{ $image1->description ?? '' }}</textarea>
                                            </div>
                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small> -->
                                        </div>

                                        <div>
                                            <label for="image2" class="form-label">General Image
                                                <span style="color: red;"></span></label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="image2"
                                                    name="image2" accept="image/*"
                                                    value="{{ $image2->image_url ?? '' }}"
                                                    onchange="previewImage(this, 'generalPreview')" />
                                                @if (isset($image2->image_url))
                                                <a href="{{ fileLink($image2->image_url) }}"
                                                    target="_blank"
                                                    class="btn btn-primary input-group-text">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @endif
                                            </div>
                                            <div style="position: relative;">
                                                <textarea class="form-control mt-2" name="image2_description" placeholder="Enter description for the image">{{ $image2->description ?? '' }}</textarea>
                                            </div>
                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small> -->
                                        </div>

                                        <div>
                                            <label for="image3" class="form-label">General Image
                                                <span style="color: red;"></span></label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="image3"
                                                    name="image3" accept="image/*"
                                                    value="{{ $image3->image_url ?? '' }}"
                                                    onchange="previewImage(this, 'generalPreview')" />
                                                @if (isset($image3->image_url))
                                                <a href="{{ fileLink($image3->image_url) }}"
                                                    target="_blank"
                                                    class="btn btn-primary input-group-text">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @endif
                                            </div>
                                            <div style="position: relative;">
                                                <textarea class="form-control mt-2" name="image3_description" placeholder="Enter description for the image">{{ $image3->description ?? '' }}</textarea>
                                            </div>
                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small> -->
                                        </div>

                                        <div>
                                            <label for="image4" class="form-label">General Image
                                                <span style="color: red;"></span></label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="image4"
                                                    name="image4" accept="image/*"
                                                    value="{{ $image4->image_url ?? '' }}"
                                                    onchange="previewImage(this, 'generalPreview')" />
                                                @if (isset($image4->image_url))
                                                <a href="{{ fileLink($image4->image_url) }}"
                                                    target="_blank"
                                                    class="btn btn-primary input-group-text">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @endif
                                            </div>
                                            <div style="position: relative;">
                                                <textarea class="form-control mt-2" name="image4_description" placeholder="Enter description for the image">{{ $image4->description ?? '' }}</textarea>
                                            </div>
                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small> -->
                                        </div>

                                        <div>
                                            <label for="image5" class="form-label">General Image
                                                <span style="color: red;"></span></label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="image5"
                                                    name="image5" accept="image/*"
                                                    value="{{ $image5->image_url ?? '' }}"
                                                    onchange="previewImage(this, 'generalPreview')" />
                                                @if (isset($image5->image_url))
                                                <a href="{{ fileLink($image5->image_url) }}"
                                                    target="_blank"
                                                    class="btn btn-primary input-group-text">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @endif
                                            </div>
                                            <div style="position: relative;">
                                                <textarea class="form-control mt-2" name="image5_description" placeholder="Enter description for the image">{{ $image5->description ?? '' }}</textarea>
                                            </div>
                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small> -->
                                        </div>

                                        <div>
                                            <label for="image6" class="form-label">General Image
                                                <span style="color: red;"></span></label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="image6"
                                                    name="image6" accept="image/*"
                                                    value="{{ $image6->image_url ?? '' }}"
                                                    onchange="previewImage(this, 'generalPreview')" />
                                                @if (isset($image6->image_url))
                                                <a href="{{ fileLink($image6->image_url) }}"
                                                    target="_blank"
                                                    class="btn btn-primary input-group-text">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @endif
                                            </div>
                                            <div style="position: relative;">
                                                <textarea class="form-control mt-2" name="image6_description" placeholder="Enter description for the image">{{ $image6->description ?? '' }}</textarea>
                                            </div>
                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                            .jpeg, .png</small> -->
                                        </div> --}}
                                                    </div>
                                                @endif

                                                {{-- Hsc Images --}}
                                                @if ($result->facility_hierarchy->facility_level_id == 6)
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <h2 class="fs-title">HSC Images:</h2>
                                                        </div>
                                                        <div class="col-5">
                                                            <h2 class="steps">Step 4 - 6</h2>
                                                        </div>
                                                    </div>
                                                    <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                                        <div>
                                                            <label for="hsc_entrance_image" class="form-label">HSC
                                                                Entrance Image <span style="color: red;">*</span></label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control"
                                                                    id="hsc_entrance_image" name="hsc_entrance_image"
                                                                    accept="image/*" required
                                                                    onchange="previewImage(this, 'hscEntrancePreview')"
                                                                    disabled />
                                                                @if (isset($entranceImage->image_url))
                                                                    <a href="{{ fileLink($entranceImage->image_url) }}"
                                                                        target="_blank"
                                                                        class="btn btn-primary input-group-text">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div style="position: relative;">
                                                                <textarea class="form-control mt-2" name="entrance_area_description" placeholder="Enter description for the image"
                                                                    readonly>{{ $entranceImage->description ?? '' }}</textarea>
                                                            </div>
                                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                                .jpeg, .png</small> -->
                                                        </div>
                                                        <div>
                                                            <label for="waiting_area_image" class="form-label">Waiting
                                                                Area Image <span style="color: red;">*</span></label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control"
                                                                    id="waiting_area_image" name="waiting_area_image"
                                                                    accept="image/*" required
                                                                    onchange="previewImage(this, 'waitingAreaPreview')"
                                                                    disabled />
                                                                @if (isset($waitingAreaImage->image_url))
                                                                    <a href="{{ fileLink($waitingAreaImage->image_url) }}"
                                                                        target="_blank"
                                                                        class="btn btn-primary input-group-text">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div style="position: relative;">
                                                                <textarea class="form-control mt-2" name="waiting_area_description" placeholder="Enter description for the image"
                                                                    readonly>{{ $waitingAreaImage->description ?? '' }}</textarea>
                                                            </div>
                                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                                .jpeg, .png</small> -->
                                                        </div>
                                                        <div>
                                                            <label for="clinic_area_image" class="form-label">Clinic
                                                                Area Image <span style="color: red;">*</span></label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control"
                                                                    id="clinic_area_image" name="clinic_area_image"
                                                                    accept="image/*" required
                                                                    onchange="previewImage(this, 'clinicAreaPreview')"
                                                                    disabled />
                                                                @if (isset($clinicAreaImage->image_url))
                                                                    <a href="{{ fileLink($clinicAreaImage->image_url) }}"
                                                                        target="_blank"
                                                                        class="btn btn-primary input-group-text">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div style="position: relative;">
                                                                <textarea class="form-control mt-2" name="clinic_area_description" placeholder="Enter description for the image"
                                                                    readonly>{{ $clinicAreaImage->description ?? '' }}</textarea>

                                                            </div>
                                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                                .jpeg, .png</small> -->
                                                        </div>
                                                        <div>
                                                            <label for="other_image" class="form-label">Other Image
                                                                <span style="color: red;"></span></label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control"
                                                                    id="other_image" name="other_image" accept="image/*"
                                                                    onchange="previewImage(this, 'otherPreview')"
                                                                    disabled />
                                                                @if (isset($otherImage->image_url))
                                                                    <a href="{{ fileLink($otherImage->image_url) }}"
                                                                        target="_blank"
                                                                        class="btn btn-primary input-group-text">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div style="position: relative;">
                                                                <textarea class="form-control mt-2" name="waiting_area_description" placeholder="Enter description for the image"
                                                                    readonly>{{ $otherImage->description ?? '' }}</textarea>

                                                            </div>
                                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                                .jpeg, .png</small> -->
                                                        </div>
                                                        <div>
                                                            <label for="general_image" class="form-label">General Image
                                                                <span style="color: red;"></span></label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control"
                                                                    id="general_image" name="general_image"
                                                                    accept="image/*"
                                                                    onchange="previewImage(this, 'generalPreview')"
                                                                    disabled />
                                                                @if (isset($generalImage->image_url))
                                                                    <a href="{{ fileLink($generalImage->image_url) }}"
                                                                        target="_blank"
                                                                        class="btn btn-primary input-group-text">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div style="position: relative;">
                                                                <textarea class="form-control mt-2" name="waiting_area_description" placeholder="Enter description for the image"
                                                                    readonly>{{ $generalImage->description ?? '' }}</textarea>
                                                            </div>
                                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                                .jpeg, .png</small> -->
                                                        </div>
                                                    </div>
                                                @endif

                                                {{-- PHC Images --}}
                                                @if ($result->facility_hierarchy->facility_level_id == 5)
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <h2 class="fs-title">PHC Images:</h2>
                                                        </div>
                                                        <div class="col-5">
                                                            <!-- <h2 class="steps">Step 5 - 6</h2> -->
                                                        </div>
                                                    </div>
                                                    <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                                        <div>
                                                            <label for="op_image" class="form-label">OP Image <span
                                                                    style="color: red;">*</span></label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control" id="op_image"
                                                                    name="op_image" accept="image/*" required
                                                                    onchange="previewImage(this, 'opPreview')" disabled />
                                                                @if (isset($opImage->image_url))
                                                                    <a href="{{ fileLink($opImage->image_url) }}"
                                                                        target="_blank"
                                                                        class="btn btn-primary input-group-text">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div style="position: relative;">
                                                                <textarea class="form-control mt-2" name="entrance_area_description" placeholder="Enter description for the image"
                                                                    readonly>{{ $opImage->description ?? '' }}</textarea>
                                                            </div>
                                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                                .jpeg, .png</small> -->
                                                        </div>
                                                        <div>
                                                            <label for="ip_image" class="form-label">IP Image <span
                                                                    style="color: red;">*</span></label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control" id="ip_image"
                                                                    name="ip_image" accept="image/*" required
                                                                    onchange="previewImage(this, 'ipPreview')" disabled />
                                                                @if (isset($ipImage->image_url))
                                                                    <a href="{{ fileLink($ipImage->image_url) }}"
                                                                        target="_blank"
                                                                        class="btn btn-primary input-group-text">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div style="position: relative;">
                                                                <textarea class="form-control mt-2" name="entrance_area_description" placeholder="Enter description for the image"
                                                                    readonly>{{ $ipImage->description ?? '' }}</textarea>

                                                            </div>
                                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                                .jpeg, .png</small> -->
                                                        </div>
                                                        <div>
                                                            <label for="pharmacy_image" class="form-label">Pharmacy
                                                                Image <span style="color: red;">*</span></label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control"
                                                                    id="pharmacy_image" name="pharmacy_image"
                                                                    accept="image/*" required
                                                                    onchange="previewImage(this, 'pharmacyPreview')"
                                                                    disabled />
                                                                @if (isset($pharmacyImage->image_url))
                                                                    <a href="{{ fileLink($pharmacyImage->image_url) }}"
                                                                        target="_blank"
                                                                        class="btn btn-primary input-group-text">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div style="position: relative;">
                                                                <textarea class="form-control mt-2" name="entrance_area_description" placeholder="Enter description for the image"
                                                                    readonly>{{ $pharmacyImage->description ?? '' }}</textarea>
                                                            </div>
                                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                                .jpeg, .png</small> -->
                                                        </div>
                                                        <div>
                                                            <label for="lab_image" class="form-label">Lab Image <span
                                                                    style="color: red;">*</span></label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control" id="lab_image"
                                                                    name="lab_image" accept="image/*" required
                                                                    onchange="previewImage(this, 'labPreview')" disabled />
                                                                @if (isset($labImage->image_url))
                                                                    <a href="{{ fileLink($labImage->image_url) }}"
                                                                        target="_blank"
                                                                        class="btn btn-primary input-group-text">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div style="position: relative;">
                                                                <textarea class="form-control mt-2" name="entrance_area_description" placeholder="Enter description for the image"
                                                                    readonly>{{ $labImage->description ?? '' }}</textarea>
                                                            </div>
                                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                                .jpeg, .png</small> -->
                                                        </div>
                                                        <div>
                                                            <label for="entrance_image" class="form-label">Entrance
                                                                Image <span style="color: red;">*</span></label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control"
                                                                    id="entrance_image" name="entrance_image"
                                                                    accept="image/*" required
                                                                    onchange="previewImage(this, 'entrancePreview')"
                                                                    disabled />
                                                                @if (isset($entranceImage->image_url))
                                                                    <a href="{{ fileLink($entranceImage->image_url) }}"
                                                                        target="_blank"
                                                                        class="btn btn-primary input-group-text">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div style="position: relative;">
                                                                <textarea class="form-control mt-2" name="entrance_area_description" placeholder="Enter description for the image"
                                                                    readonly>{{ $entranceImage->description ?? '' }}</textarea>
                                                            </div>
                                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                                .jpeg, .png</small> -->
                                                        </div>
                                                        <div>
                                                            <label for="waiting_area_phc_image" class="form-label">Waiting
                                                                Area
                                                                Image <span style="color: red;"></span></label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control"
                                                                    id="waiting_area_phc_image"
                                                                    name="waiting_area_phc_image" accept="image/*"
                                                                    onchange="previewImage(this, 'waitingAreaPhcPreview')"
                                                                    disabled />
                                                                @if (isset($waitingAreaImage->image_url))
                                                                    <a href="{{ fileLink($waitingAreaImage->image_url) }}"
                                                                        target="_blank"
                                                                        class="btn btn-primary input-group-text">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div style="position: relative;">
                                                                <textarea class="form-control mt-2" name="entrance_area_description" placeholder="Enter description for the image"
                                                                    readonly>{{ $waitingAreaImage->description ?? '' }}</textarea>
                                                            </div>
                                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                                .jpeg, .png</small> -->
                                                        </div>
                                                        <div>
                                                            <label for="clinic_area_phc_image" class="form-label">Clinic
                                                                Area Image <span style="color: red;"></span></label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control"
                                                                    id="clinic_area_phc_image"
                                                                    name="clinic_area_phc_image" accept="image/*"
                                                                    onchange="previewImage(this, 'clinicAreaPhcPreview')"
                                                                    disabled />
                                                                @if (isset($clinicAreaImage->image_url))
                                                                    <a href="{{ fileLink($clinicAreaImage->image_url) }}"
                                                                        target="_blank"
                                                                        class="btn btn-primary input-group-text">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div style="position: relative;">
                                                                <textarea class="form-control mt-2" name="entrance_area_description" placeholder="Enter description for the image"
                                                                    readonly>{{ $clinicAreaImage->description ?? '' }}</textarea>
                                                            </div>
                                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                                .jpeg, .png</small> -->
                                                        </div>
                                                        <div>
                                                            <label for="other_phc_image" class="form-label">Other PHC
                                                                Image <span style="color: red;"></span></label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control"
                                                                    id="other_phc_image" name="other_phc_image"
                                                                    accept="image/*"
                                                                    onchange="previewImage(this, 'otherPhcPreview')"
                                                                    disabled />
                                                                @if (isset($otherImage->image_url))
                                                                    <a href="{{ fileLink($otherImage->image_url) }}"
                                                                        target="_blank"
                                                                        class="btn btn-primary input-group-text">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div style="position: relative;">
                                                                <textarea class="form-control mt-2" name="entrance_area_description" placeholder="Enter description for the image"
                                                                    readonly>{{ $otherImage->description ?? '' }}</textarea>
                                                            </div>
                                                            <!-- <small style="color: red;">Upload accepted file types: .jpg,
                                                                .jpeg, .png</small> -->
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- <input type="button" name="next" class="next action-button"
                                                    value="Next" onclick="uploadDocument();" />
                                                <input type="button" name="previous" class="previous action-button-previous"
                                                    value="Previous" /> -->
                                            </div>
                                        </fieldset>
                                    </div>


                                    <!-- Upload Details -->
                                    <div class="mt-3"
                                        style="background-color: #f9f9f9; padding: 20px; border-radius: 8px;  max-width: 100%; margin: auto">
                                        <fieldset>
                                            <span
                                                style="position:relative; top: -35px; left: 06px; background-color: #fff; padding: 5px 10px; font-size: 1.25rem; font-weight: bold; color: #333;">
                                                Upload Details
                                            </span>
                                            <div class="form-card">
                                                <!-- <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">Upload Details:</h2>
                                                    </div>
                                                    <div class="col-5">
                                                        <h2 class="steps">Step 5 - 6</h2>
                                                    </div>
                                                </div> -->
                                                <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                                    <div>
                                                        <label for="video_url" class="form-label">Video URL <span
                                                                style="color: red;">*</span></label>

                                                        <input type="text" class="form-control" id="video_url"
                                                            value="{{ $result->video_url ?? '' }}" name="video_url"
                                                            placeholder="Enter Video URL" required readonly />

                                                    </div>
                                                    <div>
                                                        <label for="land_document" class="form-label">Land Document
                                                            1
                                                            <span style="color: red;">*</span></label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="land_document"
                                                                name="land_document1" accept=".pdf,.doc,.docx" required
                                                                disabled />
                                                            @if (isset($result->facilityDocuments[0]))
                                                                <a href="{{ fileLink($result->facilityDocuments[0]->document_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <!-- <small style="color: red;">Upload accepted file types: .pdf,
                                                            .doc, .docx</small> -->
                                                    </div>
                                                    <div>
                                                        <label for="land_document" class="form-label">Land Document
                                                            2
                                                            <span style="color: red;"></span></label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="land_document"
                                                                name="land_document2" accept=".pdf,.doc,.docx" disabled />
                                                            @if (isset($result->facilityDocuments[1]))
                                                                <a href="{{ fileLink($result->facilityDocuments[1]->document_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <!-- <small style="color: red;">Upload accepted file types: .pdf,
                                                            .doc, .docx</small> -->
                                                    </div>
                                                    <div>
                                                        <label for="land_document" class="form-label">Land Document
                                                            3
                                                            <span style="color: red;"></span></label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="land_document"
                                                                name="land_document3" accept=".pdf,.doc,.docx" disabled />
                                                            @if (isset($result->facilityDocuments[2]))
                                                                <a href="{{ fileLink($result->facilityDocuments[2]->document_url) }}"
                                                                    target="_blank"
                                                                    class="btn btn-primary input-group-text">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <!-- <small style="color: red;">Upload accepted file types: .pdf,
                                                            .doc, .docx</small> -->
                                                    </div>
                                                </div>
                                                <!-- <input type="button" name="next" class="next action-button"
                                                    value="Next" onclick="uploadDocument();" />
                                                <input type="button" name="previous" class="previous action-button-previous"
                                                    value="Previous" /> -->
                                            </div>
                                        </fieldset>
                                    </div>



                                    <!-- ID Details -->
                                    <div class="mt-3"
                                        style="background-color: #f9f9f9; padding: 20px; border-radius: 8px; max-width: 100%; margin: auto; margin-bottom: 10px;">
                                        <fieldset>
                                            <span
                                                style="position: relative; top: -35px; left: 6px; background-color: #fff; padding: 5px 10px; font-size: 1.25rem; font-weight: bold; color: #333;">
                                                ID Details
                                            </span>
                                            <div class="form-card">
                                                <!-- <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">ID Details:</h2>
                                                    </div>
                                                    <div class="col-5">
                                                        <h2 class="steps">Step 6 - 6</h2>
                                                    </div>
                                                </div> -->
                                                <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                                    <div>
                                                        <label for="abdm_health_facility_number" class="form-label">ABDM
                                                            Health Facility Number <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $result->abdm_facility_number ?? '' }}"
                                                            id="abdm_health_facility_number" name="abdm_facility_number"
                                                            placeholder="Enter ABDM Health Facility Number" required
                                                            readonly />
                                                    </div>
                                                    <div>
                                                        <label for="nin_number" class="form-label">NIN Number <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="nin_number"
                                                            value="{{ $result->nin_number ?? '' }}" name="nin_number"
                                                            placeholder="Enter NIN Number" required readonly />
                                                    </div>
                                                    <div>
                                                        <label for="picme" class="form-label">PICME <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="picme"
                                                            value="{{ $result->picme ?? '' }}" name="picme"
                                                            placeholder="Enter PICME" required readonly />
                                                    </div>
                                                    <div>
                                                        <label for="hmis" class="form-label">HMIS <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" id="hmis"
                                                            value="{{ $result->hmis ?? '' }}" name="hmis"
                                                            placeholder="Enter HMIS" required readonly />
                                                    </div>
                                                </div>
                                                <!-- <input type="button" name="previous" class="previous action-button-previous"
                                                    value="Previous" /> -->

                                            </div>

                                        </fieldset>

                                    </div>

                                </form>
                                <div class="d-flex gap-3">
                                    @if (isset($approvalResult) && $approvalResult->current_stage)
                                        @if (isAdmin())
                                            <button class="btn btn-success"
                                                @if ($approvalResult->current_stage !== 'state_approve') style="display: none !important;" @endif
                                                onclick="performAction('publish', {{ $approvalResult->id }})">Publish</button>
                                            <button class="btn btn-warning"
                                                @if ($approvalResult->current_stage !== 'state_approve') style="display: none !important;" @endif
                                                onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return
                                                with
                                                Remarks</button>
                                            <button class="btn btn-danger"
                                                @if ($approvalResult->current_stage !== 'state_approve') style="display: none !important;" @endif
                                                onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject
                                                with
                                                Remarks</button>
                                        @elseif (isState() && isApprover())
                                            <button class="btn btn-success"
                                                @if ($approvalResult->current_stage !== 'state_verify') style="display: none !important;" @endif
                                                onclick="performAction('state_approve', {{ $approvalResult->id }})">Approve</button>
                                            <button class="btn btn-warning"
                                                @if ($approvalResult->current_stage !== 'state_verify') style="display: none !important;" @endif
                                                onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return
                                                with
                                                Remarks</button>
                                            <button class="btn btn-danger"
                                                @if ($approvalResult->current_stage !== 'state_verify') style="display: none !important;" @endif
                                                onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject
                                                with
                                                Remarks</button>
                                        @elseif (isBlock() && isApprover())
                                            <button class="btn btn-success"
                                                @if (!in_array($approvalResult->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif
                                                onclick="performAction('block_approve', {{ $approvalResult->id }})">Approve</button>
                                            <button class="btn btn-warning"
                                                @if (!in_array($approvalResult->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif
                                                onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return
                                                with
                                                Remarks</button>
                                            <button class="btn btn-danger"
                                                @if (!in_array($approvalResult->current_stage, ['block_verify', 'phc_verify'])) style="display: none !important;" @endif
                                                onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject
                                                with
                                                Remarks</button>
                                        @elseif (isHUD() && isApprover())
                                            <button class="btn btn-success"
                                                @if ($approvalResult->current_stage !== 'hud_verify') style="display: none !important;" @endif
                                                onclick="performAction('hud_approve', {{ $approvalResult->id }})">Approve</button>
                                            <button class="btn btn-warning"
                                                @if ($approvalResult->current_stage !== 'hud_verify') style="display: none !important;" @endif
                                                onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return
                                                with
                                                Remarks</button>
                                            <button class="btn btn-danger"
                                                @if ($approvalResult->current_stage !== 'hud_verify') style="display: none !important;" @endif
                                                onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject
                                                with
                                                Remarks</button>
                                        @elseif(isVerifier() && isPHC())
                                            <button class="btn btn-success"
                                                @if (!in_array($approvalResult->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif
                                                onclick="performAction('phc_verify', {{ $approvalResult->id }})">Verify</button>
                                            <button class="btn btn-warning"
                                                @if (!in_array($approvalResult->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif
                                                onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return
                                                with
                                                Remarks</button>
                                            <button class="btn btn-danger"
                                                @if (!in_array($approvalResult->current_stage, ['hsc_upload', 'phc_upload'])) style="display: none !important;" @endif
                                                onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject
                                                with
                                                Remarks</button>
                                        @elseif(isVerifier() && isBlock())
                                            <button class="btn btn-success"
                                                @if ($approvalResult->current_stage !== 'block_upload') style="display: none !important;" @endif
                                                onclick="performAction('block_verify', {{ $approvalResult->id }})">Verify</button>
                                            <button class="btn btn-warning"
                                                @if ($approvalResult->current_stage !== 'block_upload') style="display: none !important;" @endif
                                                onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return
                                                with
                                                Remarks</button>
                                            <button class="btn btn-danger"
                                                @if ($approvalResult->current_stage !== 'block_upload') style="display: none !important;" @endif
                                                onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject
                                                with
                                                Remarks</button>
                                        @elseif(isVerifier() && isHUD())
                                            <button class="btn btn-success"
                                                @if (!in_array($approvalResult->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif
                                                onclick="performAction('hud_verify', {{ $approvalResult->id }})">Verify</button>
                                            <button class="btn btn-warning"
                                                @if (!in_array($approvalResult->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif
                                                onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return
                                                with
                                                Remarks</button>
                                            <button class="btn btn-danger"
                                                @if (!in_array($approvalResult->current_stage, ['hud_upload', 'block_approve'])) style="display: none !important;" @endif
                                                onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject
                                                with
                                                Remarks</button>
                                        @elseif(isVerifier() && isState())
                                            <button class="btn btn-success"
                                                @if (!in_array($approvalResult->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif
                                                onclick="performAction('state_verify', {{ $approvalResult->id }})">Verify</button>
                                            <button class="btn btn-warning"
                                                @if (!in_array($approvalResult->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif
                                                onclick="showRemarksModal('return', {{ $approvalResult->id }})">Return
                                                with
                                                Remarks</button>
                                            <button class="btn btn-danger"
                                                @if (!in_array($approvalResult->current_stage, ['hud_approve', 'district_upload', 'state_upload'])) style="display: none !important;" @endif
                                                onclick="showRemarksModal('reject', {{ $approvalResult->id }})">Reject
                                                with
                                                Remarks</button>
                                        @endif
                                    @endif

                                    <a href="{{ route('facility-profile.index') }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
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
        $(document).ready(function() {
            var current_fs, next_fs, previous_fs;
            var opacity;

            $(".next").click(function() {
                current_fs = $(this).parent().parent();
                next_fs = $(this).parent().parent().next();

                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                next_fs.show();
                current_fs.hide();

                opacity = 1 - ($("fieldset").index(next_fs) / $("fieldset").length);
                $(".progress-bar").css({
                    width: opacity * 100 + "%"
                });

                var formData = {};
                $("#msform").find("input").each(function() {
                    var field = $(this);
                    formData[field.attr("name")] = field.val();
                });
                var previewContent = "<h3>Preview:</h3><ul>";
                for (var key in formData) {
                    previewContent += "<li><strong>" + key + ":</strong> " +
                        "<h6 class='previewtext'>" +
                        formData[key] +
                        "</h6></li>";
                }
                previewContent += "</ul>";
                $("#previewContent").html(previewContent);
            });

            $(".previous").click(function() {
                current_fs = $(this).parent().parent();
                previous_fs = $(this).parent().parent().prev();

                $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                previous_fs.show();
                current_fs.hide();

                opacity = 1 - ($("fieldset").index(previous_fs) / $("fieldset").length);
                $(".progress-bar").css({
                    width: opacity * 100 + "%"
                });
            });

            $(".submit").click(function() {
                $("#successPopup").show();
            });
        });

        function closePopup() {
            document.getElementById("successPopup").style.display = "none";
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#goBackButton").click(function() {
                history.back();
            });
        });
    </script>
    <script>
        function toggleSelectAll(selectAllCheckbox) {
            const checkboxes = document.querySelectorAll('.form-check-input');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            updateButtonLabels();
        }

        let actionType = '';
        let isBulkAction = false; // Flag to determine if it's a bulk action
        let selectedDocumentIds = []; // Stores IDs for bulk actions
        let currentDocumentId = null; // Stores the ID for single actions

        function showRemarksModal(action, documentId = null) {
            actionType = action;
            if (documentId) {
                // Single action
                isBulkAction = false;
                currentDocumentId = documentId;
            } else {
                // Bulk action
                isBulkAction = true;
                selectedDocumentIds = Array.from(document.querySelectorAll('.documentCheckbox:checked'))
                    .map(checkbox => checkbox.value);

                if (selectedDocumentIds.length === 0) {
                    alert('Please select at least one document.');
                    return;
                }
            }

            const modalLabel = document.getElementById('remarksModalLabel');
            modalLabel.textContent = action === 'return' ? 'Return with Remarks' : 'Reject with Remarks';
            const remarksInput = document.getElementById('remarksInput');
            remarksInput.value = ''; // Clear previous remarks
            const modal = new bootstrap.Modal(document.getElementById('remarksModal'));
            modal.show();
        }


        function performBulkAction(action) {
            const selectedDocuments = Array.from(document.querySelectorAll('.documentCheckbox:checked'))
                .map(checkbox => checkbox.value);
            console.log(selectedDocuments)

            if (selectedDocuments.length === 0) {
                alert('Please select at least one document.');
                return;
            }

            if (!confirm(`Are you sure you want to ${action} the selected documents?`)) {
                return;
            }

            if (action === 'publish' || action === 'approve' || action === 'verify') {

                fetch('facilityprofile/bulk-action', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({
                            action,
                            documentIds: selectedDocuments
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(`${action.charAt(0).toUpperCase() + action.slice(1)} action completed successfully!`);
                            location.reload();
                        } else {
                            alert('An error occurred while performing the action.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while performing the action.');
                    });
            }
        }

        function submitBulkRemarks(remarks) {
            fetch(`{{ url('approval/facilityprofile/bulk-action') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content') // CSRF token
                    },
                    body: JSON.stringify({
                        documentIds: selectedDocumentIds, // Bulk document IDs
                        action: actionType,
                        remarks: remarks
                    })
                })
                .then(response => {
                    if (response.ok) {
                        location.reload(); // Reload the page or handle the UI update
                    } else {
                        console.error('Error performing bulk action');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function submitRemarks() {
            const remarks = document.getElementById('remarksInput').value;
            if (!remarks.trim()) {
                alert('Remarks are required!');
                return;
            }

            if (isBulkAction) {
                // Bulk submission logic
                submitBulkRemarks(remarks);
            } else {
                // Single submission logic
                fetch(`{{ url('approval/facilityprofile/') }}/${currentDocumentId}/${actionType}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content') // CSRF token
                        },
                        body: JSON.stringify({
                            remarks: remarks
                        })
                    })
                    .then(response => {
                        if (response.ok) {
                            location.reload(); // Reload the page or handle the UI update
                        } else {
                            console.error('Error submitting remarks');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        const checkboxes = document.querySelectorAll('.form-check-input');
        const publishBtn = document.getElementById('publishBtn');
        const approveBtn = document.getElementById('approveBtn');
        const verifyBtn = document.getElementById('verifyBtn');
        const returnBtn = document.getElementById('returnBtn');
        const rejectBtn = document.getElementById('rejectBtn');

        // Update button text with selected document count
        function updateButtonLabels() {
            const selectedCount = document.querySelectorAll('.form-check-input:checked').length;
            publishBtn.textContent = `Publish (${selectedCount})`;
            approveBtn.textContent = `Approve (${selectedCount})`;
            verifyBtn.textContent = `Verify (${selectedCount})`;
            returnBtn.textContent = `Return (${selectedCount})`;
            rejectBtn.textContent = `Reject (${selectedCount})`;
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateButtonLabels);
        });

        updateButtonLabels(); // Initial call on page load
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trackingItems = document.querySelectorAll('.tracking-item');

            trackingItems.forEach((item, index) => {
                const statusSpan = item.querySelector('.tracking-content span');
                const statusText = statusSpan ? statusSpan.textContent.trim() : '';

                if (statusText === 'Verified' || statusText === 'Approved' || statusText === 'Uploaded') {
                    // Apply styles for Verified, Approved, or Uploaded
                    item.style.borderLeft = '4px solid #00ba0d'; // Green
                    const trackingIcon = item.querySelector('.tracking-icon');
                    trackingIcon.style.backgroundColor = '#e9f8ea'; // Light green background for the icon
                    trackingIcon.style.color = '#007bff'; // Blue for icon color
                } else if (statusText === 'Pending') {
                    // Apply styles for Pending
                    item.style.borderLeft = '4px solid #f0ba09'; // Amber
                    const trackingIcon = item.querySelector('.tracking-icon');
                    trackingIcon.style.backgroundColor = '#f8eee9'; // Light amber background for the icon
                    trackingIcon.style.color = '#ffc400'; // Amber for icon color

                    // Muting all previous items
                    for (let i = 0; i < index; i++) {
                        const previousItem = trackingItems[i];
                        previousItem.classList.add('muted');
                        previousItem.style.opacity =
                            '0.5'; // Optional: reduce opacity to visually indicate muted status
                        previousItem.style.borderLeft = '4px solid #e9e5e4'; // Light gray for muted items

                        // Change icon color and background for muted items
                        const mutedIcon = previousItem.querySelector('.tracking-icon');
                        if (mutedIcon) {
                            mutedIcon.style.color = '#989695'; // Set muted icon color
                            mutedIcon.style.backgroundColor = '#d2d2d2'; // Set muted icon background color
                        }
                    }
                } else if (item.classList.contains('muted')) {
                    // Apply muted style for items that have the muted class
                    item.style.borderLeft = '4px solid #e9e5e4'; // Light gray for muted
                    const mutedIcon = item.querySelector('.tracking-icon');
                    if (mutedIcon) {
                        mutedIcon.style.color = '#989695'; // Set muted icon color
                        mutedIcon.style.backgroundColor = '#d2d2d2'; // Set muted icon background color
                    }
                } else {
                    // Apply default style for other statuses
                    item.style.borderLeft = '4px solid #f0ba09'; // Amber
                }
            });
        });


        function performAction(action, id) {
            fetch(`{{ url('approval/facilityprofile/') }}/${id}/${action}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token for security
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({}),
                })
                .then(response => {
                    if (response.ok) {
                        location.reload(); // Reload the page or handle the UI update
                    } else {
                        console.error('Error approving document');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // document.addEventListener('DOMContentLoaded', function() {
        //     const tableRows = document.querySelectorAll('table tbody tr');

        //     tableRows.forEach(row => {
        //         row.addEventListener('click', function() {
        //             const data = JSON.parse(this.getAttribute('data-entry'));
        //             console.log(data);
        //             document.getElementById('document-title').innerText = data.model.event.name;
        //             console.log(data.model.event.name);

        //             document.getElementById('modal-uploaded-by').innerText = 'Uploaded By: ' + data.user.name ;
        //             document.getElementById('uploaded-by-date-time').innerText = data.created_at;
        //             document.getElementById('modal-current-stage').innerText = data.current_stage;

        //             // Example for verification details
        //             const verificationDetails = document.getElementById(
        //                 'modal-verification-details');
        //             verificationDetails.innerHTML = ''; // Clear existing content

        //             // Populate list dynamically
        //             const stages = ['phc_verify_id', 'block_verify_id', 'hud_verify_id',
        //                 'state_verify_id'
        //             ];
        //             stages.forEach(stage => {
        //                 const li = document.createElement('li');
        //                 li.innerText =
        //                     `${stage.replace('_', ' ')}: ${data[stage] || 'Pending'}`;
        //                 verificationDetails.appendChild(li);
        //             });
        //         });
        //     });
        // });
    </script>
    <style>
        .radio-label {
            display: inline-flex;
            align-items: center;
            font-size: 1rem;
            font-weight: 500;
            gap: 8px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .radio-label:hover {
            background-color: #f0f0f0;
        }

        .radio-label input[type="radio"] {
            margin-right: 6px;
            transform: scale(1.2);
            cursor: pointer;
        }

        .radio-label input[type="radio"]:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }

        .radio-label input[type="radio"]:disabled+label {
            color: #999;
        }
    </style>
@endsection
