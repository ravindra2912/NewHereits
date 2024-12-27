<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">App Banners</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>App_banner_management">Home</a></li>
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
						<h3 class="card-title">Upload App Banners</h3>
					</div>
					<div class="card-body">
						<form id="app_banner_form" method="POST" enctype="multipart/form-data">
							<input onchange="check_image(this.id);" type="file" name="app_banner_images" id="app_banner_images" style="display:none;" class="form-control" >
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
	
	  var files = fileInput.files;
	   var file = files[0]; 
		
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
				$("#app_banner_form").submit();
			};
			reader.readAsDataURL(fileInput.files[0]);
		}
	}
}



//Insert product image
 $("#app_banner_form").on('submit',(function(e) {
   
  e.preventDefault();
	  $.ajax({
		url: '<? echo base_url(); ?>App_banner_management/add_app_banner',
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
			get_app_banners();
			
		},
		error: function(e){ 
			alert('Somthing Wron');
			console.log(e);
		}           
	});
 }));

get_app_banners();
function get_app_banners(){
	$.ajax({
		url:'<?php echo base_url(); ?>App_banner_management/get_app_banners',
		method:"POST", 
		data:{},
		success:function(data)
		{  
			var pre = '<div class="col-sm-2 col-6" onclick="gotofile()" id="addbutton" style="margin: 0px 0px 20px 0px;box-shadow: 0 0 1px rgba(0,0,0,.105),0 5px 3px rgba(0,0,0,.2);text-align: center;">';
				pre +='<i class="fas fa-upload" style="font-size: 115px;color: gray;height: 100px;object-fit: contain;padding-top: 20px;"></i>';
				pre +='<p style="color: gray;">Add Image</p>';
				pre+='<label class="error" style="font-size: 12px; margin-left: 10px;" > Max Image Size 300kb  Upload Upto 8 images *</label>';
				pre +='<input onchange="check_image(this.id);" type="file" name="app_banner_images" id="app_banner_images" style="display:none;" class="form-control" >';
				pre +='</div>';
			
			$('#image_body').html(pre+ data);
		},
		error: function(e){ 
			alertify.error("Somthing Wrong");
			console.log(e);
		} 
	});
}

function gotofile(){
	$('#app_banner_images').click();
}

//delete Service Parent Category
function delete_app_banner(id){
	var result = confirm("Want to delete?");
	if (result) { 

		$.ajax({
			url:'<?php echo base_url(); ?>App_banner_management/delete_app_banner',
			method:"POST", 
			data:{id : id},
			success:function(data)
			{  
				alertify.success("Delete Successfully");
				get_app_banners();
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
		url:'<?php echo base_url(); ?>App_banner_management/chnage_image_order',
		method:"POST", 
		data:{ id:id, order:order },
		success:function(data)
		{  
			alertify.success("Chage Image Order Successfully");
			get_app_banners();
		},
		error: function(e){ 
			alertify.error("Somthing Wrong");
			console.log(e);
		} 
	});
}


</script>