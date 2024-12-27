<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_service_charge extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Store_service_charge');
		$this->load->model('Mdl_common');
		
		if($this->session->User == null)
		{redirect('Login');}
		
		$store_subscription = $this->Mdl_common->get_store_subscription();
		if($store_subscription->type == 1 || $store_subscription->type == 0){redirect('Store_Plans');}
	}
	
	Public function index()
	{  
		$store_info = $this->Mdl_Store_service_charge->get_store_details();
		
		
		$data =array(
			'main_content'=>'service_charges',   
			'store_info'=>$store_info,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	
	function update(){
		$this->Mdl_Store_service_charge->update();
		
		redirect('Store_service_charge');
	}
}
?>
