@extends('admin.layouts.layout')
@section('title', 'List Documents')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Documents</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Documents</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            @if (request('document_type'))
                                {{ $document_types->firstWhere('id', request('document_type'))->name ?? 'Documents' }}
                            @else
                                All Documents
                            @endif
                        </li>
                    </ol>
                </nav>

            </div>
        </div>
        <div class="container-fluid">
            <div class="page-inner">
                <!-- insert the contents Here start -->

                <!-- Filter Card -->
                <div>
                    <div class="card mb-0 mt-2">
                        <div class="card-body">
                            
                            <form>
                                <div class="row">
                                    @if (!request('document_type'))
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Type Of Document</label>
                                            <select name="document_type" class="form-control searchable"
                                                onchange="searchFun()">
                                                <option value="">-- Select -- </option>
                                                @foreach ($document_types as $document_type)
                                                    <option value="{{ $document_type->id }}"
                                                        {{ SELECT($document_type->id, request('document_type')) }}>
                                                        {{ $document_type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> 
                                    @endif
                                    
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Mapping Section</label>
                                            <select name="section" class="form-control searchable" onchange="searchFun()">
                                                <option value="">-- Select -- </option>
                                                @foreach ($sections as $section)
                                                    <option value="{{ $section->id }}"
                                                        {{ SELECT($section->id, request('section')) }}>{{ $section->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Dated (From)</label>
                                            <input type="date" class="form-control searchable"
                                                placeholder="Filter by Date" name="from" value="{{ request('from') }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Dated (To)</label>
                                            <input type="date" name="to" class="form-control searchable"
                                                placeholder="Filter by Date" value="{{ request('to') }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Visible to Public</label>
                                            <select name="visible_to_public" class="form-control searchable"
                                                onchange="searchFun()">
                                                <option value="">-- Select -- </option>
                                                <option value="yes" {{ SELECT('yes', request('visible_to_public')) }}>Yes
                                                </option>
                                                <option value="no" {{ SELECT('no', request('visible_to_public')) }}>No
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control searchable" onchange="searchFun()">
                                                <option value="">-- Select -- </option>
                                                @foreach ($statuses as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ SELECT($key, request('status')) }}>{{ $key }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-end align-items-center mt-2">
                                        <div class="form-group d-flex">
                                            <button type="button" class="btn btn-primary me-2" style="border-radius: 10px;"
                                                onClick="searchFun()">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <button type="reset" class="btn btn-secondary resetSearch"
                                                style="border-radius: 10px;" onClick="resetSearch()">
                                                <i class="fas fa-redo"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                    <!-- DataTable Start -->
                    <div class="container-fluid mt-2">
                        <div class="col-md-12 col-lg-12 mt-lg-5 mt-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        
                                        <h4 class="card-title">
                                            @if (request('document_type'))
                                                {{ $document_types->firstWhere('id', request('document_type'))->name ?? 'Documents' }}
                                            @else
                                                All Documents
                                            @endif
                                        </h4>
                                        @if (request('document_type'))
                                        <button class="btn btn-primary btn-round ms-auto"
                                            onclick="window.location.href='{{ url('/new-documents/create') }}{{ request('document_type') ? '?document_type=' . request('document_type') : '' }}'">
                                            <i class="fa fa-plus"></i>
                                            
                                                Add
                                                {{ $document_types->firstWhere('id', request('document_type'))->name ?? 'Document' }}
                                        </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Table Card -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="add-row" class="display table table-striped table-hover"
                                            style="width:100%">
                                                            <form method="GET" action="{{ url('/new-documents') }}" class="mb-3"> 
<form method="GET" action="{{ url('/new-documents') }}" class="mb-3">
    <input type="hidden" name="document_type" value="{{ request('document_type') }}">
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
                                                    <th>Type Of Document</th>
                                                    <th>Name Of Document</th>
                                                     <th>Tags</th>
                                                    <th>Dated</th>
                                                    <th>Approval Status</th>
                                                    <th>Public Status</th>
                                                    <th class="text-center" style="width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody> @if ($results->count())
                                                @foreach ($results as $result)
                                                    <tr>
                                                        <td>{{ $result->document_type->name ?? '--' }}</td>
                                                        <td><a
                                                                href="{{ fileLink($result->document_url) }}">{{ $result->name }}</a>
                                                        </td>
                                                              <td>{{ $result->tag_names }}</td>

                                                        <td>{{ $result->dated ?? '--' }}</td>
                                                        <td>
                                                            {!! getStageBadge($result->approvalWorkflow->current_stage ?? '') !!}
                                                        </td>
                                                        <td style="font-weight: bold;">
                                                            @if (isset($result->status) && $result->status == 1)
                                                                <span class="text-success">Active</span>
                                                            @else
                                                                <span class="text-danger">In-Active</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="form-button-action">
                                                                @if (
                                                                    ($user_detail->user_type_id == '7') || 
                                                                    ($result->approvalWorkflow && $result->approvalWorkflow->current_stage !== 'published' && $result->approvalWorkflow->uploaded_by !== $user_detail->id)
                                                                )   
                                                                    <button type="button" data-bs-toggle="tooltip"
                                                                        title="" class="btn btn-link btn-primary btn-lg"
                                                                        data-original-title="Edit Task"
                                                                        onclick="window.location.href='{{ route('new-documents.edit', $result->id) }}'">
                                                                        <i class="fa fa-edit"></i>
                                                                    </button>
                                                                @endif
                                                                <button type="button" class="btn btn-link btn-danger"
                                                                    onclick="window.location.href='{{route('new-documents.show',$result->id)}}'">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @else
        <tr>
            <td colspan="6" class="text-center text-muted">No matching records found</td>
        </tr>@endif
                                                <!-- More rows as needed -->
                                            </tbody>
                                        </table>
                                                                        <div class="mt-3">
       {{ $results->links('pagination::bootstrap-5') }}

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
    <!-- script for the search and show entries start -->
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
            setPageUrl('/new-documents?');
        });
    </script>
@endsection
