<?php 
class Mdl_User_management extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_users($rowno,$rowperpage)
	{
		$this->db->select('*');
		$this->db->from('User_master');
		if(!empty($_POST['search'])){
			$this->db->like('user_id', $_POST['search']);
		}
		$this->db->limit($rowperpage, $rowno); 
		$this->db->order_by('created_at', 'desc'); 
		return $this->db->get()->result();
	}	
	
	function getallrecord_users()
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('User_master');
		if(!empty($_POST['search'])){
			$this->db->like('user_id', $_POST['search']);
		}
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	
	public function getreport_count($user_id) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Report_abuse_master');
		$this->db->where('user_id',$user_id);		
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	  
	 public function getorder_count($user_id) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Order_master');
		$this->db->where('user_id',$user_id);		
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }

	  public function getbooking_count($user_id) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('booking_master');
		$this->db->where('user_id',$user_id);		
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	
	function user_details($user_id){
		
		$this->db->select('um.* ,sm.store_id , sm.Store_name,sm.store_contact , sm.store_address ,sm.store_address_2, sm.user_id as store_owner_id');
		$this->db->from('User_master AS um');
		$this->db->where('um.user_id',$user_id);
		$this->db->join('Store_master AS sm','sm.user_id = um.user_id','Left');
		return $this->db->get()->row();
	}
	
	function orders_details($user_id){
		
		$this->db->select('*');
		$this->db->from('Order_master');
		$this->db->where('user_id',$user_id);
		return $this->db->get()->result();
	}
	
	function booking_details($user_id){
		
		$this->db->select('bm.*, sm.store_id , sm.Store_name ');
		$this->db->from('booking_master as bm');
		$this->db->where('bm.user_id',$user_id);
		$this->db->join('Store_master AS sm','sm.store_id = bm.store_id','Left');
		return $this->db->get()->result();
	}
	
	
	
	 
	
	function update_user(){
	
		$data['frist_name']=$_POST['frist_name'];
		$data['last_name']=$_POST['last_name'];
		$data['username']=$_POST['username'];
		$data['email']=$_POST['email'];
		$data['contact']= $_POST['contact'];
		$data['adhar_card_number']= $_POST['adhar_card_number'];
		$data['adhar_verifed']= $_POST['adhar_verifed'];
		$data['gender']= $_POST['gender'];
		$data['family_name']= $_POST['family_name'];
		$data['family_relation']= $_POST['family_relation'];
		$data['family_contact']= $_POST['family_contact'];
		$data['user_status']= $_POST['user_status'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		if($_POST['user_image']){
			$data['user_image']= $_POST['user_image'];
		}
			
		if($_POST['adhar_card_front_image']){
			$data['adhar_card_front_image']= $_POST['adhar_card_front_image'];
		}
		
		if($_POST['adhar_card_back_image']){
			$data['adhar_card_back_image']= $_POST['adhar_card_back_image'];
		}
				
		if($_POST['password'] != NULL){
			$data['password'] = md5($_POST['password']);
		}
		
		$this->db->where('user_id',$_POST['user_id']);
		$this->db->update('User_master',$data);
	}
	
	
	
}
?>