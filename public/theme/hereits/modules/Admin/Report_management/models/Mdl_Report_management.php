<?php 
class Mdl_Report_management extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	function get_report_data($rowno,$rowperpage)
	{
		$this->db->select('
			ram.*,
			um.user_id,
			um.username	,
		');
		$this->db->from('Report_abuse_master as ram');
		
		if(!empty($_POST['search'])){
			$this->db->like('ram.report_id', $_POST['search']);
		}
		
		if($_POST['is_store'] != ''){
			$this->db->where('ram.item_id', $_POST['is_store']);
		}
		
		$this->db->join('User_master AS um','um.user_id = ram.user_id','Left');
		
		$this->db->limit($rowperpage, $rowno);
				
		return $this->db->get()->result();

	}
	
	
	
		
	public function getallrecord_report() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Report_abuse_master');
		
		if(!empty($_POST['search'])){
			$this->db->like('report_id', $_POST['search']);
		}
		
		if($_POST['is_store'] != ''){
			$this->db->where('item_id', $_POST['is_store']);
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
	
	function fetch_store_name(){
				
		$this->db->select('om.*,sm.store_id,sm.Store_name');
		
		$this->db->from('Report_abuse_master as om');
		$this->db->where('is_store',1);		
		$this->db->join('Store_master AS sm','sm.store_id = om.item_id','Left');
		$this->db->group_by('sm.store_id'); 
		return $this->db->get()->result();
	} 
	
	function get_details($id, $type){
		
		if($type == 1){
			$this->db->select('pm.product_id, pm.product_name, sm.Store_name');
			$this->db->from('product_master as pm');
			$this->db->join('store_product_master AS spm','spm.product_id = pm.product_id','Left');
			$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
			$this->db->where('pm.product_id', $id);
			return $this->db->get()->row();
		}else if($type == 2){
			$this->db->select('pm.Package_id, pm.Package_name, , sm.Store_name');
			$this->db->from('Packages_master as pm');
			$this->db->join('store_Packages_master AS spm','spm.Package_id = pm.product_id','Left');
			$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
			$this->db->where('pm.Package_id', $id);
			return $this->db->get()->row();
		}
		
	}  
	
	
	  
	  function report_details($report_id){
		  $this->db->select('
			ram.*,
			um.user_id,
			um.username	,
		');
		$this->db->from('Report_abuse_master as ram');
		$this->db->where('report_id', $report_id);
		$this->db->join('User_master AS um','um.user_id = ram.user_id','Left');
		return $this->db->get()->row();
	  }
	  
	 function get_store($store_id){
		$this->db->select('*');
		$this->db->from('Store_master');
		$this->db->where('store_id', $store_id);
		return $this->db->get()->row();
		}
		
	 function get_pm_pkm_details($id, $type){
		
		if($type == 1){
			$this->db->select('pm.*, sm.*');
			$this->db->from('product_master as pm');
			$this->db->join('store_product_master AS spm','spm.product_id = pm.product_id','Left');
			$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
			$this->db->where('pm.product_id', $id);
			return $this->db->get()->row();
		}else if($type == 2){
			$this->db->select('pm.*, sm.*');
			$this->db->from('Packages_master as pm');
			$this->db->join('store_Packages_master AS spm','spm.Package_id = pm.product_id','Left');
			$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
			$this->db->where('pm.Package_id', $id);
			return $this->db->get()->row();
		}
		
	}
	  
	  function fetch_user(){
				
		$this->db->select('ram.*,um.user_id,um.username');
		$this->db->group_by('um.user_id'); 
		$this->db->from('Report_abuse_master as ram');
		$this->db->join('User_master AS um','um.user_id = ram.user_id','Left');
		$this->db->group_by('um.user_id'); 
		return $this->db->get()->result();
	} 
	
		  
	  
	  
	  
}
?>