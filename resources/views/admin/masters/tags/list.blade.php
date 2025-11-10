@extends('admin.layouts.layout')
@section('title', 'List Blocks')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Tags</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Tags</a></li>
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
                                        
                                        <h4 class="card-title mb-4 text-primary">All tags</h4>
                                        <!-- Button to add employees if needed -->
                                        
                                        <button class="btn btn-primary btn-round ms-auto"
                                            onclick="window.location.href='{{route('tags.create')}}';">
                                            <i class="fa fa-plus"></i> Add Tags
                                        </button>
                                        <button class="btn btn-secondary btn-round ms-2" id="downloadBtn">
                                            <i class="fa fa-download"></i> Download
                                        </button>

                                    </div>
                                </div>

                                <!-- Table Card -->
             <div class="card-body">
<form method="GET" action="{{ url('/tags') }}" class="mb-3">
    <input type="hidden" name="tags" value="{{ request('tags') }}">
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

                           

    <div class="table-responsive">
        <table class="table table-striped table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
  
                @forelse ($results as $tag)
                    <tr>
                        <td>{{ $tag->id }}</td>
                        <td>{{ $tag->name }}</td>
                        <td>{{ $tag->status ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <div class="form-button-action">
                                <button type="button"
                                    class="btn btn-link btn-primary btn-lg"
                                    onclick="window.location.href='{{ route('tags.edit', $tag->id) }}'"
                                    title="Edit Tags">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-link btn-danger"
                                    onclick="window.location.href='{{ route('tags.show', $tag->id) }}'"
                                    title="View Tags">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">No tags found</td></tr>
                @endforelse
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

   <!-- Include Libraries -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script>
    $(document).ready(function () {
        var tableData = @json($results);

        // Initialize DataTable
      

        // Handle the download button click
        $('#downloadBtn').on('click', function () {
            // Prepare data for export
            var exportData = [];
            tableData.forEach(function (row) {
                exportData.push([
                    row.name ?? '', // Block Name
                     // HUD Name
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
            setPageUrl('/tags?');
        });
    </script>
@endsection
