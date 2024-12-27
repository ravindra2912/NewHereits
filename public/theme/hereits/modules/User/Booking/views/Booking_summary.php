
	<section class="section pt-0">
		<section class="section pt-0">
		<div class="container  ">
			<div class="row ">
				<div class="col-lg-8 p-4">
					<div class="row">
						
						<div class="col-lg-12 bg-white pt-3">
							<h2 id="reviews" class="text-6">Booking Items</h2>
							
							<div class="tab-pane fade active show" id="third" role="tabpanel" aria-labelledby="third-tab">
							  <div class="table-responsive-md">
								<table class="table table-hover " id="cart_item">
								 
								  <tbody>
									
									
								  </tbody>
								</table>
							  </div>
							</div>
							
						</div>
						
						<div class="col-lg-12 bg-white pt-3 mt-3">
							<h2 id="reviews" class="text-6">Booking Note</h2>
							<hr class="mx-n3">
							<p id="note">	
							</p>	
							
						</div>
						
						<div class="col-lg-12 bg-white pt-3 mt-3" id="address">
							
							
							
						</div>
					</div>
				</div>
				<div class="col-lg-4 bg-white mt-3 pt-3">
					<h2 id="reviews" class="text-6">Summary</h2>
					<hr class="mx-n3">
					
					<div class="bg-white rounded p-3"> 
						<ul class="list-unstyled">
							<li class="mb-2">Subtotal <span class="float-right text-4 font-weight-500 text-dark" id="Subtotal">Rs.0</span></li>
							<li class="mb-2">Service Charge <span class="float-right text-4 font-weight-500 text-dark" id="Shipping">Rs.0</span></li>
							<li class="mb-2" id="Discount">Discount <span class="float-right text-4 font-weight-500 text-dark" >Rs.0</span></li>
						</ul>
						<div class="text-dark bg-light-4 text-4 font-weight-600 p-3"> Total Amount <span class="float-right text-6" id="totalAmount">Rs.0</span> </div>
						<div id="coupons"></div>
						
						<h3 class="text-4 mb-3 mt-4">Payment Type</h3>
						<div class="custom-control custom-radio custom-control-inline" style="position: unset;">
							<input id="Pickup" name="payment_type" value="COD" class="custom-control-input" required="" checked type="radio">
							<label class="custom-control-label" for="Pickup">COD</label>
						</div>
						
						<a class="btn btn-primary btn-block mt-3" href="<?= base_url() ?>Booking/place_to_booking">Booking</a>
					</div>
					
				</div>
            </div>
        </div>
    </section>
 
<script>

	


	get_cart();
	function get_cart(){
		$.ajax({
			url:url + 'Booking/get_user_cart',
			method:"POST", 
			data:{ id:'' }, 
			dataType: 'json',
			beforeSend:function(response)
			{ 
				document.getElementById("preloader").style.display = "block"; 
			},
			success:function(response)
			{  
				if(response.status){
					$('#cart_item tbody').html(response.data.cart);
					$('#Subtotal').html('Rs. '+response.data.Subtotal);
					$('#Shipping').html('Rs. '+response.data.Shipping);
					$('#Discount').html(response.data.Discount);
					$('#totalAmount').html('Rs. '+response.data.totalAmount);
					$('#note').html(response.data.note);
					$('#address').html(response.data.address);
					$('#coupons').html(response.data.coupons);
				}else{
					$('section').html('<div class="container text-center p-3"> <img src="<?= base_url() ?>assets/front/img/empty_cart.jpg" style="height: 400px;object-fit: contain;width: 100%;" /> </div>');
				}
				//console.log(response);
				
				document.getElementById("preloader").style.display = "none"; 
			},
			error: function(e){ 
				//alertify.error("Somthing Wrong");
				alert("Somthing Wrong");
				console.log(e);
				document.getElementById("preloader").style.display = "none"; 
			} 
		});
	}
	
	function app_coupon(code){
		$('#coupon_input').val(code);
		update_coupon();
	}
	function update_coupon(){
			
			$.ajax({
				url:url + 'Booking/apply_coupon',
				method:"POST", 
				data:{ coupon_code:$('#coupon_input').val() }, 
				dataType: 'json',
				beforeSend:function(response)
				{ 
					$('#coupon_msg').html('');
					document.getElementById("preloader").style.display = "block"; 
				},
				success:function(response)
				{  
					//console.log(response);
					if(response.status == 1){
						$('#coupon_msg').html('<p class="text-success">'+response.Message+'</p>');
						get_cart();
					}else{
						$('#coupon_msg').html('<p class="text-danger">'+response.Message+'</p>');
					}
					
					//get_cart();
					document.getElementById("preloader").style.display = "none"; 
				},
				error: function(e){ 
					//alertify.error("Somthing Wrong");
					alert("Somthing Wrong");
					console.log(e);
					document.getElementById("preloader").style.display = "none"; 
				} 
			});
	}
	
	function remove_coupon(){
			
			$.ajax({
				url:url + 'Booking/remove_coupon_in_cart',
				method:"POST", 
				data:{ coupon_code:'' }, 
				//dataType: 'json',
				beforeSend:function(response)
				{ 
					document.getElementById("preloader").style.display = "block"; 
				},
				success:function(response)
				{  
					document.getElementById("preloader").style.display = "none"; 
					get_cart();
				},
				error: function(e){ 
					//alertify.error("Somthing Wrong");
					alert("Somthing Wrong");
					console.log(e);
					document.getElementById("preloader").style.display = "none"; 
				} 
			});
	}
</script>
