@extends('admin.layouts.layout')
@section('title', 'List Documents')
@section('content')
<div class="page-wrapper">
   <div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Documents</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Documents</li>
                </ol>
                @if(!isHud())
                <a class="btn btn-info d-ntone d-lg-block m-l-15" href="{{route('documents.create')}}"><i class="fa fa-plus-circle"></i> Create New</a>
                @endif
            </div>
        </div>
    </div>
      <div class="row">

         <div class="col-lg-12">
            <!-- Table Html -->
            <div class="card">
               <div class="card-body">
                <div class="row">
                    <div class="col-lg-2">
                        <label>Type of Document
                            <select name="navigation" class="form-control form-control-line searchable" onchange="searchFun()">
                              <option value="" >-- Select -- </option>
                                @foreach($navigations as $navigation)
                            <option value="{{$navigation->id}}" {{SELECT($navigation->id,request('navigation'))}}>{{$navigation->name}}</option>
                            @endforeach
                            </select>
                            </label>
                     </div>
                     <div class="col-lg-2">
                        <label>Section
                            <select name="section" class="form-control form-control-line searchable" onchange="searchFun()">
                              <option value="" >-- Select -- </option>
                                @foreach($sections as $section)
                            <option value="{{$section->id}}" {{SELECT($section->id,request('section'))}}>{{$section->name}}</option>
                            @endforeach
                            </select>
                            </label>
                     </div>

                      <div class="col-lg-2">
                        <label>Dated ( From )
                        <input type="date" placeholder="From Date" name="from" class="form-control form-control-line searchable" aria-controls="myTable" value="{{request('from')}}">
                        </label>
                     </div>
                     <div class="col-lg-2">
                        <label>Dated ( To )
                        <input type="date" placeholder="To Date" name="to" class="form-control form-control-line searchable" aria-controls="myTable" value="{{request('to')}}">
                        </label>
                     </div>
                     <div class="col-lg-2">
                        <label>Search:<input type="search" name="keyword" class="form-control form-control-line searchable" placeholder="Search ..." aria-controls="myTable" id="keyword" value="{{request('keyword')}}"></label>
                           </div>

                     <div class="col-lg-1 mt-4">
                        <button type="button" class="btn btn-info d-lg-block" onClick="searchFun()"> Search</button>
                     </div>
                      <div class="col-lg-1 mt-4">
                        <button type="button" class="btn btn-info d-lg-block resetSearch" onClick="resetSearch()"> <i class="fas fa-refresh"></i>&nbsp;Reset</button>
                     </div>
                  </div>
               </div>
            </div>
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
                                       <th>Type of Document</th>
                                       <th>Name of Document</th>
                                       <th>Mapping Section</th>
                                       <th>G.O/Letter/Reference No.</th>
                                       <th>Dated</th>
                                       <th>Visible to Public</th>
                                       <th>Status</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>

                                  @if(!empty($results) && $results->count())
                                  @foreach($results as $result)
                                    <tr>
                                       <td>{{$result->navigation->name ?? '--'}}</td>
                                       <td><a class="text-danger" href="{{fileLink($result->document_url)}}">{{$result->display_filename}}</a></td>
                                       <td>{{$result->tag->name ?? '--'}}</td>
                                       <td>{{$result->reference_no ?? '--'}}</td>
                                       <td>{{$result->dated ?? '--'}}</td>
                                       <td>
                                        @if(isset($result->visible_to_public) && $result->visible_to_public == 1)
                                        <span class="text-success">Yes</span>
                                        @else
                                          <span class="text-danger">NO</span>
                                        @endif
                                      </td>
                                       <td>
                                        @if(isset($result->status) && $result->status == 1)
                                        <span class="text-success">Active</span>
                                        @else
                                          <span class="text-danger">In-Active</span>
                                        @endif
                                      </td>
                                      <td>
                                       <a class="waves-effect waves-dark" href="{{route('documents.show',$result->id)}}" data-toggle="tooltip" data-original-title="View Document"><i class="fa fa-eye"></i></a>
                                    &nbsp;&nbsp;&nbsp;
                                        @if(!isHud())
                                        <a class="waves-effect waves-dark" href="{{route('documents.edit',$result->id)}}" data-toggle="tooltip" data-original-title="Edit Document"><i class="fa fa-edit"></i></a>
                                        @endif

                                        @if(isAdmin())
                                        @if($result->status == 0)
                                          <div>
                                            <form action="{{ route('documents.destroy',$result->id) }}" method="POST">
                                           @csrf
                                           @method('DELETE')
      
                                          <button type="submit" class="fa fa-trash-o">Delete</button>
                                            </form>  
                                         </div>
                                          @endif
                                          @endif

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
    setPageUrl('/documents?');
  });
</script>
@endsection
