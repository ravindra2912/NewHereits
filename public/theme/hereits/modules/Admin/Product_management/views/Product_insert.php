<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>User_management">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $main_content; ?></li>
			  <li class="breadcrumb-item"><a href="#">Product Update</a></li>
            </ol>
          </div>
        </div>
      </div>
    </section>
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
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->

          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">PRODUCT INSERT</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			    <form role="form" name="insert_form" action='<?php echo base_url(); ?>Product_management/insert_product' method="POST" enctype="multipart/form-data">
					<div class="row">
						<div class="col-sm-4">
						<!-- text input -->
							<div class="form-group">
								<label>Product Name :</label> <span class="error">*</span>
								<input type="text" name="product_name" id="product_name" class="form-control" placeholder="Enter First Name">
							</div>
						</div>
						<div class="col-sm-4">
                      <!-- select -->
							<div class="form-group">
								<label>Product Main Category :</label> <span class="error">*</span>
								<select class="form-control select2" name="product_parent_category" id="product_parent_category" style="width: 100%;">
								<option value="">Select Parent Category</option>
								<?php
									foreach($parent_cat_data as $val){
										echo '<option value="'.$val->category_id.'">'.$val->category_name.'</option>';
									}
								?>
								</select>
						  </div>
						</div>
					
						<div class="col-sm-4">
						<!-- select -->
							<div class="form-group">
								<label>Product Sub Category :</label> 
								<select class="form-control select2" name="product_child_category" id="product_child_category" style="width: 100%;">
									<option value="">Select Child Category</option>
								</select>
							</div>
						</div>
                  
					<div class="col-sm-4">
						<div class="form-group">
							<label >Product Price</label><label class ="error">*</label>
							<input type="text" name="product_price" id="product_price"  class="form-control" placeholder="Product Price">
						</div>
					</div>
				
					<div class="col-sm-4">
						<div class="form-group">
							<label>Product Sale Price</label><label class ="error">*</label>
							<input type="text" name="product_sele_price" id="product_sele_price" class="form-control" placeholder="Product Sale Price">
						</div>
					</div>
					
				  <div class="col-sm-4">
					<div class="form-group">
						<label> Product Brand:</label> 
						<input type="text" class="form-control"  id="brand_name" name="brand_name" placeholder="Enter ...">
					</div>
                  </div>
				 		  
				  <div class="col-sm-4">
					<div class="form-group">
						<label>Product Tags :</label> 
						<input type="text" class='tags_input'  id="product_tag"  name="product_tag" placeholder="Enter ...">
					</div>
				  </div>
				  <div class="col-sm-4">
						<div class="form-group">
							<label>Selling Unit</label> 
								<select  class="form-control select" name="selling_unit" id="selling_unit" style="width: 100%;">
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
							
					<div class="col-sm-4">
						<div class="form-group">
							<label>Selling Unit QTY</label> 
						<input type="text" name="selling_unit_qty" id="selling_unit_qty" class="form-control" placeholder="Selling Unit Quantity">
						</div>
					</div>
						
					 <div class="col-sm-6">
						<div class="form-group">
							<label>Product Description:</label>
							<textarea class="form-control"  id="product_description" name="product_description" placeholder="Enter ..."></textarea>
						</div>
					  </div>
					<div class="col-sm-4">
						<div class="form-group" style="margin-top: 38px; text-align: -webkit-center;">
							<label> <input type="checkbox" name="fixed_selling_unit" id="fixed_selling_unit" value="1">   Fixed Selling Unit </label> 
							<label> <input type="checkbox" name="brand_fixed" id="brand_fixed" value="1">   Fixed Brand </label> 
						</div>
					</div>
				</div>
			
					<div class="card-footer">
						<button type="submit" name="submit" id="submit" class="btn btn-primary">Save</button>
					</div>
					
                </form>
              </div>
              <!-- /.card-body -->
            </div>
			</div> 
	</div>
	</div>
    </section>
	

<script>
				// Wait for the DOM to be ready
		$(function() {
			$("form[name='insert_form']").validate(
			{
				rules: {
					product_name: {
					required: true,
					},
					
					product_price: {
					  required: true,
						number: true,
					},
					
					product_sele_price: {
						required: true,
						  number: true,
						  greaterThan: "#product_price",
					},
					
					product_parent_category: {
						required: true,
						 
					},
							
					
				},
		   
			messages: 
			{
				product_name: '<p> *Please enter Product name</p>',
				
								
				product_price: {
					  required: '<p> *Please enter Product price</p>',
					  number:'<p> *Please enter Numbers only</p>',
				},
				product_sele_price: {
					  required: '<p> *Please enter Selling price</p>',
					  number:'<p> *Please enter Numbers only</p>',
					  greaterThan: '<p >Product Sale price must be less than Product price.</p>',
				},
				
				product_parent_category: '<p> *Please enter Parent Category</p>',
					
				
			},
			  
			submitHandler: function(form) {
				form.submit();
			}
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
	});
	</script>
<!-- for tags -->
<script>
$(function(){
	
	$.ajax({
		url: '<? echo base_url(); ?>Product_management/get_tag',
		type: "POST",
		data:  {tag:'' },
		dataType: "json",
		success: function(res)
		{
			var product_tag = [];
			 //alert(res);
			for (var i = 0; i < res.length; i++) {
			  product_tag.push(res[i].tag);
			}
			
			$(".tags_input").tagComplete({
			
				keylimit: 1,
				hide: false,
				autocomplete: {
					data: product_tag
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
	
<script>
//for image full view
function image_view_modal(image_src){
	$('#full_image').modal('show');
	document.getElementById("full_image_view").src = image_src;
}

<!-- product image script -->						
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
				$('#product_images_form').submit();
			};
			
			reader.readAsDataURL(fileInput.files[0]);
		}
	}
}


//Insert product image
 $('#product_images_form').on('submit',(function(e) {
  e.preventDefault();
  alert("submitted");
	  $.ajax({
		url: '<? echo base_url(); ?>Product_management/add_product_image',
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function(){ 
			
		},
		success: function(data){
			//alert(data);
			console.log(data);
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
		url:'<?php echo base_url(); ?>Product_management/get_product_images',
		method:"POST", 
		data:{ product_id:'<?= $Product_details->product_id ?>' },
		success:function(data)
		{  //console.log(data);
			//alertify.success("Delete Successfully");
			$('#image_body').html(data);
		},
		error: function(e){ 
			alertify.error("Somthing Wrong");
			console.log(e);
		} 
	});
}

function delete_product_image(id){
	var result = confirm("Want to delete?");
	if (result) { 

		$.ajax({
			url:'<?php echo base_url(); ?>Product_management/delete_product_image',
			method:"POST", 
			data:{ id:id },
			success:function(data)
			{  
				alertify.success("Delete Successfully");
				get_product_images();
			},
			error: function(e){ 
				alertify.error("Somthing Wrong");
				console.log(e);
			} 
		});
	}
}

function chnage_image_order(id){
	var order = $('#order-'+id).val();
	$.ajax({
		url:'<?php echo base_url(); ?>Product_management/chnage_product_image_order',
		method:"POST", 
		data:{ id:id, order:order },
		success:function(data)
		{  
			alertify.success("Chage Image Order Successfully");
			get_product_images();
		},
		error: function(e){ 
			alertify.error("Somthing Wrong");
			console.log(e);
		} 
	});
}

</script>	

	
	

	
	