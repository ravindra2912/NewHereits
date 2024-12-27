<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Version_management extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Version_management');
		$this->load->library("pagination");
		
		if($this->session->Admin == null)
		{redirect('Admin');}
	}
	Public function index()
	{  
		$logo = $this->Mdl_Version_management->logo();
		$version = $this->Mdl_Version_management->get_version();
		$data =array(
			'main_content'=>'Version_page', 
			'logo'=> $logo, 
			'version'=> $version, 
			
		);
		$this->load->view('admin_template/template',$data);
	}
		
}
?>
