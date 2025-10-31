@extends('admin.layouts.layout')
@section('title', 'List Contacts')
@section('content')
<div class="page-wrapper">
   <div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Contacts</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Contacts</li>
                </ol>
                <a class="btn btn-info d-ntone d-lg-block m-l-15" href="{{route('contacts.create')}}"><i class="fa fa-plus-circle"></i> Create New</a>
            </div>
        </div>
    </div>
      <div class="row">

         <div class="col-lg-12">
            <!-- Table Html -->
            <div class="card">
               <div class="card-body">
                  <div class="table-responsive m-t-40">
                     <div id="myTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row m-b-40">

                           <div class="col-sm-12 col-md-6">
                              <div class="dataTables_length" id="myTable_length">
                                 <label>Show </label>
                                    <select name="pageLength" id="pageLength" aria-controls="myTable" on-change="searchFun()">
                                      @foreach(getPageLenthArr() as $pageLenght)
                            <option value="{{$pageLenght}}" {{SELECT($pageLenght,request('pageLength'))}}>{{$pageLenght}}</option>
                            @endforeach   
                                    </select>
                              </div>
                           </div>

                           <div class="col-sm-12 col-md-6">
                              <div  class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="myTable" id="keyword" value="{{request('keyword')}}"></label></div>
                           </div>
                           <input type="hidden" name="sortfield" id="sortfield" value="{{request('sortfield')}}"/>
                           <input type="hidden" name="sorttype" id="sorttype" value="{{request('sorttype')}}"/>
                        </div>

                        <div class="row">
                           <div class="col-sm-12">
                              <table class="table table-hover">
                                 <thead>
                                    <tr>
                                       
                                       <th><a class="sort" data-column="name"><i class="fa fa-sort" aria-hidden="true"></i>Name</a></th>

                                       <th><a class="sort" data-column="designation"><i class="fa fa-sort" aria-hidden="true"></i>Designation</a></th>

                                       <th> <a class="sort" data-column="mobile_number"><i class="fa fa-sort" aria-hidden="true"></i>Mobile Number</a> </th>

                                       <th> <a class="sort" data-column="landline_number"><i class="fa fa-sort" aria-hidden="true"></i>Landline Number</a> </th>

                                       <th><a class="sort" data-column="email_id"><i class="fa fa-sort" aria-hidden="true"></i>Email Id</a></th>

                                       <th><a class="sort" data-column="fax"><i class="fa fa-sort" aria-hidden="true"></i>Fax</a></th>
                                       
                                        <th>Image</th>
                                       <th>Status</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>

                                  @if(!empty($results) && $results->count())
                                  @foreach($results as $result)
                                    <tr>

                                      
                                       <td>{{$result->name ?? ''}}</td>
                                        <td>{{$result->designation->name ?? '--'}}</td>
                                       <td>@if($result->mobile_number){{$result->country_code ?? ''}} {{$result->mobile_number ?? '--'}}@else -- @endif</td>
                                       <td>{{$result->landline_number ?? '--'}}</td>
                                       <td>{{$result->email_id ?? '--'}}</td> 
                                       <td>{{$result->fax ?? '--'}}</td>
                                       <td><a class="text-danger" href="{{fileLink($result->image_url)}}">{{$result->image_url}}</a></td>
                                       <td>
                                        @if(isset($result->status) && $result->status == 1)
                                        <span class="text-success">Active</span>
                                        @else
                                          <span class="text-danger">In-Active</span>
                                        @endif
                                      </td>
                                      <td>
                                       <a class="waves-effect waves-dark" href="{{route('contacts.show',$result->id)}}" data-toggle="tooltip" data-original-title="View Contact"><i class="fa fa-eye"></i></a>
                                    &nbsp;&nbsp;&nbsp;
                                        <a class="waves-effect waves-dark" href="{{route('contacts.edit',$result->id)}}" data-toggle="tooltip" data-original-title="Edit Contact"><i class="fa fa-edit"></i></a>

                                        </td>
                                    </tr>
                                  @endforeach
                                  @else
                                  <tr>
                                    <td collspan="6">No Records Found..</td>
                                  </tr>
                                  @endif
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        @include('admin.common.table-footer')
                     </div>
                  </div>
               </div>
            </div>
            <!-- Table Html -->
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    setPageUrl('/contacts?');
  });
</script>
@endsection
