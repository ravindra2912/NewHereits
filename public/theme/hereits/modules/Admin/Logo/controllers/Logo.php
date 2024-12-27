<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logo extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Logo');
		
		if($this->session->Admin == null)
		{redirect('Login');}
	}
	Public function index()
	{ 
		if($this->session->Admin != null)
		{
			 
				if($_FILES['logo'] != null)
				{
					$target_path = "uploads/logo/";
					$ext = explode('.', basename($_FILES['logo']['name']));
					$digits = 2;
					$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
					$c_name = $rands . "." . $ext[count($ext) - 1];
					$c_image = $target_path . $c_name;
					move_uploaded_file($_FILES['logo']['tmp_name'], $c_image);
					if(file_exists($c_image)) {
						
					//delete provider image
					$logo = $this->Mdl_Logo->get_logo();
					$target_path = "uploads/logo/";
					$path = $target_path . $logo->image;
					if(file_exists($path)) { unlink($path); }
			
					$val['image'] = $c_name;
					$this->Mdl_Logo->change_logo($val);
					}
				} 
			
			$logo = $this->Mdl_Logo->get_logo();
			$tab_logo = $this->Mdl_Logo->get_tab_logo();
			$data =array(
				'main_content'=>'logo',
				'left_sidebar'=>'logo', 
				'logo'=>$logo,  
				'tab_logo'=>$tab_logo,  
			);
			$this->load->view('admin_template/template',$data);
		}else{
			redirect('Login');
		}
	}
	function change_tab_logo()
	{ 
			if($_FILES['logo'] != null)
			{
				$target_path = "uploads/logo/";
				$ext = explode('.', basename($_FILES['logo']['name']));
				$digits = 2;
				$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
				$c_name = $rands . "." . $ext[count($ext) - 1];
				$c_image = $target_path . $c_name;
				move_uploaded_file($_FILES['logo']['tmp_name'], $c_image);
				if(file_exists($c_image)) {
					
				//delete provider image
				$logo = $this->Mdl_Logo->get_tab_logo();
				$target_path = "uploads/logo/";
				$path = $target_path . $logo->image;
				if(file_exists($path)) { unlink($path); }
		
				$val['image'] = $c_name;
				$this->Mdl_Logo->change_tab_logo($val);
				}
			} 
		redirect('Logo');
		
	}
}
?>
