<aside class="left-sidebar">
   <!-- Sidebar scroll-->
   <div class="scroll-sidebar">
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav">
         <ul id="sidebarnav">
            <li> <a class="waves-effect waves-dark" href="{{url('/dashboard')}}"><i class="fa fa-home" aria-hidden="true"></i><span class="hide-menu">&nbsp;Dashboard</span></a>
            </li>

            @if(Auth::user()->user_type_id != _employeeUserTypeId())
            <li class="nav-small-cap">--- Manage</li>
            <li> <a class="waves-effect waves-dark" href="{{url('/users')}}"><i class="fa fa-users" aria-hidden="true"></i><span class="hide-menu">&nbsp;Users</span></a>
            </li>
            @endif

            <li> <a class="waves-effect waves-dark" href="{{url('/documents')}}"><i class="fa fa-book" aria-hidden="true"></i><span class="hide-menu">&nbsp;Documents</span></a>
            </li>
         </ul>
      </nav>
      <!-- End Sidebar navigation -->
   </div>
   <!-- End Sidebar scroll-->
</aside>
