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
      <!-- Custom CSS -->
      <link href="{{asset('packa/theme/dist/css/style.min.css')}}" rel="stylesheet">
      <script src="{{asset('packa/theme/assets/node_modules/jquery/jquery-3.2.1.min.js')}}"></script>
      <!-- Bootstrap tether Core JavaScript -->
      <script src="{{asset('packa/theme/assets/node_modules/popper/popper.min.js')}}"></script>
      <script src="{{asset('packa/theme/assets/node_modules/bootstrap/dist/js/bootstrap.min.js')}}"></script>      
      <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
       
    <script type="text/javascript" src="{{asset('packa/theme/dist/js/pages/toastr.js')}}"></script>
      <link href="{{asset('packa/theme/dist/css/pages/file-upload.css')}}" rel="stylesheet">
      <link href="{{asset('packa/theme/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('packa/theme/assets/node_modules/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('packa/theme/assets/node_modules/switchery/dist/switchery.min.css')}}" rel="stylesheet" />
      <link href="{{asset('packa/theme/assets/node_modules/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" />
      <link href="{{asset('packa/theme/assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" />
      <link href="{{asset('packa/theme/assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" />
      <link href="{{asset('packa/theme/assets/node_modules/multiselect/css/multi-select.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('packa/theme/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('packa/theme/assets/node_modules/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{asset('packa/theme/dist/css/pages/other-pages.css')}}" rel="stylesheet">
      <link href="{{asset('packa/custom/custom.css')}}" rel="stylesheet" type="text/css" />
          <link href="{{asset('packa/theme/dist/css/toastr.css')}}" rel="stylesheet" type="text/css" />
   </head>
   <body class="skin-megna fixed-layout">
      <!-- ============================================================== -->
      <!-- Preloader - style you can find in spinners.css -->
      <!-- ============================================================== -->
      <div class="preloader">
         <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">{{ env('APP_GLOBAL_NAME') }}</p>
         </div>
      </div>
      <!-- ============================================================== -->
      <!-- Main wrapper - style you can find in pages.scss -->
      <!-- ============================================================== -->      
      <div id="main-wrapper">
         <a href="" id="searchField" style="display:none;"></a>
         <!-- ============================================================== -->
         <!-- Topbar header - style you can find in pages.scss -->
         <!-- ============================================================== -->
         @include('admin.contacts-layouts.header')
         <!-- ============================================================== -->
         <!-- End Topbar header -->
         <!-- ============================================================== -->
         <!-- ============================================================== -->
         <!-- Left Sidebar - style you can find in sidebar.scss  -->
         <!-- ============================================================== -->

         <!-- ============================================================== -->
         <!-- End Left Sidebar - style you can find in sidebar.scss  -->
         <!-- ============================================================== -->
         <!-- ============================================================== -->
         <!-- Page wrapper  -->
         <!-- ============================================================== -->

         @yield('content')
         <!-- End Page wrapper  -->
         <!-- ============================================================== -->
         <!-- ============================================================== -->
         <!-- footer -->
         <!-- ============================================================== -->
         @include('admin.contacts-layouts.footer')
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
      <!-- slimscrollbar scrollbar JavaScript -->
      <script src="{{asset('packa/theme/dist/js/perfect-scrollbar.jquery.min.js')}}"></script>
      <!--Wave Effects -->
      <script src="{{asset('packa/theme/dist/js/waves.js')}}"></script>
      <!--Menu sidebar -->
      <script src="{{asset('packa/theme/dist/js/sidebarmenu.js')}}"></script>
      <!--stickey kit -->
      <script src="{{asset('packa/theme/assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
      <script src="{{asset('packa/theme/assets/node_modules/sparkline/jquery.sparkline.min.js')}}"></script>
      <!--Custom JavaScript -->
      <script src="{{asset('packa/theme/dist/js/custom.min.js')}}"></script>
      <script src="{{asset('packa/theme/dist/js/pages/jasny-bootstrap.js')}}"></script>
      <script src="{{asset('packa/theme/assets/node_modules/switchery/dist/switchery.min.js')}}"></script>
      <script src="{{asset('packa/theme/assets/node_modules/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>
      <script src="{{asset('packa/theme/assets/node_modules/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>
      <script src="{{asset('packa/theme/assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
      <script src="{{asset('packa/theme/assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js')}}" type="text/javascript"></script>
      <script src="{{asset('packa/theme/assets/node_modules/dff/dff.js')}}" type="text/javascript"></script>
      <script type="text/javascript" src="{{asset('packa/theme/assets/node_modules/multiselect/js/jquery.multi-select.js')}}"></script>
      <script type="text/javascript" src="{{asset('packa/theme/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('packa/theme/assets/node_modules/timepicker/bootstrap-timepicker.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('packa/theme/dist/js/waves.js')}}"></script>
      <script type="text/javascript" src="{{asset('packa/custom/custom.js')}}"></script>
      <script type="text/javascript" src="{{asset('packa/custom/admin.js')}}"></script>
      <script type="text/javascript" src="{{asset('packa/custom/datatable.js')}}"></script>
        
      <script>
         $(function () {
             // Switchery
             var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
             $('.js-switch').each(function () {
                 new Switchery($(this)[0], $(this).data());
             });
             // For select 2
             $(".select2").select2();
             $('.selectpicker').selectpicker();
             //Bootstrap-TouchSpin
             $(".vertical-spin").TouchSpin({
                 verticalbuttons: true
             });
         });
         
      </script>
   </body>
</html>
