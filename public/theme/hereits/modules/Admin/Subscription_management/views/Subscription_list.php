<div class="content-header m-hide">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Subscription</h1>
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

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Subscription Listing</h3>
					<a href="<?php echo base_url(); ?>Subscription_management/insert_form" class="btn btn-md btn-success" style="float: right;"><i class="fas fa-plus" style="font-size: 15px;"></i></a>
				</div>
				<div class="row" style="padding: 21px 21px 0px 23px;">
					<div class="col-md-6 col-6">
						<div class="dataTables_length" id="example1_length">
							<label>Status : </label>
							<label>
								<select onchange="get_data(0)" name="status" id="status" class="custom-select custom-select-sm form-control form-control-sm">
									<option value="">All</option>
									<option value="1">Active</option>
									<option value="0">In-Active</option>
								</select>
							</label>
						</div>
					</div>
					<div class="col-md-6 col-6" style="text-align: end;">
						<div id="example1_filter" class="dataTables_filter">
							<label>
								<input type="search" name="search" id="search" class="form-control form-control-sm" placeholder="Search" aria-controls="example1">
							</label>
						</div>
					</div>
				</div>
				
			</div>
        </div>
	</div>
</section>



<!-- big screen -->
<section class="content">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<table id="Product_table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="text-center">name</th>
								<th class="text-center">type</th>
								<th class="text-center">Product or package Limit</th>
								<th class="text-center">Chat</th>
								<th class="text-center">Feature Store</th>
								<th class="text-center">Feature Product or package</th>
								<th class="text-center">Verify Batch</th>
								<th class="text-center">Stories</th>
								<th class="text-center">Support</th>
								<th class="text-center">Order</th>
								<th class="text-center">Status</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>	
						</tbody>
					</table>
				</div>
			</div>
        </div>
	</div>
</section>

<!-- pagination -->
<section class="content">
    <div class="container-fluid">
		<div class="card" style="background-color: transparent;"> 
			<div class="row" >
				<div class="col-12" style="box-shadow: 2px 2px 20px rgba(107, 128, 168, 0.6); background-color: white; margin-top: -20px;">
					<div id="pagination" class="pagination">
					</div>
				</div>
			</div>
        </div>
	</div>
</section>



<script>
	
	function change_order(order, subscription_id){
		$.ajax({
			url:'<?php echo base_url(); ?>Subscription_management/change_order',
			method:"POST", 
			data:{ order:order, subscription_id:subscription_id },
			success:function(data)
			{  
				get_data(0)
			},
			error: function(e){ 
				alertify.error("Somthing Wrong");
			} 
		});
	}

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
	
	get_data(0);
	//Get Table Data
	function get_data(pagno){
		//alert(pagno);
		var search = $('#search').val();
		var status = $('#status').val();
		$.ajax({
				url:'<?php echo base_url(); ?>Subscription_management/get_package_data/'+pagno,
				//method:"POST", 
				type: 'POST',
				data:{ search:search, status:status }, 
				dataType: 'json',
				success:function(response)
				{  
					//alert(response); 
					
					$('#Product_table tbody').html(response.table_view);
					$('#coupon_grid').html(response.grid_view);
					$('.pagination').html(response.pagination);
					//createTable(response.result,response.row);
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
				} 
			});
	}	

	
	//delete Service Parent Category
	function delete_coupon(coupon_id){
		var result = confirm("Want to delete?");
		if (result) { 

			$.ajax({
				url:'<?php echo base_url(); ?>Store_Coupons/delete_coupon',
				method:"POST", 
				data:{ coupon_id:coupon_id },
				success:function(data)
				{  
					alertify.success("Delete Successfully");
					$('#tr-'+coupon_id).remove();
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
				} 
			});
		}
	}
</script>	

	