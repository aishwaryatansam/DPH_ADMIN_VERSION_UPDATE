@extends('admin.layouts.layout')
@section('title', 'List Programs')
@section('content')
<div class="container" id="maincontent">
    <div class="container-fluid p-2" style="background-color: #f2f2f2;">
      <div class="d-flex justify-content-between align-items-center"
        style="padding-left: 20px; padding-right: 20px;">
        <h5 class="mb-0">Documents</h5>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Master</li>
          </ol>
        </nav>

      </div>
    </div>
    <div class="container-fluid">
        <div class="page-inner">
            <div class="container-fluid mt-2">
                <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                    <form id="masterForm" action="{{route('masters.store')}}" enctype="multipart/form-data" method="post">
                        {{csrf_field()}}
                        <h4 class="card-title mb-4 text-primary">Create {{ $master_type->firstWhere('id', request('master_type'))->name ?? 'Masters' }}</h4>
    
                        <!-- All Fields in One Div using d-grid -->
                        <div class="d-grid gap-4 mb-3 grid-2 grid-1">
                            
                            <!-- Row for Name and Master Type Fields -->
                            <div class="row">
                                <input type="hidden" name="master_type_id" value="{{request('master_type')}}">
                                <div class="col-md-6">
                                    <!-- Name Field -->
                                    <label for="userName" class="form-label">Name <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="name" id="userName" placeholder="Enter User Name" required>
                                </div>
    
                            </div>
    
                            <!-- Status Field -->
                            <div>
                                <label for="status" class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="status" type="checkbox"
                                                    id="toggleStatus" value="1" {{ CHECKBOX('document_status') }}
                                                    onchange="toggleStatusText('statusLabel', this)">
                                                <label class="form-check-label" for="toggleStatus"
                                                    id="statusLabel">In-Active</label>
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
