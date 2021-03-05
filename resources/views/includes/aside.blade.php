<!-- BEGIN .app-side -->
        <aside class="app-side" id="app-side">
          <!-- BEGIN .side-content -->
          <div class="side-content ">
            <!-- BEGIN .user-profile -->
            <div class="user-profile">
              <img src="{{url('upload/users/'.auth()->user()->image)}}" class="profile-thumb" alt="User Thumb">
              <h6 class="profile-name">{{auth()->user()->name}}</h6>
              <ul class="profile-actions">
                <li>
                  <a href="#">
                    <i class="icon-social-skype"></i>
                    <span class="count-label red"></span>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="icon-social-twitter"></i>
                  </a>
                </li>
                <li>
                  <a href="login.html">
                    <i class="icon-export"></i>
                  </a>
                </li>
              </ul>
            </div>
            <!-- END .user-profile -->
            <!-- BEGIN .side-nav -->
            <nav class="side-nav">
              <!-- BEGIN: side-nav-content -->
              <ul class="unifyMenu" id="unifyMenu">
                @if(auth()->user()->hasRole('super-admin'))
                <li class="{{ active_menu(['users','roles','permissions']) }}">
                  <a href="#" class="has-arrow" aria-expanded="false">
                    <span class="has-icon">
                      <span class="icon-user-tie"></span>
                    </span>
                    <span class="nav-title">Manage Users</span>
                  </a>
                  <ul aria-expanded="false">
                    <li>
                      <a href="{{url('users')}}" class="{{active_link('users')}}">Users</a>
                    </li>
                    <li>
                      <a href="{{url('roles')}}" class="{{active_link('roles')}}">Roles</a>
                    </li>
                    <li>
                      <a href="{{url('permissions')}}" class="{{active_link('permissions')}}">Permissions</a>
                    </li>
                  </ul>
                </li>
                <li class="{{ active_menu(['projects']) }}">
                  <a href="#" class="has-arrow" aria-expanded="false">
                    <span class="has-icon">
                      <span class="icon-cog"></span>
                    </span>
                    <span class="nav-title">Projects</span>
                  </a>
                  <ul aria-expanded="false">
                    <li>
                      <a href="{{url('projects')}}" class="{{active_link('projects')}}">projects</a>
                    </li>
                  </ul>
                </li>
                @endif
                @if(auth()->user()->hasRole('user'))
                <li class="{{ active_menu(['user-projects']) }}">
                  <a href="#" class="has-arrow" aria-expanded="false">
                    <span class="has-icon">
                      <span class="icon-cog"></span>
                    </span>
                    <span class="nav-title">Projects</span>
                  </a>
                  <ul aria-expanded="false">
                    <li>
                      <a href="{{url('user-projects')}}" class="{{active_link('user-projects')}}">projects</a>
                    </li>
                  </ul>
                </li>
                @endif
              </ul>
              <!-- END: side-nav-content -->
            </nav>
            <!-- END: .side-nav -->
          </div>
          <!-- END: .side-content -->
        </aside>
        <!-- END: .app-side -->