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

	<!--Toastr -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />

	<link rel="stylesheet" type="text/css" href="{{ asset('front/css/custom.css') }}" />

	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

	@stack('style')

	<script>
		
	</script>

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
								<li class="mobile-show"> <a href="{{ route('home') }}">Home</a> </li>
								<ul class="navbar-nav">
									@if (Auth::check() && Auth::user()->role_id == 2)
									<!-- <li class="mobile-hide"> <a href="{{ route('business.dashboard') }}" target="_blank" class="btn btn-primary-gradien " style="padding: 3px 11px 3px 11px;">Manage Store</a> </li> -->
									<li class="mobile-show"> <a href="{{ route('business.dashboard') }}" target="_blank">Manage Business</a> </li>
									@else
									<!-- <li class="mobile-hide"> <a href="Business" class="btn btn-primary-gradien " style="padding: 3px 11px 3px 11px;">Register Your business</a> </li> -->
									<!-- <li class="mobile-show"> <a href="Business">Register Your business</a> </li> -->
									@endif

								</ul>
							</div>
						</nav>
						<!-- Primary Navigation end -->

						<!-- Collapse Button
		  =============================== -->
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header-nav"> <span></span> <span></span> <span></span> </button>

						<!-- Login Signup
		  =============================== -->
						<nav class="login-signup navbar navbar-expand ml-sm-2 pl-sm-2"> <!-- separator -->
							<ul class="navbar-nav">
								<li class="profile">
									<a class="pr-0 mr-0 location-contaiter" href="#" data-toggle="modal" data-target="#location-modal">
										<span class="location ml-sm-2"><i class="fas fa-map-marker-alt pr-1"></i> {{ session('hereitsLocation') ? session('hereitsLocation')['fullAddress'] : null }} </span>
									</a>

									<!-- Location Modal =========================== -->
									<div id="location-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
										<div class="modal-dialog modal-lg h-75 modal-dialog-centered" role="document">
											<div class="modal-content h-75 border-0">
												<div class="modal-body py-4 px-0">
													<div class="row">
														<div class="col-11 col-md-10 mx-auto city-selection">
															<h5>Cities</h5>
															<div class="d-flex overflow-auto">
																@foreach(getAvailableCities() as $val)
																<div class="mr-2">
																	<input type="radio" name="location_city" value="{{$val->id}}" id="city-{{$val->id}}" onchange="getArea()" />
																	<label class="radio-lable" for="city-{{$val->id}}">{{$val->name}}</label>
																</div>
																@endforeach
															</div>

														</div>
														<div class="col-11 col-md-10 mx-auto search-input-line d-none">
															<input type="text" class="form-control" name="location_area_search" onkeyup="getArea()" placeholder="Search Area">
															<?php $cites = array() ?>
															<ul class="p-0" id="location-area-list">
															</ul>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>


									<!-- Location Modal End -->

									<!-- <a class="pr-0 mr-0" href="#" id="search-btn" title="Search" data-toggle="modal" data-target="#Search-modal">
										<span class="text-5 ml-sm-2"><i class="fas fa-search"></i></span>
									</a> -->

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
									<!-- <a class="pr-0 mr-0" href="Cart" title="Product Cart">
										<span class="text-5 ml-sm-2"><i class="fas fa-shopping-cart"></i></span>
										<?php if ($pcout > 0) { ?> <span class='badge' id='lblCartCount'> <?= $pcout ?> </span> <?php } ?>
									</a>

									<a class="pr-0 pl-1 mr-0" href="Cart/Booking_cart" title="Booking Cart">
										<span class="text-5 ml-sm-2"><i class="far fa-calendar-alt" style="font-size: 23px;"></i></span>
										<?php if ($scout > 0) { ?> <span class='badge' id='lblCartCount'> <?= $scout ?> </span> <?php } ?>
									</a> -->


									@if (Auth::check())
								<li class="dropdown mobile-hide align-self-center">
									<a class="pr-0 pl-1" href="#" title="Profile" style="height: unset;">
										<!-- <span class="d-none d-sm-inline-block">{{ Auth::User()->first_name }}</span> -->
										<span class="user-icon ml-sm-2"><img src="{{ getImage(Auth::User()->profile) }}" style="height: 33px; border-radius: 100%; width: 33px; border: 1px solid; object-fit: cover;" /></span>
									</a>
									<ul class="dropdown-menu">
										<li><a class="dropdown-item" href="{{ route('account.userprofile') }}">User Info</a></li>
										@if (Auth::check() && Auth::user()->role_id == 2)
										<li><a class="dropdown-item" href="{{ route('business.dashboard') }}">Manage Business</a></li>
										@endif
										<li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
									</ul>
								</li>
								@else
								<div class="pr-0 mobile-hide align-self-center" style="height: auto;" data-toggle="modal" data-target="#login-modal" href="#" title="Login / Sign up">
									<!-- <span class="d-none d-sm-inline-block">Login</span> -->
									<span href="Business" class="btn btn-primary-gradien mobile-hide ml-3 px-2 py-1">Login</span>
									<!-- <span class="user-icon ml-sm-2"><i class="fas fa-user"></i></span> -->
								</div>
								@endif

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
				<!-- <a href="#" class=""><i class="fab fa-dropbox" style="font-size:25px"></i><span> Products</span></a> -->
				<a href="{{ route('business') }}" class="{{ request()->routeIs('business') ? 'active' : '' }}"><i class="fas fa-store-alt" style="font-size:25px"></i><span> Stores</span></a>
				<!-- <a href="#" class=">"><i class="fas fa-list-ul" style="font-size:25px"></i><span> Services</span></a> -->

				@if (Auth::check())
				<a href="{{ route('account.index') }}" class=""><i class="far fa-user" style="font-size:25px"></i><span> Account</span></a>
				@else
				<a data-toggle="modal" data-target="#login-modal" href="#"><i class="far fa-user" style="font-size:25px"></i><span> Account</span></a>
				@endif



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
							<li class="nav-item"> <a target="_blank" class="nav-link" href="{{ route('contactUs') }}" title="Hereits Contact Us">Contact Us</a></li>
							<li class="nav-item"> <a target="_blank" class="nav-link" href="{{ route('aboutUs') }}" title="Hereits About Us">About Us</a></li>
							<li class="nav-item"> <a target="_blank" class="nav-link" href="Business" title="Hereits For business">Register Your business</a></li>
							<!-- li class="nav-item"> <a target="_blank" class="nav-link" href="Report" title="">Report</a></li -->
							<!-- <li class="nav-item"> <a target="_blank" class="nav-link" href="Credits" title="">Credits</a></li> -->
						</ul>
					</div>
					<div class="col-sm-6 col-md mb-3 mb-md-0">
						<h4 class="text-3 text-white font-weight-400 mb-3">Policy</h4>
						<ul class="nav flex-column">
							<li class="nav-item"> <a target="_blank" class="nav-link" href="{{ route('termAndCondition') }}" title="Hereits Terms &amp; Conditions">Terms Of Use</a></li>
							<li class="nav-item"> <a target="_blank" class="nav-link" href="{{ route('privacyPolicy') }}" title="Hereits PRIVACY POLICY">Privacy</a></li>
							<li class="nav-item"> <a target="_blank" class="nav-link" href="{{ route('CopyRight') }}" title="Hereits Copy Rights">Copyright</a></li>
							<li class="nav-item"> <a target="_blank" class="nav-link" href="{{ route('faq') }}" title="Faqs">FAQ</a></li>
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



	<!-- Login Modal =========================== -->
	<div id="login-modal" class="modal fade" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content border-0">
				<div class="modal-body py-4 px-0">
					<button type="button" class="close close-outside" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
					<!-- Login Form ====================== -->
					<div class="row">
						<div class="col-11 col-md-10 mx-auto">
							<ul class="nav nav-tabs nav-justified mb-4" role="tablist">
								<li class="nav-item"> <a class="nav-link text-5 line-height-3 active">Login</a> </li>
								<li class="nav-item"> <a class="nav-link text-5 line-height-3" href="" data-toggle="modal" data-target="#signup-modal" data-dismiss="modal">Sign Up</a> </li>
							</ul>
							<p class="text-4 font-weight-300 text-muted text-center mb-4">We are glad to see you again!</p>
							<p class="text-3 text-center text-danger mb-4" id="login_msg"></p>
							<form id="loginForm" action="{{ route('login') }}" data-action="reload" class="formaction">
								@csrf
								<div class="form-group">
									<input type="email" class="form-control" id="email" name="email" required placeholder="Email">
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
								<button class="btn btn-primary btn-block my-4 btn_action" type="submit">
									<span id="buttonText">Login</span>
									<span id="loader" class="d-none">Login ...</span>
								</button>
							</form>
							<!-- <div class="d-flex align-items-center my-3">
								<hr class="flex-grow-1">
								<span class="mx-2 text-2 text-muted">Or Login with Social Profile</span>
								<hr class="flex-grow-1">
							</div>
							<div class="d-flex  flex-column align-items-center mb-3">
								<ul class="social-icons social-icons-colored social-icons-circle">
									<li class="social-icons-google"><a href="#" data-bs-toggle="tooltip" title="" data-bs-original-title="Log In with Google" aria-label="Log In with Google"><i class="fab fa-google"></i></a></li>
								</ul>
							</div> -->
							<p class="text-2 text-center mb-0">New to Hereits? <a class="btn-link" href="" data-toggle="modal" data-target="#signup-modal" data-dismiss="modal">Sign Up</a></p>
						</div>
					</div>
					<!-- Login Form End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Login Modal End -->

	<!-- Sign Up Modal =========================== -->
	<div id="signup-modal" class="modal fade" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content border-0">
				<div class="modal-body py-4 px-0">
					<button type="button" class="close close-outside" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
					<!-- Sign Up Form ====================== -->
					<div class="row">
						<div class="col-11 col-md-10 mx-auto">
							<ul class="nav nav-tabs nav-justified mb-4" role="tablist">
								<li class="nav-item"> <a class="nav-link text-5 line-height-3" href="" data-toggle="modal" data-target="#login-modal" data-dismiss="modal">Log In</a> </li>
								<li class="nav-item"> <a class="nav-link text-5 line-height-3 active">Sign Up</a> </li>
							</ul>
							<p class="text-4 font-weight-300 text-muted text-center mb-4">Looks like you're new here!</p>
							<p class="text-3 text-center text-danger mb-4" id="gegister_msg"></p>
							<form id="registerForm" action="{{ route('register') }}" data-action="reload" class="formaction">
								@csrf
								<div class="form-group">
									<input type="text" class="form-control border-2" id="first_name" name="first_name" placeholder="First Name">
								</div>
								<div class="form-group">
									<input type="text" class="form-control border-2" id="last_name" name="last_name" placeholder="Last Name">
								</div>
								<div class="form-group">
									<input type="number" class="form-control border-2" id="contact" name="contact" placeholder="Contact">
								</div>
								<div class="form-group">
									<input type="email" class="form-control border-2" id="email" name="email" placeholder="Email Id">
								</div>
								<div class="form-group">
									<input type="password" class="form-control border-2" id="password" name="password" placeholder="Password">
								</div>
								<div class="form-group my-4">
									<div class="form-check text-2 custom-control custom-checkbox">
										<input id="agree" class="custom-control-input" type="checkbox" CHECKED required>
										<label class="custom-control-label" for="agree">I agree to the <a href="{{ route('termAndCondition') }}">Terms</a> and <a href="{{ route('privacyPolicy') }}">Privacy Policy</a>.</label>
									</div>
								</div>
								<button class="btn btn-primary btn-block my-4 btn_action" type="submit">
									<span id="buttonText">Sign Up</span>
									<span id="loader" class="d-none">Loading ...</span>
								</button>
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
					<!-- Forgot Password Form =========================== -->
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

	<!--Toastr -->
	<script src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js')}}"></script>

	<script src="{{ asset('ajax/ajax.js') }}"></script>

	<script>
		function loader(state) {
			if (state) {
				document.getElementById("preloader").style.display = "block";
			} else {
				document.getElementById("preloader").style.display = "none";
			}

		}

		document.addEventListener('DOMContentLoaded', function() {
			$('#copylink').click(function() {
				var $temp = $("<input>");
				$("body").append($temp);
				$temp.val($(this).data('url')).select();
				document.execCommand("copy");
				$temp.remove();
				alert("Link copied to clipboard");
			});
		});

		var locationData = @json(getUserLocationInfo());
	</script>

	@stack('js')

	<script>
		// ********* location model Start ******************
		
		$(document).ready(function() {
			
			console.log(locationData);
			if (locationData == null || locationData == '') {
				$('#location-modal').modal('show');
			} else {
				if (locationData['city'] != '') {
					$('input[name="location_city"][value="' + locationData['city'] + '"]').prop("checked", true);
					$('.search-input-line').removeClass('d-none')
				}

			}

		});
		var lastAjax = null;

		function getArea() {

			setLocation('city', $('input[name="location_city"]:checked').val())

			$('.search-input-line').removeClass('d-none')
			// Abort previous AJAX request if it's still pending
			if (lastAjax !== null && typeof lastAjax.abort === "function") {
				lastAjax.abort();
			}

			lastAjax = $.ajax({
				type: "get",
				url: "{{ route('getAreas') }}",
				data: {
					area_search: $('input[name="location_area_search"]').val(),
					city: $('input[name="location_city"]:checked').val(),
				},
				dataType: "json",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				beforeSend: function() {
					$('#location-area-list').html("<li> <label class='w-100 ' tabindex='2'> <p class='location-name border-bottom-0 text-center'>Fetching areas ...</p></label> </li>");
				},
				success: function(res) {
					console.log(res);
					if (res.success) {
						$('#location-area-list').html(res.data.area);
					} else {
						toastr.error(res.message);
					}
					lastAjax = null; // Reset lastAjax after success
				},
				error: function(xhr, status, error) {
					console.error("Error: " + error);
					alert("There was an error fetching areas.");
					lastAjax = null; // Reset lastAjax after error
				}
			});
		}

		function setLocation(type, val) {
			var locationData = @json(getUserLocationInfo());
			if (locationData == null || locationData == '') {
				var locationData = {
					'locationType': '',
					'city': '',
					'area': '',
					'fullAddress': '',
					'lat': '',
					'long': '',
				}
			}

			locationData.locationType = 'manual';
			if (type == 'city') {
				locationData['city'] = val;
				locationData['area'] = '';
			} else if (type == 'area') {
				locationData['area'] = val;
			} else if (type == 'currentLocation') {
				locationData['locationType'] = 'currentLocation';
				locationData['city'] = '';
				locationData['area'] = '';
			}

			$.ajax({
				type: "get",
				url: "{{ route('getLocationInfo') }}",
				data: {
					data: locationData,
				},
				dataType: "json",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				beforeSend: function() {
					document.getElementById("preloader").style.display = "block";
				},
				success: function(res) {
					if (res.success) {
						if (type == 'area') {
							window.location.reload();
						}
					} else {
						toastr.error(res.message);
					}
					document.getElementById("preloader").style.display = "none";
				},
				error: function(xhr, status, error) {
					console.error("Error: " + error);
					alert("There was an error fetching areas.");
					document.getElementById("preloader").style.display = "none";
				}
			});
		}

		// ********* location model End ******************



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