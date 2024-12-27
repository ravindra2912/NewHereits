<?php 
class Mdl_Admin extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kuala_Lumpur");
	} 
	
	function login_check()
	{   
    	$this->db->where('email', $_POST['email_id']);
		$this->db->where('password',md5($_POST['password'])); 
		$data=$this->db->get('Admin_master');
		return $data->row(); 
	} 
}
?>