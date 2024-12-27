<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Package</h1>
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
						<h3 class="card-title">Enter Package  Details</h3>
					</div>
					<form id="package_detail" action="<?php echo base_url(); ?>Store_Packages/insert_package" method="POST" enctype="multipart/form-data">		
						<div class="card-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Package Name <span class="error">*</span></label>
										<input type="text" name="Package_name" class="form-control" placeholder="Package Name">
									</div>
								</div>
								
								
								
								<div class="col-sm-6">
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
								
								<div class="col-sm-4">
									<div class="form-group">
										<label>Parent Category</label><span class="error">*</span></label>
										<select class="form-control select2" name="main_category"  id="main_category" style="width: 100%;">
											<option value="">Select Parent Category</option>
											<?php
												foreach($parent_cat_data as $val){
													echo '<option value="'.$val->category_id .'">'.$val->category_name.'</option>';
												}
											?>
										</select>
										<p id="error_dis" class="error"></p>
									</div>
								</div>
								
								
								<div class="col-sm-4">
									<div class="form-group">
										<label>Upload Image<span class="error">*</span></label>
										<input type="file" name="packege_images"  id="packege_images" onchange="fileValidation()" class="form-control">
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
								
							<!--	<div class="col-sm-4" style="display: flex;align-items: center;">
									<div class="form-group clearfix" style="padding-top: 30px;">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="price_hide" id="checkboxPrimary1" value="1">
											<label for="checkboxPrimary1">
											Price Hide
											</label>
										</div>
									</div>
								</div>
							-->	
																
								<div class="col-sm-12">
									<div class="form-group">
									<label>Package Tags</label>
									<input type='text' name="packege_tage" id="packege_tage" class='tags_input' value="" placeholder="Package Tags"/>
									</div>
								</div>
								
								<div class="col-sm-12">
									<div class="form-group">
										<label>Package Description </label>
										<textarea name="packege_description" class="form-control" placeholder="Package Description"></textarea>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Excludes</label>
										<textarea name="packege_excludes" class="form-control" placeholder="Excludes"></textarea>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Includes</label>
										<textarea name="packege_includes" class="form-control" placeholder="Includes"></textarea>
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


//validation
$('#package_detail').validate({
		rules:{
			Package_name:{
				required:true,
			},
			packege_duration:{
				required:true,
			},
			packege_images:{
				required:true,
			},
			main_category:{
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
			
			
		},
		messages:{
			Package_name: {
				required: 'Please Enter Package Name.',
			},
			packege_duration: {
				required: 'Please Select Appreoximate Service Time.',
			},
			packege_images: {
				required: 'Please Upload Image For Package.',
			},
			main_category: {
				required: 'Please Select Main Category.',
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
		},
	}); 
	jQuery.validator.addMethod("greaterThan",
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
	}," Sale price must be less than  price");
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
 function fileValidation() { 
	var fileInput = document.getElementById('packege_images'); 
    var filePath = fileInput.value; 
    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i; 

	var files = fileInput.files;
	var file = files[0]; 
		if(file.size > 300000){
			alert("File should less then 300kb");
			 fileInput.value = ''; 
			die;
		}
        if (!allowedExtensions.exec(filePath)) { 
            alert('Invalid file type'); 
            fileInput.value = ''; 
            return false; 
        }  
        /*else  
        { 
		if (fileInput.files && fileInput.files[0]) {
			// to check image is accepted
			alert('Image accepted');
                } 
            } */
        } 
</script>

<!-- for tags -->
<script>
$(function(){
	
	$.ajax({
		url: '<? echo base_url(); ?>Store_Packages/get_tag',
		type: "POST",
		data:  {tag:'' },
		dataType: "json",
		success: function(res)
		{
			var packege_tage = [];
			 //alert(res);
			for (var i = 0; i < res.length; i++) {
			  packege_tage.push(res[i].tag);
			}
			
			$(".tags_input").tagComplete({
			
				keylimit: 1,
				hide: false,
				autocomplete: {
					data: packege_tage
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
	

	