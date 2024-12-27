<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Order Detail</h1>
			</div><!-- /.col -->
			<div class="col-sm-6 m-hide">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_dashboard">Home</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_Coupons">Order_list</a></li>
					<li class="breadcrumb-item active"><?php echo $main_content; ?></li>
				</ol>
			</div>
        </div>
    </div>
</div>

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
					<h3 class="card-title">Order Action</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body" style="display: block;">
					<div class="order_detail" style="justify-content: center;">
					<?php
						if($order_detail->order_status == 0){ ?>
							<span class="key"><button type="button" class="btn btn-block btn-danger" onclick="Change_order_status(2, <?= $order_detail->order_id ?>)">Reject</button></span>
							<span class="lable"> </span>
							<span class="value "> <button type="button" class="btn btn-block btn-success" onclick="Change_order_status(1, <?= $order_detail->order_id ?>)">Accept</button> </span>
					<?php
						}else if($order_detail->order_status == 1){ ?>
							<span class="key"><button type="button" class="btn btn-block btn-danger" onclick="Change_order_status(8, <?= $order_detail->order_id ?>)">Cancel</button></span>
							<span class="lable"> </span>
							<span class="value "> <button type="button" class="btn btn-block btn-success" onclick="Change_order_status(4, <?= $order_detail->order_id ?>)">Shipped</button> </span>
					<?php
						}else if($order_detail->order_status == 2){ ?>
							<h4 class="btn-outline-danger"> Reject By Store </h4>
					<?php
						}else if($order_detail->order_status == 3){ ?>
						<h4 class="btn-outline-danger"> Reject By Customer </h4>
					<?php
						}else if($order_detail->order_status == 4){ ?>
							<span class="key"><button type="button" class="btn btn-block btn-danger" onclick="Change_order_status(8, <?= $order_detail->order_id ?>)">Cancel</button></span>
							<span class="lable"> </span>
							<span class="value "> <button type="button" class="btn btn-block btn-success" onclick="Change_order_status(6, <?= $order_detail->order_id ?>)">Order completed</button> </span>
					<?php
						}else if($order_detail->order_status == 5){ ?>
							<h4 class="btn-outline-danger"> Order Return </h4>
							
					<?php 
						}else if($order_detail->order_status == 6){ ?>
							<h4 class="btn-outline-success "> Order Completed SuccessFully </h4>
					<?php 
						}else if($order_detail->order_status == 7){ ?>
						<h4 class="btn-outline-danger"> Order Cancel by Customer </h4>
					<?php 
						}else if($order_detail->order_status == 8){ ?>
						<h4 class="btn-outline-danger"> Order Cancel by Store </h4>
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
					<div class="order_detail">
						<span class="key">Order Status</span>
						<span class="lable"> : </span>
						<span class="value"> 
							<?php 
								if($order_detail->order_status == 0){
								   echo '<button type="button" class="btn btn-warning btn-xs">Pending For Approvel</button>';
								}else if($order_detail->order_status == 1){
									echo '<button type="button" class="btn btn-success btn-xs">Accept By Store</button>';
								}else if($order_detail->order_status == 2){
									echo '<button type="button" class="btn btn-danger btn-xs">Reject By Store</button>';
								}else if($order_detail->order_status == 3){
									echo '<button type="button" class="btn btn-danger btn-xs">Reject By Customer</button>';
								}else if($order_detail->order_status == 4){
									echo '<button type="button" class="btn btn-info btn-xs">Shipped</button>';
								}else if($order_detail->order_status == 5){
									echo '<button type="button" class="btn btn-danger btn-xs">Return</button>';
								}else if($order_detail->order_status == 6){
									echo '<button type="button" class="btn btn-success btn-xs">Order completed</button>';
								}else if($order_detail->order_status == 7){
									echo '<button type="button" class="btn btn-danger btn-xs">Cancel by Customer</button>';
								}else if($order_detail->order_status == 8){
									echo '<button type="button" class="btn btn-danger btn-xs">Cancel By Store</button>';
								}
							?>
						</span>
					</div>
					<div class="order_detail">
						<span class="key">Order Note</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $order_detail->order_note ?> </span>
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
						<span class="value"> 
							<?php
								if($order_detail->address->address_type == 1){
									echo "Home";
								}else if($order_detail->address->address_type == 2){
									echo "Office";
								}else if($order_detail->address->address_type == 3){
									echo "Other";
								}
							?>
						 </span>
					</div>
				</div>
				<?php } ?>
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
									<td><?= $val->item_amount ?></td>
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
								<td><?= $total ?></td>
							</tr>
							<tr>
								<td>Delivery Charge</td>
								<td><?= $order_detail->shipping_charge ?></td>
							</tr>
							<tr>
								<td>Discount <?php if($order_detail->coupon_id != NULL){ echo '('.$order_detail->coupon_code.')';} ?></td>
								<td><?php if($order_detail->coupon_id != NULL){ echo $order_detail->coupon_amount;}else{ echo '0'; } ?></td>
							</tr>
							<tr>
								<td>Total Amount</td>
								<td><?= $order_detail->shipping_charge + ($total - $order_detail->coupon_amount) ?></td>
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
	function Change_order_status(order_status, order_id){
		if (order_status == 2 || order_status == 8 ){
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
				url:'<?= base_url() ?>Store_Order/Change_order_status',
				method:"POST", 
				data:{ order_status:order_status, order_id:order_id ,action:action},
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











	

	