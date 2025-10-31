<aside class="left-sidebar">
   <!-- Sidebar scroll-->
   <div class="scroll-sidebar">
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav">
         <ul id="sidebarnav">
            <li> <a class="waves-effect waves-dark" href="{{url('/dashboard')}}"><i class="fa fa-home" aria-hidden="true"></i><span class="hide-menu">&nbsp;Dashboard</span></a>
            </li>

          <!--  <li> <a class="waves-effect waves-dark" href="{{url('/bulk-mailers')}}"><i class="fa fa-envelope" aria-hidden="true"></i><span class="hide-menu">&nbsp;Bulk Mailer</span></a>
            </li> -->

            


            @if(isAdmin())
            <li class="nav-small-cap">--- Manage</li>
            <li> <a class="waves-effect waves-dark" href="{{url('/users')}}"><i class="fa fa-users" aria-hidden="true"></i><span class="hide-menu">&nbsp;User</span></a>
            </li>
            @endif

            <li> <a class="waves-effect waves-dark" href="{{url('/documents')}}"><i class="fa fa-book" aria-hidden="true"></i><span class="hide-menu">&nbsp;Documents</span></a>
            </li>

            @if(isAdmin() || isHud())
             <li> <a class="waves-effect waves-dark" href="{{url('/contacts')}}"><i class="fa fa-users" aria-hidden="true"></i><span class="hide-menu">&nbsp;Contact</span></a>
            </li>
            @endif

             @if(isAdmin() || isHud())
            <li class="nav-small-cap">--- Masters</li>

            @if(isAdmin())
            <li> <a class="waves-effect waves-dark" href="{{url('/designations')}}"><i class="fa fa-user" aria-hidden="true"></i><span class="hide-menu">&nbsp;Designation</span></a>
            </li>

            <li> <a class="waves-effect waves-dark" href="{{url('/districts')}}"><i class="fa fa-database" aria-hidden="true"></i><span class="hide-menu">&nbsp;District</span></a>
            </li>

            <li> <a class="waves-effect waves-dark" href="{{url('/hw-location')}}"><i class="fa fa-heart" aria-hidden="true"></i><span class="hide-menu">&nbsp;Health Walk</span></a>
            </li>
            
            @endif
            


             <li> <a class="waves-effect waves-dark" href="{{url('/huds')}}"><i class="fa fa-database" aria-hidden="true"></i><span class="hide-menu">&nbsp;HUD</span></a>
            </li>

             <li> <a class="waves-effect waves-dark" href="{{url('/blocks')}}"><i class="fa fa-database" aria-hidden="true"></i><span class="hide-menu">&nbsp;Block</span></a>
            </li>

             <li> <a class="waves-effect waves-dark" href="{{url('/phc')}}"><i class="fa fa-database" aria-hidden="true"></i><span class="hide-menu">&nbsp;PHC</span></a>
            </li>

             <li> <a class="waves-effect waves-dark" href="{{url('/hsc')}}"><i class="fa fa-database" aria-hidden="true"></i><span class="hide-menu">&nbsp;HSC</span></a>
            </li>
            @endif


            @if(isAdmin())
             <li> <a class="waves-effect waves-dark" href="{{url('/facilitytypes')}}"><i class="fa fa-database" aria-hidden="true"></i><span class="hide-menu">&nbsp;Facility Type</span></a>
            </li>
           
            <li> <a class="waves-effect waves-dark" href="{{url('/testimonials')}}"><i class="fa fa-user" aria-hidden="true"></i><span class="hide-menu">&nbsp;Testimonial</span></a>
            </li> 

            <li> <a class="waves-effect waves-dark" href="{{url('/configurations')}}"><i class="fa fa-cog" aria-hidden="true"></i><span class="hide-menu">&nbsp;Configuration</span></a>
            </li> 
            @endif

            @if(isAdmin() || isHud())
            <li class="nav-small-cap">--- Reports</li>

            <li> <a class="waves-effect waves-dark" href="{{url('/reports')}}"><i class="fa fa-book" aria-hidden="true"></i><span class="hide-menu">&nbsp;Reports</span></a>
            </li>
            @endif



         </ul>
      </nav>
      <!-- End Sidebar navigation -->
   </div>
   <!-- End Sidebar scroll-->
</aside>
