<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Report');
		$this->load->model('Mdl_emails');
		
	}
	Public function index()
	{   
		$data =array(
				'main_content'=>'Report',
				'left_sidebar'=>'Home', 
			);
			$this->load->view('user_template/template',$data);
		
	}
	
	function insert_report(){
		$this->Mdl_Report->insert_report();
		redirect('Home');
	}
	
	
}
?>
