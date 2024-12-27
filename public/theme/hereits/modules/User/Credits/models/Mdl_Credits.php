<?php 
class Mdl_Credits extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_credit(){
		$this->db->select('Credits');
		$this->db->where('id', 1);
		$this->db->from('setting_master');
		return $this->db->get()->row();
	}
	
	
}
?>