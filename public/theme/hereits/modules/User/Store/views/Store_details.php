	
	
	
	<section class="section bg-white shadow-md pt-2">
			<ul class="nav nav-tabs nav-fill justify-content-center mb-2" id="myRoutes" role="tablist">
				<li class="nav-item"> <a class="nav-link text-4 active" id="one-tab" data-toggle="tab" href="#home" role="tab" aria-controls="one" aria-selected="false">Home</a> </li>
				<?php if($Stores->store_type == 1 || $Stores->store_type == 3){ ?><li class="nav-item"> <a class="nav-link text-4" id="product-tab" data-toggle="tab" href="#products" role="tab" aria-controls="one" aria-selected="false">Products</a> </li><?php } ?>
				<?php if($Stores->store_type == 2 || $Stores->store_type == 3){ ?><li class="nav-item"> <a class="nav-link text-4 " id="service-tab" data-toggle="tab" href="#service" role="tab" aria-controls="two" aria-selected="false">Services</a> </li><?php } ?>
				<li class="nav-item"> <a class="nav-link text-4 " id="three-tab" data-toggle="tab" href="#gallery" role="tab" aria-controls="two" aria-selected="false">gallery</a> </li>
				<!-- li class="nav-item"> <a class="nav-link text-4 " id="four-tab" data-toggle="tab" href="#review" role="tab" aria-controls="two" aria-selected="false">Review</a> </li -->
			</ul>
			
			<!-- Store Info -->
			<section class="hero-wrap section pb-3" id="store_info">
			  <div class="hero-bg" style="background-image:url('<?= base_url() ?>assets/front/img/store-bg.jpg');"></div>
			  <div class="hero-content">
				<div class="container">
				  <div class="row">
					<div class="col-lg-4 col-4 text-center " style="align-self: center;"> 
						<img class="img-fluid store-img" alt="" src="<?= base_url().$Stores->store_image ?>" style="border-radius: 20px;"> 
					</div>
					<div class="col-lg-8 col-8 text-lg-left mt-4">
					  <h2 class=" font-weight-600 text-light store-name"><?= $Stores->Store_name ?> </h2>
					  <p class="mb-2">
							<!-- span class="mr-2">
								<i class="fas fa-star text-warning"></i>
								<i class="fas fa-star text-warning"></i>
								<i class="fas fa-star text-warning"></i>
								<i class="fas fa-star text-warning"></i>
							</span -->
							<span class="text-light product-description"><i class="fas fa-map-marker-alt "></i> <?= $Stores->store_address ?></span>
							<!-- p class="reviews mb-3">
								<span class="reviews-score px-2 py-1 rounded font-weight-600 text-light">8.2</span> <span class="font-weight-600 text-light">Excellent</span> <a class="text-light" href="#">(245 reviews)</a>
							</p -->
							<p class=" d-flex align-items-center mb-2 text-4">
								
								<!-- store fevourit -->
								<?php if($this->session->User != NULL){ ?>
									<span class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2" data-toggle="tooltip" data-original-title="Favourite" id="fav" item_id="<?= $Stores->store_id ?>" store_id="<?= $Stores->store_id ?>"><i class="<?php if($Stores->is_fevourit == 1){ echo 'fas fa-heart';}else{ echo 'far fa-heart';} ?>"></i></span>
								<?php } ?>
							
								<a href="tel:<?= $Stores->store_contact ?>" target="_blank" data-toggle="tooltip" data-original-title="Call" class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2"><i class="fas fa-phone-alt"></i></a>
								<a href="#" id="copylink" data-toggle="tooltip" data-original-title="Copy Link To Shere" class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2"><i class="far fa-copy"></i></a>
								<a href="http://maps.google.com/maps?q=<?= $Stores->latitude.','.$Stores->longitude ?>&ll=<?= $Stores->latitude.','.$Stores->longitude ?>&z=17" target="_blank" data-toggle="tooltip" data-original-title="get directions" class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2"><i class="fas fa-map-marker-alt"></i></a>
								<a href="https://wa.me/91<?= $Stores->store_contact ?>/?text=i want to know about" target="_blank" data-toggle="tooltip" data-original-title="Chat With Store" class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2"><i class="fab fa-whatsapp"></i></a>
							</p>
						</p>
					</div>
				  </div>
				</div>
				</div>
			</section>
			<div class="tab-content mt-2" id="myRoutesContent">
			
				<div class="tab-pane fade  active show" id="home" role="tabpanel" aria-labelledby="home-tab">
					<?= $home_html ?>
				</div>
				
				<div class="tab-pane fade " id="products" role="tabpanel" aria-labelledby="one-tab">
					<?= $product_html ?>
				</div>
			  
				<div class="tab-pane fade" id="service" role="tabpanel" aria-labelledby="two-tab">
					<?= $service_html ?>
				</div>
			 
				<div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="three-tab">
					<?= $gallery_html ?> 
				</div>
				
				<div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="four-tab">
					<?= $review_html ?> 
				</div>
			 
			</div>
		</div>
    </section>
	
	<script>
	$("#fav").click(function(){
		var item_id = $(this).attr('item_id');
		var store_id = $(this).attr('store_id');
		fevourite(item_id, store_id, 1, 1, 'fav');
	});
	
	function product_fav(item_id,store_id){
		fevourite(item_id, store_id, 1, 0, 'product-fav-'+item_id);
	}
	
	function fevourite(item_id, store_id, type, isstore, id){
		$.ajax({
				url:url + 'Store/favouriteRequest',
			method:"POST", 
			data:{ item_id:item_id, store_id:store_id, type:type, isstore:isstore }, 
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
					$('#'+id).html('<i class="fas fa-heart"></i>');
				}else{
					$('#'+id).html('<i class="far fa-heart"></i>');
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
	
	//copy link
	$("#copylink").click(function(){
		var $temp = $("<input>");
		var $url = $(location).attr('href');
		$("body").append($temp);
		$temp.val($url).select();
		document.execCommand("copy");
		$temp.remove();
		//alert("Copied the text: " + url);
	});
	</script>
	
