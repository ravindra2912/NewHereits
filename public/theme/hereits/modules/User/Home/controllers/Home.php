<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Home');
		
	}
	Public function index()
	{   
		
		
			//echo 'hello Word';die;
			//redirect('Business');
			$data =array(
				'main_content'=>'Home',
				'left_sidebar'=>'Home', 
				'product_category'=>$this->Mdl_Home->get_categores(1), 
				'service_category'=>$this->Mdl_Home->get_categores(2),  
			);
			$this->load->view('front_template/template',$data);
		
	}
	
	function get_home_elements(){
			$data =array(  
				'products'=>$this->Mdl_Home->ajax_get_products(0,8), 
				'services'=>$this->Mdl_Home->ajax_get_services(0,8), 
				'stores'=>$this->Mdl_Home->ajax_get_stores(0,8), 
			);
		$html = $this->load->view('Home_elements',$data, TRUE);
		
		$res['status'] = 0;
		$res['data'] = $html;
		if($html != null){
			$res['status'] = 1;
			$res['data'] = $html;
		}
		
		
		echo json_encode($res);
	}
	
	// ================= Search =====================================
	function search(){
		$res = $this->Mdl_Home->get_search_result();
		
		$data = '';
		foreach($res as $val){
			if($val->teg_type == 1 && $val->type == 1){
				$tag = "In Products";
				$url = base_url().'Product?search='.$val->tag;
			}else if($val->teg_type == 2 && $val->type == 1){
				$tag = "In Services";
				$url = base_url().'Services?search='.$val->tag;
			}else if($val->type == 2){
				$tag = "In Stores";
			}else if($val->type == 3){
				$tag = "In Category";
			}
			$data .= '<li><span><a href="'.$url.'">'.$val->tag.'</a></span><span style="float: right; margin-top: -20px;">'.$tag.'</span></li>';
		}
		
		if($res == Null){ $data = '<li>Result Not Faund!</li>'; }
		
		echo $data; die;
	}
	
	
}
?>
