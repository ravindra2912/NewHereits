

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

<style>
p{
	margin-top: 16px;
    margin-bottom: 0.5rem;
}
</style>
<section class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Upload Product Images</h3>
					</div>
					<div class="card-body">
						<form id="product_image_form" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="product_id" id="product_id" value="<?= $product_id?>" />
							<input onchange="check_image(this.id);" type="file" name="product_images" id="product_images" style="display:none;" class="form-control" >
						</form>	
					
						<div class="row" id="image_body">
											
						</div>
						<div class="card-footer" style="font-size:15px">
							<input type="Checkbox" id="allrights" onchange="check_right()" value="1" Checked><label>By clicking ,on this box "I Agree that i have all rights to sell this Product.Hereits not liable for any kind of legal issues or any other disputes for listing this Product on platform".</label>
						</div>
						<div class="card-footer" style="text-align-last: right;">
							<a href="<?= base_url() ?>Store_products" class="onclick-load btn btn-primary" id="btnsave">Save</a>
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
	
	  var files = fileInput.files;
	   var file = files[0]; 
	if(file.size > 300000){
		alert("File should less then 300kb");
		die;
	}
		
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

// Allrights agreemnent 
function check_right(){
	if($("#allrights").prop('checked') == true){
		$('#btnsave').show();
	}else {
		$('#btnsave').hide();
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
		beforeSend:function(response)
		{ 
			document.getElementById("load").style.visibility = "unset"; 
		},
		success: function(data){
			//alert(data);
			//console.log(data);
			image_count();
			get_product_images();
			document.getElementById("load").style.visibility = "hidden"; 
			
		},
		error: function(e){ 
			alert('Somthing Wron');
			console.log(e);
			document.getElementById("load").style.visibility = "hidden"; 
		}           
	});
 }));

get_product_images();
function get_product_images(){
	$.ajax({
		url:'<?php echo base_url(); ?>Store_products/get_product_images',
		method:"POST", 
		data:{ product_id: $('#product_id').val() },
		beforeSend:function(response)
		{ 
			document.getElementById("load").style.visibility = "unset"; 
		},
		success:function(data)
		{  
			var pre = '<div class="col-sm-2 col-6" onclick="gotofile()" id="addbutton" style="margin: 0px 0px 20px 0px;box-shadow: 0 0 1px rgba(0,0,0,.105),0 5px 3px rgba(0,0,0,.2);text-align: center;">';
				pre +='<i class="fas fa-upload" style="font-size: 115px;color: gray;height: 100px;object-fit: contain;padding-top: 20px;"></i>';
				pre +='<p style="color: gray;">Add Image</p>';
				pre+='<label class="error" style="font-size: 12px; margin-left: 10px;" > Max Image Size 300kb  Upload Upto 8 images *</label>';
				pre +='<input onchange="check_image(this.id);" type="file" name="product_images" id="product_images" style="display:none;" class="form-control" >';
				pre +='</div>';
			
			image_count();
			$('#image_body').html(pre+ data);
			document.getElementById("load").style.visibility = "hidden"; 
		},
		error: function(e){ 
			alertify.error("Somthing Wrong");
			console.log(e);
			document.getElementById("load").style.visibility = "hidden"; 
		} 
	});
}


function gotofile(){
	$('#product_images').click();
}

//delete Service Parent Category
function delete_product_image(id){
	var result = confirm("Want to delete?");
	if (result) { 

		$.ajax({
			url:'<?php echo base_url(); ?>Store_products/delete_product_image',
			method:"POST", 
			data:{id : id},
			success:function(data)
			{  
				alertify.success("Delete Successfully");
				image_count();
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
			image_count();
			get_product_images();
		},
		error: function(e){ 
			alertify.error("Somthing Wrong");
		} 
	});
}
function  image_count(){
	$.ajax({
		url:'<?php echo base_url(); ?>Store_products/get_product_images_count',
		method:"POST", 
		data:{ product_id: $('#product_id').val() },
		success:function(response)
		{  
			if (response == 0){
				$('#btnsave').hide();
			}else {
				$('#btnsave').show();
			}
			
			if (response >= 8){
				$('#addbutton').hide();
			}else {
				$('#addbutton').show();
			}
		},
		error: function(e){ 
			alertify.error("Somthing Wrong");
			console.log(e);
		} 
	});
}


</script>