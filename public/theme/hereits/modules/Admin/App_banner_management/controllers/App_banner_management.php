<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_banner_management extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_App_banner_management');
		if($this->session->Admin == null)
		{redirect('Admin');}
		
	}
	Public function index()
	{   
		$data =array(
			'main_content'=>'App_banner',   
		);
		$this->load->view('admin_template/template',$data);
	}	
	
	function get_app_banners(){
		
		$res = $this->Mdl_App_banner_management->get_app_banners();
		$data = '';
		foreach($res as $val){
			$data .='
				<div class="filtr-item col-sm-4 col-6" id="product_img-'.$val->id.'" style="margin: 0px 0px 20px 0px;box-shadow: 0 0 1px rgba(0,0,0,.105),0 5px 3px rgba(0,0,0,.2);text-align: center;">
					<div style="height: 150px;text-align: center;">
						<img onclick="image_view_modal(this.src)" src="'.base_url().$val->image_url.'" class="img-fluid mb-2" alt="Product Image" style="height: 140px;object-fit: contain;"/> 
					</div>
					<div class="row" style="margin-bottom: 6px;">
						<div class="col-sm-10">
							<input id="order-'.$val->id.'" onchange="chnage_image_order('.$val->id.')" type="text" name="product_sele_price" value="'.$val->order.'" class="form-control" >
						</div>
						<div class="col-sm-2" style="margin-top: 4px;">
							<a onclick="delete_app_banner('.$val->id.')" style="color: red;"><i class="fas fa-trash-alt"></i></a>
						</div>
					</div>
					<div class="row" style="margin-bottom: 2px;  justify-content: center;">
						<label>Set Image order</label>
					</div>
				</div>
			';
		}
		echo $data;
		die;
	}
	
	
	function add_app_banner(){
		if($_FILES['app_banner_images']['name'] != null)
		{
			$target_path = "uploads/app_banner_images/";
			$ext = explode('.', basename($_FILES['app_banner_images']['name']));
			$digits = 4;
			$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
			$c_name = 'Banner-'.time().'-'.$rands . "." . $ext[count($ext) - 1];
			$c_image = $target_path . $c_name;
			move_uploaded_file($_FILES['app_banner_images']['tmp_name'], $c_image);
			if(file_exists($c_image)) {
				$img = $target_path.$c_name;
				$this->Mdl_App_banner_management->insert_app_banner_images($img);
			}
		}
		die;
	}
	
	function chnage_image_order(){
		$this->Mdl_App_banner_management->chnage_image_order();
		die;
	}
	
	
	function delete_app_banner(){
			
			$pim = $this->Mdl_App_banner_management->get_app_banner_img();
			$path = $pim->image_url;
			if(file_exists($path))
			{
				unlink($path); 
			}	
			$this->db->where('id', $pim->id);
			$this->db->delete('app_banner_master');
			
			die;
	}
	
}
?>
