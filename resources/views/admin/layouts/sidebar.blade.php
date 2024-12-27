<aside class="main-sidebar sidebar-light-primary elevation-1">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{ config('const.site_setting.small_logo') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">{{ config('const.site_setting.name') }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p> Dashboard </p>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="{{ route('admin.user.index') }}" class="nav-link {{ request()->routeIs('admin.user*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i>
            <p> Users </p>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="{{ route('admin.business.index') }}" class="nav-link {{ request()->routeIs('admin.business*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i>
            <p> Businesses </p>
          </a>
        </li>

        
        
        <li class="nav-item">
          <a href="{{ route('admin.lagel-pages') }}" class="nav-link {{ request()->routeIs('admin.lagel-pages*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-contract"></i>
            <p> Lagel Pages </p>
          </a>
        </li>

        <li class="nav-item {{ request()->routeIs('admin.setting*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('admin.setting*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Setting
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.setting.profile') }}" class="nav-link {{ request()->routeIs('admin.setting.profile*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profile</p>
                </a>
              </li>
              
            </ul>
          </li>
        
        <li class="nav-item">
          <a href="{{ route('admin.logout') }}"  class="nav-link">
            <i class="nav-icon fas fa-power-off"></i>
            <p> Logout </p>
          </a>
        </li>
       

        
        <!-- <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li> -->

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>