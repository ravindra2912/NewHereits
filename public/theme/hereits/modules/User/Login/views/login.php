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

      <form id="login" action="<?php echo base_url();?>Login/chack_login" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email_id" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
			<a href="<?= base_url() ?>Login/Forgot_password" style="font-size: 14px;" >Forgot Password?</a>
          </div>
        </div>
      </form>
	  <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="<?= base_url() ?>Business" class="btn btn-block btn-primary"> Register Your business </a>
      </div>

      
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
		<p style="font-size: 26px;font-weight: bold;color: #000;margin-bottom: 0px;">Welcome Back</p>
		<p style="color: #000;">Enter Your Credential Login</p>
      <p class="login-box-msg" style="color:red;"><?php echo $this->session->flashdata('error_msg'); ?></p>

      <form id="login" action="<?php echo base_url();?>Login/chack_login" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email_id" placeholder="Email" style="border-top-left-radius: 20px;border-bottom-left-radius: 20px;" required>
          <div class="input-group-append">
            <div class="input-group-text" style="border-top-right-radius: 20px;border-bottom-right-radius: 20px;">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="password" style="border-top-left-radius: 20px;border-bottom-left-radius: 20px;" required>
          <div class="input-group-append">
            <div class="input-group-text" style="border-top-right-radius: 20px;border-bottom-right-radius: 20px;">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div -->
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" style="border-radius: 20px; font-size: 20px;">Sign In</button>
			<a href="<?= base_url() ?>Login/Forgot_password" style="font-size: 14px; margin-left: 14px;" >Forgot Password?</a>
          </div>
          <!-- /.col -->
        </div>
      </form>
	  <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="<?= base_url() ?>Business" class="btn btn-block btn-primary" style="border-radius: 20px; font-size: 20px;"> Register Your business </a>
      </div>

      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/admin/dist/js/adminlte.min.js"></script>

</body>
</html>
