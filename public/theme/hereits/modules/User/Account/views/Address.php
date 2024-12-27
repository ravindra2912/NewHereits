 <?php include 'header.html';?>
	
	<div class="container mt-4 mb-4">
      <div class="row">
		<!-- this for user sidebar -->
		<?php include 'user_sidebar.php';?>
		
        <div class="col-lg-9">
          <div class="bg-white shadow-md rounded p-4"> 
            <!-- Personal Information
          ============================================= -->
            <h4 class="mb-4">My Address</h4>
			<hr class="mx-n4 mb-4">
                
				<div class="row">
                  <div class="col-lg-12">
					<a data-toggle="modal" data-target="#add_address_modal" class="p-1" style="float: right;"><i class="fas fa-plus"></i> Add New</a>
                  </div>
				  
				  <?php foreach($address as $addr){?>
				  <div class="col-lg-12 p-2" style="border: 1px solid #e7e9ed; border-radius: 10px;">
					<span class="text-3 font-weight-600 mb-0"><?php if($addr->address_type == 1){ echo "HOME";} elseif($addr->address_type == 2){ echo "OFFICE";} elseif($addr->address_type == 3){ echo "OTHER";} ?></span> 
					<span class="p-1" style="float: right;"><a  onclick="edit_model(<?= $addr->address_id?>)"><i class="fas fa-edit"></i></a></span>
					<span class="p-1" style="float: right;"><a href="<?= base_url()?>Account/delete_addres/<?= $addr->address_id?>"><i class="far fa-trash-alt"></i></span></a>
					<p><?= $addr->address1 .' ,'.$addr->address2.' ,'.$addr->city.'.'. $addr->state.'-'.$addr->pincode.','.$addr->country.'.'?></p>
                  </div>
                  <?php }?>
				  
                  </div>
                  
              
          </div>
        </div>
      </div>
    </div>
	
	<!-- add address modal -->
	<div id="add_address_modal" class="modal fade" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add New Address</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
							
							<form id="insert_address_form" action="<?=base_url()?>Account/insert_address" method="post">
								<div class="row">
								  <div class="form-group col-lg-12">
									<label for="name">Full Name</label>
									<input type="text" class="form-control" data-bv-field="name"  Name="name"  placeholder="Full Name">
								  </div>
								  
								  <div class="form-group col-lg-12">
									<label for="contact">Mobile Number</label>
									<input type="number" class="form-control" data-bv-field="contact"   Name="contact"  placeholder="Mobile Number">
								  </div>
								  
								  <div class="form-group col-lg-12">
									<label for="address1">Address</label>
									<input type="text" class="form-control" data-bv-field="address1"  Name="address1"  placeholder="Address (Home No, Building, Street, Area)">
									<input type="text" class="form-control" data-bv-field="address2"  Name="address2"  placeholder="Address Line 2">
								  </div>
								 
								  <div class="form-group col-lg-12">
									<label for="pincode">Pincode</label>
									<input type="number" class="form-control" data-bv-field="pincode"   Name="pincode"  placeholder="Pincode">
								  </div>
								  
								  <div class="form-group col-lg-12">
									<label for="city">City</label>
									<input type="text" class="form-control" data-bv-field="city"  Name="city" placeholder="City">
								  </div>
								  
								  <div class="form-group col-lg-12">
									<label for="state">State</label>
									<input type="text" class="form-control" data-bv-field="state" Name="state"  placeholder="State">
								  </div>

								  <div class="form-group col-lg-12">
									<label for="country">Country</label>
									<input type="text" class="form-control" data-bv-field="country"  Name="country"  placeholder="Country">
								  </div>
								  
								  <div class="mb-3 col-lg-12">
									<label >Type Of Address</label><br>
									<div class="custom-control custom-radio custom-control-inline">
									  <input id="1" name="address_type" value="1" class="custom-control-input" checked=""  type="radio">
									  <label class="custom-control-label" for="1">Home</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
									  <input id="2" name="address_type" value="2" class="custom-control-input"  type="radio">
									  <label class="custom-control-label" for="2">Office</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
									  <input id="3" name="address_type" value="3" class="custom-control-input" type="radio">
									  <label class="custom-control-label" for="3">Other</label>
									</div>
								  </div>
								  
								  </div>
								  
								  <button class="btn btn-primary" type="submit">Submit</button>
							</form>
						  
				</div>
			</div>
		</div>
	</div>
	
	<!-- update address modal -->
	<div id="update_address_modal" class="modal fade" >
		<div class="modal-dialog modal-dialog-centered" >
			<div class="modal-content">
				<form id="address_data_form" action="<?=base_url()?>Account/update_address" method="post">
					<div class="modal-header">
						<h5 class="modal-title">Update Address</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
					</div>
				
						<div class="modal-body" id="address_data">
							<input type="hidden" name="address_id" id="address_id">
							<div class="row">
							  <div class="form-group col-lg-12">
								<label for="name">Full Name</label>
								<input type="text" class="form-control" data-bv-field="name" id="name"  Name="name"  placeholder="Full Name">
							  </div>
							  
							  <div class="form-group col-lg-12">
								<label for="contact">Mobile Number</label>
								<input type="number" class="form-control" data-bv-field="contact" id="contact"  Name="contact"  placeholder="Mobile Number">
							  </div>
							  
							  <div class="form-group col-lg-12">
								<label for="address1">Address</label>
								<input type="text" class="form-control" data-bv-field="address1" id="address1" Name="address1" placeholder="Address (Home No, Building, Street, Area)">
								<input type="text" class="form-control" data-bv-field="address2" id="address2" Name="address2" placeholder="Address Line 2">
							  </div>
							 
							  <div class="form-group col-lg-12">
								<label for="pincode">Pincode</label>
								<input type="number" class="form-control" data-bv-field="pincode" id="pincode"  Name="pincode"  placeholder="Pincode">
							  </div>
							  
							  <div class="form-group col-lg-12">
								<label for="city">City</label>
								<input type="text" class="form-control" data-bv-field="city" id="city"  Name="city" placeholder="City">
							  </div>
							  
							  <div class="form-group col-lg-12">
								<label for="state">State</label>
								<input type="text" class="form-control" data-bv-field="state" id="state" Name="state" placeholder="State">
							  </div>

							  <div class="form-group col-lg-12">
								<label for="country">Country</label>
								<input type="text" class="form-control" data-bv-field="country" id="country" Name="country" placeholder="Country">
							  </div>
							  
							  <div class="mb-3 col-lg-12">
								<label >Type Of Address</label><br>
								<div class="custom-control custom-radio custom-control-inline">
								  <input id="Home" name="address_type" value="1" class="custom-control-input" checked="" type="radio">
								  <label class="custom-control-label" for="Home">Home</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
								  <input id="Office" name="address_type" value="2" class="custom-control-input"  type="radio">
								  <label class="custom-control-label" for="Office">Office</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
								  <input id="Other" name="address_type" value="3" class="custom-control-input"type="radio">
								  <label class="custom-control-label" for="Other">Other</label>
								</div>
							  </div>
							  
							  </div>
							  
							  <button class="btn btn-primary" type="submit">Submit</button>
					</div>
				</form>	
			</div>
		</div>
	</div>
<script>
			$("#address_data_form").validate(
			{
				rules: {
					name: {
						required: true,
					},
					address1: {
						required: true,
					},
					pincode: {
						required: true,
					},
					contact: {
					  required: true,
						minlength: 10,
						maxlength:10,
					},
					city: {
						required: true,
					},
					state: {
						required: true,
					},	
					country: {
						required: true,
					},	
					address_type: {
						required: true,
					},				
				},
		   
			messages: 
			{
					name: '<p style="color:red;"> *Please Enter Full Name</p>',
					address1: '<p style="color:red;"> *Please Enter Address</p>',
					pincode: '<p style="color:red;"> *Please Enter Pincode</p>',
					contact: {
						required: '<p style="color:red;"> *Please Enter Phone number</p>',
						minlength: '<p style="color:red;"> *Phone number must be of 10 Digits</p>',
						maxlength:'<p style="color:red;"> *Phone number must be of 10 Digits</p>',
					},
					city: {
						required: '<p style="color:red;"> *Please Enter City</p>',
					},
					state: '<p style="color:red;"> *Please Enter State</p>',		
					country: '<p style="color:red;"> *Please Enter Country</p>',		
					address_type: '<p style="color:red;"> *Please Select Address Type</p>',		
				},
			  
			submitHandler: function(form) {
				form.submit();
			}
		});


</script>	

<script>
			$("#insert_address_form").validate(
			{
				rules: {
					name: {
						required: true,
					},
					address1: {
						required: true,
					},
					pincode: {
						required: true,
					},
					contact: {
					  required: true,
						minlength: 10,
						maxlength:10,
					},
					city: {
						required: true,
					},
					state: {
						required: true,
					},	
					country: {
						required: true,
					},	
					address_type: {
						required: true,
					},				
				},
		   
			messages: 
			{
					name: '<p style="color:red;"> *Please Enter Full Name</p>',
					address1: '<p style="color:red;"> *Please Enter Address</p>',
					pincode: '<p style="color:red;"> *Please Enter Pincode</p>',
					contact: {
						required: '<p style="color:red;"> *Please Enter Phone number</p>',
						minlength: '<p style="color:red;"> *Phone number must be of 10 Digits</p>',
						maxlength:'<p style="color:red;"> *Phone number must be of 10 Digits</p>',
					},
					city: {
						required: '<p style="color:red;"> *Please Enter City</p>',
					},
					state: '<p style="color:red;"> *Please Enter State</p>',		
					country: '<p style="color:red;"> *Please Enter Country</p>',		
					address_type: '<p style="color:red;"> *Please Select Address Type</p>',		
				},
			  
			submitHandler: function(form) {
				form.submit();
			}
		});


</script>		
<script>
function edit_model(id){
		
		$.ajax({
			url:'<?php echo base_url(); ?>Account/get_single_address/'+id,
			method:"POST", 
			data:{  }, 
			dataType: 'json',
			success:function(response)
			{  
				$("#address_id").val(response.address_id);
				$("#name").val(response.name);
				$("#contact").val(response.contact);
				$("#address1").val(response.address1);
				$("#address2").val(response.address2);
				$("#pincode").val(response.pincode);
				$("#city").val(response.city);
				$("#state").val(response.state);
				$("#country").val(response.country);
				if (response.address_type == 1){
					$( "#Home" ).prop( "checked", true );
				} else if(response.address_type == 2){
					$( "#Office" ).prop( "checked", true );
				}else if(response.address_type == 3){
					$( "#Other" ).prop( "checked", true );
				}
				//$("#address_data").html(response);
				$("#update_address_modal").modal('show');
				
				

			},
			error: function(e){ 
				//alertify.error("Somthing Wrong");
				console.log(e);
			} 
		});
	}
</script>