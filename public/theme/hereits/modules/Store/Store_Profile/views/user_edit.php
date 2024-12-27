<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>User_management">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Store Profile</a></li>
			  <li class="breadcrumb-item active"><?php echo $main_content; ?></li>
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
                <h3 class="card-title">USER UPDATE</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form role="form" name="update_form" action='<?php echo base_url(); ?>Store_Profile/update_user' method="POST" enctype="multipart/form-data">
                
				<div class="row" id="edit_user_image" >
						<div class="col-sm-12">
							 <div class="uploadimage jstinput common-profile-frames" style="text-align: -webkit-center">
										<label>Click to Change profile</label><br>
										<input type="file"  accept="image/*" name="user_image" id="file"  onchange="loadFile(event)" style="display: none;">
										<label for="file" style="cursor: pointer;"><img id="output" src="<?php echo base_url().$user_data->user_image;?>" style="width:140px; height:140px;"></label><br>
										<a href="#" onclick="image_view_modal('<?php echo base_url().$user_data->user_image;?>')" style="background: #007bff;padding: 0.2%; padding-left: 4%; padding-right: 4%; font-weight: bold; color: white;">View</a>
										<script>
											var loadFile = function(event) {
												var image = document.getElementById('output');
												image.src = URL.createObjectURL(event.target.files[0]);
											};
										</script>
							</div>	
						</div>
				</div>
				
				<div class="row" id="view_user_image" >
						<div class="col-sm-12">
							 <div class="uploadimage jstinput common-profile-frames" style="text-align: -webkit-center">
										<img id="output4" src="<?php echo base_url().$user_data->user_image;?>" style="width:140px; height:140px;"></label><br>
										<a href="#" onclick="image_view_modal('<?php echo base_url().$user_data->user_image;?>')" style="background: #007bff;padding: 0.2%; padding-left: 4%; padding-right: 4%; font-weight: bold; color: white;">View</a>
										<script>
											var loadFile = function(event) {
												var image = document.getElementById('output4');
												image.src = URL.createObjectURL(event.target.files[0]);
											};
										</script>
							</div>	
						</div>
				</div>
                
				<div class="row">
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
					    <label>First Name :</label> <span class="error">*</span>
						 <input type="text" name="user_id" value="<?php echo $user_data->user_id;?>" class="form-control" hidden>
                        <input type="text" value="<?php echo $user_data->frist_name;?>"  name="frist_name" id="frist_name" class="form-control" >
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Last Name :</label> <span class="error">*</span>
                        <input type="text" class="form-control" value="<?php echo $user_data->last_name;?>" name="last_name" id="last_name" >
                      </div>
                    </div>
                 
				  
				  <div class="col-sm-4">
					<div class="form-group">
						<label> Username :</label>
						<input type="text" class="form-control" value="<?php echo $user_data->username;?>" id="username" name="username" >
					</div>
                  </div>
				  
				  <div class="col-sm-4">
					<div class="form-group">
						<label> Email :</label> <span class="error">*</span>
						<input type="text" class="form-control" value="<?php echo $user_data->email;?>" id="email" name="email" placeholder="Enter ...">
					</div>
                  </div>
				  
				  <div class="col-sm-4">
					<div class="form-group">
						<label> Contact :</label> 
						<input type="text" class="form-control" value="<?php echo $user_data->contact;?>" id="contact" name="contact" >
					</div>
                  </div>
				  
				  <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Select Gender  :</label> <span class="error">*</span>
                        <select name= "gender" id= "gender" class="form-control" >
						  <option value="" >Select Gender</option>
                          <option value="1" <?php if($user_data->gender == 1){ echo "Selected";}?>>Male</option>
                          <option value="2" <?php if($user_data->gender == 2){ echo "Selected";}?>>Female</option>
						  <option value="3" <?php if($user_data->gender == 3){ echo "Selected";}?>>Other</option>
                          
                        </select>
                      </div>
                    </div>
                  
				</div>
				
				<!-- Documents -->
                <div class="row">
                    <div class="col-sm-4">
						<div class="form-group">
							<label> Adhar-Card Number  :</label>
							<input type="number" class="form-control" onchange="checkadhar()" value="<?php echo $user_data->adhar_card_number;?>" id="adhar_card_number" name="adhar_card_number" >
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group">
							<label for="exampleInputFile">Adhar-Card Front Image :</label> 
								<div class="uploadimage jstinput common-profile-frames" style="text-align: -webkit-center;">
										<img id="output1" src="<?php echo base_url().$user_data->adhar_card_front_image;?>" style="width:251px; height:140px;"></label><br>
										<a href="#" onclick="image_view_modal('<?php echo base_url().$user_data->adhar_card_front_image;?>')" style="background: #007bff;padding: 0.5%;padding-left: 8%;padding-right: 8%;font-weight: bold;color: white;">View</a>
										<script>
											var loadFile2 = function(event) {
												var image1 = document.getElementById('output1');
												image1.src = URL.createObjectURL(event.target.files[0]);
											};
										</script>
								</div>	
						  </div>
                    </div>
					
					<div class="col-sm-4">
						<div class="form-group">
							<label for="exampleInputFile">Adhar-Card Back Image :</label> 
								<div class="uploadimage jstinput common-profile-frames" style="text-align: -webkit-center;">
										<img id="output2" src="<?php echo base_url().$user_data->adhar_card_back_image;?>" style="width:251px; height:140px;"></label><br>
										<a href="#" onclick="image_view_modal('<?php echo base_url().$user_data->adhar_card_back_image;?>')" style="background: #007bff;padding: 0.5%;padding-left: 8%;padding-right: 8%;font-weight: bold;color: white;">View</a>
										<script>
											var loadFile3 = function(event) {
												var image2 = document.getElementById('output2');
												image2.src = URL.createObjectURL(event.target.files[0]);
											};
										</script>
								</div>	
						  </div>
                    </div>
				</div>	
				
				<!-- Family -->
					 <div class="row">
						<div class="col-sm-4">
						  <!-- text input -->
						  <div class="form-group">
						 	<label>Family Member Name :</label> 
							<input type="text" value="<?php echo $user_data->family_name;?>"  name="family_name" id="family_name" class="form-control" >
						  </div>
						</div>
						
						<div class="col-sm-4">
						  <!-- text input -->
						  <div class="form-group">
						 	<label>Relation:</label>
							<input type="text" value="<?php echo $user_data->family_relation;?>"  name="family_relation" id="family_relation" class="form-control" >
						  </div>
						</div>
						
						<div class="col-sm-4">
						  <!-- text input -->
						  <div class="form-group">
						 	<label>Contact: </label> 
							<input type="text" value="<?php echo $user_data->family_contact;?>"  name="family_contact" id="family_contact"  class="form-control"  >
						  </div>
						</div>
					</div>

					<!--Other details -->
					<div class="row">
						<div class="col-sm-4">
						  <!-- text input -->
						  <div class="form-group">
						 	<label>Password: </label> 
							<input type="text"   name="password" id="password" class="form-control">
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
				// Wait for the DOM to be ready
		$(function() {
			$("form[name='update_form']").validate(
			{
				rules: {
					frist_name: {
					required: true,
					},
					
					last_name: {
					  required: true,
					},
					
					username: {
					  required: true,
					},
						
					email: {
					  required: true,
					  email:true
					},
					
					gender: {
					  required: true,
					},
					user_status: {
					  required: true,
					},	
					
				},
		   
			messages: 
			{
				frist_name: '<p> *Please enter First name</p>',
				last_name:'<p> *Please enter Last name</p>',
				username:'<p> *Please enter username</p>',
				
				email: {
					  required: '<p> *Please enter Email id</p>',
					  email:'<p> *Please enter correct email</p>',
				},
				
				gender:'<p> *Please Select Gender</p>',
				user_status:'<p> *Select status</p>',
				
			},
			  
			submitHandler: function(form) {
				form.submit();
			}
		});
	});
	</script>
	<script>
	$(document).ready(function(){

   $("#adhar_card_number").on('blur', function(){

      var adhar_card_number = $(this).val().trim();

      if(adhar_card_number != ''){
		//var adhar_card_number = $('adhar_card_number').val();
		$.ajax({
				url:'<?= base_url() ?>Store_Profile/check_adhar',
				method:"POST", 
				data:{ adhar_card_number:adhar_card_number },
				success:function(response){
				if(response == 'true' && adhar_card_number != <?php echo $user_data->adhar_card_number;?>){
						alert("Enter correct Adhar-Card Number");
						$("#adhar_card_number").val('');
					}else if(response == 'false'){
					 }
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					console.log(e);
				} 
			});
		}
		});
});
//for image full view
function image_view_modal(image_src){
	$('#full_image').modal('show');
	document.getElementById("full_image_view").src = image_src;
}
</script>	

	
	 <script>
	 document.addEventListener("DOMContentLoaded", function(event) {
			<?php if($store_data->store_status == 1) { ?>
				
				document.getElementById("frist_name").disabled = true;
				document.getElementById("last_name").disabled = true;
				document.getElementById("username").disabled = true;
				document.getElementById("email").disabled = true;
				document.getElementById("contact").disabled = true;
				document.getElementById("adhar_card_number").disabled = true;
				document.getElementById("gender").disabled = true;
				 
				 $('#edit_user_image').hide();
				 $('#view_user_image').show();
					
			<?php } else if($store_data->store_status == 0 || $store_data->store_status == 2) {?>	
				
				document.getElementById("frist_name").disabled = false;
				document.getElementById("last_name").disabled = false;
				document.getElementById("username").disabled = false;
				document.getElementById("email").disabled = true;
				document.getElementById("contact").disabled = true;
				document.getElementById("gender").disabled = false;
				document.getElementById("adhar_card_number").disabled = false;
				//document.getElementById("adhar_card_front_image").disabled = false;
				//document.getElementById("adhar_card_back_image").disabled = false;
				
				$('#view_user_image').hide();
				
				$('#edit_user_image').show();
				
			<?php } ?>	
	});
		
		</script>

	
	