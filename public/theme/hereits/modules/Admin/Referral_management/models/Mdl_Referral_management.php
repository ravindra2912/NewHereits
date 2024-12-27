<?php 
class Mdl_Referral_management extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	function get_user_data($rowno,$rowperpage)
	{
		$this->db->select('*');
		$this->db->from('User_master');
				
		if(!empty($_POST['search'])){
			$this->db->like('username', $_POST['search']);
			$this->db->or_like('user_referal', $_POST['search']);
		}
		$this->db->limit($rowperpage, $rowno); 
	//	$this->db->order_by("created_at", "desc");
		return $this->db->get()->result();
	}
	
	public function getrecordCount_user() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('User_master');
		
		if(!empty($_POST['search'])){
			$this->db->like('username', $_POST['search']);
			$this->db->or_like('user_referal', $_POST['search']);
		}
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	  
	function get_pending_payments($rowno,$rowperpage)
	{
		$this->db->select('*');
		$this->db->from('Store_master');
		$this->db->where('referral_code', $_POST['user_referal']); 
		$this->db->limit($rowperpage, $rowno); 
		$this->db->order_by('created_at','desc');
		return $this->db->get()->result();
	}
	
	public function getrecordCount_pending_payments() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Store_master');
		$this->db->where('referral_code', $_POST['user_referal']); 
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	
	public function Count_pending_payments($user_referal) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Store_master');
		$this->db->where('referral_code', $user_referal); 
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	
	function get_user_pending_payments($user_referal)
	{
		$this->db->select('*');
		$this->db->from('Store_master');
		$this->db->where('referral_code', $user_referal); 
		$this->db->order_by('created_at','desc');
		return $this->db->get()->result();
	}
	  
	public function getrecordCount_referal($referal) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Store_master');
		$this->db->where('referral_code',$referal);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
  
	function get_store($id)
	{
		$this->db->select('*');
		$this->db->from('Store_master');
		$this->db->where('store_id',$id);
		return $this->db->get()->row();
	}
	
		
	function get_single_user_data($id)
	{
		$this->db->select('*');
		$this->db->from('User_master');
		$this->db->where('user_id',$id);
		return $this->db->get()->row();
	}
	
	function check_payment($id)
	{
		$this->db->select('*');
		$this->db->from('referal_commission_master');
		$this->db->where('store_id',$id);
		return $this->db->get()->row();
	}
	
	function get_completed_Pymts($rowno,$rowperpage)
	{
		$this->db->select('*');
		$this->db->from('referal_commission_master');
		$this->db->where('useri_id', $_POST['user_id']); 
		$this->db->limit($rowperpage, $rowno); 
		$this->db->order_by('created_at_date','desc');
		return $this->db->get()->result();
	}
	
	public function complt_payment() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('referal_commission_master');
		$this->db->where('useri_id', $_POST['user_id']); 
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	
	function update_status($store_id)
	{
		$this->db->select('*');
		$this->db->from('Store_master');
		$this->db->where('store_id',$store_id);
		$store_data = $this->db->get()->row();
		
		$this->db->select('*');
		$this->db->from('User_master');
		$this->db->where('user_referal',$store_data->referral_code);
		$user_data = $this->db->get()->row();
		
		$data['store_id'] = $store_id;
		$data['useri_id'] = $user_data->user_id;
		$data['created_at_date'] = date("Y-m-d");
		$data['created_at_time'] = date("H:i:s");
		$this->db->insert('referal_commission_master',$data);
		
	}
	
	
}
?>