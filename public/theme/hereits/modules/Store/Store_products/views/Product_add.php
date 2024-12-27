


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
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Add Product Details</h3>
					</div>
					<div class="card-body">
						<form id="product_detail" action="<?php base_url(); ?>Store_products/insert_product" method="POST" enctype="multipart/form-data">
							<div class="row">
							
								<div class="col-sm-6">
									<div class="form-group">
										<label>Product Name</label><label class ="error">*</label>
										<input type="text" name="product_name" id="product_name" class="form-control" placeholder="Product Name">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Parent Category</label><label class ="error">*</label>
										<select  class="form-control select2" name="product_parent_category" id="product_parent_category" style="width: 100%;">
											<option value="">Select Parent Category</option>
											<?php
												foreach($parent_cat_data as $val){
													echo '<option value="'.$val->category_id.'">'.$val->category_name.'</option>';
												}
											?>
										</select>
									</div>
								</div>
								
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Price Type</label><label class ="error">*</label>
										<select  onchange="change_price()" class="form-control select2" name="price_type" id="price_type" style="width: 100%;">
											<option value="" Selected>Select Price Type</option>
											<option value="1">Fixed Price</option>
											<option value="2">Price In Range</option>
											<option value="3">Ask For Price</option>
										</select>
									</div>
								</div>
								
								<div class="row" id="fix_price">
									<div class="col-sm-6">
										<div class="form-group">
											<label >Product Price</label><label class ="error">*</label>
											<input type="text" name="product_price" id="product_price" class="form-control" placeholder="Product Price">
										</div>
									</div>
								
									<div class="col-sm-6">
										<div class="form-group">
											<label>Product Sale Price</label><label class ="error">*</label>
											<input type="text" name="product_sele_price" id="product_sele_price" class="form-control" placeholder="Product Sale Price">
										</div>
									</div>
								</div>	
								<div class="row" style="display:none;" id="range_price">
									<div class="col-sm-6">
										<div class="form-group">
											<label >Minimum Price</label><label class ="error">*</label>
											<input type="text" name="minimum_product_price" id="minimum_product_price" class="form-control" placeholder="Minimum Price">
										</div>
									</div>
								
								
									<div class="col-sm-6">
										<div class="form-group">
											<label>Maximum Price</label><label class ="error">*</label>
											<input type="text" name="maximum_product_price" id="maximum_product_price" class="form-control" placeholder="Maximum Price">
										</div>
									</div>
								</div>
								
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Brand Name</label>
										<input type="text" name="brand_name" id="brand_name" class="form-control" placeholder="Brand name..">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Available stock</label>
										<input type="text" name="product_qty" id="product_qty" class="form-control" placeholder="Total Available Product Stock">
									</div>
								</div>
								
								<!-- div class="col-sm-6">
									<div class="form-group">
										<label>Child Category</label>
										<select class="form-control select2" name="product_child_category" id="product_child_category" style="width: 100%;">
											<option value="">Select Child Category</option>
											
										</select>
									</div>
								</div -->
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Selling Unit</label><label class ="error">*</label>
										<select  class="form-control select" name="selling_unit" style="width: 100%;">
											<option value="">Select Selling Unit</option>
											<option value="KG">KG</option>
											<option value="GRAMS">GRAMS</option>
											<option value="UNIT">UNIT</option>
											<option value="PIECE">PIECE</option>
											<option value="LTR">LTR</option>
											<option value="MI">MI</option>
											<option value="DOZEN">DOZEN</option>
											<option value="HALF DOZEN">HALF DOZEN</option>
											<option value="BUNDLE">BUNDLE</option>
										</select>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Selling Unit QTY</label>
										<input type="text" name="selling_unit_qty"  class="form-control" placeholder="Selling Unit Quantity">
									</div>
								</div>
								
								<div class="col-sm-12">
									<div class="form-group">
									<label>Product Tags</label>
									<input type='text' name="tags" class='tags_input' value="" placeholder="Product Tags"/>
									</div>
								</div>
								
								<div class="col-sm-12">
									<div class="form-group">
										<label>Product Description</label>
										<textarea name="product_description" class="form-control" placeholder="Product Description"></textarea>
									</div>
								</div>
								
							</div>
							<div class="card-footer">
								<button type="submit" class="btn btn-primary">Save And Next</button>
							</div>
						</form>
					</div>
				</div>
			</div>
        </div>
	</div>
</section>

<script>
	function change_price()
	{
		if($('#price_type').val() == 2){
			$('#fix_price').hide();
			$('#range_price').show();
		}else if($('#price_type').val() == 3){
			$('#fix_price').hide();
			$('#range_price').hide();
		}else if($('#price_type').val() == 1){
			$('#fix_price').show();
			$('#range_price').hide();
		}
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
			price_type:{
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
			maximum_product_price:{
				required:true,
				number: true,
				lessThan: "#minimum_product_price",
			},
			minimum_product_price:{
				required:true,
				number: true,
				
			},
			product_qty:{
				required:true,
				number: true,
			},
			selling_unit:{
				required:true,
			},
			selling_unit_qty:{
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
			price_type: {
				required: '<p style="color: red;">Please Select Price Type.</p>',
			},
			product_price: {
				required: '<p style="color: red;">Please Enter Product Price.</p>',
				number: '<p style="color: red;">Please Enter Numeric Value Only.</p>',
			},
			product_sele_price: {
				required: '<p style="color: red;">Please Enter Product Sele Price.</p>',
				number: '<p style="color: red;">Please Enter Numeric Value Only.</p>',
				greaterThan: '<p style="color: red;">Product Sale price must be less than Product price.</p>',
			},
			
			maximum_product_price: {
				required: '<p style="color: red;">Enter Maximum Product Price.</p>',
				number: '<p style="color: red;">Enter Numeric Value Only.</p>',
				lessThan: '<p style="color: red;">Product Maximum price must be Greater than Minimum Product price.</p>',
			},
			minimum_product_price: {
				required: '<p style="color: red;">Enter Minimum Product Price.</p>',
				number: '<p style="color: red;">Please Enter Numeric Value Only.</p>',
				
			},
			selling_unit: {
				required: '<p style="color: red;">Please Select Selling Unit.</p>',
			},
			selling_unit_qty: {
				required: '<p style="color: red;">Please Enter Selling Unit QTY.</p>',
				number: '<p style="color: red;">Please Enter Numeric Value Only.</p>',
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
	"Product Sale price must be less than Product price"
);
jQuery.validator.addMethod(
	"lessThan",
	function (value, element, param) {
		var $min = $(param);

		if (this.settings.onfocusout) {
			$min
				.off(".validate-lessThan")
				.on("blur.validate-lessThan", function () {
					$(element).valid();
				});
		}

		return parseInt(value) > parseInt($min.val());
	},
	
);
</script>

<!-- for tags -->
<script>
$(function(){
	
	$.ajax({
		url: '<? echo base_url(); ?>Store_products/get_tag',
		type: "POST",
		data:  {tag:'' },
		dataType: "json",
		success: function(res)
		{
			var tags = [];
			 //alert(res);
			for (var i = 0; i < res.length; i++) {
			  tags.push(res[i].tag);
			}
			
			$(".tags_input").tagComplete({
			
				keylimit: 1,
				hide: false,
				autocomplete: {
					data: tags
				}
		});
		},
		error: function(e){ 
			alert('Somthing Wron');
			console.log(e);
		}           
	});

	
});
</script>