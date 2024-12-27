<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Site Setting</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_dashboard">Home</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_dashboard">Setting</a></li>
					<li class="breadcrumb-item active"><?php echo $left_sidebar; ?></li>
				</ol>
			</div>
        </div>
    </div>
</div>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-4">
          <div class="card card-outline card-info">
            <div class="card-header">
              <!-- tools box -->
              <div class="card-tools">
                <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                  <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool btn-sm" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove">
                  <i class="fas fa-times"></i></button>
              </div>
              <!-- /. tools -->
            </div>
            <!-- /.card-header -->
			<form action="<?php base_url(); ?>Setting/update_site_setting" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?= $details->id ?>" />
				<div class="card-body pad">
				  <div class="row">
                    <div class="col-sm-12">
                      <!-- select -->
                      <div class="form-group">
                        <label>Site maintenance</label>
                        <select class="form-control" name="maintenance">
                          <option value="1" <?php if($details->maintenance == 1){ echo "selected";} ?> >under maintenance</option>
                          <option value="0" <?php if($details->maintenance == 0){ echo "selected";} ?> >Live</option>
                        </select>
                      </div>
                    </div>
                  </div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
          </div>
        </div>
        <!-- /.col-->
      </div>
      <!-- ./row -->
    </section>




	