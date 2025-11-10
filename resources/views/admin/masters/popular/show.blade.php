@extends('admin.layouts.layout')
@section('title', 'View Popular')
@section('content')

<div class="container" style="margin-top: 90px;">
    <div class="container-fluid p-2" style="background-color: #f2f2f2;">
        <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
            <h5 class="mb-0">Popular</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                    <li class="breadcrumb-item"><a href="{{ route('popular.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Popular</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-fluid">
        <div class="page-inner">
            <div class="container-fluid mt-3">
                <div class="row">
                    <div class="col-lg-6 py-5 px-5" style="background-color: #ffffff; border-radius: 10px;">
                        
                        <!-- Heading -->
                        <h4 class="card-title mb-4 text-primary">View Popular Details</h4>

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Name:</label>
                            <div class="border p-3 rounded bg-light">{{ $result->name }}</div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Short Description:</label>
                            <div class="border p-3 rounded bg-light" style="white-space: pre-wrap;">
                                {{ $result->description ?: 'No description provided' }}
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Image:</label><br>
                            @if(!empty($result->image) && file_exists(public_path($result->image)))
                                <img src="{{ asset($result->image) }}" alt="Popular Image" 
                                     class="img-fluid rounded border p-2" 
                                     style="max-width: 200px; height: auto;">
                            @else
                                <span class="text-muted">No Image Uploaded</span>
                            @endif
                        </div>

                        <!-- Tags -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Tags:</label>
                            <div class="border p-3 rounded bg-light">
                                {{ $result->tag_names ?: 'No tags assigned' }}
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Status:</label>
                            <div class="border p-3 rounded bg-light">
                                <span class="badge {{ $result->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $result->status == 1 ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>

                        <!-- Back Button -->
                        <button type="button" onclick="window.location.href='{{ route('popular.index') }}';"
                                class="btn btn-primary mt-3">Back</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
