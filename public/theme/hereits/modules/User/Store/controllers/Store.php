<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Store');
		$this->load->model('Mdl_common');
		$this->load->library("pagination");
		
	}
	Public function index()
	{  
		$header_import = '';
		$footer_import = '';
		
		$data =array(
			'main_content'=>'stores',
			'SCO'=>'', 
			'header_import'=>$header_import, 
			'footer_import'=>$footer_import, 
		);
		$this->load->view('front_template/template',$data);
	}
	
	function ajax_get_stores($rowno=0){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		// Row per page
		$rowperpage = 15;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Store->getrecordCount_ajax_stores();

		// Get records
		$record = $this->Mdl_Store->ajax_get_stores($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		$grid = '';
		foreach($record as $res){
			
			//store timing
			$store_timin = $this->Mdl_Store->get_store_open_time($res->store_id);
			$store_timing = $store_timin['store_timing'];
			$is_store_open = $store_timin['store_open'];
			
			//store image
			$img = base_url().'assets/admin/images/no-image.png';
			if(file_exists($res->store_image)) { $img = base_url().$res->store_image; }
			
			//check store fevourit
			$check_fevourit = $this->Mdl_Store->check_fevourit($res->store_id, $res->store_id, 1 ,1);
			$is_fevourit = '<i class="far fa-heart"></i>';
			if($check_fevourit != NULL){
				$is_fevourit = '<i class="fas fa-heart"></i>';
			}
			
			//this for grid view
			$grid .='
					<div class=" bg-white shadow-md rounded p-3 mb-2 list-store">
						<div class="row">
							<div class="col-md-4 col-4" style="align-self: center;">';
								if($this->session->User != NULL){
									$grid .='<span class="cf store-fav border rounded-pill text-nowrap" id="store-fav-'.$res->store_id.'" onclick="store_fevourit('.$res->store_id.')" >'.$is_fevourit.'</span>';
								}
								$grid .='<a href="'.base_url().'Store/store_details/'.$res->store_slug.'"><img class="img-fluid rounded align-top store-img" src="'.$img.'" alt="Store"></a>
							</div>
							<div class="col-md-8 col-8 pl-3 pl-md-0 mt-3 mt-md-0">
								<div class="row no-gutters">
									<div class="col-sm-9">
										<h4><a href="'.base_url().'Store/store_details/'.$res->store_slug.'" class="text-dark text-5 store-name">'.$res->Store_name.'</a></h4>
										<p class="mb-2 store-address">
											<!-- span class="mr-2">
												<i class="fas fa-star text-warning"></i>
												<i class="fas fa-star text-warning"></i>
												<i class="fas fa-star text-warning"></i>
												<i class="fas fa-star text-warning"></i>
											</span -->
											<span ><a href="'.base_url().'Store/store_details/'.$res->store_slug.'" class="text-black-50"><i class="fas fa-map-marker-alt"></i> '.$res->store_address_2.', '.$res->store_address.'</a></span>
										</p>
										<!-- p class=" d-flex align-items-center mb-2 text-4">
											<span class="cf border rounded-pill text-1 text-nowrap px-2">verified</span>
										</p -->
										<!-- p class="reviews mb-2">
											<span class="reviews-score px-2 py-1 rounded font-weight-600 text-light">8.2</span> <span class="font-weight-600">Excellent</span> <a class="text-black-50" href="#">(245 reviews)</a>
										</p -->
										<!-- div class="text-black-50 mb-0 mb-sm-2 order-3 d-none d-sm-block">Grocery</div -->
									</div>
									<div class="col-sm-3 text-right d-flex d-sm-block align-items-center">';
										if($store_timin['store_open'] == 1){
											$grid .='<p class="text-success mb-0">Open</p>';
										}else{
											$grid .='<p class="text-danger mb-0">close</p>';
										}
									$grid .='</div>
								</div>
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
		$data['total_stores'] = $allcount;
		
		
		echo json_encode($data);
	}
	
	
	function store_details($store_slug){
		
		$Stores = $this->Mdl_Store->get_single_Store($store_slug);
		$store_id = $Stores->store_id;
		$check_fevourit = $this->Mdl_Store->check_fevourit($store_id, $store_id, 1 ,1);
		$Stores->is_fevourit = 0;
		if($check_fevourit != NULL){
			$Stores->is_fevourit = 1;
		}
		
		//store timing
	//	$store_timin = $this->Mdl_Store->get_store_open_time($store_id);
	//	$Stores->store_timing = $store_timin['store_timing'];
	//	$Stores->is_store_open = $store_timin['store_open'];
		
		
		$header_import = '';
		$footer_import = '';
		
		//get store Hone
		$_POST['store_id'] = $store_id;
		$s_home =array( 
			'products'=>$this->Mdl_Store->ajax_get_products(0,4), 
			'services'=>$this->Mdl_Store->ajax_get_services(0,4), 
		);
		$home_html = $this->load->view('Store_Home',$s_home, TRUE);
		
		//get store products
		$s_products =array( 
			'store_id'=>$store_id, 
		);
		$product_html = $this->load->view('Store_Product',$s_products, TRUE);
		
		//get store Services
		$s_products =array( 
			'store_id'=>$store_id, 
		);
		$service_html = $this->load->view('Store_Services',$s_products, TRUE);
		
		//get store gallery
		$album = $this->Mdl_Store->get_albums($store_id);
		$s_gallery =array( 
			'album'=>$album, 
		);
		$gallery_html = $this->load->view('Store_gallery',$s_gallery, TRUE);
		
		//get store Review
		$review_html = $this->load->view('Store_review',$s_gallery, TRUE);
		
		$data =array(
			'main_content'=>'Store_details',
			'seo'=>$this->store_sco($store_id),
			'header_import'=>$header_import, 
			'footer_import'=>$footer_import, 
			'Stores'=>$Stores, 
			'home_html'=>$home_html, 
			'product_html'=>$product_html, 
			'service_html'=>$service_html, 
			'gallery_html'=>$gallery_html, 
			'review_html'=>$review_html, 
		);
		$this->load->view('front_template/template',$data);
	}
	
	function store_sco($store_id){
		$this->db->select('*');
		$this->db->where('store_id', $store_id);
		$this->db->from('Store_master');
		$store = $this->db->get()->row();
		
		$url = base_url().'Store/store_details/'.$store->store_slug;
		$image = base_url().$store->store_image;
		$description = $store->Store_name. ' in '.$store->city.' address, phone numbers, user ratings, reviews, contact person and quotes instantly to your mobile on Hereits.com.';
		$keywords = $store->Store_name. ' in '.$store->city.' address, phone numbers, user ratings, reviews, contact person and quotes instantly to your mobile on Hereits.com.';
		
		$data['description'] = $description;
		$data['keywords'] = $keywords;
		$data['title'] = $store->Store_name. ' in '.$store->city.' | Hereits';
		$data['url'] = $url;
		$data['city'] = $store->city;
		$data['state'] = $store->state;
		$data['position'] = $store->latitude.';'.$store->longitude;
		$data['image'] = $image;
		
		return $data;
	}
	
	//Favorite
	function favouriteRequest(){
		$item_id = $this->input->post('item_id', TRUE);
		$store_id = $this->input->post('store_id', TRUE);
		$type = $this->input->post('type', TRUE);
		$isstore = $this->input->post('isstore', TRUE);
		
		 if($item_id == NULL){
			$array=array('status'=>'0','Message'=>'Item Id Is Required!'); 
		}else{
			$check_fevourit = $this->Mdl_Store->check_fevourit($item_id, $store_id, $type ,$isstore);
			if($check_fevourit != NULL){
				//delete data
				$this->db->where('user_id', $this->session->User->user_id);
				$this->db->where('item_id', $item_id);
				$this->db->where('store_id', $store_id);
				$this->db->where('type', $type);
				$this->db->where('is_store', $isstore);
				$this->db->delete('Favourit_item_mster');
				$array=array('status'=>0,'Message'=>'Removed from Favourite','data'=>$check_fevourit);
			}else{
				$data['user_id'] = $this->session->User->user_id;
				$data['item_id'] = $item_id;
				$data['store_id'] = $store_id;
				$data['type'] = $type;
				$data['is_store'] = $isstore;
				$this->db->insert('Favourit_item_mster',$data);
				$array=array('status'=>1,'Message'=>'Added To Favourite','data'=>$check_fevourit);
			}
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	/* =========================== Store products ======================*/
	function ajax_get_store_products($rowno=0){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		// Row per page
		$rowperpage = 12;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Store->getrecordCount_ajax_product();

		// Get records
		$record = $this->Mdl_Store->ajax_get_products($rowno,$rowperpage);
		
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
			$p_img = $this->Mdl_Store->get_product_single_image($res->product_id);
			$img = base_url().'assets/admin/images/no-image.png';
			if(file_exists($p_img->image_url)) { $img = base_url().$p_img->image_url; }
			
			//check product favorite
			$check_fevourit = $this->Mdl_Store->check_fevourit($res->product_id, $res->store_id, 1 ,0);
			$is_fevourit = '<i class="far fa-heart"></i>';
			if($check_fevourit != NULL){
				$is_fevourit = '<i class="fas fa-heart"></i>';
			}
			//cart details
			$check_cart = $this->Mdl_Store->get_cart(1); 
			$check_cart_item = $this->Mdl_Store->get_cart_item($check_cart->cart_id,$res->product_id,1);
			$cart_store_id = $res->store_id;
			if($check_cart != NULL){
				$cart_store_id = $check_cart->store_id;
			}
			
			//this for grid view
			$grid .='
				
				<div class="col-md-3 col-6 p-1">
					<div class="card shadow-md border-0" >
						<div class="pt-2 pl-2 pr-2">';
							if($this->session->User != NULL){
									$grid .='<span class="cf store-fav border rounded-pill text-nowrap" id="product-fav-'.$res->product_id.'" onclick="product_fav('.$res->product_id.','.$res->store_id.')" style="right: 10px;" >'.$is_fevourit.'</span>';
							}
							$grid .='<a href="'.base_url().'Product/Product_details/'.$res->product_slug.'" ><img src="'.$img.'" class="card-img-top d-block product-img " alt="..."></a>
						</div>
						<div class="card-body  pl-2 pr-2 pt-2 pb-1">
							<div class=" bg-transparent d-flex mb-1" style="height: 22px;">';
								if($res->price_type == 1){
									$grid .= '
										<div class="text-dark text-4 font-weight-500 mr-2 mr-lg-3"><i class="fas fa-rupee-sign text-3"></i>'.$res->product_sele_price .'</div>
										<div class="d-block text-2 text-black-50 mr-2 mr-lg-3"><del class="d-block"><i class="fas fa-rupee-sign text-1"></i>'.$res->product_price .'</del></div>
									';
								}else if($res->price_type == 2){
									$grid .= '
										<div class="text-dark text-4 font-weight-500 mr-2 mr-lg-3"><i class="fas fa-rupee-sign text-3"></i>'.$res->product_sele_price .'</div>
										<div class="text-dark text-4 font-weight-500 mr-2 mr-lg-3"> - </div>
										<div class="text-dark text-4 font-weight-500 mr-2 mr-lg-3"><i class="fas fa-rupee-sign text-3"></i>'.$res->product_price .'</div>
									';
								}
								$grid .= '
							</div>
							<h5 class="p-name text-3 mb-0 text-black-50">'.$res->product_name .' ('. $res->selling_unit_qty.$res->selling_unit .')</h5>
							 
							<!-- p class="reviews mb-2"> 
								<span class="reviews-score px-2 py-1 mr-1 rounded font-weight-600 text-light">8.2</span> <span class="font-weight-600">Excellent</span> <a class="text-black-50" href="#">(245 reviews)</a> 
							</p -->';
							
							if($res->price_type == 1){
								if($this->session->User != NULL){
								$grid .= '<div class="mt-1 mb-2" id="p-cart-container-'.$res->product_id.'">';
									if($check_cart_item != NULL){
										$grid .= '<div class="bg-primary cart-counter mt-3" style="width: unset;">
													<button class="CounterButton" onclick="update_qty(0,'.$res->product_id.')" >-</button>
													<span class="CounterValue" id="CounterValue-'.$res->product_id.'">'.$check_cart_item->cart_qty.'</span>
													<button class="CounterButton" onclick="update_qty(1,'.$res->product_id.')" >+</button>
												</div>';
									}else{
										$grid .='<button aria-label="add item to cart" class="add-item-to-cart_btn mt-3" onclick="add_product_in_cart('.$res->product_id.','.$res->store_id.','.$cart_store_id.', 1)">
											<div class="add-item-to-box">Add</div>
											<span class="add-item-to-cart__Icon"> + </span>
										</button>';
									}
									
								$grid .=' </div>';
								}else{
									$grid .='<button aria-label="add item to cart" class="add-item-to-cart_btn mt-3  mb-2" data-toggle="modal" data-target="#login-modal">
											<div class="add-item-to-box">Add</div>
											<span class="add-item-to-cart__Icon"> + </span>
										</button>';
								}
							}else if($res->price_type == 2){
								$grid .=' <a href="https://wa.me/91'.$res->store_contact.'/?text='.base_url().'Product/Product_details/'.$res->product_slug.' %0a %0a i am interested in your above product, please tell the price" class="add-item-to-cart_btn mt-3  mb-2 bg-primary text-center" >
									<div class="add-item-to-box text-white"> Ask for Price</div>
								</a>';
							}else{
								$grid .=' <a href="https://wa.me/91'.$res->store_contact.'/?text='.base_url().'Product/Product_details/'.$res->product_slug.' %0a %0a i am interested in your above product, please tell the price" class="add-item-to-cart_btn mt-3  mb-2 bg-primary text-center" >
									<div class="add-item-to-box text-white"> Ask for Price</div>
								</a>';
							}
							
							
							$grid .='	
						</div>
						
					</div>
				</div>
			';
		}
		
		//cart count
		$cart = $this->Mdl_Store->get_cart(1); 
		$cart_items = $this->Mdl_Store->get_cart_all_item($cart->cart_id, $cart->store_id, 1); 
		$cart_item = 0;
		$cart_amount = 0;
		foreach($cart_items as $val){
			$cart_amount += $val->cart_qty * $val->product_sele_price;
			$cart_item ++;
		}
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		//$data['table_view'] = $table;
		$data['grid_view'] = $grid;
		$data['row'] = $rowno;
		$data['total_products'] = $allcount;
		$data['cart_item'] = $cart_item;
		$data['cart_amount'] = $cart_amount;
		
		
		echo json_encode($data);
	}
	
	/* =========================== Store services ======================*/
	function ajax_get_store_services($rowno=0){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		// Row per page
		$rowperpage = 12;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Store->getrecordCount_ajax_services();

		// Get records
		$record = $this->Mdl_Store->ajax_get_services($rowno,$rowperpage);
		
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
			
			//cart details
			$check_cart = $this->Mdl_Store->get_cart(2); 
			$check_cart_item = $this->Mdl_Store->get_cart_item($check_cart->cart_id,$res->Package_id,2);
			$cart_store_id = $res->store_id;
			if($check_cart != NULL){
				$cart_store_id = $check_cart->store_id;
			}
			
			//check product favorite
			$check_fevourit = $this->Mdl_Store->check_fevourit($res->Package_id, $res->store_id, 2 ,0);
			$is_fevourit = '<i class="far fa-heart"></i>';
			if($check_fevourit != NULL){
				$is_fevourit = '<i class="fas fa-heart"></i>';
			}
			
			//this for grid view
			$grid .='
				<div class="col-lg-6">
					<div class=" bg-white shadow-md rounded p-2 mb-2">
						<a href="#" style="float: right;" data-toggle="modal" data-target="#package-details-'.$res->Package_id.$res->store_id.'"><i class="fas fa-question-circle"></i></a>
						<div class="row">
							<div class="col-md-5 col-4 text-center" style="align-self: center;">';
								if($this->session->User != NULL){
									$grid .='<span class="cf store-fav border rounded-pill text-nowrap" id="service_fav-'.$res->Package_id.'" onclick="service_fav('.$res->Package_id.','.$res->store_id.')" style="left: 0px;">'.$is_fevourit.'</span>';
								}
								$grid .='<a href="'.base_url().'Services/service_details/'.$res->package_slug.'"><img class="img-fluid rounded align-top" src="'.$img.'" alt="Store"></a>
							</div>
							<div class="col-md-7 col-8 pl-3 pl-md-0 mt-3 mt-md-0">
								<h4><a href="'.base_url().'Services/service_details/'.$res->package_slug.'" class="text-dark text-3">'.$res->Package_name.'</a></h4>';
								if($res->price_type == 1){
									$grid .='<span class="text-3 pr-2">Rs. '.$res->packege_sale_price.'</span><span class="text-3"><del>Rs. '.$res->packege_price.'</del></span>';
								}else if($res->price_type == 2){
									$grid .='<span class="text-3 pr-2">Rs. '.$res->packege_sale_price.'</span><span class="text-3 pr-2">-</span><span class="text-3">Rs. '.$res->packege_price.'</span>';
								}
								
								$grid .='<!--p class="reviews mb-2">
									<span class="reviews-score px-2 py-1 rounded font-weight-600 text-light text-2">8.2</span><a class="text-1 text-black-50" href="#">(245 reviews)</a>
								</p -->
								 <div class="text-right mt-1" id="s-cart-container-'.$res->Package_id.'">';
								if($res->price_type == 1){
									if($check_cart_item != NULL && $cart_store_id == $res->store_id){
										$grid .='<a href="#" class="btn btn-sm btn-danger text-1" onclick="remove_cart_item('.$res->Package_id.','.$cart_store_id.', 2)">Remove</a>';
									}else{
										$grid .='<a href="#" class="btn btn-sm btn-primary text-1" onclick="add_service_in_cart('.$res->Package_id.','.$res->store_id.','.$cart_store_id.', 2)">Add</a>';
									}
								}else if($res->price_type == 2){
									$grid .='<a href="https://wa.me/91'.$res->store_contact.'/?text='.base_url().'Services/service_details/'.$res->package_slug.' %0a %0a i am interested in your above Service, please tell the price" class="btn btn-sm btn-primary text-1" >Ask Price</a>';
								}else{
									$grid .='<a href="https://wa.me/91'.$res->store_contact.'/?text='.base_url().'Services/service_details/'.$res->package_slug.' %0a %0a i am interested in your above Service, please tell the price" class="btn btn-sm btn-primary text-1" >Ask Price</a>';

								}
									$grid .='</div>
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
		
		//cart count
		$cart = $this->Mdl_Store->get_cart(2); 
		$cart_items = $this->Mdl_Store->get_cart_all_item($cart->cart_id, $cart->store_id, 2); 
		$cart_item = 0;
		$cart_amount = 0;
		foreach($cart_items as $val){
			$cart_amount += $val->cart_qty * $val->packege_sale_price;
			$cart_item ++;
		}
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		//$data['table_view'] = $table;
		$data['grid_view'] = $grid;
		$data['row'] = $rowno;
		$data['cart_item'] = $cart_item;
		$data['cart_amount'] = $cart_amount;
		
		
		echo json_encode($data);
	}
	
	/* cart */
	function add_to_cart(){
		$item_id = $this->input->post('item_id', TRUE);
		$store_id = $this->input->post('store_id', TRUE);
		$type = $this->input->post('type', TRUE);
		
		
		
		if($item_id == NULL){
			$array=array('status'=>'0','Message'=>'Item Id Is Required!'); 
		}else if($store_id == NULL){
			$array=array('status'=>'0','Message'=>'Store Id Is Required!'); 
		}else{
			$check_cart = $this->Mdl_Store->get_cart($type); 
			if($check_cart->store_id != $store_id){
				//delete user Cart
				$this->db->where('cart_id', $check_cart->cart_id);
				$this->db->delete('Cart_master');
				
				//delete user Cart items
				$this->db->where('cart_id', $check_cart->cart_id);
				$this->db->delete('Cart_item_master');
				
				$check_cart = $this->Mdl_Store->get_cart($type);
			}
			if($check_cart != NULL){
				$check_cart_item = $this->Mdl_Store->get_cart_item($check_cart->cart_id,$item_id,$type); 
				if($check_cart_item == NULL){
					$cart_item_id = $this->Mdl_Store->add_cart_item($check_cart->cart_id,$item_id,$type);
					$data['cart_item_id'] = $cart_item_id;
					$array=array('status'=>1,'Message'=>'Added To Cart SuccessFully','data'=>$data);
				}else{
					$array=array('status'=>1,'Message'=>'item already exists In Cart','data'=>'');
				}
				
			}else{
				$cart_item_id = $this->Mdl_Store->set_cart($item_id, $type, $store_id);
				$data['cart_item_id'] = $cart_item_id;
				$array=array('status'=>1,'Message'=>'Added To Cart SuccessFully','data'=>$data);
			}
		}
		
		//cart count
		$cart = $this->Mdl_Store->get_cart($type); 
		$cart_items = $this->Mdl_Store->get_cart_all_item($cart->cart_id, $cart->store_id, $type); 
		$cart_item = 0;
		$cart_amount = 0;
		foreach($cart_items as $val){
			if($type == 1){
				$cart_amount += $val->cart_qty * $val->product_sele_price;
			}else if($type == 2){
				$cart_amount += $val->cart_qty * $val->packege_sale_price;
			}
			
			$cart_item ++;
		}
		$array['cart_item'] = $cart_item;
		$array['cart_amount'] = $cart_amount;
		
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function update_cart_qty(){
		$item_id = $this->input->post('item_id', TRUE);
		$qty_type = $this->input->post('qty_type', TRUE);
		$type = $this->input->post('type', TRUE);
		
		$check_cart = $this->Mdl_Store->get_cart($type); 
		$check_cart_item = $this->Mdl_Store->get_cart_item($check_cart->cart_id,$item_id,$type); 
		if($check_cart_item->cart_qty == 1 && $qty_type == 0){
			$this->db->where('cart_id', $check_cart->cart_id);
			$this->db->where('item_id', $item_id);
			$this->db->where('type', $type);
			$this->db->delete('Cart_item_master');
			
			//ckeck cart is empty
			$check_cart = $this->Mdl_Store->get_cart($type); 
			$cart_items = $this->Mdl_Store->get_cart_all_item($check_cart->cart_id, $check_cart->store_id,$type);
			if($cart_items == NULL && $check_cart != NULL){
				//delete user Cart
				$this->db->where('cart_id', $check_cart->cart_id);
				$this->db->delete('Cart_master');
			}
			$html = '<button aria-label="add item to cart" class="add-item-to-cart_btn mt-3" onclick="add_product_in_cart('.$item_id.','.$check_cart->store_id.','.$check_cart->store_id.', 1)">
						<div class="add-item-to-box">Add</div>
						<span class="add-item-to-cart__Icon"> + </span>
					</button>';
			$array=array('status'=>'1','Message'=>'Removed!', 'html'=>$html); 
		}else if( $check_cart_item->cart_qty >= 1){
			$this->Mdl_Store->update_cart_qty($qty_type, $check_cart_item->cart_item_id);
			$check_cart_item = $this->Mdl_Store->get_cart_item($check_cart->cart_id,$item_id,$type); 
			
			$html = '<div class="bg-primary cart-counter mt-3" style="width: unset;">
						<button class="CounterButton" onclick="update_qty(0,'.$item_id.')" id="btn_decrement-'.$item_id.'">-</button>
						<span class="CounterValue" id="CounterValue-'.$item_id.'">'.$check_cart_item->cart_qty.'</span>
						<button class="CounterButton" onclick="update_qty(1,'.$item_id.')" id="increment-'.$item_id.'">+</button>
					</div>';
			$array=array('status'=>'1','Message'=>'Update Qty!', 'html'=>$html); 
		}else{
			$array=array('status'=>'0','Message'=>'Error!', 'html'=>$html); 
		}
		
		//cart count
		$cart = $this->Mdl_Store->get_cart(1); 
		$cart_items = $this->Mdl_Store->get_cart_all_item($cart->cart_id, $cart->store_id, 1); 
		$cart_item = 0;
		$cart_amount = 0;
		foreach($cart_items as $val){
			$cart_amount += $val->cart_qty * $val->product_sele_price;
			$cart_item ++;
		}
		$array['cart_item'] = $cart_item;
		$array['cart_amount'] = $cart_amount;
		
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function remove_cart_item(){
		$item_id = $this->input->post('item_id', TRUE);
		$type = $this->input->post('type', TRUE);
		
		$check_cart = $this->Mdl_Store->get_cart($type); 
		$this->db->where('cart_id', $check_cart->cart_id);
		$this->db->where('item_id', $item_id);
		$this->db->where('type', $type);
		$this->db->delete('Cart_item_master');
		
		$array=array('status'=>'1','Message'=>'Remove Item SuccessFully'); 
		
		//cart count
		$cart = $this->Mdl_Store->get_cart($type); 
		$cart_items = $this->Mdl_Store->get_cart_all_item($cart->cart_id, $cart->store_id, $type); 
		$cart_item = 0;
		$cart_amount = 0;
		foreach($cart_items as $val){
			$cart_amount += $val->cart_qty * $val->packege_sale_price;
			$cart_item ++;
		}
		$array['cart_item'] = $cart_item;
		$array['cart_amount'] = $cart_amount;
		
		
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
}
?>
