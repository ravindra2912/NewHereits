<?php 
class Mdl_Logo extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	//logo Start
	function change_logo($val)
	{
		$this->db->where('type','main');
		$this->db->update('logo', $val);
	}		
	
	function change_tab_logo($val)
	{
		$this->db->where('type','tab');
		$this->db->update('logo', $val);
	}
	
	function get_logo()
	{ 
		$this->db->select('*'); 
		$this->db->where('type','main');		
		$this->db->from('logo'); 
		return $this->db->get()->row();	
	} 		
	
	function get_tab_logo()
	{ 
		$this->db->select('*'); 
		$this->db->where('type','tab');	
		$this->db->from('logo'); 
		return $this->db->get()->row();	
	} 
	//logo End
	
	
	
}
?>