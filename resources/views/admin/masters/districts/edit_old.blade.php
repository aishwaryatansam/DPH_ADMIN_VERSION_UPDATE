@extends('admin.layouts.layout') @section('title', 'Edit District') @section('content') <div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Edit District</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('districts.index') }}">District</a>
                        </li>
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
                            <form action="{{ route('districts.update', $result->id) }}" enctype="multipart/form-data"
                                method="post">
                                {{ csrf_field() }} @method('PUT')

                                <div class="row pt-3 col-md-12">

                                    <div class="form-group col-sm-4 col-xs-4">
                                        <label for="name" class="required">Name</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="Enter Name" value="{{ old('name', $result->name) }}">
                                    </div>

                                    <div class="form-group col-sm-4 col-xs-4">
                                        <label for="district_image" class="">Image </label>
                                        <input type="file" name="district_image" class="form-control"
                                            id="district_image" placeholder="Image "
                                            value="{{ old('image_url', $result->image_url) }}" />
                                    </div>

                                    <div class="form-group col-sm-4 col-xs-4">
                                        <label for="location_url" class="">Map Location URL</label>
                                        <input type="text" name="location_url" class="form-control" id="location_url"
                                            placeholder=" Enter Location"
                                            value="{{ old('location_url', $result->location_url) }}" />
                                    </div>

                                    <div class="form-group col-sm-4 col-xs-4">
                                        <label for="status" class="required">Status </label>
                                        <select name="status" id="status" class="form-control">
                                            @foreach ($statuses as $key => $value)
                                                <option value="{{ $value }}"
                                                    {{ SELECT($value, old('status', $result->status)) }}>
                                                    {{ $key }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row pt-3 col-md-12">
                                    <div class="form-group col-sm-4 col-xs-4">
                                        <label for="image_url" class="required">District Image </label>
                                        @if ($result->image_url)
                                            <br>
                                            <img src="{{ fileLink($result->image_url) }}" height="100"
                                                width="100" />
                                        @else
                                            <br>
                                            <span>No Image Uploaded.</span>
                                        @endif

                                    </div>
                                </div>
                                <hr>
                                <button type="submit"
                                    class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                <a type="reset" class="btn btn-inverse waves-effect waves-light"
                                    href="{{ route('districts.index') }}"> Cancel </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> @endsection
