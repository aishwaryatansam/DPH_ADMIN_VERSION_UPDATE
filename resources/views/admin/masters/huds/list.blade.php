@extends('admin.layouts.layout')
@section('title', 'List Huds')
@section('content')
<div class="container" style="margin-top: 90px;">
    <div class="container-fluid p-2" style="background-color: #f2f2f2;">
        <div class="d-flex justify-content-between align-items-center"
            style="padding-left: 20px; padding-right: 20px;">
            <h5 class="mb-0">Health Unit District</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                    <li class="breadcrumb-item"><a href="#">HUD</a></li>
                    <li class="breadcrumb-item active" aria-current="page">List</li>
                </ol>
            </nav>

        </div>
    </div>
    <div class="container-fluid">
        <div class="page-inner">
            <!-- insert the contents Here start -->

            <div class="card mb-0 mt-2">
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col col-md-4">
                                <div class="form-group">
                                    <label>District</label>
                                    <select name="district_id" class="form-control form-control-line searchable" onchange="searchFun()">
                                        <option value="" >-- Select District -- </option>
                                          @foreach($districts as $district)
          
                                      <option value="{{$district->id}}" {{SELECT($district->id,request('district_id'))}}>{{$district->name}}</option>
                                      @endforeach
                                      </select>
                                </div>
                            </div>
                            <div class="col d-flex justify-content-end align-items-center mt-2">
                                <div class="form-group d-flex">
                                    <button type="reset" onClick="resetSearch()" class="btn btn-secondary resetSearch"
                                        style="border-radius: 10px;">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>


            <!-- Filter Card -->
            <div>
                <!-- DataTable Start -->
                <div class="container-fluid mt-2">
                    <div class="col-md-12 col-lg-12 mt-lg-5 mt-md-3">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title mb-4 text-primary">All HUD</h4>
                                    <!-- Button to add employees if needed -->
                                    <button class="btn btn-primary btn-round ms-auto"
                                        onclick="window.location.href='{{route('huds.create')}}';">
                                        <i class="fa fa-plus"></i> Add HUD
                                    </button>
                                <a href="{{ route('huds.export') }}" class="btn btn-secondary btn-round ms-2">
    <i class="fa fa-download"></i> Download
</a>

                                </div>
                            </div>

                            <!-- Table Card -->
                            <div class="card-body">
                                <form method="GET" action="{{ url('/huds') }}" class="mb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <label for="pageLength" class="me-2 mb-0">Show</label>
            <select name="pageLength" id="pageLength" class="form-select w-auto" onchange="this.form.submit()">
                @foreach(getPageLenthArr() as $pageLength)
                    <option value="{{ $pageLength }}" {{ request('pageLength', 10) == $pageLength ? 'selected' : '' }}>
                        {{ $pageLength }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto ms-auto">
            <label for="keyword">Search:</label>
            <input type="search" name="keyword" id="keyword" value="{{ request('keyword') }}">
            <button type="submit">Go</button>
        </div>
    </div>
</form>

                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <td>District</td>
                                                <th>Status</th>
                                                 <th>Tags</th>
                                                <th class="text-center" style="width: 10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($results as $result)
                                            <tr>
                                                <td>{{$result->name ?? ''}}</td>
                                                <td>{{$result->district->name ?? ''}}</td>
                                                <td class="text-success" style="font-weight: bold;">
                                                    @if(isset($result->status) && $result->status == 1)
                                                    <span class="text-success">Active</span>
                                                    @else
                                                      <span class="text-danger">In-Active</span>
                                                    @endif
                                                </td>
                                                 <td>{{ $result->tag_names }}</td>
                                                <td class="text-center">
                                                    <div class="form-button-action">
                                                        <button type="button"
                                                            class="btn btn-link btn-primary btn-lg"
                                                            onclick="window.location.href='{{route('huds.edit',$result->id)}}'"
                                                            data-bs-toggle="tooltip" title="Edit Hud">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-link btn-danger"
                                                            onclick="window.location.href='{{route('huds.show',$result->id)}}'"
                                                            data-bs-toggle="tooltip" title="View Hud">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <!-- Additional rows as needed -->
                                        </tbody>
                                        
                                    </table>
                                     <div class="mt-3">
       {{ $results->links('pagination::bootstrap-5') }}

    </div>
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
 <!-- Include Libraries -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
   <script>
$(document).ready(function () {
    var tableData = @json($results->items()); // ✅ Only the data, not pagination meta

    // Initialize DataTable
    $('#add-row').DataTable({
        "paging": true,
        "searching": true,
        "lengthChange": true,
        "pageLength": 10,
        "info": true,
        "autoWidth": false,
    });

    // Handle the download button click
    $('#downloadBtn').on('click', function () {
        if (!tableData.length) {
            alert('No data to export!');
            return;
        }

        // Prepare data for export
        var exportData = [];
        tableData.forEach(function (row) {
            exportData.push([
                row.name ?? '',
                row.district ? row.district.name : '',
                row.status == 1 ? 'Active' : 'In-Active'
            ]);
        });

        // Define the headers
        var headers = ['HUD Name', 'District Name', 'Status'];

        // Create worksheet
        var ws = XLSX.utils.aoa_to_sheet([headers].concat(exportData));

        // Create workbook and add the worksheet
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'HUDs');

        // Generate filename
        var filename = 'huds-list-' + new Date().toLocaleDateString('en-GB').replace(/\//g, '-') + '.xlsx';

        // Trigger download
        XLSX.writeFile(wb, filename);
    });
});
</script>

<script type="text/javascript">
  $(document).ready(function(){
    setPageUrl('/huds?');
  });
</script>
@endsection
