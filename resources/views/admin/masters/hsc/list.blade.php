@extends('admin.layouts.layout')
@section('title', 'List Hsc')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Health Sub Center</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">HSC</a></li>
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
                        <form method="GET" action="{{ url('/hsc') }}">
                            <div class="row">
                                <div class="col col-md-4">
                                
          <div>
             <label>Block</label>
              <select name="block_id" class="form-control" onchange="this.form.submit()">
            <option value="">-- Select Block --</option>
            @foreach ($huds as $hud)
                <optgroup label="{{ $hud->name }}">
                    @foreach ($hud->blocks as $block)
                        <option value="{{ $block->id }}" {{ request('block_id') == $block->id ? 'selected' : '' }}>
                            {{ $block->name }}
                        </option>
                    @endforeach
                </optgroup>
            @endforeach
             </select>
    </div>


        <label>PHC</label>
        <select name="phc_id" class="form-control" onchange="this.form.submit()">
            <option value="">-- Select PHC --</option>
            @foreach ($phcs as $phc)
                <option value="{{ $phc->id }}" {{ request('phc_id') == $phc->id ? 'selected' : '' }}>
                    {{ $phc->name }}
                </option>
            @endforeach
        </select>
    
    
 <div class="col d-flex justify-content-end align-items-center mt-2">
                                    <div class="form-group d-flex">
                                        <button type="reset" onClick="resetSearch()" class="btn btn-secondary resetSearch"
                                            style="border-radius: 10px;">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                    </div>
                                </div>

                                </div>
                              
                            </div>

                    </div></form> 
                </div>
                <!-- Filter Card end-->
                <div>
                    <!-- DataTable Start -->
                    <div class="container-fluid mt-2">
                        <div class="col-md-12 col-lg-12 mt-lg-5 mt-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title mb-4 text-primary">All HSC</h4>
                                        <!-- Button to add employees if needed -->
                                        <button class="btn btn-primary btn-round ms-auto"
                                            onclick="window.location.href='{{route('hsc.create')}}';">
                                            <i class="fa fa-plus"></i> Add HSC
                                        </button>
<a href="{{ route('hsc.export', request()->all()) }}" class="btn btn-success">
    Download Excel
</a>


                                    </div>
                                </div>
                                <!-- Table Card -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div class="row m-b-40">
                                            <div class="col-sm-12 col-md-6">
                                              <div class="col-auto">
                                                <form method="GET" action="{{ url('/hsc' ) }}" class="mb-3">
            <!-- #region -->                    <label for="pageLength" class="me-2 mb-0">Show</label>
          
          
                                                   <select name="pageLength" id="pageLength" class="form-select w-auto" onchange="this.form.submit()">
                                                     @foreach(getPageLenthArr() as $pageLength)
                                                 <option value="{{ $pageLength }}" {{ request('pageLength', 10) == $pageLength ? 'selected' : '' }}>
                                          {{ $pageLength }}
                                              </option>
                                                                   @endforeach
                                                         </select></form>
                                             </div>
                                             </div>
                                             <div class="col-sm-12 col-md-6">
                                                <div class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="myTable" id="keyword" value=""></label></div>
                                             </div>
                                        </div>
                                        <table id="add-row" class="display table table-striped table-hover"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>PHC</th>
                                                    <th>Status</th>
                                                    <th class="text-center" style="width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($results-> isEmpty())
                                                <tr>
                                                    <td colspan="8" class="text-center">No HSC available.</td>
                                                </tr>
                                                @else
                                                @foreach ($results as $result)
                                                    <tr>
                                                        <td>{{ $result->name ?? '' }}</td>
                                                        <td>{{ $result->phc->name ?? '' }}</td>
                                                        <td style="font-weight: bold;">
                                                            @if (isset($result->status) && $result->status == 1)
                                                                <span class="text-success">Active</span>
                                                            @else
                                                                <span class="text-danger">In-Active</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="form-button-action">
                                                                <button type="button"
                                                                    class="btn btn-link btn-primary btn-lg"
                                                                    onclick="window.location.href='{{ route('hsc.edit', $result->id) }}'"
                                                                    data-bs-toggle="tooltip" title="Edit HSC">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-link btn-danger"
                                                                    onclick="window.location.href='{{ route('hsc.show', $result->id) }}'"
                                                                    data-bs-toggle="tooltip" title="View HSC">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <!-- Pagination Links -->
                                       
                                    </div>
                                     @if(method_exists($results, 'links'))
                                    <div class="mt-3">
                                       {{ $results->appends(request()->query())->links('pagination::bootstrap-5') }}

                                    </div>
                                @endif
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
// Handle the download button click
$('#downloadBtn').on('click', function () {
    // Prepare data for export
    var exportData = [];
    
    // Loop through each row in the table
    $('#add-row tbody tr').each(function () {
        var row = $(this);
        var name = row.find('td').eq(0).text(); // Get the name (HSC Name)
        var phcName = row.find('td').eq(1).text(); // Get the PHC Name
        var status = row.find('td').eq(2).text(); // Get the status (Active/Inactive)

        // Push the row data into exportData array
        exportData.push([name, phcName, status]);
    });

    // Define the headers
    var headers = ['HSC Name', 'PHC Name', 'Status'];

    // Create worksheet
    var ws = XLSX.utils.aoa_to_sheet([headers].concat(exportData));

    // Create workbook and add the worksheet
    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'hsc');

    // Set filename
    var filename = 'hsc-list-' + new Date().toLocaleDateString('en-GB').replace(/\//g, '-') + '.xlsx';

    // Trigger download
    XLSX.writeFile(wb, filename);
});

</script>
<script>
function searchFun() {
    // Get selected values
    var blockId = document.querySelector('select[name="block_id"]').value;
    var phcId = document.querySelector('select[name="phc_id"]').value;

    // Build query string
    var query = '?';
    if (blockId) query += 'block_id=' + blockId + '&';
    if (phcId) query += 'phc_id=' + phcId + '&';

    // Redirect to URL with filters applied
    window.location.href = '/hsc' + query;
}

function resetSearch() {
    window.location.href = '/hsc';
}
</script>

@endsection
