@extends('admin.layouts.layout')
@section('title', 'List Blocks')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(function() {
    $('.searchable').select2({
        width: '100%',
        placeholder: "-- Select HUD --",
        allowClear: true
    });
});

function resetSearch() {
    window.location.href = "{{ url()->current() }}";
}
</script>


<div class="container" style="margin-top: 90px;">
    <div class="container-fluid p-2" style="background-color: #f2f2f2;">
        <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
            <h5 class="mb-0">Block</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                    <li class="breadcrumb-item"><a href="#">Block</a></li>
                    <li class="breadcrumb-item active" aria-current="page">List</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-fluid">
        <div class="page-inner">
            <div class="card mb-0 mt-2">
                <div class="card-body">
                    <form>
                        <div class="row">
                      <form method="GET" action="{{ url()->current() }}">
    <div class="col col-md-4">
        <div class="form-group">
            <label>HUD</label>
            <select name="hud_id" class="form-control searchable" onchange="this.form.submit()">
                <option value="">-- Select HUD --</option>
                @foreach ($huds as $hud)
                    <option value="{{ $hud->id }}" {{ SELECT($hud->id, request('hud_id')) }}>
                        {{ $hud->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</form>


                            <div class="col d-flex justify-content-end align-items-center mt-2">
                                <div class="form-group d-flex">
                                  <button type="button"
        onclick="window.location='{{ url()->current() }}'"
        class="btn btn-secondary"
        style="border-radius: 10px;">
    <i class="fas fa-redo"></i> Reset
</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div>
                <div class="container-fluid mt-2">
                    <div class="col-md-12 col-lg-12 mt-lg-5 mt-md-3">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title mb-4 text-primary">All Block</h4>
                                    <button class="btn btn-primary btn-round ms-auto" onclick="window.location.href='{{ route('blocks.create') }}';">
                                        <i class="fa fa-plus"></i> Add Block
                                    </button>
                                    <a href="{{ route('blocks.export') }}" class="btn btn-secondary btn-round ms-2">
    <i class="fa fa-download"></i> Download
</a>

                                </div>
                            </div>
<div class="card-body">
<form method="GET" action="{{ url('/blocks') }}" class="mb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <label for="pageLength" class="me-2 mb-0">Show</label>
            <select name="pageLength" id="pageLength" class="form-select w-auto" onchange="this.form.submit()">
                @foreach(getPageLenthArr() as $pageLength)
                    <option value="{{ $pageLength }}" {{ request('pageLength', 10) == $pageLength ? 'selected' : '' }}>
                        {{ $pageLength }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto ms-auto">
            <label for="keyword">Search:</label>
            <input type="search" name="keyword" id="keyword" value="{{ request('keyword') }}">
            <button type="submit">Go</button>
        </div>
    </div>
</form>


                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                 {{-- <th>Tags</th> --}}
                                                <th>HUD</th>
                                                <th>Status</th>
                                                <th class="text-center" style="width: 10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($results as $result)
                                                <tr>
                                                    <td>{{ $result->name ?? '' }}</td>
                                                     {{-- <td>{{ $result->tag_names }}</td> --}}
                                                    <td>{{ $result->hud->name ?? '' }}</td>
                                                    <td style="font-weight: bold;">
                                                        @if ($result->status == 1)
                                                            <span class="text-success">Active</span>
                                                        @else
                                                            <span class="text-danger">In-Active</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-button-action">
                                                            <button type="button" class="btn btn-link btn-primary btn-lg"
                                                                onclick="window.location.href='{{ route('blocks.edit', $result->id) }}'"
                                                                data-bs-toggle="tooltip" title="Edit Block">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-link btn-danger"
                                                                onclick="window.location.href='{{ route('blocks.show', $result->id) }}'"
                                                                data-bs-toggle="tooltip" title="View Block">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Laravel pagination fallback --}}
                                <div class="mt-3">
       {{ $results->links('pagination::bootstrap-5') }}

    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Libraries --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
$(document).ready(function () {
    var tableData = @json($results);

    // 🟢 Fix: Ensure DataTable works only if plugin is loaded
    if ($.fn.DataTable) {
        $('#add-row').DataTable({
            paging: true,
            searching: true,
            lengthChange: true,
            pageLength: 10,
            info: true,
            autoWidth: false,
            language: {
                searchPlaceholder: "Search Block..."
            }
        });
    }

    // Download logic
    $('#downloadBtn').on('click', function () {
        var exportData = [];
        tableData.forEach(function (row) {
            exportData.push([
                row.name ?? '',
                row.hud ? row.hud.name : '',
                row.status == 1 ? 'Active' : 'In-Active'
            ]);
        });
        var headers = ['Block Name', 'HUD', 'Status'];
        var ws = XLSX.utils.aoa_to_sheet([headers].concat(exportData));
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Blocks');
        var filename = 'blocks-list-' + new Date().toLocaleDateString('en-GB').replace(/\//g, '-') + '.xlsx';
        XLSX.writeFile(wb, filename);
    });
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    if (typeof setPageUrl === "function") {
        setPageUrl('/blocks?');
    }
});
</script>
@endsection
