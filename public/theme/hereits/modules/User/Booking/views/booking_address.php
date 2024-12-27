
	<section class="section pt-0">
		<section class="section pt-0">
		<div class="container  ">
			<div class="row ">
				<div class="col-lg-12 p-4">
					<div class="row">
						<div class="col-lg-1 col-0">
						</div>
						<form id="form" action="<?= base_url() ?>Booking/update_address" method="post" class="col-lg-10 col-12 bg-white pt-3 mt-3">
							<h2 id="reviews" class="text-6">Booking Address</h2>
							<hr class="mx-n3">
								
							<div class="form-group">
								<label for="note">Booking Date</label>
								<input id="servicedate" type="text" name="date" class="form-control" required placeholder="Booking Date">
							</div>
							
							<div class="form-group">
								<label for="note">Booking Note</label>
								<input type="text" class="form-control" id="note" name="note" value="<?= $user_cart->note ?>" placeholder="Booking Note">
							</div>
								
							<div class="mb-3">
								
								<label for="fullName">Booking Type : </label>
								<div class="custom-control custom-radio custom-control-inline" style="position: unset;">
								  <input id="Pickup" name="delivery_type" value="1" class="custom-control-input" required="" type="radio">
								  <label class="custom-control-label" for="Pickup">At Service Provider's Address</label>
								</div>
								<?php if($user_cart->service_to_address == 1){ ?>
									<div class="custom-control custom-radio custom-control-inline" style="position: unset;">
										<input id="Deliverys" name="delivery_type" value="2" class="custom-control-input" required="" type="radio">
										<label class="custom-control-label" for="Deliverys">At Your Address</label>
									</div>
								<?php 	} ?>
								
							</div>
							
							<div id="pickup-at-stores" style="display: none;">
							
								<div class="mb-3">
									<label for="fullName">Service By : </label>
									<div class="custom-control custom-radio custom-control-inline">
									  <input id="Self" name="pickup_buy" class="custom-control-input" value="1" checked="" required="" type="radio">
									  <label class="custom-control-label" for="Self">Self</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
									  <input id="Other" name="pickup_buy" class="custom-control-input" value="2" required="" type="radio">
									  <label class="custom-control-label" for="Other">Other</label>
									</div>
								</div>
								<div class="form-group">
									<label for="name">Name</label>
									<input type="text" class="form-control" id="name" name="name" required="" placeholder="Full Name">
								</div>
								
								<div class="form-group">
									<label for="contact">Contact</label>
									<input type="text"  class="form-control" data-bv-field="fullName" id="contact" name="contact" required="" placeholder="Contact">
								</div>
							</div>
							
							<div id="delivery" class="p-2" style="display: none;">
								<div class="row" >
									<div class="col-12" style="text-align: end;">
										<a href="#">+ Add Address</a>
									</div>
									<?php foreach($addresses as $val){ ?>
									 <input id="address<?= $val->address_id ?>" name="address" value="<?= $val->address_id ?>" class="custom-control-input"  required="" type="radio">
									<label class="col-sm-4 col-12 m-1 p-3 address" for="address<?= $val->address_id ?>">
										<p class="address_type bg-info"><?php if($val->address_type == 1){ echo "Home"; } else if($val->address_type == 2){ echo "Office"; } else if($val->address_type == 3){ echo "Other"; } ?></p>
										<p class="name"><?= $val->name ?></p>
										<p><?= $val->address1.', '.$val->address2 ?></p>
										<p><?= $val->city.', '.$val->state.', '.$val->pincode ?></p>
										<p><?= $val->country ?></p>
										<p><?= $val->contact ?></p>
									</label>
									<?php } ?>
									 
								</div>
							</div> 
							<button class="btn btn-primary m-2" type="submit" >Continue</button>
						</form>
						<div class="col-lg-1 col-0">
						</div>
					</div>
				</div>
				
            </div>
        </div>
    </section>
 
<!-- validation -->
<script>
	
//validation
$('#form').validate({
		rules:{
			delivery_type:{
				required:true,
			},
			pickup_buy:{
				required:true,
			},
			name:{
				required:true,
			},
			date:{
				required:true,
			},
			contact:{
				required:true,
			},
			address:{
				required:true,
			},
			
		},
		messages:{
			delivery_type: {
				required: '<p style="color: red; position: absolute;margin: 18px 28px 0px 0px;">Please Select Delivery Type.</p><br>',
			},
			pickup_buy: {
				required: '<p style="color: red;">Please Select Pickup By.</p>',
			},
			name: {
				required: '<p style="color: red;">Please Enter Name.</p>',
			},
			date: {
				required: '<p style="color: red;">Please Select Date.</p>',
			},
			contact: {
				required: '<p style="color: red;">Please Enter Contact.</p>',
			},
			address: {
				required: '<p style="color: red;position: absolute;left: 18px;">Please Select Address.</p>',
			},
		},
	}); 
	

</script>

<script>
	$('input[type=radio][name=delivery_type]').change(function() {
		//alert(this.value);
		if (this.value == '1') {
			$('#pickup-at-stores').show();
			$('#delivery').hide();
    }
    else if (this.value == '2') {
        $('#pickup-at-stores').hide();
        $('#delivery').show();
    }else{
		$('#pickup-at-stores').hide();
        $('#delivery').hide();
	}
    
	});
$(function() {
	// Depart Date
  $('#servicedate').daterangepicker({
	singleDatePicker: true,
	autoApply: true,
	minDate: moment(),
	autoUpdateInput: false,
	}, function(chosen_date) {
  $('#servicedate').val(chosen_date.format('YYYY-MM-DD'));
  });
});
	
	
</script>
