<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <!-- Tell the browser to be responsive to screen width -->
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>Hereits | Business </title>
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/store_registration/css/stylesheet.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	
	<!-- google import js -->
	<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
	<style>
		.madetari{
			color:red;
		}
	</style>
	<script>
    var base_url = "<?php echo base_url() ?>";
</script>
</head>
<style>
#btn_login{
	 color: #fff;
    background-color: #28a745;
    border-color: #28a745;
    box-shadow: none;
    display: inline-block;
    font-weight: 400;
    text-align: center;
    vertical-align: middle;
	padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
}
</style>
<body>
<div id="load">
	<img class="image" src="<?= base_url() ?>assets/Spinner.png" alt="" width="120" height="120">
</div>
	<div class="info">
  <h1>Hereits</h1>
</div>



<!-- Modal -info -->
<div class="container">
<div id="modal-3" class="modal" data-modal-effect="slide-top">
  <div class="modal-content">
    <h2 class="fs-title">Score Index</h2>
    <h3 class="fs-subtitle">Getting the most out of your data</h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce convallis consectetur ligula. Morbi dapibus tellus a ipsum sollicitudin aliquet. Phasellus id est lacus. Pellentesque a elementum velit, a tempor nulla. Mauris mauris lectus, tincidunt et purus rhoncus, eleifend convallis turpis. Nunc ullamcorper bibendum diam, vitae tempus dolor hendrerit iaculis. Phasellus tellus elit, feugiat vel mi et, euismod varius augue. Nulla a porttitor sapien. Donec vestibulum ac nisl sed bibendum. Praesent neque ipsum, commodo eget venenatis vel, tempus sit amet ante. Curabitur vel odio eget urna dapibus imperdiet sit amet eget felis. Vestibulum eros velit, posuere a metus eget, aliquam euismod purus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
    <input type="button" name="next" class="next action-button modal-close" value="Got it!">
  </div>
</div>
</div>

<form id="myform" class="steps" method="POST" enctype="multipart/form-data" novalidate="novalidate">
<input type="hidden" name="user_id" id="user_id" value="<?= $user_info->user_id ?>" />

  <ul id="progressbar">
    <li class="active">User Information</li>
    <li>Store Information</li>
    <li>Store Address</li>
  </ul>



  <!-- USER INFORMATION FIELD SET --> 
  <fieldset>
    <h2 class="fs-title">Personal Detail</h2>
    <h3 class="fs-subtitle">We just need some basic information to begin your scoring</h3>
	
		<div class="row">
			<div class="col-md-12">
				<div class="hs_firstname field hs-form-field">
				  <div class="uploadimage jstinput common-profile-frames">
						<img onclick="upload_open_user_image()" id="user_image_display" class="image_display" src="<?php echo base_url(); ?>assets/store_registration/images/upload-image.png" alt="user">
						<div style="background-color: white;position: inherit;">
							<span>Upload your image</span> <span class="madetari">*</span></br>
							<span>Image size 140 X 140</span>
						</div>
						<input onchange="load_user_image(event)" type="file" name="user_image" id="user_image" style="width: 0px !important;height: 0px !important;margin-top: -25px;">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="hs_firstname field hs-form-field">
				  <label >First Name <span class="madetari">*</span></label>
				  <input name="frist_name" type="text" placeholder="First Name" value="<?= $user_info->frist_name ?>"  >
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="hs_firstname field hs-form-field">
				  <label >Last Name <span class="madetari">*</span></label>
				  <input name="last_name"  type="text" placeholder="Last Name" value="<?= $user_info->last_name ?>">
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="hs_firstname field hs-form-field">
				  <label >User Name <span class="madetari">*</span></label>
				  <input name="username" id="username" type="text" placeholder="User Name" value="<?= $user_info->username ?>">
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="hs_firstname field hs-form-field">
				  <label >Email <span class="madetari">*</span></label>
				  <input name="email" id="email"  type="email" placeholder="Email Id" value="<?= $user_info->email ?>">
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="hs_firstname field hs-form-field">
				  <label >Contact <span class="madetari">*</span></label>
				  <input name="contact" id="contact"  type="text" placeholder="Contact Number" value="<?= $mobile_no ?>" readonly="readonly">
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="hs_firstname field hs-form-field">
				  <label >Referral Code </label>
				  <input name="referral_code" id="referral_code"  type="text" placeholder="Referral Code" onchange="check_referral()">
				  <p style="color:green;display:none;" id="referal_applied"><i class="far fa-check-square"></i> Referral Applied</p>
				  <p style="color:red;display:none;" id="referal_notfnd" ><i class="far fa-times-circle"></i> Referral Not Applied</p>
				</div>
			</div>
		
			<div class="col-md-6">
				<div class="hs_firstname field hs-form-field">
					<label >Gender <span class="madetari">*</span></label>
					<select name="gender" id="gender">
					  <option value="">Select Your Gender</option>
					  <option value="1" <?php if($user_info->gender == 1){ echo 'selected'; } ?>>Male</option>
					  <option value="2" <?php if($user_info->gender == 2){ echo 'selected'; } ?>>Female</option>
					  <option value="3" <?php if($user_info->gender == 3){ echo 'selected'; } ?>>Other</option>
					</select>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="hs_firstname field hs-form-field">
				  <label >password <span class="madetari">*</span></label>
				  <input name="password" id="password" type="password" placeholder="Password" >
				</div>
			</div>
			
			<div class="col-md-12">
				<div class="separator">Documents</div>
			</div>
			
			<div class="col-md-6 col-6">
				<div class="uploadimage jstinput common-profile-frames" style="left: 15%;width: 70%;">
					<img onclick="upload_open_adhar_image()" id="user_adhar_image_display" class="image_display" src="<?php echo base_url(); ?>assets/store_registration/images/upload-image.png" alt="documents">
					<div style="background-color: white;position: inherit;">
						<span>Upload Adhar Card(Front)</span>
						<span>Image size 140 X 140</span>
					</div>
					<input onchange="load_user_adhar_image()" type="file" name="adhar_card_front_image" id="adhar_card_front_image" style="width: 0px !important;height: 0px !important;margin-top: -25px;">
					
				</div>
			</div>
			
			<div class="col-md-6 col-6">
				<div class="uploadimage jstinput common-profile-frames" style="left: 15%;width: 70%;">
					<img onclick="upload_open_adhar_back_image()" id="user_adhar_back_image_display" class="image_display" src="<?php echo base_url(); ?>assets/store_registration/images/upload-image.png" alt="documents">
					<div style="background-color: white;position: inherit;">
						<span>Upload Adhar Card(Back)</span>
						<span>Image size 140 X 140</span>
					</div>
					<input onchange="load_user_adhar_back_image()" type="file" name="adhar_card_back_image" id="adhar_card_back_image" style="width: 0px !important;height: 0px !important;margin-top: -25px;">
					
				</div>
			</div>
			<div class="col-md-12">
				  <label >Adhar Card Number </label>
				  <input name="adhar_card_number"  type="text" placeholder="Adhar Card Number" >
			</div>
			
			<div class="col-md-12">
				<div class="separator">Femily Detail</div>
			</div>
			
			<div class="col-md-6">
				  <label >Family Member Name </label>
				  <input name="family_name"  type="text" placeholder="Family Member Name" >
			</div>
			
			<div class="col-md-6">
				  <label >Family Member Relation </label>
				  <input name="family_relation"  type="text" placeholder="Family Member Relation" >
			</div>
			
			<div class="col-md-6">
				  <label >Family Member Contact </label>
				  <input name="family_contact"  type="text" placeholder="Family Member Contact" >
			</div>
			<div class="col-md-12">
			</div>
			
		</div>
		
		<input type="button" data-page="1" name="next" class="next action-button" value="Next" />
    
    </fieldset>



  <!-- ACQUISITION FIELD SET -->  
  <fieldset>
    <h2 class="fs-title">Store Information</h2>
    <h3 class="fs-subtitle">How have you been doing in acquiring donors?</h3>
		<div class="row">
			<div class="col-md-12">
				<div class="hs_firstname field hs-form-field">
				  <div class="uploadimage jstinput common-profile-frames">
						<img onclick="upload_open_store_image()" id="store_image_display" class="image_display" src="<?php echo base_url(); ?>assets/store_registration/images/upload-image.png" alt="store">
						<div style="background-color: white;position: inherit;">
							<span>Upload Store image</span> <span class="madetari">*</span></br>
							<span>Image size 140 X 140</span>
						</div>
						<input onchange="load_store_image()" type="file" name="store_image" id="store_image" style="width: 0px !important;height: 0px !important;margin-top: -25px;">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="hs_firstname field hs-form-field">
				  <label >Store Name <span class="madetari">*</span></label>
				  <input name="Store_name" type="text" placeholder="Store Name"  >
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="hs_firstname field hs-form-field">
				  <label >Email <span class="madetari">*</span></label>
				  <input name="store_email" id="store_email"  type="email" placeholder="Email Id" >
				</div>
			</div>
			
			<div class="col-md-6">
				  <label>Contact <span class="madetari">*</span></label>
				  <input name="store_contact" id="store_contact"  type="text" placeholder="Contact Number" >
			</div>
			
			<!-- div class="col-md-6">
				<div class="hs_firstname field hs-form-field">
					<label >Store Type <span class="madetari">*</span></label>
					<select name="store_type" id="store_type">
					  <option value="">Select Store Type</option>
					  <option value="1">Product Seller</option>
					  <option value="2">Service Provider</option>
					  <option value="3">Both</option>
					</select>
				</div>
			</div -->

			<div class="col-md-12">
				  <label>Description </label>
				  <textarea name="description" placeholder="Description" ></textarea>
			</div>
			
			<div class="col-md-12">
				<div class="separator">Store Document</div>
			</div>
			
			<div class="col-md-6" style="margin-bottom: 10px;">
				<div class="uploadimage jstinput common-profile-frames" style="left: 15%;width: 70%;">
					<img onclick="upload_open_address_image()" id="user_address_image_display" class="image_display" src="<?php echo base_url(); ?>assets/store_registration/images/documents.jpg" alt="documents">
					<div style="background-color: white;position: inherit;">
						<span>Upload Address Proof</span> <span class="madetari">*</span></br>
						<span>Image size 140 X 140</span>
					</div>
					<input onchange="load_user_address_image()" type="file" name="address_proof_image" id="address_proof_image" style="width: 0px !important;height: 0px !important;margin-top: -25px;">
				</div>
			</div>
			<div class="col-md-6" style="margin-bottom: 10px;">
				<p>upload any one document  out of electricity bill, property tax bill (vera bill), rent agreement.</p>
			</div>
			
			
			
			<div class="col-md-12">
			</div>
			
		</div>
    <input type="button" data-page="2" name="previous" class="previous action-button" value="Previous" />
    <input type="button" data-page="2" name="next" class="next action-button" value="Next" />
  </fieldset>



  <!-- Store Documents -->  
  <fieldset>
    <h2 class="fs-title">Store Address</h2>
		<div class="row">
			<div class="col-md-12" style="margin-top: 10px;">
				<!--The div element for the map -->
				<div id="map"></div>
				<input id="pac-input" class="controls" name="store_address" type="text" placeholder="Search Box" style="border: 2px solid #857a7a;" />
				<div id="current_location"  style="z-index: 0; position: absolute; bottom: 136px; right: 0px;">
					<div style="background-color: rgb(255, 255, 255); border: 2px solid rgb(255, 255, 255); border-radius: 3px; box-shadow: rgba(0, 0, 0, 0.3) 0px 2px 6px; cursor: pointer; margin-right: 23px; text-align: center;" title="Current Location">
						<div style="color: rgb(25, 25, 25); font-family: Roboto, Arial, sans-serif; font-size: 16px; line-height: 38px; padding-left: 5px; padding-right: 5px; width: 40px;"><img class="svg" src="<?php echo base_url(); ?>assets/store_registration/images/location.png" style="width: 13px;" alt="placeholder">
						</div>
					</div>
				</div>
				<input type="hidden" id="latitude" name="latitude" />
				<input type="hidden" id="longitude" name="longitude" />
			</div>
			
			<div class="col-md-12">
				<div class="hs_firstname field hs-form-field">
				  <label>Store Address <span class="madetari">*</span></label>
				  <input name="store_address_2" type="text" placeholder="Enter shop number, building number, street etc" >
				</div>
			</div>

			<div class="col-md-4">
				<div class="hs_firstname field hs-form-field">
				  <label>City <span class="madetari">*</span></label>
				  <input name="city" id="locality" type="text" placeholder="City">
				</div>
			</div>

			<div class="col-md-4">
				<div class="hs_firstname field hs-form-field">
				  <label>District <span class="madetari">*</span></label>
				  <input name="district" id="administrative_area_level_2" type="text" placeholder="District" readonly >
				</div>
			</div>

			<div class="col-md-4">
				<div class="hs_firstname field hs-form-field">
				  <label>State <span class="madetari">*</span></label>
				  <input name="state" id="administrative_area_level_1" type="text" placeholder="State" readonly >
				</div>
			</div>

			<div class="col-md-4">
				<div class="hs_firstname field hs-form-field">
				  <label>Country <span class="madetari">*</span></label>
				  <input name="country" id="country" type="text" placeholder="Country" readonly >
				</div>
			</div>

			<div class="col-md-4">
				<div class="hs_firstname field hs-form-field">
				  <label>Pincode <span class="madetari">*</span></label>
				  <input name="pincode" id="postal_code" type="text" placeholder="Pincode"  >
				</div>
			</div>
			
			<div class="col-md-12">
			</div>
		</div>
	  
	<input type="button" data-page="3" name="previous" class="previous action-button" value="Previous" />
    <input  class="hs-button primary large action-button next" style="float: right;" type="submit" id="Submit" value="Submit">
  </fieldset>




	<fieldset>
		<div id="befor"> 
			<h2 class="fs-title">You Registration ON GOING!</h2>
			<h3 class="fs-subtitle">Please Do Not Refresh The Page</h3>
		</div>
		
		<div id="after" style="display:none"> 
			<h2 class="fs-title" style="color: green;font-weight: 600px !important;font-size: 30px;">Registration Successfully!</h2>
				<div style="text-align: center;">
					<img src="<?php echo base_url(); ?>assets/store_registration/images/success.gif" alt="Success">
				</div>
			<h3 class="fs-subtitle">Thank you For Registration. <a id="btn_login" href="<?php echo base_url();?>Login">Login</a> Now</h3>
		</div>
	</fieldset>
</form>

<script>
function check_referral()
{
	$('#referal_applied').hide();
	$('#referal_notfnd').hide();
	var referral_code = $('#referral_code').val();
	
		$.ajax({
			url:'<?php echo base_url(); ?>Business/check_referral',
			method:"POST", 
			data:{referral_code : referral_code},
			dataType: 'json',
			success:function(data)
			{  
				//console.log(data.user);
				 if(data.user != null)
				{
					$('#referal_applied').show();
					
				}else if(data.user == null){
					
					$('#referal_notfnd').show();
					
				}
			},
			error: function(e){ 
				//alertify.error("Somthing Wrong");
				console.log(e);
			} 
		});

}
</script>	

<script src="<?php echo base_url(); ?>assets/store_registration/js/google_map.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApYAW3LEn3K2hO8jdq0O-fULmBmREdFtc&callback=initAutocomplete&libraries=places&region=in"></script>
<script src="<?php echo base_url(); ?>assets/store_registration/js/store_registration.js"></script>


</body>
</html>
