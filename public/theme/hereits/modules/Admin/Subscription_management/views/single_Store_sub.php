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
.order_detail{
	margin: 0;
	display: flex;
	align-items: center;
	padding: 5px 0;
}
.order_detail .key{
	width: 45%;
}
.order_detail .lable{
	width: 5%;
	font-weight: 501;
}
.order_detail .value{
	width: 50%;
	font-size: 14px;
	color: #000;
	font-family: "Roboto", sans-serif;
	font-weight: 501;
}

.order_detail .order-number-text {
    width: unset;
    display: inline-block;
    background: #d3d3d3;
    padding: 3px 8px;
}




</style>

<section class="content">

	<div class="row">
				
		<div class="col-md-4">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Store Subscription Details</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body" style="display: block;">
					
					<div class="order_detail">
						<span class="key">Store Subscription id</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $sub_data->store_subscription_id ?> </span>
					</div>
					
					<div class="order_detail">
						<span class="key">Store Id </span>
						<span class="lable"> : </span>
						<a  href="<?= base_url().'Store_management/single_store/'.$sub_data->store_id ;?>" class="value order-number-text"><?= $sub_data->store_id?></a>
					</div>
					<div class="order_detail">
						<span class="key">Store Name</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $sub_data->Store_name ?> </span>
					</div>
					
					<div class="order_detail">
						<span class="key">Duration </span>
						<span class="lable"> : </span>
						<span class="value"> <?= $sub_data->duration . " Months" ?> </span>
					</div>
					<div class="order_detail">
						<span class="key">Plan Start Date</span>
						<span class="lable"> : </span>
						<span class="value"><?= $sub_data->plan_start_date?> </span>
					</div>
					<div class="order_detail" style="margin-top: -8px;">
						<span class="key"> </span>
						<span class="lable">  </span>
						<input type="date" id="datepicker" onchange="Change_subscription_date(<?= $sub_data->store_subscription_id ?>)" width="270">
					</div>
					
					<div class="order_detail">
						<span class="key">Plan End Date</span>
						<span class="lable"> : </span>
						<span class="value "><?= $sub_data->plan_end_date?></span>
					</div>
					<div class="order_detail" style="margin-top: -8px;">
						<span class="key"> </span>
						<span class="lable">  </span>
						<input type="date" id="enddatepicker" onchange="Change_subscription_date(<?= $sub_data->store_subscription_id ?>)" width="270">
					</div>
										
					<div class="booking_detail">
						<span class="key">Subscription Status</span>
						<span class="lable"> : </span>
						<span class="value">
									<select  onchange="Change_subscription_status(<?= $sub_data->store_subscription_id	 ?>)" name="sub_status" id="sub_status" class="custom-select custom-select-sm form-control form-control-sm">
									  <option value="">Select Status</option>
									  <option <?php if($sub_data->status == 0){ echo 'selected';} ?> value="0">Payment Pending</option>
									  <option <?php if($sub_data->status == 1){ echo 'selected';} ?> value="1">Active</option>
									  <option <?php if($sub_data->status == 2){ echo 'selected';} ?> value="2">Expired</option>
									  </select>
						</span>
					</div>			
				</div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Subscription Details</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body" style="display: block;">	
					<div class="order_detail">
						<span class="key">Subscription Id</span>
						<span class="lable"> : </span>
						<span class="value"><?= $subscribe->subscription_id ?></span>
					</div>
					<div class="order_detail">
						<span class="key">Subscription Type</span>
						<span class="lable"> : </span>
						<span class="value"><?= $subscribe->name ?></span>
					</div>
					<div class="order_detail">
						<span class="key">Product Limit</span>
						<span class="lable"> : </span>
						<span class="value"> <?= $subscribe->Product_Limit ?> </span>
					</div>
					<div class="order_detail">
						<span class="key">Package Limit</span>
						<span class="lable"> : </span>
						<span class="value"><?= $subscribe->package_Limit ?> </span>
					</div>
					
					<div class="order_detail">
						<span class="key">Type</span>
						<span class="lable"> : </span>
						<span class="value"> <?php if($subscribe->type==1){ echo "Product";} else if($subscribe->type==2){ echo "Service";} else if($subscribe->type==3){ echo "Product & Service";}  ?> </span>
					</div>
					
					<div class="order_detail">
						<span class="key">Status</span>
						<span class="lable"> : </span>
						<span class="value"> <?php if($subscribe->status==0){ echo "Inactive";} else if($subscribe->status==1){ echo "Active";}  ?> </span>
					</div>
				</div>	
				</div>
		</div>
		
		<div class="col-md-4">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Order Summury</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body" style="display: block;">
					<table id="Product_table" class="table">
						<tbody>	
							<tr>
								<td>Total</td>
								<td><?= "₹ ".$sub_data->total_amount ?></td>
							</tr>
							<tr>
								<td>Discount </td>
								<td><?=  "₹ ".$sub_data->discount ?></td>
							</tr>
							<tr>
								<td>Tax </td>
								<td><?=  "₹ ".$sub_data->tex ?></td>
							</tr>
							<tr>
								<td>Total Amount</td>
								<td><?= "₹ ".($sub_data->total_amount - $sub_data->discount+ $sub_data->tex)." /-" ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
	</div>
		
		
		
		
		
		
		
	</div>
</section>

<script>
		
	function Change_subscription_status(store_subscription_id){
		var sub_status = $('#sub_status').val();
		var result = confirm("Want to Change?");
		
		if (result) { 

			$.ajax({
				url:'<?= base_url() ?>Subscription_management/Change_sub_status',
				method:"POST", 
				data:{ sub_status:sub_status ,store_subscription_id:store_subscription_id},
				success:function(data)
				{  
					alertify.success("Status Updated Successfully");
					location.reload(); 
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					console.log(e);
				} 
			});
		}
</script>		}



<script>
		
	function Change_subscription_date(store_subscription_id){
		var datepicker = $('#datepicker').val();
		var enddatepicker = $('#enddatepicker').val();
		var result = confirm("Want to Change?");
		
		if (result) { 

			$.ajax({
				url:'<?= base_url() ?>Subscription_management/Change_date',
				method:"POST", 
				data:{ enddatepicker:enddatepicker,store_subscription_id:store_subscription_id,datepicker:datepicker },
				success:function(data)
				{  
					alertify.success("Status Updated Successfully");
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











	

	