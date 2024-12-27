<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>User_management">Home</a></li>
              <li class="breadcrumb-item"><a href="#">User List</a></li>
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
                <form role="form" name="update_form" action='<?php echo base_url(); ?>User_management/update_user' method="POST" enctype="multipart/form-data">
                
				<div class="row">
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
                
				<div class="row">
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
					    <label>First Name :</label> <span class="error">*</span>
						 <input type="text" name="user_id" value="<?php echo $user_data->user_id;?>" class="form-control" hidden>
                        <input type="text" value="<?php echo $user_data->frist_name;?>"  name="frist_name" id="frist_name" class="form-control" placeholder="Enter First Name">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Last Name :</label> <span class="error">*</span>
                        <input type="text" class="form-control" value="<?php echo $user_data->last_name;?>" name="last_name" id="last_name" placeholder="Enter last Name">
                      </div>
                    </div>
                  
				  
				  <div class="col-sm-4">
					<div class="form-group">
						<label> Username :</label> <span class="error">*</span>
						<input type="text" class="form-control" value="<?php echo $user_data->username;?>" id="username" name="username" placeholder="Enter ...">
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
						<label> Contact :</label> <span class="error">*</span>
						<input type="text" class="form-control" value="<?php echo $user_data->contact;?>" id="contact" name="contact" placeholder="Enter ...">
					</div>
                  </div>
				  
				  <div class="col-sm-4">
					<div class="form-group">
						<label> User Referral code:</label> <span class="error">*</span>
						<input type="text" class="form-control" value="<?php echo $user_data->user_referal;?>"  readonly>
					</div>
                  </div>
				  
				  <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Select Gender  :</label> <span class="error">*</span>
                        <select name= "gender" class="form-control">
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
							<input type="number" class="form-control" value="<?php echo $user_data->adhar_card_number;?>" id="adhar_card_number" name="adhar_card_number" placeholder="Enter ...">
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group">
							<label for="exampleInputFile">Adhar-Card Front Image :</label> 
								<div class="uploadimage jstinput common-profile-frames" style="text-align: -webkit-center;">
										<input type="file"  accept="image/*" name="adhar_card_front_image" id="file1"  onchange="loadFile2(event)" style="display: none;">
										<label for="file1" style="cursor: pointer;"><img id="output1" src="<?php echo base_url().$user_data->adhar_card_front_image;?>" style="width:251px; height:140px;"></label><br>
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
										<input type="file"  accept="image/*" name="adhar_card_back_image" id="file2"  onchange="loadFile3(event)" style="display: none;">
										<label for="file2" style="cursor: pointer;"><img id="output2" src="<?php echo base_url().$user_data->adhar_card_back_image;?>" style="width:251px; height:140px;"></label><br>
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
							<div class="form-group">
								<label> Adhar-Card Verfied :</label>
								<input type="checkbox" class="form-control" value="1" style="width:7%;height: 16px;" id="adhar_verifed" name="adhar_verifed" <?php if ($user_data->adhar_verifed ==1){ echo "Checked";}?>>							
							</div>
						</div>
						<div class="col-sm-4">
						  <!-- text input -->
						  <div class="form-group">
						 	<label>Family Member Name :</label> 
							<input type="text" value="<?php echo $user_data->family_name;?>"  name="family_name" id="family_name" class="form-control" placeholder="Enter First Name">
						  </div>
						</div>
						
						<div class="col-sm-4">
						  <!-- text input -->
						  <div class="form-group">
						 	<label>Relation:</label>
							<input type="text" value="<?php echo $user_data->family_relation;?>"  name="family_relation" id="family_relation" class="form-control" placeholder="Enter First Name">
						  </div>
						</div>
						
						<div class="col-sm-4">
						  <!-- text input -->
						  <div class="form-group">
						 	<label>Contact: </label> 
							<input type="text" value="<?php echo $user_data->family_contact;?>"  name="family_contact" id="family_contact" class="form-control" placeholder="Enter First Name">
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
						
						<div class="col-sm-4">
						  <!-- select -->
						  <div class="form-group">
							<label>Select :</label> <span class="error">*</span>
								<select name= "user_status" class="form-control">
									<option value="">Select Status</option>
									<option value="0" <?php if($user_data->user_status == 0){ echo "Selected";}?>>INACTIVE</option>
									<option value="1" <?php if($user_data->user_status == 1){ echo "Selected";}?>>ACTIVE</option>
								</select>
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
					contact: {
						required: true,
						minlength: 10,
						maxlength:12,
						number: true
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
				contact: {
					  required: '<p> *Please enter contact number</p>',
					  minlength:'<p> *Please enter minimum 10digits required</p>',
					  maxlength:'<p> *Please enter maximum 12digits allowed</p>',
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
//for image full view
function image_view_modal(image_src){
	$('#full_image').modal('show');
	document.getElementById("full_image_view").src = image_src;
}
</script>	

	
	

	
	