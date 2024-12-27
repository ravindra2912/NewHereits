
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">User Referal Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_management">Home</a></li>
              <li class="breadcrumb-item active">User Referal Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
	
    <!-- /.content-header -->
	<style>

.order_detail{
	margin: 0;
	display: flex;
	align-items: center;
	padding: 5px 0;
}


.order_detail .key{
	font-weight: 900;
	width: 24%;
}
.order_detail .lable{
	width: 3%;
	font-weight: 501;
}
.order_detail .value{

	width: 65%;
	font-size: 14px;
	color: #000;
	font-family: "Roboto", sans-serif;
	font-weight: 501;
}

.order_detail .order-number-text {
	padding-left: 10px;
    width: unset;
    display: inline-block;
    background: #d3d3d3;
    padding: 3px 8px;
}
.card-body{
	padding:0rem;
}



</style>

<section class="content">
	<div class="row">
		<div class="col-12">
			<div class="card card-primary" style="padding: 0rem;">
				<div class="card-header">
					<h3 class="card-title">Referal Details</h3>
				</div>
				<div class="row" style="padding:23px 10px 20px 11px;">
					<div class="col-md-4 col-4">
						<div class="order_detail">
							<span class="key">User id</span>
							<span class="lable"> : </span>
							<span class="value "><a href="<?php echo base_url(); ?>User_management/edit_user/<?= $user_data->user_id; ?>"><?= $user_data->user_id; ?>&nbsp;<i class="fas fa-arrow-circle-right"></i></a></span>
						</div>
						<div class="order_detail">
							<span class="key">Name</span>
							<span class="lable"> : </span>
							<span class="value"> <?= $user_data->frist_name." ".$user_data->last_name; ?> </span>
						</div>
						
						<div class="order_detail">
							<span class="key">Username </span>
							<span class="lable"> : </span>
							<span class="value"><?=$user_data->username; ?></span>
						</div>
					</div>	
					<div class="col-md-4 col-4">	
						<div class="order_detail">
							<span class="key">Contact </span>
							<span class="lable"> : </span>
							<span class="value"><?= $user_data->contact; ?></span>
						</div>
						
						<div class="order_detail">
							<span class="key">Email</span>
							<span class="lable"> : </span>
							<span class="value"> <?= $user_data->email; ?> </span>
						</div>
						
						<div class="order_detail">
							<span class="key">Referal Code</span>
							<span class="lable"> : </span>
							<span class="value"> <?= $user_data->user_referal ?> </span>
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
            <div class="small-box bg-success">
              <div class="inner">
               <h3 id="referral_cunt"><sup style="font-size: 20px"></sup></h3>
				<p>Total Referred</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url(); ?>Booking_management/index?store_id=<?php echo $store_data->store_id; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3 id="pending_payments"><sup style="font-size: 20px"></sup></h3>
                <p>Pending Payments</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo base_url(); ?>Report_management/index?store_id=<?php echo $store_data->store_id; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
		  <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3 id="complt_payment"></h3>
                <p>Payment Completed</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="<?php echo base_url(); ?>Report_management/index?id=<?php echo $store_data->store_id; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div>
    </section>

<section class="content m-hide">
	<div class="row">
		<div class="col-6">
			<div class="card">
			<div class="card-header">
						<h3 class="card-title">Pending Payments</h3>
					</div>
				<div class="card-body">
					<table id="referal_table" class="table table-bordered table-striped">
						<thead>
							<tr>
							  <th style="text-align: center;"> Store Name </th>
							  <th style="text-align: center;"> Date </th>
							  <th style="text-align: center;"> Store Status </th>
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
		
		<div class="col-6">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Completed Payments</h3>
					</div>
						<div class="card-body">
							
						<table id="Packages_table" class="table table-bordered table-striped">
							<thead>
								<tr>
								  <th style="text-align: center;"> Store Name </th>
								  <th style="text-align: center;"> Date </th>
								  <th style="text-align: center;"> Store Status </th>
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
</section>	




<script>
	

	<!--for product and package -->
     $('#pagination2').on('click','a',function(e){
       e.preventDefault(); 
       var pageno2 = $(this).attr('data-ci-pagination-page');
       get_data_product(pageno2);
     });
	 get_pending_payments(0);
	 function get_pending_payments(pagno2){
		var user_referal = "<?= $user_data->user_referal?>";
		$.ajax({
				url:'<?php echo base_url(); ?>Referral_management/get_pending_payments/'+pagno2,
				//method:"POST", 
				type: 'POST',
				data:{user_referal:user_referal}, 
				dataType: 'json',
				success:function(response)
				{  
					//alert(response); 
					$('#pagination2').html(response.pagination2);
					$('#referal_table tbody').html(response.table2);
					$('#referral_cunt').html(response.allcountreferal);
					$('#pending_payments').html(response.pending_payments);	
					
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					console.log(e);
				} 
			});
	}
		
	$('#pagination3').on('click','a',function(e){
       e.preventDefault(); 
       var pageno3 = $(this).attr('data-ci-pagination-page');
       get_completed_Pymts(pageno3);
     });
	 get_completed_Pymts(0);
	 function get_completed_Pymts(pagno3){
		var datepicker = $('#datepicker').val();
		var enddatepicker = $('#enddatepicker').val();
		//alert(pagno);
		var user_id = <?= $user_data->user_id; ?>;
		$.ajax({
				url:'<?php echo base_url(); ?>Referral_management/get_completed_Pymts/'+pagno3,
				//method:"POST", 
				type: 'POST',
				data:{user_id:user_id}, 
				dataType: 'json',
				success:function(response)
				{  
					//alert(response); 
					$('#pagination3').html(response.pagination3);
					$('#Packages_table tbody').html(response.table3);
					$('#complt_payment').html(response.complt_payment);
					console.log(response);
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					console.log(e);
				} 
			});
	}
	
function update_status(store_id)
{
	$.ajax({
		url:'<?php echo base_url(); ?>Referral_management/update_status/'+store_id,
		//method:"POST", 
		type: 'POST',
		data:{}, 
		dataType: 'json',
		success:function(response)
		{  
			alertify.success("Payment Done");
			get_pending_payments(0);
			get_completed_Pymts(0);
			
		},
		error: function(e){ 
			alertify.error("Somthing Wrong");
			console.log(e);
		} 
	});

}
</script>		

		