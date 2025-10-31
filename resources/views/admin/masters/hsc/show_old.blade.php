@extends('admin.layouts.layout')
@section('title', 'View Hsc')
@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Hsc</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('hsc.index')}}">Hsc</a></li>
                        <li class="breadcrumb-item active">View Hsc</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 card">
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><strong>Is Urban</strong></td>
                                <td>{{$result->is_urban}}</td>
                            </tr>
                            <tr>
                                <td><strong>Name</strong></td>
                                <td>{{$result->name}}</td>
                            </tr>
                            <tr>
                                <td><strong>PHC</strong></td>
                                <td>{{$result->phc->name ?? '--'}}</td>
                            </tr>
                            <tr>
                                <td><strong>Image</strong></td>
                                <td><a class="text-danger" href="{{fileLink($result->image_url)}}" target="_blank" download="download">{{$result->image_url}}</a></td>
                            </tr>
                            <tr>
                                <td><strong>Video</strong></td>
                                <td>
                                    @if($result->video_url)
                                        <a href="{{$result->video_url}}" _target="blank">Click Here to View</a>
                                    @else
                                        <span> -- </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Map Location</strong></td>
                                <td>
                                    @if($result->location_url)
                                        <a href="{{$result->location_url}}" _target="blank">Click Here to View</a>
                                    @else
                                        <span> -- </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Land Document</strong></td>
                                <td><a class="text-danger" href="{{fileLink($result->property_document_url)}}" target="_blank" download="download">{{$result->property_document_url}}</a></td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>{{findStatus($result->status)}}</td>
                            </tr>
                            <tr>
                                <td><strong>Created At</strong></td>
                                <td>{{dateOf($result->created_at) ?? ''}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
