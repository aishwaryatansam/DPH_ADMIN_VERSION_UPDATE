@extends('admin.layouts.layout')
@section('title', 'Create District')
@section('content')
<div class="page-wrapper">
   <div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Create District</h4>          
        </div>

        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('districts.index')}}">District</a></li>
                    <li class="breadcrumb-item active">Create District</li>
                      
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
                    <form action="{{route('districts.store')}}" enctype="multipart/form-data" method="post">
                        {{csrf_field()}}

                    <div class="row pt-3">
                        <div class="form-group col-sm-4 col-xs-4">
                            <label for="name" class="required">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="{{old('name')}}">
                        </div>

                        <div class="form-group col-sm-4 col-xs-4">
                            <label for="district" class="">Select Image</label>
                            <input type="file" name="district_image" class="form-control" id="district_image" accept="image/png,image/jpg,image/jpeg">
                            <small class="form-control-feedback text-danger"> Accepted only .png/.jpg/.jpeg format & allowed max size is 1MB </small>
                        </div>

                          <div class="form-group col-sm-4 col-xs-4">
                            <label for="location_url" class="">Map Location URL</label>
                            <input type="text" name="location_url" class="form-control" id="location_url" placeholder="Enter Location" value="{{old('location_url')}}">
                        </div>
                     
                        <div class="form-group col-sm-4 col-xs-4">
                            <label for="status" class="required">Status </label>
                            <select name="status" id="status" class="form-control">
                                @foreach($statuses as $key => $value)
                                <option value="{{$value}}" {{SELECT($value,old('status'))}}>{{$key}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                        <hr>
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                        <a type="reset" class="btn btn-inverse waves-effect waves-light" href="{{route('districts.index')}}"> Cancel </a>
                    </form>
                </div>
            </div>
        </div>
          </div>
        </div>
   </div>
</div>
@endsection

