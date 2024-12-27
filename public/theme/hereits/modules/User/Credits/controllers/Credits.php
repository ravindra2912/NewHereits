<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Credits extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Credits'); 
		
	}
	Public function index()
	{   	$credit = $this->Mdl_Credits->get_credit();
			$data =array(
				'title'=>'Credits - Hereits',
				'main_content'=>'Credits',
				'left_sidebar'=>'Credits', 
				'credit'=>$credit, 
			);
			$this->load->view('front_template/template',$data);
		
	}
	
	
	
	
}
?>
