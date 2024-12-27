<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Report Detail</h1>
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
			<button class="btn btn-md btn-success" onclick="pdf(<?= $record->report_id; ?>)" style="float: right;">Invoice</button>
		</div>	
		<div class="col-md-4">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Report Detail</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
					<div class="card-body" style="display: block;">
					<div class="order_detail">
						<span class="key">Report Id</span>
						<span class="lable"> : </span>
						<span class="value order-number-text"> <?= $record->report_id; ?> </span>
					</div>
					<div class="order_detail">
						<span class="key">User</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $record->username; ?> </span>
					</div>
					<div class="order_detail">
						<span class="key">Store</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $store->Store_name ;?></span>
					</div>
					<div class="order_detail">
						<span class="key">Product</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $store->product_name; ?></span>
					</div>
					<div class="order_detail">
						<span class="key">Package</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $store->Package_name ?></span>
					</div>
					<div class="order_detail">
						<span class="key">Report type</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $type; ?></span>
					</div>
				</div>
				</div>
		</div>
		
	
		
		<div class="col-md-8">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Store Details</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body" style="display: block;">
					<table id="Product_table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="text-center">Store id</th>
								<th class="text-center">Image</th>
								<th class="text-center">Store Name</th>
								<th class="text-center">Contact</th>
								<th class="text-center">Email</th> 
							</tr>
						</thead>
						<tbody>	
								<tr>
									<td><?= $store->store_id ?></td>
									<td><img src="<?php echo base_url().$store->store_image; ?>" height="50" width="50" /></td>
									<td><?= $store->Store_name ?></td>
									<td><?= $store->store_contact ?></td>
									<td><?= $store->store_email ?></td>
								</tr>
						
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
		
		<div class="col-md-8">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Product Details</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body" style="display: block;">
					<table id="Product_table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="text-center">Product id</th>
								<th class="text-center">Product name</th>
								<th class="text-center">Store Name</th>
								<th class="text-center">Price</th>
								<th class="text-center">Sale Price</th> 
							</tr>
						</thead>
						<tbody>	
								<tr>
									<td><?= $store->product_id ?></td>
									<td><?= $store->product_name ?></td>
									<td><?= $store->Store_name ?></td>
									<td><?= $store->product_price ?></td>
									<td><?= $store->product_sele_price ?></td>
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
		var result = confirm("Want to Change?");
		if (result) { 

			$.ajax({
				url:'<?= base_url() ?>Store_Order/Change_order_status',
				method:"POST", 
				data:{ order_status:order_status, order_id:order_id },
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











	

	