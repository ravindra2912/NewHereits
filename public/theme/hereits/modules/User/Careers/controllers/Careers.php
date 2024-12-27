<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Careers extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Careers'); 
		
	}
	Public function index()
	{   
			$data =array(
				'main_content'=>'Careers',
				'left_sidebar'=>'Careers', 
			);
			$this->load->view('user_template/template',$data);
		
	}
	
	Public function apply()
	{   
			$data =array(
				'main_content'=>'apply',
				'left_sidebar'=>'apply', 
			);
			$this->load->view('user_template/template',$data);
		
	}
	
	
	
	
}
?>
