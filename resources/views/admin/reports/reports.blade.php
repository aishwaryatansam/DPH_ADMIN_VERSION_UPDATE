@extends('admin.layouts.layout')
@section('title', 'Reports')
@section('content')
<style type="text/css">
.small-input {
    width: 150px; /* Adjust the width as needed */
}

.medium-input {
    width: 300px; /* Adjust the width as needed */
}

.large-input {
    width: 600px; /* Adjust the width as needed */
}
</style>
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Reports</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Reports</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Table Html -->
                @if(isAdmin())
                <div class="card">
                    <div class="card-body">
                    <h3>Master Reports</h3>
                    <hr>
                    <div class="row">                    
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">HUD Report</h4>
                                    <a href="{{url('/huds-export')}}" class="btn btn-info">Download Report <i class="fa fa-download" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Documents Report</h4>
                                    <a href="{{url('/documents-export')}}" class="btn btn-info">Download Report <i class="fa fa-download" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <!-- add another report here -->
                                </div>
                            </div>
                        </div>                    
                    </div>
                    
                    </div>
                </div>
                @endif

                @if(isAdmin() || isHud())
                <div class="card">
                    <div class="card-body">
                    <h3>Consolidated Reports</h3>
                    <hr>
                    <div class="row">       
                        @if(isAdmin())            
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">HUD Report</h4>
                                    <a href="{{url('/consolidate-export?type=hud')}}" class="btn btn-info">Download Report <i class="fa fa-download" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Block Report</h4>
                                    <a href="{{url('/consolidate-export?type=block')}}" class="btn btn-info">Download Report <i class="fa fa-download" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">PHC Report</h4>
                                    <a href="{{url('/consolidate-export?type=phc')}}" class="btn btn-info">Download Report <i class="fa fa-download" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">HSC Report</h4>
                                    <a href="{{url('/consolidate-export?type=hsc')}}" class="btn btn-info">Download Report <i class="fa fa-download" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>                 
                    </div>
                    
                    </div>
                </div>
                @endif

                
            </div>
        </div>
    </div>
</div>
</html>
@endsection
