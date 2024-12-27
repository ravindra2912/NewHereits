<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_Timing extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Store_Timing');
		$this->load->library("pagination");
		
		if($this->session->User == null)
		{redirect('Login');}
	}
	Public function index()
	{   
		$store_timing_details = $this->Mdl_Store_Timing->get_store_timing();
		
		//insert week
		if($store_timing_details == NULL){
			$this->Mdl_Store_Timing->get_set_days();
			$store_timing_details = $this->Mdl_Store_Timing->get_store_timing();
		}
		
		//get time slots
		foreach($store_timing_details as $val){
			$val->time_slots = $this->Mdl_Store_Timing->get_time_slots($val->store_timing_id);
		}
		
		$data =array(
			'main_content'=>'Store_timing',   
			'store_timing_details'=>$store_timing_details,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	function set_time_slot(){
		
		$this->Mdl_Store_Timing->set_time_slot();
		redirect('Store_Timing');
	}
	
	function edit_time_slot(){
		$res = $this->Mdl_Store_Timing->set_single_time_slot();
		
		echo json_encode($res);
		die;
	}
	
	function update_time_slot(){
		$this->Mdl_Store_Timing->update_time_slot();
		redirect('Store_Timing');
	} 
	
	function delete_time_slot(){
		//delete product record
		$this->db->where('store_timing_slot_id', $_POST['store_timing_slot_id']);
		$this->db->delete('store_timing_slot_master');
		
		die;
	}
	
	function store_opning_status(){
		$time_slote = $this->Mdl_Store_Timing->get_single_timing();
		
			$data['closed'] = '';
			$data['msg'] ='Data Not Match!';
		if($time_slote->closed == 0){
			$this->Mdl_Store_Timing->update_store_opning_status(1);
			$data['closed'] = 1;
			$data['msg'] ='Store Closed';
			echo json_encode($data);
			die;
		}else if($time_slote->closed == 1){
			$this->Mdl_Store_Timing->update_store_opning_status(0);
			$data['closed'] = 0;
			$data['msg'] ='Store Open';
			echo json_encode($data);
			die;
		}
	}
	
	
	
	
	
}
?>
