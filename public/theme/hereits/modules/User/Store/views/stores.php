	<section class="container mt-2 mb-5">
       
        <div class="row">
			<div class="col-lg-2 mt-2 mt-lg-2 col-0">
			</div>
			<div class="col-lg-8 mt-1 mt-lg-0">
          <!-- Sort Filters
          ============================================= -->
				<div class=" mb-2 pb-2">
					<div class="row align-items-center">
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
				<div class="" id="store_grid">
		  
					
					
				</div><!-- List Item end -->
          
				<!-- Pagination
				============================================= -->  
				<div class="pagination justify-content-center mt-4 mb-0" id="pagination">
				</div>
				<!-- Paginations end -->
          
			</div>
			<div class="col-lg-2 mt-2 mt-lg-2 col-0">
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
		$.ajax({
				url:url + 'Store/ajax_get_stores/'+pagno,
				//method:"POST", 
				type: 'POST',
				data:{ sort_by:sort_by,  }, 
				dataType: 'json',
				beforeSend:function(response){ 
					document.getElementById("preloader").style.display = "block"; 
				},
				success:function(response){  
					//alert(response); 
					
					$('#store_grid').html('');
					$('#store_grid').html(response.grid_view);
					$('#pagination').html(response.pagination);
					//$('#total_stores').html(response.total_stores+' Stores');
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
	
	function store_fevourit(store_id){
		$.ajax({
			url:url + 'Store/favouriteRequest',
			method:"POST", 
			data:{ item_id:store_id, store_id:store_id, type:1, isstore:1 }, 
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
					$('#store-fav-'+store_id).html('<i class="fas fa-heart"></i>');
				}else{
					$('#store-fav-'+store_id).html('<i class="far fa-heart"></i>');
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
