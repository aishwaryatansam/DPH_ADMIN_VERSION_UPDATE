@extends('admin.layouts.layout')
@section('title', 'List Programs')
@section('content')
    <div class="container" id="maincontent">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Documents</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Master</li>
                    </ol>
                </nav>

            </div>
        </div>
        <div class="container-fluid">
            <div class="page-inner">
                <div class="container-fluid mt-2">
                    <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                        <form id="referenceForm" action="{{ route('masters.update', $result->id) }}"
                            enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            @method('PUT')
                            <h4 class="card-title mb-4 text-primary">Edit {{ $result->master_type->name }}</h4>

                            <!-- All Fields in One Div using d-grid -->
                            <div class="d-grid gap-4 mb-3 grid-2 grid-1">

                                <!-- Row for Name and Master Type Fields -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Name Field -->
                                        <label for="userName" class="form-label">Name <span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" value="{{ $result->name }}"
                                            id="userName" placeholder="Enter User Name" name="name" required>
                                    </div>
                                </div>

                                <!-- Status Field -->
                                <div>
                                    <label for="status" class="form-label">Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input " name="status" type="checkbox" id="toggleStatus"
                                            value="1" {{ CHECKBOX('status', $result->status) }}
                                            onchange="toggleStatusText('statusLabel', this)">
                                        <label class="form-check-label" for="toggleStatus"
                                            id="statusLabel">{{ $result->status == 1 ? 'Active' : 'In-Active' }}</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex mt-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-danger" onclick="history.back()" style="margin-left: 10px;">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <!-- database table end -->
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            setPageUrl('/masters?');
        });
    </script>
@endsection
