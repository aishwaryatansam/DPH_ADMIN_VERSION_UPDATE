@extends('admin.layouts.layout')
@section('title', 'List Blocks')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Block</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Block</a></li>
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
                                        <label>HUD</label>
                                        <select name="hud_id" class="form-control form-control-line searchable"
                                            onchange="searchFun()">
                                            <option value="">-- Select HUD -- </option>
                                            @foreach ($huds as $hud)

                                                <option value="{{ $hud->id }}"
                                                    {{ SELECT($hud->id, request('hud_id')) }}>{{ $hud->name }}</option>
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
                                        <h4 class="card-title mb-4 text-primary">All Block</h4>
                                        <!-- Button to add employees if needed -->
                                        <button class="btn btn-primary btn-round ms-auto"
                                            onclick="window.location.href='{{route('blocks.create')}}';">
                                            <i class="fa fa-plus"></i> Add Block
                                        </button>
                                        <button class="btn btn-secondary btn-round ms-2" id="downloadBtn">
                                            <i class="fa fa-download"></i> Download
                                        </button>

                                    </div>
                                </div>

                                <!-- Table Card -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="add-row" class="display table table-striped table-hover"
                                            style="width:100%">
                                            <thead>

                                                <tr>
                                                    <th>Name</th>
                                                    <th>HUD</th>
                                                    <th>Status</th>
                                                    <th class="text-center" style="width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($results as $result)
                                                    <tr>
                                                        <td>{{ $result->name ?? '' }}</td>
                                                        <td>{{ $result->hud->name ?? '' }}</td>
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
                                                                    onclick="window.location.href='{{route('blocks.edit',$result->id)}}'"
                                                                    data-bs-toggle="tooltip" title="Edit Block">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-link btn-danger"
                                                                    onclick="window.location.href='{{route('blocks.show',$result->id)}}'"
                                                                    data-bs-toggle="tooltip" title="View Block">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
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
   <!-- Include Libraries -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script>
    $(document).ready(function () {
        var tableData = @json($results);

        // Initialize DataTable
        if (tableData.length > 0) {
            $('#add-row').DataTable({
                "paging": true,
                "searching": true,
                "lengthChange": true,
                "pageLength": 10,
                "info": true,
                "autoWidth": false,
            });
        } else {
            $('#add-row').DataTable({
                "data": [],
                "paging": true,
                "searching": true,
                "lengthChange": true,
                "pageLength": 10,
                "info": true,
                "autoWidth": false,
            });
        }

        // Handle the download button click
        $('#downloadBtn').on('click', function () {
            // Prepare data for export
            var exportData = [];
            tableData.forEach(function (row) {
                exportData.push([
                    row.name ?? '', // Block Name
                    row.hud ? row.hud.name : '', // HUD Name
                    row.status == 1 ? 'Active' : 'In-Active' // Status
                ]);
            });

            // Define the headers
            var headers = ['Block Name', 'HUD', 'Status'];

            // Create worksheet
            var ws = XLSX.utils.aoa_to_sheet([headers].concat(exportData));

            // Create workbook and add the worksheet
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Blocks');

            // Set filename
            var filename = 'blocks-list-' + new Date().toLocaleDateString('en-GB').replace(/\//g, '-') + '.xlsx';

            // Trigger download
            XLSX.writeFile(wb, filename);
        });
    });
</script>

    <script type="text/javascript">
        $(document).ready(function() {
            setPageUrl('/blocks?');
        });
    </script>
@endsection
