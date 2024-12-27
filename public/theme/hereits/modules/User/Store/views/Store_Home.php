	<?php if($products != NULL){ ?>
	<section class="section  pt-3 bg-white">
		<div class="container ">
			<h2 id="reviews" class="text-6 mb-3"> Products</h2>
			<div class="row ">
				<?php foreach($products as $res){ 
					//product image
					$p_img = $this->Mdl_Store->get_product_single_image($res->product_id);
					$img = base_url().'assets/admin/images/no-image.png';
					if(file_exists($p_img->image_url)) { $img = base_url().$p_img->image_url; }
				
				?>
				<a href="<?= base_url()?>Product/Product_details/<?= $res->product_slug ?>" class="col-md-3 col-6 p-1">
					<div class="card shadow-md border-0 mb-2">
						<div class="pt-2 pl-2 pr-2"><img src="<?= $img ?>" class="card-img-top d-block product-img " alt="..."></div>
						<div class="card-body  pl-2 pr-2">
							<h5 class="p-name text-3 mb-0 text-black-50"><?= $res->product_name .' ('. $res->selling_unit_qty.$res->selling_unit .')' ?></h5>
							<p class="mb-0">  
								<span class="text-black-50 store-name"><i class="fas fa-store"></i> <?= $res->Store_name ?></span> 
							</p> 
							<!-- p class="reviews mb-2"> 
								<span class="reviews-score px-2 py-1 mr-1 rounded font-weight-600 text-light">8.2</span> <span class="font-weight-600">Excellent</span> <a class="text-black-50" href="#">(245 reviews)</a> 
							</p -->
						</div>
						<div class="card-footer bg-transparent d-flex align-items-center">
							<div class=" bg-transparent d-flex mb-1" style="height: 22px;">
								<?php if($res->price_type == 1){ ?>
								
									<div class="text-dark text-4 font-weight-500 mr-2 mr-lg-3"><i class="fas fa-rupee-sign text-3"></i><?= $res->product_sele_price ?></div>
									<div class="d-block text-2 text-black-50 mr-2 mr-lg-3"><del class="d-block"><i class="fas fa-rupee-sign text-1"></i><?= $res->product_price ?></del></div>
								
								<?php }else if($res->price_type == 2){ ?>
									<div class="text-dark text-4 font-weight-500 mr-2 mr-lg-3"><i class="fas fa-rupee-sign text-3"></i><?= $res->product_sele_price ?></div>
									<div class="text-dark text-4 font-weight-500 mr-2 mr-lg-3"> - </div>
									<div class="text-dark text-4 font-weight-500 mr-2 mr-lg-3"><i class="fas fa-rupee-sign text-3"></i><?= $res->product_price ?></div>
								
								<?php } ?>
							</div>
						</div>
					</div>
				</a>
				<?php } ?>
				
			</div>
			<a onclick="$('#product-tab').click(); var elmnt = document.getElementById('top'); elmnt.scrollIntoView();" class="view-more">View More -></a>
		</div>
		
    </section>
	<?php }
	
	if($services != NULL){ ?>
	
	<section class="section  pt-3 bg-white">
		<div class="container ">
			
			<h2 id="reviews" class="text-6 mb-3">Services</h2>
			<div class="row service_grid" >
				<?php foreach($services as $res){ 
					//service image
					$img = base_url().'assets/admin/images/no-image.png';
					if(file_exists($res->packege_image)) { $img = base_url().$res->packege_image; }
				?>
					<div class="col-lg-6 ">
						<div class=" bg-white shadow-md rounded p-2 mb-2">
							<a href="#" style="float: right;" data-toggle="modal" data-target="#package-details-<?= $res->Package_id.$res->store_id ?>">Details</a>
							<div class="row">
								<div class="col-md-5 col-4 text-center" style="align-self: center;">
									<a href="<?= base_url() ?>Services/service_details/<?= $res->package_slug ?>"><img class="img-fluid rounded align-top" src="<?= $img ?>" alt="<?= $res->Package_name ?>"></a>
								</div>
								<div class="col-md-7 col-8 pl-3 pl-md-0 mt-3 mt-md-0">
									<h4><a href="<?= base_url() ?>Services/service_details/<?= $res->package_slug ?>" class="text-dark text-3"><?= $res->Package_name ?></a></h4>
									<p class="mb-2">  
										<span class="text-black-50 store-name"><i class="fas fa-store"></i> <?= $res->Store_name ?></span> 
									</p>
									<?php if($res->price_type == 1){ ?>
										<span class="text-3 pr-2">Rs. <?= $res->packege_sale_price ?></span><span class="text-3"><del>Rs. <?= $res->packege_price ?></del></span>
									<?php }else if($res->price_type == 2){ ?>
										<span class="text-3 pr-2">Rs. <?= $res->packege_sale_price ?></span><span class="text-3 pr-2">-</span><span class="text-3">Rs. <?= $res->packege_price ?></span>
									<?php } ?>
									<!--p class="reviews mb-2">
										<span class="reviews-score px-2 py-1 rounded font-weight-600 text-light text-2">8.2</span><a class="text-1 text-black-50" href="#">(245 reviews)</a>
									</p -->
									
								</div>
							</div>
						</div>
					</div>
					
					<!-- modal for plan details -->
					<div id="package-details-<?= $res->Package_id.$res->store_id ?>" class="modal fade" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title"><?= $res->Package_name ?></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
								</div>
								<div class="modal-body">
									<h5>Description</h5>
									<?= $res->packege_description ?>
								
								<?php if($res->packege_includes != NULL){ ?>
									<h5 class="mt-2">includes</h5>
									<?= $res->packege_includes ?>
								<?php } ?>
								
								<?php if($res->packege_includes != NULL){ ?>
									<h5 class="mt-2">excludes</h5>
									<?= $res->packege_excludes ?>
								<?php } ?>
									
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
			<a onclick="$('#service-tab').click(); var elmnt = document.getElementById('top'); elmnt.scrollIntoView();" class="view-more">View More -></a>
		</div>
    </section>
	<?php } ?>