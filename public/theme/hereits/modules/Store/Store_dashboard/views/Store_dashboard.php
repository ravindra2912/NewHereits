
<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Dashboard</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Dashboard</li>
				</ol>
			</div>
        </div>
    </div>
</div>
<section class="content">
      <div class="container-fluid">
		<div class="row">
		
			<!-- alert section start -->
			<div class="col-md-12" id="alert_section">
			</div>
			<!-- alert section End -->
		  
			
			<?php if($store_info->store_status == 1){ ?>
			<div class="col-md-12">
				<div class="row">
					<?php if ($subscription->type == 1 || $subscription->type == 3): ?>
					<div class="col-md-3 col-sm-6 col-6">
						<a href="<?= base_url(); ?>Store_Order" class="info-box" style="color: #343a40;">
							<span class="info-box-icon bg-info"><i class="fas fa-dolly"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Order</span>
								<span class="info-box-number"><?= $counts['order']; ?></span>
							</div>
						</a>
					</div>
					<?php endif; if ($subscription->type == 2 || $subscription->type == 3):?>
					<div class="col-md-3 col-sm-6 col-6">
						<a href="<?= base_url(); ?>Store_Booking" class="info-box" style="color: #343a40;">
							<span class="info-box-icon bg-info"><i class="far fa-calendar-alt"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">Booking</span>
								<span class="info-box-number"><?= $counts['booking']; ?></span>
							</div>
						</a>
					</div>
					<?php endif; if ($subscription->type == 1 || $subscription->type == 3):?>
					<div class="col-md-3 col-sm-6 col-6">
						<a href="<?= base_url(); ?>Store_products" class="info-box" style="color: #343a40;">
							<span class="info-box-icon bg-info"><i class="fas fa-box-open"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">Products</span>
								<span class="info-box-number"><?= $counts['product']; ?></span>
							</div>
						</a>
					</div>
					<?php endif; if ($subscription->type == 2 || $subscription->type == 3):?>
					<div class="col-md-3 col-sm-6 col-6">
						<a href="<?= base_url(); ?>Store_Packages" class="info-box" style="color: #343a40;">
							<span class="info-box-icon bg-info"><i class="fab fa-dropbox"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">Packages</span>
								<span class="info-box-number"><?= $counts['Packages']; ?></span>
							</div>
						</a>
					</div>
					<?php endif; if ($subscription->type == 1 ||$subscription->type == 2 || $subscription->type == 3): ?>
					<div class="col-md-3 col-sm-6 col-6">
						<a href="<?= base_url(); ?>Store_Coupons" class="info-box" style="color: #343a40;">
							<span class="info-box-icon bg-info"><i class="fas fa-tags"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">Coupons</span>
								<span class="info-box-number"><?= $counts['Coupons']; ?></span>
							</div>
						</a>
					</div>
					<?php endif; ?>
					<div class="col-md-3 col-sm-6 col-6">
						<a href="<?= base_url(); ?>Store_Album" class="info-box" style="color: #343a40;">
							<span class="info-box-icon bg-info"><i class="far fa-images"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">Album</span>
								<span class="info-box-number"><?= $counts['album']; ?></span>
							</div>
						</a>
					</div>
					
					<div class="col-md-3 col-sm-6 col-12">
						<a href="<?= base_url(); ?>Store_Timing" class="info-box" style="color: #343a40;">
							<span class="info-box-icon bg-info"><i class="fas fa-history"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">Working Day</span>
								<span class="info-box-number"><?= $counts['store_timing']; ?> Day</span>
							</div>
						</a>
					</div>
					
          
				</div>
			</div>
			<?php } ?>

        </div>
      </div>
    </section>
<section class="content">
	<?php if ($subscription->type == 1 || $subscription->type == 3){ ?>	
    	<div class="row">
			<div class="col-md-6 col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Orders Pending</h3>
					</div>
					<div class="card-body">
						<table id="Product_table" class="table table-bordered table-striped">
							<thead>
								<tr>
								  <th style="text-align: center;"> Customer</th>
								  <th style="text-align: center;"> Total Amount</th>
								  <th style="text-align: center;"> Status </th>
								  <th style="text-align: center;"> Actions </th>
								</tr>
							</thead>
							<tbody>	
							</tbody>
						</table>
					</div>
				</div>
			<section class="content">
				<div class="container-fluid">	
					<div class="card" style="background-color: transparent;"> 
						<div class="row" >
							<div class="col-12" style="box-shadow: 2px 2px 20px rgba(107, 128, 168, 0.6); background-color: white; margin-top: -20px;">
								<div id="pagination2" class="pagination">
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>	
        </div>
	<?php }?>
	<?php if ($subscription->type == 2 || $subscription->type == 3){ ?>	
		<!--for package-->
		<div class="col-md-6 col-12">
			<div class="card">
			<div class="card-header">
					<h3 class="card-title">Bookings Pending</h3>
					</div>
				<div class="card-body">
					<table id="Packages_table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th style="text-align: center;"> Customer</th>
								<th style="text-align: center;"> Total Amount</th>
								<th style="text-align: center;"> Status </th>
								<th style="text-align: center;"> Actions </th>
							</tr>
						</thead>
						<tbody>	
						</tbody>
					</table>
				</div>
			</div>
			<section class="content">
				<div class="container-fluid">	
					<div class="card" style="background-color: transparent;"> 
						<div class="row" >
							<div class="col-12" style="box-shadow: 2px 2px 20px rgba(107, 128, 168, 0.6); background-color: white; margin-top: -20px;">
								<div id="pagination3" class="pagination">
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>	
        </div>
		</div>
	<?php } ?>	
	</div>	
	</div>
</section>

<script>
$(document).ready(function(){
	get_store_messages();
});

	// Detect pagination click
     $('#pagination').on('click','a',function(e){
       e.preventDefault(); 
       var pageno = $(this).attr('data-ci-pagination-page');
       get_data(pageno);
     });
	 
	//Search On Text Change
	$(document).ready(function(){
		$("#search").on("input", function(){
			get_data(0)
		});
	});
	
	//get_data(0);
	//Get Table Data
	function get_data(pagno){
		//alert(pagno);
		var search = $('#search').val();
		var status = $('#status').val();
		$.ajax({
				url:'<?php echo base_url(); ?>Category_management/get_parent_category_data/'+pagno,
				//method:"POST", 
				type: 'POST',
				data:{ search:search, status:status, category_type:1 }, 
				dataType: 'json',
				success:function(response)
				{  
					//alert(response); 
					$('#pagination').html(response.pagination);
					$('#example2 tbody').html(response.result);
					//createTable(response.result,response.row);
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
				} 
			});
	}	

	//get single service parent Category Modal
	function get_store_messages(){
		$.ajax({
			url:'<?php echo base_url(); ?>Store_dashboard/get_store_messages',
			method:"POST", 
			data:{ id:'' }, 
			success:function(data)
			{  
				//alert(data); 
				console.log(data);
				$("#alert_section").html(data);
			},
			error: function(e){ 
				alertify.error("Somthing Wrong");
				console.log(e);
			} 
		});
	}	

	
	
</script>	

<script>
<!--for product and package -->
     $('#pagination2').on('click','a',function(e){
       e.preventDefault(); 
       var pageno2 = $(this).attr('data-ci-pagination-page');
       get_data_product(pageno2);
     });
	 get_data_product(0);
	 function get_data_product(pageno2){
		
		$.ajax({
				url:'<?php echo base_url(); ?>Store_dashboard/get_data_product/'+pageno2,
				//method:"POST", 
				type: 'POST',
				data:{}, 
				dataType: 'json',
				success:function(response)
				{  
					//alert(response); 
					$('#pagination2').html(response.pagination2);
					$('#Product_table tbody').html(response.table2);
					
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					console.log(e);
				} 
			});
	}
	
	<!--for product and package -->
     $('#pagination3').on('click','a',function(e){
       e.preventDefault(); 
       var pagno3 = $(this).attr('data-ci-pagination-page');
       get_data_Packages(pagno3);
     });
	 get_data_Packages(0);
	function get_data_Packages(pagno3){
		
		$.ajax({
				url:'<?php echo base_url(); ?>Store_dashboard/get_data_Packages/'+pagno3,
				//method:"POST", 
				type: 'POST',
				data:{}, 
				dataType: 'json',
				success:function(response)
				{  
					//alert(response); 
					$('#pagination3').html(response.pagination3);
					$('#Packages_table tbody').html(response.table3);
					//console.log("3");
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					console.log(e);
				}, 
		});
	}
</script>