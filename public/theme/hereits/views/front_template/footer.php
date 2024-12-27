
  </div>
  <!-- Content end --> 
  
 
  <!-- Mobile navigation ============================================= -->
  <div class="home-menu-icon-container">
		<div class="mobile-icon-section pt-1 pb-1 pr-2 pl-2">
			<a href="<?= base_url() ?>Home" class="<?php if($main_content == 'Home'){ echo 'active';} ?>"><i class="fas fa-home" style="font-size:25px"></i><span> Home</span></a>
			<a href="<?= base_url() ?>Product" class="<?php if($main_content == 'Product'){ echo 'active';} ?>"><i class="fab fa-dropbox" style="font-size:25px"></i><span> Products</span></a>
			<a href="<?= base_url() ?>Store" class="<?php if($main_content == 'stores'){ echo 'active';} ?>"><i class="fas fa-store-alt" style="font-size:25px"></i><span> Stores</span></a>
			<a href="<?= base_url() ?>Services" class="<?php if($main_content == 'Services'){ echo 'active';} ?>"><i class="fas fa-list-ul" style="font-size:25px"></i><span> Services</span></a>
			<?php if($this->session->User != null){ ?>
				<a href="<?= base_url() ?>Account" class="<?php if($main_content == 'Account'){ echo 'active';} ?>"><i class="far fa-user" style="font-size:25px"></i><span> Account</span></a>
			<?php }else{ ?>
				<a data-toggle="modal" data-target="#login-modal" href="#"><i class="far fa-user" style="font-size:25px"></i><span> Account</span></a>
			<?php } ?>
		</div>
	</div>


  <!-- Footer
  ============================================= -->
 <footer id="footer" class="bg-dark footer-text-light pt-5 pb-4 mt-0">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-md mb-3 mb-md-0">
          <h4 class="text-3 text-white font-weight-400 mb-3">About</h4>
          <ul class="nav flex-column">
            <li class="nav-item"> <a target="_blank" class="nav-link" href="<?= base_url() ?>Contact_us" title="Hereits Contact Us">Contact Us</a></li>
            <li class="nav-item"> <a target="_blank" class="nav-link" href="<?= base_url() ?>About_us" title="Hereits About Us">About Us</a></li>
            <li class="nav-item"> <a target="_blank" class="nav-link" href="<?= base_url() ?>Business" title="Hereits For business">Register Your business</a></li>
            <!-- li class="nav-item"> <a target="_blank" class="nav-link" href="<?= base_url() ?>Report" title="">Report</a></li -->
            <li class="nav-item"> <a target="_blank" class="nav-link" href="<?= base_url() ?>Credits" title="">Credits</a></li>
          </ul>
        </div>
        <div class="col-sm-6 col-md mb-3 mb-md-0">
          <h4 class="text-3 text-white font-weight-400 mb-3">Policy</h4>
          <ul class="nav flex-column">
            <li class="nav-item"> <a target="_blank" class="nav-link" href="<?= base_url() ?>Terms" title="Hereits Terms &amp; Conditions">Terms Of Use</a></li>
            <li class="nav-item"> <a target="_blank" class="nav-link" href="<?= base_url() ?>Privacy" title="Hereits PRIVACY POLICY">Privacy</a></li>
            <li class="nav-item"> <a target="_blank" class="nav-link" href="<?= base_url() ?>Copyright" title="Hereits Copy Rights">Copyright</a></li>
            <li class="nav-item"> <a target="_blank" class="nav-link" href="<?= base_url() ?>Faqs" title="">FAQ</a></li>
          </ul>
        </div>
        
        <!-- div class="col-12 col-lg-3">
          <h4 class="text-3 text-white font-weight-400 mb-3">Subscribe</h4>
          <div class="form-group">
            <div class="input-group newsletter">
              <input class="form-control" placeholder="Your Email Address" name="newsletterEmail" id="newsletterEmail" type="text">
              <span class="input-group-append">
              <button class="btn btn-secondary" type="submit" data-toggle="tooltip" data-original-title="Subscribe"><i class="fas fa-paper-plane"></i></button>
              </span> </div>
            <small class="form-text text-white-50">Subscribe to receive latest offers and updates.</small> </div>
          
        </div -->
		
		<div class="col-12 col-lg-3">
			<h4 class="text-3 text-white font-weight-400 mb-3">Download App</h4>
				<div class="form-group">
					<a href="https://play.google.com/store/apps/details?id=com.hereits"><img alt="" src="<?php echo base_url(); ?>assets/front/images/google-play-store.png" style="border: 1px solid white;"></a>          
					<small class="form-text text-white-50">For Use Download App.</small> 
				</div>
				<div class="form-group">
					<a href="https://play.google.com/store/apps/details?id=com.hereits_business"><img alt="" src="<?php echo base_url(); ?>assets/front/images/google-play-store.png" style="border: 1px solid white;"></a>          
					<small class="form-text text-white-50">For Business Download App.</small> 
				</div>
          
        </div>
		
      </div>
    </div>
    <div class="footer-copyright pt-4 mt-4">
      <div class="container">
        <div class="row">
          <div class="col-lg d-flex align-items-center">
            <p class="copyright-text text-center text-lg-left mt-0 mb-2 mb-lg-0">Copyright © 2020 <a href="<?= base_url() ?>">Hereits.</a>. All Rights Reserved.</p>
          </div>
          
        </div>
      </div>
    </div>
  </footer>
  <!-- Footer end --> 
  
</div>
<!-- Document Wrapper end --> 

<!-- Back to Top
============================================= --> 
<a id="back-to-top" data-toggle="tooltip" title="Back to Top" href="javascript:void(0)"><i class="fa fa-chevron-up"></i></a> 



<!-- Login Modal
=========================== -->
<div id="login-modal" class="modal fade" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content border-0">
			<div class="modal-body py-4 px-0">
				<button type="button" class="close close-outside" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				<!-- Login Form
				====================== -->
				<div class="row">
					<div class="col-11 col-md-10 mx-auto">
						<ul class="nav nav-tabs nav-justified mb-4" role="tablist">
						  <li class="nav-item"> <a class="nav-link text-5 line-height-3 active">Login</a> </li>
						  <li class="nav-item"> <a class="nav-link text-5 line-height-3" href="" data-toggle="modal" data-target="#signup-modal" data-dismiss="modal">Sign Up</a> </li>
						</ul>
						<p class="text-4 font-weight-300 text-muted text-center mb-4">We are glad to see you again!</p>
						<p class="text-3 text-center text-danger mb-4" id="login_msg"></p>
						<form id="loginForm" method="post">
							<div class="form-group">
								<input type="email" class="form-control" id="email_id" name="email_id" required placeholder="Email">
							</div>
							<div class="form-group">
								<input type="password" class="form-control" id="password" name="password" required placeholder="Password">
							</div>
							<div class="row my-4">
								<div class="col">
									<div class="form-check text-2 custom-control custom-checkbox">
										<input id="remember-me" name="remember" class="custom-control-input" type="checkbox">
										<label class="custom-control-label" for="remember-me">Remember Me</label>
									</div>
								</div>
								<div class="col text-2 text-right"><a class="btn-link" href="" data-toggle="modal" data-target="#forgot-password-modal" data-dismiss="modal">Forgot Password ?</a></div>
							</div>
							<button class="btn btn-primary btn-block my-4" type="submit">Login</button>
						</form>
					   
						<p class="text-2 text-center mb-0">New to Hereits? <a class="btn-link" href="" data-toggle="modal" data-target="#signup-modal" data-dismiss="modal">Sign Up</a></p>
					</div>
				</div>
				<!-- Login Form End --> 
			</div>
		</div>
	</div>
</div>
<!-- Login Modal End -->

<!-- Sign Up Modal
=========================== -->
<div id="signup-modal" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0">
      <div class="modal-body py-4 px-0">
        <button type="button" class="close close-outside" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        <!-- Sign Up Form
        ====================== -->
        <div class="row">
          <div class="col-11 col-md-10 mx-auto">
            <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
              <li class="nav-item"> <a class="nav-link text-5 line-height-3" href="" data-toggle="modal" data-target="#login-modal" data-dismiss="modal">Log In</a> </li>
              <li class="nav-item"> <a class="nav-link text-5 line-height-3 active">Sign Up</a> </li>
            </ul>
            <p class="text-4 font-weight-300 text-muted text-center mb-4">Looks like you're new here!</p>
			<p class="text-3 text-center text-danger mb-4" id="gegister_msg"></p>
            <form id="registerForm" method="post">
				<div class="form-group">
					<input type="text" class="form-control border-2" id="frist_name" name="frist_name"  placeholder="First Name">
				</div>
				<div class="form-group">
					<input type="text" class="form-control border-2" id="last_name" name="last_name"  placeholder="Last Name">
				</div>
				<div class="form-group">
					<input type="text" class="form-control border-2" id="username" name="username"  placeholder="User Name">
				</div>
				<div class="form-group">
					<input type="number" class="form-control border-2" id="contact" name="contact"  placeholder="Contact">
				</div>
              <div class="form-group">
                <input type="email" class="form-control border-2" id="re-email" name="email"  placeholder="Email Id">
              </div>
              <div class="form-group">
                <input type="password" class="form-control border-2" id="password" name="password"  placeholder="Password">
              </div>
              <div class="form-group my-4">
                <div class="form-check text-2 custom-control custom-checkbox">
                  <input id="agree" class="custom-control-input" type="checkbox" CHECKED required>
                  <label class="custom-control-label" for="agree">I agree to the <a href="<?= base_url() ?>Terms">Terms</a> and <a href="<?= base_url() ?>Privacy">Privacy Policy</a>.</label>
                </div>
              </div>
              <button class="btn btn-primary btn-block my-4" type="submit">Sign Up</button>
            </form>
           
            <p class="text-2 text-center mb-0">Already have an account? <a class="btn-link" href="" data-toggle="modal" data-target="#login-modal" data-dismiss="modal">Log In</a></p>
          </div>
        </div>
        <!-- Sign Up Form End --> 
      </div>
    </div>
  </div>
</div>
<!-- Sign Up Modal End -->

<!-- Forgot Password Modal
============================== -->
<div id="forgot-password-modal" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0">
      <div class="modal-body py-4 px-0">
        <button type="button" class="close close-outside" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        <!-- Forgot Password Form
        =========================== -->
        <div class="row">
          <div class="col-11 col-md-10 mx-auto">
            <h3 class="text-center mt-3 mb-4">Forgot your password?</h3>
            <p class="text-center text-3 text-muted">Enter your Email and we’ll help you reset your password.</p>
			<p class="text-3 text-center mb-4" id="forgot_msg"></p>
            <form id="forgotForm" class="form-border" method="post">
              <div class="form-group">
                <input type="text" class="form-control border-2" id="email" name="email" required placeholder="Enter Email">
              </div>
              <button class="btn btn-primary btn-block my-4" type="submit">Continue</button>
            </form>
            <p class="text-center mb-0"><a class="btn-link" href="" data-toggle="modal" data-target="#login-modal" data-dismiss="modal">Return to Log In</a> </p>
          </div>
        </div>
        <!-- Forgot Password Form End --> 
      </div>
    </div>
  </div>
</div>
<!-- Forgot Password Modal End -->



<!-- Script -->
<script src="<?php echo base_url(); ?>assets/front/vendor/jquery/jquery.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/front/vendor/jquery-ui/jquery-ui.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/front/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/front/vendor/owl.carousel/owl.carousel.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/front/vendor/bootstrap-spinner/bootstrap-spinner.js"></script> 
<script src="<?php echo base_url(); ?>assets/front/vendor/daterangepicker/moment.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/front/vendor/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/theme.js"></script>

<!-- alertify -->
<script src="<?php echo base_url(); ?>assets/admin/alertify/lib/alertify.min.js"></script>
<script>
<?php if($this->session->flashdata('success_msg')){?>
      alertify.success("<?php echo $this->session->flashdata('success_msg'); ?>");
<?php } ?>
</script>

<script>
	//Login
	 $("#loginForm").on('submit',(function(e) {
	  e.preventDefault();
		  $.ajax({
			url: url+'Login/chack_user_login',
			type: "POST",
			data:  new FormData(this),
			dataType: 'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend : function(){ 
				document.getElementById("preloader").style.display = "block"; 
			},
			success: function(data){
				//alert(data);
				console.log(data);
				if(data.status == 1){
					location.reload();
				}else{
					$('#login_msg').html(data.Message);
				}
				document.getElementById("preloader").style.display = "none"; 
			},
			error: function(e){ 
				alert('Somthing Wron');
				console.log(e);
				document.getElementById("preloader").style.display = "none"; 
			}           
		});
	 }));
	 
	 //new registration
	 $("#registerForm").on('submit',(function(e) {
	  e.preventDefault();
		  $.ajax({
			url: url+'Login/User_Registration',
			type: "POST",
			data:  new FormData(this),
			dataType: 'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend : function(){ 
				document.getElementById("preloader").style.display = "block"; 
			},
			success: function(data){
				//alert(data);
				console.log(data);
				if(data.status == 1){
					location.reload();
				}else{
					$('#gegister_msg').html(data.Message);
					var elmnt = document.getElementById("gegister_msg");
					elmnt.scrollIntoView();
				}
				document.getElementById("preloader").style.display = "none"; 
			},
			error: function(e){ 
				alert('Somthing Wron');
				console.log(e);
				document.getElementById("preloader").style.display = "none"; 
			}           
		});
	 }));

	 //new forgotForm
	 $("#forgotForm").on('submit',(function(e) {
	  e.preventDefault();
		  $.ajax({
			url: url+'Login/user_forgot',
			type: "POST",
			data:  new FormData(this),
			dataType: 'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend : function(){ 
				document.getElementById("preloader").style.display = "block"; 
			},
			success: function(data){
				//alert(data);
				console.log(data);
				if(data.status == 1){
					$('#forgot_msg').html('<span class="text-success">'+data.Message+'</span>');
				}else{
					$('#forgot_msg').html('<span class="text-danger">'+data.Message+'</span>');
				}
				var elmnt = document.getElementById("forgot_msg");
					elmnt.scrollIntoView();
				document.getElementById("preloader").style.display = "none"; 
			},
			error: function(e){ 
				alert('Somthing Wron');
				console.log(e);
				document.getElementById("preloader").style.display = "none"; 
			}           
		});
	 }));
</script>
</body>
</html>