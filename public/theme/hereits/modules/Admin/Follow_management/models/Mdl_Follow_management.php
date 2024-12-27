<?php 
class Mdl_Follow_management extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	function get_follow_data($rowno,$rowperpage)
	{
		
		$this->db->select('
			fm.*,
			um.user_id,
			um.username,
			sn.Store_name,
			sn.store_type,
			sn.store_id,
		');
		$this->db->from('Follow_master as fm');
		
		if(!empty($_POST['search'])){
			$this->db->like('fm.follow_id', $_POST['search']);
		}
		
		if($_POST['is_user'] != ''){
				$this->db->where('um.user_id', $_POST['is_user']);
		   }
		
		if($_POST['is_store'] != ''){
		   
		   if($_POST['is_store'] == '1'){
			  	$this->db->where('sn.store_type',1);
				}
		   else  if($_POST['is_store'] == '2') {
			   $this->db->where('sn.store_type',2);
		   }
		}
	   
		
		$this->db->join('User_master AS um','um.user_id = fm.user_id','Left');
		$this->db->join('Store_master AS sn','sn.store_id = fm.stor_id','Left');
		
		$this->db->limit($rowperpage, $rowno); 
	

		return $this->db->get()->result();
	}
	
	public function getallrecord_follow() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Follow_master');
		
		if(!empty($_POST['search'])){
			$this->db->like('follow_id', $_POST['search']);
		}
		
		
		
		if($_POST['is_user'] != ''){
				$this->db->where('user_id', $_POST['is_user']);
		}
				
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	 }
	  
	 function fetch_user(){
				
		$this->db->select('fm.*,um.user_id,um.username');
		$this->db->from('Follow_master as fm');
		$this->db->join('User_master AS um','um.user_id = fm.user_id','Left');
		$this->db->group_by('um.user_id'); 
		return $this->db->get()->result();
	}
	 
	  
}
?>