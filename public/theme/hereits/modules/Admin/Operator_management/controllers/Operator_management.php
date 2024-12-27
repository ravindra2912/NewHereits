<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operator_management extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Operator_management');
		
		if($this->session->Admin == null)
		{redirect('Admin');}
	}
	Public function index()
	{   
			$operator_data = $this->Mdl_Operator_management->get_operators();
			$data =array(
				'main_content'=>'Operator_list',
				'left_sidebar'=>'Operator list', 
				'operator_data'=>$operator_data,  
			);
			$this->load->view('admin_template/template',$data);
		
	}
	
	function ajex_get_all_operator(){
		$operator_data = $this->Mdl_Operator_management->get_operators();
		$data = '';
		foreach($operator_data as $od) { 
		
			$data .= '<tr id="operator-'.$od->operator_id.'">
						  <td class="text-center" style="padding: .20rem; vertical-align: unset;">
							'.$od->operator_name.'
						  </td> 
						  
						  <td class="text-center" style="padding: .20rem; vertical-align: unset;">';
								if($od->operator_status == 1)
								{
									$data .= 'Active';
								}else{
									$data .= 'In-Active';
								}
				$data .= '</td>
						  <td class="row-actions text-center" style="padding: .20rem; vertical-align: unset;"> 
							<a class="btn btn-primary" onclick="Update_operator('.$od->operator_id.')">Edit</a>
							<a class="btn btn-danger" onclick="delete_operator('.$od->operator_id.')">Delete</a>
							<a class="btn btn-success" onclick="get_operator_plans('.$od->operator_id.')">Plans</a>
						  </td>
					</tr>';
		}
		echo $data;
	}
	
	function insert_operator(){ 
		$this->Mdl_Operator_management->insert_operator();
		$success_msg='Operator Add Successfully';
		$this->session->set_flashdata('success_msg',$success_msg);
		redirect('Operator_management');
	}
	
	
	function ajex_get_single_operator(){
		$res = $this->Mdl_Operator_management->get_single_operator($_POST['id']);
		
		$data ='
				<input type="hidden" name="operator_id" value="'.$res->operator_id.'" />
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label>Operator Name</label>
								<input type="text" name="operator_name"  value="'.$res->operator_name.'" class="form-control" placeholder="Operator Name" required>
							</div>
						</div>
						
						<div class="col-md-12">
							<div class="form-group">
								<label>Status </label>
								<select class="form-control" name="operator_status" required>
									<option value="">Status</option>
									<option value="1" '; if($res->operator_status == 1){$data .='selected';} $data .='>Active</option>
									<option value="0"'; if($res->operator_status == 0){$data .='selected';} $data .='>In-Active</option>
									
								</select>
							</div> 
						</div>
						
					</div>
                </div>
		';
		
		echo $data;
	}
	
	function update_operator(){
			$this->Mdl_Operator_management->update_operator();
			$success_msg='Operator Update Successfully';
			$this->session->set_flashdata('success_msg',$success_msg);
			redirect('Operator_management');
	}
	
	function ajax_delete_operator(){
		if($_POST){
			$this->Mdl_Operator_management->delete_operator($_POST['id']);
			$success_msg='Operator Add Successfully';
			$this->session->set_flashdata('success_msg',$success_msg);
		}
	}
	
	
	//********************** operator plan ***********************
	
	function ajex_get_operator_plans(){
		$res = $this->Mdl_Operator_management->get_operator_plans();
		$data ='
			<div class="card">
            <div class="card-header">
                <a href="#" class="btn btn-md btn-success" onclick="insert_plan_model('. $_POST['id'].');">Add Plan</a>
                           
            </div>
			
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th style="text-align: center;"> Plan Amoun </th>
                  <th style="text-align: center;"> Info </th>
				  <th style="text-align: center;"> Status </th>
				  <th style="text-align: center;"> Actions </th>
                </tr>
                </thead>
                <tbody>';
		if($res == NULL){
			$data .= '<tr>
					<td class="text-center" style="padding: .20rem; vertical-align: unset;" colspan="4">No Plan</td>
			</tr>';
		}else{
			  
			foreach($res as $od) { 
		
			$data .= '<tr id="plan-'.$od->op_id.'">
						  <td class="text-center" style="padding: .20rem; vertical-align: unset;">
							'.$od->plan_amount.'
						  </td> 
						  
						  <td class="text-center" style="padding: .20rem; vertical-align: unset;">
							'.$od->info.'
						  </td> 
						  
						  <td class="text-center" style="padding: .20rem; vertical-align: unset;">';
								if($od->op_status == 1)
								{
									$data .= 'Active';
								}else{
									$data .= 'In-Active';
								}
				$data .= '</td>
						  <td class="row-actions text-center" style="padding: .20rem; vertical-align: unset;"> 
							<a class="btn btn-primary" onclick="Update_plan_model('.$od->op_id.')">Edit</a>
							<a class="btn btn-danger" onclick="delete_plan('.$od->op_id.')">Delete</a>
						  </td>
					</tr>';
			}
		}
		
		$data .='</tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>';
		
		echo $data;
		
	}
	
	function ajax_insert_operator_plan(){
		$this->Mdl_Operator_management->insert_operator_plan();
		
		echo $_POST['operator_id'];
	}
	
	function ajex_get_single_plan(){
		$res = $this->Mdl_Operator_management->get_single_plan($_POST['id']);
		
		$data ='
				<input type="hidden" name="op_id" value="'.$res->op_id.'" />
				<input type="hidden" name="operator_id" value="'.$res->operator_id.'" />
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label>Plan Amount</label>
								<input type="text" name="plan_amount"  value="'.$res->plan_amount.'" class="form-control" placeholder="Plan Amount" required>
							</div>
						</div>
						
						<div class="col-12">
							<div class="form-group">
								<label>Info</label>
								<textarea name="info" class="form-control" placeholder="Plan Amount" >'.$res->info.'</textarea>
							</div>
						</div>
						
						<div class="col-md-12">
							<div class="form-group">
								<label>Status </label>
								<select class="form-control" name="op_status" required>
									<option value="">Status</option>
									<option value="1" '; if($res->op_status == 1){$data .='selected';} $data .='>Active</option>
									<option value="0"'; if($res->op_status == 0){$data .='selected';} $data .='>In-Active</option>
									
								</select>
							</div> 
						</div>
						
					</div>
                </div>
		';
		
		echo $data;
	}
	
	function ajax_update_plan(){
		$this->Mdl_Operator_management->update_plan();
		echo $_POST['operator_id'];
	}
	
	function ajax_delete_plan(){
		$this->Mdl_Operator_management->delete_plan($_POST['id']);
	}
	
}
?>
