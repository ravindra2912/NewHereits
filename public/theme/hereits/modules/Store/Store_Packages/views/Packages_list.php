<div class="content-header m-hide">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Packages</h1>
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
					<h3 class="card-title">Packages Listing</h3>
					<a href="<?php echo base_url(); ?>Store_Packages/Package_search" class="btn btn-md btn-success" style="float: right;"><i class="fas fa-plus" style="font-size: 15px;"></i> Add Packages</a>
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

<section class="content m-hide">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<label style="float: right;margin-right: 5px;font-size: 16px;" ><?=$package_count?>/<?= $package_Limit->package_Limit ?></label>
					<table id="Product_table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="text-center table_img"><i class="far fa-image" style="font-size: 25px;"></i></th>
								<th class="text-center">Package Name</th>
								<th class="text-center">Category</th>
								<th class="text-center">Price</th>
								<th class="text-center">Status</th>
								<th class="text-center">Action</th>
							</tr>
							
						</thead>
						<tbody>	
						</tbody>
					</table>
					<div style="margin-top: 10px;" id="pagination" class="pagination">
					</div>
				</div>
			</div>
        </div>
	</div>
</section>

<!-- mobile -->
<section class="content m-show">
    <div class="container-fluid">
		<div class="card">
			<div class="row" id="packege_grid">
			
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
				url:'<?php echo base_url(); ?>Store_Packages/get_packages_data/'+pagno,
				//method:"POST", 
				type: 'POST',
				data:{ search:search, status:status }, 
				dataType: 'json',
				success:function(response)
				{  
					$('#Product_table tbody').html(response.table_view);
					$('#packege_grid').html(response.grid_view);
					$('#norecord ').html(response.norecord);
					$('.pagination').html(response.pagination);
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					console.log(e);
				} 
			});
	}	

	
	//delete Service Parent Category
	function delete_package(Package_id){
		var result = confirm("Want to delete?");
		if (result) { 

			$.ajax({
				url:'<?php echo base_url(); ?>Store_Packages/delete_package',
				method:"POST", 
				data:{ Package_id:Package_id },
				success:function(data)
				{  
					alertify.success("Delete Successfully");
					$('#tr-'+Package_id).remove();
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
				} 
			});
		}
	}
</script>	

	