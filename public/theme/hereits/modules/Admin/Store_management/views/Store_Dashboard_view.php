
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Store Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_management">Home</a></li>
              <li class="breadcrumb-item active">Store Dashboard</li>
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
					<h3 class="card-title">Store Details</h3>
				</div>
				<div class="row" style="padding:23px 10px 20px 11px;">
									
				<div class="col-md-3 col-3">
						<div class="card-body" style="display: block;">
							<div class="order_detail" style="justify-content: center;">
								<img src="<?php echo base_url().$store_data->store_image; ?>" style="height: 140px;width: auto;object-fit: contain;" />
							</div>
							<div class="order_detail" style="justify-content: center;">
							<a href="<?php echo base_url(); ?>Store_management/edit_store/<?php echo $store_data->store_id; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
							<input type="tex" value="<?= $store_data->store_id; ?>" id="store_id" name="store_id" hidden>
							</div>
						</div>
				</div>
				<div class="col-md-4 col-4">
							<div class="card-header">
								<h3 class="card-title" style="margin-top: 5px;">Store Details :</h3>
							</div>
							<div class="order_detail" >
								<span class="key">Store id</span>
								<span class="lable"> : </span>
								<span class="value"> <?= $store_data->store_id; ?> </span>
							</div>
							
							<div class="order_detail">
								<span class="key"> Store Name</span>
								<span class="lable"> : </span>
								<span class="value"> <?= $store_data->Store_name; ?> </span>
							</div>
							<div class="order_detail">
								<span class="key"> Store E-Mail</span>
								<span class="lable"> : </span>
								<span class="value"> <?= $store_data->store_email; ?> </span>
							</div>
												
							<div class="order_detail">
								<span class="key">Address</span>
								<span class="lable"> : </span>
								<span class="value "> <?= $store_data->store_address." ".store_address_2; ?> </span>
							</div>
												
							<div class="order_detail">
								<span class="key">Contact</span>
								<span class="lable"> : </span>
								<span class="value "> <?= $store_data->store_contact; ?> </span>
							</div>							
						</div>			
						<div class="col-md-5 col-5">			
						<!-- for User-->
						
						<?php if($store_data->user_id ==  $user_data->user_id) { ?>
							<div class="card-header">
								<h3 class="card-title" style="margin-top: 5px;">Store Holder :</h3>
							</div>
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
                <h3><?php echo $order_count ?></h3>
                <p>Order Details</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo base_url(); ?>Order_management/index?store_id=<?php echo $store_data->store_id; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
              <a href="<?php echo base_url(); ?>Booking_management/index?store_id=<?php echo $store_data->store_id; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $report_count ?><sup style="font-size: 20px"></sup></h3>
                <p>Reports by User </p>
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
                <h3></h3>
                <p>Reports on User</p>
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


	<!-- Subscribtion -->
<section class="content">
	<div class="row">
		<div class="col-12">
			<div class="card card-success" style="padding: 0rem;">
			 
              <div class="card-header">
                <h3 class="card-title">Subscription</h3>
              </div>
			  
			  <?php if($store_data->store_id == $subscribe->store_id) { ?>
			    <div class="row" style="padding:23px 10px 20px 11px;">
              		<div class="col-md-4 col-4">
						<div class="order_detail">
								<span class="key">ID</span>
								<span class="lable"> : </span>
								<span class="value"> <?= $subscribe->store_subscription_id; ?> </span>
						</div>
						
						<div class="order_detail">
								<span class="key">Plan Name</span>
								<span class="lable"> : </span>
								<span class="value"> <?= $subscribe->name; ?> </span>
						</div>
						
						<div class="order_detail">
								<span class="key">Duration</span>
								<span class="lable"> : </span>
								<span class="value"> <?php echo $subscribe->duration." Months"; ?> </span>
						</div>
					</div>	
             
			 		<div class="col-md-4 col-4">
						<div class="order_detail">
								<span class="key" >Subscription Id</span>
								<span class="lable"> : </span>
								<span class="value"> <?= $subscribe->subscription_id; ?> </span>
						</div>
						
						<div class="order_detail">
								<span class="key">Plan Type</span>
								<span class="lable"> : </span>
								<span class="value"><?php if($subscribe->type == 3){ echo "Both";} else if($subscribe->type == 1){ echo "Product";} else if($subscribe->type == 2){ echo "service";} ?> </span>
						</div>
						
						<div class="order_detail">
								<span class="key">Status</span>
								<span class="lable"> : </span>
								<span class="value"> <?php if($subscribe->status == 0){ echo "Pending for Payment";} else if($subscribe->status == 1){ echo "Active";} else if($subscribe->status == 2){ echo "Expired";} ?> </span>
						</div>
					</div>
					
					<div class="col-md-2 col-2">
						<div class="order_detail">
								<span class="key" style="width: 34%;">Start Date</span>
								<span class="lable" style="width: 10%;"> : </span>
								<span class="value"> <?= $subscribe->plan_start_date; ?> </span>
						</div>
						<div class="order_detail">
								<span class="key" style="width: 34%;">End Date</span>
								<span class="lable" style="width: 10%;"> : </span>
								<span class="value"> <?= $subscribe->plan_end_date; ?> </span>
						</div>
						
						<div class="order_detail">
								<span class="key" style="width: 34%;">Amount</span>
								<span class="lable" style="width: 10%;"> : </span>
								<span class="value"> <?php $total=($subscribe->total_amount-$subscribe->discount)+$subscribe->tex;
															echo "₹ ".$total." /-";?> </span>
						</div>
					</div>
					<div class="col-md-2 col-2">
						<div class="order_detail">
						  <a href="<?php echo base_url(); ?>Subscription_management/single_sub_store/<?php echo $subscribe->store_subscription_id; ?>" class="fas fa-edit" style=" margin-top: 14%; margin-left: 25%; font-size: large;"> Edit <i class="fas fa-arrow-circle-right"></i></a>
						</div>
					</div>
				</div>
			  <?php } else { ?>
				<div class="row" style="padding:23px 10px 20px 11px;">
              		<div class="col-md-4 col-4">
						<div class="order_detail">
						<h4>Oops, No Subscription Yet!</h4>
						</div>
					</div>
				</div>		
			  <?php } ?>				
              </div>
        </div> 
    </div>
 
</section>		

<section class="content m-hide">
	<div class="row">
		<div class="col-6">
				<div class="card">
				<div class="card-header">
						<h3 class="card-title">Store Products</h3>
						</div>
						<div class="card-header">
							<ul>
							<li>Total Products : <?= $allcountproduct ?></li>
							<li>Live by store : <?= $live_products_count?></li>
							<li>Approved by Admin : <?= $approved_products_count ?></li>
							<li>Pending For Approval : <?= $pending_products_count ?></li>
							</ul>
						</div>	
					<div class="card-body">
						<table id="Product_table" class="table table-bordered table-striped">
							<thead>
								<tr>
								  <th style="text-align: center;"> Image </th>
								  <th style="text-align: center;"> Product Name </th>
								  <th style="text-align: center;"> Category </th>
								  <th style="text-align: center;"> Admin Status</th>
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
		
			<!--for package-->
			<div class="col-6">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Store Packages</h3>
					</div>
						<div class="card-header">
							<ul>
							<li>Total Packages : <?= $allcountpackage ?></li>
							<li>Live by store : <?= $live_package_count?></li>
							<li>Approved by Admin : <?= $approved_package_count ?></li>
							<li>Pending For Approval : <?= $pending_packages_count ?></li>
							</ul>
						</div>	
					<div class="card-body">
							
						<table id="Packages_table" class="table table-bordered table-striped">
							<thead>
								<tr>
								  <th style="text-align: center;"> Image </th>
								  <th style="text-align: center;"> Packages Name </th>
								  <th style="text-align: center;"> Category </th>
								  <th style="text-align: center;"> Admin Status</th>
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


<!-- Popup for update packages-->
<div class="modal fade" id="update_modal_product" >
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
		  <form id="update_product" method="POST" enctype="multipart/form-data" >
            <div class="modal-header">
              <h4 class="modal-title">Update Store Product</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
				
            </div>
            <div class="modal-body" id="product_datas">
             <input type="hidden" name="product_id" id="product_id">
             <input type="hidden" name="store_id" id="store_id" value="<?= $store_data->store_id ?>">
				<div class="card-body">
						<div class="row" style="text-align: center;justify-content: center; ">
							<div class="col-3">
								<div class="form-group">
									<img src="" id="product_image" name="product_image" height="150" width="150" />
								</div>
							</div>
						</div>
					<div class="row">
						<!--div class="col-4">
							<div class="form-group">
								<label>Image</label>
								<input type="file" name="category_image" class="form-control" placeholder="Category Name" >
							</div>
						</div -->
						
						<div class="col-4">
							<div class="form-group">
								<label>Product Name</label>
								<input type="text"  id="product_name" name="product_name" class="form-control" placeholder="Product Name" >
							</div>
						</div>
						
						<div class="col-4">
							<div class="form-group">
								<label>Product Price</label>
								<input type="text"  id="product_price" name="product_price" class="form-control" placeholder="Product price" >
							</div>
						</div>
						<div class="col-4">
							<div class="form-group">
								<label>Product sale Price</label>
								<input type="text"  id="product_sele_price" name="product_sele_price" class="form-control" placeholder="Product sale Price" >
							</div>
						</div>
						<div class="col-4">
							<div class="form-group">
								<label>Product Qauntity</label>
								<input type="number"  id="product_qty" name="product_qty" class="form-control" placeholder="Product Qauntity" >
							</div>
						</div>
						<div class="col-4">
							<div class="form-group">
								<label>Brand</label>
								<input type="text"  id="brand_name" name="brand_name" class="form-control" placeholder="brand_name" >
							</div>
						</div>
						
						<div class="col-4">
							<div class="form-group">
								<label>Selling units</label>
								<input type="text"  id="selling_unit" name="selling_unit" class="form-control" placeholder="selling_unit" >
							</div>
						</div>
						<div class="col-4">
							<div class="form-group">
								<label>Selling units Qauntity</label>
								<input type="number"  id="selling_unit_qty" name="selling_unit_qty" class="form-control" placeholder="selling_unit_qty" >
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Status </label>
								<select class="form-control" name="product_status" id="product_status" required>
									<option value="">Status</option>
									<option value="1">Live</option>
									<option value="0">Offline</option>
									
								</select>
							</div> 
						</div>
						<div class="col-8">
							<div class="form-group">
								<label>Descriptions</label>
								<textarea class="form-control" name="product_description" id="product_description" placeholder="Description" ></textarea>
							</div>
						</div>					
					</div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save Change</button>
            </div>
			 </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
	  
	  <div class="modal fade" id="update_modal" >
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
		  <form id="update" method="POST" enctype="multipart/form-data" >
            <div class="modal-header">
              <h4 class="modal-title">Update Store Package</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
				
            </div>
            <div class="modal-body" id="service_datas">
             <input type="hidden" name="Package_id" id="Package_id">
             <input type="hidden" name="store_id" id="store_id" value="<?= $store_data->store_id ?>">
				<div class="card-body">
						<div class="row" style="text-align: center;justify-content: center; ">
							<div class="col-3">
								<div class="form-group">
									<img src="" id="p_image" name="p_image" height="150" width="150" />
								</div>
							</div>
						</div>
					<div class="row">
						<!--div class="col-4">
							<div class="form-group">
								<label>Image</label>
								<input type="file" name="category_image" class="form-control" placeholder="Category Name" >
							</div>
						</div -->
						
						<div class="col-4">
							<div class="form-group">
								<label>Package Name</label>
								<input type="text"  id="Package_name" name="Package_name" class="form-control" placeholder="pacakge Name" >
							</div>
						</div>
						
						<div class="col-4">
							<div class="form-group">
								<label>Package Price</label>
								<input type="text"  id="packege_price" name="packege_price" class="form-control" placeholder="pacakge price" >
							</div>
						</div>
						<div class="col-4">
							<div class="form-group">
								<label>Package sale Price</label>
								<input type="text"  id="packege_sale_price" name="packege_sale_price" class="form-control" placeholder="pacakge sale Price" >
							</div>
						</div>
						<div class="col-4">
							<div class="form-group">
								<label>Package Excludes</label>
								<input type="text"  id="packege_excludes" name="packege_excludes" class="form-control" placeholder="pacakge Excludes" >
							</div>
						</div><div class="col-4">
							<div class="form-group">
								<label>Package Includes</label>
								<input type="text"  id="packege_includes" name="packege_includes" class="form-control" placeholder="pacakge Includes" >
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Status </label>
								<select class="form-control" name="packege_status" id="packege_status" required>
									<option value="">Status</option>
									<option value="1">Live</option>
									<option value="0">Offline</option>
									
								</select>
							</div> 
						</div>
						<div class="col-8">
							<div class="form-group">
								<label>Descriptions</label>
								<textarea class="form-control" name="packege_description" id="packege_description" placeholder="Description" ></textarea>
							</div>
						</div>					
					</div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save Change</button>
            </div>
			 </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
  
<script>
function edit_model_product(id){
		var res="";
		var store_id = <?= $store_data->store_id ?>;
		var link = '<?php echo base_url();?>';
		$.ajax({
			url:'<?php echo base_url(); ?>Store_management/get_single_product_data/'+id,
			method:"POST", 
			data:{ store_id : store_id}, 
			dataType: 'json',
			success:function(response)
			{  
				//console.log(response);
				$("#product_image").attr("src", link+ response.image_url);
				$("#product_id").val(response.product_id);
				$("#product_name").val(response.product_name);
				$("#product_price").val(response.product_price);
				$("#product_sele_price").val(response.product_sele_price);
				$("#product_qty").val(response.product_qty);
				$("#selling_unit").val(response.selling_unit);
				$("#selling_unit_qty").val(response.selling_unit_qty);
				$("#brand_name").val(response.brand_name);
				$("#product_description").val(response.product_description);
				$("#product_status").val(response.product_status);
				
				$("#product_data").html(response);
				$("#update_modal_product").modal('show');
			},
			error: function(e){ 
				alertify.error("Somthing Wrong");
				console.log(e);
			} 
		});
	}	

	
	//Update Service Parent Category
	
	$(document).ready(function (e) {
	 $("#update_product").on('submit',(function(e) {
	  e.preventDefault();
	  
		if ($( "#update_product" ).valid()) {
			
			$.ajax({
				url: '<?php echo base_url(); ?>Store_management/update_sinle_store_product',
				type: "POST",
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				
				success: function(data){
					alertify.success('Product Update Successfully');
					$('#update_modal_product').modal('hide');
					$('#tr-'+$('#product_id').val()).html(data);
					location.reload();
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
				}          
			});
		}
	 }));
	});	
</script>

<script>
	

	<!--for product and package -->
     $('#pagination2').on('click','a',function(e){
       e.preventDefault(); 
       var pageno2 = $(this).attr('data-ci-pagination-page');
       get_data_product(pageno2);
     });
	 get_data_product(0);
	 function get_data_product(pagno2){
		
		$.ajax({
				url:'<?php echo base_url(); ?>Store_management/get_data_product/'+pagno2,
				//method:"POST", 
				type: 'POST',
				data:{store_id:<?= $store_data->store_id; ?>}, 
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
       var pageno3 = $(this).attr('data-ci-pagination-page');
       get_data_Packages(pageno3);
     });
	 get_data_Packages(0);
	 function get_data_Packages(pagno3){
		var datepicker = $('#datepicker').val();
		var enddatepicker = $('#enddatepicker').val();
		//alert(pagno);
		
		$.ajax({
				url:'<?php echo base_url(); ?>Store_management/get_data_Packages/'+pagno3,
				//method:"POST", 
				type: 'POST',
				data:{store_id:<?= $store_data->store_id; ?>}, 
				dataType: 'json',
				success:function(response)
				{  
					//alert(response); 
					$('#pagination3').html(response.pagination3);
					$('#Packages_table tbody').html(response.table3);
					
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					console.log(e);
				} 
			});
	}
function edit_model(id){
		var res="";
		var store_id = <?= $store_data->store_id ?>;
		var link = '<?php echo base_url();?>';
		$.ajax({
			url:'<?php echo base_url(); ?>Store_management/get_single_package_data/'+id,
			method:"POST", 
			data:{ store_id : store_id}, 
			dataType: 'json',
			success:function(response)
			{  
				//console.log(response);
				$("#Package_id").val(response.Package_id);
				$("#Package_name").val(response.Package_name);
				$("#p_image").attr("src", link+ response.packege_image);
				$("#packege_duration").val(response.packege_duration);
				$("#packege_price").val(response.packege_price);
				$("#packege_sale_price").val(response.packege_sale_price);
				$("#packege_status").val(response.packege_status);
				$("#packege_description").val(response.packege_description);
				$("#packege_excludes").val(response.packege_excludes);
				$("#packege_includes").val(response.packege_includes);
				
				$("#service_data").html(response);
				$("#update_modal").modal('show');
			},
			error: function(e){ 
				alertify.error("Somthing Wrong");
				console.log(e);
			} 
		});
	}	

	
	//Update Service Parent Category
	var update = 0;
	$(document).ready(function (e) {
	 $("#update").on('submit',(function(e) {
	  e.preventDefault();
	  
		if ($( "#update" ).valid() && update == 0) {
			
			$.ajax({
				url: '<?php echo base_url(); ?>Store_management/update_sinle_store_package',
				type: "POST",
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				beforeSend : function(){ 
					update = 1;
				},
				success: function(data){
					alertify.success('Update Successfully');
					$('#update_modal').modal('hide');
					$('#tr-'+$('#update_id').val()).html(data);
					update = 0;
					location.reload();
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
				}          
			});
		}
	 }));
	});	
</script>		

		