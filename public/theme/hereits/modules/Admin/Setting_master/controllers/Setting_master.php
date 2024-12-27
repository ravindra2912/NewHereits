<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_master extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Setting_master');
		
		if($this->session->Admin == null)
		{redirect('Admin');}
	}
	
	Public function index()
	{    
		$data =array(
			'main_content'=>'Product_list',   
		);
		$this->load->view('admin_template/template',$data);
	}
	
	function Aboutus(){
		
		$details = $this->Mdl_Setting_master->get_data();
		$data =array(
			'main_content'=>'Aboutus',   
			'left_sidebar'=>'Aboutus',   
			'details'=>$details,   
		);
		$this->load->view('admin_template/template',$data);
	}
	
	function update_Aboutus(){
		$this->Mdl_Setting_master->update_Aboutus();
		
		redirect('Setting_master/Aboutus');
	}
	
	function Credits(){
		
		$details = $this->Mdl_Setting_master->get_data();
		$data =array(
			'main_content'=>'Credits',   
			'left_sidebar'=>'Credits',   
			'details'=>$details,   
		);
		$this->load->view('admin_template/template',$data);
	}
	
	function update_Credits(){
		$this->Mdl_Setting_master->update_Credits();
		
		redirect('Setting_master/Credits');
	}
	
	function Terms_Conditions(){
		
		$details = $this->Mdl_Setting_master->get_data();
		$data =array(
			'main_content'=>'Terms_Conditions',   
			'left_sidebar'=>'Terms Conditions',   
			'details'=>$details,   
		);
		$this->load->view('admin_template/template',$data);
	}
	
	function update_Terms_Conditions(){
		$this->Mdl_Setting_master->update_Terms_Conditions();
		
		redirect('Setting_master/Terms_Conditions');
	}
	
	
	
	function Privacy_policy(){
		
		$details = $this->Mdl_Setting_master->get_data();
		$data =array(
			'main_content'=>'Privacy_Policy',   
			'left_sidebar'=>'Privacy Policy',   
			'details'=>$details,   
		);
		$this->load->view('admin_template/template',$data);
	}
	
	function update_privacy_policy(){
		$this->Mdl_Setting_master->update_privacy_policy();
		
		redirect('Setting_master/Privacy_policy');
	}
	
	function copyright_Policy(){
		
		$details = $this->Mdl_Setting_master->get_data();
		$data =array(
			'main_content'=>'copyright_Policy',   
			'left_sidebar'=>'Privacy Policy',   
			'details'=>$details,   
		);
		$this->load->view('admin_template/template',$data);
	}
	
	function update_copyright_Policy(){
		$this->Mdl_Setting_master->update_copyright_Policy();
		
		redirect('Setting_master/copyright_Policy');
	}
	
	function Banner(){
		
		$Banners = $this->Mdl_Setting_master->get_Banners();
		$data =array(
			'main_content'=>'Banner_list',   
			'left_sidebar'=>'Banner',   
			'Banners'=>$Banners,   
		);
		$this->load->view('admin_template/template',$data);
	}
	
	function add_banner(){
		
		if($_FILES['banner_image']['name'] != null)
		{
			$target_path = "uploads/banner_image/";
			$ext = explode('.', basename($_FILES['banner_image']['name']));
			$digits = 2;
			$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
			$c_name = time().'-'.$rands . "." . $ext[count($ext) - 1];
			$c_image = $target_path . $c_name;
			move_uploaded_file($_FILES['banner_image']['tmp_name'], $c_image);
			if(file_exists($c_image)) {
				$img = $target_path.$c_name;
				$this->Mdl_Setting_master->add_banner($img);
			}
		}	
		redirect('Setting_master/Banner');
	}
	
	function delete_banner($id){
		$res = $this->Mdl_Setting_master->get_single_banner($id);
		//delete image
		$path = $res->image_url;
		if(file_exists($path)) { unlink($path); }
		
		//delete record
		$this->db->where('id', $id);
		$this->db->delete('banner_master');
		
		redirect('Setting_master/Banner');
	}
	
	function site_setting(){
		$details = $this->Mdl_Setting_master->get_data();
		$data =array(
			'main_content'=>'Site_setting',   
			'left_sidebar'=>'Site Setting',   
			'details'=>$details,   
		);
		$this->load->view('admin_template/template',$data);
	}
	
	function update_site_setting(){
		$this->Mdl_Setting_master->update_site_setting();
		
		redirect('Setting_master/site_setting');
	}
	
	
	
	
}
?>
