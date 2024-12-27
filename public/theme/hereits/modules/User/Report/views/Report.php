<style>
h6{
	margin-bottom: 7px;
}
</style>
<section class="content" style="margin-top: 35px; margin-bottom: 100px; margin-left: 3%;" >
    <div class="container-fluid">
		<div class="row" style="margin-top:50px , margin-bottom: 200px;">
			<div class="col-md-12">
				<div class="card" style="width: 94%;">
					<div class="card-header">
						<h3 class="card-title">Report Description</h3>
					</div>
					<div class="card-body">
						<form id="product_detail" action="<?php base_url(); ?>Report/insert_report" method="POST" enctype="multipart/form-data">
							<div class="row">
							
								<div class="col-6">
									<div >
										<h6>Email :</h6>
										<input type="email" name="email" id="email" class="form-control" placeholder="Enter your Email">
									</div>
								</div>
							</div>
							<div class="row">	
								<div class="col-6">
									<div >
										<h6>Description :</h6>
										<textarea name="description" class="form-control" placeholder="Enter Description"></textarea>
									</div>
								</div>
							</div>
							<div class="col-4" style=" margin-left: -12px;">
									<div class="form-group">
										<h6>Upload Image</h6>
										<input type="file" name="images"  id="images" onchange="fileValidation()" class="form-control">
									</div>
								</div>
							<div >
								<button type="submit" onClick="messages()" class="btn btn-primary">Send</button>
							</div>
						</form>
					</div>
				</div>
			</div>
        </div>
	</div>
</section>
<script>
	
	function messages() {
		alert("Thanks For Reporting");
	}
	
	function fileValidation() { 
	var fileInput = document.getElementById('images'); 
    var filePath = fileInput.value; 
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i; 

	var files = fileInput.files;
	var file = files[0]; 
        if (!allowedExtensions.exec(filePath)) { 
            alert('Invalid file type'); 
            fileInput.value = ''; 
            return false; 
        } 
 } 
</script>

	

	