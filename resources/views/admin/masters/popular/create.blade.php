@extends('admin.layouts.layout')
@section('title', isset($result) ? 'Edit Popular' : 'Create Popular')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('select').select2();
    });
</script>
<div class="container" style="margin-top: 90px;">
    <div class="container-fluid p-2" style="background-color: #f2f2f2;">
        <div class="d-flex justify-content-between align-items-center px-3">
            <h5 class="mb-0">Popular</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                    <li class="breadcrumb-item"><a href="{{ route('popular.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ isset($result) ? 'Edit Popular' : 'Create Popular' }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-fluid">
        <div class="page-inner mt-3">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-5 py-5 px-5 bg-white rounded">
                    <form action="{{ isset($result) ? route('popular.update', $result->id) : route('popular.store') }}" 
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($result))
                            @method('PUT')
                        @endif

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="popularName" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="popularName" 
                                placeholder="Enter popular item name" 
                                value="{{ old('name', $result->name ?? '') }}" required>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="popularDescription" class="form-label">Short Description</label>
                            <textarea class="form-control" name="descript" id="popularDescription"
                                placeholder="Enter short description" rows="3">{{ old('descript', $result->descript ?? '') }}</textarea>
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <label for="profileImage" class="form-label">Upload Image</label>
                            <input type="file" class="form-control" id="profileImage" accept="image/*" name="img">
                            <small class="text-muted">Accepted .jpg/.jpeg/.png & max size 5MB</small>
                            @if(isset($result) && $result->img)
                                <img src="{{ asset($result->img) }}" alt="Preview" class="img-fluid mt-2" style="max-width:100px;">
                            @endif
                        </div>

                        <!-- Status -->
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" name="status" type="checkbox" id="toggleStatus"
                                   value="1" {{ old('status', $result->status ?? 1) ? 'checked' : '' }}
                                   onchange="toggleStatusText('statusLabel', this)">
                            <label class="form-check-label" id="statusLabel" for="toggleStatus">
                                {{ old('status', $result->status ?? 1) ? 'Active' : 'In-Active' }}
                            </label>
                        </div>

                        <!-- Tags -->
                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags</label>
<select name="tags[]" class="form-control" multiple>
    @foreach($tags as $tag)
        <option value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}>
            {{ $tag->name }}
        </option>
    @endforeach
</select>


                        </div>

                        <!-- Buttons -->
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('popular.index') }}" class="btn btn-danger">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- jQuery + Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const tagSelect = document.getElementById('tags');

    // Clear old items
    tagSelect.innerHTML = '<option value="">-- Select Tags --</option>';

    fetch('{{ route('list-tags') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.json())
    .then(response => {
        if (response.data && response.data.length > 0) {
            response.data.forEach(tag => {
                let option = document.createElement('option');
                option.value = tag.id;
                option.textContent = tag.name;
                tagSelect.appendChild(option);
            });
        }
    })
    .catch(err => console.error("Tag Load Error:", err));
});
</script>


@endpush
