<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terms extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Terms'); 
		
	}
	Public function index()
	{   
			//echo 'hello Word';die;
			//redirect('Business');
			
			$term = $this->Mdl_Terms->get_term();
			$data =array(
				'title'=>'Terms & Conditions - Hereits',
				'main_content'=>'Terms',
				'left_sidebar'=>'Terms', 
				'term'=>$term, 
			);
			$this->load->view('front_template/template',$data);
		
	}
	
	
	
	
}
?>
