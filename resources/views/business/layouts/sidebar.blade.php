<aside class="main-sidebar sidebar-light-primary elevation-1">
  <!-- Brand Logo -->
  <div href="{{ route('business.dashboard') }}" class="brand-link">
    <img src="{{ isset(Auth::user()->getBusinessDetails) ? getImage(Auth::user()->getBusinessDetails->business_image):config('const.site_setting.small_logo') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">{{ isset(Auth::user()->getBusinessDetails) ? Auth::user()->getBusinessDetails->name:'' }}</span>
    <!-- <span><i class="fas fa-random float-right pr-2"></i></span> -->
    @if (isset(Auth::user()->getBusinesses) && count($businesses = Auth::user()->getBusinesses()->whereIn('status', ['active', 'pending'])->get()) > 1)
    <div class="btn-group float-right">
      <button type="button" title="Switch Business" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
        <span class="sr-only">Toggle Dropdown</span>
      </button>
      <div class="dropdown-menu" role="menu">
        @foreach ($businesses as $business)
        <a class="dropdown-item p-0 pr-1 overflow-hidden" href="{{ route('business.switchBusiness', $business->id) }}">
          <img src="{{ getImage($business->business_image) }}" alt="Logo" class="brand-image img-circle " style="height: 30px; width: 30px; object-fit: cover;">
          {{ $business->name }}
        </a>
        <div class="dropdown-divider"></div>
        @endforeach
      </div>
    </div>
    @endif
  </div>

  @php
  $businessSettings = getBusinessSettings();
  @endphp

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{ route('business.dashboard') }}" class="nav-link {{ request()->routeIs('business.dashboard*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p> Dashboard </p>
          </a>
        </li>

        <!-- <li class="nav-item">
          <a href="{{ route('admin.user.index') }}" class="nav-link {{ request()->routeIs('admin.user*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i>
            <p> Users </p>
          </a>
        </li> -->

        @if ($businessSettings->is_appointment_system)
        <li class="nav-header">APPOINTMENT</li>
        @if ($businessSettings->is_appointment_with_department)
        <li class="nav-item">
          <a href="{{ route('business.appointment.department.index') }}" class="nav-link {{ request()->routeIs('business.appointment.department*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-project-diagram"></i>
            <p> Department </p>
          </a>
        </li>
        @endif
        <li class="nav-item">
          <a href="{{ route('business.appointment.appointmenter.index') }}" class="nav-link {{ request()->routeIs('business.appointment.appointmenter*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-tie"></i>
            <p> Professionals </p>
          </a>
        </li>
        

        <li class="nav-item {{ request()->routeIs('business.appointment.bookings*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('business.appointment.bookings*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>
              Appointments
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('business.appointment.bookings.index') }}" class="nav-link {{ request()->routeIs('business.appointment.bookings.index') || request()->routeIs('business.appointment.bookings.edit') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>All</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('business.appointment.bookings.pending') }}" class="nav-link {{ request()->routeIs('business.appointment.bookings.pending') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Pending</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="{{ route('business.appointment.appointment-user.index') }}" class="nav-link {{ request()->routeIs('business.appointment.appointment-user*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p> Users </p>
          </a>
        </li>

        @endif

        <li class="nav-header">SITE SETTING</li>
        <li class="nav-item {{ request()->routeIs('business.setting*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('business.setting*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cog"></i>
            <p>
              Setting
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('business.setting.profile') }}" class="nav-link {{ request()->routeIs('business.setting.profile*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Owner profile</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('business.setting.business') }}" class="nav-link {{ request()->routeIs('business.setting.business') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Business Profile</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('business.setting.business.timing') }}" class="nav-link {{ request()->routeIs('business.setting.business.timing') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Timing</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('business.setting.business.plan') }}" class="nav-link {{ request()->routeIs('business.setting.business.plan') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Plan</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('business.setting.business.credit') }}" class="nav-link {{ request()->routeIs('business.setting.business.credit') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Credit</p>
              </a>
            </li>

          </ul>
        </li>

        <li class="nav-item">
          <a href="{{ route('business.logout') }}" class="nav-link">
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