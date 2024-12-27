<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Subscription Detail</h1>
			</div><!-- /.col -->
			<div class="col-sm-6 m-hide">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Home</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Subscription_management">Subscription_list</a></li>
					<li class="breadcrumb-item active"><?php echo $main_content; ?></li>
				</ol>
			</div>
        </div>
    </div>
</div>

<style>
	.product, .service {
		display: none;
	}
</style>

<section class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Subscription Information</h3>
					</div>
					<form id="coupons_detail" action="<?php echo base_url(); ?>Subscription_management/insert_package" method="POST" enctype="multipart/form-data">		
						<div class="card-body">
							<div class="row">
							
								<div class="col-sm-6">
									<div class="form-group">
										<label>Store Type <span class="error">*</span></label>
										<select class="form-control" onchange="type_hendel(this.value)" name="type" id="type" style="width: 100%;">
											<option value="">Select Store Type</option>
											<option value="1">Product</option>
											<option value="2">Services</option>
											<option value="3">Both</option>
											
										</select>
									</div>
								</div>
							
								<div class="col-sm-6">
									<div class="form-group">
										<label>Name <span class="error">*</span></label>
										<input type="text" name="name" class="form-control" placeholder="Name">
									</div>
								</div>
								
								<div class="col-sm-6 product">
									<div class="form-group">
										<label>Product Limit <span class="error">*</span></label>
										<input type="number" name="Product_Limit" id="Product_Limit" class="form-control" placeholder="Product Limit">
									</div>
								</div>
								
								<div class="col-sm-6 service">
									<div class="form-group">
										<label>package Limit <span class="error">*</span></label>
										<input type="number" name="package_Limit" id="package_Limit" class="form-control" placeholder="package Limit">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Stories <span class="error">*</span></label>
										<input type="number" name="Stories" id="Stories" class="form-control" placeholder="Stories">
									</div>
								</div>
								
								<div class="col-sm-6 product">
									<div class="form-group">
										<label>Product Feature <span class="error">*</span></label>
										<input type="number" name="Feature_Product" id="Feature_Product" class="form-control" placeholder="Product Feature">
									</div>
								</div>
								
								<div class="col-sm-12">
									<div class="form-group">
										<label>Description</label>
										<textarea name="Description" class="form-control" placeholder="Package Description"></textarea>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="Chat" id="Chat" value="1">
											<label for="Chat">
											Chat
											</label>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="Feature_Store" id="Feature_Store" value="1">
											<label for="Feature_Store">
											Feature Store
											</label>
										</div>
									</div>
								</div>
								
								
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="Verify_Batch" id="Verify_Batch" value="1">
											<label for="Verify_Batch">
											Verify Batch
											</label>
										</div>
									</div>
								</div>
								
								
								
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="Support" id="Support" value="1">
											<label for="Support">
											Support
											</label>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="Data_and_reporting" id="Data_and_reporting" value="1">
											<label for="Data_and_reporting">
												Data And Reporting
											</label>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="recommended" id="recommended" value="1">
											<label for="recommended">
												recommended
											</label>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="ads" id="ads" value="1">
											<label for="ads">
												Ads
											</label>
										</div>
									</div>
								</div>
								
							</div>
							
						
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</form>
				</div>
			</div>
        </div>
	</div>
</section>







<!-- validation -->
<script>
//validation
$('#coupons_detail').validate({
		rules:{
			type:{ required:true, },
			name:{ required:true, },
			Product_Limit:{ required:true, },
			package_Limit:{ required:true, },
			Stories:{ required:true, },
			Feature_Product:{ required:true, },
			
		},
		messages:{
			type: { required: 'Please Select Type.', },
			name: { required: 'Please Enter Name.', },
			Product_Limit: { required: 'Please Set Product Limit.', },
			package_Limit: { required: 'Please Set Package Limit.', },
			Stories: { required: 'Please Set Story Limit.', },
			Feature_Product: { required: 'Please Set Product Limit Limit.', },
			
			
		},
	}); 
	
</script>
<script>
	function type_hendel(type){
		//alert(type);
		if(type == 1){
			$('.service').hide();
			$('.product').show();
		}else if(type == 2){
			$('.product').hide();
			$('.service').show();
		}else if(type == 3){
			$('.product').show();
			$('.service').show();
		}else{
			$('.product').hide();
			$('.service').hide();
		}
	}
</script>
	

	