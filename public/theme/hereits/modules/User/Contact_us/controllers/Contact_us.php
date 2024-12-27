<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_us extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Contact_us'); 
		
	}
	Public function index()
	{   
			//echo 'hello Word';die;
			//redirect('Business');
			$data =array(
				'main_content'=>'contactus',
				'left_sidebar'=>'contactus', 
			);
			$this->load->view('front_template/template',$data);
		
	}
	
	
	
	
}
?>
