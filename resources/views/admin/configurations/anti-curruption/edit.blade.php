@extends('admin.layouts.layout')
@section('title', 'Create DPH Icon')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Anti- Corruption Details</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Anti-Corruption Details</li>
                    </ol>
                </nav>

            </div>
        </div>

        <div class="container-fluid">
            <div class="page-inner">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- insert the contents Here start -->

                <div class="container mt-2">
                    <div class="row">
                        <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                            <!-- Separate div for Scroller Notification -->
                            <form id="dphIconForm" action="{{ route('anti-curruption.update', $result->id) }}"
                                enctype="multipart/form-data" method="post">
                                {{ csrf_field() }}
                                @method('PUT')
                                <div class="container">
                                    <h4 class="mb-4 text-primary">Edit Anti-corruption Details</h4>
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="antiCurruptionDescription"
                                                class="form-label font-weight-bold">Tamil Description<span
                                                    class="sizeoftextred">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" class="form-control" id="tamildescription"
                                                placeholder="Enter Tamil Description" required name="tamildescription" value="{{ $result->tamildescription }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="antiCurruptionDescription"
                                                class="form-label font-weight-bold">English Description<span
                                                    class="sizeoftextred">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" class="form-control" id="englishdescription"
                                                placeholder="Enter English Description" required name="englishdescription" value="{{ $result->englishdescription }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="antiCurruptionaddress"
                                                class="form-label font-weight-bold">Tamil Address<span
                                                    class="sizeoftextred">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" class="form-control" id="tamiladdress"
                                                placeholder="Enter Tamil Address" required name="tamiladdress" value="{{ $result->tamiladdress }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="antiCurruptionaddress"
                                                class="form-label font-weight-bold">English Address<span
                                                    class="sizeoftextred">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" class="form-control" id="englishaddress"
                                                placeholder="Enter English Address" required name="englishaddress" value="{{ $result->englishaddress }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="antiCurruptionFaxNumber" class="form-label font-weight-bold">Fax
                                                No.</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" class="form-control" id="fax_number"
                                                placeholder="Enter Fax Number" name="fax_number" value="{{ $result->fax_number }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="antiCurruptionaPhoneNumber"
                                                class="form-label font-weight-bold">Phone Number</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" class="form-control" id="phone_number"
                                                placeholder="Enter Phone Number" name="phone_number" value="{{ $result->phone_number }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="antiCurruptionWebsite"
                                                class="form-label font-weight-bold">Website<span
                                                    class="sizeoftextred">*</span></label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <input type="text" class="form-control" id="website"
                                                placeholder="Enter Website" name="website" value="{{ $result->website }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12 col-md-3">
                                            <label for="status" class="form-label">Status</label>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" name="status" type="checkbox"
                                                    id="toggleStatus" value="1"
                                                    {{ CHECKBOX('status', $result->status) }}
                                                    onchange="toggleStatusText('statusLabel', this)">
                                                <label class="form-check-label" for="toggleStatus" id="statusLabel">
                                                    {{ $result->status == 1 ? 'Active' : 'In-Active' }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button trigger modal -->
                                <div class="d-flex mt-2 pl-5">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-danger" onclick="history.back()" style="margin-left: 10px;">
                                        Cancel
                                    </button>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>


                <!-- insert the contents Here end -->
            </div>
            <!-- page inner end-->
        </div>
    @endsection
