<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>User_management">Home</a></li>
					<li class="breadcrumb-item active"><?php echo $main_content; ?></li>
					<li class="breadcrumb-item"><a href="#">Product image</a></li>
				</ol>
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
						<h3 class="card-title">Product Images </h3>
					</div>
					<div class="card-body">
						<form role="form" id="product_images_form" name="product_images_form"  action="#" enctype="multipart/form-data">
							<input type="hidden" name="product_id" value="<?= $product_id ?>" >
								<div class="row">
									<div class="col-sm-12">
										<button onclick="{$('#product_images').click();}" type="button" class="btn btn-md btn-success" style="float: right;"><i class="fas fa-plus" style="font-size: 15px;"></i></button>
										<input onchange="check_image(this.id);" type="file" name="product_images" id="product_images" style="display:none;" class="form-control" >
									</div>
								</div>
							<div class="row" id="image_body"></div>
							<div class="card-footer">
								<a href="<?php echo base_url(); ?>Product_management" class="btn btn-primary">Submit</a>
							</div>
						</form>
					
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="modal fade" id="full_image">
    <div class="modal-dialog modal-xl">
		<div class="modal-body" style="text-align: center;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<img src="" id="full_image_view" style="max-height: auto;max-width: 1140px"/>
		</div>
	</div>	
 </div>         <!-- /.modal-content -->
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
		data:{ product_id:'<?= $product_id ?>' },
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