@extends('admin.layouts.layout')
@section('title', 'Create Scroller Notification')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Scroller Notification</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Scroller Notification</li>
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

                <div class="container-fluid mt-2">
                    <div class="row justify-content-center">
                        <div class="col-lg-12"
                            style="background: linear-gradient(to right, #ffffff, #ffffff); border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">

                            <div class="container-fluid p-1 mt-3" style="background-color: #ffffff; border-radius: 10px;">
                                <!-- Separate div for Scroller Notification -->
                                <form id="scrollerNotificationForm" action="{{ route('scroller-notif.store') }}" enctype="multipart/form-data" method="post">
                                    {{ csrf_field() }}
                                    <div class="mb-4 p-4">
                                        <h4 class="mb-4 text-primary">Create Scroller Notification</h4>
                                        <div class="row g-3 align-items-start">
                                          <!-- Notification Text -->
                                             <div class="col-md-9">
                                            <label for="scrollerNotification" class="form-label font-weight-bold">Notification Title</label>
                                            <textarea class="form-control shadow-sm" id="scrollerNotification" placeholder="Enter scrolling notification text" rows="4" name="title" required></textarea>
                                          </div>
                                      
                                          <div class="col-md-9">
                                            <label for="scrollerNotification" class="form-label font-weight-bold">Notification Text</label>
                                            <textarea class="form-control shadow-sm" id="scrollerNotification" placeholder="Enter scrolling notification text" rows="4" name="name" required></textarea>
                                          </div>
                                      
                                          <!-- Notification Link -->
                                          <div class="col-md-9">
                                            <label for="scrollerNotificationLink" class="form-label font-weight-bold">Notification Link</label>
                                            <input class="form-control shadow-sm" type="text" id="scrollerNotificationLink" placeholder="Enter scrolling notification link" name="link">
                                          </div>
                                      
                                          <!-- Toggle Switch -->
                                          <div class="col-md-9 d-flex align-items-center justify-content-start mt-4 mt-md-0">
                                            <div class="form-check form-switch">
                                              <input class="form-check-input" name="status" type="checkbox" id="toggleStatus" value="1" {{ CHECKBOX('document_status') }} onchange="toggleStatusText('statusLabel', this)">
                                              <label class="form-check-label ms-2" for="toggleStatus" id="statusLabel">In-Active</label>
                                            </div>
                                          </div>
                                        </div>
                                      
                                        <!-- Submit Button -->
                                        <div class="text-start mt-4">
                                          <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#submitModal1">Submit</button>
                                        </div>
                                      </div>
                                      
                                </form>
                            <!-- Modal popup end -->
                            </form>

                        </div>
                    </div>
                </div>
            </div>


            <!-- insert the contents Here end -->
        </div>
        <!-- page inner end-->
    </div>
    {{-- <script>
        tinymce.init({
          selector: '#scrollerNotification', // Target the textarea by its ID
          height: 300, // Set the height of the editor
          menubar: false, // Disable the menubar (optional)
          plugins: 'lists link image table code help', // Add plugins as needed
          toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code | help', // Customize the toolbar
        });
      </script> --}}
@endsection
