@extends('admin.layouts.layout')
@section('title', 'View Document')
@section('content')
<div class="page-wrapper">
   <div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Document</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('documents.index')}}">Document</a></li>
                    <li class="breadcrumb-item active">View Document</li>
                </ol>
            </div>
        </div>
    </div>
      <div class="row">
         <div class="col-lg-12 card">
            <div class="card-body">
         <div class="row">

           <div class="col-md-3 col-xs-6 b-r">
               <strong>Type of Document</strong>
               <br>
               {{$result->navigation->name}}
            </div>
            
            <div class="col-md-3 col-xs-6 b-r">
               <strong>Name of Document</strong>
               <br>
               <p><a class="text-danger" href="{{fileLink($result->document_url)}}" target="_blank" download="download">{{$result->display_filename}}</a></p>
            </div>
           
            <div class="col-md-3 col-xs-6 b-r">
               <strong>File Name to Display</strong>
               <br>
               {{$result->display_filename}}
            </div>
            <div class="col-md-3 col-xs-6 b-r">
               <strong>Mapping Section</strong>
               <br>
               <span class="text-danger">{{ $result->tag->name ?? '--' }} ,</span>
            </div>
            <div class="col-md-3 col-xs-6 b-r">
               <strong>G.O /Letter / Reference no.</strong>
               <br>
               <span class="text-danger">{{ $result->reference_no ?? '--' }} ,</span>
            </div>
            <div class="col-md-3 col-xs-6 b-r">
               <strong>Visible to public</strong>
               <br>
               <span class="text-danger">{{ ($result->visible_to_public == 1)?'Yes':'No' }} </span>
            </div>
            <div class="col-md-3 col-xs-6 b-r">
               <strong>Dated</strong>
               <br>
               <span class="text-danger">{{ $result->dated }} </span>
            </div>
         </div>
         <hr>
         <div class="row">
            <div class="col-md-3 col-xs-6 b-r">
               <strong>Uploaded By</strong>
               <br>
               {{$result->employee->name}}
            </div>
           
              @if($result->navigation->slug_key == 'announcements')
             <div class="col-md-3 col-xs-6 b-r">
               <strong>Image</strong>
               <br>
               <p><a class="text-danger" href="{{fileLink($result->image_url)}}" target="_blank" download="download">{{$result->image_url}}</a></p>
            </div>
              @endif

              <div class="col-md-3 showSpace col-xs-6 b-r">
               <strong>Link</strong>
               <br>
               {{$result->link_url}}
            </div>

              <div class="col-md-3 col-xs-6 b-r">
               <strong>Link Title</strong>
               <br>
               {{$result->link_title}}
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
