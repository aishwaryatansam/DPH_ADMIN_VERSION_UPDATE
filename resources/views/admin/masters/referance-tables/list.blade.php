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
                        <li class="breadcrumb-item active" aria-current="page">Master</li>
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
                                        <h4 class="card-title">Master</h4>
                                        <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="tooltip"
                                            title="Add" onclick="window.location.href='{{ route('masters.create') }}{{ request('master_type') ? '?master_type=' . request('master_type') : '' }}';">
                                            <i class="fa fa-plus"></i>
                                        </button>

                                        <button class="btn btn-secondary btn-round ms-2" data-bs-toggle="tooltip" title="Download" id="btnExcel" data-master-type="{{ request('master_type') }}">
    <i class="fa fa-download"></i> Export
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
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center" style="width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($results as $index => $result)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $result->name ?? '' }}</td>
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
                                                                    onclick="window.location.href='{{ route('masters.edit', $result->id) }}'"
                                                                    data-bs-toggle="tooltip" title="Edit">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <!-- More rows as needed -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- DataTable End -->

                </div>
            </div>
        </div>
        <!-- content end here -->
        <!-- main panel end -->
    </div>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons plugin -->
<script src="https://cdn.datatables.net/buttons/2.3.3/js/dataTables.buttons.min.js"></script>

<!-- JSZip (for Excel export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<!-- pdfmake (for PDF export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<!-- xlsx (for Excel export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>

<script>
$(document).ready(function() {
    // Triggering Excel download on button click
    $('#btnExcel').on('click', function() {
        var masterType = $(this).data('master-type'); // Get the master_type from the button's data attribute

        if (masterType) {
            // Trigger the download by calling a function to fetch table data
            exportToExcel(masterType);
        } else {
            alert('Master Type is not specified');
        }
    });
});

function exportToExcel(masterType) {
    var table = $('#add-row').DataTable(); // Get the DataTable instance using the table ID

    // Get all table data with applied filters
    var data = table.rows({ search: 'applied' }).data();

    // Prepare data for export
    var exportData = [];
    data.each(function(row) {
        // Strip HTML from the "Status" column (third column)
        var status = row[2].replace(/<[^>]*>/g, ''); // Regex to remove HTML tags

        // Push the cleaned data into the exportData array
        exportData.push([row[0], row[1], status]); // [ID, Name, Status]
    });

    // Check if exportData is populated
    if (exportData.length === 0) {
        alert('No data available for export');
        return;
    }

    // Add headers
    var headers = ['Id', 'Name', 'Status'];

    // Create a new workbook
    var wb = XLSX.utils.book_new();
    var ws = XLSX.utils.aoa_to_sheet([headers].concat(exportData));

    // Check if the worksheet has been created correctly
    console.log('Generated Worksheet:', ws);

    // Apply style to the header row
    var headerStyle = {
        font: { bold: true, color: { rgb: "FFFFFF" } },
        fill: { fgColor: { rgb: "4CAF50" } },
        alignment: { horizontal: "center" }
    };

    // Apply style to header cells
    for (var col = 0; col < headers.length; col++) {
        var cellAddress = { r: 0, c: col };
        var cellRef = XLSX.utils.encode_cell(cellAddress);
        if (!ws[cellRef]) ws[cellRef] = {};
        ws[cellRef].s = headerStyle;
    }

    // Append the worksheet to the workbook
    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');  // Add this line

    // Log the final workbook before writing
    console.log('Workbook before write:', wb);

    // File name
    var filename = 'masters-' + masterType + '-' + new Date().toLocaleDateString('en-GB').replace(/\//g, '-') + '.xlsx';

    // Trigger the file download
    try {
        XLSX.writeFile(wb, filename);
    } catch (error) {
        console.error('Error exporting to Excel:', error);
        alert('An error occurred while exporting the data. Please try again.');
    }
}


</script>
    <script type="text/javascript">
        $(document).ready(function() {
            setPageUrl('/masters?');
        });
    </script>
@endsection
