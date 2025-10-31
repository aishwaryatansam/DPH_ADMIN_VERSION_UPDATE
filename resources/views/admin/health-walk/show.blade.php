@extends('admin.layouts.layout')
@section('title', 'View Health Walk')
@section('content')
<div class="container" style="margin-top: 90px;">
  <div class="container-fluid p-2" style="background-color: #f2f2f2;">
      <div class="d-flex justify-content-between align-items-center"
          style="padding-left: 20px; padding-right: 20px;">
          <h5 class="mb-0">Documents</h5>
          <nav aria-label="breadcrumb">
              <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                  <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">View HealthWalk</li>
              </ol>
          </nav>

      </div>
  </div>
  <div class="container-fluid">
      <div class="page-inner">
          <div class="container-fluid mt-2">
              <div class="row">
                  <div class="col-lg-12 p-5" style="background-color: #ffffff; border-radius: 10px;">
                      <!-- insert the contents Here start -->

                      <div class="card-body">
                          <!-- Heading -->
                          <h4 class="card-title mb-4 text-primary">View HealthWalk Details</h4>

                          <div class="row mb-3 p-3">
                              <!-- District -->
                              <div class="col-md-4">
                                  <div class="font-weight-bold text-secondary">District:</div>
                                  <div class="border p-3 rounded bg-light">{{ $result->hud->district->name ?? '' }}</div>
                              </div>

                              <!-- HUD -->
                              <div class="col-md-4">
                                  <div class="font-weight-bold text-secondary">HUD:</div>
                                  <div class="border p-3 rounded bg-light">{{ $result->hud->name ?? '' }}</div>
                              </div>

                              <!-- Description -->
                              <div class="col-md-4">
                                  <div class="font-weight-bold text-secondary">Description:</div>
                                  <div class="border p-3 rounded bg-light">{{ $result->description ?? '' }}</div>
                              </div>
                          </div>

                          <div class="row mb-3 p-3">
                              <!-- Health Walk Location Area -->
                              <div class="col-md-4">
                                  <div class="font-weight-bold text-secondary">Health Walk Location Area:
                                  </div>
                                  <div class="border p-3 rounded bg-light">{{ $result->area ?? '' }}</div>
                              </div>

                              <!-- Starting Point -->
                              <div class="col-md-4">
                                  <div class="font-weight-bold text-secondary">Starting Point:</div>
                                  <div class="border p-3 rounded bg-light">{{ $result->strati_point ?? '' }}</div>
                              </div>

                              <!-- Ending Point -->
                              <div class="col-md-4">
                                  <div class="font-weight-bold text-secondary">Ending Point:</div>
                                  <div class="border p-3 rounded bg-light">{{ $result->end_point ?? '' }}</div>
                              </div>
                          </div>

                          <div class="row mb-3 p-3">
                              <!-- Contact -->
                              <div class="col-md-4">
                                  <div class="font-weight-bold text-secondary">Contact Number:</div>
                                  <div class="border p-3 rounded bg-light">{{ $result->contact ?? '' }}</div>
                              </div>

                              <!-- Google map link -->
                              <div class="col-md-4">
                                  <div class="font-weight-bold text-secondary">Google Map Link:</div>
                                  <div class="border p-3 rounded bg-light"><a href="{{ $result->location_url ?? '' }}">{{ $result->location_url ?? '' }}</a></div>
                              </div>

                              

                              <!-- Status -->
                              <div class="col-md-4">
                                  <div class="font-weight-bold text-secondary">Status:</div>
                                  <div class="border p-3 rounded bg-light">
                                      <span class="badge {{ $result->status == 1 ? 'bg-success' : 'bg-danger' }} text-light">{{ findStatus($result->status) }}</span>
                                  </div>
                              </div>

                              <div class="col-md-4">
                                  <!-- Placeholder to align items -->
                              </div>
                          </div>

                          <!-- Visible to Public -->
                          <div class="row mb-3 p-3">
                              <div class="col-md-4">
                                  <div class="font-weight-bold text-secondary">Visible to Public:</div>
                                  <div class="border p-3 rounded bg-light">{{ $result->visible_to_public == 1 ? 'Yes' : 'No' }}</div>
                              </div>
                          </div>

                          <!-- Back Button -->
                          <button type="button" onclick="window.location.href='{{ route('health-walk.index') }}';"
                              class="btn btn-primary mt-3" style="margin-left: 13px;">Back</button>
                      </div>

                      <!-- Edit Document Layout end -->
                      <!-- Edit Document Details End -->
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
