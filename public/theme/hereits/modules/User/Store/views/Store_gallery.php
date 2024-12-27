	<div class="container mt-5 py-2">
		<?php foreach($album as $val){ ?>
        <h2 class="text-6 font-weight-500 mb-3"><?=  $val->album_name ?></h2>
        <div class="owl-carousel owl-theme" data-autoplay="true" data-loop="true" data-margin="10" data-items-xs="2" data-items-sm="3" data-items-md="4" data-items-lg="6">
			<?php foreach($val->images as $val1){ ?>
			<div class="item">
				<a href="#">
					<div class="card border-0"> <img class="card-img-top rounded" src="<?= base_url().$val1->image_url ?>" alt="gallery" style="object-fit: contain;height: 200px;">
						<div class="card-body px-0 py-1"> </div>
					</div>
				</a>
			</div>
			<?php } ?>
        </div>
		<?php } ?>
    </div>