<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Banner</h1>
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
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Banner Listing</h3>
					<a href="#" class="btn btn-md btn-success" data-toggle="modal" data-target="#add_model" style="float: right;"><i class="fas fa-plus" style="font-size: 15px;"></i></a>
				</div>
			</div>
        </div>
	</div>
</section>

<section class="content m-hide">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<table id="Product_table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="text-center table_img"><i class="far fa-image" style="font-size: 25px;"></i></th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>	
							<?php foreach($Banners as $val){ ?>
								<tr>
									<td class="text-center table_img" style="padding: .20rem; vertical-align: unset;"><img src="<?php echo base_url().$val->image_url; ?>" style="max-height: 230px;width: auto;"></td>
									<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a href="<?= base_url() ?>Setting/delete_banner/<?= $val->id ?>"  style="color: red;padding-right: 7px;"><i class="fas fa-trash-alt"></i></a></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					</div>
				</div>
			</div>
        </div>
	</div>
</section>

<div class="modal fade" id="add_model" >
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<form id="insert" action="<?= base_url() ?>Setting/add_banner" method="POST" enctype="multipart/form-data" >
				<div class="modal-header">
					<h4 class="modal-title">Add Banner</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="card-body">
						<div class="row">
						
							<div class="col-12">
								<div class="form-group">
									<label>Image</label>
									<input type="file" name="banner_image" class="form-control" placeholder="banner" required>
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





	