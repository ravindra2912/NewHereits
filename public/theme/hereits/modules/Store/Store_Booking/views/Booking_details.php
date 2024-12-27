<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Booking Detail</h1>
			</div><!-- /.col -->
			<div class="col-sm-6 m-hide">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_dashboard">Home</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_Booking">Booking_list</a></li>
					<li class="breadcrumb-item active"><?php echo $main_content; ?></li>
				</ol>
			</div>
        </div>
    </div>
</div>

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
			<button class="btn btn-md btn-success" onclick="pdf(<?= $booking_detail->booking_id ?>)" style="float: right;">Invoice</button>
		</div>	
		<div class="col-md-4">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Booking Action</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body" style="display: block;">
					<div class="booking_detail" style="justify-content: center;">
					<?php
						if($booking_detail->booking_status == 0){ ?>
							<span class="key"><button type="button" class="btn btn-block btn-danger" onclick="Change_booking_status(2, <?= $booking_detail->booking_id ?>)">Reject</button></span>
							<span class="lable"> </span>
							<span class="value "> <button type="button" class="btn btn-block btn-success" onclick="Change_booking_status(1, <?= $booking_detail->booking_id ?>)">Accept</button> </span>
					<?php
						}else if($booking_detail->booking_status == 1){ ?>
							<span class="key"><button type="button" class="btn btn-block btn-danger" onclick="Change_booking_status(8, <?= $booking_detail->booking_id ?>)">Cancel</button></span>
							<span class="lable"> </span>
							<span class="value "> <button type="button" class="btn btn-block btn-success" onclick="Change_booking_status(4, <?= $booking_detail->booking_id ?>)">OnGoing</button> </span>
					<?php
						}else if($booking_detail->booking_status == 2){ ?>
							<h4 class="btn-outline-danger"> Reject By Store </h4>
					<?php
						}else if($booking_detail->booking_status == 3){ ?>
						<h4 class="btn-outline-danger"> Reject By Customer </h4>
					<?php
						}else if($booking_detail->booking_status == 4){ ?>
							<span class="key"><button type="button" class="btn btn-block btn-danger" onclick="Change_booking_status(8, <?= $booking_detail->booking_id ?>)">Cancel</button></span>
							<span class="lable"> </span>
							<span class="value "> <button type="button" class="btn btn-block btn-success" onclick="Change_booking_status(6, <?= $booking_detail->booking_id ?>)">Booking completed</button> </span>
					<?php
						}else if($booking_detail->booking_status == 5){ ?>
							<h4 class="btn-outline-danger"> Return </h4>
							
					<?php 
						}else if($booking_detail->booking_status == 6){ ?>
							<h4 class="btn-outline-success "> Booking Completed SuccessFully </h4>
					<?php 
						}else if($booking_detail->booking_status == 7){ ?>
						<h4 class="btn-outline-danger"> Booking Cancel by Customer </h4>
					<?php 
						}else if($booking_detail->booking_status == 8){ ?>
						<h4 class="btn-outline-danger"> Booking Cancel by Store </h4>
					<?php
						}
					?>
					
						
					</div>
					
				</div>
			</div>
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
						<span class="value order-number-text"> <?= $booking_detail->booking_id ?> </span>
					</div>
					<div class="booking_detail">
						<span class="key">Booking Date & Time</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $booking_detail->created_at_date ?> </span>
					</div>
					<div class="booking_detail">
						<span class="key">Service Type</span>
						<span class="lable"> : </span>
						<span class="value"> 
							<?php 
								if($booking_detail->service_type == 1){
									echo 'At Service Provider Address';
								}else if($booking_detail->service_type == 2){
									echo 'At Customer Address';
								}
							?>
						</span>
					</div>
					<div class="booking_detail">
						<span class="key">Payment Status</span>
						<span class="lable"> : </span>
						<span class="value"> 
							<?php 
								if($booking_detail->payment_status == 1){
									echo 'COD';
								}
							?>
						</span>
					</div>
					<div class="booking_detail">
						<span class="key">Order Status</span>
						<span class="lable"> : </span>
						<span class="value"> 
							<?php 
								if($booking_detail->booking_status == 0){
								   echo '<button type="button" class="btn btn-warning btn-xs">Pending For Approval</button>';
								}else if($booking_detail->booking_status == 1){
									echo '<button type="button" class="btn btn-success btn-xs">Accept By Store</button>';
								}else if($booking_detail->booking_status == 2){
									echo '<button type="button" class="btn btn-danger btn-xs">Reject By Store</button>';
								}else if($booking_detail->booking_status == 3){
									echo '<button type="button" class="btn btn-danger btn-xs">Reject By Customer</button>';
								}else if($booking_detail->booking_status == 4){
									echo '<button type="button" class="btn btn-info btn-xs">OnGoing</button>';
								}else if($booking_detail->booking_status == 5){
									echo '<button type="button" class="btn btn-danger btn-xs">Return</button>';
								}else if($booking_detail->booking_status == 6){
									echo '<button type="button" class="btn btn-success btn-xs">Booking completed</button>';
								}else if($booking_detail->booking_status == 7){
									echo '<button type="button" class="btn btn-danger btn-xs">Cancel by Customer</button>';
								}else if($booking_detail->booking_status == 8){
									echo '<button type="button" class="btn btn-danger btn-xs">Cancel By Store</button>';
								}
							?>
						</span>
					</div>
					<div class="booking_detail">
						<span class="key">Order Note</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $booking_detail->booking_note ?> </span>
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
				<?php if($booking_detail->service_type == 1){?>
				<div class="card-body" style="display: block;">
					<div class="booking_detail">
						<span class="key">Service By</span>
						<span class="lable"> : </span>
						<span class="value order-number-text"> 
							<?php
								if($booking_detail->service_by == 1){
									echo 'Service by self';
								}else if($booking_detail->service_by == 2){
									echo 'Service by other';
								}
							?>
						</span>
					</div>
					<div class="booking_detail">
						<span class="key">Name</span>
						<span class="lable"> : </span>
						<span class="value"><?= $booking_detail->customer_name  ?></span>
					</div>
					<div class="booking_detail">
						<span class="key">Contact</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $booking_detail->customer_contact  ?> </span>
					</div>
				</div>
				<?php }else if($booking_detail->service_type == 2){ ?>
					<div class="card-body" style="display: block;">
					<div class="booking_detail">
						<span class="key">Name</span>
						<span class="lable"> : </span>
						<span class="value order-number-text"><?= $booking_detail->address->name  ?></span>
					</div>
					<div class="booking_detail">
						<span class="key">Contact</span>
						<span class="lable"> : </span>
						<span class="value"><?= $booking_detail->address->contact ?></span>
					</div>
					<div class="booking_detail">
						<span class="key">Address</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $booking_detail->address->address1  ?>, <?= $booking_detail->address->address2  ?> </span>
					</div>
					<div class="booking_detail">
						<span class="key">city</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $booking_detail->address->city  ?> </span>
					</div>
					<div class="booking_detail">
						<span class="key">state</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $booking_detail->address->state  ?> </span>
					</div>
					<div class="booking_detail">
						<span class="key">country</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $booking_detail->address->country  ?> </span>
					</div>
					<div class="booking_detail">
						<span class="key">pincode</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $booking_detail->address->pincode  ?> </span>
					</div>
					<div class="booking_detail">
						<span class="key">address_type</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $booking_detail->address->address_type  ?> </span>
					</div>
				</div>
				<?php } ?>
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
						<tbody>	
							<?php foreach($booking_detail->Order_items as $val){ ?>
								<tr>
									<td><img src="<?php echo base_url().$val->packege_image; ?>" height="50" width="50" /></td>
									<td><?= $val->Package_name ?></td>
									<td><?= $val->booking_qty ?></td>
									<td><?= $val->item_amount ?></td>
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
								<td><?= $total ?></td>
							</tr>
							<tr>
								<td>Visiting Charge</td>
								<td><?= $booking_detail->service_charge ?></td>
							</tr>
							<tr>
								<td>Discount <?php if($booking_detail->coupon_id != NULL){ echo '('.$booking_detail->coupon_code.')';} ?></td>
								<td><?= $booking_detail->coupon_amount ?></td>
							</tr>
							<tr>
								<td>Total Amount</td>
								<td><?= $booking_detail->service_charge + ($total - $booking_detail->coupon_amount) ?></td>
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
	function Change_booking_status(booking_status, booking_id){
		if (booking_status == 2 || booking_status == 8 ){
			var result = prompt("Please enter Reason");
			if (result == "")
			{	
				 result = prompt("Please enter Reason");
				 var action = result;
				 
			}
			else {
				var action = result;
			}
		} else{
			var action = confirm("Want to Change?");
		}
		
		if (action) { 

			$.ajax({
				url:'<?= base_url() ?>Store_Booking/Change_booking_status',
				method:"POST", 
				data:{ booking_status:booking_status, booking_id:booking_id , action:action},
				success:function(data)
				{  
					alertify.success("Order Update Successfully");
					location.reload(); 
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
				} 
			});
		}
	}
</script>	











	

	