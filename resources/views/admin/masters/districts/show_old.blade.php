@extends('admin.layouts.layout')
@section('title', 'View District')
@section('content')
<div class="page-wrapper">
   <div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">District</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('districts.index')}}">District</a></li>
                    <li class="breadcrumb-item active">View District</li>
                </ol>
            </div>
        </div>
    </div>
      <div class="row">
         <div class="col-lg-12 card">
            <div class="card-body">
         <div class="row">
             
            <div class="col-md-3 col-xs-6 b-r">
               <strong>Name</strong>
               <br>
               {{$result->name}}
            </div>
             
            <div class="col-md-3 col-xs-6 b-r">
               <strong>Image</strong>
               <br>
               <p><a class="text-danger" href="{{fileLink($result->image_url)}}" target="_blank" download="download">{{$result->image_url}}</a></p>
            </div>
            
            <div class="col-md-3 showSpace col-xs-6 b-r">
               <strong>Map Location </strong>
               <br>
               
                @if($result->location_url)
                  <a href="{{$result->location_url}}" _target="blank">Click Here to View</a>
                @else

                <span> -- </span>

                @endif
            </div>
            <div class="col-md-3 col-xs-6 b-r">
               <strong>Status</strong>
               <br>
               {{findStatus($result->status)}}
            </div>
           
            <div class="col-md-3 col-xs-6 b-r">
               <strong>Created At</strong>
               <br>
              {{dateOf($result->created_at) ?? ''}}
            </div>
         </div>
         <hr>
      </div>
         </div>
      </div>
   </div>
</div>
@endsection
