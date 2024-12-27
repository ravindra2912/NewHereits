<div class="content-header m-hide">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Store Timing</h1>
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
	
		<?php foreach($store_timing_details as $day){ ?>
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 style="float: left;margin: -5px 0px -5px 0px;"><?= $day->day ?></h3>
						<div style="float: right;">
							<button type="button" style="<?php if($day->closed == 0){ echo 'display:none';} ?>" id="btn_close<?= $day->store_timing_id ?>" onclick="store_opning_status(<?=$day->store_timing_id ?>)" class="btn btn-block btn-danger btn-sm">Close</button>
							<button type="button" style="<?php if($day->closed == 1){ echo 'display:none';} ?>" id="btn_open<?=$day->store_timing_id ?>" onclick="store_opning_status(<?= $day->store_timing_id ?>)" class="btn btn-block btn-success btn-sm">Open</button>
							
							
							
						</div>
					</div>
					<div class="row p-2" >
						
						
						<?php foreach($day->time_slots as $time){ ?>
							<div class="col-md-4 col-12" id="slot-<?=  $time->store_timing_slot_id ?>">
								<div class="external-event ui-draggable ui-draggable-handle text-center bg-gray" style="position: relative;"><?php echo date("H:i", strtotime($time->start_time)); ?> - <?php echo date("H:i", strtotime($time->end_time)); ?> 
									<div class="input-group-prepend" style="float: right;">
										<button type="button" style="padding: 0px 7px 0px 7px !important;" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></button>
										<ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 48px, 0px); top: 0px; left: 0px; will-change: transform;">
										  <li class="dropdown-item" onclick="edit_time_slot(<?=  $time->store_timing_slot_id ?>)"><a href="#">Edit</a></li>
										  <li class="dropdown-item" onclick="delete_time_slot(<?=  $time->store_timing_slot_id ?>)"><a href="#">Delete</a></li>
										</ul>
									  </div>
								</div>
							</div>
						<?php } ?>
						
						<div class="col-md-4 col-12">
							<div class="external-event ui-draggable ui-draggable-handle text-center bg-primary" onclick="add_time_slot(<?= $day->store_timing_id ?>)" style="position: relative;">
								Add Time &nbsp;<i class="fas fa-plus" style="font-size: 15px;"></i>
								
							</div>
						</div>
					</div>
					
				</div>
			</div>
		<?php } ?>
	</div>
</section>

	<!-- Add timing Model -->
	<div class="modal fade" id="add_time_slot">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Time Slote</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
			<form id="coupons_detail" action="<?= base_url() ?>Store_Timing/set_time_slot" method="POST" enctype="multipart/form-data" novalidate="novalidate">		
				<div class="modal-body">
					<div class="card-body">
						<div class="row">
							
							<input type="hidden" name="store_timing_id" id="store_timing_id" />
							<div class="col-sm-12 col-12">
								<div class="bootstrap-timepicker">
									<div class="form-group">
										<label>Start Time <span class="error">*</span></label>
										<div class="input-group date" id="start_time" data-target-input="nearest">
											<input name="start_time" readonly="readonly" type="text" class="form-control datetimepicker-input" data-target="#start_time" data-toggle="datetimepicker"/>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-sm-12 col-12">
								<div class="bootstrap-timepicker">
									<div class="form-group">
										<label>End Time <span class="error">*</span></label>
										<div class="input-group date" id="end_time" data-target-input="nearest">
											<input name="end_time" readonly="readonly" type="text" class="form-control datetimepicker-input" data-target="#end_time" data-toggle="datetimepicker"/>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				
				</div>
				<div class="modal-footer justify-content-between">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  <button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
	  
	  <!-- update timing Model -->
	<div class="modal fade" id="update_time_slot">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Update Time Slote</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
			<form id="coupons_detail" action="<?= base_url() ?>Store_Timing/update_time_slot" method="POST" enctype="multipart/form-data" novalidate="novalidate">		
				<div class="modal-body">
					<div class="card-body">
						<div class="row" >
							<input type="hidden" name="store_timing_slot_id" id="update_store_timing_slot_id" />
							<div class="col-sm-12 col-12">
								<div class="bootstrap-timepicker">
									<div class="form-group">
										<label>Start Time <span class="error">*</span></label>
										<div class="input-group date" id="start_time1" data-target-input="nearest">
											<input name="start_time" id="update_start_time"  readonly="readonly" type="text" class="form-control datetimepicker-input" data-target="#start_time1" data-toggle="datetimepicker"/>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-sm-12 col-12">
								<div class="bootstrap-timepicker">
									<div class="form-group">
										<label>End Time <span class="error">*</span></label>
										<div class="input-group date" id="end_time1" data-target-input="nearest">
											<input name="end_time" id="update_end_time" readonly="readonly" type="text" class="form-control datetimepicker-input" data-target="#end_time1" data-toggle="datetimepicker"/>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				
				</div>
				<div class="modal-footer justify-content-between">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  <button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>





<script>
function add_time_slot(id){
	$('#store_timing_id').val(id);
	$('#add_time_slot').modal('show');
}

function edit_time_slot(store_timing_slot_id){
	$.ajax({
		url:'<?php echo base_url(); ?>Store_Timing/edit_time_slot',
		method:"POST", 
		data:{ store_timing_slot_id:store_timing_slot_id },
		dataType: 'json',
		success:function(data)
		{  
			//alert(data);
			$('#update_store_timing_slot_id').val(data.store_timing_slot_id);
			$('#update_start_time').val(data.start_time);
			$('#update_end_time').val(data.end_time);
			$('#update_time_slot').modal('show');
		},
		error: function(e){ 
			alertify.error("Somthing Wrong");
			console.log(e);
		} 
	});
}

	
	//delete Time Slot
	function delete_time_slot(store_timing_slot_id){
		var result = confirm("Want to delete?");
		if (result) { 

			$.ajax({
				url:'<?php echo base_url(); ?>Store_Timing/delete_time_slot',
				method:"POST", 
				data:{ store_timing_slot_id:store_timing_slot_id },
				success:function(data)
				{  
					alertify.success("Delete Successfully");
					$('#slot-'+store_timing_slot_id).remove();
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
				} 
			});
		}
	}
	
	//chenge Store Closing Status
	function store_opning_status(store_timing_id){
		$.ajax({
			url:'<?php echo base_url(); ?>Store_Timing/store_opning_status',
			method:"POST", 
			data:{ store_timing_id:store_timing_id },
			dataType: 'json',
			success:function(data)
			{  
				if(data.closed == 1){
					alertify.success(data.msg);
					$('#btn_close'+store_timing_id).show();
					$('#btn_open'+store_timing_id).hide();
				}else if(data.closed == 0){
					alertify.success(data.msg);
					$('#btn_close'+store_timing_id).hide();
					$('#btn_open'+store_timing_id).show();
				}else{
					alertify.success(data.msg);
				}
			},
			error: function(e){ 
				alertify.error("Somthing Wrong");
				console.log(e);
			} 
		});
	}



</script>	

	