@extends('admin.layouts.layout')
@section('title', 'Create Popular')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Popular</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="{{ route('popular.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Popular</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container-fluid">
            <div class="page-inner">
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="container-fluid mt-3">
                    <div class="row">
                        <div class="col-lg-5 py-5 px-5" style="background-color: #ffffff; border-radius: 10px;">
                            <form action="{{ route('popular.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="popularName" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" id="popularName"
                                        placeholder="Enter popular item name" required>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12 mt-2 col-md-3">
                                        <label for="status" class="form-label">Status</label>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="status" type="checkbox" id="toggleStatus"
                                                value="1" checked onchange="toggleStatusText('statusLabel', this)">
                                            <label class="form-check-label" for="toggleStatus" id="statusLabel">Active</label>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('popular.index') }}" class="btn btn-danger">Cancel</a>
                            </form>

                            <!-- Confirmation Modal -->
                            <div class="modal fade" id="confirmationModal" tabindex="-1"
                                aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header justify-content-center position-relative">
                                            <h5 class="modal-title" id="confirmationModalLabel">Confirm Submission</h5>
                                            <button type="button" class="btn-close position-absolute end-0 me-3"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <div class="confirmation-icon mb-4">
                                                <i class="fas fa-question-circle fa-4x text-danger"></i>
                                            </div>
                                            <p class="mb-4">Are you sure you want to submit the form?</p>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="button" class="btn btn-outline-danger"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-success" onclick="submitForm()">Yes, Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- col -->
                    </div> <!-- row -->
                </div> <!-- container-fluid -->
            </div> <!-- page-inner -->
        </div> <!-- container-fluid -->
    </div> <!-- main container -->
@endsection

@push('scripts')
<script>
    function toggleStatusText(labelId, checkbox) {
        const label = document.getElementById(labelId);
        label.textContent = checkbox.checked ? 'Active' : 'In-Active';
    }
</script>
@endpush
