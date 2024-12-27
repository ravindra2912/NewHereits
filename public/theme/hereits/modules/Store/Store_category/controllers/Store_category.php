<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_category extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Store_category');
		
		if($this->session->User == null)
		{redirect('Login');}
	}
	
	Public function index()
	{  
		
		$data =array(
			'main_content'=>'Store_Category',   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	Public function Product_category()
	{  
		
		$data =array(
			'main_content'=>'Store_Category',   
			'left_sidebar'=>'Product_category',   
			'type'=>1,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	Public function service_category()
	{  
		
		$data =array(
			'main_content'=>'Store_Category',   
			'left_sidebar'=>'service_category',   
			'type'=>2,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	
	public function get_store_category_data()
	{   
		$res = $this->Mdl_Store_category->get_store_category_data();
		
		$data = '';
		foreach($res as $cat){
			
			//category image
			$img = base_url().'assets/admin/images/no-image.png';
			if(file_exists($cat->category_image)) { $img = base_url().$cat->category_image; }
			
			$data .='
					<tr id="cat-'.$cat->category_id.'">
						<td class="text-center table_img" style="padding: .20rem; vertical-align: unset;"><img src="'.$img.'" style="height: 50px;width: 50px;"></td>
						<td class="text-center">'.$cat->category_name.'</td>
						<td class="text-center"><a onclick="delete_Store_category('.$cat->category_id.')" style="color: red;padding-right: 7px;"><i class="fas fa-trash-alt"></i></a></td>
					</tr>
			';
		}
		echo $data;
	}
	
	function get_suggestion_category_data(){
		$res = $this->Mdl_Store_category->get_suggestion_category_data();
		$store_cat = $this->Mdl_Store_category->get_store_category_data();
		
		$data = '';
		foreach($res as $cat){
				$show = 1;
				foreach($store_cat as $sc){
					if($sc->category_id == $cat->category_id){ $show = 0; }
				}
				if($show == 1){
					$data .='
					<tr id="store-cat-'.$cat->category_id.'">
						<td class="text-center">'.$cat->category_name.'</td>
						<td class="text-center"><a class="btn btn-md btn-success" onclick="add_category('.$cat->category_id.')" style="color: white;">Add</a></td>
					</tr>
			';
				}
				
				
			
			
		}
		echo $data;
		die;
	}
	
	function add_category_to_store_cat(){
		$res = $this->Mdl_Store_category->get_store_single_category_data($_POST['id']);
		
		if($res == NULL){
			$data['store_id'] = $this->session->User->store_id;
			$data['category_id'] = $_POST['id'];
			$this->db->insert('Store_category_master',$data);
			echo '1';
			die;
		}else{
			echo '0';
			die;
		}
	}
	
	function delete_Store_category(){
		
		//delete store category
		$this->db->where('category_id', $_POST['category_id']);
		$this->db->where('store_id',$this->session->User->store_id);
		$this->db->delete('Store_category_master');
		die;
	}
}
?>
