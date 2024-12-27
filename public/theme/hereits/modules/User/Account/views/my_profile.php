<div class="container mt-4 mb-4">
      <div class="row">
		<!-- this for user sidebar -->
		<?php include 'user_sidebar.php';?>
		
        <div class="col-lg-9">
          <div class="bg-white shadow-md rounded p-4"> 
            <!-- Personal Information
          ============================================= -->
            <h4 class="mb-4">Personal Information</h4>
			<hr class="mx-n4 mb-4">
                
                <form id="personalInformation" action="<?= base_url()?>Account/update_profile" method="post" enctype="multipart/form-data">>
				<div class="row">
					<div class="form-group col-lg-12" style="text-align: -webkit-center;">
						<image onclick="image_view_modal(this.src)" src="<?php echo base_url().$profile_data->user_image; ?>" style="height: 200px;width: auto;" alt="Store Image" />
						<input type="file" name="user_image" class="form-control" style="width: 25%;">
					</div>

					  <div class="form-group col-lg-6">
						<label for="frist_name">First Name</label>
						<input type="text" value="<?= $profile_data->frist_name?>" class="form-control" data-bv-field="frist_name" id="frist_name" name="frist_name"  placeholder="First Name">
					  </div>
					  <div class="form-group col-lg-6">
						<label for="last_name">Last Name</label>
						<input type="text" value="<?= $profile_data->last_name?>" class="form-control" data-bv-field="last_name" id="last_name" name="last_name"  placeholder="Last Name">
					  </div>
					  <div class="form-group col-lg-6">
						<label for="username">username</label>
						<input type="text" value="<?= $profile_data->username?>" class="form-control" data-bv-field="username" id="username" name="username"  placeholder="Username">
					  </div>
					  <div class="form-group col-lg-6">
						<label for="contact">Mobile Number</label>
						<input type="text" value="<?= $profile_data->contact?>" class="form-control" data-bv-field="contact" id="contact" name="contact"  placeholder="Mobile Number">
					  </div>
					  <div class="form-group col-lg-6">
						<label for="email">Email ID</label>
						<input type="text" value="<?= $profile_data->email?>" class="form-control" data-bv-field="email" id="email" name="email"  placeholder="Email ID">
					  </div>
					  
					  <div class="mb-3 col-lg-6">
						<div class="custom-control custom-radio custom-control-inline">
						  <input id="1" name="gender" value="1" class="custom-control-input" <?php if($profile_data->gender == 1){ echo "Checked";}?>  type="radio">
						  <label class="custom-control-label" for="1">Male</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
						  <input id="2" name="gender" value="2" class="custom-control-input" <?php if($profile_data->gender == 2){ echo "Checked";}?>  type="radio">
						  <label class="custom-control-label" for="2">Female</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
						  <input id="3" name="gender" value="3" class="custom-control-input" <?php if($profile_data->gender == 3){ echo "Checked";}?>  type="radio">
						  <label class="custom-control-label" for="3">Other</label>
						</div>
					  </div>
					  
					  </div>
                  
                  <button class="btn btn-primary" type="submit">Update Now</button>
				  <a class="btn btn-danger" href="<?= base_url()?>Account/reset_password" >Reset Password</a>
				  <p class="login-box-msg" style="color:red;"><?php echo $this->session->flashdata('success_msg'); ?></p>
                </form>
              
          </div>
        </div>
      </div>
    </div>

<script>
			$("#personalInformation").validate(
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
					contact: {
					  required: true,
						minlength: 10,
						maxlength:10,
					},
					email: {
						required: true,
						email:true,
					},
					gender: {
						required: true,
					},				
				},
		   
			messages: 
			{
					frist_name: '<p style="color:red;"> *Please Enter First Name</p>',
					last_name: '<p style="color:red;"> *Please Enter Last Name</p>',
					username: '<p style="color:red;"> *Please Enter Username</p>',
					contact: {
						required: '<p style="color:red;"> *Please Enter Phone number</p>',
						minlength: '<p style="color:red;"> *Phone number must be of 10 Digits</p>',
						maxlength:'<p style="color:red;"> *Phone number must be of 10 Digits</p>',
					},
					email: {
						required: '<p style="color:red;"> *Please Enter Email</p>',
						email:'<p style="color:red;"> *Please Enter Correct Mail</p>',
					},
					gender: '<p style="color:red;"> *Please Select Gender</p>',		
				},
			  
			submitHandler: function(form) {
				form.submit();
			}
		});


</script>	