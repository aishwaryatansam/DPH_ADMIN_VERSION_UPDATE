@extends('admin.layouts.layout')
@section('title', 'List Users')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Users</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">User's</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Users</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="container-fluid">
            <div class="page-inner">
                <!-- insert the contents Here start -->


                <!-- Filter Card -->
                <div>
                    {{-- <div class="card mb-0 mt-2">
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>User Name</label>
                                            <input type="text" class="form-control" placeholder="Enter user name">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>User Type</label>
                                            <select class="form-control">
                                                <option>Admin</option>
                                                <option>Editor</option>
                                                <option>Viewer</option>
                                                <option>Contributor</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Designation</label>
                                            <input type="text" class="form-control" placeholder="Enter designation">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control">
                                                <option>Active</option>
                                                <option>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-end align-items-center mt-2">
                                        <div class="form-group d-flex">
                                            <button type="button" class="btn btn-primary me-2"
                                                style="border-radius: 10px;">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <button type="reset" class="btn btn-secondary" style="border-radius: 10px;" >
                                                <i class="fas fa-redo"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> --}}

                    <!-- DataTable Start -->
                    <div class="container-fluid mt-2">
                        <div class="col-md-12 col-lg-12 mt-lg-5 mt-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Users</h4>
                                        @if ((isApprover() || isVerifier()) && (isState() || isHUD() || isBlock()) || isAdmin())
                                            <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="tooltip"
                                                title="Add"
                                                onclick="window.location.href='{{ route('users.create') }}';">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        @endif
                                        {{-- <button class="btn btn-secondary btn-round ms-2" data-bs-toggle="tooltip"
                                            id="download-excel" title="Download">
                                            <i class="fa fa-download"></i>
                                        </button> --}}
                                    </div>
                                </div>

                                <!-- Table Card -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="add-row" class="display table table-striped table-hover"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Username</th>
                                                    <th>Name</th>
                                                    <th>User Type</th>
                                                    <th>User Role</th>
                                                    <th>Designation</th>
                                                    <th>Status</th>
                                                    <th class="text-center" style="width: 15%">Action</th>
                                                    <!-- Adjusted width for extra button -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($results as $result)
                                                    <tr>
                                                        <td><a href="#">{{ $result->username }}</a></td>
                                                        <td>{{ $result->name }}</td>
                                                        <td>{{ findUserType($result->user_type_id) }}</td>
                                                        <td>{{ findUserRole($result->user_role_id) }}</td>
                                                        <td>{{ $result->designations->name ?? '' }}</td>
                                                        <td style="font-weight: bold;">
                                                            @if (isset($result->status) && $result->status == 1)
                                                                <span class="text-success">Active</span>
                                                            @else
                                                                <span class="text-danger">In-Active</span>
                                                            @endif
                                                        </td>
                                                        <td class="d-flex justify-content-center align-items-center">
                                                            <div class="form-button-action">
                                                                @if (isAdmin() || isState() || isHUD() || isBlock())
                                                                <button type="button"
                                                                    class="btn btn-link btn-primary btn-lg"
                                                                    onclick="window.location.href='{{ route('users.edit', $result->id) }}';"
                                                                    data-bs-toggle="tooltip" title="Edit User">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                                @endif
                                                                <button type="button" class="btn btn-link btn-danger"
                                                                    onclick="window.location.href='{{ route('users.show', $result->id) }}';"
                                                                    data-bs-toggle="tooltip" title="View USer">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                                @if (isAdmin() || isState() || isHUD())
                                                                <button type="button" class="btn btn-link btn-warning"
                                                                    onclick="window.location.href='{{ url('manage-user-password/'.encryptData($result->id)) }}';"
                                                                    data-bs-toggle="tooltip" title="Update User Password">
                                                                    <i class="fa fa-lock"></i>
                                                                </button>
                                                                @endif
                                                                {{-- <button type="button"
                                                           class="btn btn-link btn-warning"
                                                           onclick="window.location.href='user_forgotpassword.html';"
                                                           data-bs-toggle="tooltip"
                                                           title="Update User Password">
                                                           <i class="fa fa-lock"></i>
                                                       </button> --}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <!-- Add more rows as needed -->
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="d-flex justify-content-center">
                                            {{ $results->links() }}
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
                    XLSX.utils.book_append_sheet(wb, ws, "User's");

                    // Create and download the Excel file
                    XLSX.writeFile(wb, "User's.xlsx");
                });
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            setPageUrl('/users?');
        });
    </script>
@endsection
