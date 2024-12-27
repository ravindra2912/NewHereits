
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
              <li class="breadcrumb-item active">Product Child Category List</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
	
	<section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
                <a href="#" class="btn btn-md btn-success" data-toggle="modal" data-target="#add_model">Add Category</a>
			</div>
			
			
			
            <!-- /.card-header -->
            <div class="card-body">
				<div class="row">
					<!-- div class="col-sm-12 col-md-3">
						<div class="dataTables_length" id="example1_length">
							<label>
								<select name="example1_length" aria-controls="example1" class="custom-select custom-select-sm form-control form-control-sm">
									<option value="10">10</option>
									<option value="25">25</option>
									<option value="50">50</option>
									<option value="100">100</option>
								</select>
							</label>
						</div>
					</div -->
					<div class="col-sm-12 col-md-2">
						<div class="dataTables_length" >
							<label>Status : </label>
							<select onchange="get_data(0)" name="status" id="status" class="custom-select custom-select-sm form-control form-control-sm">
								<option value="">All</option>
								<option value="1">Active</option>
								<option value="0">In-Active</option>
							</select>
						</div>
					</div>
					<div class="col-sm-12 col-md-4">
						<div class="dataTables_length">
							<label>Prent Category : </label>
							<select onchange="get_data(0)" name="parent_category" id="parent_category" class="custom-select custom-select-sm form-control form-control-sm select2">
								<option value="">Select Parent Category</option>
								<?php foreach($category_data as $val){ 
									echo '<option value="'.$val->category_id.'">'.$val->category_name.'</option>';
								}?>
							</select>
						</div>
					</div>
					<div class="col-sm-12 col-md-6" style="text-align: end;">
						<div id="example1_filter" class="dataTables_filter">
							<label>
								<label>&nbsp;</label>
								<input type="search" name="search" id="search" class="form-control form-control-sm" placeholder="Search" aria-controls="example1">
							<label>
						</div>
					</div>
				</div>
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th style="text-align: center;"> Image </th>
                  <th style="text-align: center;">Child Category </th>
				  <th style="text-align: center;">Parent Category</th>
                  <th style="text-align: center;"> Status </th>
				  <th style="text-align: center;"> Actions </th>
                </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
			  
			    <!-- Paginate -->
					<div style='margin-top: 10px;' id='pagination' class="pagination"></div>
            </div>
            <!-- /.card-body -->
          </div>
		</div>
      </div>
    </section>	
	
	<div class="modal fade" id="update_modal" >
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
		  <form id="update" method="POST" enctype="multipart/form-data" >
            <div class="modal-header">
              <h4 class="modal-title">Update Product Child Category</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="service_data">
              
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save Change</button>
            </div>
			 </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
	  
	 
	
	<div class="modal fade" id="add_model" >
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
		  <form id="insert" method="POST" enctype="multipart/form-data" >
			<input type="hidden" name="category_type" value="1" />
            <div class="modal-header">
              <h4 class="modal-title">Add Product Child Category</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
                <div class="card-body">
					<div class="row">
						<div class="col-4">
							<div class="form-group">
								<label>Image</label>
								<input type="file" name="category_image" class="form-control" placeholder="Category Name">
							</div>
						</div>
						
						<div class="col-4">
							<div class="form-group">
								<label>Parent Category</label>
								<select name="parent_category" class="form-control select2" placeholder="Category Name" style="width: 100%;">
									<option value="">Select Parent Category</option>
								<?php foreach($category_data as $val){ 
									echo '<option value="'.$val->category_id.'">'.$val->category_name.'</option>';
								}?>
							  </select>
							</div>
						</div>
						<div class="col-4">
							<div class="form-group">
								<label>Category Name</label>
								<input type="text" name="category_name" id="category_name" class="form-control" placeholder="Category Name" required>
							</div>
						</div>
						
						<div class="col-4">
							<div class="form-group">
								<label>Category Tags</label>
								<input type="text" name="category_tag" class="tags_input" placeholder="Category Tags">
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
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
	  

<script>
$(function(){
	
	$.ajax({
		url: '<? echo base_url(); ?>Package_management/get_tag',
		type: "POST",
		data:  {tag:'' },
		dataType: "json",
		success: function(res)
		{
			var category_tag = [];
			 //alert(res);
			for (var i = 0; i < res.length; i++) {
			  category_tag.push(res[i].tag);
			}
			
			$(".tags_input").tagComplete({
			
				keylimit: 1,
				hide: false,
				autocomplete: {
					data: category_tag
				}
		});
		},
		error: function(e){ 
			alert('Somthing Wron');
			console.log(e);
		}           
	});

	
});
</script>

<script>
	var insert = 0;
	//Insert Service Parent Category
	$(document).ready(function (e) {
	 $("#insert").on('submit',(function(e) {
	  e.preventDefault();
	  if ($( "#insert" ).validate().valid() && insert == 0) {
		  $.ajax({
			url: '<?php echo base_url(); ?>Category_management/insert_child_category',
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			beforeSend : function(){ 
				insert = 1;
			},
			success: function(data){
				alertify.success('Add Successfully');
				document.getElementById("insert").reset();
				$('#add_model').modal('hide');
				insert = 0;
				get_data(0);
			},
			error: function(e){ 
				alertify.error("Somthing Wrong");
			}           
		});
	  }
	 }));
	}); 

	// Detect pagination click
     $('#pagination').on('click','a',function(e){
       e.preventDefault(); 
       var pageno = $(this).attr('data-ci-pagination-page');
       get_data(pageno);
     });
	 
	//Search On Text Change
	$(document).ready(function(){
		$("#search").on("input", function(){
			get_data(0)
		});
	});
	
	get_data(0);
	//Get Table Data
	function get_data(pagno){
		//alert(pagno);
		var search = $('#search').val();
		var status = $('#status').val();
		var parent_category = $('#parent_category').val();
		$.ajax({
				url:'<?php echo base_url(); ?>Category_management/get_child_category_data/'+pagno,
				//method:"POST", 
				type: 'POST',
				data:{ search:search, status:status, parent_category:parent_category, category_type:1 }, 
				dataType: 'json',
				success:function(response)
				{  
					//alert(response); 
					$('#pagination').html(response.pagination);
					$('#example2 tbody').html(response.result);
					//createTable(response.result,response.row);
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
				} 
			});
	}	

	//get single service parent Category Modal
	function edit_model(id){
		$.ajax({
			url:'<?php echo base_url(); ?>Category_management/get_single_child_cat',
			method:"POST", 
			data:{ id:id, category_type:1 }, 
			success:function(data)
			{  
				//alert(data); 
				$("#service_data").html(data);
				$("#update_modal").modal('show');
			},
			error: function(e){ 
				alertify.error("Somthing Wrong");
			} 
		});
	}	

	
	//Update Service Parent Category
	var update = 0;
	$(document).ready(function (e) {
	 $("#update").on('submit',(function(e) {
	  e.preventDefault();
	  
		if ($( "#update" ).valid() && update == 0) {
			
			$.ajax({
				url: '<?php echo base_url(); ?>Category_management/update_child_category',
				type: "POST",
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				beforeSend : function(){ 
					update = 1;
				},
				success: function(data){
					alertify.success('Update Successfully');
					$('#update_modal').modal('hide');
					$('#tr-'+$('#update_id').val()).html(data);
					update = 0;
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
				}          
			});
		}
	 }));
	});
	
	//delete Service Parent Category
	function deletes(id){
		var result = confirm("Want to delete?");
		if (result) { 

			$.ajax({
				url:'<?php echo base_url(); ?>Category_management/deletes_child_category',
				method:"POST", 
				data:{ id:id },
				success:function(data)
				{  
					alertify.success("Delete Successfully");
					$('#tr-'+id).remove();
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
				} 
			});
		}
	}
</script>	

<script>

	$('#insert').validate({
		rules:{
			parent_category:{
				required:true,
			},
			category_name:{
				required:true,
				remote:{
                    url:'<?php echo base_url(); ?>Category_management/child_category_exists',
                    type:'post',
                    data:{category_name:function(){ return $("#category_name").val(); },category_type:1}
				}
			},
			
		},
		messages:{
			category_name: {
				required: '<p style="color: red;">Please enter Category Name.</p>',
				remote: '<p style="color: red;">Category already exist.</p>',
			},
			parent_category: {
				required: '<p style="color: red;">Please Select Parent Category.</p>',
			},
		},
	});
	
	$('#update').validate({
		rules:{
			parent_category:{
				required:true,
			},
			category_name:{
				required:true,
				remote:{
                    url:'<?php echo base_url(); ?>Category_management/child_category_exists',
                    type:'post',
                    data:{category_name:function(){ return $("#update_category_name").val(); },category_id:function(){ return $("#update_id").val(); },category_type:1}
				}
			},
			category_status:{
				required:true,
			},
			
		},
		messages:{
			category_name: {
				required: '<p style="color: red;">Please enter Category Name.</p>',
				remote: '<p style="color: red;">Category already exist.</p>',
			},
			parent_category: {
				required: '<p style="color: red;">Please Select Parent Category.</p>',
			},
			category_status: {
				required: '<p style="color: red;">Please Select Category Status.</p>',
			},
		},
	});
</script>	
