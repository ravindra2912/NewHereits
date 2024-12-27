	
	<div class="container mt-4 mb-4">
      <div class="row">
		<!-- this for user sidebar -->
		<?php include 'user_sidebar.php';?>
		
        <div class="col-lg-9">
          <div class="  rounded"> 
            <!-- Personal Information
          ============================================= -->
			<div class="bg-white">
				<h4 class="pb-4 pt-4 pl-4">My Orders</h4>
			</div>
            
			
                
				<div class="row pl-3 pr-3 ablack">
				  
				  <?php foreach($order_details as $orders){
					  $get_store = $this-> Mdl_Account->get_single_store($orders->store_id);
					  
						if($orders->order_status == 0){ $status = "Pending For Approval";}
						elseif($orders->order_status ==1){ $status = "Accept By Store";}
						elseif($orders->order_status ==2){ $status = "Reject By Store";}
						elseif($orders->order_status ==3){ $status = "Reject By Customer";}
						elseif($orders->order_status ==4){ $status = "Shipped";}
						elseif($orders->order_status ==5){ $status = "Return";}
						elseif($orders->order_status ==6){ $status = "Order completed";}
						elseif($orders->order_status ==7){ $status = "Cancel by Customer";}
						elseif($orders->order_status ==8){ $status = "Cancel By Store";}

					  ?>
					<a href="<?= base_url() ?>Account/Orders_details/<?= $orders->order_id?>" class="col-lg-12 rounded bg-white mb-3" >
						<div class="row">
							<div class="col-lg-12 mb-2 p-2 bg-white rounded" style="border-bottom: 1px solid rgba(0,0,0,.1);">
								<span class="text-3 font-weight-600 mb-0">Order Id :- <?= $orders->order_id?></span> 
								<span class="p-1" style="float: right; border: 1px solid blue; color: blue; border-radius: 20px;"><?php if($orders->delivery_type == 1){ echo "Pickup From Store";}elseif($orders->delivery_type == 2){ echo "Home Delivery";}?></span>
							</div>
							<div class="col-lg-2 col-4 bg-white rounded text-center" style="border-bottom: 1px solid rgba(0,0,0,.1);">
								<img class="img-fluid rounded align-top" src="<?= base_url().$get_store->store_image?>" style="height: 55px;" alt="Store">
							</div>
							<div class="col-lg-10 col-8 bg-white rounded" style="border-bottom: 1px solid rgba(0,0,0,.1);">
								<p class="text-3 font-weight-600 mb-0"><?= $get_store->Store_name?></p> 
								<p><?= $get_store->store_address .','.$get_store->city.','.$get_store->state.'-'.$get_store->pincode.','.$get_store->country.'.'?></p>
							</div>
							<div class="col-lg-6 col-6 bg-white rounded text-center" >
								<p class="text-3 font-weight-600"><?= date_format(date_create($orders->created_at_date),"d/m/Y") ?></p> 
							</div>
							<div class="col-lg-6 col-6 bg-white rounded text-center" >
								<p class="text-info "> <?= $status?></p>
							</div>
							<!-- div class="col-lg-2 pl-2 pr-2  bg-white rounded text-center" >
								<p class="text-3 font-weight-600 mb-0">Sub Totle</p> 
								<p class="text-3 ">&#x20a8; 400</p> 
							</div>
							<div class="col-lg-8 pl-2 pr-2 bg-white rounded" >
								<p class="text-3 font-weight-600 mb-0">Quick Heal Anti Virus</p> 
							</div>
							<div class="col-lg-2 pl-2 pr-2 bg-white rounded" >
								<p class="text-3  mb-0">&#x20a8; 400 * 1</p> 
							</div -->
						</div>
					</a>
				  <?php } ?>	
					
                </div>
                  
              
          </div>
        </div>
      </div>
    </div>
	
	
	
