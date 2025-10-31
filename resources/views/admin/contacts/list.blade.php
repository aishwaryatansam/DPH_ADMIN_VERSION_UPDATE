@extends('admin.layouts.layout')
@section('title', 'List Contacts')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="container-fluid p-2" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center" style="padding-left: 20px; padding-right: 20px;">
                <h5 class="mb-0">Contacts</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background-color: #f2f2f2;">
                        <li class="breadcrumb-item"><a href="#">Contacts</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Contacts</li>
                    </ol>
                </nav>

            </div>
        </div>
        <div class="container-fluid">
            <div class="page-inner">
                <!-- insert the contents Here start -->


                <!-- Filter Card -->
                <div>
                    <div class="card mb-5 mt-2">
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Contact Type</label>
                                            <select name="contact_type" class="form-control searchable" onchange="searchFun()">
                                                <option value="" >-- Select -- </option>
                                                  @foreach($contact_types as $contact_type)
                  
                                              <option value="{{$contact_type->id}}" {{SELECT($contact_type->id,request('contact_type'))}}>{{$contact_type->name}}</option>
                                              @endforeach
                                              </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>HUD</label>
                                            <select name="hud_id" class="form-control searchable" onchange="searchFun()">
                                                <option value="" >-- Select HUD -- </option>
                                                @foreach($huds as $hud)
                                                <option value="{{$hud->id}}" {{SELECT($hud->id,request('hud_id'))}}>{{$hud->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @if(!empty($blocks))
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                       <label>Block</label>
                                           <select name="block_id" class="form-control searchable" onchange="searchFun()">
                                             <option value="" >-- Select Block -- </option>
                                               @foreach($blocks as $block)
                                               <option value="{{$block->id}}" {{SELECT($block->id,request('block_id'))}}>{{$block->name}}</option>
                                               @endforeach
                                           </select>
                                       
                                    </div>
                                    </div>
                                     @endif
                                     @if(!empty($phcs))
                                     <div class="col-sm-2">
                                        <div class="form-group">
                                        <label>PHC</label>
                                            <select name="phc_id" class="form-control searchable" onchange="searchFun()">
                                              <option value="" >-- Select PHC -- </option>
                                                @foreach($phcs as $phc)
                                                <option value="{{$phc->id}}" {{SELECT($phc->id,request('phc_id'))}}>{{$phc->name}}</option>
                                                @endforeach
                                            </select>
                                        
                                    </div>
                                     </div>
                                      @endif

                                      @if(!empty($hscs))
                                      <div class="col-sm-2">
                                        <div class="form-group">
                                        <label>HSC</label>
                                            <select name="hsc_id" class="form-control searchable" onchange="searchFun()">
                                            
                                                <option value="" >-- Select HSC -- </option>
                                                @foreach($hscs as $hsc)
                                                <option value="{{$hsc->id}}" {{SELECT($hsc->id,request('hsc_id'))}}>{{$hsc->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        </div> 
                                         @endif


                                    <!-- <div class="col d-flex justify-content-end align-items-center mt-2">
                                        <div class="form-group d-flex">
                                            <button type="button" class="btn btn-primary me-2"
                                                style="border-radius: 10px;">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <button type="reset" class="btn btn-secondary resetSearch" style="border-radius: 10px;" onClick="resetSearch()">
                                                <i class="fas fa-redo"></i>
                                            </button>
                                        </div>
                                    </div> -->
                                </div>

                            </form>
                        </div>
                    </div>


                    <!-- DataTable Start -->
                    <div class="container-fluid mt-2">
                        <div class="col-md-12 col-lg-12 mt-lg-5 mt-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Contacts</h4>
                                        <button class="btn btn-primary btn-round ms-auto"
                                            onclick="window.location.href='{{ route('contacts.create') }}';">
                                            <i class="fa fa-plus"></i> Add Contacts
                                        </button>
                                    </div>
                                </div>

                                <!-- Table Card -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="add-row" class="display table table-striped table-hover"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Contact Type</th>
                                                    <th>Is Post Vacant</th>
                                                    <th>Name</th>
                                                    <th>Approval Status</th>
                                                    <th>Public Status</th>
                                                    <th class="text-center" style="width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($results-> isEmpty())
                                                <tr>
                                                    <td colspan="6" class="text-center">No contacts available.</td>
                                                </tr>
                                                @else
                                                @foreach ($results as $result)
                                                    <tr>
                                                        <td>{{ $result->contactType->name ?? '' }}</td>
                                                        <td>
                                                            @if (isset($result->is_post_vacant) && $result->is_post_vacant == '1')
                                                                <span>Yes</span>
                                                            @else
                                                                <span>No</span>
                                                            @endif
                                                        </td>
                                                        <td><a href="#">{{ $result->name ?? '--' }}</a></td>
                                                        <td>
                                                            {!! getStageBadge($result->approvalWorkflow->current_stage ?? '') !!}
                                                        </td>
                                                        <td class="text-success" style="font-weight: bold;">
                                                            @if (isset($result->status) && $result->status == 1)
                                                                <span class="text-success">Active</span>
                                                            @else
                                                                <span class="text-danger">In-Active</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="form-button-action">
                                                                @if (
                                                                    ($user_detail->user_type_id == '7') || 
                                                                    ($result->approvalWorkflow && $result->approvalWorkflow->current_stage !== 'published' && $result->approvalWorkflow->uploaded_by !== $user_detail->id)
                                                                )
                                                                <button type="button"
                                                                    class="btn btn-link btn-primary btn-lg"
                                                                    data-original-title="Edit Task"
                                                                    onclick="window.location.href='{{ route('contacts.edit', $result->id) }}';">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                                @endif
                                                                <button type="button" class="btn btn-link btn-danger"
                                                                    onclick="window.location.href='{{ route('contacts.show', $result->id) }}';"
                                                                    data-bs-toggle="tooltip" title="View Contact">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @endif
                                                <!-- More rows as needed -->
                                            </tbody>
                                        </table>
                                        <!-- Pagination Links -->
                                        <div class="d-flex justify-content-center">
                                            {{ $results->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- DataTable End -->
                    <!-- insert the contents Here end -->
                </div>
            </div>
        </div>

        <!-- content end here -->

    </div>
    
  

    <!-- <script type="text/javascript">
        $(document).ready(function() {
            setPageUrl('/contacts?');
        });
    </script> -->
@endsection
