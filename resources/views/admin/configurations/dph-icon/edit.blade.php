@extends('admin.layouts.layout')
@section('title', 'Create DPH Icon')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">DPH Icon</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">DPH Icon</li>
                    </ol>
                </nav>

            </div>
        </div>

        <div class="container-fluid">
            <div class="page-inner">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- insert the contents Here start -->

                <div class="container mt-2">
                    <div class="row">
                        <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                                <!-- Separate div for Scroller Notification -->
                                <form id="dphIconForm" action="{{ route('dph-icon.update', $result->id) }}" enctype="multipart/form-data"
                                    method="post">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <div class="container">
                                        <h4 class="mb-4 text-primary">Edit DPH Icon</h4>
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="dphIconName" class="form-label font-weight-bold">Name<span
                                                    class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control" id="name"
                                                    placeholder="Enter Name" required name="name" value="{{$result->name}}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="dphIconLink" class="form-label font-weight-bold">Link<span
                                                    class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input type="text" class="form-control" id="link"
                                                    placeholder="Enter Link" required name="link" value="{{$result->link}}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="coloreffect" class="form-label">Colour Effect</label>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input"
                                                           name="coloreffect"
                                                           type="checkbox"
                                                           id="toggleColor1"
                                                           value="1"
                                                           {{ CHECKBOX('coloreffect', $result->coloreffect) }}
                                                           onchange="toggleColor1Text('statusLabel', this)">
                                                    <label class="form-check-label"
                                                    for="toggleColor1"
                                                    id="statusLabel">
                                                        {{ $result->coloreffect == 1 ? 'Active' : 'In-Active' }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="status" class="form-label">Status</label>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input"
                                                        name="status"
                                                        type="checkbox"
                                                        id="toggleStatus"
                                                        value="1"
                                                        {{ CHECKBOX('status', $result->status) }}
                                                        onchange="toggleStatusText('statusLabel', this)">
                                                    <label class="form-check-label"
                                                    for="toggleStatus"
                                                        id="statusLabel">
                                                        {{ $result->status == 1 ? 'Active' : 'In-Active' }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <!-- Button trigger modal -->
                                        <div class="d-flex mt-2 pl-5">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="button" style="margin-left: 10px;"
                                                class="btn btn-danger" onclick="history.back()">Cancel</button>
                                        </div>
                                </form>

                        </div>
                    </div>
                </div>


                <!-- insert the contents Here end -->
            </div>
            <!-- page inner end-->
        </div>
    @endsection
