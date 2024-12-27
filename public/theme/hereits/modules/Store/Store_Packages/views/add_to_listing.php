<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-4">
				<h1 class="m-0 text-dark">Listing Details</h1>
			</div><!-- /.col -->
			<div class="col-sm-4">
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
						<h3 class="card-title">Package Information</h3>
					</div>
					<div class="card-body">
						<form id="product_detail" action="<?= base_url(); ?>Store_Packages/submit_to_list" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="Package_id" value="<?= $package_data->Package_id ?>" />
							
							<div class="row" style="justify-content: center;margin-bottom: 25px;"> 		
									<div class="filtr-item col-sm-2 col-6" style="margin: 0px 0px 20px 0px;box-shadow: 0 0 1px rgba(0,0,0,.105),0 5px 3px rgba(0,0,0,.2);text-align: center;">
										<div style="height: 150px;text-align: center;">
											<img  src="<?= base_url().$package_data->packege_image?>" class="img-fluid mb-2" alt="Product Image" style="height: 140px;object-fit: contain;"/> 
										</div>
									</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<label>Package Name </label>
										<input type="text" value="<?= $package_data->Package_name ?>"  class="form-control" disabled>
									</div>
								</div>	
								<div class="col-sm-4">
									<div class="form-group">
										<label>Category</label>
										<input type="text"  value="<?= $category_name->category_name ?>" class="form-control" disabled >
									</div>
								</div>
								
								<div class="col-sm-4">
									<div class="form-group">
										<label> Select Appreoximate Service Time <span class="error">*</span></label>
										<select class="form-control" name="packege_duration" id="packege_duration" style="width: 100%;">
											<option value="">Select Hrous</option>
											<?php
												for($i=1; $i<=48; $i++){
													echo '<option value="'.$i.'">'.$i.' Hour</option>';
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
											<option value="1" >Fixed Price</option>
											<option value="2" >Price In Range</option>
											<option value="3" >Ask For Price</option>
										</select>
									</div>
								</div>
								
								<div class="row" id="fix_price">
									<div class="col-sm-6">
										<div class="form-group">
											<label >Package Price</label><label class ="error">*</label>
											<input type="text" name="packege_price" id="packege_price"  class="form-control" placeholder="Product Price">
										</div>
									</div>
								
									<div class="col-sm-6">
										<div class="form-group">
											<label>Package Sale Price</label><label class ="error">*</label>
											<input type="text" name="packege_sale_price" id="packege_sale_price" class="form-control" placeholder="Product Sale Price">
										</div>
									</div>
								</div>	
								<div class="row" style="display:none;" id="range_price">
									<div class="col-sm-6">
										<div class="form-group">
											<label >Minimum Price</label><label class ="error">*</label>
											<input type="text" name="minimum_packege_price" id="minimum_packege_price"  class="form-control" placeholder="Minimum Price">
										</div>
									</div>
								
								
									<div class="col-sm-6">
										<div class="form-group">
											<label>Maximum Price</label><label class ="error">*</label>
											<input type="text" name="maximum_packege_price" id="maximum_packege_price"  class="form-control" placeholder="Maximum Price">
										</div>
									</div>
								</div> 
													
							<!--<div class="col-sm-4">
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
										<label>Package Description</label>
										<textarea name="Package_description" id="Package_description" class="form-control" placeholder="Package Description"><?= $package_data->packege_description ?></textarea>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Package Excludes</label>
										<textarea name="packege_excludes" id="packege_excludes" class="form-control" placeholder="Package Excludes"><?= $package_data->packege_excludes ?></textarea>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Package Includes</label>
										<textarea name="packege_includes" id="packege_includes" class="form-control" placeholder="Package Includes"><?= $package_data->packege_includes ?></textarea>
									</div>
								</div>
							</div>
								
							
								<div class="card-footer" style="font-size:11px">
									<input type="Checkbox" id="allrights" onchange="check_right()" value="1" style="margin-right: 3px;" Checked><label style="font-size: 12.5px;">By clicking ,on this box "I Agree that i have all rights to sell this Package.Hereits not liable for any kind of legal issues or any other disputes for listing this Package on platform".</label>
								</div>
							
							<div class="card-footer">
								<button type="submit" id="btnsave" class="btn btn-primary">Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
        </div>
	</div>
</section>

<!-- for package price type-->
<script>
	function change_price()
	{
		 document.getElementById("packege_price").value = "";
		 document.getElementById("packege_sale_price").value = "";
		 document.getElementById("minimum_packege_price").value = "";
		 document.getElementById("maximum_packege_price").value = "";
		 		 
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
			Package_price:{
				required:true,
				number: true,
			},
			Package_sele_price:{
				required:true,
				number: true,
				greaterThan: "#Package_price",
			},
			maximum_packege_price:{
				required:true,
				number: true,
				lessThan : "#minimum_packege_price",
			},
			minimum_packege_price:{
				required:true,
				number: true,
				
			},
			Package_qty:{
				required:true,
				number: true,
			},
		},
		messages:{
			Package_price: {
				required: '<p style="color: red;">Please Enter Package Price.</p>',
				number: '<p style="color: red;">Please Enter Numeric Value Only.</p>',
			},
			Package_sele_price: {
				required: '<p style="color: red;">Please Enter Package Sele Price.</p>',
				number: '<p style="color: red;">Please Enter Numeric Value Only.</p>',
				greaterThan: '<p style="color: red;">Package Sale price must be less than Package price.</p>',
			},
			maximum_packege_price: {
				required: 'Enter Maximum Price.',
				number: 'Please Enter Numeric Value Only.',
				lessThan: 'Maximum price must be Greater than Minimum price.',
			},
			minimum_packege_price: {
				required: 'Enter Minimum Price.',
				number: 'Please Enter Numeric Value Only.',
				
			},
			Package_qty: {
				required: '<p style="color: red;">Please Enter Package QTY.</p>',
				number: '<p style="color: red;">Please Enter Numeric Value Only.</p>',
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
	"Package Sale price must be less than Package price"
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

	

	