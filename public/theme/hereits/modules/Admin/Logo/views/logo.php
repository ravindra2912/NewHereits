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
                <h3 class="card-title">Web Logo</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             <div class="col-sm-12">
				<div class="form-group" style="text-align: center;">
					<img src="<?php echo base_url();?>uploads/logo/<?php echo $logo->image; ?>" width="200" alt="RAJ CONSULT">
				</div>
			  </div> 
				<div class="card-footer">
                  <a class="btn btn-primary" href="#" data-target="#change_logo" data-toggle="modal"><span>Change Logo</span></a>
                </div>
            </div>
			</div>
			
			<div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Browser Logo</h3>
              </div>
			  <div class="col-sm-12">
				<div class="form-group" style="text-align: center;">
					<img src="<?php echo base_url();?>uploads/logo/<?php echo $tab_logo->image; ?>" width="200" alt="RAJ CONSULT">
				</div>
			  </div>
                <div class="card-footer">
                  <a class="btn btn-primary" href="#" data-target="#change_tab_logo" data-toggle="modal"><span>Change Logo</span></a>
                </div> 
            </div>
			</div>
        </div>
      </div>
    </section>
		  
		
		  
          
       
		  
	
	<!-- Model For main Logo -->
	<div class="modal fade" id="change_logo">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Change Logo</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
			<form id="new_service" enctype="multipart/form-data" method="post">
				<div class="modal-body">
				  <label for=""> Image </label>
				<input class="form-control" name="logo" placeholder="Select Image" type="file">
				</div>
				<div class="modal-footer justify-content-between">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  <button type="submin" class="btn btn-primary">Save changes</button>
				</div>
			</form>
          </div>
        </div>
      </div>
	
		<!-- Model For tab Logo -->
		<div class="modal fade" id="change_tab_logo">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Change Browser Logo</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
			<form id="new_service" enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/Logo/change_tab_logo" method="post">
				<div class="modal-body">
				   <label for=""> Image </label>
				<input class="form-control" name="logo" placeholder="Select Image" type="file">
				</div>
				<div class="modal-footer justify-content-between">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  <button type="submin" class="btn btn-primary">Save changes</button>
				</div>
			</form>
          </div>
        </div>
      </div>
		
		
		
	