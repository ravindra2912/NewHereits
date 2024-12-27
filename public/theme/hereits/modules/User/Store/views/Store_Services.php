 
	<section class="container mt-1 mb-5">
        <input type="hidden" value="<?= $store_id ?>" name="store_id" id="store_id" />
        <div class="row">
			<div class="col-lg-2 mt-2 mt-lg-2 col-0">
			</div>
			<div class="col-lg-10 mt-4 mt-lg-0">
				<!-- form id="bookingHotels" method="post">
					<div class="form-row">
						<div class="col-md-12 col-lg form-group">
							<input type="text" class="form-control" required placeholder="Search">
							<span class="icon-inside"><i class="fas fa-map-marker-alt"></i></span> 
						</div>
				   
						<div class="col-md-6 col-lg form-group">
							<button class="btn btn-primary btn-block" type="submit">Search</button>
						</div >
					</div>
				</form -->
          <!-- Sort Filters  ============================================= -->
				<div class=" mb-2 pb-2">
					<div class="row align-items-center">
						<!--div class="col-6 col-md-8">
							<span class="mr-3"><span class="text-4">Surat:</span> <span class="font-weight-600" id="total_products">0 Products</span> found</span> 
						</div -->
						<div class="col-12 col-md-12">
							<div class="row no-gutters ml-auto">
								<label class="col col-form-label-sm text-right mr-2 mb-0" for="input-sort">Sort By:</label>
								<select  class="custom-select custom-select-sm col" id="service_sort_by" onchange="get_data(0)">
								  <option value="1" selected>Popularity</option>
								  <option value="3" >Newest First</option>
								  <option value="5" >Price: Low to High</option>
								  <option value="6" >Price: High to Low</option>
								</select>
							</div>
						</div>
					</div>
				</div><!-- Sort Filters end -->
          
          <!-- List Item
          ============================================= -->
				<div class="row" id="service_grid">
		  
				</div><!-- List Item end -->
          
				<!-- Pagination
				============================================= -->  
				<div class="pagination justify-content-center mt-4 mb-0" id="sercice_pagination">
				</div>
				<!-- Paginations end -->
				
				
          
			</div>
        </div>
    </section>
	
	<!-- ---------------- Services Catr Start ------------------->
	<a href="https://hereits.com/Cart/Booking_cart" class="bg-primary hmkNrQ cart-btn-style" >
		<span class="cart-btn-items">
			<span> <li class="fas fa-shopping-bag"></li> </span>
			<span class="cart-btn-item pl-2" id="service_cart_item">0 Item</span>
		</span>
		
		<span class="text-primary cart-btn-price" id="service_cart_amount">Rs 0</span>
	</a>	
	
	
	
	<!-- ---------------- Services Catr End ------------------->	
	
	<script>
		// Detect pagination click
		 $('#pagination').on('click','a',function(e){
		   e.preventDefault(); 
		   var pageno = $(this).attr('data-ci-pagination-page');
		   get_data(pageno);
		 });
	
	get_data(0);
	//Get Table Data
	function get_data(pagno){
		//alert(pagno);
		var sort_by = $('#service_sort_by').val();
		var store_id = $('#store_id').val();
		$.ajax({
				url:url + 'Store/ajax_get_store_services/'+pagno,
				//method:"POST", 
				type: 'POST',
				data:{ sort_by:sort_by,  store_id:store_id }, 
				dataType: 'json',
				beforeSend:function(response){ 
					document.getElementById("preloader").style.display = "block"; 
				},
				success:function(response){  
					//alert(response); 
					
					$('#service_grid').html('');
					$('#service_grid').html(response.grid_view);
					$('#sercice_pagination').html(response.pagination);
					//console.log(response.grid_view);
					
					document.getElementById("preloader").style.display = "none"; 
					var elmnt = document.getElementById("top");
					elmnt.scrollIntoView();
					
					$('#service_cart_item').html(response.cart_item+' Item');
					$('#service_cart_amount').html('Rs '+response.cart_amount);
				},
				error: function(e){ 
					//alertify.error("Somthing Wrong");
					alert('Somthing Wrong')
					console.log(e);
				} 
			});
	}	
	
	function add_service_in_cart(item_id, store_id, cartstore, type){
  
		if(store_id != cartstore && cartstore != ''){
			if(confirm("Store Is Different. Are You Sure You Want To Remove Previous Store Items?")){ add_to_cart_service(item_id, store_id, type, 's-cart-container-'+item_id, cartstore); }
		}else{ add_to_cart_service(item_id, store_id, type, 's-cart-container-'+item_id, cartstore); }

		
	}
	
	function add_to_cart_service(item_id, store_id, type, id, cartstore){
		$.ajax({
			url:url + 'Store/add_to_cart',
			method:"POST", 
			data:{ item_id:item_id, store_id:store_id, type:type }, 
			dataType: 'json',
			beforeSend:function(response)
			{ 
				document.getElementById("preloader").style.display = "block"; 
			},
			success:function(response)
			{  
				//console.log(response);
				if(response.status == 1){
					//alert(response.Message);
					
					$('#'+id).html('<a href="#" class="btn btn-sm btn-danger text-1" onclick="remove_cart_item('+item_id+','+store_id+','+type+')">Remove</a>');
					$('#service_cart_item').html(response.cart_item+' Item');
					$('#service_cart_amount').html('Rs '+response.cart_amount);
				}else{
					alert(response.Message);
				}
				document.getElementById("preloader").style.display = "none"; 
				
				if(store_id != cartstore && cartstore != ''){
					get_data(0);
				}
			},
			error: function(e){ 
				//alertify.error("Somthing Wrong");
				alert("Somthing Wrong");
				console.log(e);
				document.getElementById("preloader").style.display = "none"; 
			} 
		});
	}
	
	//update cart
	function remove_cart_item(item_id, store_id, type){
		$.ajax({
				url:url + 'Store/remove_cart_item',
				method:"POST", 
				data:{ type:type, item_id:item_id}, 
				dataType: 'json',
				beforeSend:function(response)
				{ 
					document.getElementById("preloader").style.display = "block"; 
				},
				success:function(response)
				{  
					if(response.status == 1){
						$('#s-cart-container-'+item_id).html('<a href="#" class="btn btn-sm btn-primary text-1" onclick="add_service_in_cart('+item_id+','+store_id+','+store_id+', '+type+')">Add</a>');
					}
					$('#service_cart_item').html(response.cart_item+' Item');
					$('#service_cart_amount').html('Rs '+response.cart_amount);
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
	
	function service_fav(Package_id, store_id){
		$.ajax({
			url:url + 'Services/favouriteRequest',
			method:"POST", 
			data:{ item_id:Package_id, store_id:store_id, type:2, isstore:0 }, 
			dataType: 'json',
			beforeSend:function(response)
			{ 
				document.getElementById("preloader").style.display = "block"; 
			},
			success:function(response)
			{  
				//console.log(response);
				if(response.status == 1){
					//alert(response.Message);
					$('#service_fav-'+Package_id).html('<i class="fas fa-heart"></i>');
				}else{
					$('#service_fav-'+Package_id).html('<i class="far fa-heart"></i>');
				}
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
	</script>
