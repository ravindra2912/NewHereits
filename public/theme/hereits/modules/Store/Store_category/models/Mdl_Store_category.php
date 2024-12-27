<?php 
class Mdl_Store_category extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kuala_Lumpur");
	} 
	
	function get_store_subscription(){
		
	}
	
	function get_store_category_data()
	{  
		
			$this->db->select('scm.*, cm.category_name, cm.category_image, cm.category_type');
			$this->db->from('Store_category_master as scm');
			$this->db->join('category_master AS cm','cm.`category_id` = scm.`category_id`','Left');
			$this->db->where('cm.category_type ', $_POST['type']);
			$this->db->where('scm.store_id',$this->session->User->store_id);
			return $this->db->get()->result();
		
		
	} 
	
	function get_store_single_category_data($cat_id)
	{   
		$data = $this->db->where('category_id',$cat_id);
		$data = $this->db->where('store_id',$this->session->User->store_id);
		$data = $this->db->get('Store_category_master');
		return $data->row(); 
	} 
	
	function get_suggestion_category_data()
	{   
		
		$this->db->select('cm.*');
		$this->db->from('category_master as cm');
		if($_POST['search'] != NULL){
			$this->db->like('cm.category_name', $_POST['search']);
		}
		$this->db->where('cm.parent_category', NULL);
		$this->db->where('cm.category_status', 1);
		$this->db->group_by('cm.`category_id');
		$this->db->where('cm.category_type', $_POST['type']);
		
		return $this->db->get()->result();
	} 
	
	function get_single_category_data($cat_id){
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('category_id',$cat_id);
		$this->db->where('parent_category', NULL);
		$this->db->where('category_status', 1);
		if($this->session->User->store_type == 1 || $this->session->User->store_type == 2){
			$this->db->where('category_type', $this->session->User->store_type);
		}
		return $this->db->get()->row();
	}
	
	
}
?>