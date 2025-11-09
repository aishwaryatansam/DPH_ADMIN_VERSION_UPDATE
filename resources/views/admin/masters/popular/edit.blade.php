@extends('admin.layouts.layout')
@section('title', 'Edit Block')
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script><script>
        $(document).ready(function() {
    $('.select2').select2({
        width: '100%',
        placeholder: "Select tags",
        allowClear: true
    });
});

    </script>
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Tags</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Tags</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                <div class="container-fluid mt-2">
                    <div class="row">
                        <div class="col-lg-5 p-5" style="background-color: #ffffff; border-radius: 10px;">
                            <!-- insert the contents Here start -->

                            <div class="card-body">
                                <!-- Heading -->
                                <h4 class="card-title mb-4 text-primary">Edit tags Details</h4>

                                <form action="{{route('popular.update',$result->id)}}" enctype="multipart/form-data" method="post">
                                    {{csrf_field()}}
                                    @method('PUT')
                                    <!-- Name -->
                                    <div class="row mb-3 p-3">
                                        <div class="col-md-10">
                                            <div class="font-weight-bold text-secondary">Name:</div>
                                            <input type="text" class="form-control" id="tagName" value="{{old('name',$result->name)}}"
                                                name="name">
                                        </div>

                                    </div>

                                    <!-- District Row as Dropdown -->
                                 <div class="row mb-3 px-3">
    <div class="col-md-10">
   <label for="popular" class="form-label">Tags<span
                                                    style="color: red;">*</span></label>
                                        </div>
                                           <div class="col-12 col-md-10">
    <select class="form-control select2" id="tags" name="tags[]" multiple>
        @foreach ($tags as $id => $name)
            <option value="{{ $id }}" {{ in_array($id, $selectedTags) ? 'selected' : '' }}>
                {{ $name }}
            </option>
        @endforeach
    </select>
</div>






                                    <!-- Status -->
                                    <div class="row mb-3 px-3">
                                        <div class="col-md-10">
                                            <div class="font-weight-bold text-secondary">Status:</div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input " name="status" type="checkbox"
                                                    id="toggleStatus" value="1"
                                                    {{ CHECKBOX('status', $result->status) }}
                                                    onchange="toggleStatusText('statusLabel', this)">
                                                <label class="form-check-label" for="toggleStatus"
                                                    id="statusLabel">{{ $result->status == 1 ? 'Active' : 'In-Active' }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="text-start mt-4 px-3">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button type="button" onclick="window.location.href='{{url('/popular.index')}}';" class="btn btn-danger">Cancel</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Modal for Image Preview -->
                           





                            <!-- insert the contents Here end -->
                        </div>
                    </div>
                </div>








            </div>
            <!-- page inner end-->
        </div>
        <!-- database table end -->
    </div>
@endsection
