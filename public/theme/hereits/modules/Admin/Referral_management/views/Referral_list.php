
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
              <li class="breadcrumb-item active">User List</li>
            </ol>
          </div>
        </div>
      </div>
</section>
	
	<section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
		       <div class="card-body">
				<div class="row">
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
						  <th style="text-align: center;"> Username </th>
						  <th style="text-align: center;"> Refferal Code </th>
						  <th style="text-align: center;"> Total Referal </th>
						  <th style="text-align: center;"> Pending Payments </th>
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
			get_data(0);
		});
	});
	
	get_data(0);
	//Get Table Data
	function get_data(pagno){
		//alert(pagno);
		var search = $('#search').val();
		//var status = $('#status').val();
		//var type = $('#type').val();
		$.ajax({
				url:'<?php echo base_url(); ?>Referral_management/get_user_data/'+pagno,
				//method:"POST", 
				type: 'POST',
				data:{ search:search}, 
				dataType: 'json',
				success:function(response)
				{  
					//alert(response); 
					$('#pagination').html(response.pagination);
					$('#example2 tbody').html(response.result);
					
				},
				error: function(e){ 
					//alertify.error("Somthing Wrong");
				} 
			});
	}	
	
	function pay_all(user_id){
		alert("hbhj");
		$.ajax({
				url:'<?php echo base_url(); ?>Referral_management/pay_all_users/'+user_id,
				//method:"POST", 
				type: 'POST',
				data:{ }, 
				dataType: 'json',
				success:function(response)
				{  
					alertify.success("Paid Successfully");
					get_data(0);
					
				},
				error: function(e){ 
					//alertify.error("Somthing Wrong");
				} 
			});
	}	


</script>	
