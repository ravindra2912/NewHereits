<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Choose Plan</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_dashboard">Home</a></li>
					<li class="breadcrumb-item active"><?php echo $main_content; ?></li>
				</ol>
			</div>
        </div>
    </div>
</div>
<?php $plan_count = 1; ?>
<style>
	.vendor-landing-main .block {
    padding: 70px 0;
}
.block {
    float: left;
    width: 100%;
    padding: 50px 0;
    position: relative;
}
.block .container {
    padding: 0;
}
.price-list-section-main .inner-price-list {
    width: 100%;
}
.price-list-section-main .inner-price-list ul {
    display: flex;
    width: 100%;
    text-align: center;
    justify-content: center;
}
ul {
    list-style: outside none none;
    margin: 0 0 30px;
    padding: 0;
}
ul li {
    color: #1e1e1e;
    margin-bottom: 15px;
    position: relative;
}
.price-list-section-main .inner-price-list ul li a.activelink {
    background-color: #fff;
border: 5px solid #2b6be2;
border-radius: 10px;
font-size: 20px;
font-weight: 800;
color: #0171bc;
margin: 0;
text-transform: uppercase;
}
.price-list-section-main .inner-price-list ul li a {
    color: #000;
    background-color: #ddd;
    border: 1px solid #ddd;
    padding: 10px 15px;
}
.price-list-section-main .inner-price-list .content-for-price .plf {
    padding: 0 5px;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 {
    position: relative;
    background: #fff;
    min-height: 500px;
    box-shadow: 0px 5px 30px 0px rgba(38, 30, 0, 0.1);
	margin-bottom: 20px;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .header-price-list {
    box-shadow: 0px 5px 30px 0px rgba(38, 30, 0, 0.1);
    padding: 20px 15px;
    text-align: center;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .header-price-list h3 {
    font-size: 20px;
    font-weight: 800;
    color: #0171bc;
    margin: 0;
    text-transform: uppercase;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package {
    width: 90%;
    margin-left: auto;
    margin-right: auto;
    display: block;
    margin-top: 20px;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package h5 {
    margin-bottom: 10px;
    font-size: 12px;
    text-transform: uppercase;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .wrap-drop {
    padding: 10px 15px;
    background-color: #FBFBFB;
    border: 1px solid #999999;
    cursor: pointer;
    font-size: 16px;
    font-weight: 200;
    max-width: 100%;
    position: relative;
    width: 100%;
    z-index: 3;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .selected-txt {
    color: #333;
    font-size: 16px;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .selected-txt {
    color: #333;
    font-size: 16px;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .year-txt {
    color: #666;
    font-size: 14px;
    text-transform: capitalize;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .wrap-drop span {
    color: #928579;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .selected-txt .rupee {
    font-size: 20px;
    color: #0171bc;
    margin-right: 2px;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .wrap-drop .drop li a .rupee {
    font-size: 20px;
    color: #333 !important;
    margin-right: 2px;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .selected-txt .month-txt {
    color: #0171bc !important;
}
.inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .month-txt {
    font-size: 22px;
    font-weight: 700;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .wrap-drop span {
    color: #928579;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .actual-price {
    color: #767676;
    font-size: 14px;
    font-weight: 500;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .wrap-drop span {
    color: #928579;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .actual-discount {
    color: #f15922 !important;
    font-size: 13px;
    font-weight: 400;
    margin-left: 5px;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .wrap-drop .drop {
    background: #e7ded5;
    border: 1px solid #999999;
    display: none;
    left: 0;
    list-style: none;
    margin-top: 0;
    opacity: 0;
    padding-left: 0;
    pointer-events: none;
    position: absolute;
    right: 0;
    top: 100%;
    z-index: 2;
}
.price-list-section-main .inner-price-list ul {
    display: flex;
    width: 100%;
    text-align: center;
    justify-content: center;
}
ul {
    list-style: outside none none;
    margin: 0 0 30px;
        margin-top: 0px;
    padding: 0;
        padding-left: 0px;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .wrap-drop .drop li {
    border: 1px solid #f1f1f1;
    margin-bottom: 0;
}
ul li {
    color: #1e1e1e;
    margin-bottom: 15px;
    position: relative;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .wrap-drop .drop li a {
    color: #333;
    display: block;
    text-align: left;
    padding: 8px 5px;
    background: #fff;
    border: unset !important;
    text-decoration: none;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .wrap-drop .drop li .blc-clr {
    color: #333 !important;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .wrap-drop span {
    color: #928579;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .year-txt {
    color: #666;
    font-size: 14px;
    text-transform: capitalize;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .wrap-drop span {
    color: #928579;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .wrap-drop .drop li .blc-clr {
    color: #333 !important;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .wrap-drop span {
    color: #928579;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .month-txt {
    font-size: 22px;
    font-weight: 700;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .wrap-drop::after {
    content: "\f078";
    font-family: "Font Awesome 5 Free";
    height: 0;
    margin-top: -4px;
    position: absolute;
    right: 30px;
    top: 40%;
    font-size: 20px;
    color: #0171bc;
    font-weight: 600;
    width: 0;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .price-package .inner-price-package .wrap-drop.active .drop {
    display: block;
    opacity: 1;
    pointer-events: auto;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .buy-plan button {
    border: 0;
    width: 90%;
    margin-left: auto;
    margin-right: auto;
    display: block;
    margin-top: 20px;
    margin-bottom: 20px;
    padding: 12px;
    font-size: 18px;
    background: linear-gradient(131.64deg, #FF9052 0%, #FF6B17 100%);
    border-radius: 6px;
    box-shadow: none;
    transition: all ease-in-out 0.2s;
    color: #fff;
    font-weight: 800;
    text-align: center;
    text-transform: capitalize;
    font-family: 'Gotham SSm A', 'Gotham SSm B', Arial, sans-serif;
    letter-spacing: .5px;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .feature-list {
    width: 90%;
    margin-left: auto;
    margin-right: auto;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .feature-list ul {
    display: unset;
    text-align: left;
}
.price-list-section-main .inner-price-list ul {
    display: flex;
    width: 100%;
    text-align: center;
    justify-content: center;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .feature-list ul li {
    margin-bottom: 10px;
    font-size: 13px;
}
ul li {
    color: #1e1e1e;
    margin-bottom: 15px;
    position: relative;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .feature-list ul li {
    font-size: 13px;
}
ul li {
    color: #1e1e1e;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .feature-list ul li .success {
    color: #16b663;
    margin-right: 2px;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .feature-list ul li .fail {
    color: #FF6B17;
    margin-right: 2px;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .feature-list ul li span {
    font-size: 13px;
    color: #333;
}
.price-list-section-main .inner-price-list .content-for-price .price-list-1 .feature-list .more a {
    cursor: pointer;
    color: #0171bc;
    font-size: 14px;
}
.price-list-section-main .inner-price-list .content-for-price .recommenend {
    position: relative;
}
.price-list-section-main .inner-price-list .content-for-price .recommenend-content {
    position: absolute;
    top: -23px;
    width: 100%;
}
.price-list-section-main .inner-price-list .content-for-price .line-img {
    position: relative;
    text-align: center;
    border-bottom: 3px solid #f15922;
}
.price-list-section-main .inner-price-list .content-for-price .line-img img {
    margin-bottom: -17px;
}
.plan-active{
	box-shadow: 0px 5px 30px 0px rgb(46, 215, 22) !important;
	border: 1px solid green;
}
</style>



<section class="content">
      <div class="container-fluid">
        <div class="row">
			<div class="col-12">
				<a href="<?php echo base_url(); ?>Store_Plans/Plan_history" style="float: right;" class="onclick-load btn btn-success">History</a>
			</div>
			<div class="col-12">
				<!-- product -->
				<section class="block price-list-section-main">
					<div class="container">
						<div class="row">
							<div class="inner-price-list">
								<!-- ul>
									<li class="clickme"><a href="javascript:void();" data-tag="tab1" class="activelink">Product Plans</a></li>
								</ul -->
								<div class="content-for-price">
									<div class="list " id="tab1">
										<div class="row no-gutters">
										
											<?php foreach($plans as $p){ ?>
											
											
											<div class="col-lg-4 plf">
												<div class="price-list-1 <?php if($p->recommended == 1){ echo "recommenend";} if($p->subscription_id == $current_plan->subscription_id){echo'plan-active';}?> ">
													<?php 
														if($p->recommended == 1){ 
															echo '<div class="recommenend-content">
																	<div class="line-img"><img src="'.base_url().'assets/front-end/images/planrecommend.png" alt="">
																	</div>
																</div>';
														} 
													?>
													
													<div class="header-price-list">
														<h3 class="orange-txt"><?= $p->name ?></h3>
													</div>
													<div class="price-package">
														<div class="inner-price-package">
															<h5>SELECT THE TENURE</h5>
															<div class="wrap-drop" id="noble-gases<?= $plan_count ?>">
																<?php 
																		$per_month = $p->plans[0]->amount / $p->plans[0]->month;
																	?>
																	<div class="selected-txt"><span class="year-txt"><?= $p->plans[0]->month ?> Month</span> @  <span class="rupee" > <span class="rupee">&#8377;</span></span><span class="month-txt"><?php echo round($per_month-($per_month * $p->plans[0]->discount / 100)) ?>/Mo</span>
																		<div class="save-price">
																			
																			<del><span class="actual-price">&#8377;<?= round($per_month) ?></span></del>
																			<span class="actual-discount">SAVE <?= $p->plans[0]->discount ?>%</span>
																		</div>
																	</div>
																<ul class="drop">
																<?php 
																	$c = 0;
																	foreach($p->plans as $plans){ 
																		$per_month = $plans->amount / $plans->month;
																	?>
																		<li class="<?php if($c == 0){ echo 'selected';} ?>" onclick="set_form_data(<?= $p->subscription_id ?>,<?= $plans->month ?>)">
																			<a>
																				<span class="year-txt blc-clr"><?= $plans->month ?> Month</span> @  <span></span> <span class="rupee">&#8377;</span><span class="month-txt blc-clr"><?php echo round($per_month-($per_month * $plans->discount / 100)) ?>/Mo</span>
																				<div class="save-price">
																					<del><span class="actual-price"> &#8377; <?= round($per_month) ?></span></del>
																					<span class="actual-discount">SAVE <?= $plans->discount ?>%</span>
																				</div>
																			</a>
																		</li>
																	<?php $c ++; } ?>
																	
																	
																</ul>
															</div>
														</div>
													</div>
													<form action="<?php echo base_url(); ?>Store_Plans/plan_details" method="POST" enctype="multipart/form-data">
														<input type="hidden" name="subscription_id" value="<?= $p->subscription_id ?>" />
														<input type="hidden" id="month<?= $p->subscription_id ?>" name="month" value="<?= $p->plans[0]->month ?>" />
														
														<div class="buy-plan">
															<?php if($p->subscription_id == $current_plan->subscription_id){echo'<button type="button">Current Plan</button>';}else{echo '<button type="submit">Buy Now</button>';} ?>
															
														</div>
													</form>
													<div class="feature-list">
														<ul>
															<?php if($p->type == 1 || $p->type == 3){ ?>
																<li><i class="fa fa-check success"></i><span> Product Listing (<?= $p->Product_Limit ?>)</span></li>
															<?php }if($p->type == 2 || $p->type == 3){ ?>
																<li><i class="fa fa-check success"></i><span> Service Package Listing (<?= $p->package_Limit ?>)</span></li>
															<?php } ?>
															<!-- li><i class="<?php if($p->Verify_Batch == 1){ echo "fa fa-check success";}else{ echo "fas fa-times fail";} ?>"></i><span> Verify Batch</span></li -->
															<!-- li><i class="<?php if($p->Chat == 1){ echo "fa fa-check success";}else{ echo "fas fa-times fail";} ?>"></i><span> Chat </span></li -->
															<li><i class="fa fa-check success"></i><span> Support ( <?php if($p->Support == 1){ echo "Dedicated account manager";}else{ echo " Local email support";} ?> ) </span></li>
															<li><i class="<?php if($p->Data_and_reporting == 1){ echo "fa fa-check success";}else{ echo "fas fa-times fail";} ?>"></i><span> Data And Reporting </span></li>
															<li><i class="<?php if($p->ads == 1){ echo "fa fa-check success";}else{ echo "fas fa-times fail";} ?>"></i><span> Includes Ads </span></li>
														</ul> 
													</div>
												</div>
											</div> 
											<?php $plan_count ++; } ?>
											
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</section>
				<div style=""></div>
				<!-- Service -->
				<!-- section class="block price-list-section-main">
					<div class="container">
						<div class="row">
							<div class="inner-price-list">
								<ul>
									<li class="clickme"><a href="javascript:void();" data-tag="tab1" class="activelink">service Plans</a></li>
								</ul>
								<div class="content-for-price">
									<div class="list " id="tab1">
										<div class="row no-gutters">
										
											<?php foreach($service as $s){ ?>
											
											
											<div class="col-lg-3 plf">
												<div class="price-list-1 <?php if($s->recommended == 1){ echo "recommenend";} ?>">
													<?php 
														if($s->recommended == 1){ 
															echo '<div class="recommenend-content">
																	<div class="line-img"><img src="https://hereits.com/assets/front-end/images/planrecommend.png" alt="">
																	</div>
																</div>';
														} 
													?>
													
													<div class="header-price-list">
														<h3 class="orange-txt"><?= $s->name ?></h3>
													</div>
													<div class="price-package">
															<div class="inner-price-package">
																<h5>SELECT THE TENURE</h5>
																<div class="wrap-drop" id="noble-gases<?= $plan_count ?>">
																	<?php 
																		$per_month = $s->plans[0]->amount / $s->plans[0]->month;
																	?>
																	<div class="selected-txt"><span class="year-txt"><?= $s->plans[0]->month ?> Month</span> @  <span class="rupee" > <span class="rupee">&#8377;</span></span><span class="month-txt"><?php echo round($per_month-($per_month * $s->plans[0]->discount / 100)) ?>/Mo</span>
																		<div class="save-price">
																			
																			<del><span class="actual-price">&#8377;<?= round($per_month) ?></span></del>
																			<span class="actual-discount">SAVE <?= $s->plans[0]->discount ?>%</span>
																		</div>
																	</div>
																	<ul class="drop">
																	<?php 
																	$c = 0;
																	foreach($s->plans as $plans){ 
																		$per_month = $plans->amount / $plans->month;
																	?>
																		<li class="<?php if($c == 0){ echo 'selected';} ?>" onclick="set_form_data(<?= $s->subscription_id ?>,<?= $plans->month ?>)">
																			<a>
																				<span class="year-txt blc-clr"><?= $plans->month ?> Month</span> @  <span></span> <span class="rupee">&#8377;</span><span class="month-txt blc-clr"><?php echo round($per_month-($per_month * $plans->discount / 100)) ?>/Mo</span>
																				<div class="save-price">
																					<del><span class="actual-price"> &#8377; <?= round($per_month) ?></span></del>
																					<span class="actual-discount">SAVE <?= $plans->discount ?>%</span>
																				</div>
																			</a>
																		</li>
																	<?php $c ++; } ?>
																		
																		
																	</ul>
																</div>
															</div>
														</div>
													<form action="<?php echo base_url(); ?>Store_Plans/plan_details" method="POST" enctype="multipart/form-data">
														<input type="hidden" name="subscription_id" value="<?= $s->subscription_id ?>" />
														<input type="hidden" id="month<?= $s->subscription_id ?>" name="month" value="<?= $s->plans[0]->month ?>" />
														
														<div class="buy-plan">
															<button type="submit">Buy Now</button>
														</div>
													</form>
													<div class="feature-list">
														<ul>
															<li><i class="fa fa-check success"></i><span> Service Package Listing (<?= $s->package_Limit ?>)</span></li>
															<li><i class="<?php if($s->Verify_Batch == 1){ echo "fa fa-check success";}else{ echo "fas fa-times fail";} ?>"></i><span> Verify Batch</span></li>
															<li><i class="<?php if($s->Chat == 1){ echo "fa fa-check success";}else{ echo "fas fa-times fail";} ?>"></i><span> Chat </span></li>
															<li><i class="fa fa-check success"></i><span> Support ( <?php if($s->Support == 1){ echo "Dedicated account manager";}else{ echo " Local email support";} ?> ) </span></li>
															<li><i class="<?php if($s->Data_and_reporting == 1){ echo "fa fa-check success";}else{ echo "fas fa-times fail";} ?>"></i><span> Data And Reporting </span></li>
														</ul> 
													</div>
												</div>
											</div> 
											<?php $plan_count ++; } ?>
											
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</section -->
				
				<!-- both -->
				<!-- section class="block price-list-section-main">
					<div class="container">
						<div class="row">
							<div class="inner-price-list">
								<ul>
									<li class="clickme"><a href="javascript:void();" data-tag="tab1" class="activelink">Service And Product Combo Plans</a></li>
								</ul>
								<div class="content-for-price">
									<div class="list " id="tab1">
										<div class="row no-gutters">
										
											<?php foreach($both as $c){ ?>
											
											
											<div class="col-lg-3 plf">
												<div class="price-list-1 <?php if($c->recommended == 1){ echo "recommenend";} ?>">
													<?php 
														if($c->recommended == 1){ 
															echo '<div class="recommenend-content">
																	<div class="line-img"><img src="https://hereits.com/assets/front-end/images/planrecommend.png" alt="">
																	</div>
																</div>';
														} 
													?>
													
													<div class="header-price-list">
														<h3 class="orange-txt"><?= $c->name ?></h3>
													</div>
													<div class="price-package">
														<div class="inner-price-package">
															<h5>SELECT THE TENURE</h5>
															<div class="wrap-drop" id="noble-gases<?= $plan_count ?>">
																<?php 
																		$per_month = $c->plans[0]->amount / $c->plans[0]->month;
																	?>
																	<div class="selected-txt"><span class="year-txt"><?= $c->plans[0]->month ?> Month</span> @  <span class="rupee" > <span class="rupee">&#8377;</span></span><span class="month-txt"><?php echo round($per_month-($per_month * $c->plans[0]->discount / 100)) ?>/Mo</span>
																		<div class="save-price">
																			
																			<del><span class="actual-price">&#8377;<?= round($per_month) ?></span></del>
																			<span class="actual-discount">SAVE <?= $c->plans[0]->discount ?>%</span>
																		</div>
																	</div>
																<ul class="drop">
																<?php 
																	$ct = 0;
																	foreach($c->plans as $plans){ 
																		$per_month = $plans->amount / $plans->month;
																	?>
																		<li class="<?php if($ct == 0){ echo 'selected';} ?>" onclick="set_form_data(<?= $c->subscription_id ?>,<?= $plans->month ?>)">
																			<a>
																				<span class="year-txt blc-clr"><?= $plans->month ?> Month</span> @  <span></span> <span class="rupee">&#8377;</span><span class="month-txt blc-clr"><?php echo round($per_month-($per_month * $plans->discount / 100)) ?>/Mo</span>
																				<div class="save-price">
																					<del><span class="actual-price"> &#8377; <?= round($per_month) ?></span></del>
																					<span class="actual-discount">SAVE <?= $plans->discount ?>%</span>
																				</div>
																			</a>
																		</li>
																	<?php $ct ++; } ?>
																	
																	
																</ul>
															</div>
														</div>
													</div>
													<form action="<?php echo base_url(); ?>Store_Plans/plan_details" method="POST" enctype="multipart/form-data">
														<input type="hidden" name="subscription_id" value="<?= $c->subscription_id ?>" />
														<input type="hidden" id="month<?= $c->subscription_id ?>" name="month" value="<?= $c->plans[0]->month ?>" />
														
														<div class="buy-plan">
															<button type="submit">Buy Now</button>
														</div>
													</form>
													<div class="feature-list">
														<ul>
															<li><i class="fa fa-check success"></i><span> Product Listing (<?= $c->Product_Limit ?>)</span></li>
															<li><i class="fa fa-check success"></i><span> Service Package Listing (<?= $c->package_Limit ?>)</span></li>
															<li><i class="<?php if($c->Verify_Batch == 1){ echo "fa fa-check success";}else{ echo "fas fa-times fail";} ?>"></i><span> Verify Batch</span></li>
															<li><i class="<?php if($c->Chat == 1){ echo "fa fa-check success";}else{ echo "fas fa-times fail";} ?>"></i><span> Chat </span></li>
															<li><i class="fa fa-check success"></i><span> Support ( <?php if($c->Support == 1){ echo "Dedicated account manager";}else{ echo " Local email support";} ?> ) </span></li>
															<li><i class="<?php if($c->Data_and_reporting == 1){ echo "fa fa-check success";}else{ echo "fas fa-times fail";} ?>"></i><span> Data And Reporting </span></li>
														</ul> 
													</div>
												</div>
											</div> 
											<?php $plan_count ++; } ?>
											
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</section -->
				

			</div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<script>

function set_form_data(subscription_id, month){
	$('#month'+subscription_id).val(month);
}

$(document).ready(function() {
    // tabing js start
    $('.selling-register-main ul.selling-tab li a').click(function() {
        var tab_id = $(this).attr('data-tab');

        $('ul.tabs li a').removeClass('active');
        $('.selling-content .tab-content').removeClass('active');

        $(this).addClass('active');
        $("#" + tab_id).addClass('active');
    });
    // tabing js end
});


 // Price Tabing js start
  
 $('.clickme a').click(function(){
    $('.clickme a').removeClass('activelink');
    $(this).addClass('activelink');
    var tagid = $(this).data('tag');
    $('.list').removeClass('active').addClass('hide');
    $('#'+tagid).addClass('active').removeClass('hide');
});


 // Price Tabing js end

//  custom select for price list js start
function DropDown(el) {
    this.dd = el;
    this.placeholder = this.dd.children('div');
    this.opts = this.dd.find('ul.drop li');
    this.val = '';
    this.index = -1;
    this.initEvents();
}

DropDown.prototype = {
    initEvents: function () {
        var obj = this;
        obj.dd.on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).toggleClass('active');
        });
        obj.opts.on('click', function () {
            var opt = $(this);
            obj.val = opt.html();
            
            obj.index = opt.index();
            obj.placeholder.html(obj.val);
            opt.siblings().removeClass('selected');
            opt.filter(':contains("' + obj.val + '")').addClass('selected');
        }).change();
    },
    getValue: function () {
        return this.val;
    },
    getIndex: function () {
        return this.index;
    }
};

$(function () {
	for(i = 1 ;i <= <?= $plan_count ?>; i++){
		new DropDown($('#noble-gases'+i));
	}
    
    $(document).click(function () {
        // close menu on document click
        $('.wrap-drop').removeClass('active');
    });
});
//  custom select for price list js End
</script>




	