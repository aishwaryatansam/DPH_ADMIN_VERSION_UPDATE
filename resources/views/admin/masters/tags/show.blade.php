@extends('admin.layouts.layout')
@section('title', 'View Tags')
@section('content')
<div class="container" style="margin-top: 90px;">
    <div class="container-fluid p-2" style="background-color: #f2f2f2;">
        <div class="d-flex justify-content-between align-items-center"
            style="padding-left: 20px; padding-right: 20px;">
            <h5 class="mb-0">Tags</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Tags</li>
                </ol>
            </nav>

        </div>
    </div>
    <div class="container-fluid">
        <div class="page-inner">
            <div class="container-fluid mt-2">
                <div class="row">
                    <div class="col-lg-5 p-5" style="background-color: #ffffff; border-radius: 10px;">
                        <!-- insert the contents Here start -->

                        <div class="card-body">
                            <!-- Heading -->
                            <h4 class="card-title mb-4 text-primary">View Tags Details</h4>
                        
                            <div class="row mb-3 p-3">
                                <!-- Name -->
                                <div class="col-md-9 pb-4">
                                    <div class="font-weight-bold text-secondary">Name:</div>
                                    <div class="border p-3 rounded bg-light">{{$result->name}}</div>
                                </div>

                                <!-- District -->
                                <div class="col-md-9">
                                    <div class="font-weight-bold text-secondary">Status:</div>
                                    <div class="border p-3 rounded bg-light">{{$result->hud->name ?? '--'}}</div>
                                </div>
                                  
                            </div>
                        
                            <div class="row mb-3 px-3">
                                <!-- Status -->
                                <div class="col-md-9">
                                    <div class="font-weight-bold text-secondary">Status:</div>
                                    <div class="border p-3 rounded bg-light">
                                        <span class="badge {{ $result->status == 1 ? 'bg-success' : 'bg-danger' }} text-light">{{findStatus($result->status)}}</span>
                                    </div>
                                </div>
                            </div>
                        
                            <button type="button" onclick="window.location.href='{{url('/tags')}}';" class="btn btn-primary mt-3" style="margin-left: 13px;">Back</button>
                        </div>
                        
                        



                        <!-- Edit Document Layout end -->




                        <!-- insert the contents Here end -->
                    </div>
                </div>
            </div>








        </div>
        <!-- page inner end-->
    </div>
    <!-- database table end -->
</div>
@endsection
