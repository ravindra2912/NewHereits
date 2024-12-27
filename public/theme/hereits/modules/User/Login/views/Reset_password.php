<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Hereits | Login </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
  <style>
	.mobile-show {
      display: none;
	} 
	.web-show {
      display: block;
	} 
@media screen and (max-width: 767px) {
    .mobile-show {
      display: block; 
	} 
	.mb-3, .my-3 {
    margin-bottom:0rem;
	}
	.web-show {
      display: none;
	} 
	body{
		display: unset !important;
	}
	

}
  </style>
</head>
<body class="hold-transition login-page" >
<div class="login-box web-show">
  <div class="login-logo">
    <a href="../../index2.html"><b>Hereits</b> Store</a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg" style="color:red;"><?php echo $this->session->flashdata('error_msg'); ?></p>

    <form id="reset_pswrd" class="myform" action="<?php echo base_url();?>Login/update_password/<?= $user->user_id?>" method="post">
        <div class="input-group mb-3">	
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
		<label id="error" class="error" for="password" style="color: red;font-weight: 400; font-size: 14px;"></label>
		<div class="input-group mb-3">
          <input type="password" class="form-control" id="conform_password" name="conform_password" placeholder="Conform Password" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
		<label id="conform_password-error" class="error" for="conform_password" style="color: red;font-weight: 400; font-size: 14px;"></label>
		<div class="col-12">
			<button type="submit" class="btn btn-primary btn-block" id="submit"  >Conform</button>
		</div>
    </form>
      
    </div>
  </div>
</div>


<!-- /////////////////////// for mobile view ///////////////////////// -->
<div class="mobile-show" style="width: unset; background-color: blue;">
  <div class="login-logo w3-animate-bottom" style="padding-top: 10px;">
    <a href="../../index2.html" style="color: #fff;"><b>Hereits</b> Store</a>
  </div>
  <!-- /.login-logo -->
  <div class="card" style="background: unset; height: 100vh;">
    <div class="card-body login-card-body w3-animate-bottom" style="border-top-left-radius: 40px;border-top-right-radius: 40px;">
		<p style="font-size: 26px;font-weight: bold;color: #000;margin-bottom: 0px;">Reset Password</p>
		<p style="color: #000;"></p>

    <form id="reset_pswrd_mobile" class="myform" action="<?php echo base_url();?>Login/update_password/<?= $user->user_id?>" method="post">
        
        <div class="input-group mb-3">	
          <input type="password" class="form-control" id="passwords" name="password" placeholder="Password" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
		<label id="error" class="error" for="password" style="color: red;font-weight: 400; font-size: 14px;"></label>
		<div class="input-group mb-3">
          <input type="password" class="form-control" id="conform_password" name="conform_password" placeholder="Conform Password" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
		<label id="conform_password-error" class="error" for="conform_password" style="color: red;font-weight: 400; font-size: 14px;"></label>
		<div class="col-12">
			<button type="submit" class="btn btn-primary btn-block" id="submit"  >Conform</button>
		</div>
      </form>
      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<script>


$('#reset_pswrd').validate({
  rules: {
    password: {
      required: true,
      useradd_pwcheck: true,
    },
    conform_password :{
		equalTo: "#password"
	},
  },
  messages: {
    password: {
		required:"<p>Please Enter new password</p>",
		useradd_pwcheck: '<p style="color: red;">Password should be at least 8 digits and must contains at least one alphabet and one digit.</p>',
    },
	conform_password:{
		equalTo: "<p>Password Didn't Match</p>",
	},
	
  },
});
$('#reset_pswrd_mobile').validate({
  rules: {
    password: {
      required: true,
      useradd_pwcheck: true,
    },
    conform_password :{
		equalTo: "#passwords"
	},
  },
  messages: {
    password: {
		required:"<p>Please Enter new password</p>",
		useradd_pwcheck: '<p style="color: red;">Password should be at least 8 digits and must contains at least one alphabet and one digit.</p>',
    },
	conform_password:{
		equalTo: "<p>Password Didn't Match</p>",
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
<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/admin/dist/js/adminlte.min.js"></script>

</body>
</html>
