<?php 

	$store_subscription = $this->Mdl_common->get_store_subscription();
	$store_details = $this->Mdl_common->get_store_details();
?>

<style>
.nav-link {
	color: #343a40 !important;
}
.nav-header{
	color: #343942f0 !important;
}
.nav-link:hover {
    background-color: #007bff !important;
    color: #fff !important;
}

.nav-link.active {
    background-color: #007bff !important;
    color: #fff !important;
}
</style>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" onclick="side_bar()" data-widget="pushmenu" href="#"><i style="font-size: 25px;" class="fas fa-bars"></i></a>
      </li>
      
    </ul>
	
	<script>
		$( ".nav-link" ).click(function() {
			if($("body").hasClass("sidebar-collapse")){
				$( "body" ).removeClass( "sidebar-collapse" );
			}else{
				$( "body" ).addClass( "sidebar-collapse" );
			}
		});
	</script>

    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="onclick-load nav-link" href="<?php echo base_url(); ?>Login/logout">
          Logout
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #fff;">
    <!-- Brand Logo -->
	<?php $logo = $this->Mdl_common->get_logo(); ?>
    <a href="#" class="brand-link">
		<img src="<?php echo base_url(); ?>uploads/logo/<?php echo $logo->image; ?>" alt="Hereits" class="brand-image img-circle elevation-3"
           style="opacity: .8">
		<span class="brand-text font-weight-light" style="color: #343a40;"><?= $this->session->User->Store_name ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="<?php echo base_url(); ?>Store_dashboard" class="onclick-load nav-link <?php if( $main_content == 'Store_dashboard'){echo 'active';} ?>">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p> Dashboards 	</p>
					</a>
				</li>
				
				<?php 
				if($store_details->store_status == 1){
					if($store_subscription->type == 1 || $store_subscription->type == 3){ ?>
				
						<!-- store Product information -->
						<li class="nav-header">Product</li>
					
						<li class="nav-item">
							<a href="<?php echo base_url(); ?>Store_category/Product_category" class="onclick-load nav-link <?php if( $left_sidebar == 'Product_category'){echo 'active';} ?>">
								<i class="nav-icon fas fa-th-list"></i>
								<p> Product Categories </p>
							</a>
						</li>
						
						<li class="nav-item">
							<a href="<?php echo base_url(); ?>Store_products" class="onclick-load  nav-link <?php if( $main_content == 'Product_list' || $main_content == 'Product_add'){echo 'active';} ?>">
								<i class="nav-icon fas fa-box-open"></i>
								<p> Products </p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url(); ?>Store_Order" class="onclick-load nav-link <?php if( $main_content == 'Order_list'){echo 'active';} ?>">
								<i class="nav-icon fas fa-dolly"></i>
								<p> Orders </p>
							</a>
						</li>
						
						<!-- li class="nav-item has-treeview <?php if( $main_content == 'Coupons_List' || $main_content == 'Coupons_History' ){echo 'menu-open';} ?>">
							<a href="#" class="nav-link <?php if( $main_content == 'Coupons_List' || $main_content == 'Coupons_History'){echo 'active';} ?>">
								<i class="nav-icon fas fa-tachometer-alt"></i>
								<p> Orders <i class="right fas fa-angle-left"></i></p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="<?php echo base_url(); ?>Store_Order" class="nav-link <?php if( $main_content == 'Online_order_list'){echo 'active';} ?>">
										<i class="far fa-circle nav-icon"></i>
										<p>Online Orders</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?php echo base_url(); ?>Store_coupons/Coupons_history" class="nav-link <?php if( $main_content == 'Coupons_History'){echo 'active';} ?>">
										<i class="far fa-circle nav-icon"></i>
										<p>Ofline Orders</p>
									</a>
								</li>
							</ul>
						</li -->
						
						<li class="nav-item">
							<a href="<?php echo base_url(); ?>Store_Shippment" class="onclick-load nav-link <?php if( $main_content == 'Store_Shippment'){echo 'active';} ?>">
								<i class="nav-icon fas fa-truck"></i>
								<p> Shippment </p>
							</a>
						</li>
						
						<?php }else{ ?>
							<li class="nav-item">
							<a href="<?php echo base_url(); ?>Store_Plans" class="onclick-load nav-link" style="color: #007bff !important;">
								<i class="nav-icon fas fa-plus"></i>
								<p> List Products </p>
							</a>
						</li>
						<?php }
						if($store_subscription->type == 2 || $store_subscription->type == 3){ ?>
						
						<!-- store services information -->
						<li class="nav-header">Services</li>
						
						<li class="nav-item">
							<a href="<?php echo base_url(); ?>Store_category/service_category" class="onclick-load nav-link <?php if( $left_sidebar == 'service_category'){echo 'active';} ?>">
								<i class="nav-icon fas fa-th-list"></i>
								<p> Service Categories </p>
							</a>
						</li>
						
						<li class="nav-item">
							<a href="<?php echo base_url(); ?>Store_Packages" class="onclick-load nav-link <?php if( $main_content == 'Packages_list' || $main_content == 'Package_add' || $main_content == 'Package_edit'){echo 'active';} ?>">
								<i class="nav-icon fab fa-dropbox"></i>
								<p> Packages </p>
							</a>
						</li>
						
						<li class="nav-item">
							<a href="<?php echo base_url(); ?>Store_Booking" class="onclick-load nav-link <?php if( $main_content == 'Booking_list'){echo 'active';} ?>">
								<i class="nav-icon far fa-calendar-alt"></i>
								<p> Bookings </p>
							</a>
						</li>
						
						<li class="nav-item">
							<a href="<?php echo base_url(); ?>Store_service_charge" class="onclick-load nav-link <?php if( $main_content == 'service_charges'){echo 'active';} ?>">
								<i class="nav-icon fab fa-phabricator"></i>
								<p> Service Charges </p>
							</a>
						</li>
						
						<?php }else{ ?>
							<li class="nav-item">
							<a href="<?php echo base_url(); ?>Store_Plans" class="onclick-load nav-link" style="color: #007bff !important;">
								<i class="nav-icon fas fa-plus"></i>
								<p> List Services </p>
							</a>
						</li>
				<?php 
							}
					}
				?>
				
				<!-- store information -->
				<li class="nav-header">Store Info</li>
				
				<li class="nav-item">
					<a href="<?php echo base_url(); ?>Store_Timing" class="onclick-load nav-link <?php if( $main_content == 'Store_Timing'){echo 'active';} ?>">
						<i class="nav-icon fas fa-history"></i>
						<p> Store Timing </p>
					</a>
				</li>
				
				
				<!-- li class="nav-item">
					<a href="<?php echo base_url(); ?>Store_customers" class="nav-link <?php if( $main_content == 'Store_Customers'){echo 'active';} ?>">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p> Customers </p>
					</a>
				</li -->
				
				<?php if($store_details->store_status == 1){ ?>
					<li class="nav-item has-treeview <?php if( $main_content == 'Coupons_list' || $main_content == 'Coupons_History' ){echo 'menu-open';} ?>">
						<a href="#" class="nav-link <?php if( $main_content == 'Coupons_list' || $main_content == 'Coupons_History'){echo 'active';} ?>">
							<i class="nav-icon fas fa-tags"></i>
							<p> Coupons <i class="right fas fa-angle-left"></i></p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="<?php echo base_url(); ?>Store_Coupons" class="onclick-load nav-link <?php if( $main_content == 'Coupons_list'){echo 'active';} ?>">
									<i class="far fa-circle nav-icon"></i>
									<p>Coupons List</p>
								</a>
							</li>
							<!--li class="nav-item">
								<a href="<?php echo base_url(); ?>Store_coupons/Coupons_history" class="nav-link <?php if( $main_content == 'Coupons_History'){echo 'active';} ?>">
									<i class="far fa-circle nav-icon"></i>
									<p>Coupons History</p>
								</a>
							</li -->
						</ul>
					</li>
				<?php } ?>
				
				<li class="nav-item">
					<a href="<?php echo base_url(); ?>Store_Album" class="onclick-load nav-link <?php if( $main_content == 'album_list'){echo 'active';} ?>">
						<i class="nav-icon far fa-images"></i>
						<p> Album </p>
					</a>
				</li>
				
				<li class="nav-item">
					<a href="<?php echo base_url(); ?>Store_Follow" class="onclick-load nav-link <?php if( $main_content == 'Follow_list'){echo 'active';} ?>">
						<i class="nav-icon fas fa-user-check"></i>
						<p> Followers </p>
					</a>
				</li>
				
				<!--li class="nav-item">
					<a href="<?php echo base_url(); ?>Share_store" class="onclick-load nav-link<?php if( $main_content == 'Share_store_page'){echo 'active';} ?>">
						<i class="fas fa-share-square"></i>
						<p> Share Store </p>
					</a>
				</li-->
				
				<?php if($store_details->store_status == 1){ ?>
					<li class="nav-item">
						<a href="<?php echo base_url(); ?>Store_Plans" class="onclick-load nav-link <?php if( $main_content == 'Plan_list'){echo 'active';} ?>">
							<i class="nav-icon far fa-handshake"></i>
							<p> My Plan </p>
						</a>
					</li>
				<?php } ?>
				
				<li class="nav-item has-treeview <?php if( $main_content == 'Store_profile' || $main_content == 'Aboutus' || $main_content == 'Terms_Conditions' ){echo 'menu-open';} ?>">
					<a href="#" onclick="scrollup()" class="nav-link <?php if( $main_content == 'Store_profile' || $main_content == 'Aboutus' || $main_content == 'Terms_Conditions'){echo 'active';} ?>">
						<i class="nav-icon fas fa-cog"></i>
						<p > Setting <i class="right fas fa-angle-left"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url(); ?>Store_Profile" class="onclick-load nav-link <?php if( $main_content == 'Store_profile'){echo 'active';} ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Profile</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url(); ?>Store_Setting/Aboutus" class="onclick-load nav-link <?php if( $main_content == 'Aboutus'){echo 'active';} ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>About Us</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url(); ?>Store_Setting/Terms_Conditions" class="onclick-load nav-link <?php if( $main_content == 'Terms_Conditions'){echo 'active';} ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Terms & Conditions</p>
							</a>
						</li>
						
					</ul>
				</li>
				
<script>	
function scrollup(){
 window.scrollBy(0, 150);
 }
</script>				
				
				
				
				
				
			</ul>
		</nav>
    </div>
</aside>
<div class="content-wrapper">