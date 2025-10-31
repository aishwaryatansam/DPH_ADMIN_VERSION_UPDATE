@extends('admin.layouts.layout')
@section('title', 'View Facility Details')
@section('content')
<div class="container" style="margin-top: 90px;">
    <div class="container-fluid p-2" style="background-color: #f2f2f2;">
        <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
            <h5 class="mb-0">Facility Masters</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Facility Masters</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container-fluid">
        <div class="page-inner">
            <!-- insert the contents Here start -->

            <div class="container mt-2">
                <div class="row">
                    <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                        <h4 class="card-title mb-4 text-primary">View Facility Details</h4>
                        <table class="table table-borderless">
                            <tbody>
                                <!-- Facility Type -->
                                <tr>
                                    <td>
                                        <label for="facilityType" class="form-label">Facility Type</label>
                                    </td>
                                    <td>
                                        <span>{{ $result->facility_type->name ?? '' }}</span>
                                    </td>
                                </tr>

                                <!-- Facility Name -->
                                <tr>
                                    <td>
                                        <label for="facilityName" class="form-label">Facility Name</label>
                                    </td>
                                    <td>
                                        <span>{{ $result->facility_name }}</span>
                                    </td>
                                </tr>

                                <!-- Facility Code -->
                                <tr>
                                    <td>
                                        <label for="facilityCode" class="form-label">Facility Code</label>
                                    </td>
                                    <td>
                                        <span>{{ $result->facility_code }}</span>
                                    </td>
                                </tr>

                                <!-- Facility Level -->
                                <tr>
                                    <td>
                                        <label for="facilityLevel" class="form-label">Facility Level</label>
                                    </td>
                                    <td>
                                        <span>{{ $result->facility_level->name }}</span>
                                    </td>
                                </tr>

                                <!-- District ID (if applicable) -->
                                @if ($result->facility_level->name == 'district' || 
                                     $result->facility_level->name == 'hud' || 
                                     $result->facility_level->name == 'block' || 
                                     $result->facility_level->name == 'phc' || 
                                     $result->facility_level->name == 'hsc')
                                <tr>
                                    <td>
                                        <label for="districtId" class="form-label">District</label>
                                    </td>
                                    <td>
                                        <span>{{ $result->district->name }}</span>
                                    </td>
                                </tr>
                                @endif

                                <!-- HUD ID (if applicable) -->
                                @if ($result->facility_level->name == 'hud' || 
                                     $result->facility_level->name == 'block' || 
                                     $result->facility_level->name == 'phc' || 
                                     $result->facility_level->name == 'hsc')
                                <tr>
                                    <td>
                                        <label for="hudId" class="form-label">HUD</label>
                                    </td>
                                    <td>
                                        <span>{{ $result->hud->name }}</span>
                                    </td>
                                </tr>
                                @endif

                                <!-- Block ID (if applicable) -->
                                @if ($result->facility_level->name == 'block' || 
                                     $result->facility_level->name == 'phc' || 
                                     $result->facility_level->name == 'hsc')
                                <tr>
                                    <td>
                                        <label for="blockId" class="form-label">Block</label>
                                    </td>
                                    <td>
                                        <span>{{ $result->block->name }}</span>
                                    </td>
                                </tr>
                                @endif

                                <!-- PHC ID (if applicable) -->
                                @if ($result->facility_level->name == 'phc' || 
                                     $result->facility_level->name == 'hsc')
                                <tr>
                                    <td>
                                        <label for="phcId" class="form-label">PHC</label>
                                    </td>
                                    <td>
                                        <span>{{ $result->phc->name }}</span>
                                    </td>
                                </tr>
                                @endif

                                <!-- HSC ID (if applicable) -->
                                @if ($result->facility_level->name == 'hsc')
                                <tr>
                                    <td>
                                        <label for="hscId" class="form-label">HSC</label>
                                    </td>
                                    <td>
                                        <span>{{ $result->hsc->name }}</span>
                                    </td>
                                </tr>
                                @endif

                                <!-- Urban/Rural -->
                                <tr>
                                    <td>
                                        <label for="status" class="form-label">Urban/Rural</label>
                                    </td>
                                    <td>
                                        <span>{{ $result->area_type == 1 ? 'Urban' : 'Rural' }}</span>
                                    </td>
                                </tr>

                                <!-- Status -->
                                <tr>
                                    <td>
                                        <label for="status" class="form-label">Status</label>
                                    </td>
                                    <td>
                                        <span>{{ $result->status == 1 ? 'Active' : 'In-Active' }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-flex mt-2">
                            <button type="button" onclick="window.location.href='{{ route('facility_hierarchy.index') }}'" style="margin-left: 10px;" class="btn btn-primary">Back</button>
                        </div>
                    </div>
                    
                </div>
            </div>

            <!-- insert the contents Here end -->
        </div>
        <!-- page inner end-->
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        setPageUrl('/facility_hierarchy?');
    });
</script>
@endsection
