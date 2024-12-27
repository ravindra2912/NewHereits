<?php 
class Mdl_Terms extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_term(){
		$this->db->select('Terms_Conditions');
		$this->db->where('id', 1);
		$this->db->from('setting_master');
		return $this->db->get()->row();
	}
	
	
	
}
?>