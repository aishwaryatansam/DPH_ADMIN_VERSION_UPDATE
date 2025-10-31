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
                        <form>
                            <div class="row">
                                <div class="col col-md-4">
                                    <div class="form-group">
                                        <label>Block</label>
                                        <select name="block_id" class="form-control searchable" onchange="searchFun()">
                                            <option value="">-- Select Block -- </option>
                                            @foreach ($huds as $hud)
                                                <optgroup label="{{ $hud->name }}">
                                                    @foreach ($hud->blocks as $block)
                                                        <option value="{{ $block->id }}"
                                                            {{ SELECT($block->id, request('block_id')) }}>
                                                            {{ $block->name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col col-md-4">
                                    <div class="form-group">
                                        <label>PHC</label>
                                        <select name="phc_id" class="form-control searchable" onchange="searchFun()">
                                            <option value="">-- Select PHC -- </option>
                                            @foreach ($phcs as $phc)
                                                <option value="{{ $phc->id }}"
                                                    {{ SELECT($phc->id, request('phc_id')) }}>{{ $phc->name }}</option>
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

                                        <button class="btn btn-secondary btn-round ms-2" id="downloadBtn">
                                            <i class="fa fa-download"></i> Download
                                        </button>

                                    </div>
                                </div>
                                <!-- Table Card -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div class="row m-b-40">
                                            <div class="col-sm-12 col-md-6">
                                                <div class="dataTables_length" id="myTable_length">
                                                   <label>Show </label>
                                                      <select name="pageLength" id="pageLength" aria-controls="myTable" on-change="searchFun()">
                                                        @foreach(getPageLenthArr() as $pageLenght)
                                              <option value="{{$pageLenght}}" {{SELECT($pageLenght,request('pageLength'))}}>{{$pageLenght}}</option>
                                              @endforeach   
                                                      </select>
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
                                        @include('admin.common.table-footer')
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
    <script type="text/javascript">
        $(document).ready(function() {
            setPageUrl('/hsc?');
        });
    </script>
@endsection
