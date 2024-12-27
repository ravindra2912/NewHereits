<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Copyright extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Copyright'); 
		
	}
	Public function index()
	{   
			//$Copyright = $this->Mdl_Copyright->get_Copyright();
			$data =array(
				'title'=>'Copy Rights - Hereits',
				'main_content'=>'Copyright',
				'left_sidebar'=>'Copyright', 
			);
			$this->load->view('front_template/template',$data);
		
	}
	
	
	
	
}
?>
