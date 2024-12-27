
<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Service Charges</h1>
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
	<div class="row">
		<div class="col-12 col-sm-4">
			<div class="card">
              <div class="card-header">
                <h3 class="card-title">Service Charges </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="<?= base_url() ?>Store_service_charge/update" style="border-top: 3px solid #007bff;">
                <div class="card-body">
				
					
					<div class="form-group">
						<div class="custom-control custom-checkbox">
							<input class="custom-control-input" type="checkbox" id="service_to_address" name="service_to_address" value="1" onchange="check_service()" <?php if($store_info->service_to_address == 1){echo 'checked=""';} ?> >
							<label for="service_to_address" class="custom-control-label">click on check box if you provide Service to customer Address</label>
                        </div>
					</div>
				
					<div <?php if($store_info->service_to_address == 0){echo 'style="display: none;"';} ?> id="service">
					  <div class="form-group">
						<label for="exampleInputEmail1">Visiting Charge</label>
						<input type="number" class="form-control" name="service_charge" value="<?= $store_info->service_charge ?>" placeholder="Visiting Charge">
					  </div>
					  <div class="form-group">
						<label for="exampleInputPassword1">Minimum Cart Amount For Free Service</label>
						<input type="number" class="form-control" name="minimum_service_cart_amount" value="<?= $store_info->minimum_service_cart_amount ?>" placeholder="Minimum Cart Amount For Free Inspection">
					  </div>
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
        </div>
		
		<div class="col-12 col-sm-4">
			<div class="card">
              <div class="card-header">
                <h3 class="card-title">Inspection Charges </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="<?= base_url() ?>Store_service_charge/update" style="border-top: 3px solid #007bff;">
                <div class="card-body">
				
					<div class="form-group">
						<label for="exampleInputEmail1">Inspection Charge</label>
						<input type="number" class="form-control" name="inspection_charge" value="<?= $store_info->inspection_charge ?>" placeholder="Inspection Charge">
					</div>
										
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
        </div>
	</div>
</section>


<script>
	
	function check_service(){
		var lfckv = document.getElementById("service_to_address").checked;
		if(lfckv){
			$('#service').show();
		}else{
			$('#service').hide();
		}
	}
	
	
</script>

