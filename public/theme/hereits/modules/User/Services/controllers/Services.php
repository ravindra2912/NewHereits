<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Services');
		$this->load->model('Mdl_common');
		$this->load->library("pagination");
		
	}
	Public function index()
	{  
			//echo 'hello Word';die;
			//redirect('Business');
			$data =array(
				'main_content'=>'Services',
				'left_sidebar'=>'Home', 
			);
			$this->load->view('front_template/template',$data);
		
	}
	function ajax_get_services($rowno=0){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		// Row per page
		$rowperpage = 16;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Services->getrecordCount_ajax_services();

		// Get records
		$record = $this->Mdl_Services->ajax_get_services($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		$grid = '';
		foreach($record as $res){
			
			//service image
			$img = base_url().'assets/admin/images/no-image.png';
			if(file_exists($res->packege_image)) { $img = base_url().$res->packege_image; }
			
			//check product favorite
			$check_fevourit = $this->Mdl_Services->check_fevourit($res->Package_id, $res->store_id, 2 ,0);
			$is_fevourit = '<i class="far fa-heart"></i>';
			if($check_fevourit != NULL){
				$is_fevourit = '<i class="fas fa-heart"></i>';
			}
			
			//this for grid view
			$grid .='
				<div class="col-lg-6 ">
					<div class=" bg-white shadow-md rounded p-2 mb-2">
						<a href="#" style="float: right;" data-toggle="modal" data-target="#package-details-'.$res->Package_id.$res->store_id.'">Details</a>
						<div class="row">
							<div class="col-md-5 col-4 text-center" style="align-self: center;">';
								if($this->session->User != NULL){
									$grid .='<span class="cf store-fav border rounded-pill text-nowrap" id="fav-'.$res->Package_id.'" onclick="fav('.$res->Package_id.','.$res->store_id.')" style="left: 0px;">'.$is_fevourit.'</span>';
								}
								$grid .='<a href="'.base_url().'Services/service_details/'.$res->package_slug.'"><img class="img-fluid rounded align-top" src="'.$img.'" alt="Store"></a>
							</div>
							<div class="col-md-7 col-8 pl-3 pl-md-0 mt-3 mt-md-0">
								<h4><a href="'.base_url().'Services/service_details/'.$res->package_slug.'" class="text-dark text-3">'.$res->Package_name.'</a></h4>
								<p class="mb-2">  
									<span class="text-black-50 store-name"><i class="fas fa-store"></i> '.$res->store_name.'</span> 
								</p>
								';
								if($res->price_type == 1){
									$grid .='<span class="text-3 pr-2">Rs. '.$res->packege_sale_price.'</span><span class="text-3"><del>Rs. '.$res->packege_price.'</del></span>';
								}else if($res->price_type == 2){
									$grid .='<span class="text-3 pr-2">Rs. '.$res->packege_sale_price.'</span><span class="text-3 pr-2">-</span><span class="text-3">Rs. '.$res->packege_price.'</span>';
								}
								
								$grid .='
								<!--p class="reviews mb-2">
									<span class="reviews-score px-2 py-1 rounded font-weight-600 text-light text-2">8.2</span><a class="text-1 text-black-50" href="#">(245 reviews)</a>
								</p -->
								
							</div>
						</div>
					</div>
				</div>
				
				<!-- modal for plan details -->
				<div id="package-details-'.$res->Package_id.$res->store_id.'" class="modal fade" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">'.$res->Package_name.'</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
							</div>
							<div class="modal-body">
								<h5>Description</h5>
								'.$res->packege_description.'';
								
								if($res->packege_includes != NULL){
									$grid .='<h5 class="mt-2">includes</h5>
									'.$res->packege_includes.'';
								}
								
								if($res->packege_includes != NULL){
									$grid .='<h5 class="mt-2">excludes</h5>
									'.$res->packege_excludes.'';
								}
							$grid .='</div>
						</div>
					</div>
				</div>
			';
		}
		
	
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		//$data['table_view'] = $table;
		$data['grid_view'] = $grid;
		$data['row'] = $rowno;
		
		
		echo json_encode($data);
	}
	
	Public function service_details($package_slug)
	{   
		$pachages = $this->Mdl_Services->get_service_details($package_slug);
			
		//cart details
		$check_cart = $this->Mdl_Services->get_cart(2); 
		$check_cart_item = $this->Mdl_Services->get_cart_item($check_cart->cart_id,$pachages->Package_id,2);
		$pachages->cart_store = $check_cart->store_id;
		$pachages->in_cart = 0;
		if($check_cart_item != null){
			$pachages->in_cart = 1;
		}
		
		//check product favorite
		$check_favorite = $this->Mdl_Services->check_fevourit($pachages->Package_id, $pachages->store_id, 2 ,0);
		$pachages->is_favorite = 0;
		if($check_favorite != NULL){
			$pachages->is_favorite = 1;
		}
			
			
			$data =array(
				'main_content'=>'Services_details',
				'seo' => $this->package_sco($pachages->store_id, $pachages->Package_id),
				'pachages'=>$pachages, 
				'get_related_packages'=>$this->Mdl_Services->get_related_packages($pachages->Package_id, $pachages->main_category),
			);
			$this->load->view('front_template/template',$data);
		
	}
	
	function package_sco($store_id, $Package_id){
		
		$this->db->select('*');
		$this->db->where('store_id', $store_id);
		$this->db->where('Package_id', $Package_id);
		$this->db->from('store_Packages_master');
		$store_package = $this->db->get()->row();
		
		$this->db->select('*');
		$this->db->where('Package_id', $Package_id);
		$this->db->from('Packages_master');
		$package = $this->db->get()->row();
		
		$this->db->select('*');
		$this->db->where('store_id', $store_id);
		$this->db->from('Store_master');
		$store = $this->db->get()->row();
		
		$url = base_url().'Services/service_details/'.$store_package->package_slug;
		$image = base_url().$package->packege_image;
		$description = $package->Package_name. ' in '.$store->city.' address, phone numbers, user ratings, reviews, contact person and quotes instantly to your mobile on Hereits.com.';
		$keywords = $package->Package_name. ' in '.$store->city.' address, phone numbers, user ratings, reviews, contact person and quotes instantly to your mobile on Hereits.com.';
		
		$data['description'] = $description;
		$data['keywords'] = $keywords;
		$data['title'] = $package->Package_name.' in '.$store->Store_name.' Store | Hereits '.$store->city;
		$data['url'] = $url;
		$data['city'] = $store->city;
		$data['state'] = $store->state;
		$data['position'] = $store->latitude.';'.$store->longitude;
		$data['image'] = $image;
		
		
		return $data;
	}
	
	function add_to_cart(){
		$item_id = $this->input->post('item_id', TRUE);
		$store_id = $this->input->post('store_id', TRUE);
		
		
		
		if($item_id == NULL){
			$array=array('status'=>'0','Message'=>'Item Id Is Required!'); 
		}else if($store_id == NULL){
			$array=array('status'=>'0','Message'=>'Store Id Is Required!'); 
		}else{
			$check_cart = $this->Mdl_Services->get_cart(2); 
			if($check_cart->store_id != $store_id){
				//delete user Cart
				$this->db->where('cart_id', $check_cart->cart_id);
				$this->db->delete('Cart_master');
				
				//delete user Cart items
				$this->db->where('cart_id', $check_cart->cart_id);
				$this->db->delete('Cart_item_master');
				
				$check_cart = $this->Mdl_Services->get_cart(2);
			}
			if($check_cart != NULL){
				$check_cart_item = $this->Mdl_Services->get_cart_item($check_cart->cart_id,$item_id,2); 
				if($check_cart_item == NULL){
					$cart_item_id = $this->Mdl_Services->add_cart_item($check_cart->cart_id,$item_id,2);
					$data['cart_item_id'] = $cart_item_id;
					$array=array('status'=>1,'Message'=>'Added To Cart SuccessFully','data'=>$data);
				}else{
					$array=array('status'=>1,'Message'=>'item already exists In Cart','data'=>'');
				}
				
			}else{
				$cart_item_id = $this->Mdl_Services->set_cart($item_id, 2, $store_id);
				$data['cart_item_id'] = $cart_item_id;
				$array=array('status'=>1,'Message'=>'Added To Cart SuccessFully','data'=>$data);
			}
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//Favorite
	function favouriteRequest(){
		$item_id = $this->input->post('item_id', TRUE);
		$store_id = $this->input->post('store_id', TRUE);
		
		
		 if($item_id == NULL){
			$array=array('status'=>'0','Message'=>'Item Id Is Required!'); 
		}else{
			$check_fevourit = $this->Mdl_Services->check_fevourit($item_id, $store_id, 2 ,0);
			if($check_fevourit != NULL){
				//delete data
				$this->db->where('user_id', $this->session->User->user_id);
				$this->db->where('item_id', $item_id);
				$this->db->where('store_id', $store_id);
				$this->db->where('type', 2);
				$this->db->where('is_store', 0);
				$this->db->delete('Favourit_item_mster');
				$array=array('status'=>0,'Message'=>'Removed from Favourite','data'=>$check_fevourit);
			}else{
				$data['user_id'] = $this->session->User->user_id;
				$data['item_id'] = $item_id;
				$data['store_id'] = $store_id;
				$data['type'] = 2;
				$data['is_store'] = 0;
				$this->db->insert('Favourit_item_mster',$data);
				$array=array('status'=>1,'Message'=>'Added To Favourite','data'=>$check_fevourit);
			}
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
}
?>
