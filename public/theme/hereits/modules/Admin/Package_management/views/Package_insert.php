<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>User_management">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $main_content; ?></li>
			  <li class="breadcrumb-item"><a href="#">Package  Update</a></li>
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
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->

          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Package  Insert</h3>
              </div>
               <div class="card-body">
			  
                <form role="form" name="update_form" action='<?php echo base_url(); ?>Package_management/insert_packege' method="POST" enctype="multipart/form-data">
               
					<div class="row">
						<div class="col-sm-12">
							 <div class="uploadimage jstinput common-profile-frames" style="text-align: -webkit-center">
										<label>Click to Change profile</label><span class="error">*</span><br>
										<input type="file"  accept="image/*" name="packege_image" id="file"  onchange="loadFile(event)" style="display: none;">
										<label for="file" style="cursor: pointer;"><img id="output" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTc56kS-t_H0imXgzFZMSZsIYe0TtOyAxU00w&usqp=CAU" style="width:140px; height:140px;"></label><br>
										<script>
											var loadFile = function(event) {
												var image = document.getElementById('output');
												image.src = URL.createObjectURL(event.target.files[0]);
												
											};
										</script>
							</div>	
						</div>
				</div>
				
				<div class="row">
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
					    <label>Package Name :</label> <span class="error">*</span>
                        <input type="text"   name="Package_name" id="Package_name" class="form-control" placeholder="Enter First Name">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Package Price :</label> <span class="error">*</span>
                        <input type="number" class="form-control"  name="packege_price" id="packege_price" placeholder="Enter last Name">
                      </div>
                    </div>
                  
				  
				  <div class="col-sm-4">
					<div class="form-group">
						<label> Package Sale Price :</label> <span class="error">*</span>
						<input type="number" class="form-control"  id="packege_sale_price" name="packege_sale_price" placeholder="Enter ...">
					</div>
                  </div>
				  
				  <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Package Main Category :</label> <span class="error">*</span>
                        <select class="form-control select2" name="main_category" id="main_category" style="width: 100%;">
											<option value="">Select Parent Category</option>
											<?php
												foreach($parent_cat_data as $val){ ?>
													<option value="<?=$val->category_id?>"><?=$val->category_name?></option>
												<?php }	?>
										</select>
                      </div>
                    </div>
					
				  			  
				  <div class="col-sm-4">
					<div class="form-group">
						<label>Package Tags :</label> 
						<input type="text" class='tags_input' value="<?php echo $Package_details->packege_tage;?>" id="packege_tage" name="packege_tage" placeholder="Enter ...">
					</div>
                  </div>
				  
				  <div class="col-sm-4">
					<div class="form-group">
						<label>Package Duration :</label> <span class="error">*</span>
						<select class="form-control" name="packege_duration" id="packege_duration" style="width: 100%;">
							<option value="">Select Hrous</option>
							<?php
							for($i=1; $i<=48; $i++){
								echo '<option value="'.$i.'">'.$i.' Hour</option>';
							}
							?>
						</select>
					</div>
                  </div>
				 
				  <div class="col-sm-4">
					<div class="form-group">
						<label>Package Excludes :</label> 
						<input type="text" class="form-control"  id="packege_excludes" name="packege_excludes" placeholder="Enter ...">
					</div>
                  </div>
				
				  <div class="col-sm-4">
					<div class="form-group">
						<label>Package Includes:</label> 
						<input type="text" class="form-control"  id="packege_includes" name="packege_includes" placeholder="Enter ...">
					</div>
                  </div>
				  
				 <!-- <div class="col-sm-4">
                     
                      <div class="form-group">
                        <label>Package Status :</label> <span class="error">*</span>
                        <select name= "packege_status" class="form-control">
						  <option value="" >Select Status</option>
                          <option value="0" >PENDING FOR APPROVEL</option>
                          <option value="1" >ACTIVE</option>
                          <option value="2" >PAUSE</option>
						                           
                        </select>
                      </div>
                    </div>
				-->
					  <div class="col-sm-10">
						<div class="form-group">
							<label>Package Description:</label> 
							<textarea class="form-control"  id="packege_description" name="packege_description" placeholder="Enter ..." rows="2" cols="100"></textarea>
						</div>
					  </div>
                  
				</div>
			
					<div class="card-footer">
						<button type="submit" name="submit" id="submit" id="submit" class="btn btn-primary">Save</button>
					</div>
					
                </form>
              </div>
              <!-- /.card-body -->
            </div>
    </section>
	

</div> 
</div>
	</div>
	
<script>
$(function(){
	
	$.ajax({
		url: '<? echo base_url(); ?>Package_management/get_tag',
		type: "POST",
		data:  {tag:'' },
		dataType: "json",
		success: function(res)
		{
			var packege_tage = [];
			 //alert(res);
			for (var i = 0; i < res.length; i++) {
			  packege_tage.push(res[i].tag);
			}
			
			$(".tags_input").tagComplete({
			
				keylimit: 1,
				hide: false,
				autocomplete: {
					data: packege_tage
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
	<script>

			// Wait for the DOM to be ready
		$(function() {
			$("form[name='update_form']").validate(
			{
				rules: {
					Package_name: {
					required: true,
					},
					packege_image: {
					required: true,
					},
					
					packege_price: {
					  required: true,
						number: true,
					},
					
					packege_sale_price: {
						required: true,
						  number: true,
					},
								
					main_category: {
						required: true,
					},
						
					packege_duration: {
					  required: true,
					},	
					packege_status: {
					  required: true,
					},	
					
				},
		   
			messages: 
			{
				Package_name: '<p> *Please enter Package name</p>',
				packege_image: '<p> *Please Upload Package image</p>',
					
				packege_price: {
					  required: '<p> *Please enter Package price</p>',
					  number:'<p> *Please enter Numbers only</p>',
				},
				packege_sale_price: {
					  required: '<p> *Please enter Selling price</p>',
					  number:'<p> *Please enter Numbers only</p>',
				},
				main_category: '<p> *Please enter Parent Category</p>',
				packege_duration: '<p> *Please enter Packege duration</p>',
				packege_status:'<p> *Select status</p>',
				
			},
			  
			submitHandler: function(form) {
				form.submit();
			}
		});
	});
	</script>
