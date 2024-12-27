<div class="container mt-1 mb-4 ablack">
      <div class="row">
        <div class="col-lg-12 bg-white shadow-md rounded p-2 mb-2">
		
			<div class="row">
				<div class="col-lg-4 col-4 p-2 text-center">
					<img class="img-fluid rounded align-top" src="<?= base_url().$this->session->User->user_image ?>" style="height: 55px; object-fit: contain;" alt="Store">
				</div>
				<div class="col-lg-8 col-8 p-2">
					<p class="text-3 font-weight-600 mb-0"><?= $this->session->User->username ?></p> 
					<p><?= $this->session->User->email ?></p>
				</div>
			</div>
        </div>

		<div class="col-lg-12 bg-white shadow-md rounded p-2 mb-2">
		
			<a href="<?= base_url() ?>Account/My_profile" class="row pl-2 pr-2 pb-2" style="border-bottom: 1px solid rgba(0,0,0,.1);">
				<div class=" col-9 pl-4">
					<p class="text-2 font-weight-600 mb-0">My Profile</p> 
					<p class="text-1 mb-0">Change Profile Details</p>
				</div>
				<div class=" col-3 text-right" style="align-self: center;">
					<i class="fas fa-chevron-right"></i>
				</div>
			</a>
			
			<a href="<?= base_url() ?>Account/Address" class="row pl-2 pr-2 pb-2" style="border-bottom: 1px solid rgba(0,0,0,.1);">
				<div class=" col-9 pl-4">
					<p class="text-2 font-weight-600 mb-0">My Address</p> 
					<p class="text-1 mb-0">Change Your Address Details</p>
				</div>
				<div class=" col-3 text-right" style="align-self: center;">
					<i class="fas fa-chevron-right"></i>
				</div>
			</a>
			<!-- div class="row pl-2 pr-2 pb-2" style="border-bottom: 1px solid rgba(0,0,0,.1);">
				<div class=" col-10 pl-4">
					<p class="text-2 font-weight-600 mb-0">My Wishlist</p> 
					<p class="text-1 mb-0">You Most Loved Products, Stores And Services</p>
				</div>
				<div class=" col-2 text-right" style="align-self: center;">
					<i class="fas fa-chevron-right"></i>
				</div>
			</div -->
			<a href="<?= base_url() ?>Account/Orders" class="row pl-2 pr-2 pb-2" style="border-bottom: 1px solid rgba(0,0,0,.1);">
				<div class=" col-9 pl-4">
					<p class="text-2 font-weight-600 mb-0">My Order</p> 
					<p class="text-1 mb-0">Your Order History</p>
				</div>
				<div class=" col-3 text-right" style="align-self: center;">
					<i class="fas fa-chevron-right"></i>
				</div>
			</a>
			<a href="<?= base_url() ?>Account/Bookings" class="row pl-2 pr-2 pb-2" style="border-bottom: 1px solid rgba(0,0,0,.1);">
				<div class=" col-9 pl-4">
					<p class="text-2 font-weight-600 mb-0">My Booking</p> 
					<p class="text-1 mb-0">Your Booking History</p>
				</div>
				<div class=" col-3 text-right" style="align-self: center;">
					<i class="fas fa-chevron-right"></i>
				</div>
			</a>
			<a href="<?= base_url() ?>Login/logout" class="row pl-2 pr-2 pb-2" style="border-bottom: 1px solid rgba(0,0,0,.1);">
				<div class=" col-9 pl-4">
					<p class="text-2 font-weight-600 mb-0">Log Out</p> 
					<p class="text-1 mb-0">Log Out</p>
				</div>
				<div class=" col-3 text-right" style="align-self: center;">
					<i class="fas fa-chevron-right"></i>
				</div>
			</a>
			<!--div class="row pl-2 pr-2 pb-2">
				<div class=" col-9 pl-4">
					<p class="text-2 font-weight-600 mb-0">Following</p> 
					<p class="text-1 mb-0">Store You Following</p>
				</div>
				<div class=" col-3 text-right" style="align-self: center;">
					<i class="fas fa-chevron-right"></i>
				</div>
			</div -->
        </div>
      </div>
    </div>