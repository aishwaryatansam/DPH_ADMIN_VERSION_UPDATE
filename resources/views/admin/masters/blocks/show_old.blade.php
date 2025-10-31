@extends('admin.layouts.layout')
@section('title', 'View Block')
@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Block</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('blocks.index')}}">Block</a></li>
                        <li class="breadcrumb-item active">View Block</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">Is Urban</th>
                                    <td>{{$result->is_urban}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Name</th>
                                    <td>{{$result->name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">HUD</th>
                                    <td>{{$result->hud->name ?? '--'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Image</th>
                                    <td>
                                        @if($result->image_url)
                                        <a class="text-danger" href="{{fileLink($result->image_url)}}" target="_blank"
                                            download="download">{{$result->image_url}}</a>
                                        @else
                                        No Image Uploaded.
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Video</th>
                                    <td>
                                        @if($result->video_url)
                                        <a href="{{$result->video_url}}" target="_blank">Click Here to View</a>
                                        @else
                                        --
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Map Location</th>
                                    <td>
                                        @if($result->location_url)
                                        <a href="{{$result->location_url}}" target="_blank">Click Here to View</a>
                                        @else
                                        --
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Land Document</th>
                                    <td>
                                        @if($result->property_document_url)
                                        <a class="text-danger" href="{{fileLink($result->property_document_url)}}"
                                            target="_blank" download="download">{{$result->property_document_url}}</a>
                                        @else
                                        No Land Document Uploaded.
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Status</th>
                                    <td>{{findStatus($result->status)}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Created At</th>
                                    <td>{{dateOf($result->created_at) ?? ''}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
