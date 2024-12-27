<?php 
class Mdl_Operator_management extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_operators()
	{
		$this->db->select('*');
		$this->db->from('operator_master');
		return $this->db->get()->result();
	}
	
	function insert_operator(){ 
		$data['operator_name'] = $_POST['operator_name'];
		$data['Created_at'] = date("Y-m-d");
		$data['updated_at'] = date("Y-m-d H:i:s");
		$this->db->insert('operator_master',$data);
	}
	
	function get_single_operator($id){
		$this->db->select('*');
		$this->db->where('operator_id', $id);
		$this->db->from('operator_master');
		return $this->db->get()->row();
	}
	
	function update_operator(){
		$data['operator_name'] = $_POST['operator_name'];
		$data['operator_status'] = $_POST['operator_status'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		$this->db->where('operator_id',$_POST['operator_id']);
		$this->db->update('operator_master',$data);
	}
	
	function delete_operator($id){
		$this->db->where('operator_id', $id);
		$this->db->delete('operator_master');
	}
	
	//********************** operator plan ***********************
	
	function get_operator_plans(){
		$this->db->select('*');
		$this->db->where('operator_id', $_POST['id']);
		$this->db->from('operator_plan_master');
		return $this->db->get()->result();
	}
	
	function insert_operator_plan(){
		$data['operator_id'] = $_POST['operator_id'];
		$data['plan_amount'] = $_POST['plan_amount'];
		$data['info'] = $_POST['info'];
		$data['Created_at'] = date("Y-m-d");
		$data['updated_at'] = date("Y-m-d H:i:s");
		$this->db->insert('operator_plan_master',$data);
	}
	
	function get_single_plan($id){
		$this->db->select('*');
		$this->db->where('op_id', $id);
		$this->db->from('operator_plan_master');
		return $this->db->get()->row();
	}
	
	function update_plan(){
		$data['plan_amount'] = $_POST['plan_amount'];
		$data['info'] = $_POST['info'];
		$data['op_status'] = $_POST['op_status'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		$this->db->where('op_id',$_POST['op_id']);
		$this->db->update('operator_plan_master',$data);
	}
	
	function delete_plan($id){
		$this->db->where('op_id', $id);
		$this->db->delete('operator_plan_master');
	}
	
	
}
?>