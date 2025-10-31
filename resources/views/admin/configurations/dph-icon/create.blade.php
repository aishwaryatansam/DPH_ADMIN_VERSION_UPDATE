@extends('admin.layouts.layout')
@section('title', 'Create DPH Icon')
@section('content')
<style>
    .form-check-input:disabled {
        opacity: 0.6;
    }
    .glow-color1 {
        background: linear-gradient(to right, #ff7e5f, #feb47b); /* Color 1 gradient */
        box-shadow: 0 0 10px 5px rgba(255, 126, 95, 0.5); /* Glowing effect */
    }
</style>

<div class="container" style="margin-top: 90px;">
    <div class="container-fluid p-2" style="background-color: #f2f2f2;">
        <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
            <h5 class="mb-0">DPH Icon</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">DPH Icon</li>
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
            <div class="container mt-2">
                <div class="row">
                    <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                        <!-- Form for DPH Icon -->
                        <form id="dphIconForm" action="{{ route('dph-icon.store') }}" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="container">
                                <h4 class="mb-4 text-primary">Create DPH Icon</h4>

                                <!-- Name and Link Inputs -->
                                <div class="row mb-3">
                                    <div class="col-12 col-md-3">
                                        <label for="dphIconName" class="form-label font-weight-bold">Name<span class="sizeoftextred">*</span></label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input type="text" class="form-control" id="name" placeholder="Enter Name" required name="name">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12 col-md-3">
                                        <label for="dphIconLink" class="form-label font-weight-bold">Link<span class="sizeoftextred">*</span></label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <input type="text" class="form-control" id="link" placeholder="Enter Link" required name="link">
                                    </div>
                                </div>

                                <!-- Color Selection Toggle (Only one option now) -->
                                <div class="row mb-3">
                                    <div class="col-12 col-md-3">
                                        <label for="toggleColor1" class="form-label font-weight-bold">Color Selection</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <!-- Single Color Toggle -->
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="coloreffect" type="checkbox" id="toggleColor1" {{ CHECKBOX('color_status') }} value="1">
                                            <label class="form-check-label" for="toggleColor1">Color 1 (Glow effect)</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="row mb-3">
                                    <div class="col-12 col-md-3">
                                        <label for="status" class="form-label">Status</label>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="status" type="checkbox" id="toggleStatus" value="1" {{ CHECKBOX('document_status') }} onchange="toggleStatusText('statusLabel', this)">
                                            <label class="form-check-label" for="toggleStatus" id="statusLabel">In-Active</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="d-flex mt-2 pl-5">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" style="margin-left: 10px;" class="btn btn-danger" onclick="history.back()">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Define the toggleColor function for only one color
    function toggleColor() {
        let toggle1 = document.getElementById('toggleColor1');

        // Reset the glow effect
        let button = document.querySelector('a'); // Or any other element you want to apply the effect to
        button.classList.remove('glow-color1');

        // If Color 1 is checked, apply the glow effect
        if (toggle1.checked) {
            button.classList.add('glow-color1');
        }
    }

    // Event listener for color toggle
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('toggleColor1').addEventListener('change', toggleColor);
    });
</script>
@endsection
@endsection
