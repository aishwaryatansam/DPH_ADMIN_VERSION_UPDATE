<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- Tell the browser to be responsive to screen width -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta content="{{url('/')}}" name="base_url" />
      <meta content="{{url()->current()}}" name="current_url" />
      <!-- Favicon icon -->
      <link rel="icon" type="image/png" sizes="16x16" href="{{favicon()}}">
      <title>{{ siteName() }}</title>

      <!-- Fonts -->
      <script src="{{asset('packa/theme/dist/js/pages/webfont.min.js')}}"></script>
      <script>
         WebFont.load({
               google: { families: ["Public Sans:300,400,500,600,700"] },
               custom: {
                  families: [
                     "Font Awesome 5 Solid",
                     "Font Awesome 5 Regular",
                     "Font Awesome 5 Brands",
                     "simple-line-icons",
                  ],
                  urls: ["{{ asset('packa/theme/dist/css/fonts.min.css') }}"],
               },
               active: function () {
                  sessionStorage.fonts = true;
               },
         });
      </script>

      <!-- Custom CSS -->
      <script src="{{asset('packa/theme/assets/node_modules/jquery/jquery-3.7.1.min.js')}}"></script>
      <link rel="stylesheet" href="{{asset('packa/theme/dist/css/bootstrap.min.css')}}" />
      <link rel="stylesheet" href="{{asset('css/custom.css')}}" />
      <link rel="stylesheet" href="{{asset('packa/theme/dist/css/plugins.min.css')}}" />
      <link rel="stylesheet" href="{{asset('packa/theme/dist/css/dphadmin.min.css')}}" />
      <!-- Bootstrap tether Core JavaScript -->
      <script src="{{asset('packa/theme/dist/js/pages/popper.min.js')}}"></script>
      <link href="{{asset('packa/theme/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
      <script src="{{asset('packa/theme/dist/js/pages/bootstrap.min.js')}}"></script>      
      <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
      <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
      <script type="text/javascript" src="{{asset('packa/theme/dist/js/pages/toastr.js')}}"></script>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@latest/font/bootstrap-icons.css" rel="stylesheet">
      <link href="{{asset('packa/theme/dist/css/toastr.css')}}" rel="stylesheet" type="text/css" />

       <!-- Datatables -->
       <script src="{{asset('packa/theme/dist/js/pages/datatables.min.js')}}"></script>
       
      <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
      <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
      <script src="https://cdn.tiny.cloud/1/yrfe44o4ubo8p3n8eabqspla5mve0inqt8tepene2fdn3qnk/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>


      {{-- select2 --}}

      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
   </head>
   <body>
      <!-- ============================================================== -->
      <!-- Preloader - style you can find in spinners.css -->
      <!-- ============================================================== -->
      {{-- <div class="preloader">
         <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">{{ env('APP_GLOBAL_NAME') }}</p>
         </div>
      </div> --}}
      <!-- ============================================================== -->
      <!-- Main wrapper - style you can find in pages.scss -->
      <!-- ============================================================== -->      
      <div class="wrapper">
         <a href="" id="searchField" style="display:none;"></a>
         <!-- ============================================================== -->
         <!-- ============================================================== -->
         <!-- Left Sidebar - style you can find in sidebar.scss  -->
         <!-- ============================================================== -->
         @include('admin.layouts.navigation')
         <!-- ============================================================== -->
         <!-- End Left Sidebar - style you can find in sidebar.scss  -->
         <!-- ============================================================== -->
         <div class="main-panel">
            <!-- Topbar header - style you can find in pages.scss -->
            <!-- ============================================================== -->
            @include('admin.layouts.header')
            <!-- ============================================================== -->
            <!-- End Topbar header -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Page wrapper  -->
            @yield('content')
            <!-- ============================================================== -->  
         </div>
         <!-- ============================================================= -->
         @include('admin.common.modal')
         @include('admin.common.toastr')
         <!-- End Page wrapper  -->
         <!-- ============================================================== -->
         <!-- ============================================================== -->
         <!-- footer -->
         <!-- ============================================================== -->
         {{-- @include('admin.layouts.footer') --}}
         <!-- ============================================================== -->
         <!-- End footer -->
         <!-- ============================================================== -->
      </div>
      <!-- ============================================================== -->
      <!-- End Wrapper -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- All Jquery -->
      <!-- ============================================================== -->
      <script src="{{asset('packa/custom/status-text.js')}}"></script>
      <script src="{{asset('packa/custom/custom.js')}}"></script>
      <script src="{{asset('packa/custom/datatable.js')}}"></script>
  
      <script type="text/javascript" src="{{asset('packa/theme/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
      <!-- jQuery Scrollbar -->
      <script src="{{asset('packa/theme/dist/js/pages/jquery.scrollbar.min.js')}}"></script>
      <!-- Chart JS -->
      <script src="{{asset('packa/theme/assets/node_modules/Chart.js/Chart.min.js')}}"></script>
      <!-- Chart Circle -->
      <script src="{{asset('packa/theme/dist/js/pages/circles.min.js')}}"></script>
     
      <!-- Bootstrap Notify -->
      <script src="{{asset('packa/theme/dist/js/pages/bootstrap-notify.min.js')}}"></script>
      <!-- Sweet Alert -->
      <script src="{{asset('packa/theme/dist/js/pages/sweetalert.min.js')}}"></script>
      <!-- Kaiadmin JS -->
      <script src="{{asset('packa/theme/dist/js/pages/kaiadmin.min.js')}}"></script>
      {{-- select2 --}}
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
   </body>
</html>
