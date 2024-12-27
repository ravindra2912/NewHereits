<?php 
class Mdl_Booking_management extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	function get_booking_data($rowno,$rowperpage)
	{
		$this->db->select('
			bm.*,
			um.user_id,
			um.username,
			um.contact,
			sm.Store_name,
			sm.store_id,
		');
		$this->db->from('booking_master as bm');
		
		if(!empty($_POST['search'])){
			$this->db->like('bm.booking_id', $_POST['search']);
		}
		if($_POST['is_user'] != ''){
				$this->db->where('um.user_id', $_POST['is_user']);
		   } 
		if($_POST['is_store'] != ''){
			$this->db->where('sm.store_id', $_POST['is_store']);
		}
		if($_POST['status'] != ''){
			$this->db->where('bm.booking_status', $_POST['status']);
		}
		
		$this->db->join('User_master AS um','um.user_id = bm.user_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = bm.store_id','Left');
		
		$this->db->limit($rowperpage, $rowno); 
		return $this->db->get()->result();
	}
	
	public function getallrecord_booking() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('booking_master');
		
		if(!empty($_POST['search'])){
			$this->db->like('booking_id', $_POST['search']);
		}
		if($_POST['is_user'] != ''){
				$this->db->where('user_id', $_POST['is_user']);
		}
		if($_POST['is_store'] != ''){
				$this->db->where('store_id', $_POST['is_store']);
		}
		if($_POST['status'] != ''){
			$this->db->where('booking_status', $_POST['status']);
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
	 
	function Get_booking_details($booking_id)
	  {
		  $this->db->select('
			bm.*,
			um.frist_name,
			um.last_name,
			um.username,
			um.email,
			um.contact,
			
		');
		$this->db->from('booking_master as bm');
		$this->db->join('User_master AS um','um.user_id = bm.user_id','Left');
		
	
		//$this->db->where('bm.store_id', $this->session->Admin->store_id);
		$this->db->where('bm.booking_id', $booking_id);
	
		return $this->db->get()->row();
		
	  }
	function fetch_user(){
				
		$this->db->select('bm.*,um.user_id,um.username');
		$this->db->from('booking_master as bm');
		$this->db->join('User_master AS um','um.user_id = bm.user_id','Left');
		$this->db->group_by('um.user_id'); 
		return $this->db->get()->result();
	}  
	
	function fetch_store_name(){
				
		$this->db->select('bm.*,sm.store_id,sm.Store_name');
		$this->db->from('booking_master as bm');
		$this->db->join('Store_master AS sm','sm.store_id = bm.store_id','Left');
		$this->db->group_by('sm.store_id'); 
		return $this->db->get()->result();
	} 
	

	  
	  
	function get_address($id){
		$this->db->select('*');
		$this->db->from('address_master');		
		$this->db->where('address_id', $id);
		
		return $this->db->get()->row();
	  }
	  
	  function Get_store($id){
		  $this->db->select('*');
		$this->db->from('Store_master');		
		$this->db->where('store_id', $id);
		
		return $this->db->get()->row();
	  }
	  
	  function Get_booking_items($booking_id){
		  $this->db->select('
			bim.*,
			pm.Package_name,
			pm.Package_id,
			pm.packege_image,
		');
		$this->db->from('booking_item_master as bim');
		
		$this->db->join('Packages_master AS pm','pm.Package_id = bim.booking_item_id','Left');
		$this->db->where('bim.booking_id', $booking_id);
		return $this->db->get()->result();
	  }
	  
	  function Change_booking_status(){
		
		$data['booking_status'] = $_POST['booking_status'];
		$this->db->where('booking_id',$_POST['booking_id']);
		$this->db->update('booking_master',$data);
		
		$data['booking_id'] = $_POST['booking_id'];
		$data['booking_status'] = $_POST['booking_status'];
		$data['created_at'] = date("Y-m-d H:i:s");
		$this->db->insert('Booking_Log_Master',$data);
	  } 
}
?>