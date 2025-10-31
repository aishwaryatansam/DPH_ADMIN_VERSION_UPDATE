@extends('admin.layouts.layout')
@section('title', 'Edit Document')
@section('content')
<div class="page-wrapper">
   <div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Document</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('documents.index')}}">Document</a></li>
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
                    <form action="{{route('documents.update',$result->id)}}" enctype="multipart/form-data" method="post">
                        {{csrf_field()}}
                        @method('PUT')

                        <div class="row pt-3">

                        <div class="form-group col-sm-4 col-xs-4">
                            <label for="navigation_id" class="required">Type of Document </label>
                            <p><a class="text-danger" href="{{showDiskImage($result->navigation_id)}}">{{$result->navigation->name}}</a></p>
                        </div>

                        <div class="form-group col-sm-4 col-xs-4">
                            <label for="document" class="required">Document File</label>
                            <p><a class="text-danger" href="{{showDiskImage($result->document_url)}}">{{$result->display_filename}}</a></p>
                        </div> 
                       
                       
                        <div class="form-group col-sm-4 col-xs-4">
                            <label for="display_filename" class="required">Enter File Name to Display</label>
                            <input type="text" name="display_filename" class="form-control" id="display_filename" placeholder="Enter File Name to Display" value="{{old('display_filename',$result->display_filename)}}">
                             <small class="form-control-feedback text-danger"> No Special Characters are allowed. </small>
                        </div>
                    </div>

                    <div class="row pt-3">
                        <div class="form-group col-sm-4 col-xs-4">
                            <label for="tags" class="required">Select Mapping Section</label>

                            <select name="tags" id="tags" class="form-control">
                                @foreach($tags as $key => $value)
                                <option value="{{$key}}" {{SELECT($key,old('tags',$result->tag_id))}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($result->navigation->slug_key != 'announcements') 
                        <div class="form-group col-sm-4 col-xs-4">
                            <label for="display_filename" class="required">Enter G.O /Letter / Reference no.</label>
                            <input type="text" name="reference_no" class="form-control" id="reference_no" placeholder="Enter Letter / Reference no." value="{{old('reference_no', $result->reference_no)}}">
                        </div>
                        <div class="form-group col-sm-4 col-xs-4">
                            <label for="dated" class="required">Dated</label>
                            <input type="text" class="form-control mydatepicker"  name="dated" placeholder="mm/dd/yyyy" value="{{old('dated',$result->dated)}}" id="dated">
                        </div>
                        @endif
                         <div class="form-group col-sm-4 col-xs-4">
                            <label for="status" class="required">File Visible to Public </label>
                            <select name="visible_to_public" id="visible_to_public" class="form-control">
                                <option value="1" {{SELECT(1,old('visible_to_public',$result->visible_to_public))}}>Yes</option>
                                <option value="0" {{SELECT(0,old('visible_to_public',$result->visible_to_public))}}>No</option>
                            </select>
                        </div>
                       
                       @if($result->navigation->slug_key == 'announcements') 
                         <div class="form-group col-sm-4 col-xs-4"  id="image_div">
                              <label for="document_image" class="">Image Upload</label>
                              <input type="file" name="document_image" class="form-control" id="document_image" placeholder="Image " value="{{old('image_url',$result->image_url)}}" />
                           </div>
                        @endif
                             

                        <div class="form-group col-sm-4 col-xs-4">
                            <label for="link_url" class="">Link</label>
                            <input type="text" name="link_url" class="form-control" id="link_url" placeholder=" Enter Link" value="{{old('link_url',$result->link_url)}}" />
                        </div>

                        <div class="form-group col-sm-4 col-xs-4">
                                <label for="link_title" class="">Link Title</label>
                                <input type="text" name="link_title" class="form-control" id="link_title" placeholder="Enter Link Title" value="{{old('link_title',$result->link_title)}}">
                            </div>

                        <div class="form-group col-sm-4 col-xs-4">
                            <label for="status" class="required">Status </label>
                            <select name="status" id="status" class="form-control">
                                @foreach($statuses as $key => $value)
                                <option value="{{$value}}" {{SELECT($value,old('status',$result->status))}}>{{$key}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        @if($result->navigation->slug_key == 'announcements') 
                        <div class="form-group col-sm-4 col-xs-4"  id="image_div">
                    <label for="image_url" class="required">Document Image </label>
                    @if($result->image_url)
                        <br>
                        <img src="{{fileLink($result->image_url)}}" height="100" width="100" />
                    @else
                        <br>
                        <span>No Image Uploaded.</span>
                    @endif

                        </div>
                         @endif
                         
                    </div>

                        <hr>
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                       <a type="reset" class="btn btn-inverse waves-effect waves-light" href="{{route('documents.index')}}"> Cancel </a>
                    </form>

                </div>
            </div>
        </div>
    </div>
  </div>
   </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('.mydatepicker, #datepicker').datepicker();
        $('.disable_submit').on('keyup keypress', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) {
            e.preventDefault();
            return false;
          }
        });
    });


     $(function () {
        $("#display_filename").keypress(function (e) {
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
<script src="{{asset('packa/custom/document.js')}}"></script>
@endsection
