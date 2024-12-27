<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privacy extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Privacy'); 
		
	}
	Public function index()
	{   
			$privacy = $this->Mdl_Privacy->get_privacy();
			$data =array(
				'title'=>'Privacy - Hereits',
				'main_content'=>'Privacy',
				'left_sidebar'=>'Privacy', 
				'privacy'=>$privacy, 
			);
			$this->load->view('front_template/template',$data);
		
	}
	
	
	
	
}
?>
