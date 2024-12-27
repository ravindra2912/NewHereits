<?php $store_subscription = $this->Mdl_common->get_store_subscription();?>
<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Store Categories</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item onclick-load"><a href="<?php echo base_url(); ?>Store_dashboard">Home</a></li>
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
					<input type="hidden" id="type" value="<?= $type ?>"/>
					<h3 class="card-title" id="service_page">Store Service Categories</h3>
					<h3 class="card-title" id="product_page">Store Product Categories</h3>
					<a onclick="get_suggestion()" class="btn btn-md btn-success" style="float: right;"><i class="fas fa-plus" style="font-size: 15px;"></i>Add Category</a>
					<script>
						if (<?= $type ?> == 1){
								 $('#service_page').hide();
								 $('#product_page').Show();
						} else if (<?= $type ?> == 2){
								 $('#product_page').hide();
								 $('#service_page').Show();
								
						} 
					</script>	
				</div>
				<div class="card-body">
					<table id="store_category" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="text-center">Image</th>
								<th class="text-center">Category Name</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>	
						</tbody>
					</table>
				</div>
			</div>
        </div>
	</div>
</section>

<div class="modal fade" id="modal_suggestion">
    <div class="modal-dialog modal-lg">
		<div class="modal-content">
            <div class="modal-header">
				<h4 class="modal-title">Category List</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
            </div>
            <div class="modal-body">
				<div class="row" style="padding: 21px 21px 0px 23px;">
					<div class="col-md-12 col-12" style="text-align: end;">
						<div id="example1_filter" class="dataTables_filter">
							<input type="search" name="search" id="search" class="form-control form-control-sm" placeholder="Search" aria-controls="example1">
						</div>
					</div>
				</div>
				<table id="suggestion_table" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center">Category</th>
							<th class="text-center">Add</th>
						</tr>
					</thead>
						<tbody>	
						</tbody>
					</table>
            </div>
            <div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
		</div>
	</div>
</div>

	


<script>
	
	get_data();
	//Get Table Data
	function get_data(){
		var type = $('#type').val();
		$.ajax({
				url:'<?php echo base_url(); ?>Store_category/get_store_category_data',
				method:"POST",
				data:{ type: type }, 
				//dataType: 'json',
				beforeSend:function(response)
				{ 
					document.getElementById("load").style.visibility = "unset"; 
				},
				success:function(response)
				{  
					//alert(response); 
					//$('#pagination').html(response.pagination);
					$('#store_category tbody').html(response);
					//createTable(response.result,response.row);
					document.getElementById("load").style.visibility = "hidden"; 
				},
				error: function(e){ 
					//alertify.error("Somthing Wrong");
					console.log(e);
					document.getElementById("load").style.visibility = "hidden"; 
				} 
			});
	}
	
	//Search On Text Change
	$(document).ready(function(){
		$("#search").on("input", function(){
			get_suggestion()
		});
	});
	//Get category suggestion
	function get_suggestion(){
		var type = $('#type').val();
		$.ajax({
				url:'<?php echo base_url(); ?>Store_category/get_suggestion_category_data',
				method:"POST",
				data:{ search:$('#search').val(), type:type }, 
				//dataType: 'json',
				beforeSend:function(response)
				{ 
					document.getElementById("load").style.visibility = "unset"; 
				},
				success:function(response)
				{  
					//alert(response); 
					$('#modal_suggestion').modal('show');
					$('#suggestion_table tbody').html(response);
					document.getElementById("load").style.visibility = "hidden"; 
				},
				error: function(e){ 
					//alertify.error("Somthing Wrong");
					console.log(e);
					document.getElementById("load").style.visibility = "hidden"; 
				} 
			});
	}	

	//get single service parent Category Modal
	function add_category(id){
		$.ajax({
			url:'<?php echo base_url(); ?>Store_category/add_category_to_store_cat',
			method:"POST", 
			data:{ id:id }, 
			beforeSend:function(response)
			{ 
				document.getElementById("load").style.visibility = "unset"; 
			},
			success:function(data)
			{  
				if(data == '1'){
					$("#store-cat-"+id).remove();
					alertify.success('Category Add Successfully');
					get_data();
				}else if(data == '0'){
					alertify.error("Category Exist In Your Store");
				}else{
					alertify.error("Somthing Wrong");
				}
				document.getElementById("load").style.visibility = "hidden"; 
			},
			error: function(e){ 
				alertify.error("Somthing Wrong");
				console.log(e);
				document.getElementById("load").style.visibility = "hidden"; 
			} 
		});
	}	

	//delete Store Category
	function delete_Store_category(category_id){
		var result = confirm("Warning , If You Delete This Category Yo need to Re-Select Categores In Product, Otherwise Your Product Will Remain In-ACtive");
		if (result) { 

			$.ajax({
				url:'<?php echo base_url(); ?>Store_category/delete_Store_category',
				method:"POST", 
				data:{ category_id:category_id },
				beforeSend:function(response)
				{ 
					document.getElementById("load").style.visibility = "unset"; 
				},
				success:function(data)
				{  
					alertify.success("Delete Successfully");
					$('#cat-'+category_id).remove();
					document.getElementById("load").style.visibility = "hidden"; 
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					document.getElementById("load").style.visibility = "hidden"; 
				} 
			});
		}
	}
	
	
</script>	

