<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
	
	<!--Filters-->
<section class="content">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Filter Range</h3>
					</div>
				<div class="row" style="padding: 21px 21px 20px 23px;">
					<div class="col-md-6 col-6">
						<div class="dataTables_length" id="example1_length">
						<label>Start Date : </label>
						<input type="date" id="datepicker" onchange="get_data(); get_data_product();" width="270">
						&nbsp; &nbsp; &nbsp; <label>End Date : </label>
						<input type="date" id="enddatepicker" onchange="get_data(); get_data_product();" width="270">
						</div>
					</div>	
					</div>
			</div>
        </div>
	</div>
</section>	
	
	<section class="content">
	   <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3 id="usercount"><?=$users_count?><sup style="font-size: 20px"></sup> </h3>
                <p>Total Users</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3 id="storecount"><?= $store_count?><sup style="font-size: 20px"></sup></h3>
                <p>Total Stores</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
		  
		   <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?= $pendingstore_count?></h3>
                <p>Pending Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="<? echo base_url();?>Dashboard/Pending_Reg_list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
		  
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>10<sup style="font-size: 20px"></sup></h3>
                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
         
		
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
	
<!--Big Screen -->
<section class="content m-hide">
	<div class="row">
		<div class="col-6">
			<div class="card">
			<div class="card-header">
					<h3 class="card-title">Stores Pending For Approval</h3>
					</div>
				<div class="card-body">
					<table id="store_table" class="table table-bordered table-striped">
						<thead>
							<tr>
							  <th style="text-align: center;"> Image </th>
							  <th style="text-align: center;"> Store Name </th>
							  <th style="text-align: center;"> Username </th>
								<th style="text-align: center;"> City </th>
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
									<div id="pagination" class="pagination">
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
        </div>

		<!-- Semi Verfied Stores-->
		
		<div class="col-6">
			<div class="card">
			<div class="card-header">
					<h3 class="card-title">Semi Approved Stores</h3>
					</div>
				<div class="card-body">
					<table id="semi_aprvd_store_table" class="table table-bordered table-striped">
						<thead>
							<tr>
							  <th style="text-align: center;"> Image </th>
							  <th style="text-align: center;"> Store Name </th>
							  <th style="text-align: center;"> Username </th>
							  <th style="text-align: center;"> City </th>
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
								<div id="pagination5" class="pagination">
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>	
        </div>


		<!-- Product  and Package-->
		<div class="col-6">
			<div class="card">
			<div class="card-header">
					<h3 class="card-title">Products Pending For Approval</h3>
					</div>
				<div class="card-body">
					<table id="Product_table" class="table table-bordered table-striped">
						<thead>
							<tr>
							  <th style="text-align: center;"> Image </th>
							  <th style="text-align: center;"> Product Name </th>
							  <th style="text-align: center;"> Request by Store </th>
							  <th style="text-align: center;"> Category</th>
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
	
		<!--for package-->
		<div class="col-6">
			<div class="card">
			<div class="card-header">
					<h3 class="card-title">Packages Pending For Approval</h3>
					</div>
				<div class="card-body">
					<table id="Packages_table" class="table table-bordered table-striped">
						<thead>
							<tr>
							  <th style="text-align: center;"> Image </th>
							  <th style="text-align: center;"> Packages Name </th>
							  <th style="text-align: center;"> Request by Store </th>
							  <th style="text-align: center;"> Category</th>
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
		
		<!--Semi verfied Users-->
		
		<div class="col-6">
			<div class="card">
			<div class="card-header">
					<h3 class="card-title">Semi Approved Users</h3>
					</div>
				<div class="card-body">
					<table id="semi_aprvd_users_table" class="table table-bordered table-striped">
						<thead>
							<tr>
							  <th style="text-align: center;"> Image </th>
							  <th style="text-align: center;"> User Name</th>
							  <th style="text-align: center;">Email</th>
							  <th style="text-align: center;"> Gender</th>
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
								<div id="pagination4" class="pagination">
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>	
        </div>
		
		
	</div>
</section>	
<script>
     $('#pagination5').on('click','a',function(e){
		 e.preventDefault(); 
       var pageno5 = $(this).attr('data-ci-pagination-page');
       get_data(pageno5);
     });
	 get_data(0);
	 function get_data(pagno5){
		var datepicker = $('#datepicker').val();
		var enddatepicker = $('#enddatepicker').val();
		//alert(pagno);
		
		$.ajax({
				url:'<?php echo base_url(); ?>Dashboard/get_semi_approved_stores/'+pagno5,
				//method:"POST", 
				type: 'POST',
				data:{datepicker:datepicker ,enddatepicker:enddatepicker}, 
				dataType: 'json',
				success:function(response)
				{  
					//console.log(response); 
					$('#pagination5').html(response.pagination5);
					$('#semi_aprvd_store_table tbody').html(response.table5);
					
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					console.log(e);
				} 
			});
	}
	
</script>

<script>
	

	// Detect pagination click
     $('#pagination').on('click','a',function(e){
       e.preventDefault(); 
       var pageno = $(this).attr('data-ci-pagination-page');
       get_data(pageno);
     });
	 get_data(0);
	 function get_data(pagno){
		var datepicker = $('#datepicker').val();
		var enddatepicker = $('#enddatepicker').val();
		//alert(pagno);
		
		$.ajax({
				url:'<?php echo base_url(); ?>Dashboard/get_store_data/'+pagno,
				//method:"POST", 
				type: 'POST',
				data:{datepicker:datepicker ,enddatepicker:enddatepicker}, 
				dataType: 'json',
				success:function(response)
				{  
					//alert(response); 
					$('#pagination').html(response.pagination);
					$('#store_table tbody').html(response.result);
					$('#usercount').html(response.users_count);
					$('#storecount').html(response.store_count);
					///createTable(response.result,response.row);
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					console.log(e);
				} 
			});
	}
	
	<!--for product and package -->
     $('#pagination2').on('click','a',function(e){
       e.preventDefault(); 
       var pageno2 = $(this).attr('data-ci-pagination-page');
       get_data_product(pageno2);
     });
	 get_data_product(0);
	 function get_data_product(pageno2){
		var datepicker = $('#datepicker').val();
		var enddatepicker = $('#enddatepicker').val();
		//alert(pagno);
		
		$.ajax({
				url:'<?php echo base_url(); ?>Dashboard/get_data_product/'+pageno2,
				//method:"POST", 
				type: 'POST',
				data:{datepicker:datepicker ,enddatepicker:enddatepicker}, 
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
		var datepicker = $('#datepicker').val();
		var enddatepicker = $('#enddatepicker').val();
		
		$.ajax({
				url:'<?php echo base_url(); ?>Dashboard/get_data_Packages/'+pagno3,
				//method:"POST", 
				type: 'POST',
				data:{datepicker:datepicker ,enddatepicker:enddatepicker}, 
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
	
 $('#pagination4').on('click','a',function(e){
		 //alert("4");
       e.preventDefault(); 
       var pageno4 = $(this).attr('data-ci-pagination-page');
       get_semi_approved_users(pageno4);
     });
	 get_semi_approved_users(0);
	 function get_semi_approved_users(pageno4){
		var datepicker = $('#datepicker').val();
		var enddatepicker = $('#enddatepicker').val();
		//alert(pagno);
		
		$.ajax({
				url:'<?php echo base_url(); ?>Dashboard/get_semi_approved_users/'+pageno4,
				//method:"POST", 
				type: 'POST',
				data:{datepicker:datepicker ,enddatepicker:enddatepicker}, 
				dataType: 'json',
				success:function(response)
				{  
					//alert(response); 
					$('#pagination4').html(response.pagination4);
					$('#semi_aprvd_users_table tbody').html(response.table4);
					//console.log(response);
					
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					console.log(e);
				} 
			});
	}


</script>
