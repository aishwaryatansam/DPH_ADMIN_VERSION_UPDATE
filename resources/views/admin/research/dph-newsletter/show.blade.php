@extends('admin.layouts.layout')
@section('title', 'View Programs')
@section('content')
<div class="container" style="margin-top: 90px;">
    <div class="container-fluid p-2" style="background-color: #f2f2f2;">
      <div class="d-flex justify-content-between align-items-center"
        style="padding-left: 20px; padding-right: 20px;">
        <h5 class="mb-0">Documents</h5>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">View DPH NewsLetter</li>
          </ol>
        </nav>

      </div>
    </div>
    <div class="container-fluid">
      <div class="page-inner">
        <div class="container-fluid mt-2">
          <div class="row">
            <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
              <!-- View Newsletter Details Section Start -->
              <div class="card-body">
                <!-- Heading -->
                <h4 class="card-title mb-4 text-primary">View Newsletter Details</h4>

                <!-- All Fields in One Div using d-grid -->
                <div class="d-grid gap-4 mb-3 grid-3 grid-2 grid-1">
                  <!-- Title -->
                  <div>
                    <label class="font-weight-bold text-secondary">Title:</label>
                    <div class="border p-3 rounded bg-light">{{ $result->name }}</div>
                  </div>

                  <!-- Description -->
                  <div>
                    <label class="font-weight-bold text-secondary">Description:</label>
                    <div class="border p-3 rounded bg-light">{{ $result->description }}</div>
                  </div>

                  <!-- Newsletter PDF -->
                  <!-- <div>
                    <label class="font-weight-bold text-secondary">Newsletter PDF:</label>
                    <div class="border p-3 rounded bg-light">[PDF Link Here]</div>
                  </div> -->

                   <!-- File Upload -->
                   <div>
                    <div class="font-weight-bold text-secondary">Newsletter PDF:</div>
                    <div class="input-group">
                        
                        <div class="input-group-append">
                            <a href="{{ fileLink($result->document_url) }}" target="_blank" class="btn btn-primary">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>

                  <!-- Thumbnail Image -->
                  <div>
                    <label class="font-weight-bold text-secondary">Thumbnail Image:</label>
                    <div class="input-group">
                        
                        <div class="input-group-append">
                            <a href="{{ fileLink($result->image_url) }}" target="_blank" class="btn btn-primary">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </div>
                  </div>

                  <!-- Publish Date -->
                  <div>
                    <label class="font-weight-bold text-secondary">Publish Date:</label>
                    <div class="border p-3 rounded bg-light">{{ $result->date }}</div>
                  </div>

                  <!-- Volume -->
                  <div>
                    <label class="font-weight-bold text-secondary">Volume:</label>
                    <div class="border p-3 rounded bg-light">{{ $result->volume }}</div>
                  </div>

                  <!-- Issues -->
                  <div>
                    <label class="font-weight-bold text-secondary">Issues:</label>
                    <div class="border p-3 rounded bg-light">{{ $result->issue }}</div>
                  </div>

                  <!-- Status -->
                  <div>
                    <label class="font-weight-bold text-secondary">Status:</label>
                    <div class="border p-3 rounded bg-light">
                      <span class="badge {{ $result->status ? 'bg-success' : 'bg-danger' }} text-light">{{findStatus($result->status)}}</span>
                      <!-- or "Inactive" depending on the status -->
                    </div>
                  </div>

               
              </div>
               <!-- Action Button -->
               <div class="d-flex justify-content-start mt-3">
                <button type="button" onclick="window.location.href='{{ route('dph-newsletter.index') }}';"
                  class="btn btn-primary">Back</button>
              </div>
              <!-- View Newsletter Details Section End -->
            </div>
          </div>
        </div>
      </div>
    </div>




    <!-- database table end -->
  </div>
@endsection
