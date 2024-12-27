<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_Packages extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Store_Packages');
		$this->load->model('Mdl_common');
		$this->load->library("pagination");
		
		if($this->session->User == null)
		{redirect('Login');}
		
		$store_subscription = $this->Mdl_common->get_store_subscription();
		if($store_subscription->type == 1 || $store_subscription->type == 0){redirect('Store_Plans');}
	}
	Public function index()
	{  
		$package_count = $this->Mdl_Store_Packages->active_package_count();
		$package_Limit = $this->Mdl_Store_Packages->getCount_packages();
	
		$data =array(
			'main_content'=>'Packages_list',   
			'package_count'=>$package_count,   
			'package_Limit'=>$package_Limit,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	
	//ajex get Coupons list
	function get_packages_data($rowno=0){
		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Store_Packages->getrecordCount_packages();

		// Get records
		$record = $this->Mdl_Store_Packages->get_package_data($rowno,$rowperpage);

		
		// Pagination Configuration
		$config['base_url'] = "";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		$grid = '';
		
		
		foreach($record as $res){
			
			$category = $this->Mdl_Store_Packages->category_name($res->Package_id);
			
			if($res->packege_tb_status == 0){
			   $status = 'Panding For Approval';
			}else if($res->packege_tb_status == 1){
			   if($res->packege_status == 1)
			   {
				$status = 'Live';
			   }else if($res->packege_status == 0)
			   {
				$status = 'Offline';
			   }
			   
			}else if($res->packege_tb_status == 2){
			   $status = 'Paused';
			}
			
			$img = base_url().'assets/admin/images/no-image.png';
			if(file_exists($res->packege_image)) { $img = base_url().$res->packege_image; }
			
			
			//this for table veiw
			$table .= '<tr id="tr-'.$res->Package_id .'">';
						$table .= '<td class="text-center table_img" style="padding: .20rem; vertical-align: unset;"><img src="'.$img.'" style="height: 80px;width: 80px;"></td>';

			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Package_name .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$category->category_name .'</td>';
			if( $res->price_type == 2 ){
				$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->packege_sale_price .'-'.$res->packege_price .'</td>';
			} elseif( $res->price_type == 1){
				$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->packege_sale_price .'</td>';
			} elseif( $res->price_type == 3){
				$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">Ask Price</td>';
			}
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">
							<a onclick="delete_package('.$res->Package_id .')"  style="color: red;padding-right: 7px;"><i class="fas fa-trash-alt"></i></a>
							<a href="'.base_url().'Store_Packages/update_form/'.$res->Package_id.'" style="color: blue;padding-right: 7px;"><i class="fas fa-edit"></i></i></a></td>';
			$table .= '</tr>';
			
			//this for grid view
			$grid .='
				
				<div class="col-12" style="box-shadow: 2px 2px 20px rgba(107, 128, 168, 0.6); margin-bottom: 10px;background-color: white;" id="tr-'.$res->product_id .'">
					<div class="noo-product-inner"> <!-- productssize -->
						<div class="row">
							<div class="col-4">
								<div class="noo-product-thumbnail">
									<img class="pimg" src="'.$img.'" alt="product">
								</div>
							</div>
							<div class="col-8">
								<div class="noo-product-title">
									<span class="price"><span style="font-size: 19px;" class="amount">Rs. '.$res->packege_price .'</span></span>
									<div style="height: 50;">
										<h3 class="p-name">'.$res->Package_name .'</h3>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="nav-item dropdown" style="text-align: center;">
									<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
									  Edit <span class="caret"></span>
									</a>
									<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 40px, 0px);">
										<a class="dropdown-item" tabindex="-1" onclick="delete_package('.$res->Package_id .')" href="#">Delete</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" tabindex="-1" href="'.base_url().'Store_Packages/update_form/'.$res->Package_id.'">Edit</a>
									</div>
								</div>
							</div>
							<div class="col-6" style="margin-bottom: -10px;">
								<p style="text-align: center; margin-top: 8px;'; if($status == 'Live'){$grid .='color:green;';}else{$grid .='color:red;';}$grid .='">
									'.$status.'
								</p>
							</div>
						</div>
					</div>
				</div>
				
			';
		}
		
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['table_view'] = $table;
		$data['grid_view'] = $grid;
		$data['row'] = $rowno;
		$data['norecord ']=$norecord ;
		
		
		echo json_encode($data);
	}
	
	Public function Package_search()
	{   
		$parent_cat_data = $this->Mdl_Store_Packages->get_all_parent_category();
		$data =array(
			'main_content'=>'Package_search', 
			'parent_cat_data'=>$parent_cat_data, 
			
		);
		$this->load->view('Store_template/template',$data);
	}
	
	function ajax_search_package(){
	$res = $this->Mdl_Store_Packages->ajax_search_package();
	$store_package = $this->Mdl_Store_Packages->get_all_store_packages();	
		$table = '';
		
	foreach($res as $val){
		
				//product image
			//$p_img = $this->Mdl_Store_Packages->get_package_single_image($val->Package_id);
			$img = base_url().'assets/admin/images/no-image.png';
			if(file_exists($val->packege_image)) { $img = base_url().$val->packege_image; }
			
			$table .= '<tr id="tr-'.$val->Package_id .'">';
			$table .= '<td class="text-center table_img" style="padding: .20rem; vertical-align: unset;"><img src="'.$img.'" style="height: 80px;width: 80px;"></td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$val->Package_name .'</td>';
			
			$instore = 0;
			foreach($store_package as $sp){
				if($sp->Package_id == $val->Package_id){$instore = 1;}
			}
			if($instore == 0){
				$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a href="'.base_url().'Store_Packages/add_to_listing/'.$val->Package_id .'" class="onclick-load btn btn-md btn-success">Add To Listing</a></td>';
			}else{
				$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a href="#" class="btn btn-md btn-info">already In List</a></td>';

			}
			
			$table .= '</tr>';

	}
		
		if($res == NULL){
			$data['status'] = 0;
		}else{
			$data['status'] = 1;
		}
		
		$data['table_view'] = $table;
		echo json_encode($data);
	}
	
	function add_to_listing($id){
		
		// listing edit page
		$package_data = $this->Mdl_Store_Packages->get_single_package($id);
		$category_name = $this->Mdl_Store_Packages->category_name($id);
		$data =array(
			'main_content'=>'add_to_listing',   
			'package_data'=>$package_data,   
			'category_name'=>$category_name,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	function submit_to_list(){
		$this->Mdl_Store_Packages->submit_to_list();
		
		//slug
		$this->Mdl_common->package_slug($this->session->User->store_id, $_POST['Package_id']);
		
		redirect('Store_Packages');
	}
	
	Public function insert_form()
	{   
		$parent_cat_data = $this->Mdl_Store_Packages->get_all_parent_category();
		
		$header_import = '<script src="'.base_url().'assets/tags/tagcomplete.js"></script>
							<link rel="stylesheet" href="'.base_url().'assets/tags/tag.css">';
		$data =array(
			'main_content'=>'Package_add', 
			'parent_cat_data'=>$parent_cat_data,
			'header_import'=>$header_import,  
		);
		$this->load->view('Store_template/template',$data);
	}
	
	function get_tag(){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		$tags = $this->Mdl_Store_Packages->get_tag();
		echo json_encode($tags);
	}
	
	function insert_package(){
		
		if($_FILES['packege_images']['name'] != null)
		{
			$target_path = "uploads/packege_images/";
			$ext = explode('.', basename($_FILES['packege_images']['name']));
			$digits = 4;
			$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
			$c_name = $_POST['product_id'].'-'.time().'-'.$rands . "." . $ext[count($ext) - 1];
			$c_image = $target_path . $c_name;
			move_uploaded_file($_FILES['packege_images']['tmp_name'], $c_image);
			if(file_exists($c_image)) {
				$img = $target_path.$c_name;
			
			}
		}
		
		$packege_id = $this->Mdl_Store_Packages->insert_package($img);
		
		//slug
		$this->Mdl_common->package_slug($this->session->User->store_id, $packege_id);
		
		redirect('Store_Packages');
	}
		
		

	Public function update_form($Package_id)
	{   
		$package_data = $this->Mdl_Store_Packages->single_store_Package($Package_id);
		$category_name = $this->Mdl_Store_Packages->category_name($Package_id);
		$package_count = $this->Mdl_Store_Packages->active_package_count();
		$package_Limit = $this->Mdl_Store_Packages->getCount_packages();
		
		$data =array(
			'main_content'=>'Package_edit',   
			'package_data'=>$package_data,   
			'category_name'=>$category_name,   
			'package_count'=>$package_count,   
			'package_Limit'=>$package_Limit,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	function update_package(){
		$this->Mdl_Store_Packages->update_package();
		redirect('Store_Packages');
	}
	
	function delete_package(){
		$res = $this->Mdl_Store_Packages->delete_package($_POST['Package_id']);
		die;
	}
	
	
	
}
?>
