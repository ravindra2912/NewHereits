<div id="content">
    <div class="container mt-5 mb-5">
		<div class="bg-white shadow-md rounded p-4">
			<h2 class="text-center my-5">Frequently Asked Questions</h2>
		
		
			<div class="row mb-3">
				<div class="col-md-12">
					<h4 class="mb-4">General</h4>
					<div class="accordion" id="accordionDefault">
					<?php foreach($Faqs as $faq){ 
						if($faq->category == 3){
					?>
						<div class="card">
							<h6 class="mb-0"><?= $faq->question ?></h6>
								<p class="card-body"> <?= $faq->answer ?> </p>
						</div>
					<?php } } ?>  
					</div>
				</div>
			</div>
			
			<div class="row mb-3">
				<div class="col-md-12">
					<h4 class="mb-4">Services</h4>
					<div class="accordion" id="accordionDefault">
					<?php foreach($Faqs as $faq){ 
						if($faq->category == 2){
					?>
						<div class="card">
							<h6 class="mb-0"><?= $faq->question ?></h6>
							<p class="card-body"> <?= $faq->answer ?> </p>
						</div>
					<?php } } ?>  
					</div>
				</div>
			</div>
			
			<div class="row mb-3">
				<div class="col-md-12">
					<h4 class="mb-4">Product</h4>
					<div class="accordion" id="accordionDefault">
					<?php foreach($Faqs as $faq){ 
						if($faq->category == 1){
					?>
						<div class="card">
							<h6 class="mb-0"><?= $faq->question ?></h6>
							<p class="card-body"> <?= $faq->answer ?> </p>
						</div>
					<?php } } ?>  
					</div>
				</div>
			</div>
			
			<div class="row mb-3">
				<div class="col-md-12">
					<h4 class="mb-4">Order</h4>
					<div class="accordion" id="accordionDefault">
					<?php foreach($Faqs as $faq){ 
						if($faq->category == 4){
					?>
						<div class="card">
							<h6 class="mb-0"><?= $faq->question ?></h6>
							<p class="card-body"> <?= $faq->answer ?> </p>
						</div>
					<?php } } ?>  
					</div>
				</div>
			</div>
			
			<div class="row mb-3">
				<div class="col-md-12">
					<h4 class="mb-4">Delivery</h4>
					<div class="accordion" id="accordionDefault">
					<?php foreach($Faqs as $faq){ 
						if($faq->category == 5){
					?>
						<div class="card">
							<h6 class="mb-0"><?= $faq->question ?></h6>
							<p class="card-body"> <?= $faq->answer ?> </p>
						</div>
					<?php } } ?>  
					</div>
				</div>
			</div>
			
			
        
		</div>
	</div>
</div>
