<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
	<link href="{{ asset('front/img/fevicon-icon.png') }}" rel="icon" />

	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title', '404') | Hereits</title>

	@if (isset($seo) && !empty($seo))
	<meta name="description" content="<?= $seo['description'] ?>">
	<meta name="keywords" content="<?= $seo['keywords'] ?>">
	

	<link rel="canonical" href="{{ url()->current() }}" />

	<meta name="distribution" content="global">
	<meta http-equiv="content-language" content="en-gb">
	<meta name="city" content="<?= $seo['city'] ?>">
	<meta name="state" content="<?= $seo['state'] ?>">
	<meta name="geo.region" content="IN-GJ">
	<meta name="geo.placename" content="<?= $seo['city'] ?>">
	<meta name="DC.title" content="<?= $seo['title'] ?>">
	<meta name="geo.position" content="<?= $seo['position'] ?>">

	<!-- meta property="og:see_also" content="alternate url" -->

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta property="al:web:url" content="{{ url()->current() }}">

	<meta name="copyright" content="Hereits">

	<meta property="og:title" content="<?= $seo['title'] ?>">
	<meta property="og:description" content="<?= $seo['description'] ?>">
	<meta property="og:url" content="{{ url()->current() }}">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="Hereits - Local Business">
	<meta property="og:locale" content="en_GB">
	<meta property="og:image" content="<?= $seo['image'] ?>">
	<meta property="og:image:width" content="550" />
	<meta property="og:image:height" content="413" />

	<meta property="twitter:card" content="summary">
	<meta property="twitter:site" content="hereitsdotcom">
	<meta property="twitter:title" content="<?= $seo['title'] ?>">
	<meta property="twitter:description" content="<?= $seo['description'] ?>">
	<meta property="twitter:image" content="<?= $seo['image'] ?>">
	<meta property="twitter:url" content="{{ url()->current() }}">
	<meta name="twitter:domain" content="Hereits">

	<link rel="alternate" href="">
	<meta itemprop="name" content="<?= $seo['title'] ?>">
	<meta itemprop="description" content="">
	@endif


	<!-- Web Fonts
		============================================= -->
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900' type='text/css'>

	<!-- Stylesheet
		============================================= -->
	<link rel="stylesheet" type="text/css" href="{{ asset('front/vendor/bootstrap/css/bootstrap.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('front/vendor/font-awesome/css/all.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('front/vendor/owl.carousel/assets/owl.carousel.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('front/vendor/owl.carousel/assets/owl.theme.default.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('front/vendor/jquery-ui/jquery-ui.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('front/vendor/daterangepicker/daterangepicker.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('front/css/stylesheet.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('front/css/custom.css') }}" />

	@stack('style')

	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

	<!-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
		<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script> -->


</head>

<body id="top">
	<!-- Preloader -->
	<div id="preloader">
		<img class="image" src="{{ asset('front/img/Spinner.png') }}" alt="" width="120" height="120">
	</div>
	<!-- Preloader End -->

	<!-- Document Wrapper   
============================================= -->
	<div id="main-wrapper">

		<!-- Header
  ============================================= -->
		<header id="header">
			<div class="container">
				<div class="header-row">
					<div class="header-column justify-content-start">
						<div class="logo"> <a href="{{ route('home') }}" class="d-flex" title="Hereits"><img src="{{ asset('front/img/logo.png') }}" alt="Hereits" /></a> </div>
					</div>
					<div class="header-column justify-content-end">

						<!-- Primary Navigation
          ============================================= -->
						<nav class="primary-menu navbar navbar-expand-lg">
							<div id="header-nav" class="collapse navbar-collapse">
								<ul class="navbar-nav">
									<?php /* if($this->session->User->store_id != NULL){ ?>
					<li class="mobile-hide"> <a href="Store_dashboard" target="_blank" class="btn btn-primary-gradien " style="padding: 3px 11px 3px 11px;">Manage Store</a> </li>
					<li class="mobile-show"> <a href="Store_dashboard" target="_blank">Manage Store</a> </li>
				<?php }else{ ?>
					<li class="mobile-hide"> <a href="Business" class="btn btn-primary-gradien " style="padding: 3px 11px 3px 11px;">Register Your business</a> </li>
					<li class="mobile-show"> <a href="Business" >Register Your business</a> </li>
				<?php } */ ?>

									<li class="mobile-hide"> <a href="{{ route('business.dashboard') }}" class="btn btn-primary-gradien " style="padding: 3px 11px 3px 11px;">Register Your business</a> </li>
									<li class="mobile-show"> <a href="{{ route('business.dashboard') }}">Register Your business</a> </li>

								</ul>
							</div>
						</nav>
						<!-- Primary Navigation end -->

						<!-- Collapse Button
		  =============================== -->
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header-nav"> <span></span> <span></span> <span></span> </button>

						<!-- Login Signup
		  =============================== -->
						<nav class="login-signup navbar navbar-expand separator ml-sm-2 pl-sm-2">
							<ul class="navbar-nav">
								<li class="profile">
									<a class="pr-0 mr-0 location-contaiter" href="#" data-toggle="modal" data-target="#location-modal">
										<span class="location ml-sm-2"><i class="fas fa-map-marker-alt"></i> GJ, Surat</span>
									</a>

									<!-- Location Modal =========================== -->
									<div id="location-modal" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content border-0">
												<div class="modal-body py-4 px-0">
													<div class="row">
														<div class="col-11 col-md-10 mx-auto search-input-line">
															<!-- ul class="nav nav-tabs nav-justified mb-4" role="tablist">
							  <li class="nav-item"> <a class="nav-link text-5 line-height-3 active">Location</a> </li>
							 
							</ul -->
															<input type="text" class="form-control" data-bv-field="number" onkeyup="myFunction()" id="city-search" required="" placeholder="Search City">
															<?php $cites = array() ?>
															<ul class="p-0" id="location-area">
																<?php foreach (getAvailableCities() as $val) { ?>
																	<li>
																		<input id="<?= $val->name ?>" name="location" value="<?= $val->name ?>" state="<?= $val->name ?>" class="custom-control-input" type="radio">
																		<label class="location-box" tabindex="2" for="<?= $val->city ?>">
																			<span class="fas fa-map-marker-alt location-icon"></span>
																			<p class="location-name"><?= $val->name ?></p>
																		</label>
																	</li>
																<?php } ?>

															</ul>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- Location Modal End -->



									<a class="pr-0 mr-0" href="#" id="search-btn" title="Search" data-toggle="modal" data-target="#Search-modal">
										<span class="text-5 ml-sm-2"><i class="fas fa-search"></i></span>
									</a>

									<script>
										$(document).ready(function() {
											$('#Search-modal').on('shown.bs.modal', function() {
												$('#search_input').focus();
											});
										});
									</script>



									<!-- Search Modal =========================== -->
									<div id="Search-modal" class="modal fade" role="dialog">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content border-0">
												<div class="modal-header" style="padding-bottom: unset;border: none;">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
												</div>
												<div class="modal-body py-4 px-0">
													<div class="row">
														<div class="col-11 col-md-10 mx-auto search-input-line">
															<!-- ul class="nav nav-tabs nav-justified mb-4" role="tablist">
							  <li class="nav-item"> <a class="nav-link text-5 line-height-3 active">Location</a> </li>
							 
							</ul -->
															<input type="text" class="form-control" data-bv-field="number" onkeyup="search(this.value)" id="search_input" required="" placeholder="Search">
															<ul class="p-0" id="search-result" style="height: 400px;">


															</ul>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<script>
										function search(search) {
											$.ajax({
												url: url + 'Home/search',
												method: "POST",
												data: {
													search: search
												},
												//dataType: 'json',
												beforeSend: function() {},
												success: function(data) {
													//alert(data);
													//console.log(data);
													$('#search-result').html(data);
												},
												error: function(e) {
													alert('Somthing Wron');
													console.log(e);
												}
											});
										}
									</script>
									<!-- Search Modal End -->

									<?php
									$pcout = 0;
									$scout = 0;
									?>


									<a class="pr-0 mr-0" href="Cart" title="Product Cart">
										<span class="text-5 ml-sm-2"><i class="fas fa-shopping-cart"></i></span>
										<?php if ($pcout > 0) { ?> <span class='badge' id='lblCartCount'> <?= $pcout ?> </span> <?php } ?>
									</a>

									<a class="pr-0 pl-1 mr-0" href="Cart/Booking_cart" title="Booking Cart">
										<span class="text-5 ml-sm-2"><i class="far fa-calendar-alt" style="font-size: 23px;"></i></span>
										<?php if ($scout > 0) { ?> <span class='badge' id='lblCartCount'> <?= $scout ?> </span> <?php } ?>
									</a>

								<li class="dropdown mobile-hide">
									<a class="pr-0 pl-1" href="#" title="Login / Sign up">
										<span class="d-none d-sm-inline-block">user</span>
										<span class=" ml-sm-2"><img src="" style="height: 30px;border-radius: 10px;" /></span>
									</a>
									<ul class="dropdown-menu">
										<li><a class="dropdown-item" href="Account/My_profile">User Info</a></li>
										<li><a class="dropdown-item" href="Account/Address">My Address</a></li>
										<li><a class="dropdown-item" href="Account/Orders">My Order</a></li>
										<li><a class="dropdown-item" href="Account/Bookings">My Booking</a></li>
										<li><a class="dropdown-item" href="Login/logout">Logout</a></li>
									</ul>
								</li>


								<a class="pr-0 mobile-hide" style="padding-top: 18px;" data-toggle="modal" data-target="#login-modal" href="#" title="Login / Sign up">
									<span class="d-none d-sm-inline-block">Login</span>
									<span class="user-icon ml-sm-2"><i class="fas fa-user"></i></span>
								</a>


								</li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</header>
		<!-- Header end -->

		<!-- Content
  ============================================= -->
		<div id="content">
			@yield('content')

		</div>
		<!-- Content end -->


		<!-- Mobile navigation ============================================= -->
		<div class="home-menu-icon-container">
			<div class="mobile-icon-section pt-1 pb-1 pr-2 pl-2">
				<a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><i class="fas fa-home" style="font-size:25px"></i><span> Home</span></a>
				<a href="#" class=""><i class="fab fa-dropbox" style="font-size:25px"></i><span> Products</span></a>
				<a href="{{ route('business') }}" class="{{ request()->routeIs('business') ? 'active' : '' }}"><i class="fas fa-store-alt" style="font-size:25px"></i><span> Stores</span></a>
				<a href="#" class=">"><i class="fas fa-list-ul" style="font-size:25px"></i><span> Services</span></a>

				<!-- <a href="Account" class=""><i class="far fa-user" style="font-size:25px"></i><span> Account</span></a> -->

				<a data-toggle="modal" data-target="#login-modal" href="#"><i class="far fa-user" style="font-size:25px"></i><span> Account</span></a>

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
							<li class="nav-item"> <a target="_blank" class="nav-link" href="Contact_us" title="Hereits Contact Us">Contact Us</a></li>
							<li class="nav-item"> <a target="_blank" class="nav-link" href="About_us" title="Hereits About Us">About Us</a></li>
							<li class="nav-item"> <a target="_blank" class="nav-link" href="Business" title="Hereits For business">Register Your business</a></li>
							<!-- li class="nav-item"> <a target="_blank" class="nav-link" href="Report" title="">Report</a></li -->
							<li class="nav-item"> <a target="_blank" class="nav-link" href="Credits" title="">Credits</a></li>
						</ul>
					</div>
					<div class="col-sm-6 col-md mb-3 mb-md-0">
						<h4 class="text-3 text-white font-weight-400 mb-3">Policy</h4>
						<ul class="nav flex-column">
							<li class="nav-item"> <a target="_blank" class="nav-link" href="Terms" title="Hereits Terms &amp; Conditions">Terms Of Use</a></li>
							<li class="nav-item"> <a target="_blank" class="nav-link" href="Privacy" title="Hereits PRIVACY POLICY">Privacy</a></li>
							<li class="nav-item"> <a target="_blank" class="nav-link" href="Copyright" title="Hereits Copy Rights">Copyright</a></li>
							<li class="nav-item"> <a target="_blank" class="nav-link" href="Faqs" title="">FAQ</a></li>
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
							<a href="https://play.google.com/store/apps/details?id=com.hereits"><img alt="" src="{{ asset('front/images/google-play-store.png') }}" style="border: 1px solid white;"></a>
							<small class="form-text text-white-50">For Use Download App.</small>
						</div>
						<div class="form-group">
							<a href="https://play.google.com/store/apps/details?id=com.hereits_business"><img alt="" src="{{ asset('front/images/google-play-store.png') }}" style="border: 1px solid white;"></a>
							<small class="form-text text-white-50">For Business Download App.</small>
						</div>

					</div>

				</div>
			</div>
			<div class="footer-copyright pt-4 mt-4">
				<div class="container">
					<div class="row">
						<div class="col-lg d-flex align-items-center">
							<p class="copyright-text text-center text-lg-left mt-0 mb-2 mb-lg-0">Copyright © 2020 <a href="">Hereits.</a>. All Rights Reserved.</p>
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
									<input type="text" class="form-control border-2" id="frist_name" name="frist_name" placeholder="First Name">
								</div>
								<div class="form-group">
									<input type="text" class="form-control border-2" id="last_name" name="last_name" placeholder="Last Name">
								</div>
								<div class="form-group">
									<input type="text" class="form-control border-2" id="username" name="username" placeholder="User Name">
								</div>
								<div class="form-group">
									<input type="number" class="form-control border-2" id="contact" name="contact" placeholder="Contact">
								</div>
								<div class="form-group">
									<input type="email" class="form-control border-2" id="re-email" name="email" placeholder="Email Id">
								</div>
								<div class="form-group">
									<input type="password" class="form-control border-2" id="password" name="password" placeholder="Password">
								</div>
								<div class="form-group my-4">
									<div class="form-check text-2 custom-control custom-checkbox">
										<input id="agree" class="custom-control-input" type="checkbox" CHECKED required>
										<label class="custom-control-label" for="agree">I agree to the <a href="Terms">Terms</a> and <a href="Privacy">Privacy Policy</a>.</label>
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
	<script src="{{ asset('front/vendor/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('front/vendor/jquery-ui/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('front/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('front/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('front/vendor/bootstrap-spinner/bootstrap-spinner.js') }}"></script>
	<!-- <script src="{{ asset('front/vendor/daterangepicker/moment.min.js') }}"></script> -->
	<!-- <script src="{{ asset('front/vendor/daterangepicker/daterangepicker.js') }}"></script> -->
	<script src="{{ asset('front/js/theme.js') }}"></script>

	<script>
		function loader(state) {
			if (state) {
				document.getElementById("preloader").style.display = "block";
			} else {
				document.getElementById("preloader").style.display = "none";
			}

		}
	</script>

	@stack('js')

	<script>
		//Login
		$("#loginForm").on('submit', (function(e) {
			e.preventDefault();
			$.ajax({
				url: url + 'Login/chack_user_login',
				type: "POST",
				data: new FormData(this),
				dataType: 'json',
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					document.getElementById("preloader").style.display = "block";
				},
				success: function(data) {
					//alert(data);
					console.log(data);
					if (data.status == 1) {
						location.reload();
					} else {
						$('#login_msg').html(data.Message);
					}
					document.getElementById("preloader").style.display = "none";
				},
				error: function(e) {
					alert('Somthing Wron');
					console.log(e);
					document.getElementById("preloader").style.display = "none";
				}
			});
		}));

		//new registration
		$("#registerForm").on('submit', (function(e) {
			e.preventDefault();
			$.ajax({
				url: url + 'Login/User_Registration',
				type: "POST",
				data: new FormData(this),
				dataType: 'json',
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					document.getElementById("preloader").style.display = "block";
				},
				success: function(data) {
					//alert(data);
					console.log(data);
					if (data.status == 1) {
						location.reload();
					} else {
						$('#gegister_msg').html(data.Message);
						var elmnt = document.getElementById("gegister_msg");
						elmnt.scrollIntoView();
					}
					document.getElementById("preloader").style.display = "none";
				},
				error: function(e) {
					alert('Somthing Wron');
					console.log(e);
					document.getElementById("preloader").style.display = "none";
				}
			});
		}));

		//new forgotForm
		$("#forgotForm").on('submit', (function(e) {
			e.preventDefault();
			$.ajax({
				url: url + 'Login/user_forgot',
				type: "POST",
				data: new FormData(this),
				dataType: 'json',
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					document.getElementById("preloader").style.display = "block";
				},
				success: function(data) {
					//alert(data);
					console.log(data);
					if (data.status == 1) {
						$('#forgot_msg').html('<span class="text-success">' + data.Message + '</span>');
					} else {
						$('#forgot_msg').html('<span class="text-danger">' + data.Message + '</span>');
					}
					var elmnt = document.getElementById("forgot_msg");
					elmnt.scrollIntoView();
					document.getElementById("preloader").style.display = "none";
				},
				error: function(e) {
					alert('Somthing Wron');
					console.log(e);
					document.getElementById("preloader").style.display = "none";
				}
			});
		}));
	</script>
</body>

</html>