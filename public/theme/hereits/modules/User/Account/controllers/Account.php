<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Account');
		$this->load->model('Mdl_common');
		$this->load->library("pagination");
		
		if($this->session->User == null){ redirect('Home'); }
	}
	Public function index()
	{  
		
		$header_import = '';
		$footer_import = '';
		$data =array(
			'main_content'=>'Account',
			'SCO'=>'', 
			'header_import'=>$header_import, 
			'footer_import'=>$footer_import, 
		);
		$this->load->view('front_template/template',$data);
		
	}
	
	/* =================== my profile ====================*/
	
	Public function My_profile()
	{  
		$profile_data = $this->Mdl_Account->get_profile();
		
		$header_import = '';
		$footer_import = '';
		$data =array(
			'main_content'=>'my_profile',
			'SCO'=>'', 
			'header_import'=>$header_import, 
			'footer_import'=>$footer_import, 
			'profile_data'=>$profile_data, 
		);
		$this->load->view('front_template/template',$data);
		
	}
	
	function reset_password()
	{
		
		$header_import = '';
		$footer_import = '';
		$data =array(
			'main_content'=>'Reset_password',
			'SCO'=>'', 
			'header_import'=>$header_import, 
			'footer_import'=>$footer_import, 
		);
		$this->load->view('front_template/template',$data);
	}
	function update_password()
	{
			$check_pswrd = $this->Mdl_Account->check_pswrd();
			if ($check_pswrd == NULL){
				$error_msg='Please Enter Correct Old Password.';
				$this->session->set_flashdata('error_msg',$error_msg);
				redirect('Account/reset_password');
			}else{
				$this->Mdl_Account->update_password();
					redirect('Account/My_profile');
			}	
	}
	 function update_profile()
	 {

		 if($_FILES['user_image']['name'] != null)
		{
			$target_path = "uploads/user_image/";
			$ext = explode('.', basename($_FILES['user_image']['name']));
			$digits = 2;
			$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
			$c_name = time().'-'.$rands . "." . $ext[count($ext) - 1];
			$c_image = $target_path . $c_name;
			move_uploaded_file($_FILES['user_image']['tmp_name'], $c_image);
			if(file_exists($c_image)) {
				$res = $this->Mdl_Account->get_profile();
				$path = $res->user_image;
				if(file_exists($path)) { unlink($path); }
				
				$img = $target_path.$c_name;
				$_POST['user_image']=$img;
			}
		}
		
		$this->Mdl_Account->update_profile();
		$success_msg='Profile Updated Successfully.';
		$this->session->set_flashdata('success_msg',$success_msg);
		redirect('Account/My_profile');

	 }
	
	/* =================== my Address ====================*/
	
	Public function Address()
	{  
		$address = $this->Mdl_Account->get_addresses();
		$header_import = '';
		$footer_import = '';
		$data =array(
			'main_content'=>'Address',
			'SCO'=>'', 
			'header_import'=>$header_import, 
			'footer_import'=>$footer_import, 
			'address'=>$address, 
		);
		$this->load->view('front_template/template',$data);
		
	}
	 function insert_address()
	 {
		$this->Mdl_Account->insert_address();
		redirect('Account/Address');

	 }
	 function get_single_address($id){
		 $res = $this->Mdl_Account->get_single_address($id);
		echo json_encode($res);
	 }
	 function update_address()
	 {
		$this->Mdl_Account->update_address();
		redirect('Account/Address');

	 }
	 
	 function delete_addres($id)
	 {
		$this->Mdl_Account->delete_addres($id);
		redirect('Account/Address');

	 }
	/* =================== my Orders ====================*/
	
	Public function Orders()
	{  
		$order_details = $this->Mdl_Account->get_orders();
		$header_import = '';
		$footer_import = '';
		$data =array(
			'main_content'=>'Orders',
			'SCO'=>'', 
			'header_import'=>$header_import, 
			'footer_import'=>$footer_import, 
			'order_details'=>$order_details, 
			
		);
		$this->load->view('front_template/template',$data);
		
	}
	
	Public function Orders_details($id)
	{  
		$order_details = $this->Mdl_Account->get_single_orders($id);
		$order_items = $this->Mdl_Account->get_order_items($order_details->order_id);
		$header_import = '';
		$footer_import = '';
		$data =array(
			'main_content'=>'Orders_details',
			'SCO'=>'', 
			'header_import'=>$header_import, 
			'footer_import'=>$footer_import, 
			'order_details'=>$order_details, 
			'order_items'=>$order_items, 
		);
		$this->load->view('front_template/template',$data);
		
	}
	
	function cancel_order($id)
	{
		$this->Mdl_Account->cancel_order($id);
		redirect('Account/Orders');
	}
	
	/* =================== my Bookins ====================*/
	
	Public function Bookings()
	{  
		$booking_details = $this->Mdl_Account->get_bookings();
		$header_import = '';
		$footer_import = '';
		$data =array(
			'main_content'=>'Bookings',
			'SCO'=>'', 
			'header_import'=>$header_import, 
			'footer_import'=>$footer_import, 
			'booking_details'=>$booking_details, 
		);
		$this->load->view('front_template/template',$data);
		
	}
	
	Public function Booking_details($id)
	{  
		$booking_details = $this->Mdl_Account->get_single_Bookings($id);
		$booking_items = $this->Mdl_Account->get_Bookings_service($booking_details->booking_id);
	
		$header_import = '';
		$footer_import = '';
		$data =array(
			'main_content'=>'Booking_details',
			'SCO'=>'', 
			'header_import'=>$header_import, 
			'footer_import'=>$footer_import, 
			'booking_details'=>$booking_details, 
			'booking_items'=>$booking_items, 
		);
		$this->load->view('front_template/template',$data);
		
	}
	function cancel_Booking($id)
	{
		$this->Mdl_Account->cancel_Booking($id);
		redirect('Account/Bookings');
	}
	
	function ajax_get_products($rowno=0){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		// Row per page
		$rowperpage = 12;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_product->getrecordCount_ajax_product();

		// Get records
		$record = $this->Mdl_product->ajax_get_products($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		$grid = '';
		foreach($record as $res){
			
			//product image
			$p_img = $this->Mdl_product->get_product_single_image($res->product_id);
			$img = base_url().'assets/admin/images/no-image.png';
			if(file_exists($p_img->image_url)) { $img = base_url().$p_img->image_url; }
			
			
			
			//this for grid view
			$grid .='
				
				<a href="'.base_url().'Product/Product_details/'.$res->product_id.'" class="col-md-4 col-6 p-1">
					<div class="card shadow-md border-0 mb-2" >
						<div class="pt-2 pl-2 pr-2"><img src="'.$img.'" class="card-img-top d-block product-img " alt="..."></div>
						<div class="card-body  pl-2 pr-2">
							<h5 class="p-name text-3 mb-0">'.$res->product_name .' ('. $res->selling_unit_qty.$res->selling_unit .')</h5>
							<p class="mb-0">  
								<span class="text-black-50 store-name"><i class="fas fa-store"></i> '.$res->Store_name .'</span> 
							</p> 
							<!-- p class="reviews mb-2"> 
								<span class="reviews-score px-2 py-1 mr-1 rounded font-weight-600 text-light">8.2</span> <span class="font-weight-600">Excellent</span> <a class="text-black-50" href="#">(245 reviews)</a> 
							</p -->
						</div>
						<div class="card-footer bg-transparent d-flex align-items-center">
							<div class="text-dark text-4 font-weight-500 mr-2 mr-lg-3">Rs. '.$res->product_sele_price .'</div>
							<div class="d-block text-2 text-black-50 mr-2 mr-lg-3"><del class="d-block">Rs. '.$res->product_price .'</del></div>
							<div class="text-success text-2">'.round( (($res->product_price - $res->product_sele_price) / $res->product_price) * 100 ).'% Off!</div>
						</div>
					</div>
				</a>
			';
		}
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		//$data['table_view'] = $table;
		$data['grid_view'] = $grid;
		$data['row'] = $rowno;
		$data['total_products'] = $allcount;
		
		
		echo json_encode($data);
	}
	
	
	function Product_details($product_id){
		
		$product = $this->Mdl_product->get_single_products($product_id);
		$product->images = $this->Mdl_product->get_product_imgs($product_id);
		
		$related_product = $this->related_product($product_id, $product->product_parent_category);
		
		$header_import = '';
		$footer_import = '';
		$data =array(
			'main_content'=>'Product_details',
			'SCO'=>'', 
			'header_import'=>$header_import, 
			'footer_import'=>$footer_import, 
			'product'=>$product, 
			'related_product'=>$related_product, 
		);
		$this->load->view('front_template/template',$data);
	}
	
	function related_product($product_id, $cat_id){
		$related_product = $this->Mdl_product->get_related_products($product_id, $cat_id);
		$data = '';
		foreach($related_product as $res){
			//product image
			$p_img = $this->Mdl_product->get_product_single_image($res->product_id);
			$img = base_url().'assets/admin/images/no-image.png';
			if(file_exists($p_img->image_url)) { $img = base_url().$p_img->image_url; }
			
			$data .='
				<a href="'.base_url().'Product/Product_details/'.$res->product_id.'" class="col-md-3 col-6 p-1">
					<div class="card shadow-md border-0 mb-2" >
						<div class="pt-2 pl-2 pr-2"><img src="'.$img.'" class="card-img-top d-block product-img " alt="..."></div>
						<div class="card-body  pl-2 pr-2">
							<h5 class="p-name text-3 mb-0">'.$res->product_name .' ('. $res->selling_unit_qty.$res->selling_unit .')</h5>
							<p class="mb-0">  
								<span class="text-black-50 store-name"><i class="fas fa-store"></i> '.$res->Store_name .'</span> 
							</p> 
							<!-- p class="reviews mb-2"> 
								<span class="reviews-score px-2 py-1 mr-1 rounded font-weight-600 text-light">8.2</span> <span class="font-weight-600">Excellent</span> <a class="text-black-50" href="#">(245 reviews)</a> 
							</p -->
						</div>
						<div class="card-footer bg-transparent d-flex align-items-center">
							<div class="text-dark text-4 font-weight-500 mr-2 mr-lg-3">Rs. '.$res->product_sele_price .'</div>
							<div class="d-block text-2 text-black-50 mr-2 mr-lg-3"><del class="d-block">Rs. '.$res->product_price .'</del></div>
							<div class="text-success text-2">'.round( (($res->product_price - $res->product_sele_price) / $res->product_price) * 100 ).'% Off!</div>
						</div>
					</div>
				</a>
			';
		}
		return $data;
	}
	
}
?>
