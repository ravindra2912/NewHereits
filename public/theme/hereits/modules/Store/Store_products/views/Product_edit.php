<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Product Detail</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_dashboard">Home</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_products">Products_list</a></li>
					<li class="breadcrumb-item active"><?php echo $main_content; ?></li>
				</ol>
			</div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-warning">
					<div class="card-header">
						<h3 class="card-title">Product Information</h3>
					</div>
					<div class="card-body">
						<form id="product_detail" action="<?php echo base_url(); ?>Store_products/update_product" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="product_id" id="product_id" value="<?= $product_data->product_id ?>" />
							<div class="row">
							
								<div class="col-sm-6">
									<div class="form-group">
										<label>Product Name</label>
										<input type="text" value="<?= $product_data->product_name ?>" name="product_name" id="product_name" class="form-control" placeholder="Product Name">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Product Quantity</label>
										<input type="text" value="<?= $product_data->product_qty ?>" name="product_qty" id="product_qty" class="form-control" placeholder="Product Quantity">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Brand Name</label>
										<input type="text" value="<?= $product_data->brand_name ?>" name="brand_name" id="brand_name" class="form-control" >
									</div>
								</div>
								
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Product Price</label>
										<input type="text" value="<?= $product_data->product_price ?>" name="product_price" id="product_price" class="form-control" placeholder="Product Price">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Product Sele Price</label>
										<input type="text" value="<?= $product_data->product_sele_price ?>" name="product_sele_price" id="product_sele_price" class="form-control" placeholder="Product Sele Price">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Parent Category</label>
										<select onchange="get_child_category(this.value)" class="form-control select2" name="product_parent_category" id="product_parent_category" style="width: 100%;">
											<option value="">Select Parent Category</option>
											<?php
												foreach($parent_cat_data as $val){
													echo '<option value="'.$val->category_id.'"'; if($product_data->product_parent_category == $val->category_id){echo 'selected';} echo '>'.$val->category_name.'</option>';
												}
											?>
										</select>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Child Category</label>
										<select class="form-control select2" name="product_child_category" id="product_child_category" style="width: 100%;">
											<option value="">Select Child Category</option>
											<?php
												foreach($child_cat_data as $val){
													echo '<option value="'.$val->category_id.'"'; if($product_data->product_child_category == $val->category_id){echo 'selected';} echo '>'.$val->category_name.'</option>';
												}
											?>
											
										</select>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Status</label>
										<select class="form-control select2" name="product_status" id="product_status" style="width: 100%;">
											<option value="">Status</option>
											<option value="1" <?php if($product_data->product_status == 1){echo 'selected';} ?>>Active</option>
											<option value="0" <?php if($product_data->product_status == 0){echo 'selected';} ?>>In-Active</option>
											
										</select>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Product tags</label>
										<input type="text" value="<?= $product_data->product_tag ?>" name="product_tag" class="form-control" placeholder="Product Tags">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group clearfix" >
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="product_price_hide" id="checkboxPrimary1" <?php if($product_data->product_price_hide == 1){echo 'checked';} ?> value="1">
											<label for="checkboxPrimary1">
											Price Hide
											</label>
										</div>
									</div>
								</div>
								
								<div class="col-sm-12">
									<div class="form-group">
										<label>Product Description</label>
										<textarea name="product_description" class="form-control" placeholder="Product Description"><?= $product_data->product_description ?></textarea>
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
	</div>
</section>

<section class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-warning">
					<div class="card-header">
						<h3 class="card-title">Product Images</h3>
					</div>
					<div class="card-body">
						<form id="product_image_form" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="product_id" value="<?= $product_data->product_id ?>" />
							<div class="row">
							
								<div class="col-sm-12">
									<button onclick="{$('#product_images').click();}" type="button" class="btn btn-md btn-success" style="float: right;"><i class="fas fa-plus" style="font-size: 15px;"></i></button>
									<input onchange="check_image(this.id);" type="file" name="product_images" id="product_images" style="display:none;" class="form-control" >
								</div>
								
							</div>
						</form>
						<div class="row" id="image_body">
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- full view Image Modal -->  
<div class="modal fade" id="full_image">
    <div class="modal-dialog modal-xl"">
		<div class="modal-body" style="text-align: center;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<img src="" id="full_image_view" style="max-height: 500px;max-width: 1140px"/>
		</div>
          <!-- /.modal-content -->
    </div>
        <!-- /.modal-dialog -->
</div> 

<!-- product image script -->
<script>						
function check_image(id){
	var fileInput = document.getElementById(id);
	var filePath = fileInput.value;
	var allowedExtensions = /(\.JPG|\.JPEG|\.PNG)$/i;
	if(!allowedExtensions.exec(filePath)){
		alert('Please upload file having extensions .JPG/.JPEG/ only.');
		fileInput.value = '';
		return false;
	}else{
		//Image preview
		if (fileInput.files && fileInput.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				//alert(e.target.result);
				$("#product_image_form").submit();
			};
			reader.readAsDataURL(fileInput.files[0]);
		}
	}
}
//Insert product image
 $("#product_image_form").on('submit',(function(e) {

  e.preventDefault();
	  $.ajax({
		url: '<? echo base_url(); ?>Store_products/add_product_image',
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function(){ 
			
		},
		success: function(data){
			//alert(data);
			//console.log(data);
			get_product_images();
		},
		error: function(e){ 
			alert('Somthing Wron');
			console.log(e);
		}           
	});
 }));

get_product_images();
function get_product_images(){
	$.ajax({
		url:'<?php echo base_url(); ?>Store_products/get_product_images',
		method:"POST", 
		data:{ product_id:'<?= $product_data->product_id ?>' },
		success:function(data)
		{  
			//alertify.success("Delete Successfully");
			$('#image_body').html(data);
		},
		error: function(e){ 
			alertify.error("Somthing Wrong");
		} 
	});
}

//delete Service Parent Category
function delete_product_image(id){
	var result = confirm("Want to delete?");
	if (result) { 

		$.ajax({
			url:'<?php echo base_url(); ?>Store_products/delete_product_image',
			method:"POST", 
			data:{ id:id },
			success:function(data)
			{  
				alertify.success("Delete Successfully");
				get_product_images();
			},
			error: function(e){ 
				alertify.error("Somthing Wrong");
			} 
		});
	}
}

function chnage_image_order(id){
	var order = $('#order-'+id).val();
	$.ajax({
		url:'<?php echo base_url(); ?>Store_products/chnage_product_image_order',
		method:"POST", 
		data:{ id:id, order:order },
		success:function(data)
		{  
			alertify.success("Chage Image Order Successfully");
			get_product_images();
		},
		error: function(e){ 
			alertify.error("Somthing Wrong");
		} 
	});
}

</script>

<!-- validation -->
<script>
	
//validation
$('#product_detail').validate({
		rules:{
			product_name:{
				required:true,
			},
			product_price:{
				required:true,
				number: true,
			},
			product_sele_price:{
				required:true,
				number: true,
				greaterThan: "#product_price",
			},
			product_qty:{
				required:true,
				number: true,
			},
			product_parent_category:{
				required:true,
			},
			password:{
				required:true,
				useradd_pwcheck: true,
			},
			
			
		},
		messages:{
			product_name: {
				required: '<p style="color: red;">Please Enter Product Name.</p>',
			},
			product_price: {
				required: '<p style="color: red;">Please Enter Product Price.</p>',
				number: '<p style="color: red;">Please Enter Numeric Value Only.</p>',
			},
			product_sele_price: {
				required: '<p style="color: red;">Please Enter Product Sele Price.</p>',
				number: '<p style="color: red;">Please Enter Numeric Value Only.</p>',
				greaterThan: '<p style="color: red;">Product Sale price must be less than Product price !.</p>',
			},
			product_qty: {
				required: '<p style="color: red;">Please Enter Product QTY.</p>',
				number: '<p style="color: red;">Please Enter Numeric Value Only.</p>',
			},
			product_parent_category: {
				required: '<p style="color: red;">Please Select Parent Category.</p>',
			},
		},
	}); 
	jQuery.validator.addMethod(
	"greaterThan",
	function (value, element, param) {
		var $min = $(param);

		if (this.settings.onfocusout) {
			$min
				.off(".validate-greaterThan")
				.on("blur.validate-greaterThan", function () {
					$(element).valid();
				});
		}

		return parseInt(value) <= parseInt($min.val());
	},
	"Product Sale price must be less than Product price !!"
);
jQuery.validator.addMethod(
	"greaterThan",
	function (value, element, param) {
		var $min = $(param);

		if (this.settings.onfocusout) {
			$min
				.off(".validate-greaterThan")
				.on("blur.validate-greaterThan", function () {
					$(element).valid();
				});
		}

		return parseInt(value) <= parseInt($min.val());
	},
	"Product Sale price must be less than Product price !"
);
</script>

<script>
//for image full view
function image_view_modal(image_src){
	$('#full_image').modal('show');
	document.getElementById("full_image_view").src = image_src;
}

function get_child_category(parent_id){
	$('#product_child_category').html('<option>Loading ....</option>');
	$.ajax({
		url:'<?php echo base_url(); ?>Store_products/get_child_category',
		method:"POST", 
		data:{ parent_id:parent_id },
		success:function(data)
		{  
			$('#product_child_category').html(data);
		},
		error: function(e){ 
			alertify.error("Somthing Wrong");
		} 
	});
}

	
</script>	

	