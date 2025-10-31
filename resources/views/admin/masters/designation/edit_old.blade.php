@extends('admin.layouts.layout')
@section('title', 'Edit Designation')
@section('content')
<div class="page-wrapper">
   <div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Designation</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('designations.index')}}">Designation</a></li>
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
                    <form action="{{route('designations.update',$result->id)}}" enctype="multipart/form-data" method="post">
                        {{csrf_field()}}
                        @method('PUT')

                        <div class="row pt-3">
                            <div class="form-group col-sm-4 col-xs-4">
                                <label for="name" class="required">Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="{{old('name',$result->name)}}">
                            </div>

                        <div class="form-group col-sm-4 col-xs-4">
                            <label for="designation_type_id" class="required">Designation Type</label>
                            <select name="designation_type_id" id="designation_type_id" class="form-control">
                                <option value="" >-- Select Designation Type-- </option>
                                @foreach($designation_types as $key => $value)
                                <option value="{{$value->id}}" {{SELECT($value->id,old('designation_type_id',$result->designation_type_id))}}>{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                           
                           
                        <div class="form-group col-sm-4 col-xs-4">
                                  <label for="status" class="required">Status </label>
                                  <select name="status" id="status" class="form-control">
                                      @foreach($statuses as $key => $value)
                                      <option value="{{$value}}" {{SELECT($value,old('status',$result->status))}}>{{$key}}</option>
                                      @endforeach
                                  </select>
                              </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                        <a type="reset" class="btn btn-inverse waves-effect waves-light" href="{{route('designations.index')}}"> Cancel </a>
                    </form>

                </div>
            </div>
        </div>
    </div>
  </div>
   </div>
</div>
@endsection
