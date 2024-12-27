
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
              <li class="breadcrumb-item active">Store List</li>
            </ol>
          </div>
        </div>
      </div>
</section>
	
	<section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
		    <!-- /.card-header -->
            <div class="card-body">
				<div class="row">
					<div class="col-md-3 col-4">
						<div class="dataTables_length" id="example1_length">
							<label>Status : </label>
									<select onchange="get_data(0)" name="status" id="status" class="custom-select custom-select-sm form-control form-control-sm" style="font-size: 14px;">
									<option value="">Select Status</option>
									<option value="0">Pending for Approval</option>
									<option value="1">Approved</option>
									<option value="2">Disapproved</option>
								</select>
						</div>
					</div>
					
					<div class="col-md-3 col-4" id="example1_length">
						<div class="dataTables_length" id="example1_length">
							<label>Type : </label>
									<select onchange="get_data(0)" name="type" id="type" class="custom-select custom-select-sm form-control form-control-sm" style="font-size: 14px;">
									<option value="">Select Status</option>
									<option value="1">Product</option>
									<option value="2">Service</option>
									<option value="3">Both</option>
								</select>
						</div>
					</div>
					
					<div class="col-md-3 col-4"></div>
					<div class="col-md-3 col-4" style="text-align: end;">
						<div id="example1_filter" class="dataTables_filter">
							<label>&nbsp;</label>
							<input type="search" name="search" id="search" class="form-control form-control-sm" placeholder="Search" aria-controls="example1">
						</div>
					</div>
				</div>
				
			<div class="row" style="margin-top: 24px;">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th style="text-align: center;"> Image </th>
                  <th style="text-align: center;"> Store Name </th>
                  <th style="text-align: center;"> Username </th>
                  <th style="text-align: center;"> Rerred by </th>
                  <th style="text-align: center;"> City </th>
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
	
	
	  
	 
	
	
	  



<script>
	

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
		var type = $('#type').val();
		$.ajax({
				url:'<?php echo base_url(); ?>Store_management/get_store_data/'+pagno,
				//method:"POST", 
				type: 'POST',
				data:{ search:search, status:status,type:type }, 
				dataType: 'json',
				success:function(response)
				{  
					//alert(response); 
					$('#pagination').html(response.pagination);
					$('#example2 tbody').html(response.result);
					//createTable(response.result,response.row);
				},
				error: function(e){ 
					//alertify.error("Somthing Wrong");
				} 
			});
	}	

	
	
	//delete Service Parent Category
	function deletes(id){
		var result = confirm("Want to delete?");
		if (result) { 

			$.ajax({
				url:'<?php echo base_url(); ?>Category_management/deletes_parent_category',
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
			category_name:{
				required:true,
				remote:{
                    url:'<?php echo base_url(); ?>Category_management/parent_category_exists',
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
		},
	});
	
	
</script>	