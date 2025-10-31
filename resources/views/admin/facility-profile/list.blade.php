@extends('admin.layouts.layout')
@section('title', 'List Facility Profile')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Facility Profile</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Facility Profile</li>
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
                                        <h4 class="card-title">Facility Profile</h4>
                                        <!-- <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="tooltip"
                                            title="Add"
                                            onclick="window.location.href='{{ route('facility-profile.create') }}';">
                                            <i class="fa fa-plus"></i>
                                        </button> -->
                                        <button class="btn btn-secondary btn-round ms-auto" data-bs-toggle="tooltip"  id="download-excel"
                                            title="Download">
                                            <i class="fa fa-download"></i>
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
                                                    <th>Code</th>
                                                    <th>Level</th>
                                                    <th class="text-center" style="width: 10%">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($results['paginatedResult'] as $result)
                                                    <tr>

                                                        <td>{{ $result->facility_hierarchy_id ?? '' }}</td>
                                                        <td>{{ $result->facility_hierarchy->facility_name ?? '' }}</td>
                                                        <td>{{ $result->facility_hierarchy->facility_code ?? '' }}</td>
                                                        <td>{{ $result->facility_hierarchy->facility_level->name }}</td>
                                                        <td>
                                                            <div class="form-button-action">
                                                                <button type="button" data-bs-toggle="tooltip"
                                                                    title="Edit" class="btn btn-link btn-primary btn-lg"
                                                                    onclick="window.location.href='{{ route('facility-profile.edit', $result->id) }}';">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-link btn-danger"
                                                                    data-bs-toggle="tooltip" title="View"
                                                                    onclick="window.location.href='{{ route('facility-profile.show', $result->id) }}';">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <!-- Additional rows can be added here -->
                                            </tbody>
                                        </table>
                                        <!-- Pagination Links -->
                                        <div class="d-flex justify-content-center">
                                            {{ $results['paginatedResult']->links() }}
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
        document.addEventListener("DOMContentLoaded", () => {
    const downloadButton = document.querySelector("#download-excel");

    if (downloadButton) {
        downloadButton.addEventListener("click", () => {
            // Select the table element
            const table = document.querySelector("#add-row");

            if (!table) {
                alert("Table not found!");
                return;
            }

            // Convert the table into a worksheet
            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.table_to_sheet(table);

            // Append worksheet to the workbook
            XLSX.utils.book_append_sheet(wb, ws, "FacilityProfile");

            // Create and download the Excel file
            XLSX.writeFile(wb, "Facility_Profile.xlsx");
        });
    }
});

    </script>
@endsection
