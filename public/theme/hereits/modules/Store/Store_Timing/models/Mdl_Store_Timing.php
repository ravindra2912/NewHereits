<?php 
class Mdl_Store_Timing extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_store_timing(){
		$this->db->select('*');
		$this->db->from('store_timing_master');
		$this->db->where('store_id', $this->session->User->store_id);
		return $this->db->get()->result();
	}
	
	function get_time_slots($store_timing_id){
		$this->db->select('*');
		$this->db->from('store_timing_slot_master');
		$this->db->order_by("start_time", "asc");
		$this->db->where('store_timing_id', $store_timing_id);
		return $this->db->get()->result();
	}
	
	function get_set_days(){
		$week = ['Sunday','Saturday','Friday','Thursday','Wednesday','Tuesday','Monday'];
		
		foreach($week as $val){
			
			$data['store_id'] =$this->session->User->store_id;
			$data['day'] = $val;
			$data['created_at'] = date("Y-m-d H:i:s");
			$data['updated_at'] = date("Y-m-d H:i:s");
		
			$this->db->insert('store_timing_master',$data);
		}
	}
	
	function set_time_slot(){
		$data['store_timing_id'] = $_POST['store_timing_id'];
		$data['start_time'] = $_POST['start_time'];
		$data['end_time'] = $_POST['end_time'];
		$data['created_at'] = date("Y-m-d H:i:s");
		$data['updated_at'] = date("Y-m-d H:i:s");
	
		$this->db->insert('store_timing_slot_master',$data);
	}
	
	function set_single_time_slot(){
		$this->db->select('*');
		$this->db->from('store_timing_slot_master');
		$this->db->where('store_timing_slot_id', $_POST['store_timing_slot_id']);
		return $this->db->get()->row();
	}
	
	function update_time_slot(){
		$data['start_time'] = $_POST['start_time'];
		$data['end_time'] = $_POST['end_time'];
		$data['updated_at'] = date("Y-m-d H:i:s");
	
		$this->db->where('store_timing_slot_id', $_POST['store_timing_slot_id']);
		$this->db->update('store_timing_slot_master',$data);
	}
	
	
	function get_single_timing(){
		$this->db->select('*');
		$this->db->from('store_timing_master');
		$this->db->where('store_timing_id', $_POST['store_timing_id']);
		return $this->db->get()->row();
	}
	
	function update_store_opning_status($close_status){
		$data['closed'] = $close_status;
		$data['updated_at'] = date("Y-m-d H:i:s");
	
		$this->db->where('store_timing_id', $_POST['store_timing_id']);
		$this->db->update('store_timing_master',$data);
	}
	  
	
	
}
?>