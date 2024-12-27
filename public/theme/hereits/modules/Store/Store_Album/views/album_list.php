<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Album</h1>
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
		<div class="col-12" style="margin-bottom: 10px;">
			<button class="btn btn-md btn-success" data-toggle="modal" data-target="#add_album_model" style="float: right;">
				<i class="fas fa-plus" style="font-size: 15px;"> Add Album</i>
			</button>	
        </div>
	</div>
</section>

<section class="content">
      <div class="container-fluid">
        <div class="row">
		<?php foreach($album as $val){ ?>
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <div class="card-title">
                  <?= $val->album_name ?>
				  
                </div>
				<a href="<?= base_url() ?>Store_Album/delete_album/<?= $val->album_id ?>" style="float: right;margin-right: 8px;">
					<i class="fas fa-trash-alt" style="font-size: 20px;"></i>
				</a>
				<a onclick="update_model(<?= $val->album_id ?>,'<?= $val->album_name ?>')" data-toggle="modal" data-target="#update_album_model" style="float: right;margin-right: 8px;">
					<i class="fas fa-edit" style="font-size: 20px;"></i>
				</a>

              </div>
              <div class="card-body">
                <div class="row">
					<div class="col-sm-2 col-6" onclick="add_image_action(<?= $val->album_id ?>)" style="margin: 0px 0px 20px 0px;box-shadow: 0 0 1px rgba(0,0,0,.105),0 5px 3px rgba(0,0,0,.2);text-align: center;">
						<i class="fas fa-upload" style=" font-size: 75px;color: gray;height: 100px;object-fit: contain;padding-top: 20px;"></i>
						<p style="color: gray;">Add Image</p>
                  </div>
				  
				  
				<?php  foreach($val->imaghes as $img){ ?>
                  <div class="col-sm-2 col-6" id="img-<?= $img->image_id ?>" style="margin: 0px 0px 20px 0px;box-shadow: 0 0 1px rgba(0,0,0,.105),0 5px 3px rgba(0,0,0,.2);text-align: center;">
                    <a href="<?php echo base_url().$img->image_url; ?>" data-toggle="lightbox" data-title="Analog Offers" data-gallery="gallery">
                      <img src="<?php echo base_url().$img->image_url; ?>" class="img-fluid mb-2" alt="Hereits" style="height: 100px;object-fit: contain;"/>
                    </a>
					<div>
						<a href="<?= base_url() ?>Store_Album/delete_image/<?= $img->image_id ?>" onclick="update_model(<?= $val->album_id ?>,'<?= $val->album_name ?>')"  style="color: red;padding-right: 7px;"><i class="fas fa-trash-alt"></i></a>
					</div>
                  </div>
                  <?php }  ?>
                </div>
              </div>
            </div>
          </div>
		<?php } ?>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	<form id="add_img_form" action="<?= base_url() ?>Store_Album/add_img" method="POST" enctype="multipart/form-data" style="display: none;">
		<input type="text" name="album_id" id="album_id" >
		<input type="file"name="image_url[]" id="img" onchange="submit_image_for()" class="form-control" multiple accept="image/*" required >
	</form>


<!-- add album model -->
<div class="modal fade" id="add_album_model" >
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<form id="insert" action="<?= base_url() ?>Store_Album/add_album" method="POST" enctype="multipart/form-data" >
				<div class="modal-header">
					<h4 class="modal-title">Add Album</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="card-body">
						<div class="row">
						
							<div class="col-12">
								<div class="form-group">
									<label>Album Name</label>
									<input type="text" name="album_name" class="form-control" placeholder="Album Name" required>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<label>Image</label>
									<input type="file" name="image_url[]" class="form-control" multiple accept="image/*" required>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
        </div>
	</div>
</div>

<!-- add album images model -->
<div class="modal fade" id="update_album_model" >
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<form id="insert" action="<?= base_url() ?>Store_Album/update_album" method="POST" enctype="multipart/form-data" >
				<div class="modal-header">
					<h4 class="modal-title">Add Offer Image</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="card-body">
						<div class="row">
						
							<div class="col-12">
								<div class="form-group">
									<label>Album Name</label>
									<input type="hidden" name="album_id" id="update_album_id" class="form-control" placeholder="album_id" required>
									<input type="text" name="album_name" id="update_album_name" class="form-control" placeholder="Album Name" required>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
        </div>
	</div>
</div>


<script>
	
	function add_image_action(album_id){
		$('#album_id').val(album_id);
		$('#img').click();
		alert(id);
	}
	
	function submit_image_for(){
		$('#add_img_form').submit();
	}

	function update_model(id, name){
		$('#update_album_id').val(id);
		$('#update_album_name').val(name);
		console.log(id+name);
	}
</script>


	