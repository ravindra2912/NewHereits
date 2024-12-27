<div class="container mt-4 mb-4">
      <div class="row">
		<!-- this for user sidebar -->
		<?php include 'user_sidebar.php';?>
		
        <div class="col-lg-9">
          <div class="bg-white shadow-md rounded p-4"> 
            <!-- Personal Information
          ============================================= -->
            <h4 class="mb-4">Reset Password</h4>
			<hr class="mx-n4 mb-4">
                
                <form id="reset_pswrd" action="<?= base_url()?>Account/update_password" method="post">
				<div class="row">
                  <div class="form-group col-lg-6">
                    <label for="old_pswrd">Old Password</label>
                    <input type="text" class="form-control" data-bv-field="old_pswrd" id="old_pswrd" name="old_pswrd" required="" placeholder="Old Password">
					<p class="login-box-msg" style="color:red;"><?php echo $this->session->flashdata('error_msg'); ?></p>
				  </div>
				  
				  <div class="form-group col-lg-6">
                    <label for="new_pswrd">New Password</label>
                    <input type="text" 	 class="form-control" data-bv-field="new_pswrd" id="new_pswrd" name="new_pswrd" required="" placeholder="New Password">
                  </div>
                  
                  <div class="form-group col-lg-6">
                    <label for="conform_pswrd">Conform Password</label>
                    <input type="text" 	 class="form-control" data-bv-field="conform_pswrd" id="conform_pswrd" name="conform_pswrd" required="" placeholder="Conform Password">
                  </div>
                  </div>
                  
                  <button class="btn btn-primary" type="submit">Reset Password</button>
                </form>
              
          </div>
        </div>
      </div>
    </div>
<script>


$('#reset_pswrd').validate({
  rules: {
    new_pswrd: {
      required: true,
      useradd_pwcheck: true,
    },
    conform_pswrd :{
		equalTo: "#new_pswrd"
	},
  },
  messages: {
    new_pswrd: {
		required:"<p>Please Enter new password</p>",
		useradd_pwcheck: '<p style="color: red;">Password should be at least 8 digits and must contains at least one alphabet and one digit.</p>',
    },
	conform_pswrd:{
		equalTo: '<p style="color: red;">Password Didnt Match</p>',
	},
	
  },
});
$.validator.addMethod("useradd_pwcheck",function(value, element) {
		if(value == ''){
			return true;
		}else{
			return /^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,}$/.test(value);
		}
	}); 

</script>	