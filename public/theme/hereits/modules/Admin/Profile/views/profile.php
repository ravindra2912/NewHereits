<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $left_sidebar; ?></li>
            </ol>
          </div>
        </div>
      </div>
    </section>
	
	<section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Profile</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             <form id="formValidate" action="<?php echo base_url(); ?>index.php/Profile/save_Profile" enctype="multipart/form-data" method="post">
				<input type="hidden" name="id" value="<?php echo $info->id; ?>" />
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" name="name" value="<?php echo $info->name; ?>" required="true" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Email</label>
                    <input type="email" name="email" value="<?php echo $info->email; ?>" class="form-control" required="true">
                  </div>
				  <div class="form-group">
                    <label for="exampleInputPassword1">Contact</label>
                    <input type="number" name="contact" value="<?php echo $info->contact; ?>" class="form-control" required="true">
                  </div>
				  <div class="form-group">
                    <label for="exampleInputPassword1">Address</label>
                    <textarea class="form-control" name="address" rows="3" required="true"><?php echo $info->address; ?></textarea>
                  </div>
				  <div class="form-group">
                    <label for="exampleInputPassword1">About</label>
                    <textarea required="true" class="form-control" name="info" rows="3" ><?php echo $info->info; ?></textarea>
                  </div>
					<h4>Share</h4>
                  <hr>
				  
				  <div class="form-group">
                    <label for="exampleInputEmail1">Facebook Username</label>
                    <input type="text" name="facebook" value="<?php echo $info->facebook; ?>" class="form-control">
                  </div>
				  <div class="form-group">
                    <label for="exampleInputEmail1">Instagram Username</label>
                    <input type="text" name="instagram" value="<?php echo $info->instagram; ?>" class="form-control">
                  </div>
										
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
			</div>
			
			<div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Change Password</h3>
              </div>
             <form id="formValidate_password" action="<?php echo base_url(); ?>index.php/Profile/change_pssword" enctype="multipart/form-data" method="post">
				<input type="hidden" name="id" value="<?php echo $info->id; ?>" />
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="password" data-minlength="6" id="pass" name="password" class="form-control" required="true">
                  </div>
				  <div class="form-group">
                    <label for="exampleInputEmail1">Confirm Password</label>
                    <input type="password" data-minlength="6" id="cpass" name="password" class="form-control" required="true">
                  </div>
                  
										
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button onclick="change_pass()" type="button" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
			</div>
        </div>
      </div>
    </section>
		  
		
		  
	
	
	
	<script>
		function change_pass()
		{	
			if($('#pass').val() == '' ){
				alert('Enter Passwor');
			}
			else if( $('#cpass').val() == ''){
				alert('Enter Confirm Passwor');
			}else if($('#pass').val() != $('#cpass').val())
			{
				alert('Passwor Not Matc');
			}else{
				document.getElementById("formValidate_password").submit();
			}
			
			 
		}
	</script>