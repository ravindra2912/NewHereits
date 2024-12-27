<?php 
class Mdl_Privacy extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_privacy(){
		$this->db->select('Privacy_policy');
		$this->db->where('id', 1);
		$this->db->from('setting_master');
		return $this->db->get()->row();
	}
	
	
	
}
?>