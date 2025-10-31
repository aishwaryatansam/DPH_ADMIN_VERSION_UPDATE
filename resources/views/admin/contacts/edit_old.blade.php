@extends('admin.layouts.layout') @section('title', 'Edit Contact') @section('content') <div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                @if (!empty($isProfileUpdate))
                    <h4 class="text-themecolor">Update Profile</h4>
                @else
                    <h4 class="text-themecolor">Edit Contact</h4>
                @endif
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        </li>
                        @if (empty($isProfileUpdate))
                            <li class="breadcrumb-item active">
                                <a href="{{ route('contacts.index') }}">Contact</a>
                            </li>
                            </li>
                        @endif
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <form action="{{ route('contacts.update', $result->id) }}" enctype="multipart/form-data"
                                method="post">
                                {{ csrf_field() }} @method('PUT')
                                <input type="hidden" name="contact_type" id="contact_type"
                                    value="{{ $result->contact_type }}"
                                    data-value="{{ $result->contactType->slug_key }}">
                                <input type="hidden" name="hidden_hud_id" id="hidden_hud_id"
                                    value="{{ auth()->user()->hud_id }}">
                                @if (!empty($isProfileUpdate))
                                    <input type="hidden" name="profile_update" value="true">
                                    <input type="hidden" name="is_post_vacant" value="no">
                                @endif

                                <div class="row pt-3">
                                    @if (empty($isProfileUpdate))
                                        <div class="form-group col-sm-4 col-xs-4" id="is_post_vacant_div">
                                            <label for="is_post_vacant" class="required">Is Post Vacant </label>
                                            <select name="is_post_vacant" id="is_post_vacant" class="form-control">
                                                @foreach ($is_post_vacants as $key => $value)
                                                    <option value="{{ $key }}" data-value="{{ $key }}"
                                                        {{ SELECT($key, old('is_post_vacant', $result->is_post_vacant)) }}>
                                                        {{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    <div class="form-group col-sm-4 col-xs-4" id="designation_div">
                                        <label for="designation_id" class="required">Designation</label>
                                        <select name="designation_id" id="designation_id" class="form-control">
                                            <option value="">-- Select Designation -- </option>
                                            @foreach ($designation as $key => $value)
                                                <option value="{{ $value->id }}"
                                                    {{ SELECT($value->id, old('designation_id', $result->designation_id)) }}>
                                                    {{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4 col-xs-4" id="name_div">
                                        <label for="name" class="required">Name</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="Enter Name" value="{{ old('name', $result->name) }}">
                                    </div>

                                    <div class="form-group col-sm-4 col-xs-4" id="mobile_number_div">
                                        <label for="mobile_number" class="required">Mobile Number</label>
                                        <input type="text" name="mobile_number" class="form-control"
                                            id="mobile_number" placeholder="Enter Mobile Number"
                                            value="{{ old('mobile_number', $result->mobile_number) }}">
                                    </div>
                                    <div class="form-group col-sm-4 col-xs-4" id="landline_number_div">
                                        <label for="landline_number" class="">Landline Number</label>
                                        <input type="text" name="landline_number" class="form-control"
                                            id="landline_number" placeholder="Enter Landline Number"
                                            value="{{ old('landline_number', $result->landline_number) }}">
                                    </div>
                                    <div class="form-group col-sm-4 col-xs-4" id="email_id_div">
                                        <label for="email_id" class="required">Email Id</label>
                                        <input type="text" name="email_id" class="form-control" id="email_id"
                                            placeholder="Enter Email Id"
                                            value="{{ old('email_id', $result->email_id) }}">
                                    </div>
                                    <div class="form-group col-sm-4 col-xs-4" id="fax_div">
                                        <label for="fax" class="">Fax</label>
                                        <input type="text" name="fax" class="form-control" id="fax"
                                            placeholder="Enter Fax" value="{{ old('fax', $result->fax) }}">
                                    </div>

                                    @if (!empty($isProfileUpdate))
                                        <input type="hidden" name="hud_id" id="hud_id"
                                            value="{{ $result->hud_id }}">
                                    @elseif(empty($isProfileUpdate) && (isAdmin() || isHud()))
                                        @if (
                                            $result->contactType->slug_key == 'hud' ||
                                                $result->contactType->slug_key == 'block' ||
                                                $result->contactType->slug_key == 'phc' ||
                                                $result->contactType->slug_key == 'hsc')
                                            <div class="form-group col-sm-4 col-xs-4" id="hud_div">
                                                <label for="hud_id" class="required">HUD</label>
                                                <select name="hud_id" id="hud_id" class="form-control">
                                                    <option value="">-- Select HUD -- </option>
                                                    @foreach ($huds as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ SELECT($value->id, old('hud_id', $result->hud_id)) }}>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif

                                        @if (
                                            $result->contactType->slug_key == 'block' ||
                                                $result->contactType->slug_key == 'phc' ||
                                                $result->contactType->slug_key == 'hsc')
                                            <div class="form-group col-sm-4 col-xs-4" id="block_div">
                                                <label for="block_id" class="required">Block</label>
                                                <select name="block_id" id="block_id" class="form-control">
                                                    <option value="">-- Select Block -- </option>
                                                    @foreach ($blocks as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ SELECT($value->id, old('block_id', $result->block_id)) }}>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif

                                        @if ($result->contactType->slug_key == 'phc' || $result->contactType->slug_key == 'hsc')
                                            <div class="form-group col-sm-4 col-xs-4" id="phc_div">
                                                <label for="phc_id" class="required">PHC</label>
                                                <select name="phc_id" id="phc_id" class="form-control">
                                                    <option value="">-- Select PHC -- </option>
                                                    @foreach ($phc as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ SELECT($value->id, old('phc_id', $result->phc_id)) }}>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif

                                        @if ($result->contactType->slug_key == 'hsc')
                                            <div class="form-group col-sm-4 col-xs-4" id="hsc_div">
                                                <label for="hsc_id" class="required">HSC</label>
                                                <select name="hsc_id" id="hsc_id" class="form-control">
                                                    <option value="">-- Select HSC -- </option>
                                                    @foreach ($hsc as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ SELECT($value->id, old('hsc_id', $result->hsc_id)) }}>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    @endif

                                    <!--   <div class="form-group col-sm-4 col-xs-4">
                    <label for="location_url" class="">Map Location URL</label>
                    <input type="text" name="location_url" class="form-control" id="location_url" placeholder=" Enter Location" value="{{ old('location_url', $result->location_url) }}" />
                  </div>
                  <div class="form-group col-sm-4 col-xs-4">
                    <label for="contact_image" class="">Image </label>
                    <input type="file" name="contact_image" class="form-control" id="contact_image" placeholder="Image" value="{{ old('image_url', $result->image_url) }}" />
                  </div> -->

                                    @if (!empty($isProfileUpdate))
                                        <input type="hidden" name="status" value="{{ $result->status }}">
                                    @else
                                        <div class="form-group col-sm-4 col-xs-4" id="status_div">
                                            <label for="status" class="required">Status </label>
                                            <select name="status" id="status" class="form-control">
                                                @foreach ($statuses as $key => $value)
                                                    <option value="{{ $value }}"
                                                        {{ SELECT($value, old('status', $result->status)) }}>
                                                        {{ $key }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif



                                    <!--<div class="row pt-3 col-md-12">
                    <div class="form-group col-sm-4 col-xs-4">
                      <label for="image_url" class="">Contact Image </label> @if ($result->image_url)
<br>
                      <img src="{{ fileLink($result->image_url) }}" height="100" width="100" />
@else
<br>
                      <span>No Image Uploaded.</span>
@endif
                    </div>
                  </div> -->
                                </div>
                                <hr>
                                <button type="submit"
                                    class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                <a type="reset" class="btn btn-inverse waves-effect waves-light"
                                    href="{{ route('contacts.index') }}"> Cancel </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="{{ asset('packa/custom/contact.js') }}"></script>
@endsection
