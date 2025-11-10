@extends('admin.layouts.layout')
@section('title', 'List Populars')
@section('content')
<div class="container" style="margin-top: 90px;">
    <div class="container-fluid p-2" style="background-color: #f2f2f2;">
        <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
            <h5 class="mb-0">Populars</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                    <li class="breadcrumb-item"><a href="#">Populars</a></li>
                    <li class="breadcrumb-item active" aria-current="page">List</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-fluid">
        <div class="page-inner">

       

            <div>
                <div class="container-fluid mt-2">
                    <div class="col-md-12 col-lg-12 mt-lg-5 mt-md-3">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title mb-4 text-primary">All Populars</h4>
                                    <button class="btn btn-primary btn-round ms-auto"
                                        onclick="window.location.href='{{ route('popular.create') }}';">
                                        <i class="fa fa-plus"></i> Add Popular
                                    </button>
                                    {{-- <button class="btn btn-secondary btn-round ms-2" id="downloadBtn">
                                        <i class="fa fa-download"></i> Download
                                    </button> --}}
                                </div>
                            </div>

                            <div class="card-body">
                                <form method="GET" action="{{ url('/popular') }}" class="mb-3">
                                    <input type="hidden" name="popular" value="{{ request('popular') }}">
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
            <th>Description</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($results as $popular)
            <tr>
                <td>{{ $popular->id }}</td>
                <td>{{ $popular->name }}</td>

                <!-- Description Column -->
                <td style="white-space: pre-wrap; max-width: 300px;">
                    {{ $popular->description }}
                </td>

                <!-- Image Column -->
                <td>
                    @if(!empty($popular->image) && file_exists(public_path($popular->image)))
                        <img src="{{ asset($popular->image) }}" alt="Popular Image"
                             width="60" height="60"
                             style="object-fit: cover; border-radius: 6px;">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>

                <!-- Tags -->
                <td>{{ $popular->tag_names }}</td>

                <!-- Status -->
                <td>{{ $popular->status ? 'Active' : 'Inactive' }}</td>

                <!-- Actions -->
                <td>
                    <div class="form-button-action">
                        <button type="button"
                            class="btn btn-link btn-primary btn-lg"
                            onclick="window.location.href='{{ route('popular.edit', $popular->id) }}'"
                            title="Edit Popular">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-link btn-danger"
                            onclick="window.location.href='{{ route('popular.show', $popular->id) }}'"
                            title="View Popular">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center">No populars found</td></tr>
        @endforelse
    </tbody>
</table>


                                    <div>
                                        @if ($results->lastPage() > 1)
                                            {{ $results->links('pagination::bootstrap-5') }}
                                        @else
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

                                <div class="mt-3">
                                    {{ $results->appends(request()->query())->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script>
                $(document).ready(function () {
                    var tableData = @json($results);

                    $('#downloadBtn').on('click', function () {
                        var exportData = [];
                        tableData.forEach(function (row) {
                            exportData.push([
                                row.name ?? '',
                                row.status == 1 ? 'Active' : 'Inactive'
                            ]);
                        });

                        var headers = ['Popular Name', 'Status'];
                        var ws = XLSX.utils.aoa_to_sheet([headers].concat(exportData));
                        var wb = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(wb, ws, 'Populars');

                        var filename = 'populars-list-' + new Date().toLocaleDateString('en-GB').replace(/\//g, '-') + '.xlsx';
                        XLSX.writeFile(wb, filename);
                    });
                });
            </script>

            <script type="text/javascript">
                $(document).ready(function() {
                    setPageUrl('/populars?');
                });
            </script>
        </div>
    </div>
</div>
@endsection
