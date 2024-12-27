
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $left_sidebar; ?></li>
            </ol>
          </div>
        </div>
      </div>
    </section>
	
	<section class="content">
      <div class="row">
        <div class="col-6">
          <div class="card">
            <div class="card-header">
                <a href="#" class="btn btn-md btn-success" data-toggle="modal" data-target="#add_operator">Add Operator</a>
                           
            </div>
			
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th style="text-align: center;"> Operator Name </th>
				  <th style="text-align: center;"> Status </th>
				  <th style="text-align: center;"> Actions </th>
                </tr>
                </thead>
                <tbody id="operator_data_list">
					
							
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
		</div>
		
		<div class="col-6" id="operator_plans_data_list">
          
		</div>
      </div>
    </section>	
	
	<div class="modal fade" id="update_operator" >
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
		  <form id="update_operator_form" method="POST">
            <div class="modal-header">
              <h4 class="modal-title">Update Operator</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="operator_update_body">
              
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
	
	<div class="modal fade" id="add_operator" >
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
		  <form id="new_operator_form" method="POST" >
            <div class="modal-header">
              <h4 class="modal-title">Add New Operator</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
                <div class="card-body">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label>Operator Name</label>
								<input type="text" name="operator_name" class="form-control" placeholder="Plan Name" required>
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
	  
	  <div class="modal fade" id="add_plan" >
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
		  <form id="new_plan_form" method="POST" >
            <div class="modal-header">
              <h4 class="modal-title">Add New plan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="operator_id" id="operator_id" />
                <div class="card-body">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label>Plan Amount</label>
								<input type="text" name="plan_amount" class="form-control" placeholder="Plan Amount" required>
							</div>
						</div>
						
						<div class="col-12">
							<div class="form-group">
								<label>Info</label>
								<textarea name="info" class="form-control" placeholder="Plan Amount" ></textarea>
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
	
	<div class="modal fade" id="update_plan" >
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
		  <form id="update_plan_form" method="POST">
            <div class="modal-header">
              <h4 class="modal-title">Update Operator</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="plan_update_body">
              
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
get_all_operators();
function get_all_operators(){
	$.ajax({
			url:'<?php echo base_url(); ?>Operator_management/ajex_get_all_operator',
			method:"POST", 
			data:{  }, 
			success:function(data)
			{  
				//alert(data); 
				$("#operator_data_list").html(data);
			}
		});
}

$(document).ready(function (e) {
 $("#new_operator_form").on('submit',(function(e) {
  e.preventDefault();
  
  $.ajax({
        url: '<?php echo base_url(); ?>Operator_management/insert_operator',
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function(){ 
		},
		success: function(data){
			//alert(data);
			get_all_operators();
			$('#add_operator').modal('hide');
		},
		error: function(e){ 
		}          
    });
 }));
}); 

$(document).ready(function (e) {
 $("#update_operator_form").on('submit',(function(e) {
  e.preventDefault();
  
  $.ajax({
        url: '<?php echo base_url(); ?>Operator_management/update_operator',
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function(){ 
		},
		success: function(data){
			//alert(data);
			get_all_operators();
			$('#update_operator').modal('hide');
		},
		error: function(e){ 
		}          
    });
 }));
});  

function Update_operator(id){
	
	$.ajax({
			url:'<?php echo base_url(); ?>Operator_management/ajex_get_single_operator',
			method:"POST", 
			data:{ id:id }, 
			success:function(data)
			{  
				//alert(data); 
				get_all_operators();
				$("#operator_update_body").html(data);
				$("#update_operator").modal('show');
			}
		});
}	

function delete_operator(id){
	var result = confirm("Want to delete?");
	if (result) { 

		$.ajax({
			url:'<?php echo base_url(); ?>Operator_management/ajax_delete_operator',
			method:"POST", 
			data:{ id:id },
			success:function(data)
			{  
				$('#operator-'+id).remove();
				//location.reload(); 
				
				
			}
		});
	}
}
</script>	
<script>
function get_operator_plans(id){
	$.ajax({
			url:'<?php echo base_url(); ?>Operator_management/ajex_get_operator_plans',
			method:"POST", 
			data:{ id:id}, 
			success:function(data)
			{  
				//alert(data); 
				$("#operator_plans_data_list").html(data);
			}
		});
}

function insert_plan_model(id){
	$("#add_plan").modal('show');
	$('#operator_id').val(id);
}

$(document).ready(function (e) {
 $("#new_plan_form").on('submit',(function(e) {
  e.preventDefault();
  
  $.ajax({
        url: '<?php echo base_url(); ?>Operator_management/ajax_insert_operator_plan',
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function(){ 
		},
		success: function(data){
			//alert(data);
			get_operator_plans(data);
			$('#add_plan').modal('hide');
		},
		error: function(e){ 
		}          
    });
 }));
}); 

function Update_plan_model(id){
	
	$.ajax({
			url:'<?php echo base_url(); ?>Operator_management/ajex_get_single_plan',
			method:"POST", 
			data:{ id:id }, 
			success:function(data)
			{  
				//alert(data); 
				get_all_operators();
				$("#plan_update_body").html(data);
				$("#update_plan").modal('show');
			}
		});
}	

$(document).ready(function (e) {
 $("#update_plan_form").on('submit',(function(e) {
  e.preventDefault();
  
  $.ajax({
        url: '<?php echo base_url(); ?>Operator_management/ajax_update_plan',
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend : function(){ 
		},
		success: function(data){
			//alert(data);
			get_operator_plans(data);
			$('#update_plan').modal('hide');
		},
		error: function(e){ 
		}          
    });
 }));
});  

function delete_plan(id){
	var result = confirm("Want to delete?");
	if (result) { 

		$.ajax({
			url:'<?php echo base_url(); ?>Operator_management/ajax_delete_plan',
			method:"POST", 
			data:{ id:id },
			success:function(data)
			{  
				$('#plan-'+id).remove();
				//location.reload(); 
				
				
			}
		});
	}
}
</script>

		
		  
          
       
		  
	
	