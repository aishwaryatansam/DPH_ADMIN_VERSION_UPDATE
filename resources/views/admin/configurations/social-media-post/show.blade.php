@extends('admin.layouts.layout')
@section('title', 'List Director Message')
@section('content')
<div class="container" style="margin-top: 90px;">
    <div class="container-fluid p-2" style="background-color: #f2f2f2;">
      <div class="d-flex justify-content-between align-items-center"
        style="padding-left: 20px; padding-right: 20px;">
        <h5 class="mb-0">View Director Message</h5>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
            <li class="breadcrumb-item"><a href="#">Director Message</a></li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
          </ol>
        </nav>

      </div>
    </div>

    <div class="container-fluid">
      <div class="page-inner">
        <div class="container mt-2">
          <!-- insert the contents Here start -->

          <div class="col-md-12 col-lg-12 p-3">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <!-- Heading -->
                    <h4 class="card-title mb-4 text-primary">View Social Media Post Details</h4>

                    <!-- Row for Title -->
                    <div class="row mb-3 p-3">
                        <div class="col-md-2 font-weight-bold text-secondary">Name:</div>
                        <div class="col-md-8 border p-3 rounded bg-light">
                            {{$result->name}}
                        </div>
                    </div>

                    <!-- Row for Link -->
                    <div class="row mb-3 p-3">
                        <div class="col-md-2 font-weight-bold text-secondary">Link:</div>
                        <div class="col-md-8 border p-3 rounded bg-light">
                            <a href="{{ $result->link ?? '' }}" target="_blank" class="text-primary">{{$result->link}}</a>
                        </div>
                    </div>

                    <!-- Row for Logo -->
                    <div class="row mb-5 p-3">
                        <div class="col-md-2 font-weight-bold text-secondary">Logo:</div>
                        <div class="col-md-8 d-flex align-items-center">
                            <img src="{{fileLink($result->image_url)}}" alt="Logo" class="img-fluid rounded"
                                style="max-height: 150px; max-width: 150px; object-fit: cover;">
                        </div>
                    </div>

                    <!-- Row for Status -->
                    <div class="row mb-3 p-3">
                        <div class="col-md-2 font-weight-bold text-secondary">Status:</div>
                        <div class="col-md-8">
                            <span class="badge bg-success text-light">Active</span>
                        </div>
                    </div>

                    <!-- Row for Back Button -->
                    <button type="button" class="btn btn-primary px-5 py-2 mt-5"
                        onclick="window.location.href='socialmediapost_list.html'">Back</button>

                </div>
            </div>
        </div>










          <!-- insert the contents Here end -->
        </div>
        <!-- page inner end-->
      </div>
      <!-- database table end -->
    </div>

    <!-- content end here -->







    <footer class="footer">
      <div class="container-fluid d-flex justify-content-center align-items-center">
        <div class="copyright">
          <p> Copyright © 2024 <a target="_blank" href="http://tansam.org/">TANSAM</a>. All Rights Reserved.Created
            By
            TANSAM IT DEPARTMENT </p>
        </div>
        <!-- <div>
          Distributed by
          <a target="_blank" href="https://themewagon.com/">ThemeWagon</a>.
        </div> -->
      </div>
    </footer>
    <!-- main panel end -->
  </div>
@endsection
