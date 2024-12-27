 <?php include 'header.html';?>
	
	<div class="container mt-4 mb-4">
      <div class="row">
		<!-- this for user sidebar -->
		<?php include 'user_sidebar.php';?>
		
        <div class="col-lg-9">
          <div class="  rounded"> 
            <!-- Personal Information
          ============================================= -->
			
            
			
                
				<div class="row pl-3 pr-3">
				  
					<div class="col-lg-12 rounded bg-white mb-3" >
						
						<div class="col-lg-12 bg-white rounded" >
							<div class="row">
								<div class="col-lg-12 mb-2 p-2 bg-white rounded" style="border-bottom: 1px solid rgba(0,0,0,.1);">
									<span class="text-3 font-weight-600 mb-0">Booking Information</span> 
								</div>
							</div> 
							
							<div class="row">
							  <p class="col-6 text-muted mb-0 mb-sm-3">Booking Id :</p>
							  <p class="col-6 text-right font-weight-500"><?= $booking_details->booking_id?></p>
							</div> 
							<div class="row">
							  <p class="col-6 text-muted mb-0 mb-sm-3">Payment Type :</p>
							  <p class="col-6 text-right font-weight-500"><?php if($booking_details->payment_type ==1){ echo "COD";} elseif($booking_details->payment_type ==2){ echo "CASH";}?></p>
							</div>            
							<div class="row">
							  <p class="col-6 text-muted mb-0 mb-sm-3">Delivery Type :</p>
							  <p class="col-6 text-right font-weight-500"><?php if($booking_details->service_type == 1){ echo "At Store";} elseif($booking_details->service_type == 2){ echo "At Your Address";}?></p>
							</div>
							<div class="row">
							  <p class="col-6 text-muted mb-0 mb-sm-3">Booking Status:</p>
							  <p class="col-6 text-right font-weight-500 text-info"><?php if($booking_details->booking_status == 0){ echo "Pending For Approval";}
						elseif($booking_details->booking_status ==1){ echo "Accept By Store";}
						elseif($booking_details->booking_status ==2){ echo "Reject By Store";}
						elseif($booking_details->booking_status ==3){ echo "Reject By Customer";}
						elseif($booking_details->booking_status ==4){ echo "OnGoing";}
						elseif($booking_details->booking_status ==5){ echo "Return";}
						elseif($booking_details->booking_status ==6){ echo "Service completed";}
						elseif($booking_details->booking_status ==7){ echo "Cancel by Customer";}
						elseif($booking_details->booking_status ==8){ echo "Cancel By Store";}?></p>
							</div>
							<div class="row">
							  <p class="col-6 text-muted mb-0 mb-sm-3">Booking On:</p>
							  <p class="col-6 text-right font-weight-500"><?= date("d/m/Y", strtotime($booking_details->service_date))?></p>
							</div>
								
						</div>
							
					</div>
					
					<div class="col-lg-12 rounded bg-white mb-3" >
						<div class="col-lg-12 bg-white rounded" >
							<div class="row">
								<div class="col-lg-12 mb-2 p-2 bg-white rounded" style="border-bottom: 1px solid rgba(0,0,0,.1);">
									<span class="text-3 font-weight-600 mb-0">Store Information</span> 
								</div>
							</div> 
							
							<div class="row">
								<div class="col-2 mb-0 mb-sm-3 text-center">
									<img class="img-fluid rounded align-top" src="<?= base_url().$booking_details->store_image?>" style="height: 55px; object-fit: contain;" alt="Store">
								</div>
								<div class="col-10">
									<p class="text-3 font-weight-600 mb-0"><?= $booking_details->Store_name?></p> 
									<p><?= $booking_details->store_address .','.$booking_details->city.','.$booking_details->state.'-'.$booking_details->pincode.','.$booking_details->country.'.'?></p>
								</div>
							</div> 
						</div>
					</div>
					<?php if($booking_details->service_type == 1){?>
					<div class="col-lg-12 rounded bg-white mb-3" >
						<div class="col-lg-12 bg-white rounded" >
							<div class="row">
								<div class="col-lg-12 mb-2 p-2 bg-white rounded" style="border-bottom: 1px solid rgba(0,0,0,.1);">
									<span class="text-3 font-weight-600 mb-0">Service Information</span> 
								</div>
								
								<div class="col-lg-12 mb-2 p-2 bg-white rounded" >
									<p class="text-3 font-weight-600 mb-0">Booked for : <?php if($booking_details->service_by == 1){ echo "Self";} elseif($booking_details->service_by == 2){ echo "Other";}?></p> 
									<p><?= $booking_details->customer_name  .' - '. $booking_details->customer_contact .'.' ?></p>
								</div>
							</div> 
						</div>
							
					</div>
					<?php }elseif($booking_details->service_type == 2){?>
					<div class="col-lg-12 rounded bg-white mb-3" >
						<div class="col-lg-12 bg-white rounded" >
							<div class="row">
								<div class="col-lg-12 mb-2 p-2 bg-white rounded" style="border-bottom: 1px solid rgba(0,0,0,.1);">
									<span class="text-3 font-weight-600 mb-0">Service Information</span> 
								</div>
								
								<div class="col-lg-12 mb-2 p-2 bg-white rounded" >
									<p class="text-3 font-weight-600 mb-0"><?= $booking_details->name .' - '. $booking_details->cust_contact?></p> 
									<p><?= $booking_details->address1 .','.$booking_details->address2.','.$booking_details->customer_city.','.$booking_details->customer_state.'-'.$booking_details->customer_pincode.','.$booking_details->customer_country.'.'?></p>
								</div>
							</div> 
						</div>
							
					</div>
					<?php } ?>
					<div class="col-lg-12 rounded bg-white mb-3" >
						
						<div class="col-lg-12 bg-white rounded" >
							<div class="row">
								<div class="col-lg-12 mb-2 p-2 bg-white rounded" style="border-bottom: 1px solid rgba(0,0,0,.1);">
									<span class="text-3 font-weight-600 mb-0">Items</span> 
								</div>
							</div> 
							<?php foreach($booking_items as $service){
								$item_total = $service->item_amount *$service->booking_qty;
								$total += $item_total;
								$item_count += 1;
								?>
							<div class="row">
							  <div class="col-4 mb-0 mb-sm-3 text-center">
								<img class="img-fluid rounded align-top" src="<?= base_url().$service->packege_image?>" style="height: 90px; object-fit: contain;" alt="Package">
							</div>
							  <div class="col-8">
								<p class="text-3 font-weight-600 mb-0"><?= $service->Package_name?></p> 
								<p class="mb-1">  
									<span class="text-black-50"><i class="fas fa-store pr-1"></i><?= $service->name?></span> 
								</p> 
								<p><span class="pr-2">Rs <?= $service->item_amount?></span><span>QTY : <?= $service->booking_qty?></span></p>
							  </div>
							</div>
							<?php } ?>
						</div>
					</div>
					
					<div class="col-lg-12 rounded bg-white mb-3" >
						
						<div class="col-lg-12 bg-white rounded" >
							<div class="row">
								<div class="col-lg-12 mb-2 p-2 bg-white rounded" style="border-bottom: 1px solid rgba(0,0,0,.1);">
									<span class="text-3 font-weight-600 mb-0">Price Details</span> 
								</div>
							</div> 
							
							<div class="row">
							  <p class="col-6 text-muted mb-0 mb-sm-3">Price(<?= $item_count?> item) </p>
							  <p class="col-6 text-right font-weight-500">Rs <?= $total?></p>
							</div> 
							<div class="row">
							  <p class="col-6 text-muted mb-0 mb-sm-3">Discount </p>
							  <p class="col-6 text-right font-weight-500">Rs <?= $booking_details->coupon_amount?></p>
							</div>            
							<div class="row">
							  <p class="col-6 text-muted mb-0 mb-sm-3">Service Charge </p>
							  <p class="col-6 text-right font-weight-500">Rs <?= $booking_details->service_charge?></p>
							</div>
							<div class="row" style="border-Top: 1px solid rgba(0,0,0,.1);">
							  <p class="col-6 text-muted mb-0 mb-sm-3 font-weight-600 text-4">Total Amount</p>
							  <p class="col-6 text-right font-weight-600 text-4">Rs <?php $final_amount = ($total-$booking_details->coupon_amount)+$booking_details->service_charge; echo $final_amount;?></p>
							</div>
						</div>
					</div>
					
					<div class="col-lg-12 mb-3" >
						<div class="row" >
							  <p class="col-6 mt-4 mb-0"><a href="recharge-payment.html" class="btn btn-primary btn-block">Invoice</a></p>
							  <?php if($booking_details->booking_status == 0 || $booking_details->booking_status ==1 ) {?>
								<p class="col-6 mt-4 mb-0"><button onclick="Booking_cancel()" class="btn btn-danger btn-block">Cancel Booking</button></p>
							  <? }?>	
						</div>
					</div>
					
					
					
					
					
                </div>
                  
              
          </div>
        </div>
      </div>
    </div>
<script>	
function Booking_cancel()
{
	var result = confirm("Are Your Sure ?, You want to delete Order?");
	if(result){
		location.href ="<?= base_url()?>Account/cancel_Booking/"+<?= $booking_details->booking_id?>;
	}
}

</script>	
	
	
