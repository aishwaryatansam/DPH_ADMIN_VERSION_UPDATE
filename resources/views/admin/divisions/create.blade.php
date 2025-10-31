@extends('admin.layouts.layout')
@section('title', 'Create Division')
@section('content')
<div class="page-wrapper">
   <div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Create Division</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('divisions.index')}}">Media Gallery</a></li>
                    <li class="breadcrumb-item active">Create Division</li>
                </ol>
            </div>
        </div>
    </div>

      @if ($errors->any())
      <div class="row">
        <div class="col-md-12">
            <div class="card card-body">
                
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
               
            </div>
        </div>
     </div>
      @endif
                <div class="row">
                    <div class="col-md-12">

                          <form action="{{route('divisions.store')}}" enctype="multipart/form-data" method="post">
                                    {{csrf_field()}}


                            <!-- Card Section 1 -->
                            <div class="card">
                                <div class="card-header alert-info">
                                    <h4 class="m-b-0 font-weight-normal">Division</h4>
                                </div>
                                <div class="card-body">                        
                                    
                                    <div class="form-row">                                           
                                        @if($parent_division->isNotEmpty()) 
                                        <div class="form-group col-sm-6 col-xs-6">
                                            <label for="status" >Parent Division </label>
                                            <select name="parent_division_id" id="parent_division_id" class="form-control">
                                                <option value="0" >-- None -- </option>
                                                @foreach($parent_division as $key => $value)
                                                <option value="{{$value->id}}" {{SELECT($value,old('status'))}}>{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @else
                                            <input type="hidden" value="0" name="parent_division_id" id="parent_division_id"> 
                                        @endif
                                        <div class="form-group col-sm-6 col-xs-6">
                                            <label for="name" class="required">Division Name</label>
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Division Name" value="{{old('name')}}">
                                        </div>
                                    </div>
                                    <div class="form-row">   
                                        <div class="form-group col-sm-6 col-xs-6">
                                            <label for="division" class="">Division Icon</label>
                                            <input type="file" name="division_icon" class="form-control" id="division_icon" accept="image/png,image/jpg,image/jpeg">
                                            <small class="form-control-feedback text-danger"> Accepted only .png/.jpg/.jpeg format & allowed max size is 1MB </small>
                                        </div>

                                        <div class="form-group col-sm-6 col-xs-6">
                                            <label for="status" class="required">Status </label>
                                            <select name="status" id="status" class="form-control">
                                                @foreach($statuses as $key => $value)
                                                <option value="{{$value}}" {{SELECT($value,old('status'))}}>{{$key}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    
                                </div>
                            </div>

                            <!-- Card Section 2 -->
                            <div class="card">
                                <div class="card-header alert-info">
                                    <h4 class="m-b-0 font-weight-normal">Division Heads Settings</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Mini Banner relevant fields -->
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width:40%;">Officer Name</th>
                                                <th style="width:30%;">Image</th>                                    
                                                <th style="width:20%;">Designation</th>                                    
                                                <th style="width:20%;">Status</th>                                    
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Announcement Banner 1 -->
                                            <tr>
                                                <td>
                                                    <label for="division_head_name_one">Officer One Name</label>
                                                    <input type="text" name="division_head_name_one" id="division_head_name_one" class="form-control" value="{{ old('division_head_name_one') }}" placeholder="Enter Officer One Name">
                                                </td>
                                                <td>
                                                    <label for="division_head_image_one">Officer One Image</label>
                                                    <input type="file" name="division_head_image_one" id="division_head_image_one" class="form-control">
                                                    <small class="form-control-feedback text-danger"> Accepted .jpg/.jpeg/.png format & allowed max size is 1MB </small>
                                                </td>
                                                <td>
                                                    <label for="status" >Officer One Designation </label>
                                                    <select name="designation_id_one" id="designation_id_one" class="form-control">
                                                        <option value="0" >-- None -- </option>
                                                        @foreach($designations as $key => $designation)
                                                        <option value="{{$designation->id}}" {{SELECT($designation,old('status'))}}>{{$designation->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>    
                                                <td>
                                                    <input type="checkbox"  name="division_head_status_one" id="division_head_status_one" value="1" {{CHECKBOX('division_head_status_one')}} >
                                                </td>                                            
                                            </tr>


                                            <tr>
                                                <td>
                                                    <label for="division_head_name_two">Officer Two Name</label>
                                                    <input type="text" name="division_head_name_two" id="division_head_name_two" class="form-control" value="{{ old('division_head_name_two') }}" placeholder="Enter Officer Two Name">
                                                </td>
                                                <td>
                                                    <label for="division_head_image_two">Officer Two Image</label>
                                                    <input type="file" name="division_head_image_two" id="division_head_image_two" class="form-control">
                                                    <small class="form-control-feedback text-danger"> Accepted .jpg/.jpeg/.png format & allowed max size is 1MB </small>
                                                </td>   
                                                <td>
                                                    <label for="status" > Officer Two Designation</label>
                                                    <select name="designation_id_two" id="designation_id_two" class="form-control">
                                                        <option value="0" >-- None -- </option>
                                                        @foreach($designations as $key => $designation)
                                                        <option value="{{$designation->id}}" {{SELECT($designation,old('status'))}}>{{$designation->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td> 
                                                <td>
                                                    <input type="checkbox"  name="division_head_status_two" id="division_head_status_two" value="1" {{CHECKBOX('division_head_status_two')}} >
                                                </td>                                             
                                            </tr>



                                            <tr>
                                                <td>
                                                    <label for="division_head_name_three">Officer Three Name</label>
                                                    <input type="text" name="division_head_name_three" id="division_head_name_three" class="form-control" value="{{ old('division_head_name_three') }}" placeholder="Enter Officer Three Name">
                                                </td>
                                                <td>
                                                    <label for="division_head_image_three">Officer Three Image</label>
                                                    <input type="file" name="division_head_image_three" id="division_head_image_three" class="form-control">
                                                    <small class="form-control-feedback text-danger"> Accepted .jpg/.jpeg/.png format & allowed max size is 1MB </small>
                                                </td>   
                                                <td>
                                                    <label for="status" >Officer Three Designation </label>
                                                    <select name="designation_id_three" id="designation_id_three" class="form-control">
                                                        <option value="0" >-- None -- </option>
                                                        @foreach($designations as $key => $designation)
                                                        <option value="{{$designation->id}}" {{SELECT($designation,old('status'))}}>{{$designation->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>   
                                                <td>

                                                    <input type="checkbox"  name="division_head_status_three" id="division_head_status_three" value="1" {{CHECKBOX('division_head_status_three')}}>                                         
                                                </td>                                            
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>




                            <!-- Common Action Buttons -->
                            <div class="mt-3 float-right">
                                <button type="submit" class="btn btn-success waves-effect waves-light"><i class="fa fa-check"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
            </div>
          </div>
        </div>
   </div>
</div>
@endsection
