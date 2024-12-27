<div class="content-header m-hide">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Order</h1>
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

<!-- filter -->
<section class="content">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Order Listing</h3>
					</div>
				<div class="row" style="padding: 21px 21px 0px 23px;">
					<div class="col-md-6 col-6">
						<div class="dataTables_length" id="example1_length">
							<label>Status : </label>
							<label>
								<select onchange="get_data(0)" name="status" id="status" class="custom-select custom-select-sm form-control form-control-sm">
									<option value="">All</option>
									<option value="0">Pending For Approvel</option>
									<option value="1">Accept By Store</option>
									<option value="2">Reject By Store</option>
									<option value="3">Reject By Customer</option>
									<option value="4">Shipped</option>
									<option value="5">Return</option>
									<option value="6">Order completed</option>
									<option value="7">Cancel by Customer</option>
									<option value="8">Cancel By Store</option>
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

<!--Big Screen -->
<section class="content m-hide">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<table id="Product_table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="text-center">Order Id</th>
								<th class="text-center">Order Date</th>
								<th class="text-center">Username</th>
								<th class="text-center">User Contact</th>
								<th class="text-center">Delivery Type</th>
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

<!--Mobile Screen -->
<section class="content m-show">
    <div class="container-fluid">
		<div class="card" style="background-color: transparent;"> 
			<div class="row" id="grid_view">
				
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
				url:'<?php echo base_url(); ?>Store_Order/get_online_order_data/'+pagno,
				//method:"POST", 
				type: 'POST',
				data:{ search:search, status:status }, 
				dataType: 'json',
				success:function(response)
				{  
					//alert(response); 
					$('#Product_table tbody').html(response.table_view);
					$('#grid_view').html(response.grid_view);
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

	