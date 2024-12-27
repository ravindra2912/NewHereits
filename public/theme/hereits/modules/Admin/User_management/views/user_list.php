<style>
 th{
	 text-align: -webkit-center;
 }
</style>
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
	
<section class="content">
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
            <h3 class="card-title">User Management</h3>               
            </div>
				<div class="row" style="padding: 12px 21px 12px 23px">
					<div class="col-10" style="text-align: end;"></div>
						<div class="col-2" style="text-align: end;">
							<div id="example1_filter" class="dataTables_filter">
								<input type="search" name="search" id="search" class="form-control form-control-sm" placeholder="Search" aria-controls="example1">
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
							  <th style="text-align: center;"> ID </th>
							  <th style="text-align: center;"> Username </th>
							  <th style="text-align: center;"> Email </th>
							  <th style="text-align: center;"> Gender </th>
							  <th style="text-align: center;"> Contact </th>
							  <th style="text-align: center;"> Actions </th>
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
		var search = $('#search').val();
		
		$.ajax({
				url:'<?php echo base_url(); ?>User_management/get_user_data/'+pagno,
				//method:"POST", 
				type: 'POST',
				data:{ search:search},
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