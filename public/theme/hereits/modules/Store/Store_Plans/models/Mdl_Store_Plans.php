<?php 
class Mdl_Store_Plans extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_plans($type){
		$this->db->select('*');
		if($type != 0){
			$this->db->where('type', $type);
		}
		$this->db->order_by('order', 'asc');
		$this->db->where('status', 1);
		$this->db->from('subscription_master');
		$sub = $this->db->get()->result();
		
		$data = array();
		foreach($sub as $plans){
			$this->db->select('*');
			$this->db->where('subscription_id', $plans->subscription_id);
			$this->db->order_by('month', 'asc');
			$this->db->from('subscription_plans_master');
			$splans = $this->db->get()->result();
			if($splans != NULL){
				$plans->plans = $splans;
				$data[] = $plans;
			}
		}
		return $data;
	}
	
	function get_plan(){
		$this->db->select('*');
		$this->db->where('subscription_id', $_POST['subscription_id']);
		$this->db->where('status', 1);
		$this->db->from('subscription_master');
		$sub = $this->db->get()->row();
		
		
		$this->db->select('*');
		$this->db->where('subscription_id', $sub->subscription_id);
		$this->db->order_by('month', 'asc');
		$this->db->from('subscription_plans_master');
		$sub->plans = $this->db->get()->result();
		
		return $sub;
	}
	
	function get_single_plan(){
		$this->db->select('*');
		$this->db->where('subscription_id', $_POST['subscription_id']);
		$this->db->where('month', $_POST['month']);
		$this->db->from('subscription_plans_master');
		return $this->db->get()->row();
	}
	
	function get_plans_data($rowno,$rowperpage){
		
		$this->db->select('ssm.* ,ssm.status as plan_status, sm.*');
		$this->db->from('store_subscription_master as ssm ');
		$this->db->join('subscription_master as sm','sm.subscription_id = ssm.subscription_id','left');
		$this->db->limit($rowperpage, $rowno); 
		$this->db->order_by('ssm.created_date', 'desc');
		$this->db->order_by('ssm.created_time', 'desc');
		$this->db->where('store_id', $this->session->User->store_id);
		
		return $this->db->get()->result();
	}
	function getrecordCount_plans(){
		
		$this->db->select('count(*) as allcount');
		$this->db->from('store_subscription_master');
				
		$this->db->where('store_id', $this->session->User->store_id);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	
	function store_sub_details($id)
	{
		$this->db->select('ssm.* ,ssm.status as plan_status, sm.*');
		$this->db->from('store_subscription_master as ssm ');
		$this->db->join('subscription_master as sm','sm.subscription_id = ssm.subscription_id','left');
		$this->db->where('store_subscription_id', $id);
		
		return $this->db->get()->row();
	}
	
	function deactive_current_plan(){
		
		$data['status'] = 2;
		$this->db->where('store_id', $this->session->User->store_id);
		$this->db->where('status', 1);
		$this->db->update('store_subscription_master', $data);
		
	}
	
	function set_subscription(){
		
		$this->db->insert('store_subscription_master', $_POST);
		return $this->db->insert_id();
		
	}
	
	function get_store_subscription_details($sspi){
		$this->db->select('ssm.*');
		$this->db->from('store_subscription_master as ssm');
		$this->db->where('ssm.store_subscription_id', $sspi);
		
		return $this->db->get()->row();
	}
	
	function user_relogin($ORDERID){
		$this->db->select('um.*, sm.store_id, sm.Store_name');
		$this->db->from('store_subscription_master as ssm');
		$this->db->join('Store_master as sm','sm.store_id = ssm.store_id','left');
		$this->db->join('User_master as um','um.user_id = sm.user_id','left');
		$this->db->where('ssm.store_subscription_id', $ORDERID);
		return $this->db->get()->row();
		
	}
	
	
	
	
	
	
	
}
?>