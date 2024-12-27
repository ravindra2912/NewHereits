<?php 
class Mdl_Faqs extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_Faqs(){
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->from('faq_master');
		return $this->db->get()->result();
	}
	
	
	
}
?>