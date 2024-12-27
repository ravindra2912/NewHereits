<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $main_content; ?></li>
            </ol>
          </div>
        </div>
      </div>
</section>

<!-- filter -->
<section class="content">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Booking List</h3>
					</div>
				<div class="row" style="padding: 21px 21px 20px 23px;">
					<div class="col-md-3 col-4">
						<div class="dataTables_length" id="example1_length">
							<label>Status : </label>
								<select onchange="get_data(0)" name="status" id="status" class="custom-select custom-select-sm form-control form-control-sm">
									<option value="">All</option>
									<option value="0">Pending For Approval</option>
									<option value="1">Accept By Store</option>
									<option value="2">Reject By Store</option>
									<option value="3">Reject By User</option>
									<option value="4">Shipped</option>
									<option value="5">Return</option>
									<option value="6">Order completed</option>
									<option value="7">Cancel by Customer</option>
									<option value="8">Cancel By Store</option>
								</select>
						</div>
					</div>
					<div class="col-md-3 col-4">
						<div class="dataTables_length" id="example2_length">
							<label>By User : </label>
							<select  name="is_user" onchange="get_data(0)" id="is_user" style="font-size: 124%" class="custom-select custom-select-sm form-control form-control-sm">
									<option value="">All</option>
										<?php
													foreach($is_user as $row) { ?>
												
													 <option value="<?= $row->user_id ?>" <?php if($row->user_id == $getuserid){ echo 'selected';} ?> > <?= $row->username ?></option>;
											<?php	}
											?>
								</select>
							
						</div>
					</div>
					
					<div class="col-md-3 col-4" >
						<div class="dataTables_length" id="example2_length">
								<label>By Store : </label>
								<select  name="is_store" onchange="get_data(0)" id="is_store" style="font-size: 124%" class="custom-select custom-select-sm form-control form-control-sm">
										<option value="">All</option>
											<?php
														foreach($is_store as $row) { ?>
													
														 <option value="<?= $row->store_id ?>" <?php if($row->store_id == $getstoreid){ echo 'selected';} ?> > <?= $row->Store_name ?></option>;
												<?php	}
												?>
									</select>
						</div>
					</div>
					
					<div class="col-md-3 col-4" style="text-align: end;">
						<div id="example1_filter" class="dataTables_filter">
						<label>&nbsp; </label>
							<input type="search" name="search" id="search" value="<?php $getbooking ?>" class="form-control form-control-sm" placeholder="Search" aria-controls="example1">
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
								<th class="text-center">Booking Id</th>
								<th class="text-center">Store </th>
								<th class="text-center">User Name</th>
								<th class="text-center">User Contact</th>
								<th class="text-center">Service Type</th>
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
		var is_user = $('#is_user').val();
		var is_store = $('#is_store').val();
		$.ajax({
				url:'<?php echo base_url(); ?>Booking_management/get_booking_data/'+pagno,
				//method:"POST", 
				type: 'POST',
				data:{ search:search, status:status, is_user:is_user, is_store:is_store }, 
				dataType: 'json',
				success:function(response)
				{  
					//alert(response); 
					$('#Product_table tbody').html(response.table_view);
					$('.pagination').html(response.pagination);
					//createTable(response.result,response.row);
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
				} 
			});
	}	

	
	
</script>	

	