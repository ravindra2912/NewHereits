<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Plan Detail</h1>
			</div><!-- /.col -->
			<div class="col-sm-6 m-hide">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_dashboard">Home</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_Plans">Plan history</a></li>
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
		<!-- div class="col-md-12 mb-2">
			<button class="btn btn-md btn-success" onclick="pdf(<?= $store_sub->store_subscription_id ?>)" style="float: right;">Invoice</button>
		</div -->	
		
		
		<div class="col-md-4">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Plan Detail</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body" style="display: block;">
					<div class="order_detail">
						<span class="key">Subscription Id :</span>
						<span class="lable"> : </span>
						<span class="value order-number-text"> <?= $store_sub->store_subscription_id ?> </span>
					</div>
					<div class="order_detail">
						<span class="key">Duration</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $store_sub->duration ?> Months </span>
					</div>
					
					<div class="order_detail">
						<span class="key">Start Date</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $store_sub->plan_start_date ?></span>
					</div>
					<div class="order_detail">
						<span class="key">End Date</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $store_sub->plan_end_date ?></span>
					</div>
					
					<div class="order_detail">
						<span class="key">Payment Status</span>
						<span class="lable"> : </span>
						<span class="value"> 
							<?php 
								if($store_sub->payment_status == 1){
									echo 'Paid';
								}else if($store_sub->payment_status == 0){
									echo 'Pending';
								}else if($store_sub->payment_status == 2){
									echo 'failed';
								}
							?>
						</span>
					</div>
					
					<div class="order_detail">
						<span class="key">Order Status</span>
						<span class="lable"> : </span>
						<span class="value"> 
							<?php 
								if($store_sub->plan_status == 0){
								   echo '<button type="button" class="btn btn-warning btn-xs">Payment Pending</button>';
								}else if($store_sub->plan_status == 1){
									echo '<button type="button" class="btn btn-success btn-xs">Active</button>';
								}else if($store_sub->plan_status == 2){
									echo '<button type="button" class="btn btn-danger btn-xs">Expired</button>';
								}
							?>
						</span>
					</div>
									
				</div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Subscription Detail</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
								
					<div class="card-body" style="display: block;">
					<div class="order_detail">
						<span class="key">Name</span>
						<span class="lable"> : </span>
						<span class="value order-number-text"><?= $store_sub->name  ?></span>
					</div>
					<div class="order_detail">
						<span class="key">Description</span>
						<span class="lable"> : </span>
						<span class="value"><?= $store_sub->Description ?></span>
					</div>
					<div class="order_detail">
						<span class="key">Product / Package Limit</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $store_sub->Product_Limit ?> /  <?= $store_sub->package_Limit ?></span>
					</div>
					<div class="order_detail">
						<span class="key">Data and Reporting</span>
						<span class="lable"> : </span>
						<span class="value"> <?php if ($store_sub->Data_and_reporting == 1){ echo "Yes"; } else {echo "No";} ?> </span>
					</div>
					<div class="order_detail">
						<span class="key">Support</span>
						<span class="lable"> : </span>
						<span class="value"> <?php if ($store_sub->Support == 1){ echo "Yes"; } else {echo "No";} ?> </span>
					</div>
					<div class="order_detail">
						<span class="key">Ads</span>
						<span class="lable"> : </span>
						<span class="value"> <?php if ($store_sub->ads == 1){ echo "Yes"; } else {echo "No";} ?> </span>
					</div>
					<div class="order_detail">
						<span class="key">Type	</span>
						<span class="lable"> : </span>
						<span class="value"> <?php if ($store_sub->type == 1){ echo "Product"; } else if ($store_sub->type == 2){echo "Service";} else if ($store_sub->type == 3){echo "Both(Product & Service)";} ?> </span>
					</div>
					
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
								<td>Amount</td>
								<td> ₹ <?= number_format($store_sub->total_amount , 2); ?></td>
							</tr>
							<tr style="color: red;">
								<td>Discount</td>
								<td>- ₹ <?= number_format($store_sub->discount , 2); ?></td>
							</tr>
							<tr>
								<td>Tax</td>
								<td>₹ <?= number_format($store_sub->tex , 2); ?> </td>
							</tr>
							
							<tr>
								<td>Total Amount</td>
								<td>₹ <?= number_format(($store_sub->total_amount - $store_sub->discount) + $store_sub->tex , 2); ?> </td>
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
				//url:'<?= base_url() ?>Templates/product_pdf_invoice',
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
</script>	











	

	