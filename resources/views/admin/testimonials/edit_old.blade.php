@extends('admin.layouts.layout')
@section('title', 'Edit Testimonial')
@section('content')
<head>
    <link rel="stylesheet" href="{{asset('packa/theme/assets/node_modules/html5-editor/bootstrap-wysihtml5.css')}}"/>
</head>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Edit Testimonial</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('testimonials.index')}}">Testimonial</a></li>
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
                            <form action="{{route('testimonials.update',$result->id)}}" enctype="multipart/form-data" method="post">
                                {{csrf_field()}} @method('PUT')

                                <div class="row pt-3 col-md-12">
                                    <div class="form-group col-sm-6 col-xs-6">
                                        <label for="name" class="required">Name</label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="{{old('name',$result->name)}}">
                                    </div>

                                    <div class="form-group col-sm-6 col-xs-6">
                                        <label for="designation" class="">Designation</label>
                                        <input type="text" name="designation" class="form-control" id="designation" placeholder="Enter Designation" value="{{old('designation', $result->designation)}}">
                                    </div>

                                    <div class="form-group col-sm-12 col-xs-12">
                                        <label for="content" class="required">Content</label>
                                        <textarea class="textarea_editor form-control" rows="15" name="content" id="content" placeholder="Enter Content">{!! old('content', $result->content) !!}</textarea>
                                    </div>
                                </div>
                                <div class="row pt-3 col-md-12">
                                    <div class="form-group col-sm-4 col-xs-4">
                                        <label for="testimonial_image" class="">Profile Image</label>
                                        <input type="file" name="testimonial_image" class="form-control" id="testimonial_image" placeholder="Image" value="{{old('image_url',$result->image_url)}}" />
                                        <br>
                                        @if($result->image_url)
                                            <img src="{{fileLink($result->image_url)}}" height="100" width="100" />
                                        @else
                                            <span>No Image Uploaded.</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-sm-4 col-xs-4">
                                        <label for="testimonial_document" class="">Profile Document</label>
                                        <input type="file" name="testimonial_document" class="form-control" id="testimonial_document" placeholder="Image" accept=".pdf" value="{{old('testimonial_document_url',$result->testimonial_document_url)}}" />
                                        <br>
                                        @if($result->testimonial_document_url)
                                        <a class="text-danger" href="{{fileLink($result->testimonial_document_url)}}" target="_blank" download="download">{{$result->testimonial_document_url}}</a>
                                        @else
                                        No Document Uploaded.
                                        @endif
                                    </div>

                                    <div class="form-group col-sm-4 col-xs-4">
                                        <label for="status" class="required">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            @foreach($statuses as $key => $value)
                                                <option value="{{$value}}" {{SELECT($value,old('status',$result->status))}}>{{$key}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <hr>
                                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                <a type="reset" class="btn btn-inverse waves-effect waves-light" href="{{route('testimonials.index')}}"> Cancel </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('packa/theme/assets/node_modules/html5-editor/wysihtml5-0.3.0.js')}}"></script>
<script src="{{asset('packa/theme/assets/node_modules/html5-editor/bootstrap-wysihtml5.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.textarea_editor').wysihtml5();
    });
</script>
@endsection
