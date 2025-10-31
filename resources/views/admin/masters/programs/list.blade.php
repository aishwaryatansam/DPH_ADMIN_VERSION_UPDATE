@extends('admin.layouts.layout')
@section('title', 'List Programs')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Programs & Divisions</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List Programs & Divisions</li>
                    </ol>
                </nav>

            </div>
        </div>
        <div class="container-fluid">
            <div class="page-inner">
                <!-- insert the contents Here start -->


                <!-- Filter Card -->
                <div>


                    <!-- DataTable Start -->
                    <div class="container-fluid mt-2">
                        <div class="col-md-12 col-lg-12 mt-lg-5 mt-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title mb-4 text-primary">All Program Divisions</h4>
                                        <!-- Button to add employees if needed -->
                                        <button class="btn btn-primary btn-round ms-auto"
                                            onclick="window.location.href='{{ route('programs.create') }}';">
                                            <i class="fa fa-plus"></i> Add Program Divisions
                                        </button>

                                        <!-- Button to export sections -->
                                        <button class="btn btn-secondary btn-round ms-2" id="btnExcel">
                                            <i class="fa fa-download"></i> Export programs
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
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Short Code</th>
                                                    <th>order No</th>
                                                    <th>Status</th>
                                                    <th class="text-center" style="width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($results as $result)
                                                    <tr>
                                                      <th>{{ $result->id ?? '' }}</th>
                                                        <td>{{ $result->name ?? '' }}</td>
                                                        <td>{{ $result->short_code ?? '' }}</td>
                                                        <td>{{ $result->order_no ?? '' }}</td>
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
                                                                    onclick="window.location.href='{{route('programs.edit',$result->id)}}'"
                                                                    data-bs-toggle="tooltip" title="Edit program">
                                                                    <i class="fa fa-edit"></i>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#add-row').DataTable({
            "paging": true,
            "searching": true,
            "lengthChange": true,
            "pageLength": 10,
            "info": true,
            "autoWidth": false,
        });

        // Excel Export Button Click Handler
        $('#btnExcel').on('click', function() {
            // Gather the data from the DataTable
            var data = table.rows().data();

            // Prepare the data for export (without the Action column)
            var exportData = [];
            data.each(function(row, index) {
                var statusText = $(row[4]).text(); // Get plain text for 'Status' column

                exportData.push([
                    row[0], // ID
                    row[1], // Name
                    row[2], // Short Code
                    row[3], // Order No
                    statusText // Status text without HTML tags
                ]);
            });

            // Add column headers
            var headers = ['ID', 'Name', 'Short Code', 'Order No', 'Status'];

            // Create a new workbook
            var wb = XLSX.utils.book_new();

            // Create worksheet from the data
            var ws = XLSX.utils.aoa_to_sheet([headers].concat(exportData));

            // Apply styles to the header row (bold, background color)
            var headerStyle = {
                font: { bold: true, color: { rgb: "FFFFFF" } },
                fill: { fgColor: { rgb: "4CAF50" } }, // Green background color
                alignment: { horizontal: "center" }
            };

            // Apply style to header cells (row 0)
            for (var col = 0; col < headers.length; col++) {
                var cellAddress = { r: 0, c: col }; // Address of header cell
                var cellRef = XLSX.utils.encode_cell(cellAddress);
                if (!ws[cellRef]) ws[cellRef] = {}; // Create empty cell if not exists
                ws[cellRef].s = headerStyle; // Apply style
            }

            // Add the worksheet to the workbook
            XLSX.utils.book_append_sheet(wb, ws, 'Programs');

            // Define the filename with the current date
            var filename = 'programs-' + new Date().toLocaleDateString('en-GB').replace(/\//g, '-') + '.xlsx';

            // Trigger the download
            XLSX.writeFile(wb, filename);
        });
    });
</script>

    <script type="text/javascript">
        $(document).ready(function() {
            setPageUrl('/programs?');
        });
    </script>
@endsection
