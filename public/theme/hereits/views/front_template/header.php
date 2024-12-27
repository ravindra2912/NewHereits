<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
		<link href="<?php echo base_url(); ?>assets/front/img/fevicon-icon.png" rel="icon" />
		
			<?php if($seo == NULL){ $seo = $this->Mdl_common->site_seo(); } ?>
			<meta name="description" content="<?=  $seo['description'] ?>">
			<meta name="keywords" content="<?= $seo['keywords'] ?>">
			<title><?= $seo['title'] ?></title>

			<link rel="canonical" href="<?= $seo['url'] ?>" />
			
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
			<meta property="al:web:url" content="<?= $seo['url'] ?>">
			
			<meta name="copyright" content="Hereits">
			
			<meta property="og:title" content="<?= $seo['title'] ?>">
			<meta property="og:description" content="<?=  $seo['description'] ?>">
			<meta property="og:url" content="<?= $seo['url'] ?>">
			<meta property="og:type" content="website">
			<meta property="og:site_name" content="Hereits - Local Business">
			<meta property="og:locale" content="en_GB">
			<meta property="og:image" content="<?= $seo['image'] ?>">
			<meta property="og:image:width" content="550"/>
			<meta property="og:image:height" content="413"/>
			
			<meta property="twitter:card" content="summary">
			<meta property="twitter:site" content="hereitsdotcom">
			<meta property="twitter:title" content="<?= $seo['title'] ?>">
			<meta property="twitter:description" content="<?=  $seo['description'] ?>">
			<meta property="twitter:image" content="<?= $seo['image'] ?>">
			<meta property="twitter:url" content="<?= $seo['url'] ?>">
			<meta name="twitter:domain" content="Hereits">
			
			<link rel="alternate" href="">
			<meta itemprop="name" content="<?= $seo['title'] ?>">
			<meta itemprop="description" content="">
		

		<!-- Web Fonts
		============================================= -->
		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900' type='text/css'>

		<!-- Stylesheet
		============================================= -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/vendor/bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/vendor/font-awesome/css/all.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/vendor/owl.carousel/assets/owl.carousel.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/vendor/owl.carousel/assets/owl.theme.default.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/vendor/jquery-ui/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/vendor/daterangepicker/daterangepicker.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/css/stylesheet.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/front/css/custom.css" />
		
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	
		<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
		<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
		<script>
			var url = '<?php echo base_url(); ?>'
		</script>
		
		<?php 
			if(isset($header_import) != null){
				echo $header_import;
			}
		?>

		<!-- alertify -->
		<link id="style-main-color" rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/alertify/alertify.core.css">
		<link id="style-main-color" rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/alertify/alertify.default.css" id="toggleCSS">
		
	</head>
<body id="top">
<!-- Preloader -->
<div id="preloader">
  <img class="image" src="<?php echo base_url(); ?>assets/front/img/Spinner.png" alt="" width="120" height="120">
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
          
          <!-- Logo
          ============================================= -->
          <div class="logo"> <a href="<?= base_url() ?>" class="d-flex" title="Hereits"><img src="<?php echo base_url(); ?>assets/front/img/logo.png" alt="Hereits" /></a> </div>
          <!-- Logo end --> 
          
        </div>
        <div class="header-column justify-content-end"> 
          
          <!-- Primary Navigation
          ============================================= -->
          <nav class="primary-menu navbar navbar-expand-lg">
            <div id="header-nav" class="collapse navbar-collapse">
              <ul class="navbar-nav">
				<?php if($this->session->User->store_id != NULL){ ?>
					<li class="mobile-hide"> <a href="<?= base_url() ?>Store_dashboard" target="_blank" class="btn btn-primary-gradien " style="padding: 3px 11px 3px 11px;">Manage Store</a> </li>
					<li class="mobile-show"> <a href="<?= base_url() ?>Store_dashboard" target="_blank">Manage Store</a> </li>
				<?php }else{ ?>
					<li class="mobile-hide"> <a href="<?= base_url() ?>Business" class="btn btn-primary-gradien " style="padding: 3px 11px 3px 11px;">Register Your business</a> </li>
					<li class="mobile-show"> <a href="<?= base_url() ?>Business" >Register Your business</a> </li>
				<?php } ?>
                
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
				<a class="pr-0 mr-0 location-contaiter" href="#" data-toggle="modal" data-target="#location-modal" >
					<span class="location ml-sm-2"><i class="fas fa-map-marker-alt"></i> <?= $_COOKIE['city'].', '.$_COOKIE['state'] ?></span>
				</a>
				
				<!-- Location Modal =========================== -->
				<div id="location-modal" class="modal fade" role="dialog"  aria-hidden="true" data-backdrop="static" data-keyboard="false">
				  <div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content border-0">
					  <div class="modal-body py-4 px-0">
						<div class="row">
						  <div class="col-11 col-md-10 mx-auto search-input-line">
							<!-- ul class="nav nav-tabs nav-justified mb-4" role="tablist">
							  <li class="nav-item"> <a class="nav-link text-5 line-height-3 active">Location</a> </li>
							 
							</ul -->
							<input type="text" class="form-control" data-bv-field="number" onkeyup="myFunction()" id="city-search" required="" placeholder="Search City">
							<?php $cites = $this->Mdl_common->get_cities(); ?>
							<ul class="p-0" id="location-area">
								<?php foreach($cites as $val){ ?>
								<li>
									<input id="<?= $val->city ?>" name="location" value="<?= $val->city ?>" state="<?= $val->state ?>"  class="custom-control-input" type="radio">
									<label class="location-box" tabindex="2" for="<?= $val->city ?>">
										<span class="fas fa-map-marker-alt location-icon"></span>
										<p class="location-name"><?= $val->city.', '. $val->state ?></p>
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
				
				<script>
				<?php if($_COOKIE['city'] ==  ''){ ?>
				$(document).ready(function(){
					$('#location-modal').modal('show');
				});
				<?php } ?>
				
				//seach city list
				function myFunction() {
					var input, filter, ul, li, a, i, txtValue;
					input = document.getElementById("city-search");
					filter = input.value.toUpperCase();
					ul = document.getElementById("location-area");
					li = ul.getElementsByTagName("li");
					for (i = 0; i < li.length; i++) {
						a = li[i].getElementsByTagName("p")[0];
						txtValue = a.textContent || a.innerText;
						if (txtValue.toUpperCase().indexOf(filter) > -1) {
							li[i].style.display = "";
						} else {
							li[i].style.display = "none";
						}
					}
				}
				
				//onchange set city in cookie
				$('input[type=radio][name=location]').change(function() {
					document.cookie = 'city='+this.value;
					document.cookie = 'state='+this.getAttribute("state");
					$('#location-modal').modal('hide');
					location.reload();
				});
					
					
				</script>
				
				<a class="pr-0 mr-0" href="#" id="search-btn" title="Search" data-toggle="modal" data-target="#Search-modal" >
					<span class="text-5 ml-sm-2"><i class="fas fa-search"></i></span>
				</a>
				
				<script>
					$(document).ready(function(){
						$('#Search-modal').on('shown.bs.modal', function () {
			                $('#search_input').focus();
			            });
					});
				</script>
				
				
				
				<!-- Search Modal =========================== -->
				<div id="Search-modal" class="modal fade" role="dialog"  >
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
					function search(search){
						 $.ajax({
							url:url + 'Home/search',
							method:"POST", 
							data:{ search:search}, 
							//dataType: 'json',
							beforeSend : function(){ 
							},
							success: function(data){
								//alert(data);
								//console.log(data);
								$('#search-result').html(data);
							},
							error: function(e){ 
								alert('Somthing Wron');
								console.log(e);
							}           
						});
					}
				</script>
				<!-- Search Modal End -->
				
				<?php 
					if($this->session->User != null){ 
						if($main_content == 'Home' || $main_content == 'stores' || $main_content == 'Product' || $main_content == 'Services' ){ //for cart
						$pcout = $this->Mdl_common->get_cart_count(1);
						$scout = $this->Mdl_common->get_cart_count(2);
				?>
					
					
					<a class="pr-0 mr-0" href="<?= base_url() ?>Cart" title="Product Cart">
						<span class="text-5 ml-sm-2"><i class="fas fa-shopping-cart"></i></span>
						<?php if($pcout > 0){ ?> <span class='badge' id='lblCartCount'> <?= $pcout ?> </span> <?php } ?>
					</a>
					
					<a class="pr-0 pl-1 mr-0" href="<?= base_url() ?>Cart/Booking_cart" title="Booking Cart">
						<span class="text-5 ml-sm-2"><i class="far fa-calendar-alt" style="font-size: 23px;"></i></span>
						<?php if($scout > 0){ ?> <span class='badge' id='lblCartCount'> <?= $scout ?> </span> <?php } ?>
					</a>
					<?php } ?>
					<li class="dropdown mobile-hide">
						<a class="pr-0 pl-1"  href="#" title="Login / Sign up">
							<!-- span class="d-none d-sm-inline-block"><?= $this->session->User->username ?></span --> 
							<span class=" ml-sm-2"><img src="<?= base_url().$this->session->User->user_image ?>" style="height: 30px;border-radius: 10px;"/></span>
						</a>
						 <ul class="dropdown-menu" >
							<li><a class="dropdown-item" href="<?= base_url() ?>Account/My_profile">User Info</a></li>
							<li><a class="dropdown-item" href="<?= base_url() ?>Account/Address">My Address</a></li>
							<li><a class="dropdown-item" href="<?= base_url() ?>Account/Orders">My Order</a></li>
							<li><a class="dropdown-item" href="<?= base_url() ?>Account/Bookings">My Booking</a></li>
							<li><a class="dropdown-item" href="<?= base_url() ?>Login/logout">Logout</a></li>
						</ul>
					</li>
				<?php }else{ ?>
					<a class="pr-0 mobile-hide" style="padding-top: 18px;" data-toggle="modal" data-target="#login-modal" href="#" title="Login / Sign up">
						<span class="d-none d-sm-inline-block">Login</span> 
						<span class="user-icon ml-sm-2"><i class="fas fa-user"></i></span>
					</a>
				<?php } ?>
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
    
   
    
    
  