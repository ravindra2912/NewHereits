<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Copyright Policy</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Home</a></li>
					<li class="breadcrumb-item active"><?php echo $main_content; ?></li>
				</ol>
			</div>
        </div>
    </div>
</div>

 <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
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
			<form action="<?php base_url(); ?>Setting_master/update_copyright_Policy" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?= $details->id ?>" />
				<div class="card-body pad">
				  <div class="mb-3">
					<textarea name="copyright" class="textarea" placeholder="Place some text here"
							  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?= $details->copyright ?></textarea>
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




	