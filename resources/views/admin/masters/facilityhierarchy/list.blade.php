@extends('admin.layouts.layout')
@section('title', 'List Facility Type')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Facility Masters</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Facility Masters</li>
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
                                <!-- Facility Level Field -->
                                
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Facility Level</label>
                                        <select class="form-control searchable" name="facility_level_id" onchange="searchFun()">
                                            <option value="">-- Select Level -- </option>
                                            @foreach ($facility_levels as $facility_level)
                                                <option value="{{ $facility_level->id }}" {{ SELECT($facility_level->id, request('facility_level_id')) }}>{{ $facility_level->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- HUD ID Field -->
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>HUD</label>
                                        <select name="hud_id" class="form-control searchable" onchange="searchFun()">
                                            <option value="">-- Select HUD -- </option>
                                            @foreach($huds as $hud)
                                                <option value="{{$hud->id}}" {{SELECT($hud->id,request('hud_id'))}}>{{$hud->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Block ID Field -->
                                @if(!empty($blocks))
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Block</label>
                                            <select name="block_id" class="form-control searchable" onchange="searchFun()">
                                                <option value="">-- Select Block -- </option>
                                                @foreach($blocks as $block)
                                                    <option value="{{$block->id}}" {{SELECT($block->id,request('block_id'))}}>{{$block->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                @if(!empty($phcs))
                                    <!-- PHC ID Field -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>PHC</label>
                                            <select name="phc_id" class="form-control searchable" onchange="searchFun()">
                                                <option value="">-- Select PHC -- </option>
                                                @foreach($phcs as $phc)
                                                    <option value="{{$phc->id}}" {{SELECT($phc->id,request('phc_id'))}}>{{$phc->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                @if(!empty($hscs))
                                    <!-- HSC ID Field -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>HSC</label>
                                            <select name="hsc_id" class="form-control searchable" onchange="searchFun()">
                                                <option value="">-- Select HSC -- </option>
                                                @foreach($hscs as $hsc)
                                                    <option value="{{$hsc->id}}" {{SELECT($hsc->id,request('hsc_id'))}}>{{$hsc->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="col d-flex justify-content-end align-items-center mt-2">
                                    <div class="form-group d-flex">
                                        <button type="button" class="btn btn-primary btn-sm me-2" style="border-radius: 10px;">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <button type="reset" class="btn btn-secondary btn-sm resetSearch" style="border-radius: 10px;" onClick="resetSearch()">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- insert the contents Here end -->
                </div>
            </div>
            <div class="container-fluid mt-2">
                <div class="col-md-12 col-lg-12 mt-lg-5 mt-md-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">All Facilities</h4>
                                <button class="btn btn-primary btn-round ms-auto" onclick="window.location.href='{{route('facility_hierarchy.create')}}';">
                                    <i class="fa fa-plus"></i> Add Facility Master
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
                                <table id="add-row" class="display table table-striped table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Level</th>
                                            <th>Latitude</th>
                                              <th>Longitude</th>
                                            <th>District</th>
                                            <th>HUD</th>
                                            <th>Block</th>
                                            <th>PHC</th>
                                            <th>HSC</th>
                                            <th class="text-center" style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($results->isEmpty())
                                            <tr>
                                                <td colspan="8" class="text-center">No Facility available.</td>
                                            </tr>
                                        @else
                                            @foreach ($results as $result)
                                                <tr>
                                                    <td>{{ $result->id ?? '' }}</td>
                                                    <td><a href="#">{{ $result->facility_name ?? '' }}</a></td>
                                                    <td>{{ $result->facility_code ?? '--' }}</td>
                                                    <td>{{ $result->facility_level->name ?? '--' }}</td>
                                                        <td>{{ $result->latitude ?? '--' }}</td>
                                                        <td>{{ $result->latitude ?? '--' }}</td>
                                                    <td>{{ $result->district->name ?? '--' }}</td>
                                                    <td>{{ $result->hud->name ?? '--' }}</td>
                                                    <td>{{ $result->block->name ?? '--' }}</td>
                                                    <td>{{ $result->phc->name ?? '--' }}</td>
                                                    <td>{{ $result->hsc->name ?? '--' }}</td>
                                                    <td>
                                                        <div class="form-button-action">
                                                            <button type="button" class="btn btn-link btn-primary btn-lg" onclick="window.location.href='{{ route('facility_hierarchy.edit', $result->id) }}'" data-bs-toggle="tooltip" title="Edit Facility">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-link btn-danger" onclick="window.location.href='{{ route('facility_hierarchy.show', $result->id) }}';" data-bs-toggle="tooltip" title="View Facility">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        <!-- More rows as needed -->
                                    </tbody>
                                </table>

                                <!-- Pagination Links -->
                                @include('admin.common.table-footer')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content end here -->
        <!-- main panel end -->
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script>
        $(document).ready(function() {
            // Download Button Event
            $('#downloadBtn').on('click', function() {
                var exportData = [];
                @foreach($results as $result)
                    exportData.push([
                        '{{ $result->facility_name ?? "" }}',
                        '{{ $result->facility_code ?? "--" }}',
                        '{{ $result->facility_level->name ?? "--" }}',
                        '{{ $result->district->name ?? "--" }}',
                        '{{ $result->hud->name ?? "--" }}',
                        '{{ $result->block->name ?? "--" }}',
                        '{{ $result->phc->name ?? "--" }}',
                        '{{ $result->hsc->name ?? "--" }}'
                    ]);
                @endforeach

                var headers = ['Name', 'Code', 'Level', 'District', 'HUD', 'Block', 'PHC', 'HSC'];
                var ws = XLSX.utils.aoa_to_sheet([headers].concat(exportData));
                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Facilities');
                var filename = 'facilities-list-' + new Date().toLocaleDateString('en-GB').replace(/\//g, '-') + '.xlsx';
                XLSX.writeFile(wb, filename);
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            setPageUrl('/facility_hierarchy?');
        });
    </script> 
@endsection
