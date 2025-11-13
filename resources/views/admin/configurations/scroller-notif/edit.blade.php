@extends('admin.layouts.layout')
@section('title', 'Edit Scroller Notification')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Edit ScrollerNotification</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit ScrollerNotification</li>
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
                <div>

                    <!-- insert the contents Here start -->

                    <div class="container mt-2">
                        <div class="row">
                            <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                                <form id="myForm" action="{{ route('scroller-notif.update', $result->id) }}"
                                    enctype="multipart/form-data" method="post">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <div class="container">
                                        <h4 class="card-title mb-4 text-primary">Edit Scroller Notification</h4>

                                        <!-- Scroller Notification Row -->
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="scrollerNotification" class="form-label">Scroller Notification
                                                    <span class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <textarea class="form-control" id="scrollerNotification" rows="4" name="name"
                                                    placeholder="Enter scroller notification content" required>{{old('name', $result->name)}}</textarea>
                                            </div>
                                        </div>
      <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="scrollerNotification" class="form-label">Scroller Notification
                                                    <span class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <textarea class="form-control" id="scrollerNotification" rows="4" name="title"
                                                    placeholder="Enter scroller notification content" required>{{old('title', $result->name)}}</textarea>
                                            </div>
                                        </div>
                                        <!-- Scroller Notification Row -->
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-3">
                                                <label for="scrollerNotification" class="form-label">Scroller Notification Link
                                                    <span class="sizeoftextred">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <input class="form-control" type="text" name="link"  pattern="https?://.*" title="Please enter a valid URL starting with http:// or https://" id="editNotificationLink" value="{{ $result->link }}">
                                            </div>
                                        </div>


                                        <div class="row mb-3 p-3">
                                            <!-- Status -->
                                            <div class="col-md-6">
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
                                    </div>

                                    <!-- Buttons -->
                                    <div class="d-flex mt-2 pl-5">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="button" style="margin-left: 10px;"
                                            class="btn btn-danger">Cancel</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        tinymce.init({
          selector: '#scrollerNotification', // Target the textarea by its ID
          height: 300, // Set the height of the editor
          menubar: false, // Disable the menubar (optional)
          plugins: 'lists link image table code help', // Add plugins as needed
          toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code | help', // Customize the toolbar
        });
      </script>
@endsection
