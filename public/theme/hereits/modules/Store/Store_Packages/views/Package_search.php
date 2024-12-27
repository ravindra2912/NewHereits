<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Add Packages </h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_dashboard">Home</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_products">Package_list</a></li>
					<li class="breadcrumb-item active"><?php echo $main_content; ?></li>
				</ol>
			</div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					
					<div class="card-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Parent Category</label>
										<select class="form-control select2" name="package_parent_category" onchange="activesearch()" id="package_parent_category" style="width: 100%;">
											<option value="">Select Parent Category</option>
											<?php
											  	foreach($parent_cat_data as $val){
													echo '<option value="'.$val->category_id.'">'.$val->category_name.'</option>';
												}
											?>
										</select>
										<p id="error_dis" class="error"></p>
										<?php if(empty($parent_cat_data)) {?>
											<script>
												alert("Please Add category From Service Category to add Package/Service")
												document.getElementById("package_parent_category").disabled = true;
											</script>
											<a href="<?php echo base_url()?>Store_category/service_category" class="btn btn-md btn-success">Add Category</a>
										<?php } ?>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Search Packages</label>
										<input type="text" name="search_package" id="search_package" onClick="return validatecategories()" class="form-control" placeholder="Search Product">
									</div>
								</div>
								<div class="col-sm-12">
									<table id="Product_table" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th class="text-center table_img"><i class="far fa-image" style="font-size: 25px;"></i></th>
												<th class="text-center">Name</th>
												<th class="text-center">Action</th>
											</tr>
										</thead>
										<tbody>	
										</tbody>
									</table>
								</div>
								
								
								
							</div>
							<div class="card-footer">
								<a href="<?php echo base_url(); ?>Store_Packages/insert_form" id="add_package" class="btn btn-primary" style="display: none;">Add New Package</button>
							</div>
						
					</div>
				</div>
			</div>
        </div>
	</div>
</section>

<!-- validation -->
<script>

//Search On Text Change
	$(document).ready(function(){
		$("#search_package").on("input", function(){
			get_search()
		});
	});

	function get_search(){
		var package_parent_category = $('#package_parent_category').val();
		var search = $('#search_package').val();

			$.ajax({
				url:'<?php echo base_url(); ?>Store_Packages/ajax_search_package',
				method:"POST", 
				dataType: 'json',
				data:{ search:search, package_parent_category:package_parent_category },
				success:function(data)
				{  
					//console.log(data);
					if(data.status == 1){
						$('#add_package').show();
						$('#Product_table tbody').html(data.table_view);
					}else{
						$('#Product_table tbody').html('');
						$('#add_package').show();
					}
					
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					console.log(e);
				} 
			});
	}
	
	function validatecategories() {
	var package_parent_category = $('#package_parent_category').val();
		if (package_parent_category == "") {
			document.getElementById("error_dis").innerHTML = "* Select Category First to Search";
			document.getElementById("search_package").disabled = true;
			return false;
		}
	}
	function activesearch() {
	var package_parent_category = $('#package_parent_category').val();
		if (package_parent_category != "") {
			document.getElementById("error_dis").innerHTML = " ";
			document.getElementById("search_package").disabled = false;
			get_search();
			$('#search_package').val('');
			return false;
		}
	}
</script>


	

	