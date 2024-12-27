<?php
class Mdl_store_common extends CI_Model{	
	function __construct()	{		
		parent::__construct();     	
	}
	
	function get_store_subscription(){
		$this->db->select('ssm.*, sm.type');
		$this->db->from('store_subscription_master as ssm');
		$this->db->join('subscription_master as sm', 'sm.subscription_id = ssm.store_subscription_id','left');
		$this->db->where('ssm.store_id', $this->session->User->store_id);
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		return $this->db->get()->row();
	}
	
	
}
?>