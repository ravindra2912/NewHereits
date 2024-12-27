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
					<form id="coupons_detail" action="<?php echo base_url(); ?>Subscription_management/upadate_package" method="POST" enctype="multipart/form-data">		
						<div class="card-body">
							<div class="row">
							
								<input type="hidden" name="subscription_id" id="subscription_id" value="<?= $package_data->subscription_id ?>" >
							
								<div class="col-sm-6">
									<div class="form-group">
										<label>Store Type <span class="error">*</span></label>
										<select class="form-control" name="type" id="type" onchange="type_hendel(this.value)" style="width: 100%;">
											<option value="" >Select Store Type</option>
											<option value="1" <?php if($package_data->type == 1 ){ echo "selected"; } ?>>Product</option>
											<option value="2" <?php if($package_data->type == 2 ){ echo "selected"; } ?>>Services</option>
											<option value="3" <?php if($package_data->type == 3 ){ echo "selected"; } ?>>Both</option>
											
										</select>
									</div>
								</div>
							
								<div class="col-sm-6">
									<div class="form-group">
										<label>Name <span class="error">*</span></label>
										<input type="text" name="name" class="form-control" value="<?= $package_data->name ?>" placeholder="Name">
									</div>
								</div>
								
								<div class="col-sm-6 product">
									<div class="form-group">
										<label>Product Limit <span class="error">*</span></label>
										<input type="number" value="<?= $package_data->Product_Limit ?>" name="Product_Limit" id="Product_Limit" class="form-control" placeholder="Product Limit">
									</div>
								</div>
								
								<div class="col-sm-6 service">
									<div class="form-group">
										<label>package Limit <span class="error">*</span></label>
										<input type="number" value="<?= $package_data->package_Limit ?>" name="package_Limit" id="package_Limit" class="form-control" placeholder="package Limit">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Stories <span class="error">*</span></label>
										<input type="number" value="<?= $package_data->Stories ?>" name="Stories" id="Stories" class="form-control" placeholder="Stories">
									</div>
								</div>
								
								<div class="col-sm-6 product">
									<div class="form-group">
										<label>Product Feature <span class="error">*</span></label>
										<input type="number" value="<?= $package_data->Feature_Product ?>" name="Feature_Product" id="Feature_Product" class="form-control" placeholder="Product Feature">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Status <span class="error">*</span></label>
										<select class="form-control" name="status" id="status" style="width: 100%;">
											<option value="" >Select Status</option>
											<option value="0" <?php if($package_data->status == 0 ){ echo "selected"; } ?>>In-Active</option>
											<option value="1" <?php if($package_data->status == 1 ){ echo "selected"; } ?>>Active</option>
											
										</select>
									</div>
								</div>
								
								<style>
									.line{display:block; margin:25px}
									.line h2{font-size:20px; text-align:center; border-bottom:1px solid; position:relative; }
									.line h2 span { background-color: white; position: relative; top: 10px; padding: 0 10px;}
								</style>
								
								<div class="col-sm-12" >
									<span class="line">
										<h2><span>Plans</span></h2>
									</span>
								</div>
								
								<div class="col-sm-12" >
									<a href="#" class="btn btn-md btn-success" data-toggle="modal" data-target="#add_model" style="float: right;"><i class="fas fa-plus" style="font-size: 15px;"></i> Add</a>
								</div>
								<div class="col-sm-12" style="padding: 6px;margin: 15px 0px 15px 0px;">
									<div class="row" id="plans_list">
				
										
									</div>
								</div>
								
								
								
								<div class="col-sm-12">
									<div class="form-group">
										<label>Package Description</label>
										<textarea name="Description" class="form-control" placeholder="Package Description"><?= $package_data->Description ?></textarea>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="Chat" <?php if($package_data->Chat == 1 ){ echo "checked"; } ?> id="Chat" value="1">
											<label for="Chat">
											Chat
											</label>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="Feature_Store" <?php if($package_data->Feature_Store == 1 ){ echo "checked"; } ?> id="Feature_Store" value="1">
											<label for="Feature_Store">
											Feature Store
											</label>
										</div>
									</div>
								</div>
								
								
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="Verify_Batch" <?php if($package_data->Verify_Batch == 1 ){ echo "checked"; } ?> id="Verify_Batch" value="1">
											<label for="Verify_Batch">
											Verify Batch
											</label>
										</div>
									</div>
								</div>
								
								
								
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="Support" <?php if($package_data->Support == 1 ){ echo "checked"; } ?> id="Support" value="1">
											<label for="Support">
											Support
											</label>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="Data_and_reporting" <?php if($package_data->Data_and_reporting == 1 ){ echo "checked"; } ?> id="Data_and_reporting" value="1">
											<label for="Data_and_reporting">
												Data_and_reporting
											</label>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="recommended" <?php if($package_data->recommended == 1 ){ echo "checked"; } ?> id="recommended" value="1">
											<label for="recommended">
												recommended
											</label>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="ads" <?php if($package_data->ads == 1 ){ echo "checked"; } ?> id="ads" value="1">
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

<!-- Add Plan Modal -->
<div class="modal fade" id="add_model" >
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
		  <form id="insert" method="POST" enctype="multipart/form-data" >
		  <input type="hidden" name="subscription_id" value="<?= $package_data->subscription_id ?>" >
            <div class="modal-header">
              <h4 class="modal-title">Add Subscription Plans</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
                <div class="card-body">
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Package duration <span class="error">*</span></label>
								<select class="form-control" name="month" id="month" style="width: 100%;" required>
									<option value="">Select Package duration</option>
									<?php
										for($i=1;$i<=24;$i++){
											echo '<option value="'.$i.'">'.$i.' Month</option>';
										}
									?>
									
								</select>
							</div>
						</div>
						
						<div class="col-sm-4">
							<div class="form-group">
								<label>Amount <span class="error">*</span></label>
								<input type="number" name="amount" id="amount" class="form-control" placeholder="Amount" required>
							</div>
						</div>
						
						<div class="col-sm-4">
							<div class="form-group">
								<label>Offer(%) <span class="error">*</span></label>
								<input type="number" name="discount" id="discount" class="form-control" placeholder="offer (%)">
							</div>
						</div>
				
					</div>
                </div>
				
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
			 </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>






<script>
	
var insert = 0;
	//Insert Service Parent Category
	$(document).ready(function (e) {
	 $("#insert").on('submit',(function(e) {
	  e.preventDefault();
	  if ($( "#insert" ).validate().valid() && insert == 0) {
		  $.ajax({
			url: '<?php echo base_url(); ?>Subscription_management/add_package_plans',
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			beforeSend : function(){ 
				insert = 1;
			},
			success: function(data){
				//alert(data);
				$('#add_model').modal('hide');
				insert = 0;
				get_data();
			},
			error: function(e){ 
				alertify.error("Somthing Wrong");
			}           
		});
	  }
	 }));
	});
	
	get_data();
	function get_data(){
		//alert(pagno);
		var subscription_id = $('#subscription_id').val();
		$.ajax({
				url:'<?php echo base_url(); ?>Subscription_management/get_package_plans',
				//method:"POST", 
				type: 'POST',
				data:{ subscription_id:subscription_id }, 
				success:function(response)
				{  
					//alert(response); 
					$('#plans_list').html(response);
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
				} 
			});
	}	
	
	function delete_plan(month){
		//alert(pagno);
		if (confirm("Want To Delete This!")) {
			var subscription_id = $('#subscription_id').val();
			$.ajax({
				url:'<?php echo base_url(); ?>Subscription_management/delete_package_plans',
				//method:"POST", 
				type: 'POST',
				data:{ subscription_id:subscription_id, month:month }, 
				success:function(response)
				{  
					//alert(response); 
					$('#'+month+subscription_id).remove();
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
				} 
			});
		}
	}	
</script>

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
			status:{ required:true, },
			
		},
		messages:{
			type: { required: 'Please Select Type.', },
			name: { required: 'Please Enter Name.', },
			Product_Limit: { required: 'Please Set Product Limit.', },
			package_Limit: { required: 'Please Set Package Limit.', },
			Stories: { required: 'Please Set Story Limit.', },
			Feature_Product: { required: 'Please Set Product Limit Limit.', },
			status: { required: 'Please Select Status.', },
			
			
		},
	}); 
	
</script>
<script>
	type_hendel(<?= $package_data->type ?>);
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
	

	