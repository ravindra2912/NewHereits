<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>

   
  </nav>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
	<?php $logo = $this->Mdl_common->get_logo(); ?>
    <a href="index3.html" class="brand-link">
      <img src="<?php echo base_url(); ?>uploads/logo/<?php echo $logo->image; ?>" alt="Hereits" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Hereits</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>Dashboard" class="nav-link <?php if( $left_sidebar == 'Dashboard'){echo 'active';} ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboards
              </p>
            </a>
			</li>
			
			<li class="nav-item has-treeview <?php if( $main_content == 'Product_parent' || $main_content == 'Product_child'){echo 'menu-open';} ?>">
				<a href="#" class="nav-link <?php if( $main_content == 'Product_parent' || $main_content == 'Product_child'){echo 'active';} ?>">
					<i class="nav-icon fas fa-bars"></i>
					<p>
						Product Categories
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="<?php echo base_url(); ?>Category_management/Product_parent" class="nav-link <?php if( $main_content == 'Product_parent'){echo 'active';} ?>">
							<i class="far fa-circle nav-icon"></i>
							<p>Parent Category</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo base_url(); ?>Category_management/Product_child" class="nav-link <?php if( $main_content == 'Product_child'){echo 'active';} ?>">
							<i class="far fa-circle nav-icon"></i>
							<p>Child Category</p>
						</a>
					</li>
				</ul>
			</li>
			
			<li class="nav-item has-treeview <?php if( $main_content == 'Service_parent' || $main_content == 'Service_child'){echo 'menu-open';} ?>">
				<a href="#" class="nav-link <?php if( $main_content == 'Service_parent' || $main_content == 'Service_child'){echo 'active';} ?>">
					<i class="nav-icon fas fa-bars"></i>
					<p>
						Service Categories
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="<?php echo base_url(); ?>Category_management/Service_parent" class="nav-link <?php if( $main_content == 'Service_parent'){echo 'active';} ?>">
							<i class="far fa-circle nav-icon"></i>
							<p>Parent Category</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo base_url(); ?>Category_management/Service_child" class="nav-link <?php if( $main_content == 'Service_child'){echo 'active';} ?>">
							<i class="far fa-circle nav-icon"></i>
							<p>Child Category</p>
						</a>
					</li>
				</ul>
			</li>
			
			<li class="nav-item">
            <a href="<?php echo base_url(); ?>Store_management" class="nav-link <?php if( $main_content == 'Store_list' || $main_content == 'Store_Dashboard_view' || $main_content == 'single_Store'){echo 'active';} ?>">
              <i class="nav-icon fas fa-store"></i>
              <p>
                Store Management
              </p>
            </a>
			</li>
			
			<li class="nav-item">
            <a href="<?php echo base_url(); ?>User_management" class="nav-link <?php if( $main_content == 'user_list' || $main_content == 'User_Dashboard_view' || $main_content == 'user_update'){echo 'active';} ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                User Management
              </p>
            </a>
			</li>
			
			<li class="nav-item">
            <a href="<?php echo base_url(); ?>Product_management" class="nav-link <?php if( $main_content == 'Product_list' || $main_content == 'Product_details' || $main_content == 'Product_update'){echo 'active';} ?>">
              <i class="nav-icon fas fa-box-open"></i>
              <p>
               Product Management
              </p>
            </a>
			</li>
			
			<li class="nav-item">
            <a href="<?php echo base_url(); ?>Package_management" class="nav-link <?php if( $main_content == 'Package_list' || $main_content == 'Package_details' || $main_content == 'Package_update'){echo 'active';} ?>">
              <i class="nav-icon fas fa-box-open"></i>
              <p>
               Package Management
              </p>
            </a>
			</li>
			
			<li class="nav-item">
            <a href="<?php echo base_url(); ?>Referral_management" class="nav-link <?php if( $main_content == 'Referral_list' || $main_content == 'single_referral'){echo 'active';} ?>">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Referral Management
              </p>
            </a>
			</li>
			
			<li class="nav-item">
            <a href="<?php echo base_url(); ?>Booking_management" class="nav-link <?php if( $main_content == 'Booking_list' || $main_content == 'Booking_details'){echo 'active';} ?>">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Booking Management
              </p>
            </a>
			</li>
			
			<li class="nav-item">
            <a href="<?php echo base_url(); ?>Order_management" class="nav-link <?php if( $main_content == 'Online_order_list' || $main_content == 'Order_details'){echo 'active';} ?>">
              <i class="nav-icon fas fa-boxes"></i>
              <p>
                 Order Management
              </p>
            </a>
			</li> 

			<li class="nav-item">
            <a href="<?php echo base_url(); ?>Faq_management" class="nav-link <?php if( $main_content == 'Faq_list' || $main_content == 'Faq_add' || $main_content == 'faq_update'){echo 'active';} ?>">
              <i class="nav-icon fas fa-question-circle"></i>
              <p>
                FAQ Management
              </p>
            </a>
			</li>
			
			<li class="nav-item">
            <a href="<?php echo base_url(); ?>Fav_item_management" class="nav-link <?php if( $main_content == 'Fav_item_list'){echo 'active';} ?>">
              <i class="nav-icon fas fa-heart"></i>
              <p>
                 Favourite Item Management
              </p>
            </a>
			</li> 
		
			<li class="nav-item has-treeview <?php if( $main_content == 'Subscription_list' || $main_content == 'Subscription_add' || $main_content == 'Subscription_update' || $main_content == 'sub_Store_list' || $main_content == 'single_Store_sub' ){echo 'menu-open';} ?>">
				<a href="#" class="nav-link <?php if( $main_content == 'Subscription_list' || $main_content == 'Subscription_add' || $main_content == 'Subscription_update' || $main_content == 'sub_Store_list' || $main_content == 'single_Store_sub'){echo 'active';} ?>">
					<i class="nav-icon fas fa-handshake"></i>
					<p>
						Subscription management
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="<?php echo base_url(); ?>Subscription_management" class="nav-link <?php if( $main_content == 'Subscription_list'  || $main_content == 'Subscription_add' || $main_content == 'Subscription_update'){echo 'active';} ?>">
							<i class="far fa-circle nav-icon"></i>
							<p>Subscription Details</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo base_url(); ?>Subscription_management/store_sub_list" class="nav-link <?php if( $main_content == 'sub_Store_list' || $main_content == 'single_Store_sub'){echo 'active';} ?>">
							<i class="far fa-circle nav-icon"></i>
							<p>History</p>
						</a>
					</li>
				</ul>
			</li> 
		
			<li class="nav-item">
            <a href="<?php echo base_url(); ?>Follow_management" class="nav-link <?php if( $main_content == 'Follow_list'){echo 'active';} ?>">
              <i class="nav-icon fas fa-user-plus"></i>
              <p>
                 Follow Management
              </p>
            </a>
			</li>
			
			<li class="nav-item">
            <a href="<?php echo base_url(); ?>Profile" class="nav-link <?php if( $main_content == 'profile'){echo 'active';} ?>">
              <i class="nav-icon fas fa-user-edit"></i>
              <p>
                 profile Management
              </p>
            </a>
			</li> 
			
			<li class="nav-item">
            <a href="<?php echo base_url(); ?>Report_management" class="nav-link <?php if( $main_content == 'Report_list'){echo 'active';} ?>">
              <i class="nav-icon fas fa-file-signature"></i>
              <p>
                 Report Management
              </p>
            </a>
			</li> 
			
			<li class="nav-item has-treeview <?php if( $main_content == 'Aboutus' || $main_content == 'Terms_Conditions' || $main_content == 'Privacy_Policy' || $main_content == 'copyright_Policy' || $main_content == 'Site_setting' || $main_content == 'logo' ){echo 'menu-open';} ?>">
				<a href="#" class="nav-link <?php if( $main_content == 'Aboutus' || $main_content == 'Terms_Conditions' || $main_content == 'Privacy_Policy' || $main_content == 'copyright_Policy' || $main_content == 'Site_setting' || $main_content == 'logo'){echo 'active';} ?>">
					<i class="nav-icon fas fa-cog"></i>
					<p>
						Setting Management
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="<?php echo base_url(); ?>Setting_master/Aboutus" class="nav-link <?php if( $main_content == 'Aboutus'){echo 'active';} ?>">
							<i class="far fa-circle nav-icon"></i>
							<p>About Us</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo base_url(); ?>Setting_master/Terms_Conditions" class="nav-link <?php if( $main_content == 'Terms_Conditions'){echo 'active';} ?>">
							<i class="far fa-circle nav-icon"></i>
							<p>Terms Conditions</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo base_url(); ?>Setting_master/Privacy_policy" class="nav-link <?php if( $main_content == 'Privacy_Policy'){echo 'active';} ?>">
							<i class="far fa-circle nav-icon"></i>
							<p>Privacy Policy</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo base_url(); ?>Setting_master/copyright_Policy" class="nav-link <?php if( $main_content == 'copyright_Policy'){echo 'active';} ?>">
							<i class="far fa-circle nav-icon"></i>
							<p>copyright</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo base_url(); ?>Setting_master/site_setting" class="nav-link <?php if( $main_content == 'Site_setting'){echo 'active';} ?>">
							<i class="far fa-circle nav-icon"></i>
							<p>Site Setting</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo base_url(); ?>Logo" class="nav-link <?php if( $main_content == 'logo'){echo 'active';} ?>">
							<i class="far fa-circle nav-icon"></i>
							<p>Logo</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo base_url(); ?>Setting_master/Credits" class="nav-link <?php if( $main_content == 'Credits'){echo 'active';} ?>">
							<i class="far fa-circle nav-icon"></i>
							<p>Credits</p>
						</a>
					</li>
					 
				</ul>
			</li>
			
			<li class="nav-header">App Info</li>
			<li class="nav-item">
				<a href="<?php echo base_url(); ?>App_banner_management" class="nav-link <?php if( $main_content == 'App_banner'){echo 'active';} ?>">
				  <i class="nav-icon fas fa-images"></i>
				  <p>
					App Banner
				  </p>
				</a>
			</li>
			<li class="nav-item has-treeview <?php if( $main_content == 'Version_page'  ){echo 'menu-open';} ?>">
				<a href="#" class="nav-link <?php if( $main_content == 'Version_page' ){echo 'active';} ?>">
					<i class="nav-icon fas fa-cogs"></i>
					<p>
						App Setting
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="<?php echo base_url(); ?>Version_management" class="nav-link <?php if( $main_content == 'Version_page'){echo 'active';} ?>">
							<i class="far fa-circle nav-icon"></i>
							<p>App Version</p>
						</a>
					</li>
					
					 
				</ul>
			</li>
			
			
			
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <div class="content-wrapper">