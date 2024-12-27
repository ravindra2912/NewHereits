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
.booking_detail{
	margin: 0;
	display: flex;
	align-items: center;
	padding: 5px 0;
}
.booking_detail .key{
	width: 45%;
}
.booking_detail .lable{
	width: 5%;
	font-weight: 501;
}
.booking_detail .value{
	width: 50%;
	font-size: 14px;
	color: #000;
	font-family: "Roboto", sans-serif;
	font-weight: 501;
}

.booking_detail .order-number-text {
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
					<h3 class="card-title">Booking Detail</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body" style="display: block;">
					<div class="booking_detail">
						<span class="key">Booking Id</span>
						<span class="lable"> : </span>
						<span class="value order-number-text"> <?= $booking_details->booking_id ?> </span>
					</div>
					<div class="booking_detail">
						<span class="key">Booking Date & Time</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $booking_details->created_at_date ?> </span>
					</div>
					<div class="booking_detail">
						<span class="key">Service Type</span>
						<span class="lable"> : </span>
						<span class="value"> 
							<?php 
								if($booking_details->service_type == 1){
									echo 'At Service Provider Address';
								}else if($booking_details->service_type == 2){
									echo 'At Customer Address';
								}
							?>
						</span>
					</div>
					
					<div class="booking_detail">
						<span class="key">Customer Id </span>
						<span class="lable"> : </span>
						<a  href="<?= base_url().'User_management/edit_user/'.$booking_details->user_id ;?>" class="value order-number-text">#<?= $booking_details->user_id?></a>
					</div>
					<div class="booking_detail">
						<span class="key">Customer Username </span>
						<span class="lable"> : </span>
						<span class="value"><?= $booking_details->username?></span>
					</div>
					<div class="booking_detail">
						<span class="key">CustomerNname</span>
						<span class="lable"> : </span>
						<span class="value "><?= $booking_details->frist_name." ".$booking_details->last_name?></span>
					</div>
					<div class="booking_detail">
						<span class="key">Contact </span>
						<span class="lable"> : </span>
						<span class="value"><?= $booking_details->contact ?></span>
					</div>
					<div class="booking_detail">
						<span class="key">Email</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $booking_details->email ?> </span>
					</div>
					
					<div class="booking_detail">
						<span class="key">Payment Status</span>
						<span class="lable"> : </span>
						<span class="value"> 
							<?php 
								if($booking_details->payment_status == 1){
									echo 'COD';
								}
							?>
						</span>
					</div>
					<div class="booking_detail">
						<span class="key">Order Status</span>
						<span class="lable"> : </span>
						<span class="value">
									<select  onchange="Change_booking_status(<?= $booking_details->booking_id ?>)" name="booking_status" id="booking_status" class="custom-select custom-select-sm form-control form-control-sm">
									  <option value="">Select Status</option>
									  <option <?php if($booking_details->booking_status == 0){ echo 'selected';} ?> value="0">Pending for Approval</option>
									  <option <?php if($booking_details->booking_status == 1){ echo 'selected';} ?> value="1">Accept By Store</option>
									  <option <?php if($booking_details->booking_status == 2){ echo 'selected';} ?> value="2">Reject By Store</option>
									  <option <?php if($booking_details->booking_status == 3){ echo 'selected';} ?> value="3">Reject By Customer</option>
									  <option <?php if($booking_details->booking_status == 4){ echo 'selected';} ?> value="4"> OnGoing</option>
									  <option <?php if($booking_details->booking_status == 5){ echo 'selected';} ?> value="5">Return</option>
									  <option <?php if($booking_details->booking_status == 6){ echo 'selected';} ?> value="6">Service completed</option>
									  <option <?php if($booking_details->booking_status == 7){ echo 'selected';} ?> value="7">Cancel by Customer</option>
									  <option <?php if($booking_details->booking_status == 8){ echo 'selected';} ?> value="8">Cancel By Store</option>
									</select>
						</span>
					</div>
										
				</div>
			</div>
		</div>
		
		
		
		<div class="col-md-4">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Service Detail</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
				<?php if($booking_details->service_type == 1){ ?>
				<div class="card-body" style="display: block;">
					<div class="booking_detail">
						<span class="key">Service By</span>
						<span class="lable"> : </span>
						<span class="value "> 
							<?php
								if($booking_details->service_by == 1){
									echo 'Service by self';
								}else if($booking_details->service_by == 2){
									echo 'Service by other';
								}
							?>
						</span>
					</div>
					<div class="booking_detail">
						<span class="key">Name</span>
						<span class="lable"> : </span>
						<span class="value"><?= $booking_details->customer_name  ?></span>
					</div>
					<div class="booking_detail">
						<span class="key">Contact</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $booking_details->customer_contact  ?> </span>
					</div>
				</div>
				<?php } else if($booking_details->service_type == 2){ ?>
					<div class="card-body" style="display: block;">
					<div class="booking_detail">
						<span class="key">Name</span>
						<span class="lable"> : </span>
						<span class="value order-number-text"><?= $address->name ?></span>
					</div>
					<div class="booking_detail">
						<span class="key">Contact</span>
						<span class="lable"> : </span>
						<span class="value"><?= $address->contact ?></span>
					</div>
					<div class="booking_detail">
						<span class="key">Address</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $address->address1  ?>, <?= $address->address2  ?> </span>
					</div>
					<div class="booking_detail">
						<span class="key">city</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $address->city  ?> </span>
					</div>
					<div class="booking_detail">
						<span class="key">state</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $address->state  ?> </span>
					</div>
					<div class="booking_detail">
						<span class="key">country</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $address->country  ?> </span>
					</div>
					<div class="booking_detail">
						<span class="key">pincode</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $address->pincode  ?> </span>
					</div>
					<div class="booking_detail">
						<span class="key">address_type</span>
						<span class="lable"> : </span>
						<span class="value"> <?php if($address->address_type == 1){ echo "Home";} else if($address->address_type == 2){ echo "Office";} else if($address->address_type == 3){ echo "other";}  ?> </span>
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
					<div class="booking_detail" style="justify-content: center;">
						<img src="<?php echo base_url().$store->store_image; ?>" height="60" width="60" />
					</div>
					
					<div class="booking_detail">
						<span class="key">Name</span>
						<span class="lable"> : </span>
						<a  href="<?= base_url().'Store_management/single_store/'.$booking_details->store_id ;?>" class="value order-number-text"><?= $store->Store_name?></a>
					</div>
					<div class="booking_detail">
						<span class="key">Contact</span>
						<span class="lable"> : </span>
						<span class="value"><?= $store->store_contact ?></span>
					</div>
					<div class="booking_detail">
						<span class="key">Address</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $store->store_address." ".$store->store_address_2 ?> </span>
					</div>
					<div class="booking_detail">
						<span class="key">city</span>
						<span class="lable"> : </span>
						<span class="value"><?= $store->city ?> </span>
					</div>
					
					<div class="booking_detail">
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
					<h3 class="card-title">Booking Items</h3>
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
						<tbody style="text-align-last: center;">	
							<?php foreach($booking_details->Order_items as $val){ ?>
								<tr>
									<td><img src="<?php echo base_url().$val->packege_image; ?>" height="50" width="50" /></td>
									<td><?= $val->Package_name ?></td>
									<td><?= $val->booking_qty ?></td>
									<td><?= "₹ ".$val->item_amount ." /-"?></td>
								</tr>
							<?php
								$total += $val->booking_qty * $val->item_amount;
								} ?>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
		 
		<div class="col-md-4">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Booking Summury</h3>
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
								<td>Service Charge</td>
								<td><?php if($store->minimum_cart_amount < $total){
											$service_charges = 0;
											echo "₹ ".$service_charges;
										}else {
										$service_charges = $store->inspection_charge;
										 echo "₹ ".$service_charges;
									}
									?>
								</td>
							</tr>
							<tr>
								<td>Discount <?php if($booking_details->coupon_id != NULL){ echo '('.$booking_details->coupon_code.')';} ?></td>
								<td><?= "₹ ".$booking_details->coupon_amount ?></td>
							</tr>
							<tr>
								<td>Total Amount</td>
								<td><?= "₹ ".($total - $booking_details->coupon_amount + $service_charges) ." /-" ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
		
		
		
	</div>
</section>

<script>
	function pdf(booking_id){
		var status = $('#status').val();
		
		$.ajax({
				url:'<?= base_url() ?>Templates/service_pdf_invoice',
				method:"POST", 
				data:{ booking_id:booking_id },
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
	
	
	function Change_booking_status(booking_id){
		var booking_status = $('#booking_status').val();
		var result = confirm("Want to Change?");
		
		if (result) { 

			$.ajax({
				url:'<?= base_url() ?>Booking_management/Change_booking_status',
				method:"POST", 
				data:{ booking_status:booking_status, booking_id:booking_id },
				success:function(data)
				{  
					alertify.success("Status Update Successfully");
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
