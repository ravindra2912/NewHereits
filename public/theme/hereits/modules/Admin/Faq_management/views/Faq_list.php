
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $main_content; ?></li>
            </ol>
          </div>
        </div>
      </div>
 </section>
 
	
<!--Big Screen -->	
<section class="content m-hide">
	<div class="row">
		<div class="col-12">
			<div class="card">
			<div class="card-header">
					 <a href="<?php echo base_url();?>Faq_management/goto_add_form" class="btn btn-md btn-success" >ADD FAQ</a>
					</div>
				<div class="card-body">
					<table id="Product_table" class="table table-bordered table-striped">
						<thead>
							<tr>
							  <th class="text-center"> ID </th>
							  <th class="text-center"> Question </th>
							  <th class="text-center"> Answer </th>
							  <th class="text-center"> Category </th>
							  <th class="text-center"> Status </th>
							  <th class="text-center"> Actions </th>
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
	
<!-- pagination -->
<section class="content">
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
</section>

<script>
	

	// Detect pagination click
     $('#pagination').on('click','a',function(e){
       e.preventDefault(); 
       var pageno = $(this).attr('data-ci-pagination-page');
       get_data(pageno);
     });
	
	get_data(0);
	//Get Table Data
	function get_data(pagno){
		//alert(pagno);
		$.ajax({
				url:'<?php echo base_url(); ?>Faq_management/get_faq_data/'+pagno,
				//method:"POST", 
				type: 'POST',
				data:{  }, 
				dataType: 'json',
				success:function(response)
				{  
					//alert(response); 
					$('#Product_table tbody').html(response.table_view);
					$('#grid_view').html(response.grid_view);
					$('.pagination').html(response.pagination);
					//createTable(response.result,response.row);
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
					console.log(e);
				} 
			});
	}	

	
	
</script>		
		  
          
       
		  
	
	