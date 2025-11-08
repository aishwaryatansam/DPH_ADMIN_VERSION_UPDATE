@extends('admin.layouts.layout')
@section('title', 'List Schemes')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Scheme</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List Scheme</li>
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
                                        <h4 class="card-title mb-4 text-primary">All Scheme</h4>
                                        <!-- Button to add employees if needed -->
                                        <button class="btn btn-primary btn-round ms-auto"
                                            onclick="window.location.href='{{ route('schemes.create') }}';">
                                            <i class="fa fa-plus"></i> Add Scheme
                                        </button>

                                         <!-- Download Button -->
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
                                               <form method="GET" action="{{ url('/schemes') }}" class="mb-3">
    <input type="hidden" name="schemes" value="{{ request('schemes') }}">
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
                                                    <th>order No</th>
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
                                                                    onclick="window.location.href='{{ route('schemes.edit', $result->id) }}'"
                                                                    data-bs-toggle="tooltip" title="Edit scheme">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <!-- Additional rows as needed -->
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
        // Ensure the table is initialized when the document is ready
        $(document).ready(function() {
            var tableData = @json($results);
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
                    "autoWidth": false
                });
            }

            // Handle the download button click event
            $('#downloadBtn').on('click', function() {
                // Prepare data to be exported
                var exportData = [];
                tableData.forEach(function(row) {
                    exportData.push([row.id, row.program.name, row.name, row.short_code, row.order_no, (row.status == 1 ? 'Active' : 'In-Active')]);
                });

                // Define the headers
                var headers = ['ID', 'Program', 'Name', 'Short Code', 'Order No', 'Status'];

                // Create a new worksheet
                var ws = XLSX.utils.aoa_to_sheet([headers].concat(exportData));

                // Create a new workbook
                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Schemes');

                // Set the filename
                var filename = 'schemes-list-' + new Date().toLocaleDateString('en-GB').replace(/\//g, '-') + '.xlsx';

                // Trigger the download
                XLSX.writeFile(wb, filename);
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            setPageUrl('/facilitytypes?');
        });
    </script>
@endsection
