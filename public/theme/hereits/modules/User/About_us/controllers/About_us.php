<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About_us extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_About_us'); 
		
	}
	Public function index()
	{   
			//echo 'hello Word';die;
			//redirect('Business');
			$data =array(
				'main_content'=>'aboutus',
				'left_sidebar'=>'About us', 
			);
			$this->load->view('front_template/template',$data);
		
	}
	
	
	
	
}
?>
