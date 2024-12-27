<?php 
class Mdl_Store_Booking extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	function get_booking_data($rowno,$rowperpage)
	{
		$this->db->select('
			bm.*,
			um.username,
			um.contact,
		');
		$this->db->from('booking_master as bm');
		
		if(!empty($_POST['search'])){
			$this->db->like('bm.booking_id', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('bm.booking_status', $_POST['status']);
		}
		
		$this->db->join('User_master AS um','um.user_id = bm.user_id','Left');
		
		$this->db->limit($rowperpage, $rowno); 
		$this->db->order_by('bm.created_at_date','desc'); 
		$this->db->order_by('bm.created_at_time','desc'); 
		$this->db->where('bm.store_id', $this->session->User->store_id);
		return $this->db->get()->result();
	}
	
	public function getrecordCount_booking() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('booking_master');
		
		if(!empty($_POST['search'])){
			$this->db->like('booking_id', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('booking_status', $_POST['status']);
		}
		
		$this->db->where('store_id', $this->session->User->store_id);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	  
	  function Get_booking_details($id){
		  $this->db->select('
			bm.*,
			um.username,
			um.contact,
		');
		$this->db->from('booking_master as bm');
		
		$this->db->join('User_master AS um','um.user_id = bm.user_id','Left');
		
		$this->db->limit($rowperpage, $rowno); 
		$this->db->where('bm.store_id', $this->session->User->store_id);
		$this->db->where('bm.booking_id', $id);
		return $this->db->get()->row();
	  }
	  
	  function get_address($id){
		$this->db->select('*');
		$this->db->from('address_master');		
		$this->db->where('address_id', $id);
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
		
		$this->db->join('Packages_master AS pm','pm.Package_id = bim.item_id','Left');
		$this->db->where('bim.booking_id', $booking_id);
		return $this->db->get()->result();
	  }
	  
	  
	  function Change_booking_status(){
		$data['booking_status'] = $_POST['booking_status'];
		$data['cancel_reason'] = $_POST['action'];
		$this->db->where('booking_id',$_POST['booking_id']);
		$this->db->update('booking_master',$data);
		
		$data2['booking_id'] = $_POST['booking_id'];
		$data2['booking_status'] = $_POST['booking_status'];
		$data2['created_at'] = date("Y-m-d H:i:s");
		$this->db->insert('Booking_Log_Master',$data2);
	  }
	  
	  
	  
	  
	  
	  
}
?>