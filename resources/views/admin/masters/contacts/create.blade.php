@extends('admin.layouts.layout')
@section('title', 'Create Contact')
@section('content')
<div class="page-wrapper">
   <div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Create Contact</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('contacts.index')}}">Contact</a></li>
                    <li class="breadcrumb-item active">Create Contact</li>
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
                    <form action="{{route('contacts.store')}}" enctype="multipart/form-data" method="post">
                        {{csrf_field()}}

                    <div class="row pt-3">
                        <div class="form-group col-sm-4 col-xs-4">
                            <label for="name" class="required">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="{{old('name')}}">
                        </div>


                         <div class="form-group col-sm-4 col-xs-4">
                            <label for="section" class="required">Designation</label>
                            <select name="designation_id" id="section" class="form-control">
                                <option value="" >-- Select Designation -- </option>
                                @foreach($designation as $key => $value)
                                <option value="{{$value->id}}" {{SELECT($value->id,old('designation_id'))}}>{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-4 col-xs-4">
                            <label for="mobile_number" class="required">Mobile Number</label>
                            <input type="text" name="mobile_number" class="form-control" id="mobile_number" placeholder="Enter Mobile Number" value="{{old('mobile_number')}}">
                        </div>

                         <div class="form-group col-sm-4 col-xs-4">
                            <label for="landline_number" class="required">Landline Number</label>
                            <input type="text" name="landline_number" class="form-control" id="landline_number" placeholder="Enter Landline Number" value="{{old('landline_number')}}">
                        </div>

                        <div class="form-group col-sm-4 col-xs-4">
                            <label for="email_id" class="required">Email Id</label>
                            <input type="text" name="fax" class="form-control" id="email_id" placeholder="Enter Email Id" value="{{old('email_id')}}">
                        </div>

                        
                        <div class="form-group col-sm-4 col-xs-4">
                            <label for="fax" class="required">Fax</label>
                            <input type="text" name="fax" class="form-control" id="fax" placeholder="Enter Fax" value="{{old('fax')}}">
                        </div>

                          <div class="form-group col-sm-4 col-xs-4">
                            <label for="contact" class="required">Select Image</label>
                            <input type="file" name="contact" class="form-control" id="contact" accept=".jpg">
                            
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
                        <button type="reset" class="btn btn-inverse waves-effect waves-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
          </div>
        </div>
   </div>
</div>
@endsection
