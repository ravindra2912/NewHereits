<div class="content-header m-hide">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Store Profile</h1>
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
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3">
				<div class="card card-primary card-outline">
					<div class="card-body box-profile">
						<div class="text-center">
							<img class="profile-user-img img-fluid img-circle" src="<?= base_url() ?><?= $user_data->user_image ?>" alt="Store Image">
						</div>

						<h3 class="profile-username text-center"><?= $store_data->Store_name ?></h3>
						
						<ul class="list-group list-group-unbordered mb-3">
							<li class="list-group-item">
								<b>Username :</b> <a  class="float-right"><?= $user_data->username ?></a>
							</li>
							<li class="list-group-item">
								<b>Email :</b> <a  class="float-right"><?= $user_data->email ?></a>
							</li>
							<li class="list-group-item">
								<b>Contact :</b> <a  class="float-right"><?= $user_data->contact ?></a>
							</li>
							<li class="list-group-item">
								<b> Store Followers :</b> <a id="follow_count" class="float-right"><?= $follow_count ?></a>
							</li>
							<a href="<?php echo base_url(); ?>Store_Profile/user_edit" class="btn btn-primary" >Edit Details</a>
						</ul>
					</div>
				</div>

			</div>
			<div class="col-md-9">
			
				
				
											
			
				<div class="card">
					<div class="card-header p-2">
						<ul class="nav nav-pills">
							<li class="nav-item"><a class="nav-link active" href="#Store_Info" data-toggle="tab">Store Info</a></li>
							<li class="nav-item"><a class="nav-link" href="#Address" data-toggle="tab">Address</a></li>
							<li class="nav-item"><a class="nav-link" href="#document" data-toggle="tab">Documents</a></li>
						</ul>
					</div>
					<form action='<?php echo base_url(); ?>Store_Profile/update_store' method="POST" enctype="multipart/form-data">
						<div class="card-body">
							<div class="tab-content">
								<div class="active tab-pane" id="Store_Info">
									<div class="form-horizontal row">
										<div class="col-sm-12" >
											<div class="form-group" style="text-align: center;">
												<image src="<?php echo base_url().$store_data->store_image; ?>" id="store_image_output" style="height: 140px;width: auto;object-fit: contain;" alt="Store Image" />
												<input type="file" name="store_image1" id="store-upload-Image" onchange="resizeimage('store-upload-Image', 'store_image_output', 'store_image', 300, 175);" class="form-control" style="width: 25%;margin-left: 39%;">
												<input type="text" id="store_image" name="store_image" style="opacity:0" />
											</div>
										</div>
										
										<div class="col-sm-6">
											<div class="form-group">
												<label>Store Name</label>
												<input type="text" name="Store_name" value="<?php echo $store_data->Store_name; ?>" class="form-control" placeholder="Enter Store Name">
											</div>
										</div>
										
										<div class="col-sm-6">
											<div class="form-group">
												<label>Contact</label>
												<input type="text" name="store_contact" id="store_contact" value="<?php echo $store_data->store_contact; ?>" class="form-control" placeholder="Enter Contact Number" readonly>
											</div>
										</div>
										
										<div class="col-sm-6">
											<div class="form-group">
												<label>Email</label>
												<input type="text" name="store_email" id="store_email" value="<?php echo $store_data->store_email; ?>" class="form-control" placeholder="Enter Contact Number">
											</div>
										</div>
										<?php $refred_by = $this-> Mdl_Store_Profile->get_refered_user($store_data->referral_code); ?>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Refered by</label>
												<input type="text" value="<?php if($store_data->referral_code != null){ echo $store_data->referral_code .' - '.$refred_by->username; }?>" class="form-control" readonly>
											</div>
										</div>
										
										<div class="col-sm-6">
											<div class="form-group">
												<label>My Referral Code</label>
												<input type="text" value="<?php echo $user_data->user_referal?>" class="form-control" readonly>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<label>Store Tags :</label> 
												<input type="text" class='tags_input' value="<?php echo $tag;?>" id="tags"  name="tags" placeholder="Enter ...">
											</div>
										</div>
										
										<div class="col-sm-12">
											<div class="form-group">
												<label>Description</label>
												<textarea name="description" id="description" class="form-control" placeholder="Enter Description"><?php echo $store_data->description; ?></textarea>
											</div>
										</div>
										
										
										
									</div>
								</div>

								<div class="tab-pane" id="Address">
									<div class="form-horizontal row">
										<div class="col-sm-12" style="margin-top: 10px;">
											<!--The div element for the map -->
											<div id="map" style="height: 300px;width: auto;"></div>
											<input id="pac-input" class="controls form-control" value="<?php echo $store_data->store_address; ?>" name="store_address" id="store_address" type="text" placeholder="Search Box" />
											<div id="current_location"  style="z-index: 0; position: absolute; bottom: 136px; right: 0px;">
												<div style="background-color: rgb(255, 255, 255); border: 2px solid rgb(255, 255, 255); border-radius: 3px; box-shadow: rgba(0, 0, 0, 0.3) 0px 2px 6px; cursor: pointer; margin-right: 16px; text-align: center;" title="Current Location">
													<div style="color: rgb(25, 25, 25); font-family: Roboto, Arial, sans-serif; font-size: 16px; line-height: 38px; padding-left: 5px; padding-right: 5px; width: 40px;"><img class="svg" src="<?= base_url() ?>assets/store_registration/images/location.png" style="width: 13px;" alt="placeholder">
													</div>
												</div>
											</div>
											<input type="hidden" value="<?php echo $store_data->latitude; ?>" id="latitude" name="latitude" />
											<input type="hidden" value="<?php echo $store_data->longitude; ?>" id="longitude" name="longitude" />
										</div>
										
										<div class="col-sm-12">
											<div class="form-group">
											  <label>Store Address <span class="error">*</span></label>
											  <input name="store_address_2" id="store_address_2" value="<?php echo $store_data->store_address_2; ?>" class="form-control" type="text" placeholder="Store Address" >
											</div>
										</div>

										<div class="col-sm-4">
											<div class="form-group">
											  <label>City <span class="error">*</span></label>
											  <input name="city" id="city" value="<?php echo $store_data->city; ?>" id="locality" class="form-control" type="text" placeholder="City" readonly>
											</div>
										</div>

										<div class="col-sm-4">
											<div class="form-group">
											  <label>District <span class="error">*</span></label>
											  <input name="district" id="district" value="<?php echo $store_data->district; ?>" id="administrative_area_level_2" class="form-control" type="text" placeholder="District" readonly >
											</div>
										</div>

										<div class="col-sm-4">
											<div class="form-group">
											  <label>State <span class="error">*</span></label>
											  <input name="state" id="state" value="<?php echo $store_data->state; ?>" id="administrative_area_level_1" class="form-control" type="text" placeholder="State" readonly >
											</div>
										</div>

										<div class="col-sm-4">
											<div class="form-group">
											  <label>Country <span class="error">*</span></label>
											  <input name="country" id="country" value="<?php echo $store_data->country; ?>" id="country" class="form-control" type="text" placeholder="Country" readonly >
											</div>
										</div>

										<div class="col-sm-4">
											<div class="form-group">
											  <label>Pincode <span class="error">*</span></label>
											  <input name="pincode" id="pincode" value="<?php echo $store_data->pincode; ?>" id="postal_code" class="form-control" type="text" placeholder="Pincode" readonly >
											</div>
										</div>
									</div>
								</div>
								<script>
								    if(<?php echo $store_data->store_status; ?> == 1 ){
										$('store_address').prop('disabled', true);
										$('store_address_2').prop('disabled', true);
										$('country').prop('disabled', true);
										$('pincode').prop('disabled', true);
										$('state').prop('disabled', true);
										$('city').prop('disabled', true);
										$('district').prop('disabled', true);
									}
								</script>
								
								<div class="tab-pane" id="document">
									<div class="form-horizontal row">
										<?php if($store_data->store_status == 1) { ?>
										<div class="col-sm-12" style="margin-bottom: 6px; margin-top: -14px;">
											<span class="error" style="font-size: 15px;">Note: If you want to Change Documents details,Please E-mail us on support@hereits.com</span>
										</div>
										<?php }?>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Address Proof</label>
												<div class="form-group" style="text-align: center;">
													<image src="<?php if(file_exists($store_data->address_proof_image)) { echo base_url().$store_data->address_proof_image; }else{ echo base_url().'assets/store_registration/images/documents.jpg';} ?>" style="height: 200px;width: auto;" alt="Store Image" />
													<?php if($store_data->store_status != 1){ ?>
													<input type="file" name="address_proof_image" class="form-control" style="width: 54%;margin-left: 23%;">
													<?php } ?>
												</div>
											</div>
										</div>
										
										<div class="col-sm-6">
											<div class="form-group">
												<label>Pancard Image</label>
												<div class="form-group" style="text-align: center;">
													<image src="<?php if(file_exists($store_data->pancard_image)) { echo base_url().$store_data->pancard_image; }else{ echo base_url().'assets/store_registration/images/documents.jpg';} ?>" style="height: 200px;width: auto;" alt="Store Image" />
													<?php if($store_data->store_status != 1){ ?>
														<input type="file" name="pancard_image" class="form-control" style="width: 54%;margin-left: 23%;">
													<?php } ?>
													<input type="text" value="<?php echo $store_data->pancard_number; ?>" name="pancard_number" value="<?php echo $store_data->pancard_number; ?>" class="form-control" placeholder="Pan-card Number" <?php if($store_data->store_status == 1){echo 'readonly';}?>>
												</div>
											</div>
										</div>
										
										<div class="col-sm-6">
											<div class="form-group">
												<label>GST Image</label>
												<div class="form-group" style="text-align: center;">
													<image src="<?php if(file_exists($store_data->gst_image)) { echo base_url().$store_data->gst_image; }else{ echo base_url().'assets/store_registration/images/documents.jpg';} ?>" style="height: 200px;width: auto;" alt="Store Image" />
													<?php if($store_data->store_status != 1){ ?>
														<input type="file" name="gst_image" class="form-control" style="width: 54%;margin-left: 23%;">
													<?php } ?>
													<input type="text" value="<?php echo $store_data->gst_number; ?>" name="gst_number" value="<?php echo $store_data->pancard_number; ?>" class="form-control" placeholder="GST Number" <?php if($store_data->store_status == 1){echo 'readonly';}?>>
												</div>
											</div>
										</div>
									</div>
								</div>
									<button type="submit" class="btn btn-primary" style="float: right;">Save</button>
							
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
    </div>
</section>




















	<!-- Add timing Model -->
	<div class="modal fade" id="add_time_slot">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Time Slote</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
			<form id="coupons_detail" action="<?= base_url() ?>Store_Timing/set_time_slot" method="POST" enctype="multipart/form-data" novalidate="novalidate">		
				<div class="modal-body">
					<div class="card-body">
						<div class="row">
							
							<input type="hidden" name="store_timing_id" id="store_timing_id" />
							<div class="col-sm-12 col-12">
								<div class="bootstrap-timepicker">
									<div class="form-group">
										<label>Start Time <span class="error">*</span></label>
										<div class="input-group date" id="start_time" data-target-input="nearest">
											<input name="start_time" readonly="readonly" type="text" class="form-control datetimepicker-input" data-target="#start_time" data-toggle="datetimepicker"/>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-sm-12 col-12">
								<div class="bootstrap-timepicker">
									<div class="form-group">
										<label>Start Time <span class="error">*</span></label>
										<div class="input-group date" id="end_time" data-target-input="nearest">
											<input name="end_time" readonly="readonly" type="text" class="form-control datetimepicker-input" data-target="#end_time" data-toggle="datetimepicker"/>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				
				</div>
				<div class="modal-footer justify-content-between">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  <button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
	  
	  <!-- update timing Model -->
	<div class="modal fade" id="update_time_slot">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Update Time Slote</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
			<form id="coupons_detail" action="<?= base_url() ?>Store_Timing/update_time_slot" method="POST" enctype="multipart/form-data" novalidate="novalidate">		
				<div class="modal-body">
					<div class="card-body">
						<div class="row" >
							<input type="hidden" name="store_timing_slot_id" id="update_store_timing_slot_id" />
							<div class="col-sm-12 col-12">
								<div class="bootstrap-timepicker">
									<div class="form-group">
										<label>Start Time <span class="error">*</span></label>
										<div class="input-group date" id="start_time1" data-target-input="nearest">
											<input name="start_time" id="update_start_time"  readonly="readonly" type="text" class="form-control datetimepicker-input" data-target="#start_time1" data-toggle="datetimepicker"/>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-sm-12 col-12">
								<div class="bootstrap-timepicker">
									<div class="form-group">
										<label>Start Time <span class="error">*</span></label>
										<div class="input-group date" id="end_time1" data-target-input="nearest">
											<input name="end_time" id="update_end_time" readonly="readonly" type="text" class="form-control datetimepicker-input" data-target="#end_time1" data-toggle="datetimepicker"/>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				
				</div>
				<div class="modal-footer justify-content-between">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  <button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>





<script>
function add_time_slot(id){
	$('#store_timing_id').val(id);
	$('#add_time_slot').modal('show');
}

function edit_time_slot(store_timing_slot_id){
	$.ajax({
		url:'<?php echo base_url(); ?>Store_Timing/edit_time_slot',
		method:"POST", 
		data:{ store_timing_slot_id:store_timing_slot_id },
		dataType: 'json',
		success:function(data)
		{  
			//alert(data);
			$('#update_store_timing_slot_id').val(data.store_timing_slot_id);
			$('#update_start_time').val(data.start_time);
			$('#update_end_time').val(data.end_time);
			$('#update_time_slot').modal('show');
		},
		error: function(e){ 
			alertify.error("Somthing Wrong");
			console.log(e);
		} 
	});
}

	
	//delete Service Parent Category
	function delete_time_slot(store_timing_slot_id){
		var result = confirm("Want to delete?");
		if (result) { 

			$.ajax({
				url:'<?php echo base_url(); ?>Store_Timing/delete_time_slot',
				method:"POST", 
				data:{ store_timing_slot_id:store_timing_slot_id },
				success:function(data)
				{  
					alertify.success("Delete Successfully");
					$('#slot-'+store_timing_slot_id).remove();
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
				} 
			});
		}
	}



</script>	
<!-- for tags -->
<script>
$(function(){
	
	$.ajax({
		url: '<? echo base_url(); ?>Store_Profile/get_tag',
		type: "POST",
		data:  {tag:'' },
		dataType: "json",
		success: function(res)
		{
			var tags = [];
			 //alert(res);
			for (var i = 0; i < res.length; i++) {
			  tags.push(res[i].tag);
			}
			
			$(".tags_input").tagComplete({
			
				keylimit: 1,
				hide: false,
				autocomplete: {
					data: tags
				}
		});
		},
		error: function(e){ 
			alert('Somthing Wron');
			console.log(e);
		}           
	});

	
});
</script>