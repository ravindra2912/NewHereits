<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Admin');
	}
	
	Public function index()
	{  
		$data =array(
		);
		$this->load->view('login',$data); 
		
		/*$data =array(
				'main_content'=>'login',
				'left_sidebar'=>'Dashboard',
			);
			$this->load->view('admin_template/template',$data);*/
	}
	
	
	public function chack_login()
	{   
		$rowdata = $this->Mdl_Admin->login_check(); 
		
		if($rowdata == null)
		{    
			$credential=$_POST['email_id'];
			$this->session->set_flashdata('credential',$credential);
			$error_msg='Login failed. Please enter a valid email id and password.';
			$this->session->set_flashdata('error_msg',$error_msg);
			redirect('Admin'); 
			
		}else
		{
			unset($rowdata->password); 
			$this->session->set_userdata("Admin",$rowdata);
			$success_msg='Welcome '.$rowdata->email_id.'';
			$this->session->set_flashdata('success_msg',$success_msg);   
			redirect('Dashboard');
		}
		
	}
	
	Public function logout()
	{
		$all_userdata = $this->session->all_userdata();
		$this->session->unset_userdata($all_userdata);
        session_destroy();   
        redirect('Admin');
	}
}
?>
