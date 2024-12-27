<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faqs extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Faqs'); 
		
	}
	Public function index()
	{   
			//echo 'hello Word';die;
			//redirect('Business');
			
			$Faqs = $this->Mdl_Faqs->get_Faqs();
			$data =array(
				'title'=>'FAQ - Hereits',
				'main_content'=>'Faqs',
				'left_sidebar'=>'Faqs', 
				'Faqs'=>$Faqs, 
			);
			$this->load->view('front_template/template',$data);
		
	}
	
	
	
	
}
?>
