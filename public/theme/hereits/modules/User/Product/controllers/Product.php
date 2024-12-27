<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_product');
		$this->load->model('Mdl_common');
		$this->load->library("pagination");
		
	}
	Public function index()
	{  	
		$header_import = '';
		$footer_import = '';
		$data =array(
			'main_content'=>'Product',
			'SCO'=>'', 
			'header_import'=>$header_import, 
			'footer_import'=>$footer_import, 
		);
		$this->load->view('front_template/template',$data);
		
	}
	
	function ajax_get_products($rowno=0){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		// Row per page
		$rowperpage = 15;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 

		// Get records
		$record = $this->Mdl_product->ajax_get_products($rowno,$rowperpage);
		
		// All records count
		$allcount = count($this->Mdl_product->ajax_get_products());
		
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
			
			//check product favorite
			$check_fevourit = $this->Mdl_product->check_fevourit($res->product_id, $res->store_id, 1 ,0);
			$is_fevourit = '<i class="far fa-heart"></i>';
			if($check_fevourit != NULL){
				$is_fevourit = '<i class="fas fa-heart"></i>';
			}
			
			//this for grid view
			$grid .='
				
				<div class="col-md-4 col-6 p-1">
					<div class="card shadow-md border-0" >
						<div class="pt-2 pl-2 pr-2">';
								if($this->session->User != NULL){
									$grid .='<span class="cf store-fav border rounded-pill text-nowrap" id="product-fav-'.$res->product_id.$res->store_id.'" onclick="fevourit('.$res->product_id.','.$res->store_id.')" style="right: 10px;" >'.$is_fevourit.'</span>';
								}
								$grid .='<a href="'.base_url().'Product/Product_details/'.$res->product_slug.'" ><img src="'.$img.'" class="card-img-top d-block product-img " alt="..."></a>
						</div>
						<div class="card-body  pl-2 pr-2 pb-1 pt-1">
							<a href="'.base_url().'Product/Product_details/'.$res->product_slug.'" class="p-name text-3 mb-0 text-dark">'.$res->product_name .' ('. $res->selling_unit_qty.$res->selling_unit .')</a>
							<p class="mb-0">  
								<span class="text-black-50 store-name"><i class="fas fa-store"></i> '.$res->Store_name .'</span> 
							</p> 
							<!-- p class="reviews mb-2"> 
								<span class="reviews-score px-2 py-1 mr-1 rounded font-weight-600 text-light">8.2</span> <span class="font-weight-600">Excellent</span> <a class="text-black-50" href="#">(245 reviews)</a> 
							</p -->
						</div>
						<div class="card-footer bg-transparent d-flex align-items-center" style="height: 40px;">';
							if($res->price_type == 1){
								$grid .='<div class="text-dark text-4 font-weight-500 mr-2 mr-lg-3"><i class="fas fa-rupee-sign text-3"></i>'.$res->product_sele_price .'</div>
								<div class="d-block text-2 text-black-50 mr-2 mr-lg-3"><del class="d-block"><i class="fas fa-rupee-sign text-1"></i>'.$res->product_price .'</del></div>
								<!-- div class="text-success text-2">'.round( (($res->product_price - $res->product_sele_price) / $res->product_price) * 100 ).'%Off!</div -->';
							}else if($res->price_type == 2){
								$grid .='<div class="text-dark text-4 font-weight-500 mr-2 mr-lg-3"><i class="fas fa-rupee-sign text-3"></i>'.$res->product_sele_price .'</div>
										<div class="text-dark text-4 font-weight-500 mr-2 mr-lg-3">-</div>
										<div class="text-dark text-4 font-weight-500 mr-2 mr-lg-3"><i class="fas fa-rupee-sign text-3"></i>'.$res->product_price .'</div>';
							}
						$grid .='</div>
					</div>
				</div>
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
	
	
	function Product_details($product_slug){
		
		$product = $this->Mdl_product->get_single_products($product_slug);
		
		$product_id = $product->product_id;
		$product->images = $this->Mdl_product->get_product_imgs($product_id);
		
		//related product
		$related_product = $this->related_product($product_id, $product->product_parent_category);
		
		//cart details
		$check_cart = $this->Mdl_product->get_cart(1); 
		$check_cart_item = $this->Mdl_product->get_cart_item($check_cart->cart_id,$product_id,1);

		//check product favorite
		$check_favorite = $this->Mdl_product->check_fevourit($product_id, $product->store_id, 1 ,0);
		$product->is_favorite = 0;
		if($check_favorite != NULL){
			$product->is_favorite = 1;
		}
		
		$product->cart_store = $check_cart->store_id;
		$product->in_cart = 0;
		if($check_cart_item != null){
			$product->in_cart = 1;
		}
		
		$header_import = '';
		$footer_import = '';
		$sco = $this->product_sco($product->store_id, $product_id);
		$data =array(
			'main_content'=>'Product_details',
			'seo'=>$sco, 
			'header_import'=>$header_import, 
			'footer_import'=>$footer_import, 
			'product'=>$product, 
			'related_product'=>$related_product, 
		);
		$this->load->view('front_template/template',$data);
	}
	
	function product_sco($store_id, $product_id){
		
		$this->db->select('*');
		$this->db->where('store_id', $store_id);
		$this->db->where('product_id', $product_id);
		$this->db->from('store_product_master');
		$store_product = $this->db->get()->row();
		
		$this->db->select('*');
		$this->db->where('product_id', $product_id);
		$this->db->from('product_master');
		$product = $this->db->get()->row();
		
		$this->db->select('*');
		$this->db->from('product_image_master');
		$this->db->where('product_id', $product_id);
		$this->db->order_by("image_order", "asc");
		$product->img = $this->db->get()->row();
		
		$this->db->select('*');
		$this->db->where('store_id', $store_id);
		$this->db->from('Store_master');
		$store = $this->db->get()->row();
		
		$url = base_url().'Product/Product_details/'.$store_product->product_slug;
		$image = base_url().$product->img->image_url;
		$description = $product->product_name. ' in '.$store->city.' address, phone numbers, user ratings, reviews, contact person and quotes instantly to your mobile on Hereits.com.';
		$keywords = $product->product_name. ' in '.$store->city.' address, phone numbers, user ratings, reviews, contact person and quotes instantly to your mobile on Hereits.com.';
		
		$data['description'] = $description;
		$data['keywords'] = $keywords;
		$data['title'] = $product->product_name.' in '.$store->Store_name.' Store | Hereits '.$store->city;
		$data['url'] = $url;
		$data['city'] = $store->city;
		$data['state'] = $store->state;
		$data['position'] = $store->latitude.';'.$store->longitude;
		$data['image'] = $image;
		
		
		return $data;
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
				<a href="'.base_url().'Product/Product_details/'.$res->product_slug.'" class="col-md-3 col-6 p-1">
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
						<div class="card-footer bg-transparent d-flex align-items-center">';
							if($res->price_type == 1){
								$data .='<div class="text-dark text-4 font-weight-500 mr-2 mr-lg-3"><i class="fas fa-rupee-sign text-3"></i>'.$res->product_sele_price .'</div>
								<div class="d-block text-2 text-black-50 mr-2 mr-lg-3"><del class="d-block"><i class="fas fa-rupee-sign text-1"></i>'.$res->product_price .'</del></div>
								<!-- div class="text-success text-2">'.round( (($res->product_price - $res->product_sele_price) / $res->product_price) * 100 ).'%Off!</div -->';
							}else if($res->price_type == 2){
								$data .='<div class="text-dark text-4 font-weight-500 mr-2 mr-lg-3"><i class="fas fa-rupee-sign text-3"></i>'.$res->product_sele_price .'</div>
										<div class="text-dark text-4 font-weight-500 mr-2 mr-lg-3">-</div>
										<div class="text-dark text-4 font-weight-500 mr-2 mr-lg-3"><i class="fas fa-rupee-sign text-3"></i>'.$res->product_price .'</div>';
							}
						$data .='</div>
					</div>
				</a>
			';
		}
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
			$check_cart = $this->Mdl_product->get_cart(1); 
			if($check_cart->store_id != $store_id){
				//delete user Cart
				$this->db->where('cart_id', $check_cart->cart_id);
				$this->db->delete('Cart_master');
				
				//delete user Cart items
				$this->db->where('cart_id', $check_cart->cart_id);
				$this->db->delete('Cart_item_master');
				
				$check_cart = $this->Mdl_product->get_cart(1);
			}
			if($check_cart != NULL){
				$check_cart_item = $this->Mdl_product->get_cart_item($check_cart->cart_id,$item_id,1); 
				if($check_cart_item == NULL){
					$cart_item_id = $this->Mdl_product->add_cart_item($check_cart->cart_id,$item_id,1);
					$data['cart_item_id'] = $cart_item_id;
					$array=array('status'=>1,'Message'=>'Added To Cart SuccessFully','data'=>$data);
				}else{
					$array=array('status'=>1,'Message'=>'item already exists In Cart','data'=>'');
				}
				
			}else{
				$cart_item_id = $this->Mdl_product->set_cart($item_id, 1, $store_id);
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
			$check_fevourit = $this->Mdl_product->check_fevourit($item_id, $store_id, 1 ,0);
			if($check_fevourit != NULL){
				//delete data
				$this->db->where('user_id', $this->session->User->user_id);
				$this->db->where('item_id', $item_id);
				$this->db->where('store_id', $store_id);
				$this->db->where('type', 1);
				$this->db->where('is_store', 0);
				$this->db->delete('Favourit_item_mster');
				$array=array('status'=>0,'Message'=>'Removed from Favourite','data'=>$check_fevourit);
			}else{
				$data['user_id'] = $this->session->User->user_id;
				$data['item_id'] = $item_id;
				$data['store_id'] = $store_id;
				$data['type'] = 1;
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
