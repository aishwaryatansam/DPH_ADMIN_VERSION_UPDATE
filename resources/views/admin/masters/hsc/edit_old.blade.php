@extends('admin.layouts.layout')
@section('title', 'Edit Hsc')
@section('content')
<div class="page-wrapper">
   <div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Edit Hsc</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('hsc.index')}}">Hsc</a></li>
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
                    <form action="{{route('hsc.update',$result->id)}}" enctype="multipart/form-data" method="post">
                        {{csrf_field()}}
                        @method('PUT')

                        <div class="row pt-3">

                           <div class="form-group col-sm-4 col-xs-4">
                            <label for="is_urban" class="required">Is Urban</label>
                            <select name="is_urban" id="is_urban" class="form-control">
                                @foreach($is_urban as $key => $value)
                                <option value="{{$key}}" data-value="{{$key}}" {{SELECT($key,old('is_urban',$result->is_urban))}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                            <div class="form-group col-sm-4 col-xs-4">
                                <label for="name" class="required">Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="{{old('name',$result->name)}}">
                            </div>

                             <div class="form-group col-sm-4 col-xs-4">
                         <label for="block_id" class="required">Block</label>
                            <select name="block_id" id="block_id" class="form-control">
                                  <option value="" >-- Select Block -- </option>
                                  @foreach($huds as $hud)
                                  <optgroup label="{{$hud->name}}">
                                    @foreach($hud->blocks as $block)
                                    <option value="{{$block->id}}" {{SELECT($block->id,old('block_id',$result->phc->block_id))}}>{{$block->name}}</option>
                                    @endforeach
                                  </optgroup>
                                  @endforeach
                            </select>
                     </div>

                   
                            
                             <div class="form-group col-sm-4 col-xs-4">
                                <label for="phc_id" class="required">PHC</label>
                                <select name="phc_id" id="phc_id" class="form-control">
                                    <option value="" >-- Select PHC -- </option>
                                    @foreach($phc as $key => $value)
                                    <option value="{{$value->id}}" {{SELECT($value->id,old('phc_id',$result->phc_id))}}>{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>




                               <div class="form-group col-sm-4 col-xs-4">
                                 <label for="hsc_image" class="">Image </label>
                                <input type="file" name="hsc_image" class="form-control" id="hsc_image" placeholder="Image" value="{{old('image_url',$result->image_url)}}" />
                            </div>

                           
                           <div class="form-group col-sm-4 col-xs-4">
                              <label for="video_url" class="">Video URL</label>
                              <input type="text" name="video_url" class="form-control" id="video_url" placeholder=" Enter Video URL" value="{{old('video_url',$result->video_url)}}" />
                            </div>

                             <div class="form-group col-sm-4 col-xs-4">
                                <label for="location_url" class="">Map Location URL</label>
                                 <input type="text" name="location_url" class="form-control" id="location_url" placeholder=" Enter Location" value="        {{old('location_url',$result->location_url)}}" />
                           </div>

                           <div class="form-group col-md-4">
                                <label for="property_document" class="">Land Document</label>
                                <input type="file" name="property_document" class="form-control" id="property_document" placeholder="Land Document" value="{{old('property_document_url',$result->property_document_url)}}" accept=".pdf"/>
                                <small class="form-control-feedback text-danger"> Accepted .pdf format & allowed max size is 5MB </small>
                            </div>

                        <div class="form-group col-sm-4 col-xs-4">
                                  <label for="status" class="required">Status </label>
                                  <select name="status" id="status" class="form-control">
                                      @foreach($statuses as $key => $value)
                                      <option value="{{$value}}" {{SELECT($value,old('status',$result->status))}}>{{$key}}</option>
                                      @endforeach
                                  </select>
                              </div>
                               <div class="row pt-3 col-md-12">
                                    <div class="form-group col-sm-4 col-xs-4">
                                    <label for="image_url" class="required">HSC Image </label>
                                    @if($result->image_url)
                                        <br>
                                        <img src="{{fileLink($result->image_url)}}" height="100" width="100" />
                                    @else
                                        <br>
                                        <span>No Image Uploaded.</span>
                                    @endif

                                    </div>
                                    <div class="form-group col-md-4">
                                    <label for="property_document_url">Land Document</label>
                                    @if($result->property_document_url)
                                        <br>
                                        <div class="position-relative mt-2">
                                                <a href="{{fileLink($result->property_document_url)}}" target="_blank" >
                                                    <i class="fa fa-eye"></i> View Document
                                                </a>
                                                <br>
                                                <a href="{{ url('hsc/destroy-document/'. $result->id) }}" onclick="return confirm('Are you sure you want to delete this document?')">
                                                    <i class="fa fa-trash"></i> Delete Document
                                                </a>
                                            </div>
                                    @else
                                        <br>
                                        <span>No Land Document Uploaded.</span>
                                    @endif
                                </div>
                
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                         <a type="reset" class="btn btn-inverse waves-effect waves-light" href="{{route('hsc.index')}}"> Cancel </a>
                    </form>

                </div>
            </div>
        </div>
    </div>
  </div>
   </div>
</div>
</div>
<script src="{{asset('packa/custom/hierarchy.js')}}"></script>

@endsection
