<div class="content-header m-hide">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Plan History</h1>
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
					<h3 class="card-title">Plan Listing</h3>
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
					<table id="plan_table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="text-center">Name</th>
								<th class="text-center">Amount</th>
								<th class="text-center">Duration</th>
								<th class="text-center">Start date</th>
								<th class="text-center">End date</th>
								<th class="text-center">status</th>
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
				url:'<?php echo base_url(); ?>Store_Plans/get_plans/'+pagno,
				//method:"POST", 
				type: 'POST',
				data:{ search:search, status:status }, 
				dataType: 'json',
				beforeSend:function(response)
				{ 
					document.getElementById("load").style.visibility = "unset"; 
				},
				success:function(response)
				{  
					//alert(response); 
					document.getElementById("load").style.visibility = "unset";  // for show
					document.getElementById("load").style.visibility = "hidden";  // for hide
					$('#plan_table tbody').html(response.table_view);
					$('#grid_view').html(response.grid_view);
					$('.pagination').html(response.pagination);
					//createTable(response.result,response.row);
				},
				error: function(e){ 
					document.getElementById("load").style.visibility = "unset";  // for show
					document.getElementById("load").style.visibility = "hidden";  // for hide
					document.getElementById("load").style.visibility = "hidden";  // for hide
					alertify.error("Somthing Wrong");
					console.log(e);
				} 
			});
	}	
</script>	

	