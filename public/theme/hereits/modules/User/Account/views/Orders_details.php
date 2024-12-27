 <?php include 'header.html';?>
		
	<div class="container mt-4 mb-4">
      <div class="row">
		<!-- this for user sidebar -->
		<?php include 'user_sidebar.php';?>
		
        <div class="col-lg-9">
          <div class="  rounded"> 
            <!-- order Information
          ============================================= -->
		
				<div class="row pl-3 pr-3">
				  
					<div class="col-lg-12 rounded bg-white mb-3" >
						
						<div class="col-lg-12 bg-white rounded" >
							<div class="row">
								<div class="col-lg-12 mb-2 p-2 bg-white rounded" style="border-bottom: 1px solid rgba(0,0,0,.1);">
									<span class="text-3 font-weight-600 mb-0">Order Information</span> 
								</div>
							</div> 
							
							<div class="row">
							  <p class="col-6 text-muted mb-0 mb-sm-3">Order Id :</p>
							  <p class="col-6 text-right font-weight-500"><?= $order_details->order_id?></p>
							</div> 
							<div class="row">
							  <p class="col-6 text-muted mb-0 mb-sm-3">Payment Type :</p>
							  <p class="col-6 text-right font-weight-500"><?php if($order_details->payment_type ==1){ echo "COD";} elseif($order_details->payment_type ==2){ echo "CASH";}?></p>
							</div>            
							<div class="row">
							  <p class="col-6 text-muted mb-0 mb-sm-3">Delivery Type :</p>
							  <p class="col-6 text-right font-weight-500"><?php if($order_details->delivery_type == 1){ echo "Pickup From Store";}elseif($order_details->delivery_type == 2){ echo "Home Delivery";}?></p>
							</div>
							<div class="row">
							  <p class="col-6 text-muted mb-0 mb-sm-3">Order Status:</p>
							  <p class="col-6 text-right font-weight-500 text-info">
							  <?php if($order_details->order_status == 0){ echo  "Pending For Approval";}
									elseif($order_details->order_status ==1){ echo "Accept By Store";}
									elseif($order_details->order_status ==2){ echo "Reject By Store";}
									elseif($order_details->order_status ==3){ echo "Reject By Customer";}
									elseif($order_details->order_status ==4){ echo "Shipped";}
									elseif($order_details->order_status ==5){ echo "Return";}
									elseif($order_details->order_status ==6){ echo "Order completed";}
									elseif($order_details->order_status ==7){ echo "Cancel by Customer";}
									elseif($order_details->order_status ==8){ echo "Cancel By Store";}?></p>
							</div>
							<div class="row">
							  <p class="col-6 text-muted mb-0 mb-sm-3">Order On:</p>
							  <p class="col-6 text-right font-weight-500"><?php echo date("d/m/Y", strtotime($order_details->created_at_date)); ?></p>
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
									<img class="img-fluid rounded align-top" src="<?= base_url().$order_details->store_image?>" style="height: 55px; object-fit: contain;" alt="Store">
								</div>
								<div class="col-10">
									<p class="text-3 font-weight-600 mb-0"><?= $order_details->Store_name?></p> 
									<p><?= $order_details->store_address .','.$order_details->city.','.$order_details->state.'-'.$order_details->pincode.','.$order_details->country.'.'?></p>
								</div>
							</div> 
						</div>
					</div>
					
					<?php if($order_details->delivery_type == 1){?>
					<div class="col-lg-12 rounded bg-white mb-3" >
						<div class="col-lg-12 bg-white rounded" >
							<div class="row">
								<div class="col-lg-12 mb-2 p-2 bg-white rounded" style="border-bottom: 1px solid rgba(0,0,0,.1);">
									<span class="text-3 font-weight-600 mb-0">Pickup Information</span> 
								</div>
								
								<div class="col-lg-12 mb-2 p-2 bg-white rounded" >
									<p class="text-3 font-weight-600 mb-0">Pickup By : <?php if($order_details->pickup_by == 1){ echo "Self";} elseif($order_details->pickup_by == 2){ echo "Other";}?></p> 
									<p><?= $order_details->pickup_name .' - '. $order_details->pickup_contact?></p>
								</div>
							</div> 
						</div>	
					</div>
					<?php } elseif($order_details->delivery_type == 2){?>
					<div class="col-lg-12 rounded bg-white mb-3" >
						<div class="col-lg-12 bg-white rounded" >
							<div class="row">
								<div class="col-lg-12 mb-2 p-2 bg-white rounded" style="border-bottom: 1px solid rgba(0,0,0,.1);">
									<span class="text-3 font-weight-600 mb-0">Shipping Information</span> 
								</div>
								
								<div class="col-lg-12 mb-2 p-2 bg-white rounded" >
									<p class="text-3 font-weight-600 mb-0"><?= $order_details->name .' - '. $order_details->customer_contact?></p> 
									<p><?= $order_details->address1 .','.$order_details->address2.','.$order_details->customer_city.','.$order_details->customer_state.'-'.$order_details->customer_pincode.','.$order_details->customer_country.'.'?></p>
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
							<?php foreach($order_items as $items){
								$p_img = $this->Mdl_Account->get_product_single_image($items->product_id);
								$img = base_url().$p_img->image_url;
								$item_total = $items->item_amount*$items->order_qty;
								$total += $item_total;
								$items_count += 1;
							?>
							<div class="row">
								<div class="col-4 col-lg-4 mb-0 mb-sm-3 text-center">
									<img class="img-fluid rounded align-top" src="<?= $img?>" style="height: 90px; object-fit: contain; width:100%" alt="Store">
								</div>
							
								<div class="col-8 col-lg-8">
									<p class="text-3 font-weight-600 mb-0"><?= $items->product_name?></p> 
									<p class="mb-1">  
										<span class="text-black-50"><i class="fas fa-store pr-1"></i> <?= $order_details->Store_name?></span> 
									</p> 
									<p><span class="pr-2">Rs <?= $items->item_amount?></span><span>QTY : <?= $items->order_qty?></span></p>
							  </div>
							<?php }?>
							</div>
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
							  <p class="col-6 text-muted mb-0 mb-sm-3">Price(<?= $items_count?> item) </p>
							  <p class="col-6 text-right font-weight-500">Rs <?= $total?></p>
							</div> 
							<div class="row">
							  <p class="col-6 text-muted mb-0 mb-sm-3">Discount </p>
							  <p class="col-6 text-right font-weight-500">Rs <?= $order_details->coupon_amount?></p>
							</div>            
							<div class="row">
							  <p class="col-6 text-muted mb-0 mb-sm-3">Delivery Charge </p>
							  <p class="col-6 text-right font-weight-500">Rs <?= $order_details->shipping_charge?></p>
							</div>
							<div class="row" style="border-Top: 1px solid rgba(0,0,0,.1);">
							  <p class="col-6 text-muted mb-0 mb-sm-3 font-weight-600 text-4">Total Amount</p>
							  <p class="col-6 text-right font-weight-600 text-4">Rs <?php $final_amount = ($total - $order_details->coupon_amount)+$order_details->shipping_charge; echo $final_amount;?></p>
							</div>
						</div>
					</div>
					
					<div class="col-lg-12 mb-3" >
						<div class="row" >
							  <p class="col-6 mt-4 mb-0"><a href="recharge-payment.html" class="btn btn-primary btn-block">Invoice</a></p>
							<?php if($order_details->order_status == 0 || $order_details->order_status ==1 ) {?>
								<p class="col-6 mt-4 mb-0"><button onclick="Order_cancel()" class="btn btn-danger btn-block">Cancel Order</button></p>
							<? }?>	
						</div>
					</div>
					
                </div>
                  
              
          </div>
        </div>
      </div>
    </div>
<script>	
function Order_cancel()
{
	var result = confirm("Are Your Sure ?, You want to delete Order?");
	if(result){
		location.href ="<?= base_url()?>Account/cancel_order/"+<?= $order_details->order_id?>;
	}
}

</script>