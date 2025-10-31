@extends('admin.layouts.layout')
@section('title', 'Edit Program Details')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Documents</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit NewsLetter</li>
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
                    <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                        <form id="newsletterForm" action="{{route('dph-newsletter.update', $result->id)}}" enctype="multipart/form-data" method="post">
                            {{csrf_field()}}
                            @method('PUT')
                            <h4 class="card-title mb-4 text-primary">Edit Newsletter</h4>

                            <!-- All Fields in One Div using d-grid -->
                            <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                                <!-- Title -->
                                <div>
                                    <label for="newsletterTitle" class="form-label">Title <span
                                            style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="newsletterTitle"
                                        placeholder="Enter Title" value="{{ $result->name }}" name="name">
                                </div>

                                <!-- File Upload -->
                                <div>
                                    <label for="newsletterFile" class="form-label">Newsletter PDF Upload</label>
                                    <div class="input-group">
                                        <input type="file" accept=".pdf" class="form-control" id="newsletterFile" name="document">
                                        <a href="{{ fileLink($result->document_url) }}" target="_blank"
                                            class="btn btn-primary input-group-text">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                    <small style="color: red;">Accepted formats: .pdf, max size 5MB</small>
                                </div>

                                <!-- thumbnail Upload -->
                                <div>
                                    <label for="thumbnailImage" class="form-label">Upload Thumbnail Image</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="thumbnailImage" name="image">
                                            <a href="{{ fileLink($result->image_url) }}" target="_blank"
                                                class="btn btn-primary input-group-text">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    <small style="color: red;">Accepted formats: .jpg, .jpeg, .png, max size 5MB</small>
                                </div>

                                <!-- Date -->
                                <div>
                                    <label for="publishDate" class="form-label">Publish Date <span
                                            style="color: red;">*</span></label>
                                    <input type="date" class="form-control" id="publishDate" value="{{ $result->date }}" name="date">
                                </div>

                                <!-- Volume -->
                                <div>
                                    <label for="volume" class="form-label">Volume <span
                                            style="color: red;">*</span></label>
                                    <input type="number" class="form-control" id="volume"
                                        placeholder="Enter Volume Number" value="{{ $result->volume }}" name="volume">
                                </div>

                                <!-- Issues -->
                                <div>
                                    <label for="issues" class="form-label">Issues <span
                                            style="color: red;">*</span></label>
                                    <input type="number" class="form-control" id="issues"
                                        placeholder="Enter Issue Number" value="{{ $result->issue }}" name="issue">
                                </div>

                                <!-- Status -->
                                <div>
                                    <label for="status" class="form-label">Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="toggleStatus" value="1" name="status"
                                        {{ CHECKBOX('status', $result->status) }}
                                            onchange="toggleStatusText('statusLabel', this)">
                                        <label class="form-check-label" for="toggleStatus" id="statusLabel">{{ $result->status == 1 ? 'Active' : 'In-Active' }}</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="md-3">
                                <label for="newsletterDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="newsletterDescription" placeholder="Enter Description" name="description"></textarea>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex mt-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-danger" onclick="history.back()" style="margin-left: 10px;">
                                    Cancel
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- database table end -->
    </div>
    
    <script>
        tinymce.init({
        selector: '#newsletterDescription', // Target the textarea by its ID
        height: 300, // Set the height of the editor
        menubar: false, // Disable the menubar (optional)
        plugins: 'lists link image table code help', // Add plugins as needed
        toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code | help', // Customize the toolbar
        });
    </script>
@endsection
