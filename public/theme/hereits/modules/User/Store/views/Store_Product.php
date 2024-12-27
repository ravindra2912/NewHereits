 
	<section class="container mt-1 mb-5">
        <input type="hidden" value="<?= $store_id ?>" name="store_id" id="store_id" />
        <div class="row">
			<div class="col-lg-12 mt-4 mt-lg-0">
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
								<select  class="custom-select custom-select-sm col" id="sort_by" onchange="get_data(0)">
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
				<div class="row" id="product_grid">
		  
				</div><!-- List Item end -->
          
				<!-- Pagination
				============================================= -->  
				<div class="pagination justify-content-center mt-4 mb-0" id="pagination">
				</div>
				<!-- Paginations end -->
				
				
          
			</div>
        </div>
    </section>
	
	<!-- ---------------- product Catr Start ------------------->
	<?php if($this->session->User != null){ ?>
		<a href="<?= base_url() ?>Cart" class="bg-primary hmkNrQ cart-btn-style">
	<?php }else{ ?>
		<a href="#" data-toggle="modal" data-target="#login-modal" class="bg-primary hmkNrQ cart-btn-style">
	<?php } ?>
		<span class="cart-btn-items">
			<span> <li class="fas fa-shopping-bag"></li> </span>
			<span class="cart-btn-item pl-2" id="cart_item">0 Item</span>
		</span>
		
		<span class="text-primary cart-btn-price" id="cart_amount">Rs 0</span>
	</a>	
	
	
	
	<!-- ---------------- product Catr End ------------------->	
	
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
		var sort_by = $('#sort_by').val();
		var store_id = $('#store_id').val();
		$.ajax({
				url:url + 'Store/ajax_get_store_products/'+pagno,
				//method:"POST", 
				type: 'POST',
				data:{ sort_by:sort_by,  store_id:store_id }, 
				dataType: 'json',
				beforeSend:function(response){ 
					document.getElementById("preloader").style.display = "block"; 
				},
				success:function(response){  
					//alert(response); 
					
					$('#product_grid').html('');
					$('#product_grid').html(response.grid_view);
					$('#pagination').html(response.pagination);
					$('#total_products').html(response.total_products+' Products');
					$('#cart_item').html(response.cart_item+' Item');
					$('#cart_amount').html('Rs '+response.cart_amount);
					//console.log(response.grid_view);
					
					document.getElementById("preloader").style.display = "none"; 
					var elmnt = document.getElementById("top");
					elmnt.scrollIntoView();
				},
				error: function(e){ 
					//alertify.error("Somthing Wrong");
					alert('Somthing Wrong')
					console.log(e);
				} 
			});
	}	
	
	function add_product_in_cart(item_id, store_id, cartstore, type){
		if(store_id != cartstore && cartstore != ''){
			if(confirm("Store Is Different. Are You Sure You Want To Remove Previous Store Items?")){ add_to_cart(item_id, store_id, type, 'p-cart-container-'+item_id, cartstore); }
		}else{ add_to_cart(item_id, store_id, type, 'p-cart-container-'+item_id, cartstore); }
	}
	
	function add_to_cart(item_id, store_id, type, id, cartstore){
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
				console.log(response);
				if(response.status == 1){
					//alert(response.Message);
					var data = '	<div class="bg-primary cart-counter mt-3" style="width: unset;">';
						data +='		<button class="CounterButton" onclick="update_qty(0,'+item_id+')" id="btn_decrement-'+item_id+'">-</button>';
						data +='		<span class="CounterValue" id="CounterValue-'+item_id+'">1</span>';
						data +='		<button class="CounterButton" onclick="update_qty(1,'+item_id+')" id="increment-'+item_id+'">+</button>';
						data +='	</div>';
					$('#'+id).html(data);
					$('#cart_item').html(response.cart_item+' Item');
					$('#cart_amount').html('Rs '+response.cart_amount);
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
	function update_qty(qty_type, item_id){
		$.ajax({
				url:url + 'Store/update_cart_qty',
				method:"POST", 
				data:{ type:1, item_id:item_id, qty_type:qty_type }, 
				dataType: 'json',
				beforeSend:function(response)
				{ 
					document.getElementById("preloader").style.display = "block"; 
				},
				success:function(response)
				{  
					if(response.status == 1){
						$('#p-cart-container-'+item_id).html(response.html);
					}
					$('#cart_item').html(response.cart_item+' Item');
					$('#cart_amount').html('Rs '+response.cart_amount);
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
