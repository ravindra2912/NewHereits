<?php 
class Mdl_Profile extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	} 
	function get_single_data()
	{
		$this->db->select('*');
		$this->db->from('Admin_master');
		$this->db->where('id', $_POST['id']); 
		return $this->db->get()->row();
	} 
	function save_Profile()
	{ 
		$this->db->where('id', $_POST['id']); 
		$this->db->update('Admin_master', $_POST); 
	} 
	function change_pssword() 
	{	 
		$data['password'] = md5($_POST['password']); 
		$this->db->where('id', $_POST['id']); 
		$this->db->update('Admin_master', $data); 
	} 
	function get_data() 
	{  
		$this->db->select('*'); 
		$this->db->from('Admin_master'); 
		return $this->db->get()->row(); 
	} 
	//logo End
	
	
	
}
?>