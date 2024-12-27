<?php 
class Mdl_Fav_item_management extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	function get_fav_item($rowno,$rowperpage)
	{
		$this->db->select('
			fim.*,
			um.user_id,
			um.username	,
		');
		$this->db->from('Favourit_item_mster as fim');
		
		//search
		if(!empty($_POST['search'])){
			$this->db->like('fim.favourit_id', $_POST['search']);
		}
		
		if($_POST['is_user'] != ''){
				$this->db->where('fim.user_id', $_POST['is_user']);
		   }
		   
		//filter
		if($_POST['is_store'] != ''){
		   
		   if($_POST['is_store'] == '0'){
			   if($res->type== 2)
				{
					$this->db->where('fim.type', $_POST['is_store']);
				}
				else{
					$this->db->where('fim.is_store', $_POST['is_store']);
				}
		   }
		   else{
			   $this->db->where('fim.is_store', $_POST['is_store']);
		   }
		}
		
		$this->db->join('User_master AS um','um.user_id = fim.user_id','Left');
		
		$this->db->limit($rowperpage, $rowno);
				
		return $this->db->get()->result();

	}
	
	
	
		
	public function getallrecord_favitem() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Favourit_item_mster');
		
		if(!empty($_POST['search'])){
			$this->db->like('favourit_id', $_POST['search']);
		}
		
		if($_POST['is_user'] != ''){
				$this->db->where('user_id', $_POST['is_user']);
		   }
		
		
		
		if($_POST['is_store'] != ''){
		   
		   if($_POST['is_store'] ==  $_POST['is_store']){
			   if($res->type== 2)
				{
					$this->db->where('type',  $_POST['is_store']);
				}
				else{
					$this->db->where('is_store',  $_POST['is_store']);
				}
		   }
		   else{
			   $this->db->where('is_store', 1);
		   }
		}
		
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	  
	  
	function get_store_details($store_id){
		$this->db->select('store_id, Store_name');
		$this->db->from('Store_master');
		$this->db->where('store_id', $store_id);
		return $this->db->get()->row();
	} 
	
	function get_details($id, $type){
		
		if($type == 1){
			$this->db->select('pm.product_id, pm.product_name, sm.Store_name');
			$this->db->from('product_master as pm');
			$this->db->join('Store_master AS sm','sm.store_id = pm.store_id','Left');
			$this->db->where('pm.product_id', $id);
			return $this->db->get()->row();
		}else if($type == 2){
			$this->db->select('pm.Package_id, pm.Package_name, , sm.Store_name');
			$this->db->from('Packages_master as pm');
			$this->db->join('Store_master AS sm','sm.store_id = pm.store_id','Left');
			$this->db->where('pm.Package_id', $id);
			return $this->db->get()->row();
		}
		
	}  
	
	function fetch_user(){
				
		$this->db->select('fim.*,um.user_id,um.username');
		$this->db->from('Favourit_item_mster as fim');
		$this->db->join('User_master AS um','um.user_id = fim.user_id','Left');
		$this->db->group_by('um.user_id'); 
		return $this->db->get()->result();
	}
	  
	  
	  
	  
	  
	  
	  
	  
}
?>