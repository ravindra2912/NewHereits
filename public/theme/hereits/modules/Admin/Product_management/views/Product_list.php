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
					<h3 class="card-title">Proudct Listing</h3>
					<a href="<?php echo base_url(); ?>Product_management/Product_insert" class="btn btn-md btn-success" style="float: right;"><i class="fas fa-plus" style="font-size: 15px;"></i></a>
					</div>
				<div class="row" style="padding: 21px 21px 20px 23px;">
					<div class="col-md-3 col-4">
						<div class="dataTables_length" id="example1_length">
							<label>Status : </label>
						
								<select onchange="get_data(0)" name="status" id="status" class="custom-select custom-select-sm form-control form-control-sm">
									<option value="">All</option>
									<option value="0">PENDING FOR APPROVEL</option>
									<option value="1">ACTIVE</option>
									<option value="2">PAUSE</option>
								</select>
							
						</div>
					</div>
					<div class="col-md-3 col-4" >
					
					</div>
					<div class="col-md-3 col-4">
						
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
								<th class="text-center">Product Id</th>
								<th class="text-center">Product Name</th>
								<th class="text-center">Product Price</th>
								<th class="text-center">Product Sale-price</th>
								<th class="text-center">Product Status</th>
								<th class="text-center">Upload by </th>
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
		var is_store = $('#is_store').val();
		var is_user = $('#is_user').val();
		$.ajax({
				url:'<?php echo base_url(); ?>Product_management/get_Product_data/'+pagno,
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
					console.log(e);
				} 
			});
	}	

	
	
</script>	

	