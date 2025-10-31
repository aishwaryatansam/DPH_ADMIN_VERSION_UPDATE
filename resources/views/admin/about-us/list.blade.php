@extends('admin.layouts.layout')
@section('title', 'List Programs')
@section('content')
<div class="container" style="margin-top: 90px;">
    <div class="container-fluid p-2" style="background-color: #f2f2f2;">
        <div class="d-flex justify-content-between align-items-center"
            style="padding-left: 20px; padding-right: 20px;">
            <h5 class="mb-0">Documents</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">AboutUs</li>
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
                                  <h4 class="card-title">About Us</h4>
                                  <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="tooltip" title="Add" onclick="window.location.href='{{route('about-us.create')}}';">
                                      <i class="fa fa-plus"></i>
                                  </button>
                                  <!-- <button class="btn btn-secondary btn-round ms-2" data-bs-toggle="tooltip" title="Download">
                                      <i class="fa fa-download"></i>
                                  </button> -->
                              </div>
                          </div>

                          <!-- Table Card -->
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table id="add-row" class="display table table-striped table-hover" style="width:100%">
                                      <thead>
                                          <tr>
                                              <th>Content Type</th>
                                              <th>Title</th>
                                              <th>Status</th>
                                              {{-- <th>Visible to Public</th> --}}
                                              <th class="text-center" style="width: 10%">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($results as $result)
                                          <tr>
                                              <td>{{ $result->submenu->name }}</td>
                                              <td>{{ $result->name }}</td>
                                              <td class="text-{{$result->status == 1 ? 'success' : 'danger'}}" style="font-weight: bold;">{{ $result->status == 1 ? 'Active' : 'In - Active'  }}</td>
                                              {{-- <td class="text-{{$result->visible_to_public == 1 ? 'success' : 'danger'}}" style="font-weight: bold;">{{ $result->visible_to_public == 1 ? 'Yes' : 'No' }}</td> --}}
                                              <td>
                                                  <div class="form-button-action">
                                                      <button type="button" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit" onclick="window.location.href='{{ route('about-us.edit', $result->id) }}';">
                                                          <i class="fa fa-edit"></i>
                                                      </button>
                                                      <button type="button" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="View" onclick="window.location.href='{{ route('about-us.show', $result->id) }}';">
                                                          <i class="fa fa-eye"></i>
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
    <script>
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
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            setPageUrl('/programs?');
        });
    </script>
@endsection
