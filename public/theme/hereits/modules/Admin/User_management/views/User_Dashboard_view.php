<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">User Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>User_management">Home</a></li>
              <li class="breadcrumb-item active">User Dashboard</li>
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
	width: 18%;
}
.order_detail .lable{
	width: 3%;
	font-weight: 501;
}
.order_detail .value{

	width: 70%;
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
					<h3 class="card-title">User Details</h3>
				</div>
				<div class="row" style="padding:23px 10px 20px 11px;">
									
				<div class="col-md-3 col-3">
						<div class="card-body" style="display: block;">
							<div class="order_detail" style="justify-content: center;">
								<img src="<?php echo base_url().$user_data->user_image; ?>" height="200" width="200" />
							</div>
							<div class="order_detail" style="justify-content: center;">
							<a href="<?php echo base_url(); ?>User_management/user_full_details/<?php echo $user_data->user_id; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>
				</div>
				<div class="col-md-4 col-4">
							<div class="order_detail">
								<span class="key">User id</span>
								<span class="lable"> : </span>
								<span class="value order-number-text"> <?= $user_data->user_id; ?> </span>
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
							
							<!-- for store-->
							<?php if($user_data->user_id ==  $user_data->store_owner_id) { ?>
							<div class="card-header">
								<h3 class="card-title" style="margin-top: 13px;">Store Details</h3>
							</div>
							<div class="order_detail"  style="margin-top: 5px;">
								<span class="key">Store id</span>
								<span class="lable"> : </span>
								<span class="value "><a href="<?php echo base_url(); ?>Store_management/single_store/<?= $user_data->store_id; ?>"> <?= $user_data->store_id; ?>&nbsp;<i class="fas fa-arrow-circle-right"></i></a></span>
							</div>
							
							<div class="order_detail">
								<span class="key"> Store Name</span>
								<span class="lable"> : </span>
								<span class="value"> <?= $user_data->Store_name; ?> </span>
							</div>
														
							<?php }?>
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
								<span class="key">Gender</span>
								<span class="lable"> : </span>
								<span class="value"> <?php if($user_data->gender == 1){ echo "Male";} else if($user_data->gender == 2){ echo "Female";} else if($user_data->gender == 3){ echo "Other";} ?> </span>
							</div>
							
							<!-- for store-->
							<?php if($user_data->user_id ==  $user_data->store_owner_id) { ?>
							<div class="card-header" style="margin-top: 39px;">
								<h3 class="card-title" ></h3>
							</div>
							<div class="order_detail"  style="margin-top: 5px;">
								<span class="key">Address</span>
								<span class="lable"> : </span>
								<span class="value "> <?= $user_data->store_address." ".store_address_2; ?> </span>
							</div>
												
							<div class="order_detail">
								<span class="key">Contact</span>
								<span class="lable"> : </span>
								<span class="value "> <?= $user_data->store_contact; ?> </span>
							</div>
							
							<?php }?>
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
                <h3><?php echo $ordercount;?></h3>
                <p>Order Details</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo base_url(); ?>Order_management/index?id=<?php echo $user_data->user_id; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $booking_count ?><sup style="font-size: 20px"></sup></h3>
                <p>Bookings Details</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url(); ?>Booking_management/index?id=<?php echo $user_data->user_id; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $report_count ?></h3>
                <p>Reports by User </p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo base_url(); ?>Report_management/index?id=<?php echo $user_data->user_id; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
		  <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3></h3>
                <p>Reports on User</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="<?php echo base_url(); ?>User_management/reports_on_user/<?php echo $user_data->user_id; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>