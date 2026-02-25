@extends('admin.layouts.layout')
@section('title', 'List Designations')
@section('content')
<div class="container" style="margin-top: 90px;">
    <div class="container-fluid p-2" style="background-color: #f2f2f2;">
        <div class="d-flex justify-content-between align-items-center"
            style="padding-left: 20px; padding-right: 20px;">
            <h5 class="mb-0">Designation</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                    <li class="breadcrumb-item"><a href="#">Designation</a></li>
                    <li class="breadcrumb-item active" aria-current="page">List Designation</li>
                </ol>
            </nav>

        </div>
    </div>
    <div class="container-fluid">
        <div class="page-inner">
            <!-- insert the contents Here start -->


            <!-- Filter Card -->
            <div>
                <!-- <div class="card mb-0 mt-2">
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <!-- Name Field --
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Name">
                                    </div>
                                </div>
                
                                <!-- Designation Field --
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Designation</label>
                                        <input type="text" class="form-control" placeholder="Enter Designation">
                                    </div>
                                </div>
                
                                <!-- Status Field --
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control">
                                            <option>Active</option>
                                            <option>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                
                                <!-- Search and Reset Buttons --
                                <div class="col d-flex justify-content-end align-items-center mt-2">
                                    <div class="form-group d-flex">
                                        <button type="button" class="btn btn-primary me-2" style="border-radius: 10px;">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <button type="reset" class="btn btn-secondary" style="border-radius: 10px;">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> -->
                

                <!-- DataTable Start -->
                <div class="container-fluid mt-2">
                    <div class="col-md-12 col-lg-12 mt-lg-5 mt-md-3">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title mb-4 text-primary">All Designation</h4>
                                    <!-- Button to add employees if needed -->
                                    <button class="btn btn-primary btn-round ms-auto"
                                        onclick="window.location.href='{{route('designations.create')}}';">
                                        <i class="fa fa-plus"></i> Add Designation
                                    </button>

                                    <button class="btn btn-primary btn-round ms-auto" id="btnExcel">
                                        <i class="fa fa-plus"></i> Export
                                    </button>
                                   
                                </div>
                            </div>
                
                            <!-- Table Card -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th class="text-center" style="width: 10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($results as $result)
                                            <tr>
                                                <td>{{$result->name ?? ''}}</td>
                                                @if(isset($result->status) && $result->status == 1)
                                                <td class="text-success" style="font-weight: bold;">Active</td>
                                                @else
                                                <td class="text-danger" style="font-weight: bold;">In-Active</td>
                                                @endif
                                                <td class="text-center">
                                                    <div class="form-button-action">
                                                        <button type="button" class="btn btn-link btn-primary btn-lg"
                                                            onclick="window.location.href='{{route('designations.edit', $result->id)}}'" data-bs-toggle="tooltip"
                                                            title="Edit Designation">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        {{-- <button type="button" class="btn btn-link btn-danger"
                                                            onclick="window.location.href='designation_view.html'" data-bs-toggle="tooltip"
                                                            title="View Designation">
                                                            <i class="fa fa-eye"></i>
                                                        </button> --}}
                                                    </div>
                                                </td>
                                            </tr> 
                                            @endforeach
                                            <!-- Additional rows as needed -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- DataTable End -->


                <!-- insert the contents Here end -->
            </div>
        </div>
    </div>









    <!-- content end here -->
    <!-- main panel end -->
</div>
<script>
   $(document).ready(function () {
    var table = $('#add-row').DataTable({
        "paging": true,
        "searching": true,
        "lengthChange": true,
        "pageLength": 10,
        "info": true,
        "autoWidth": false,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                className: 'buttons-excel',
                init: function(api, node, config){
                    $(node).hide();
                }
            }
        ]
    });

    $('#btnExcel').on('click', function () {
        table.button('.buttons-excel').trigger();
    });
});
</script>


<script type="text/javascript">
  $(document).ready(function(){
    setPageUrl('/designations?');
  });
</script>
@endsection
