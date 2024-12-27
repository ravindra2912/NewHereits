<?php 
class Mdl_Store_Follow extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	function get_Follow_list($rowno,$rowperpage)
	{
		$this->db->select('
			fm.*,
			um.username,
			um.user_image,
		');
		$this->db->from('Follow_master as fm');
		$this->db->join('User_master AS um','um.user_id = fm.user_id','Left');
		
		$this->db->limit($rowperpage, $rowno); 
		$this->db->order_by('fm.stor_id','desc'); 
		$this->db->where('fm.stor_id', $this->session->User->store_id);
		return $this->db->get()->result();
	}
	
	public function get_Follow_list_count() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Follow_master');
		$this->db->where('stor_id', $this->session->User->store_id);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	  
	 
}
?>