<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Package Detail</h1>
			</div><!-- /.col -->
			<div class="col-sm-6 m-hide">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_dashboard">Home</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_Coupons">Package_list</a></li>
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
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Package Information</h3>
					</div>
					<form id="package_detail" action="<?php echo base_url(); ?>Store_Packages/update_package" method="POST" enctype="multipart/form-data">		
						<div class="card-body">
							
							<div class="row" style="justify-content: center;margin-bottom: 25px;"> 		
									<div class="filtr-item col-sm-2 col-6" style="margin: 0px 0px 20px 0px;box-shadow: 0 0 1px rgba(0,0,0,.105),0 5px 3px rgba(0,0,0,.2);text-align: center;">
										<div style="height: 150px;text-align: center;">
											<img  src="<?= base_url().$package_data->packege_image?>" class="img-fluid mb-2" alt="Product Image" style="height: 140px;object-fit: contain;"/> 
										</div>
									</div>
							</div>
								
							<div class="row">
							
								<input type="hidden" name="Package_id" value="<?= $package_data->Package_id ?>"/>
								
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
													echo '<option value="'.$i.'" '; if($package_data->packege_duration == $i){ echo 'selected';} echo '>'.$i.' Hour</option>';
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
											<option value="1" <?php if($package_data->price_type==1){ echo " Selected";}?>>Fixed Price</option>
											<option value="2" <?php if($package_data->price_type==2){ echo " Selected";}?>>Price In Range</option>
											<option value="3" <?php if($package_data->price_type==3){ echo " Selected";}?>>Ask For Price</option>
										</select>
									</div>
								</div>
								
								<div class="row" id="fix_price">
									<div class="col-sm-6">
										<div class="form-group">
											<label >Package Price</label><label class ="error">*</label>
											<input type="text" name="packege_price" id="packege_price" value="<?= $package_data->packege_price ?>" class="form-control" placeholder="Product Price">
										</div>
									</div>
								
									<div class="col-sm-6">
										<div class="form-group">
											<label>Package Sale Price</label><label class ="error">*</label>
											<input type="text" name="packege_sale_price" id="packege_sale_price"  value="<?= $package_data->packege_sale_price ?>" class="form-control" placeholder="Product Sale Price">
										</div>
									</div>
								</div>	
								<div class="row" style="display:none;" id="range_price">
									<div class="col-sm-6">
										<div class="form-group">
											<label >Minimum Price</label><label class ="error">*</label>
											<input type="text" name="minimum_packege_price" id="minimum_packege_price" value="<?= $package_data->packege_sale_price ?>" class="form-control" placeholder="Minimum Price">
										</div>
									</div>
								
								
									<div class="col-sm-6">
										<div class="form-group">
											<label>Maximum Price</label><label class ="error">*</label>
											<input type="text" name="maximum_packege_price" id="maximum_packege_price" value="<?= $package_data->packege_price ?>" class="form-control" placeholder="Maximum Price">
										</div>
									</div>
								</div> 
								
							<!--	<div class="col-sm-4" style="display: flex;align-items: center;">
									<div class="form-group clearfix" style="padding-top: 30px;">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="price_hide" id="checkboxPrimary1" value="1" <?php if($package_data->price_hide == 1){ echo 'checked';} ?>>
											<label for="checkboxPrimary1">
											Price Hide
											</label>
										</div>
									</div>
								</div>
								-->
																
								<div class="col-sm-4">
									<div class="form-group">
										<label> Status <span class="error">*</span></label>
										<select class="form-control" name="packege_status" onchange="check_limits()" id="packege_status" style="width: 100%;">
											<option value="1" <?php if($package_data->packege_status == 1){ echo 'selected';} ?>>Live</option>
											<option value="0" <?php if($package_data->packege_status == 0){ echo 'selected';} ?>>Offline</option>
										</select>
									</div>
								</div>
								
								
																
								<div class="col-sm-12">
									<div class="form-group">
										<label>Package Description </label>
										<textarea name="packege_description" id="packege_description" class="form-control" placeholder="Package Description"><?= $package_data->packege_description ?></textarea>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Excludes</label>
										<textarea name="packege_excludes" id="packege_excludes" class="form-control" placeholder="Excludes"><?= $package_data->packege_excludes ?></textarea>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Includes</label>
										<textarea name="packege_includes" id="packege_includes" class="form-control" placeholder="Includes"><?= $package_data->packege_includes ?></textarea>
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

<!-- for package price type-->
<script>
<?php if($package_data->price_type==1){ ?> 
$('#fix_price').show(); $('#range_price').hide(); 
<?php } elseif($package_data->price_type==2) { ?> 
$('#fix_price').hide(); $('#range_price').show(); 
<?php }elseif($package_data->price_type==3) {  ?> 
$('#fix_price').hide(); $('#range_price').hide(); <?php } ?>

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

<script>
function check_limits(){
	if($('#packege_status').val() == 1){
		if( <?= $package_count ?> >= <?= $package_Limit->package_Limit ?>){
			alert("Sorry , You had Reached Active Packages Limits , Upgarde Your Plan to list more Service or Remove/Offline some packages and try again");
			document.getElementById('packege_status').value  = "0";
		}else{
			
		}
	}else if($('#packege_status').val() == 0){
		
	}
	
}
</script>
<!-- validation -->
<script>

//image validet
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
			};
			reader.readAsDataURL(fileInput.files[0]);
		}
	}
}
	
//validation
$('#package_detail').validate({
		rules:{
			Package_name:{
				required:true,
			},
			packege_duration:{
				required:true,
			},
			main_category:{
				required:true,
			},
			sub_category:{
				required:true,
			},
			packege_price:{
				required:true,
				number: true,
			},
			packege_sale_price:{
				required:true,
				number: true,
				greaterThan: "#packege_price",
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
			packege_status:{
				required:true,
			},
			packege_tage:{
				required:true,
			},
						
		},
		messages:{
			Package_name: {
				required: 'Please Enter Coupon Name.',
			},
			packege_duration: {
				required: 'Please Select Appreoximate Service Time.',
			},
			main_category: {
				required: 'Please Select Main Category.',
			},
			sub_category: {
				required: 'Please Select Sub Category.',
			},
			packege_price: {
				required: 'Please Enter Price.',
				number: 'Please Enter Numeric Value Only.',
			},
			packege_sale_price: {
				required: 'Please Enter Sale Price.',
				number: 'Please Enter Numeric Value Only.',
				greaterThan: 'Sale price must be less than price.',
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
			packege_tage: {
				required: 'Please Enter Tags.',
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
	" Sale price must be less than  price"
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
	

	