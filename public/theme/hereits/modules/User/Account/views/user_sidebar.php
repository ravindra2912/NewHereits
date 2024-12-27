 <div class="col-lg-3 user-sidebar"> 
          <!-- Nav Link
          ============================================= -->
          <ul class="nav nav-pills alternate flex-lg-column sticky-top">
            <li class="nav-item"><a class="nav-link <?php if($main_content == 'my_profile' || $main_content == 'Reset_password'){echo 'active';} ?>" href="<?= base_url() ?>Account/My_profile"><i class="fas fa-user"></i>Personal Information</a></li>
            <li class="nav-item"><a class="nav-link <?php if($main_content == 'Address'){echo 'active';} ?>" href="<?= base_url() ?>Account/Address"><i class="fas fa-bookmark"></i>My Address</a></li>
            <li class="nav-item"><a class="nav-link <?php if($main_content == 'Orders' || $main_content == 'Orders_details'){echo 'active';} ?>" href="<?= base_url() ?>Account/Orders"><i class="fas fa-bookmark"></i>My Order</a></li>
            <li class="nav-item"><a class="nav-link <?php if($main_content == 'Bookings' || $main_content == 'Booking_details'){echo 'active';} ?>" href="<?= base_url() ?>Account/Bookings"><i class="fas fa-bookmark"></i>My Booking</a></li>
          </ul>
          <!-- Nav Link end -->
        </div>