<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Profile');
		
		if($this->session->Admin == null)
		{redirect('Login');}
	}
	Public function index()
	{ 
			
		$info = $this->Mdl_Profile->get_data();
		$data =array(
			'main_content'=>'profile',
			'left_sidebar'=>'Profile', 
			'info'=>$info, 
		);
		$this->load->view('admin_template/template',$data);
		
	}
	
	function save_Profile()
	{
		$this->Mdl_Profile->save_Profile();
		redirect('Profile');
	}
	
	function change_pssword()
	{
		$this->Mdl_Profile->change_pssword();
		redirect('Profile');
	}
	
	function delete_product($p_id)
	{
		
		
		$this->Mdl_Product->delete_product($p_id);
		redirect('Product');
	}
}
?>
