<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_Setting extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Store_Setting');
		
		if($this->session->User == null)
		{redirect('Login');}
	}
	
	function Aboutus(){
		
		$details = $this->Mdl_Store_Setting->get_data();
		$data =array(
			'main_content'=>'Aboutus',   
			'left_sidebar'=>'Aboutus',   
			'details'=>$details,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	function update_Aboutus(){
		$this->Mdl_Store_Setting->update_Aboutus();
		
		redirect('Store_Setting/Aboutus');
	}
	
	function Terms_Conditions(){
		
		$details = $this->Mdl_Store_Setting->get_data();
		$data =array(
			'main_content'=>'Terms_Conditions',   
			'left_sidebar'=>'Terms Conditions',   
			'details'=>$details,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	function update_Terms_Conditions(){
		$this->Mdl_Store_Setting->update_Terms_Conditions();
		
		redirect('Store_Setting/Terms_Conditions');
	}
	
}
?>
