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
						<div class="card card-warning">
							<div class="card-header">
								<h3 class="card-title">Product Images</h3>
							</div>
							<div class="card-body">
								<form id="product_images_form" class="myform" action="#" method="POST" enctype="multipart/form-data">
									<input type="hidden" name="product_id" value="<?= $Product_details->product_id ?>" />
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
		  
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">PRODUCT UPDATE</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  
                <form role="form" name="update_form" action='<?php echo base_url(); ?>Product_management/update_product' method="POST" enctype="multipart/form-data">
                
				
				<label> <input type="checkbox" name="show_in_listing" id="show_in_listing" value="1" <?php if($Product_details->show_in_listing == 1){ echo "Checked";}?>> Show in Listing </label>
				<div class="row">
					
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
					    <label>Product Name :</label> <span class="error">*</span>
						 <input type="text" name="product_id" value="<?php echo $Product_details->product_id;?>" class="form-control" hidden>
                        <input type="text" value="<?php echo $Product_details->product_name;?>"  name="product_name" id="product_name" class="form-control" placeholder="Enter First Name">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Product Price :</label> <span class="error">*</span>
                        <input type="number" class="form-control" value="<?php echo $Product_details->product_price;?>" name="product_price" id="product_price" placeholder="Enter last Name">
                      </div>
                    </div>
                  
				  
				  <div class="col-sm-4">
					<div class="form-group">
						<label> product Sale Price :</label> <span class="error">*</span>
						<input type="number" class="form-control" value="<?php echo $Product_details->product_sele_price;?>" id="product_sele_price" name="product_sele_price" placeholder="Enter ...">
					</div>
                  </div>
				  
				  <div class="col-sm-4">
					<div class="form-group">
						<label> Product brand :</label>
						<input type="text" class="form-control" value="<?php echo $Product_details->brand_name; ?>" id="brand_name" name="brand_name" placeholder="Enter ...">
					</div>
                  </div>
				  
				  <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Product Main Category :</label> <span class="error">*</span>
                        <select onchange="get_child_category(this.value)" class="form-control select2" name="product_parent_category" id="product_parent_category" style="width: 100%;">
											<option value="">Select Parent Category</option>
											<?php
												foreach($parent_cat_data as $val){ ?>
													<option value="<?=$val->category_id?>" <?php if($val->category_id == $Product_details->product_parent_category){ echo "selected";} ?> ><?=$val->category_name?></option>
												<?php }	?>
										</select>
                      </div>
                    </div>
					
					<div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Product Sub Category :</label> 
                        <select class="form-control select2" name="product_child_category" id="product_child_category" style="width: 100%;">
											<option value="">Select Child Category</option>
											<?php
												foreach($child_cat_data as $val){ ?>
													<option value="<?=$val->category_id?>" <?php if($val->category_id == $Product_details->product_child_category){ echo "selected";} ?> ><?=$val->category_name?></option>												<?php }	?>
										</select>
                      </div>
                      </div>
				  			  
					
					<div class="col-sm-4">
						<div class="form-group">
							<label>Selling Unit</label> <label class ="error">*</label>
								<select  class="form-control select" name="selling_unit" id="selling_unit" style="width: 100%;">
									<option value="">Select Selling Unit</option>
									<option <?php if($Product_details->selling_unit == "KG"){echo 'selected';} ?> value="KG">KG</option>
									<option <?php if($Product_details->selling_unit == "GRAMS"){echo 'selected';} ?> value="GRAMS">GRAMS</option>
									<option <?php if($Product_details->selling_unit == "UNIT"){echo 'selected';} ?> value="UNIT">UNIT</option>
									<option <?php if($Product_details->selling_unit == "PIECE"){echo 'selected';} ?> value="PIECE">PIECE</option>
									<option <?php if($Product_details->selling_unit == "LTR"){echo 'selected';} ?> value="LTR">LTR</option>
									<option <?php if($Product_details->selling_unit == "MI"){echo 'selected';} ?> value="MI">MI</option>
									<option <?php if($Product_details->selling_unit == "DOZEN"){echo 'selected';} ?> value="DOZEN">DOZEN</option>
									<option <?php if($Product_details->selling_unit == "HALF DOZEN"){echo 'selected';} ?> value="HALF DOZEN">HALF DOZEN</option>
									<option <?php if($Product_details->selling_unit == "BUNDLE"){echo 'selected';} ?> value="BUNDLE">BUNDLE</option>
								</select>
						</div>
					</div>
								
					<div class="col-sm-4">
						<div class="form-group">
							<label>Selling Unit QTY</label> <label class ="error">*</label>
							<input type="text" name="selling_unit_qty" id="selling_unit_qty" value="<?= $Product_details->selling_unit_qty ?>" class="form-control" placeholder="Selling Unit Quantity">
						</div>
					</div>
					<div class="col-sm-4">
						  <!-- select -->
						  <div class="form-group">
							<label>Product Status :</label> <span class="error">*</span>
							<select name= "product_status" class="form-control">
							  <option value="" >Select Status</option>
							  <option value="0" <?php if($Product_details->product_status == 0){ echo "Selected";}?>>PENDING FOR APPROVEL</option>
							  <option value="1" <?php if($Product_details->product_status == 1){ echo "Selected";}?>>Active</option>
							  <option value="2" <?php if($Product_details->product_status == 2){ echo "Selected";}?>>De-active</option>
							  <option value="2" <?php if($Product_details->product_status == 3){ echo "Selected";}?>>Deleted</option>
													   
							</select>
						  </div>
                    </div>
					 
					<div class="col-sm-4">
						<div class="form-group">
							<label>Product Tags :</label> 
							<input type="text" class='tags_input'  value="<?php echo $tag;?>" id="product_tag"  name="product_tag" placeholder="Enter ...">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>Product Description:</label> 
							<textarea class="form-control"  id="product_description" name="product_description" placeholder="Enter ..."><?php echo $Product_details->product_description;?></textarea>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group" style="margin-top: 38px; text-align: -webkit-center;">
							<label> <input type="checkbox" name="fixed_selling_unit" id="fixed_selling_unit" value="1" <?php if($Product_details->fixed_selling_unit == 1){ echo "Checked";}?>> Fixed Selling Unit </label> 
							<label> <input type="checkbox" name="brand_fixed" id="brand_fixed" value="1" <?php if($Product_details->brand_fixed == 1){ echo "Checked";}?>> Fixed Brand </label> 
							 
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
    </section>
	
	<!-- full view Image Modal -->  
<div class="modal fade" id="full_image">
    <div class="modal-dialog modal-xl"">
		<div class="modal-body" style="text-align: center;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<img src="" id="full_image_view" style="max-height: auto;max-width: 1140px"/>
		</div>
          <!-- /.modal-content -->
    </div>
        <!-- /.modal-dialog -->
</div> 
</div>
	</div>
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
				// Wait for the DOM to be ready
		$(function() {
			$("form[name='update_form']").validate(
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
					},
								
					product_parent_category: {
						required: true,
					},
					product_status: {
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
				},
				product_parent_category: '<p> *Please enter Parent Category</p>',
				product_status:'<p> *Select status</p>',
				
			},
			  
			submitHandler: function(form) {
				form.submit();
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

	
	

	
	