@extends('admin.layouts.layout')
@section('title', env('APP_GLOBAL_NAME'))
@section('content')
<link href="{{asset('packa/theme/dist/css/pages/dashboard4.css')}}" rel="stylesheet">

<style type="text/css">
   .round-custom {
   line-height: 48px;
   color: #736060;
   width: 50px;
   height: 50px;
   display: inline-block;
   text-align: center;
   font-size: 40px;
   }
   .round-custom i {
   color: #342e4c;
   }
</style>
<div class="page-wrapper">
   <!-- ============================================================== -->
   <!-- Container fluid  -->
   <!-- ============================================================== -->
   <div class="container-fluid">
      <!-- ============================================================== -->
      <!-- Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->
      <div class="row page-titles">
         <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Dashboard</h4>
         </div>
         <div class="col-md-7 align-self-center text-right">
         </div>
      </div>
      <!-- ============================================================== -->
      <!-- End Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Start Page Content -->
      <!-- ============================================================== -->
      @if(session()->has('success'))
      <div class="alert alert-success alert-rounded">
            {{session()->get('success')}}
      </div>
      @endif

      <div class="row">

         <div class="col-lg-12">
            <div class="row">
               @if(isAdmin())
                <!-- column -->
               <div class="col-md-3">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                           <span class="display-5 text-success"><i class="fa fa-users"></i></span>
                           <a href="{{url('users')}}" class="link display-5 ml-auto">{{$totalEmployeeCount}}</a>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- column -->
               <div class="col-md-3">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title">Active Users</h5>
                        <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                           <span class="display-5 text-primary"><i class="fa fa-user"></i></span>
                           <a href="{{url('users')}}" class="link display-5 ml-auto">{{$activeEmployeeCount}}</a>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- column -->
               <div class="col-md-3">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title">InActive Users</h5>
                        <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                           <span class="display-5 text-primary"><i class="fa fa-ban"></i></span>
                           <a href="{{url('users')}}" class="link display-5 ml-auto">{{$inActiveEmployeeCount}}</a>
                        </div>
                     </div>
                  </div>
               </div>
               @endif

               @if(isHud())
                <!-- column -->
               <div class="col-md-3">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title">Total Contacts</h5>
                        <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                           <span class="display-5 text-success"><i class="fa fa-users"></i></span>
                           <a href="{{url('contacts')}}" class="link display-5 ml-auto">{{$totalContactCount}}</a>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- column -->
               <div class="col-md-3">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title">Active Contacts</h5>
                        <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                           <span class="display-5 text-primary"><i class="fa fa-user"></i></span>
                           <a href="{{url('contacts')}}" class="link display-5 ml-auto">{{$activeContactCount}}</a>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- column -->
               <div class="col-md-3">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title">InActive Contacts</h5>
                        <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                           <span class="display-5 text-primary"><i class="fa fa-ban"></i></span>
                           <a href="{{url('contacts')}}" class="link display-5 ml-auto">{{$inActiveContactCount}}</a>
                        </div>
                     </div>
                  </div>
               </div>
               @endif

               <div class="col-md-3">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title">Total Documents</h5>
                        <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                           <span class="display-5 text-success"><i class="fa fa-file"></i></span>
                           <a href="{{url('documents')}}" class="link display-5 ml-auto">{{$documentCount}}</a>
                        </div>
                     </div>
                  </div>
               </div>

            </div>
         </div>

         @if(isAdmin() || isHud())
          <div class="col-lg-12">
            <br>
             <h4 class="card-title">Type of Documents</h4>
             <hr>
             <br>
            <div class="row">
               @foreach($navigationDocs as $index => $navDoc)
               <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10" style="background-color:{{getColorCode()}}">
                                    <h3 class="text-white box m-b-0"><i class="ti-file"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-5 text-danger">{{$navDoc->documents->count()}}</h3>
                                    @if(isAdmin())
                                    <a href="{{url('documents?navigation=').$navDoc->id}}">
                                       <h5 class="text-muted font-medium m-b-0">{{$navDoc->name}}</h5>
                                    </a>
                                    @endif
                                    
                                    @if(isHud())
                                    <h5 class="text-muted font-medium m-b-0">{{$navDoc->name}}</h5>
                                    @endif
                                 </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
            </div>
         </div>
         @endif


         @if(isAdmin() || isHud())
          <div class="col-lg-12">
            <br>
             <h4 class="card-title">Sections</h4>
             <hr>
             <br>
            <div class="row">
               @foreach($sectionDocs as $index => $tagDoc)
               <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10" style="background-color:{{getColorCode()}}">
                                    <h3 class="text-white box m-b-0"><i class="icon-tag"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-5 text-danger">{{$tagDoc->documents->count()}}</h3>
                                    @if(isAdmin())
                                    <a href="{{url('documents?section=').$tagDoc->id}}">
                                       <h5 class="text-muted font-medium m-b-0">{{$tagDoc->name}}</h5>
                                    </a>
                                    @endif
                                    @if(isHud())
                                    <h5 class="text-muted font-medium m-b-0">{{$tagDoc->name}}</h5>
                                    @endif
                                 </div>

                            </div>
                        </div>
                    </div>
                    @endforeach
            </div>
         </div>
         @endif


      </div>
      <!-- ============================================================== -->
      <!-- End PAge Content -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->                
   </div>
   <!-- ============================================================== -->
   <!-- End Container fluid  -->
   <!-- ============================================================== -->
</div>
<script src="{{asset('packa/theme/assets/node_modules/skycons/skycons.js')}}"></script>
@endsection
