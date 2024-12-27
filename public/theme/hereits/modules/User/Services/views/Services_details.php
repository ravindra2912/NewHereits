 <style>
 @media (max-width: 767px){
 .mobile-v-croll{
	 overflow: auto;
    white-space: nowrap;
 }
 .molile-column-reverse{
	 flex-direction: column-reverse;
 }
 }
 </style>
	<section class="section bg-white mt-1">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-12 mb-3">
					<div class="row no-gutters molile-column-reverse">
						
						<div class="col-md-12 col-12" style="text-align: -webkit-center;">
							
							<img class="img-fluid d-block rounded p-list-main-img" src="<?= base_url().$pachages->packege_image ?>" style="width:auto; height: 300px; object-fit: contain;" alt="hereits">
						</div>
					</div>
              
				</div>
				<div class="col-md-6 col-12">
					<h5><a href="#" class="text-dark text-6"><?= $pachages->Package_name ?></a></h5>
					<?php if($pachages->price_type == 1){ ?>
						<div class="bg-transparent d-flex align-items-center mt-3">
							<div class="text-dark text-5 font-weight-500 mr-2 mr-lg-3"><i class="fas fa-rupee-sign text-4"></i><?= $pachages->packege_sale_price ?></div>
							<div class="d-block text-3 text-black-50 mr-2 mr-lg-3"><del class="d-block"><i class="fas fa-rupee-sign text-2"></i><?= $pachages->packege_price ?></del></div>
							<div class="text-success text-3"><?= round( (($pachages->packege_price - $pachages->packege_sale_price) / $pachages->packege_price) * 100 ) ?>% Off!</div>
						</div>
					<?php }else if($pachages->price_type == 2){ ?>
						<div class="bg-transparent d-flex align-items-center mt-3">
							<div class="text-dark text-5 font-weight-500 mr-2 mr-lg-3"><i class="fas fa-rupee-sign text-4"></i><?= $pachages->packege_sale_price ?></div>
							<div class="text-dark text-5 font-weight-500 mr-2 mr-lg-3">-</div>
							<div class="text-dark text-5 font-weight-500 mr-2 mr-lg-3"><i class="fas fa-rupee-sign text-4"></i><?= $pachages->packege_price ?></div>
						</div>
					<?php } ?>
					<p class="mt-3">  
						<a href="<?= base_url() ?>Store/store_details/<?= $pachages->store_slug ?>" class="text-black-50  text-4"><i class="fas fa-store"></i> <?= $pachages->store_name ?> <i class="fas fa-share text-2"></i></a> 
					</p> 
					<p class="mt-2">  
						<span class="text-black-50  text-3"><span class="text-dark text-3 font-weight-500 ">Category :</span> <?= $pachages->category_name ?></span> 
					</p> 
					
					<!--p class="reviews mt-2"> 
						<span class="reviews-score px-2 py-1 mr-1 rounded font-weight-600 text-light">8.2</span> <span class="font-weight-600">Excellent</span> <a class="text-black-50" href="#">(245 reviews)</a> 
					</p -->
					<div class="mb-3" id="cart_btn_area">
						<?php if($pachages->price_type == 1){ //-- for cart  ?>
								<a <?php if($this->session->User != NULL){echo 'href="'.base_url().'Cart/Booking_cart"';}else{echo 'data-toggle="modal" data-target="#login-modal" href="#"';} ?> class="btn btn-success btn-sm gotocart" style="<?php if($pachages->in_cart == 0){ echo 'display: none;';} ?>">Go To Cart</a> 
								<button type="button" class="btn btn-primary btn-sm addtocart" <?php if($this->session->User != NULL){echo 'id="addtocart"';}else{echo 'data-toggle="modal" data-target="#login-modal"';} ?>  Package="<?= $pachages->Package_id ?>" store="<?= $pachages->store_id ?>" cartstore="<?= $pachages->cart_store ?>" style="<?php if($pachages->in_cart == 1){ echo 'display: none;';} ?>">Add To Cart</button>
						<?php }else if($pachages->price_type == 2){ ?><!-- for get quote -->
							<a href="https://wa.me/91<?= $pachages->store_contact ?>/?text=<?= base_url() ?>Services/service_details/<?= $pachages->package_slug ?> %0a %0a i am interested in your above Service, please tell the price" class="btn btn-primary btn-sm"   ><div class="add-item-to-box text-white"> Ask for Price</div></a>
						<?php 
						}else{ ?> 
							<a href="https://wa.me/91<?= $pachages->store_contact ?>/?text=<?= base_url() ?>Services/service_details/<?= $pachages->package_slug ?> %0a %0a i am interested in your above Service, please tell the price" class="btn btn-primary btn-sm"   ><div class="add-item-to-box text-white"> Ask for Price</div></a>
						<?php }
						if($this->session->User != NULL){ ?>
							<button type="button" class="btn btn-outline-primary btn-sm shadow-none" id="fav" item_id="<?= $pachages->Package_id ?>" store_id="<?= $pachages->store_id ?>" data-toggle="tooltip" data-original-title="Fevorite"><i class="<?php if($pachages->is_favorite == 1){ echo 'fas fa-heart';}else{ echo 'far fa-heart';} ?>"></i></button>
						<?php } ?>
						<button type="button" class="btn btn-outline-primary btn-sm shadow-none" id="copylink" data-toggle="tooltip" data-original-title="Copy Link To Shere"><i class="far fa-copy"></i></button>
					</div>
					<p class="text-black-50 product-description"><?= $pachages->packege_description ?></p>
				</div>
			</div>
		</div>
    </section>
	
	<section class="section bg-white pt-0">
		<div class="container">
			<ul class="nav nav-tabs nav-fill justify-content-center mb-3" id="myRoutes" role="tablist">
				<li class="nav-item"> <a class="nav-link text-4 active" id="one-tab" data-toggle="tab" href="#Description" role="tab" aria-controls="one" aria-selected="false">Description</a> </li>
				<?php if($pachages->packege_includes != NULL){ ?><li class="nav-item"> <a class="nav-link text-4 " id="four-tab" data-toggle="tab" href="#includes" role="tab" aria-controls="two" aria-selected="false">includes</a> </li> <?php } ?>
				<?php if($pachages->packege_excludes != NULL){ ?><li class="nav-item"> <a class="nav-link text-4 " id="four-tab" data-toggle="tab" href="#excludes" role="tab" aria-controls="two" aria-selected="false">Excludes</a> </li> <?php } ?>
				<!-- li class="nav-item"> <a class="nav-link text-4 " id="four-tab" data-toggle="tab" href="#review" role="tab" aria-controls="two" aria-selected="false">Review</a> </li -->
			</ul>
			<div class="tab-content" id="myRoutesContent">
				<div class="tab-pane fade  active show" id="Description" role="tabpanel" aria-labelledby="one-tab">
					<p class="text-black-50"><?= $pachages->packege_description ?></p>
				</div>
				<?php if($pachages->packege_includes != NULL){ ?>
					<div class="tab-pane fade" id="includes" role="tabpanel" aria-labelledby="four-tab">
						<p class="text-black-50"><?= $pachages->packege_includes ?></p>
					</div>
				<?php } 

				if($pachages->packege_excludes != NULL){ ?>
					<div class="tab-pane fade" id="excludes" role="tabpanel" aria-labelledby="four-tab">
						<p class="text-black-50"><?= $pachages->packege_excludes ?></p>
					</div>
				<?php } ?>
				<div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="four-tab">
					<?php include 'product_review.php';?> 
				</div>
			 
			</div>
		</div>
    </section>
	
	<?php if($get_related_packages != NULL){ ?>
	<section class="section  pt-3 bg-white">
		<div class="container ">
			<h2 id="reviews" class="text-6 mb-5">Related Package</h2>
			<div class="row " id="service_grid">
				<?= $get_related_packages ?>
			</div>
		</div>
    </section>
	<?php } ?>
<script>
	$("#addtocart").click(function(){
		var item_id = $(this).attr('Package');
		var store_id = $(this).attr('store');
		var cartstore = $(this).attr('cartstore');
		var add = 0;
  
		if(store_id != cartstore && cartstore != ''){
			if(confirm("Store Is Different. Are You Sure You Want To Remove Previous Store Items?")){ add = 1; }
		}else{ add = 1; }

		if(add == 1){
			$.ajax({
				url:url + 'Services/add_to_cart',
				method:"POST", 
				data:{ item_id:item_id, store_id:store_id }, 
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
						$('.addtocart').hide();
						$('.gotocart').show();
					}else{
						alert(response.Message);
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
	});
	
		$("#fav").click(function(){
		var item_id = $(this).attr('item_id');
		var store_id = $(this).attr('store_id');
  
		
			$.ajax({
			url:url + 'Services/favouriteRequest',
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
					$('#fav').html('<i class="fas fa-heart"></i>');
				}else{
					$('#fav').html('<i class="far fa-heart"></i>');
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
	});
	
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
<script>
	$('.p-list-img').click(function() {    
	$('.p-list-main-img').attr("src",$(this).attr('src'));
  //alert('a');
});
</script>
