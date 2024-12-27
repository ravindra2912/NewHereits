<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Add Products </h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_dashboard">Home</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_products">Products_list</a></li>
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
										<label>Parent Category </label>
										<select class="form-control select2" id="store_parent_category" name="store_parent_category" onchange="activesearch()" id="store_parent_category" style="width: 100%;">
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
												alert("Please Add category From Product Category to add products")
												document.getElementById("store_parent_category").disabled = true;
											</script>
											<a href="<?php echo base_url()?>Store_category/Product_category" class="btn btn-md btn-success">Add Category</a>
										<?php } ?>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Search Product</label>
										<input type="text" name="search_product" id="search_product" onClick="return validatecategories()" class="form-control" placeholder="Search Product">
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
							<!-- pagination -->
<div class="container-fluid">
		<div class="card" style="background-color: transparent;"> 
			<div class="row" >
				<div class="col-12" style="box-shadow: 2px 2px 20px rgba(107, 128, 168, 0.6); background-color: white; margin-top: -20px;">
					<div id="pagination" class="pagination">
					</div>
				</div>
			</div>
       </div>
</div>
							<div class="card-footer">
								<a href="<?php echo base_url(); ?>Store_products/insert_form" id="add_product" class="btn btn-primary" style="display: none;">Add New Product</button>
							</div>
						
					</div>
				</div>
			</div>
        </div>
	</div>
</section>
    
</section>
<!-- validation -->
<script>

//Search On Text Change
	$(document).ready(function(){
		$("#search_product").on("input", function(){
			get_search()
		});
	});
	// Detect pagination click
     $('#pagination').on('click','a',function(e){
       e.preventDefault(); 
       var pageno = $(this).attr('data-ci-pagination-page');
       get_search(pageno);
     });
	 
	//Search On Text Change
	$(document).ready(function(){
		$("#search").on("input", function(){
			get_search(0)
		});
	});
	
	get_search(0);
	//Get Table Data
//delete Service Parent Category
	function get_search(pagno){
		var store_parent_category = $('#store_parent_category').val();
		var search = $('#search_product').val();

			$.ajax({
				url:'<?php echo base_url(); ?>Store_products/ajax_search_product/'+pagno,
				method:"POST", 
				dataType: 'json',
				data:{ search:search, store_parent_category:store_parent_category },
				success:function(data)
				{  
					console.log(data);
					if(data.status == 1){
						$('#add_product').show();
						$('#Product_table tbody').html(data.table_view);
						$('#pagination').html(data.pagination);
					}else{
						$('#Product_table tbody').html('');
						$('#add_product').show();
					}
					
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					console.log(e);
				} 
			});
	}
	
	function validatecategories() {
	var store_parent_category = $('#store_parent_category').val();
		if (store_parent_category == "") {
			document.getElementById("error_dis").innerHTML = "* Select Category First to Search";
			document.getElementById("search_product").disabled = true;
			return false;
		}
	}
	function activesearch() {
	var store_parent_category = $('#store_parent_category').val();
		if (store_parent_category != "") {
			document.getElementById("error_dis").innerHTML = " ";
			document.getElementById("search_product").disabled = false;
			get_search();
			//$('#search_product').val('');
			return false;
		}
	}
</script>


	

	