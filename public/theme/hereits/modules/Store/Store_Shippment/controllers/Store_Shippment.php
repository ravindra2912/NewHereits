<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_Shippment extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Store_Shippment');
		$this->load->model('Mdl_common');
		
		if($this->session->User == null)
		{redirect('Login');}
		
		$store_subscription = $this->Mdl_common->get_store_subscription();
		if($store_subscription->type == 2 || $store_subscription->type == 0){redirect('Store_Plans');}
	}
	
	Public function index()
	{  
		$store_info = $this->Mdl_Store_Shippment->get_store_details();
		
		
		$data =array(
			'main_content'=>'Store_Shippment',   
			'store_info'=>$store_info,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	
	function update_shippment(){
		$this->Mdl_Store_Shippment->update_shippment();
		$store_info = $this->Mdl_Store_Shippment->get_store_details();
		$this->session->set_flashdata('success', 'Shippment Updated successfully');
		$data =array(
			'main_content'=>'Store_Shippment',   
			'store_info'=>$store_info,   
		);
		$this->load->view('Store_template/template',$data);

	}
}
?>
