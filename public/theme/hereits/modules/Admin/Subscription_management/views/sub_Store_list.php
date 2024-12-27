
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
									<option value="0">Pending for Payment</option>
									<option value="1">Active</option>
									<option value="2">Expired</option>
								</select>
						</div>
					</div>
					
					<div class="col-md-3 col-4" >
						<div class="dataTables_length" id="example2_length">
								<label>By Store : </label>
								<select  name="is_store" onchange="get_data(0)" id="is_store" style="font-size: 124%" class="custom-select custom-select-sm form-control form-control-sm">
										<option value="">All</option>
											<?php
														foreach($is_store as $row) { ?>
													
														 <option value="<?= $row->store_id ?>" <?php if($row->store_id == $getstoreid){ echo 'selected';} ?> > <?= $row->Store_name ?></option>;
												<?php	}
												?>
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
                  <th style="text-align: center;"> Store Subscription Id </th>
                  <th style="text-align: center;"> Store Name </th>
                  <th style="text-align: center;"> Subscription Id </th>
                  <th style="text-align: center;"> Subscription Plan </th>
                  <th style="text-align: center;"> Subscription Type </th>
                  <th style="text-align: center;"> Duration </th>
                  <th style="text-align: center;"> Start Date  </th>
                  <th style="text-align: center;"> End Date  </th>
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
		var is_store = $('#is_store').val();
		$.ajax({
				url:'<?php echo base_url(); ?>Subscription_management/get_store_data/'+pagno,
				//method:"POST", 
				type: 'POST',
				data:{ search:search, status:status, is_store:is_store}, 
				dataType: 'json',
				success:function(response)
				{  
					//alert(response); 
					$('#pagination').html(response.pagination);
					$('#example2 tbody').html(response.table_view);
					//createTable(response.result,response.row);
				},
				error: function(e){ 
					//alertify.error("Somthing Wrong");
				} 
			});
	}	

	
	
	
</script>	

	