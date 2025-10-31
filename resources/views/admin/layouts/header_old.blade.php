<header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{url('/dashboard')}}">
                        <!-- Logo icon --><b>
                            <!-- Dark Logo icon -->
                            <img src="{{logo()}}" alt="logo" class="dark-logo" style="width: 100px;height: 40px;padding-left: 10px;" />
                            <!-- Light Logo icon -->
                            <img src="{{logo()}}" alt="logo" class="light-logo" style="width: 100px;height: 40px;padding-left: 10px;"/>
                        </b>                        
                        
                    </a>

                </div>

                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse" style="margin-left: 50px">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                      
                    </ul>

                    <ul class="navbar-nav mr-auto">
                        <img src="{{headerLogo()}}" alt="logo" style="max-width: 100%;height: 60px;"/>
                    </ul>

                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                    
                        <!-- ============================================================== -->
                        <!-- User Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{userimage()}}" alt="user" class=""> <span class="hidden-md-down">{{ Auth::user()->name ?? '' }}  &nbsp;<i class="fa fa-angle-down"></i></span> </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <!-- text-->
                                @if(isHud())
                                 <a href="{{url('profile/update')}}" class="dropdown-item"><i class="fa fa-user"></i> Profile</a>
                                 <div class="dropdown-divider"></div>
                                @endif

                                <a href="{{route('password.manage')}}" class="dropdown-item"><i class="fa fa-unlock-alt"></i> Password</a>
                                
                                <div class="dropdown-divider"></div>
                                <!-- text-->
                                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> {{ __('Logout') }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                <!-- text-->
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End User Profile -->
                        <!-- ============================================================== -->
                       
                    </ul>
                </div>

            </nav>
        </header>
        
