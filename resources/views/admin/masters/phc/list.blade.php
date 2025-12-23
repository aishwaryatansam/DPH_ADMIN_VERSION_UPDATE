@extends('admin.layouts.layout')
@section('title', 'List Phc')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Public Health District</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">PHC</a></li>
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
                      <form method="GET" action="{{ route('phc.index') }}">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
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
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <a href="{{ route('phc.index') }}" class="btn btn-secondary" style="border-radius: 10px;">
                <i class="fas fa-redo"></i>
            </a>
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
                                        <h4 class="card-title mb-4 text-primary">All PHC</h4>
                                        <!-- Button to add employees if needed -->
                                        <button class="btn btn-primary btn-round ms-auto"
                                            onclick="window.location.href='{{ route('phc.create') }}';">
                                            <i class="fa fa-plus"></i> Add PHC
                                        </button>

                                        <a href="{{ route('phc.export', ['block_id' => request('block_id')]) }}" class="btn btn-secondary btn-round ms-2">
    <i class="fa fa-download"></i> Download
</a>

                                    </div>
                                </div>
       <!-- Table Card -->
                                <div class="card-body">
                                     {{-- <form method="GET" action="{{ url('/phc') }}" class="mb-3"></form>
        <div class="col-md-4">
            <label>Search</label>
            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                   placeholder="Search by PHC or Block" onkeyup="if(event.key==='Enter') this.form.submit()">
        </div>

        <div class="col-md-2">
            <label>Show</label>
            <select name="pageLength" class="form-control" onchange="this.form.submit()">
                @foreach([10, 25, 50, 100] as $len)
                    <option value="{{ $len }}" {{ request('pageLength', 10) == $len ? 'selected' : '' }}>{{ $len }}</option>
                @endforeach
            </select>
        </div>
</div></div></form> --}}
<form method="GET" action="{{ url('/phc') }}" class="mb-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap">

        <!-- Left: Show entries -->
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <label class="me-2 mb-0">Show</label>

            <select name="pageLength"
                    class="form-select form-select-sm me-2"
                    style="width:80px"
                    onchange="this.form.submit()">
                @foreach(getPageLenthArr() as $pageLength)
                    <option value="{{ $pageLength }}"
                        {{ request('pageLength', 10) == $pageLength ? 'selected' : '' }}>
                        {{ $pageLength }}
                    </option>
                @endforeach
            </select>

            <span>entries</span>
        </div>

        <!-- Right: Search -->
       <input type="search" name="search" id="search" value="{{ request('search') }}" placeholder="Search..." class="form-control form-control-sm" style="width: 180px;" oninput="this.form.submit()">
                    

    </div>
</form>
                           <div class="table-responsive">
                                        <table id="add-row" class="display table table-striped table-hover"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                     {{-- <th>Tags</th> --}}
                                                    <th>Block</th> <!-- New Block Column -->
                                                    <th>Status</th>
                                                    <th class="text-center" style="width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($results as $result)
                                                    <tr>
                                                        <td>{{ $result->name ?? '' }}</td>
                                                         {{-- <td>{{ $result->tag_names }}</td> --}}
                                                        <td>{{ $result->block->name ?? '' }}</td>
                                                        <td>
                                                            @if (isset($result->status) && $result->status == 1)
                                                                <span class="text-success"
                                                                    style="font-weight: bold;">Active</span>
                                                            @else
                                                                <span class="text-danger"
                                                                    style="font-weight: bold;">In-Active</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="form-button-action">
                                                                <button type="button"
                                                                    class="btn btn-link btn-primary btn-lg"
                                                                    onclick="window.location.href='{{route('phc.edit',$result->id)}}'"
                                                                    data-bs-toggle="tooltip" title="Edit PHC">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-link btn-danger"
                                                                    onclick="window.location.href='{{route('phc.show',$result->id)}}'"
                                                                    data-bs-toggle="tooltip" title="View PHC">
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
                         <div class="d-flex justify-content-between align-items-center mt-3">
    <div>
        Showing {{ $results->firstItem() ?? 0 }} to {{ $results->lastItem() ?? 0 }} of {{ $results->total() }} entries
    </div>
    <div>
        @if ($results->lastPage() > 1)
            {{ $results->links('pagination::bootstrap-4') }}
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
        // if (tableData.length > 0) {
        //     $('#add-row').DataTable({
        //         "paging": true,
        //         "searching": true,
        //         "lengthChange": true,
        //         "pageLength": 10,
        //         "info": true,
        //         "autoWidth": false,
        //     });
        // } else {
        //     $('#add-row').DataTable({
        //         "data": [],
        //         "paging": true,
        //         "searching": true,
        //         "lengthChange": true,
        //         "pageLength": 10,
        //         "info": true,
        //         "autoWidth": false,
        //     });
        // }

        // Handle the download button click
    
            // Define the headers
     
    });
</script>
    <script type="text/javascript">
        $(document).ready(function() {
            setPageUrl('/phc?');
        });
    </script>
@endsection
