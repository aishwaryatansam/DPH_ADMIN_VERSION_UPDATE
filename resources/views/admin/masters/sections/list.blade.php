@extends('admin.layouts.layout')
@section('title', 'List Section')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Section</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Section</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List Section</li>
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
                                        
                                        <h4 class="card-title mb-4 text-primary">All Section</h4>
                                        <!-- Button to add sections -->
                                        <button class="btn btn-primary btn-round ms-auto"
                                            onclick="window.location.href='{{ route('sections.create') }}';">
                                            <i class="fa fa-plus"></i> Add section
                                        </button>

                                         <!-- Button to export sections -->
                                      <a href="{{ route('sections.export') }}" class="btn btn-success">Export Sections</a>

                                    </div>
                                </div>

                                <!-- Table Card -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="add-row" class="display table table-striped table-hover"
                                            style="width:100%">
                                            <form method="GET" action="{{ url('/sections') }}" class="mb-3">
    <input type="hidden" name="sections" value="{{ request('sections') }}">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <span class="me-1">Show</span>
            <select name="pageLength" id="pageLength"
                    class="form-select form-select-sm me-1"
                    style="width:70px"
                    onchange="this.form.submit()">
                @foreach(getPageLenthArr() as $pageLength)
                    <option value="{{ $pageLength }}" {{ request('pageLength', 10) == $pageLength ? 'selected' : '' }}>
                        {{ $pageLength }}
                    </option>
                @endforeach
            </select>
            <span>entries</span>
        </div>
        <input type="search" name="search" id="search"
               value="{{ request('search') }}"
               placeholder="Search..."
               class="form-control form-control-sm"
               style="width: 180px;"
               oninput="this.form.submit()">
    </div>
</form>
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Program</th>
                                                    <th>Name</th>
                                                    <th>Short Code</th>
                                                    <th>Status</th>
                                                    <th class="text-center" style="width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($results as $result)
                                                    <tr>
                                                        <td>{{ $result->id ?? '' }}</td>
                                                        <td>{{ $result->program->name ?? '' }}</td>
                                                        <td>{{ $result->name ?? '' }}</td>
                                                        <td>{{ $result->short_code ?? '' }}</td>
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
                                                                    onclick="window.location.href='{{ route('sections.edit', $result->id) }}'"
                                                                    data-bs-toggle="tooltip" title="Edit section">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                                                                <div>
        @if ($results->lastPage() > 1)
            {{ $results->links('pagination::bootstrap-5') }}
        @else
            <!-- Always show pagination bar even for 1 page -->
            <nav>
                <ul class="pagination">
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    <li class="page-item active"><span class="page-link">1</span></li>
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                </ul>
            </nav>
        @endif
    </div>
</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- DataTable End -->
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.datatables.net/buttons/2.3.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>

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
                    text: 'Export to Excel',
                    init: function(api, node, config) {
                        $(node).hide();  // Hide the button initially, if you want to show it later manually
                    }
                }
            ]
        });

        // Trigger the Excel export when clicking the "Export Sections" button
        $('#btnExcel').on('click', function () {
            var data = table.rows().data();  // Get all the table data

            // Prepare the data for export (exclude Action column)
            var exportData = [];
            data.each(function(row, index) {
                var statusText = $(row[4]).text(); // Extract the plain text from the 'Status' column
                
                exportData.push([
                    row[0], // ID
                    row[1], // Program
                    row[2], // Name
                    row[3], // Short Code
                    statusText  // Status (text without HTML tags)
                ]);
            });

            // Prepare the headers for the Excel file
            var headers = ['ID', 'Program', 'Name', 'Short Code', 'Status'];

            // Create a new workbook
            var wb = XLSX.utils.book_new();

            // Create the worksheet data
            var ws = XLSX.utils.aoa_to_sheet([headers].concat(exportData));

            // Apply styles to the header row (row 0)
            var headerStyle = {
                font: { bold: true, color: { rgb: "FFFFFF" } }, // Bold text and white color
                fill: { fgColor: { rgb: "4CAF50" } }, // Green background color
                alignment: { horizontal: "center" } // Center align the header text
            };

            // Apply style to each header cell (first row)
            for (var col = 0; col < headers.length; col++) {
                var cellAddress = { r: 0, c: col }; // The header cells are in row 0
                var cellRef = XLSX.utils.encode_cell(cellAddress);
                if (!ws[cellRef]) ws[cellRef] = {}; // If no cell exists at the address, create an empty cell
                ws[cellRef].s = headerStyle; // Apply style
            }

            // Add the worksheet to the workbook
            XLSX.utils.book_append_sheet(wb, ws, 'Sections');

            // Create a filename with the current date
            var filename = 'sections-' + new Date().toLocaleDateString('en-GB').replace(/\//g, '-') + '.xlsx';

            // Download the file
            XLSX.writeFile(wb, filename);
        });
    });
</script>

    <script type="text/javascript">
        $(document).ready(function(){
            setPageUrl('/sections?');
        });
    </script>


@endsection
