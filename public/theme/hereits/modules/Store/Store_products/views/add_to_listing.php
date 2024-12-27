<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Listing Details</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_dashboard">Home</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_products">Products_list</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>search_product">search_product</a></li>
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
						<h3 class="card-title">Product Images</h3>
					</div>
					<div class="card-body">
						<div class="row" style="justify-content:center; margin-top: 20px;"> 		
							<?php foreach($product_images as $val){?>
								<div class="filtr-item col-sm-2 col-6" style="margin: 0px 0px 20px 0px;box-shadow: 0 0 1px rgba(0,0,0,.105),0 5px 3px rgba(0,0,0,.2);text-align: center;">
								<div style="height: 150px;text-align: center;">
								<img  src="<?= base_url().$val->image_url?>" class="img-fluid mb-2" alt="Product Image" style="height: 140px;object-fit: contain;"/> 
								</div>
								</div>
							<?php } ?>							
						</div>
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
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Product Information</h3>
					</div>
					<div class="card-body">
						<form id="product_detail" action="<?= base_url(); ?>Store_products/submit_to_list" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="product_id" value="<?= $product_data->product_id ?>" />
							<div class="row">
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Product Name</label>
										<input type="text" " value="<?= $product_data->product_name ?>" class="form-control" disabled >
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Category</label>
										<input type="text" " value="<?= $category_name->category_name ?>" class="form-control" disabled >
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
											<input type="text" name="product_price" id="product_price"  class="form-control" placeholder="Product Price">
										</div>
									</div>
								
									<div class="col-sm-6">
										<div class="form-group">
											<label>Product Sale Price</label><label class ="error">*</label>
											<input type="text" name="product_sele_price" id="product_sele_price"  class="form-control" placeholder="Product Sale Price">
										</div>
									</div>
								</div>	
								<div class="row" style="display:none;" id="range_price">
									<div class="col-sm-6">
										<div class="form-group">
											<label >Minimum Price</label><label class ="error">*</label>
											<input type="text" name="minimum_product_price" id="minimum_product_price"  class="form-control" placeholder="Minimum Price">
										</div>
									</div>
								
								
									<div class="col-sm-6">
										<div class="form-group">
											<label>Maximum Price</label><label class ="error">*</label>
											<input type="text" name="maximum_product_price" id="maximum_product_price"  value="<?= $product_data->product_sele_price ?>" class="form-control" placeholder="Maximum Price">
										</div>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Brand name</label>
										<input type="text" name="brand_name" value="<?= $product_data->brand_name ?>" id="brand_name" class="form-control" placeholder="Product brand..">
									</div>
								</div>
	<?php if ($product_data->brand_fixed == 1){ ?>
		<script>
			 document.getElementById("brand_name").readOnly  = true; 
		</script>							
	<?php } ?>							
								<div class="col-sm-6">
									<div class="form-group">
										<label>Available Stock</label><span class="error">*</span>
										<input type="text" name="product_qty" id="product_qty" class="form-control" placeholder="Product Quantity">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Selling Unit</label> <label class ="error">*</label>
										<select  class="form-control select" name="selling_unit" id="selling_unit" style="width: 100%;">
											<option value="">Select Selling Unit</option>
											<option <?php if($product_data->selling_unit == "KG"){echo 'selected';} ?> value="KG">KG</option>
											<option <?php if($product_data->selling_unit == "GRAMS"){echo 'selected';} ?> value="GRAMS">GRAMS</option>
											<option <?php if($product_data->selling_unit == "UNIT"){echo 'selected';} ?> value="UNIT">UNIT</option>
											<option <?php if($product_data->selling_unit == "PIECE"){echo 'selected';} ?> value="PIECE">PIECE</option>
											<option <?php if($product_data->selling_unit == "LTR"){echo 'selected';} ?> value="LTR">LTR</option>
											<option <?php if($product_data->selling_unit == "MI"){echo 'selected';} ?> value="MI">MI</option>
											<option <?php if($product_data->selling_unit == "DOZEN"){echo 'selected';} ?> value="DOZEN">DOZEN</option>
											<option <?php if($product_data->selling_unit == "HALF DOZEN"){echo 'selected';} ?> value="HALF DOZEN">HALF DOZEN</option>
											<option <?php if($product_data->selling_unit == "BUNDLE"){echo 'selected';} ?> value="BUNDLE">BUNDLE</option>
										</select>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group"><label class ="error">*</label>
										<label>Selling Unit QTY</label> <label class ="error">*</label>
										<input type="text" name="selling_unit_qty" id="selling_unit_qty" value="<?= $product_data->selling_unit_qty ?>" class="form-control" placeholder="Selling Unit Quantity">
									</div>
								</div>
							<?php if ($product_data->fixed_selling_unit == 1){ ?>
								<script>
									 document.getElementById("selling_unit").disabled  = true; 
									 document.getElementById("selling_unit_qty").readOnly  = true; 
									 
								</script>							
							<?php } ?>			
							<!--<div class="col-sm-6">
									<div class="form-group clearfix" style="margin-top: 40px;">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="product_price_hide" id="checkboxPrimary1" value="1">
											<label for="checkboxPrimary1">
											Price Hide
											</label>
										</div>
									</div>
								</div>
							-->	
								<div class="col-sm-12">
									<div class="form-group">
										<label>Product Description</label>
										<textarea name="product_description" class="form-control" placeholder="Product Description"><?= $product_data->product_description ?></textarea>
									</div>
								</div>
								
							</div>
							
							
								<div class="card-footer" style="font-size:11px">
									<input type="Checkbox" id="allrights" onchange="check_right()" value="1" style="margin-right: 3px;" Checked><label style="font-size: 12.5px;">By clicking ,on this box "I Agree that i have all rights to sell this Product.Hereits not liable for any kind of legal issues or any other disputes for listing this Product on platform".</label>
								</div>
							
							<div class="card-footer">
								<button type="submit" id="btnsave" class="btn btn-primary">Save </button>
							</div>
						</form>
					</div>
				</div>
			</div>
        </div>
	</div>
</section>

<!-- for product price type-->
<script>

	function change_price()
	{
		 document.getElementById("product_price").value = "";
		 document.getElementById("product_sele_price").value = "";
		 document.getElementById("minimum_product_price").value = "";
		 document.getElementById("maximum_product_price").value = "";
		 		 
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

// Allrights agreemnent 
function check_right(){
	if($("#allrights").prop('checked') == true){
		$('#btnsave').show();
	}else {
		$('#btnsave').hide();
	}
}

//validation
$('#product_detail').validate({
		rules:{
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
		},
		messages:{
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
			product_qty: {
				required: '<p style="color: red;">Please Enter Product QTY.</p>',
				number: '<p style="color: red;">Please Enter Numeric Value Only.</p>',
			},
			selling_unit:{
				required:'<p style="color: red;">Please Select Selling Unit.</p>',
			},
			selling_unit_qty:{
				required:'<p style="color: red;">Please Enter Selling Unity Quantity.</p>',
				number: '<p style="color: red;">Please Enter Unit in Number.</p>',
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

	

	