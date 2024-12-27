
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
						
						
					</div>
				</div>
				<div class="col-lg-4 bg-white mt-3 pt-3">
					<h2 id="reviews" class="text-6">Summary</h2>
					<hr class="mx-n3">
					
					<div class="bg-white rounded p-3"> 
						<ul class="list-unstyled">
							<li class="mb-2">Subtotal <span class="float-right text-4 font-weight-500 text-dark" id="Subtotal">Rs.0</span></li>
							<!-- li class="mb-2">Service  <span class="float-right text-4 font-weight-500 text-dark" id="Shipping">Rs.0</span></li>
							<li class="mb-2" id="Discount">Discount <span class="float-right text-4 font-weight-500 text-dark" >Rs.0</span></li -->
						</ul>
						<div class="text-dark bg-light-4 text-4 font-weight-600 p-3"> Total Amount <span class="float-right text-6" id="totalAmount">Rs.0</span> </div>
						
						<a class="btn btn-primary btn-block mt-3" href="<?= base_url() ?>Booking" >Place Booking</a>
					</div>
					
				</div>
            </div>
        </div>
    </section>
 
<script>


	


	get_cart();
	function get_cart(){
		$.ajax({
			url:url + 'Cart/get_user_booking_cart',
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
	
	function remove_cart_items(cart_item_id){
		if (confirm("Are You Sure You Want To Remove This Item!")) {
			$.ajax({
				url:url + 'Cart/remove_cart_item',
				method:"POST", 
				data:{ cart_item_id:cart_item_id }, 
				//dataType: 'json',
				beforeSend:function(response)
				{ 
					document.getElementById("preloader").style.display = "block"; 
				},
				success:function(response)
				{  
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
	}
</script>
