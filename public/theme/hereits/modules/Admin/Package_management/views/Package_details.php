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

<style>
.Package_details{
	margin: 0;
	display: flex;
	align-items: center;
	padding: 5px 0;
}
.Package_details .key{
	width: 30%;
}
.Package_details .lable{
	width: 5%;
	font-weight: 501;
}
.Package_details .value{
	white-space: nowrap; 
    overflow: hidden;
	text-overflow: ellipsis;
	width: 50%;
	font-size: 14px;
	color: #000;
	font-family: "Roboto", sans-serif;
	font-weight: 501;
}
.Package_details .value:hover {
  overflow: visible;

}
.Package_details .order-number-text {
    width: unset;
    display: inline-block;
    background: #d3d3d3;
    padding: 3px 8px;
}




</style>

<section class="content">
	<div class="row">
		<div class="col-12">
			<div class="card card-primary" style="padding: 0rem;">
				<div class="card-header">
					<h3 class="card-title">Packege Details</h3>
				</div>
				<div class="row" style="padding:23px 10px 20px 11px;">
					
					<div class="col-md-3 col-3" style="text-align-last: center;">
						<div class="Package_details" style="justify-content: center;">
							<img src="<?php echo base_url().$Package_details->packege_image; ?>" height="170px"  /> 
						</div>
						<a href="<?php echo base_url(); ?>Package_management/Package_update/<?php echo $Package_details->Package_id; ?>" class="small-box-footer">Edit <i class="fas fa-arrow-circle-right"></i></a>
					</div>
					<div class="col-md-4 col-4" >
						<input type="text" value="<?= $Package_details->Package_id ?>" name="Package_id" id="Package_id" hidden>
						<div class="Package_details">
							<span class="key">Packege Id</span>
							<span class="lable"> : </span>
							<span class="value order-number-text"> <?= $Package_details->Package_id ?> </span>
						</div>
						
						<div class="Package_details">
							<span class="key">Packege Name</span>
							<span class="lable"> : </span>
							<span class="value"> <?= $Package_details->Package_name ?> </span>
						</div>
						<div class="Package_details">
							<span class="key">Packege Tag</span>
							<span class="lable"> : </span>
							<span class="value"> <?= $Package_details->packege_tage ?> </span>
						</div>
						
						<?php if($Package_details->request_store_id != 0) {?>
						<div class="card-header">
							<h3 class="card-title">Store Details</h3>
						</div>
							<div class="Package_details">
								<span class="key">Store Id</span>
								<span class="lable"> : </span>
								<a href="<?php echo base_url(); ?>Store_management/single_store/<?= $store->store_id ?>"class="value order-number-text"><?= $store->store_id ?><i class="fas fa-arrow-circle-right"></i></a>
							</div>
							<div class="Package_details">
								<span class="key">Store Name </span>
								<span class="lable"> : </span>
								<span class="value "> <?= $store->Store_name ?> </span>
							</div>
						<?php } ?>
					</div>
				
					<div class="col-md-4 col-4">
						<div class="Package_details">
							<span class="key">Packege Sale price </span>
							<span class="lable"> : </span>
						<span class="value"><?= $Package_details->packege_sale_price?></span>
						</div>
						<div class="Package_details">
							<span class="key">Packege Price </span>
							<span class="lable"> : </span>
							<span class="value"><?= $Package_details->packege_price?></span>
						</div>
						<div class="Package_details">
							<span class="key">Packege Status</span>
							<span class="lable"> : </span>
							<span class="value">
										<select  onchange="Change_Package_status(<?= $Package_details->Package_id ?>)" name="packege_status" id="packege_status" class="custom-select custom-select-sm form-control form-control-sm" style="width:50%;">
										  <option value="">Select Status</option>
										  <option <?php if($Package_details->packege_status == 0){ echo 'selected';} ?> value="0">PENDING FOR APPROVEL</option>
										  <option <?php if($Package_details->packege_status == 1){ echo 'selected';} ?> value="1">Active</option>
										  <option <?php if($Package_details->packege_status == 2){ echo 'selected';} ?> value="2">De-active</option>
										  <option <?php if($Package_details->packege_status == 3){ echo 'selected';} ?> value="2">Delete</option>
										  </select>
							</span>
						</div>
						<?php if($Package_details->request_store_id != 0) {?>
						<div class="card-header">
							<h3 class="card-title">&nbsp;</h3>
						</div>
						<div class="Package_details">
								<span class="key">Store Contact </span>
								<span class="lable"> : </span>
								<span class="value"> <?= $store->store_contact ?> </span>
							</div>
							
							<div class="Package_details">
								<span class="key">Store Address </span>
								<span class="lable"> : </span>
								<span class="value"> <?= $store->city.'-'.$store->pincode.' ,'.$store->state ?> </span>
							</div>
						<?php } ?>
					</div>
					
					<div class="col-md-1 col-1" style="text-align: -webkit-center;">
						<a onclick="conform_delete(<?= $Package_details->Package_id ?>)"  href="#" style="color: red;" ><i class="far fa-trash-alt" style="font-size: 20px;"></i></a>
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
                <h3 id="usercount"><?=$fav_count ?><sup style="font-size: 20px"></sup> </h3>
                <p>Favourites</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url(); ?>Fav_item_management/index?item_id=<?php echo $get_item->item_id; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3 id="storecount"><?= $report_count?><sup style="font-size: 20px"></sup></h3>
                <p>Total Reports</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo base_url(); ?>Report_management/index?item_id=<?php echo $get_item->item_id; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
		  
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3 id="orders_count"><?= $orders_count?><sup style="font-size: 20px"></sup></h3>
                <p>Total Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        
		</div>
		 <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3 id="allcountstore"><?= $allcountstore ?><sup style="font-size: 20px"></sup></h3>
                <p>Store Displays Products</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
</section>

<!--For Orders -->
<section class="content m-hide">
	<div class="row">
		<div class="col-6">
			<div class="card">
				<div class="card-body">
				<div class="card-header">
					<h3 class="card-title">Orders Details for this Packege</h3>
				</div>
					<table id="order_table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="text-center">Order Id</th>
								<th class="text-center">Order Date</th>
								<th class="text-center">Username</th>
								<th class="text-center">User Contact</th>
								<th class="text-center">Store Name</th>
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
		</div>	
			
			<!-- For store details-->
		<div class="col-6">	
			<div class="card">
				<div class="card-body">
				<div class="card-header">
					<h3 class="card-title">Store's Displays This Products</h3>
				</div>
					<table id="store_table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="text-center">Store Id</th>
								<th class="text-center">Name</th>
								<th class="text-center">Contact </th>
								<th class="text-center">Email</th>
								<th class="text-center">City / pincode</th>
								<th class="text-center">State</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>	
						</tbody>
					</table>
				</div>
			</div>
				<!-- pagination -->
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
	</div>
</section>


<script>

function conform_delete(Package_id){
	
	var result = confirm("Want to delete?");
	if (result) { 

		$.ajax({
			url:'<?php echo base_url(); ?>Package_management/Package_delete',
			method:"POST", 
			data:{ Package_id:Package_id },
			success:function(data)
				{  
					window.location = "<?php echo base_url();?>Package_management";
					alertify.success("Delete Successfully");
					$('#tr-'+product_id).remove();
					
				},
			error: function(e){ 
				alertify.error("Somthing Wrong");
				console.log(e);
			} 
		});
	}
}
	
	function Change_Package_status(Package_id){
		var packege_status = $('#packege_status').val();
		var result = confirm("Want to Change?");
		
		if (result) { 

			$.ajax({
				url:'<?= base_url() ?>Package_management/Change_Package_status',
				method:"POST", 
				data:{ packege_status:packege_status, Package_id:Package_id },
				success:function(data)
				{  
					alertify.success("Packege Status Upadted Successfully");
					location.reload(); 
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					console.log(e);
				} 
			});
		}
	}
</script>	
<script>
	
// for Orders details

	// Detect pagination click
     $('#pagination').on('click','a',function(e){
       e.preventDefault(); 
       var pageno = $(this).attr('data-ci-pagination-page');
       get_data(pageno);
     });  
	 
	get_data(0);
	//Get Table Data
	function get_data(pagno){
		var Package_id = <?= $Package_details->Package_id ?>;
		//alert(pagno);
		
		$.ajax({
				url:'<?php echo base_url(); ?>Package_management/get_order_data/'+pagno,
				//method:"POST", 
				type: 'POST',
				data:{ Package_id:Package_id}, 
				dataType: 'json',
				success:function(response)
				{  
					//alert(response); 
					$('#order_table tbody').html(response.table_view);
					$('.pagination').html(response.pagination);
					$('#orders_count').html(response.orders_count);
					//createTable(response.result,response.row);
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					console.log(e);
				} 
			});
	}	

	//*************** For Store details****************************
	
	$('#pagination2').on('click','a',function(e){
       e.preventDefault(); 
       var pageno2 = $(this).attr('data-ci-pagination-page');
       get_store_data(pageno2);
    });
	get_store_data(0);
	function get_store_data(pagno2){
		var Package_id = <?= $Package_details->Package_id ?>;
		//alert(pagno);
		
		$.ajax({
				url:'<?php echo base_url(); ?>Package_management/get_store_data/'+pagno2,
				//method:"POST", 
				type: 'POST',
				data:{ Package_id:Package_id}, 
				dataType: 'json',
				success:function(response)
				{  
					//alert(response); 
					$('#store_table tbody').html(response.table_view2);
					$('.pagination2').html(response.pagination2);
					$('#allcountstore').html(response.allcountstore);
					//createTable(response.result,response.row);
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					console.log(e);
				} 
			});
	}	
</script>

