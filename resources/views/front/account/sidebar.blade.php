 <div class="col-lg-3 user-sidebar"> 
          <!-- Nav Link
          ============================================= -->
          <ul class="nav nav-pills alternate flex-lg-column sticky-top">
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('account.userprofile') || request()->routeIs('account.changePassword') ? 'active':''}}" href="{{ route('account.userprofile') }}"><i class="fas fa-user"></i>Personal Information</a></li>
          </ul>
          <!-- Nav Link end -->
        </div>