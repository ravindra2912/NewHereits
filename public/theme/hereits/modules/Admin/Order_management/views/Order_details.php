<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $main_content; ?></li>
            </ol>
          </div>
        </div>
      </div>
</section>

<style>
.order_detail{
	margin: 0;
	display: flex;
	align-items: center;
	padding: 5px 0;
}
.order_detail .key{
	width: 45%;
}
.order_detail .lable{
	width: 5%;
	font-weight: 501;
}
.order_detail .value{
	width: 50%;
	font-size: 14px;
	color: #000;
	font-family: "Roboto", sans-serif;
	font-weight: 501;
}

.order_detail .order-number-text {
    width: unset;
    display: inline-block;
    background: #d3d3d3;
    padding: 3px 8px;
}




</style>

<section class="content">

	<div class="row">
		<div class="col-md-12 mb-2">
			<button class="btn btn-md btn-success" onclick="pdf(<?= $order_detail->order_id ?>)" style="float: right;">Invoice</button>
		</div>	
	
		
		<div class="col-md-4">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Order Detail</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body" style="display: block;">
					<div class="order_detail">
						<span class="key">Order Id</span>
						<span class="lable"> : </span>
						<span class="value order-number-text"> <?= $order_detail->order_id ?> </span>
					</div>
					<div class="order_detail">
						<span class="key">Order Date & Time</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $order_detail->created_at ?> </span>
					</div>
					
					<div class="order_detail">
						<span class="key">Customer Id </span>
						<span class="lable"> : </span>
						<a  href="<?= base_url().'User_management/edit_user/'.$order_detail->user_id ;?>" class="value order-number-text">#<?= $order_detail->user_id?></a>
					</div>
					<div class="order_detail">
						<span class="key">Customer Username </span>
						<span class="lable"> : </span>
						<span class="value"><?= $order_detail->username?></span>
					</div>
					<div class="order_detail">
						<span class="key">Customer Name</span>
						<span class="lable"> : </span>
						<span class="value "><?= $order_detail->frist_name." ".$order_detail->last_name?></span>
					</div>
					<div class="order_detail">
						<span class="key">Contact </span>
						<span class="lable"> : </span>
						<span class="value"><?= $order_detail->contact ?></span>
					</div>
					<div class="order_detail">
						<span class="key">Email</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $order_detail->email ?> </span>
					</div>
					
					<div class="order_detail">
						<span class="key">Delivery Type</span>
						<span class="lable"> : </span>
						<span class="value"> 
							<?php 
								if($order_detail->delivery_type == 1){
									echo 'Pickup At Store';
								}else if($order_detail->delivery_type == 2){
									echo 'Home Delivery';
								}
							?>
						</span>
					</div>
					<div class="order_detail">
						<span class="key">Payment Status</span>
						<span class="lable"> : </span>
						<span class="value"> 
							<?php 
								if($order_detail->payment_status == 1){
									echo 'COD';
								}
							?>
						</span>
					</div>
					<div class="booking_detail">
						<span class="key">Order Status</span>
						<span class="lable"> : </span>
						<span class="value">
									<select  onchange="Change_booking_status(<?= $order_detail->order_id ?>)" name="order_status" id="order_status" class="custom-select custom-select-sm form-control form-control-sm">
									  <option value="">Select Status</option>
									  <option <?php if($order_detail->order_status == 0){ echo 'selected';} ?> value="0">Pending for Approval</option>
									  <option <?php if($order_detail->order_status == 1){ echo 'selected';} ?> value="1">Accept By Store</option>
									  <option <?php if($order_detail->order_status == 2){ echo 'selected';} ?> value="2">Reject By Store</option>
									  <option <?php if($order_detail->order_status == 3){ echo 'selected';} ?> value="3">Reject By Customer</option>
									  <option <?php if($order_detail->order_status == 4){ echo 'selected';} ?> value="4"> OnGoing</option>
									  <option <?php if($order_detail->order_status == 5){ echo 'selected';} ?> value="5">Return</option>
									  <option <?php if($order_detail->order_status == 6){ echo 'selected';} ?> value="6">Service completed</option>
									  <option <?php if($order_detail->order_status == 7){ echo 'selected';} ?> value="7">Cancel by Customer</option>
									  <option <?php if($order_detail->order_status == 8){ echo 'selected';} ?> value="8">Cancel By Store</option>
									</select>
						</span>
					</div>			
					
					
				</div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Delivery Detail</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
				<?php if($order_detail->delivery_type == 1){?>
				<div class="card-body" style="display: block;">
					<div class="order_detail">
						<span class="key">Pickup By</span>
						<span class="lable"> : </span>
						<span class="value order-number-text"> 
							<?php
								if($order_detail->pickup_by == 1){
									echo 'Pickup by self';
								}else if($order_detail->pickup_by == 2){
									echo 'pickup by other';
								}
							?>
						</span>
					</div>
					<div class="order_detail">
						<span class="key">Name</span>
						<span class="lable"> : </span>
						<span class="value"><?= $order_detail->pickup_name  ?></span>
					</div>
					<div class="order_detail">
						<span class="key">Contact</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $order_detail->pickup_contact  ?> </span>
					</div>
				</div>
				<?php }else if($order_detail->delivery_type == 2){ ?>
					<div class="card-body" style="display: block;">
					<div class="order_detail">
						<span class="key">Name</span>
						<span class="lable"> : </span>
						<span class="value order-number-text"><?= $order_detail->address->name  ?></span>
					</div>
					<div class="order_detail">
						<span class="key">Contact</span>
						<span class="lable"> : </span>
						<span class="value"><?= $order_detail->address->contact ?></span>
					</div>
					<div class="order_detail">
						<span class="key">Address</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $order_detail->address->address1  ?>, <?= $order_detail->address->address2  ?> </span>
					</div>
					<div class="order_detail">
						<span class="key">city</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $order_detail->address->city  ?> </span>
					</div>
					<div class="order_detail">
						<span class="key">state</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $order_detail->address->state  ?> </span>
					</div>
					<div class="order_detail">
						<span class="key">country</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $order_detail->address->country  ?> </span>
					</div>
					<div class="order_detail">
						<span class="key">pincode</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $order_detail->address->pincode  ?> </span>
					</div>
					<div class="order_detail">
						<span class="key">address_type</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $order_detail->address->address_type  ?> </span>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Store Detail</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
				
				<div class="card-body" style="display: block;">
					<div class="order_detail" style="justify-content: center;">
						<img src="<?php echo base_url().$store->store_image; ?>" height="60" width="60" />
					</div>
					
					<div class="order_detail">
						<span class="key">Name</span>
						<span class="lable"> : </span>
						<a  href="<?= base_url().'Store_management/single_store/'.$order_detail->store_id ;?>" class="value order-number-text"><?= $store->Store_name?></a>
					</div>
					<div class="order_detail">
						<span class="key">Contact</span>
						<span class="lable"> : </span>
						<span class="value"><?= $store->store_contact ?></span>
					</div>
					<div class="order_detail">
						<span class="key">Address</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $store->store_address." ".$store->store_address_2 ?> </span>
					</div>
					<div class="order_detail">
						<span class="key">city</span>
						<span class="lable"> : </span>
						<span class="value"><?= $store->city ?> </span>
					</div>
					
					<div class="order_detail">
						<span class="key">Email</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $store->store_email  ?> </span>
					</div>
					
				</div>
			</div>
		</div>
		
		<div class="col-md-8">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Order Items</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body" style="display: block;">
					<table id="Product_table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="text-center">Image</th>
								<th class="text-center">Name</th>
								<th class="text-center">Qty</th>
								<th class="text-center">Price</th>
							</tr>
						</thead>
						<tbody>	
							<?php foreach($order_detail->Order_items as $val){ ?>
								<tr>
									<td><img src="<?php echo base_url().$val->images; ?>" height="50" width="50" /></td>
									<td><?= $val->product_name ?></td>
									<td><?= $val->order_qty ?></td>
									<td><?= "₹ ".$val->item_amount." /_" ?></td>
								</tr>
							<?php
								$total += $val->order_qty * $val->item_amount;
								} ?>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Order Summury</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body" style="display: block;">
					<table id="Product_table" class="table">
						<tbody>	
							<tr>
								<td>Total</td>
								<td><?= "₹ ".$total ?></td>
							</tr>
							<tr>
								<td>Delivery Charge</td>
								<td><?php if($store->minimum_cart_amount < $total){
											$Delivery_charges = 0;
											echo "₹ ".$Delivery_charges;
										}else {
										$Delivery_charges = $store->inspection_charge;
										 echo "₹ ".$Delivery_charges;
									}
									?>
								</td>
							</tr>
							<tr>
								<td>Discount <?php if($order_detail->coupon_id != NULL){ echo '('.$order_detail->coupon_code.')';} ?></td>
								<td><?php if($order_detail->coupon_id != NULL){ echo "₹ ".$order_detail->coupon_amount;}else{ echo "₹ ".'0'; } ?></td>
							</tr>
							<tr>
								<td>Total Amount</td>
								<td><?= "₹ ".($total - $order_detail->coupon_amount+ $Delivery_charges)." /-" ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
		
		
		
	</div>
</section>

<script>
	function pdf(order_id){
		$.ajax({
				url:'<?= base_url() ?>Templates/product_pdf_invoice',
				method:"POST", 
				data:{ order_id:order_id },
				success:function(data)
				{  
					//alert(data);
					window.location.href = data;
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
				} 
			});
	}
	
	function Change_booking_status(order_id){
		var order_status = $('#order_status').val();
		var result = confirm("Want to Change?");
		
		if (result) { 

			$.ajax({
				url:'<?= base_url() ?>Order_management/Change_order_status',
				method:"POST", 
				data:{ order_status:order_status, order_id:order_id },
				success:function(data)
				{  
					alertify.success("Order Update Successfully");
					location.reload(); 
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					console.log(e);
				} 
			});
		}
	}
</script>	











	

	