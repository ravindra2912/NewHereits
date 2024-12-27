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
<form id="myform" name="myform" action='<?php echo base_url(); ?>Store_management/update_store' method="POST" enctype="multipart/form-data">
<input type="hidden" name="store_id" value="<?php echo $store_data->store_id; ?>" ?>
<div class="card-footer" style="text-align: end;">
	<button type="submit" name="submit" id="submit" class="btn btn-primary">Save</button>
</div>
<section class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-warning">
					<div class="card-header">
						<h3 class="card-title">store Information</h3>
					</div>
					<div class="card-body">
						<div class="row">
						
							<div class="col-sm-12">
								<div class="form-group" style="text-align: center;">
									<image onclick="image_view_modal(this.src)" src="<?php echo base_url().$store_data->store_image; ?>" id="store_image_output" style="height: 140px;width: auto;object-fit: contain;" />
									<input type="file" name="store_image1" class="form-control" id="store-upload-Image" onchange="resizeimage('store-upload-Image', 'store_image_output', 'store_image', 300, 175);" style="width: 25%;margin-left: 39%;">
									<input type="text" id="store_image" name="store_image" style="opacity:0" />
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="form-group">
									<label>Store Name :</label><span class="error">*</span>
									<input type="text" name="Store_name" id="Store_name" value="<?php echo $store_data->Store_name; ?>" class="form-control" placeholder="Enter Store Name">
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="form-group">
									<label>Contact :</label><span class="error">*</span>
									<input type="text" name="store_contact" id="store_contact" value="<?php echo $store_data->store_contact; ?>" class="form-control" placeholder="Enter Contact Number">
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="form-group">
									<label>Email :</label> <span class="error">*</span>
									<input type="text" name="store_email" id="store_email" value="<?php echo $store_data->store_email; ?>" class="form-control" placeholder="Enter Contact Number">
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="form-group">
									<label>Reffered by :</label> <span class="error">*</span>
									<input type="text" value="<?php echo $store_data->referral_code; ?>" class="form-control" readonly>
								</div>
							</div>
													
							<div class="col-sm-6">
								<div class="form-group">
									<label>Select Status :</label> <span class="error">*</span>
									<select class="form-control" onchange="check_status()" name="store_status" id="store_status">
									  <option value="">Select Status</option>
									  <option <?php if($store_data->store_status == 0){ echo 'selected';} ?> value="0">Pending for Approval</option>
									  <option <?php if($store_data->store_status == 1){ echo 'selected';} ?> value="1">Approved</option>
									  <option <?php if($store_data->store_status == 2){ echo 'selected';} ?> value="2">Disapproved</option>
									</select>
								  </div>
							</div>
							
							<div class="col-sm-12" id="reason">
								<div class="form-group">
									<label>Reason :</label>
									<textarea name="disapprove_reason" id="disapprove_reason" class="form-control" placeholder="Enter Reason"><?php echo $store_data->disapprove_reason; ?></textarea>
								</div>
							</div>
								<?php if($store_data->store_status == 2){ ?>
									<script>	$('#reason').show(); </script>
								<?php }	else{  ?>
									<script>	$('#reason').hide();</script>
								<?php } ?>
							<script>	
								function check_status(){
									
									if ($('#store_status').val() == 2){
										$('#reason').show();
									}
									else{
										$('#reason').hide();
									}
								}
							</script>
							<div class="col-sm-12">
								<div class="form-group">
									<label>Description :</label>
									<textarea name="description" id="description" class="form-control" placeholder="Enter Description"><?php echo $store_data->description; ?></textarea>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Location  -->
<section class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-warning">
					<div class="card-header">
						<h3 class="card-title">store Location :</label> <span class="error">*</span>
					</div>
					<div class="card-body">
						<div class="row">
						
							<div class="col-sm-12" style="margin-top: 10px;">
								<!--The div element for the map -->
								<div id="map" style="height: 300px;width: auto;"></div>
								<input id="pac-input" class="controls form-control" value="<?php echo $store_data->store_address; ?>" name="store_address" type="text" placeholder="Search Box" />
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
								  <label>Store Address :<span class="error"> * </span></label>
								  <input name="store_address_2" value="<?php echo $store_data->store_address_2; ?>" class="form-control" type="text" placeholder="Store Address" >
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
								  <label>City : <span class="error">*</span></label>
								  <input name="city" value="<?php echo $store_data->city; ?>" id="locality" class="form-control" type="text" placeholder="City">
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
								  <label>District : <span class="error">*</span></label>
								  <input name="district" value="<?php echo $store_data->district; ?>" id="administrative_area_level_2" class="form-control" type="text" placeholder="District" readonly >
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
								  <label>State : <span class="error">*</span></label>
								  <input name="state" value="<?php echo $store_data->state; ?>" id="administrative_area_level_1" class="form-control" type="text" placeholder="State" readonly >
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
								  <label>Country : <span class="error">*</span></label>
								  <input name="country" value="<?php echo $store_data->country; ?>" id="country" class="form-control" type="text" placeholder="Country" readonly >
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
								  <label>Pincode : <span class="error">*</span></label>
								  <input name="pincode" value="<?php echo $store_data->pincode; ?>" id="postal_code" class="form-control" type="text" placeholder="Pincode" readonly >
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-warning">
					<div class="card-header">
						<h3 class="card-title">store Document</h3>
					</div>
					<div class="card-body">
						<div class="row">
						
							<div class="col-sm-6">
								<div class="form-group">
									<label>Address Proof  :</label> <span class="error">*</span>
									<div class="form-group" style="text-align: center;">
										<image onclick="image_view_modal(this.src)" src="<?php if(file_exists($store_data->address_proof_image)) { echo base_url().$store_data->address_proof_image; }else{ echo base_url().'assets/store_registration/images/documents.jpg';} ?>" style="height: 200px;width: auto;" alt="Store Image" />
										<input type="file" name="address_proof_image" class="form-control" style="width: 54%;margin-left: 23%;">
									</div>
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="form-group">
									<label>Pancard Image :</label>
									<div class="form-group" style="text-align: center;">
										<image onclick="image_view_modal(this.src)" src="<?php if(file_exists($store_data->pancard_image)) { echo base_url().$store_data->pancard_image; }else{ echo base_url().'assets/store_registration/images/documents.jpg';} ?>" style="height: 200px;width: auto;" alt="Store Image" />
										<input type="file" name="pancard_image" class="form-control" style="width: 54%;margin-left: 23%;">
										<input type="text" value="<?php echo $store_data->pancard_number; ?>" name="pancard_number" value="<?php echo $store_data->pancard_number; ?>" class="form-control" placeholder="Pnacard Number">
									</div>
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="form-group">
									<label>GST Image :</label>
									<div class="form-group" style="text-align: center;">
										<image onclick="image_view_modal(this.src)" src="<?php if(file_exists($store_data->gst_image)) { echo base_url().$store_data->gst_image; }else{ echo base_url().'assets/store_registration/images/documents.jpg';} ?>" style="height: 200px;width: auto;" alt="Store Image" />
										<input type="file" name="gst_image" class="form-control" style="width: 54%;margin-left: 23%;">
										<input type="text" value="<?php echo $store_data->gst_number; ?>" name="gst_number" value="<?php echo $store_data->pancard_number; ?>" class="form-control" placeholder="GST Number">
									</div>
								</div>
							</div>
			
						</div>
						<div class="row" style=" margin-left: 6px;margin-top: 20px;">
							<label>Address Verfied </label>
							<input type="Checkbox" name="address_verifed" value="1" id="address_verifed" class="form-control"  style="width: 4%;height: 21px"<?php if($store_data->address_verifed == 1){ echo "Checked";} ?>>
							
							<label style="margin-left: 45px;">Pancard Verfied</label>
							<input type="Checkbox" name="pancard_verifed" value="1" id="pancard_verifed" class="form-control" style="width: 4%;height: 21px"<?php if($store_data->pancard_verifed == 1){ echo "Checked";} ?>>
								  
							<label style="margin-left: 45px;">GST Verfied </label>
							<input type="Checkbox" name="gst_verifed" value="1" id="gst_verifed" class="form-control"  style="width: 4%;height: 21px"<?php if($store_data->gst_verifed == 1){ echo "Checked";} ?>>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="card-footer">
	<button type="submit" name="submit" id="submit" class="btn btn-primary">Save</button>
</div>
</form>
	
<!-- full view Image Modal -->  
<div class="modal fade" id="full_image">
    <div class="modal-dialog modal-xl"">
		<div class="modal-body" style="text-align: center;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<img src="" id="full_image_view" style="max-height: auto;max-width: 1140px"/>
		</div>
          <!-- /.modal-content -->
    </div>
        <!-- /.modal-dialog -->

	
	  

<script>
		$(function() {
			$("#myform").validate(
			{
				rules: {
					Store_name: {
					required: true,
					},
					store_contact: {
						required: true,
						minlength: 10,
						maxlength:12,
						number: true,
					},
					store_email: {
					  required: true,
					  email:true,
					},
					store_status: {
					  required: true,
					},
					disapprove_reason: {
					  required: true,
					},
					
					store_address_2: {
					  required: true,
					},
					city: {
					  required: true,
					},
					district: {
					  required: true,
					},					
					state: {
					  required: true,
					},
					country: {
					  required: true,
					},
					
					
					
					
				},
		   
			messages: 
			{
					Store_name:'<p> *Please enter Store name</p>',
					store_contact: {
						required: '<p> *Please enter Contact number</p>',
						minlength:'<p> *Minimum 10 digits required</p>',
						maxlength:'<p> *Minimum 12 digits required</p>',
						number: '<p> *Enter numbers only</p>',
					},
					store_email: {
					  required: '<p> *Please enter Email address</p>',
					  email:'<p> *Please enter validate email</p>',
					},
					
					store_status:'<p> *Please Select status</p>',
					disapprove_reason:'<p> *Please enter Reason for rejection</p>',
					store_address_2:'<p> *Please enter Store address</p>',
					city: '<p> *Please Select city</p>',
					district:'<p> *Please Select district</p>',		
					state: '<p> *Please Select state</p>',
					country:'<p> *Please Select country</p>',
					
					address_proof_image:'<p> *Please Upload address proofe</p>',
				},
			  
			submitHandler: function(form) {
				form.submit();
			}
		});
	});

</script>

<script>
//for image full view
function image_view_modal(image_src){
	$('#full_image').modal('show');
	document.getElementById("full_image_view").src = image_src;
}
</script>	


	

	