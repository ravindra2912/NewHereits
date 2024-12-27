 
	<section class="container mt-2 mb-5">
        
        <div class="row">
			<div class="col-lg-2 mt-2 mt-lg-2 col-0">
			</div>
			<div class="col-lg-10 mt-1 mt-lg-0">
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
		var category = '<?= $_GET['category'] ?>';
		var search = '<?= $_GET['search'] ?>';
		$.ajax({
				url:url + 'Product/ajax_get_products/'+pagno,
				//method:"POST", 
				type: 'POST',
				data:{ sort_by:sort_by, category:category, search:search }, 
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
	
	function fevourit(item_id, store_id){
		$.ajax({
			url:url + 'Product/favouriteRequest',
			method:"POST", 
			data:{ item_id:item_id, store_id:store_id }, 
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
					$('#product-fav-'+item_id+store_id).html('<i class="fas fa-heart"></i>');
				}else{
					$('#product-fav-'+item_id+store_id).html('<i class="far fa-heart"></i>');
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
