<?php 
class Mdl_Store_Setting extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_data(){
		$this->db->select('*');
		$this->db->from('Store_master');
		$this->db->where('store_id',$this->session->User->store_id);
		return $this->db->get()->row();
	}
	
	function update_Terms_Conditions(){
		
		$data['terms'] = $_POST['terms'];
		
		$this->db->where('store_id',$this->session->User->store_id);
		$this->db->update('Store_master',$data);
	}
	
	function update_Aboutus(){
		
		$data['aboutus'] = $_POST['aboutus'];
		
		$this->db->where('store_id',$this->session->User->store_id);
		$this->db->update('Store_master',$data);
	}
	
	
	
	
}
?>