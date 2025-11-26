@extends('admin.layouts.layout')
@section('title', 'List Hsc')
@section('content')
<div class="container" style="margin-top: 90px;">
    <div class="container-fluid p-2" style="background-color: #f2f2f2;">
        <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
            <h5 class="mb-0">Health Sub Center</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                    <li class="breadcrumb-item"><a href="#">HSC</a></li>
                    <li class="breadcrumb-item active" aria-current="page">List</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-fluid">
        <div class="page-inner">
            <!-- Filter Card -->
            <div class="card mb-0 mt-2">
                <div class="card-body">
                  <form id="filterForm" method="GET" action="{{ route('hsc.index') }}">
                        <div class="row">
                            <!-- Block Filter -->
                            <div class="col col-md-4">
                                <div class="form-group">
                                    <label>Block</label>
 <select name="block_id" id="block_id" class="form-control searchable"
            data-selected="{{ request('block_id') }}">
        <option value="">-- Select Block --</option>
        @foreach ($huds as $hud)
            <optgroup label="{{ $hud->name }}">
                @foreach ($hud->blocks as $block)
                    <option value="{{ $block->id }}" {{ $block->id == request('block_id') ? 'selected' : '' }}>
                        {{ $block->name }}
                    </option>
                @endforeach
            </optgroup>
        @endforeach
    </select>              </div>
                            </div>

                            <!-- PHC Filter -->
                            <div class="col col-md-4">
                                <div class="form-group">
                                    <label>PHC</label>
         <select name="phc_id" id="phc_id" class="form-control searchable"
            data-selected="{{ request('phc_id') }}">
        <option value="">-- Select PHC --</option>
        @foreach ($phcs as $phc)
            <option value="{{ $phc->id }}" {{ $phc->id == request('phc_id') ? 'selected' : '' }}>
                {{ $phc->name }}
            </option>
        @endforeach
    </select>
                </div>
                            </div>

                            <!-- Reset Button -->
                            <div class="col d-flex justify-content-end align-items-center mt-2">
                                <div class="form-group d-flex">
                                    <button type="button" onClick="resetSearch()" class="btn btn-secondary resetSearch" style="border-radius: 10px;">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- DataTable -->
            <div class="container-fluid mt-2">
                <div class="col-md-12 col-lg-12 mt-lg-5 mt-md-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title mb-4 text-primary">All HSC</h4>
                                <button class="btn btn-primary btn-round ms-auto" onclick="window.location.href='{{route('hsc.create')}}';">
                                    <i class="fa fa-plus"></i> Add HSC
                                </button>
                                <a href="{{ route('hsc.export', request()->all()) }}" class="btn btn-success ms-2">Download Excel</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ url('/hsc') }}" class="mb-3"> 
                                <input type="hidden" name="hsc" value="{{ request('hsc') }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <span class="me-1">Show</span>
                                        <select name="pageLength" id="pageLength" class="form-select form-select-sm me-1" style="width:70px" onchange="this.form.submit()">
                                            @foreach(getPageLenthArr() as $pageLength)
                                                <option value="{{ $pageLength }}" {{ request('pageLength', 10) == $pageLength ? 'selected' : '' }}>
                                                    {{ $pageLength }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span>entries</span>
                                    </div>
                                    <input type="search" name="search" id="search" value="{{ request('search') }}" placeholder="Search..." class="form-control form-control-sm" style="width: 180px;" oninput="this.form.submit()">
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>PHC</th>
                                            <th>Status</th>
                                            <th class="text-center" style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($results->isEmpty())
                                        <tr>
                                            <td colspan="8" class="text-center">No HSC available.</td>
                                        </tr>
                                        @else
                                        @foreach ($results as $result)
                                            <tr>
                                                <td>{{ $result->name ?? '' }}</td>
                                                <td>{{ $result->phc->name ?? '' }}</td>
                                                <td style="font-weight: bold;">
                                                    @if (isset($result->status) && $result->status == 1)
                                                        <span class="text-success">Active</span>
                                                    @else
                                                        <span class="text-danger">In-Active</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-button-action">
                                                        <button type="button" class="btn btn-link btn-primary btn-lg" onclick="window.location.href='{{ route('hsc.edit', $result->id) }}'" data-bs-toggle="tooltip" title="Edit HSC">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-link btn-danger" onclick="window.location.href='{{ route('hsc.show', $result->id) }}'" data-bs-toggle="tooltip" title="View HSC">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                @if(method_exists($results, 'links'))
                                    <div class="mt-3">
                                        {{ $results->appends(request()->query())->links('pagination::bootstrap-4') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Dynamic PHC Script -->
<!-- Dynamic PHC Script -->
<script>
    const filterForm = document.getElementById('filterForm');

document.getElementById('block_id').addEventListener('change', function () {
    // When block changes → reset PHC to empty (to avoid wrong filters)
    document.getElementById('phc_id').value = "";
    filterForm.submit();
});

document.getElementById('phc_id').addEventListener('change', function () {
    filterForm.submit();
});

document.getElementById('block_id').addEventListener('change', function() {
    const blockId = this.value;
    const phcSelect = document.getElementById('phc_id');
    phcSelect.innerHTML = '<option value="">Loading...</option>';

    if (blockId) {
        fetch(`/hsc/get-phc/${blockId}`)
            .then(res => res.json())
            .then(data => {
                phcSelect.innerHTML = '<option value="">-- Select PHC --</option>';
                data.forEach(phc => {
                    phcSelect.innerHTML += `
                        <option value="${phc.id}">${phc.name}</option>
                    `;
                });

                // Auto-submit after PHCs are loaded
                document.getElementById('filterForm').submit();
            });
    } else {
        phcSelect.innerHTML = '<option value="">-- Select PHC --</option>';
        filterForm.submit();
    }
});

</script>


@endsection
