@extends('admin.layouts.layout')
@section('title', 'Edit Facility Type')
@section('content')
<div class="container" style="margin-top: 90px;">
    <div class="container-fluid p-2" style="background-color: #f2f2f2;">
        <div class="d-flex justify-content-between align-items-center"
            style="padding-left: 20px; padding-right: 20px;">
            <h5 class="mb-0">Facility Type</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Facility Type</li>
                </ol>
            </nav>

        </div>
    </div>
    <div class="container-fluid">
        <div class="page-inner">
            <div class="container-fluid mt-2">
                <div class="row">
                    <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                        <!-- insert the contents Here start -->

                        <div class="card-body">
                            <!-- Heading -->
                            <h4 class="card-title mb-4 text-primary">Edit Facility Type</h4>
                        
                            <form action="{{route('facilitytypes.update',$result->id)}}" enctype="multipart/form-data" method="post">
                                {{csrf_field()}}
                                @method('PUT')
                                <div class="row mb-3 p-3">
                                    <!-- Name -->
                                    <div class="col-md-6">
                                        <div class="font-weight-bold text-secondary">Name:</div>
                                        <input type="text" class="form-control" id="Designationtype" name="name" value="{{old('name',$result->name)}}" required>
                                    </div>
                                    
                                </div>
                        
                                <div class="row mb-3 p-3">
                                    <!-- Status -->
                                    <div class="col-md-6">
                                        <div class="font-weight-bold text-secondary">Status:</div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input " name="status" type="checkbox"
                                                    id="toggleStatus" value="1"
                                                    {{ CHECKBOX('status', $result->status) }}
                                                    onchange="toggleStatusText('statusLabel', this)">
                                                <label class="form-check-label" for="toggleStatus"
                                                    id="statusLabel">{{ $result->status == 1 ? 'Active' : 'In-Active' }}</label>
                                        </div>
                                    </div>
                                    
                                </div>
                        
                                <div class="text-start mt-4">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a type="button" class="btn btn-danger" href="{{route('designations.index')}}">Cancel</a>
                                </div>
                            </form>
                        </div>
                        




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
