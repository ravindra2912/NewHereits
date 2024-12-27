<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_products extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Store_products');
		$this->load->model('Mdl_common');
		$this->load->library("pagination");
		
		if($this->session->User == null)
		{redirect('Login');}
		
		$store_subscription = $this->Mdl_common->get_store_subscription();
		if($store_subscription->type == 2 || $store_subscription->type == 0){redirect('Store_Plans');}
	}
	Public function index() 
	{   
		$product_limit = $this->Mdl_Store_products->product_limit();
		$product_count = $this->Mdl_Store_products->getCount_product();
		$data =array(
			'main_content'=>'Product_list',   
			'product_limit'=>$product_limit,   
			'product_count'=>$product_count,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	function listing(){
		$parent_cat_data = $this->Mdl_Store_products->get_all_parent_category();
		$data =array(
			'main_content'=>'Product_search',   
			'parent_cat_data'=>$parent_cat_data,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	function ajax_search_product($rowno=0){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		
		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
		$res = $this->Mdl_Store_products->ajax_search_product($rowno,$rowperpage);
		$allcount = $this->Mdl_Store_products->ajax_search_product_Count();
		$store_product = $this->Mdl_Store_products->get_all_store_product();
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		$grid = '';
		
		$table = '';
		
	foreach($res as $val){
		
				//product image
			$p_img = $this->Mdl_Store_products->get_product_single_image($val->product_id);
			$img = base_url().'assets/admin/images/no-image.png';
			if(file_exists($p_img->image_url)) { $img = base_url().$p_img->image_url; }
			
			$table .= '<tr id="tr-'.$val->product_id .'">';
			$table .= '<td class="text-center table_img" style="padding: .20rem; vertical-align: unset;"><img src="'.$img.'" style="height: 80px;width: 80px;"></td>';
			
			if ($val->fixed_selling_unit ==0){
				$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$val->product_name .'</td>';
			}elseif ($val->fixed_selling_unit ==1){
				// fixed unit/ quantity display 
				$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$val->product_name .' ('.$val->selling_unit_qty .'-'. $val->selling_unit .')</td>';
			} 
			$instore = 0;
			foreach($store_product as $sp){
				if($sp->product_id == $val->product_id){$instore = 1;}
			}
			if($instore == 0){
				$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a href="'.base_url().'Store_products/add_to_listing/'.$val->product_id .'" class="onclick-load btn btn-md btn-success">Add To Listing</a></td>';
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
		$data['pagination'] = $this->pagination->create_links();
		$data['allcount'] = $allcount;
		$data['row'] = $rowno;
		echo json_encode($data);
	}
	
	function add_to_listing($product_id){
		
		$product_data = $this->Mdl_Store_products->get_single_product($product_id);
		$product_images = $this->Mdl_Store_products->product_images($product_id);
		$category_name = $this->Mdl_Store_products->category_name($product_id);
		$data =array(
			'main_content'=>'add_to_listing',   
			'product_data'=>$product_data, 
			'product_images'=>$product_images,   
			'category_name'=>$category_name,   			
		);
		$this->load->view('Store_template/template',$data);
	}
	
	function submit_to_list(){

		$product_data = $this->Mdl_Store_products->get_single_product($_POST['product_id']);
		if ($product_data->fixed_selling_unit == 1){
			$_POST['selling_unit'] = $product_data->selling_unit;
		}
			
		$this->Mdl_Store_products->submit_to_list();
		
		//slug
		$this->Mdl_common->product_slug($this->session->User->store_id,$_POST['product_id']);
		redirect('Store_products');
	}
	
	Public function update_listing($product_id)	{   
		$product_data = $this->Mdl_Store_products->get_single_store_product($product_id);

		$product_images = $this->Mdl_Store_products->product_images($product_id);
		$category_name = $this->Mdl_Store_products->category_name($product_id);
		$product_limit = $this->Mdl_Store_products->product_limit();
		$product_count = $this->Mdl_Store_products->getCount_product();
		$data =array(
			'main_content'=>'edit_to_listing',     
			'product_data'=>$product_data,   
			'product_images'=>$product_images,   
			'category_name'=>$category_name,
			'product_limit'=>$product_limit,   
			'product_count'=>$product_count, 
		);
		$this->load->view('Store_template/template',$data);
	}
	
	function submit_update_list(){

		$this->Mdl_Store_products->submit_update_list();
		redirect('Store_products');
	}
	
	function get_child_category(){
		$res = $this->Mdl_Store_products->get_child_category($_POST['parent_id']);
		
		$data = '<option value="">Select Child Category</option>';
		foreach($res as $val){
			$data .= '<option value="'.$val->category_id.'">'.$val->category_name.'</option>';
		}
		echo $data;
	}
	
	Public function insert_form()
	{   
		$parent_cat_data = $this->Mdl_Store_products->get_all_parent_category();
		
		$header_import = '<script src="'.base_url().'assets/tags/tagcomplete.js"></script>
							<link rel="stylesheet" href="'.base_url().'assets/tags/tag.css">';
		
		$data =array(
			'main_content'=>'Product_add',   
			'parent_cat_data'=>$parent_cat_data,   
			'header_import'=>$header_import,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	function get_product_data($rowno=0){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		// Row per page
		$rowperpage = 10;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Store_products->getrecordCount_product();

		// Get records
		$record = $this->Mdl_Store_products->get_product_data($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		$grid = '';
		foreach($record as $res){
			
			if($res->product_tb_status == 0){
			   $status = 'Panding For Approval';
			}else if($res->product_tb_status == 1){
			   if($res->product_status == 1)
			   {
				$status = 'Live';
			   }else if($res->product_status == 0)
			   {
				$status = 'Offline';
			   }
			   
			}else if($res->product_tb_status == 2){
			   $status = 'Paused';
			}
			
			//product image
			$p_img = $this->Mdl_Store_products->get_product_single_image($res->product_id);
			$img = base_url().'assets/admin/images/no-image.png';
			if(file_exists($p_img->image_url)) { $img = base_url().$p_img->image_url; }
			
			//this for table veiw
			$table .= '<tr id="tr-'.$res->product_id .'">';
			$table .= '<td class="text-center table_img" style="padding: .20rem; vertical-align: unset;"><img src="'.$img.'" style="height: 80px;width: 80px;"></td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->product_name .' ('.$res->selling_unit_qty .'-'.$res->selling_unit .')</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->product_qty .'</td>';
			if( $res->price_type == 1 ){
				$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->product_sele_price .'</td>';
			} elseif ( $res->price_type == 2){
				$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->product_sele_price .'-'.$res->product_price .'</td>';
			}elseif ( $res->price_type == 3){
				$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">Ask Price</td>';
			}
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a onclick="delete_product('.$res->product_id .')"  style="color: red;padding-right: 7px;"><i class="fas fa-trash-alt"></i></a><a href="'.base_url().'Store_products/update_listing/'.$res->product_id.'" class="onclick-load" style="color: blue;padding-right: 7px;"><i class="fas fa-edit"></i></i></a></td>';
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
									<span class="price"><span style="font-size: 19px; color: black;" class="amount">Rs. '.$res->product_sele_price .'</span><del style="margin-left: 7px;" class="amount">Rs. '.$res->product_price .'</del></span>
									<div style="height: 50;">
										<h3 class="p-name">'.$res->product_name .'</h3>
									</div>
								</div>
							</div>
							<div class="col-6" >
								<div class="nav-item dropdown" style="text-align: center;">
									<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
									  Edit <span class="caret"></span>
									</a>
									<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 40px, 0px);">
										<a class="dropdown-item" tabindex="-1" onclick="delete_product('.$res->product_id .')" href="#">Delete</a>
										<div class="dropdown-divider"></div>
										<a class="onclick-load dropdown-item" tabindex="-1" href="'.base_url().'Store_products/update_listing/'.$res->product_id.'">Edit</a>
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
		
		
		echo json_encode($data);
	}
	
	function get_tag(){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		$tags = $this->Mdl_Store_products->get_tag();
		echo json_encode($tags);
	}
	
	function insert_product(){
		$product_id = $this->Mdl_Store_products->insert_product();
		
		//slug
		$this->Mdl_common->product_slug($this->session->User->store_id,$product_id);
		
		redirect('Store_products/Product_image/'.$product_id);
	
	}

	function update_product(){
		$this->Mdl_Store_products->update_product();
		redirect('Product_image');
	}
	
	function Product_image($product_id){
		$data =array(
			'main_content'=>'Product_image',   
			'product_id'=>$product_id,  
		);
		$this->load->view('Store_template/template',$data);
	}
	
	function get_product_images(){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		$res = $this->Mdl_Store_products->get_product_images();
		$data = '';
		foreach($res as $val){
			$data .='
				<div class="filtr-item col-sm-2 col-6" id="product_img-'.$val->id.'" style="margin: 0px 0px 20px 0px;box-shadow: 0 0 1px rgba(0,0,0,.105),0 5px 3px rgba(0,0,0,.2);text-align: center;">
					<div style="height: 150px;text-align: center;">
						<img onclick="image_view_modal(this.src)" src="'.base_url().$val->image_url.'" class="img-fluid mb-2" alt="Product Image" style="height: 140px;object-fit: contain;"/> 
					</div>
					<div class="row" style="margin-bottom: 6px;">
						<div class="col-sm-10">
							<input id="order-'.$val->id.'" onchange="chnage_image_order('.$val->id.')" type="text" name="product_sele_price" value="'.$val->image_order.'" class="form-control" >
						</div>
						<div class="col-sm-2" style="margin-top: 4px;">
							<a onclick="delete_product_image('.$val->id.')" style="color: red;"><i class="fas fa-trash-alt"></i></a>
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

	function get_product_images_count(){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
	  $allcount = $this->Mdl_Store_products->get_product_images_count();
	 
		echo json_encode($allcount);
	}
	
	function add_product_image(){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		if($_FILES['product_images']['name'] != null)
		{
			$target_path = "uploads/product_images/";
			$ext = explode('.', basename($_FILES['product_images']['name']));
			$digits = 4;
			$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
			$c_name = $_POST['product_id'].'-'.time().'-'.$rands . "." . $ext[count($ext) - 1];
			$c_image = $target_path . $c_name;
			move_uploaded_file($_FILES['product_images']['tmp_name'], $c_image);
			if(file_exists($c_image)) {
				$img = $target_path.$c_name;
				$this->Mdl_Store_products->insert_product_images($img);
			}
		}
		die;
	}
	
	function chnage_product_image_order(){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		$this->Mdl_Store_products->chnage_product_image_order();
		die;
	}
	
	function delete_product(){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		$res = $this->Mdl_Store_products->delete_product();	
		die;
		
	}
	
	function delete_product_image(){
			(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
			$pim = $this->Mdl_Store_products->get_product_img();
			$path = $pim->image_url;
			if(file_exists($path))
			{
				unlink($path); 
			}	
			$this->db->where('id', $pim->id);
			$this->db->delete('product_image_master');
			
			die;
	}
	
}
?>
