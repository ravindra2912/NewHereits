
<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Store Shippment</h1>
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
                <h3 class="card-title">Shippment Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="<?= base_url() ?>Store_Shippment/update_shippment" style="border-top: 3px solid #007bff;">
                <div class="card-body">
				
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" id="delivery" name="delivery" value="1" onchange="check_delivery()" <?php if($store_info->delivery_to_address == 1){echo 'checked=""';} ?> >
                          <label for="delivery" class="custom-control-label">click on check box if you provide home delivery to customer</label>
                        </div>
                  </div>
				  
				  <div <?php if($store_info->delivery_to_address == 0){echo 'style="display: none;"';} ?> id="delivery_to_address">
				  <div class="form-group" >
                    <label for="exampleInputEmail1">Shipping Charge</label>
                    <input type="number" class="form-control" name="shipping_charge" value="<?= $store_info->shipping_charge ?>" placeholder="Shipping Charge">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Minimum Cart Amount For Free Delivery</label>
                    <input type="number" class="form-control" name="minimum_cart_amount" value="<?= $store_info->minimum_cart_amount ?>" placeholder="Minimum Cart Amount For Free Delivery">
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
	</div>
</section>



	


<script>
	
	function check_delivery(){
		var lfckv = document.getElementById("delivery").checked;
		if(lfckv){
			$('#delivery_to_address').show();
		}else{
			$('#delivery_to_address').hide();
		}
	}
	
	
</script>	

