@extends('admin.layouts.layout')
@section('title', 'View Testimonial')
@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Testimonial</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('testimonials.index')}}">Testimonial</a></li>
                        <li class="breadcrumb-item active">View Testimonial</li>
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
                                    <th>Name</th>
                                    <td>{{$result->name}}</td>
                                </tr>
                                <tr>
                                    <th>Designation</th>
                                    <td>{{$result->designation ?? '--'}}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{findStatus($result->status)}}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{dateOf($result->created_at) ?? ''}}</td>
                                </tr>
                                <tr>
                                    <th>Content</th>
                                    <td colspan="7">{!! $result->content ?? '--' !!}</td>
                                </tr>
                                <tr>
                                    <th>Image</th>
                                    <td colspan="7">
                                        <p><a class="text-danger" href="{{fileLink($result->image_url)}}" target="_blank" download="download">{{$result->image_url}}</a></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Document URL</th>
                                    <td colspan="7">
                                        @if($result->testimonial_document_url)
                                        <a class="text-danger" href="{{fileLink($result->testimonial_document_url)}}" target="_blank" download="download">{{$result->testimonial_document_url}}</a>
                                        @else
                                        No Document Uploaded.
                                        @endif
                                    </td>
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
