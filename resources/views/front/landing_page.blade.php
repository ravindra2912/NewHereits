@extends('front.layouts.main', ['seo' => [
'title' => 'landing page | Hereits',
'description' => 'landing page',
'keywords' => 'landing page' ,
'image' => '' ,
'city' => '',
'state' => '',
'position' => ''
]
])
@section('content')
@section('title', 'landing page')

@push('style')

@endpush

<div id="content">
	<section class="section bg-white">
		<div class="container my-sm-5">
			<h2 class="text-9 text-center">Simple Steps to Register on HEREITS?</h2>
			<p class="lead text-center mb-5">Register in less than 5 minutes!.</p>
			<div class="row">
				<div class="col-md-3 col-6">
					<div class="featured-box style-4">
						<div class="featured-box-icon bg-light-2 text-primary shadow-sm rounded-circle"> <i class="fas fa-hand-point-up"></i> </div>
						<h3 class="text-5 font-weight-400 mb-3">Step 1</h3>
						<p class="text-3">Click on registration.</p>
					</div>
				</div>
				<div class="col-md-3 col-6">
					<div class="featured-box style-4">
						<div class="featured-box-icon bg-light-2 text-primary shadow-sm rounded-circle"> <i class="fas fa-store-alt"></i> </div>
						<h3 class="text-5 font-weight-400 mb-3">Step 2</h3>
						<p class="text-3">Fill personal and store information</p>
					</div>
				</div>
				<div class="col-md-3 col-6">
					<div class="featured-box style-4">
						<div class="featured-box-icon bg-light-2 text-primary shadow-sm rounded-circle"> <i class="far fa-file"></i> </div>
						<h3 class="text-5 font-weight-400 mb-3">Step 3</h3>
						<p class="text-3">Upload documents</p>
					</div>
				</div>
				<div class="col-md-3 col-6">
					<div class="featured-box style-4">
						<div class="featured-box-icon bg-light-2 text-primary shadow-sm rounded-circle"> <i class="far fa-check-circle"></i> </div>
						<h3 class="text-5 font-weight-400 mb-3">Step 4</h3>
						<p class="text-3">Finish verification</p>
					</div>
				</div>
			</div>
			<div class="text-center pt-5"> <a href="#" class="btn btn-outline-primary shadow-none">Register Now</a> </div>
		</div>
	</section>

	<section class="section py-2 my-sm-5">
		<h2 class="text-9 text-center mb-5">Why register on hereits</h2>
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-4 col-12">
					<div class="featured-box rounded style-3">
						<div class="featured-box-icon h-100 border-right"> <i class="fas fa-users-cog"></i> </div>
						<p class="text-muted">Manage your own store product, order, offers and other details.</p>
					</div>
				</div>
				<div class="col-sm-6 col-md-4 col-12">
					<div class="featured-box rounded style-3">
						<div class="featured-box-icon h-100 border-right"> <i class="fas fa-store"></i> </div>
						<p class="text-muted">Create offers for products/services and store to attract customers..</p>
					</div>
				</div>
				<div class="col-sm-6 col-md-4 col-12">
					<div class="featured-box rounded style-3">
						<div class="featured-box-icon h-100 border-right"> <i class="fas fa-hands"></i> </div>
						<p class="text-muted">Handle business via hereits business app.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="section bg-white shadow-md">
		<div class="container">
			<h2 class="text-9 font-weight-500 text-center mb-5">Benifits of HEREITS</h2>
			<div class="row">
				<div class="col-lg-9 mx-auto">
					<div class="row">

						<div class="col-sm-12">
							<div class="featured-box mb-5 style-3">
								<div class="featured-box-icon text-success" style="align-items: unset !important;"> <i class="far fa-check-circle"></i> </div>
								<h3>Link your offline store to online store.</h3>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="featured-box mb-5 style-3">
								<div class="featured-box-icon text-success" style="align-items: unset !important;"> <i class="far fa-check-circle"></i> </div>
								<h3>Get available 24*7 to your customer.</h3>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="featured-box mb-5 style-3">
								<div class="featured-box-icon text-success" style="align-items: unset !important;"> <i class="far fa-check-circle"></i> </div>
								<h3>Showcase your store/service and offering 24*7 to your customer.</h3>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="featured-box mb-5 style-3">
								<div class="featured-box-icon text-success" style="align-items: unset !important;"> <i class="far fa-check-circle"></i> </div>
								<h3>Save huge cost of advertising and branding.</h3>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="featured-box mb-5 style-3">
								<div class="featured-box-icon text-success" style="align-items: unset !important;"> <i class="far fa-check-circle"></i> </div>
								<h3>No Commissions.</h3>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="featured-box mb-5 style-3">
								<div class="featured-box-icon text-success" style="align-items: unset !important;"> <i class="far fa-check-circle"></i> </div>
								<h3>Manage your own store like king.</h3>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="featured-box mb-5 style-3">
								<div class="featured-box-icon text-success" style="align-items: unset !important;"> <i class="far fa-check-circle"></i> </div>
								<h3>Quick response to customer via hereits chat.</h3>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="featured-box mb-5 style-3">
								<div class="featured-box-icon text-success" style="align-items: unset !important;"> <i class="far fa-check-circle"></i> </div>
								<h3>Increase your local presence.</h3>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="featured-box mb-5 style-3">
								<div class="featured-box-icon text-success" style="align-items: unset !important;"> <i class="far fa-check-circle"></i> </div>
								<h3>get new potential customers and sustain existing customer by value addition.</h3>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="featured-box mb-5 style-3">
								<div class="featured-box-icon text-success" style="align-items: unset !important;"> <i class="far fa-check-circle"></i> </div>
								<h3>Create offer, discount.</h3>
							</div>
						</div>


					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="section py-2 my-sm-5">
		<h2 class="text-9 text-center mb-5">Comparison other to HEREITS</h2>
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-6 col-12 border-right">

					<h4 class="text-7">Other Platforms</h4>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">Heavy commission charged by marketplace.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">Delays in settlement of cash payments, leading to working capital issues.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">Most of product sale by marketplace owned company.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">Incurs more cost than traditional logistics due to returns.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">Generate fake orders and steal your money through various charges and penalty.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">Preferred supplier concept kills the basic objective of fair marketplace.</p>
					</div>


				</div>

				<div class="col-sm-6 col-md-6 col-12">

					<h4 class="text-7">HEREITS Platforms</h4>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">Zero commission charged by marketplace.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">Immediate settlement as products are delivered by store directly.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">store gets exclusive rights for their product/brand in a city.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">Logistics cost reduced as the supplier uses own manpower in most cases.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">Return will be minimized with offline presence.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">direct chat with customer.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">Provide value addition and time saving service for customers.</p>
					</div>


				</div>

				<div class="col-sm-6 col-md-6 col-12 border-right" style="margin-top: 48px;">

					<h4 class="text-7">Other Service Providing Platforms</h4>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">Huge commission.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">Spamming calls from platform to buy their paid listing and lead credits.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">You have to provide service as per their rules.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">You can not contact directly to customer.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">You can not work as per your choice.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">You can not assign your employees or team member to fulfil service.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">Provide Fake leads and steal your money.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">Irrelevant inquiries.</p>
					</div>




				</div>

				<div class="col-sm-6 col-md-6 col-12" style="margin-top: 48px;">

					<h4 class="text-7">HEREITS Service Providing Platforms</h4>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">no commission.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">we assured that you will not receive spamming calls for buying leads and credits from hereits.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">your business your rules.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">direct contact to customer via hereits chat.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">get bookings of servces.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">You can assign your team member to fulfil service booking.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">you can offer your service as per your choice.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">You can create service plan for your customer.</p>
					</div>

					<div class="featured-box rounded style-3" style="padding-left: 57px;">
						<div class="featured-box-icon text-success " style="height: 26px;font-size: 20px;"> <i class="fas fa-check"></i> </div>
						<p class="text-muted">You can give offers and discounts to your customer.</p>
					</div>






				</div>

			</div>
		</div>
	</section>

</div>

@endsection