<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Api extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_User_Api');
		$this->load->model('Mdl_emails');
		$this->load->helper(array('form', 'url'));
		header('Content-Type: application/json');
	}
	
	/****************** user profile ***************/
	function User_login(){
		$email = $this->input->post('email', TRUE); 
		$password = $this->input->post('password', TRUE);
		
		
		if($email == NULL){
			$array=array('status'=>'0','Message'=>'Enter Your Email'); 
		}else if($password == NULL){
			$array=array('status'=>'0','Message'=>'Enter Your password'); 
		}else{
			$ck_user = $this->Mdl_User_Api->check_user_email($email);
			if($ck_user == NULL){
				$array=array('status'=>'0','Message'=>'User Not Exist');
			}else if(md5($password) != $ck_user->password){
				$array=array('status'=>'0','Message'=>'Password Not Match');
			}else{
				$array=array('status'=>'1','Message'=>'Loging Success', 'data'=>$ck_user);
			}
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function User_forgot_password(){
		$email = $this->input->post('email', TRUE); 
		
		
		if($email == NULL){
			$array=array('status'=>'0','Message'=>'Enter Your Email'); 
		}else{
			$ck_user = $this->Mdl_User_Api->check_user_email($email);
			if($ck_user == NULL){
				$array=array('status'=>'0','Message'=>'User Not Exist');
			}else{
				$this->Mdl_emails->user_forgot_email($email);
				$array=array('status'=>'1','Message'=>'Loging Success', 'data'=>$ck_user);
			}
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function User_Registration(){
		$post['frist_name'] = $this->input->post('frist_name', TRUE); 
		$post['last_name'] = $this->input->post('last_name', TRUE); 
		$post['username'] = $this->input->post('username', TRUE); 
		$post['contact'] = $this->input->post('contact', TRUE); 
		$post['email'] = $this->input->post('email', TRUE); 
		$post['password'] = $this->input->post('password', TRUE);
		
		
		if($post['frist_name'] == NULL){
			$array=array('status'=>'0','Message'=>'Enter Your Frist Name'); 
		}else if($post['last_name'] == NULL){
			$array=array('status'=>'0','Message'=>'Enter Your Last Name'); 
		}else if($post['username'] == NULL){
			$array=array('status'=>'0','Message'=>'Enter Your User Name'); 
		}else if($post['email'] == NULL){
			$array=array('status'=>'0','Message'=>'Enter Your Email'); 
		}else if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
			$array=array('status'=>'0','Message'=>'Enter Valid Email'); 
		}else if($post['contact'] == NULL){
			$array=array('status'=>'0','Message'=>'Enter Your Contact'); 
		}else if(!preg_match('/^[0-9]{10}+$/', $post['contact'])){
			$array=array('status'=>'0','Message'=>'Enter Valid Contact'); 
		}else if($post['password'] == NULL){
			$array=array('status'=>'0','Message'=>'Enter Your password'); 
		}else if(strlen($post['password']) < 8 || !preg_match("#[0-9]+#",$post['password']) || !preg_match("#[A-Z]+#",$post['password']) || !preg_match("#[a-z]+#",$post['password'])){
			$array=array('status'=>'0','Message'=>'Your Password Must Contain At Least 8 Characters, 1 Number, 1 Capital Letter And 1 Lowercase Letter!'); 
		}else{
			$ck_email = $this->Mdl_User_Api->check_user_email($post['email']);
			$ck_contact = $this->Mdl_User_Api->check_user_contact($post['contact']);
			$ck_username = $this->Mdl_User_Api->check_user_username($post['username']);
			
			if($ck_email){
				$array=array('status'=>'0','Message'=>'Email Id Already exists!'); 
			}else if($ck_contact){
				$array=array('status'=>'0','Message'=>'Contact Number Already exists!'); 
			}else if($ck_username){
				$array=array('status'=>'0','Message'=>'User Name Already exists!'); 
			}else{
				$data = $this->Mdl_User_Api->User_Registr($post);
				$array=array('status'=>'1','Message'=>'Registration Success', 'data'=>$data);
			}
			
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function update_user_profile(){
		$_post['user_id'] = $this->input->post('user_id', TRUE); 
		$_post['frist_name'] = $this->input->post('frist_name', TRUE); 
		$_post['last_name'] = $this->input->post('last_name', TRUE);
		$_post['username'] = $this->input->post('username', TRUE);
		$_post['email'] = $this->input->post('email', TRUE);
		$_post['contact'] = $this->input->post('contact', TRUE);
		$_post['gender'] = $this->input->post('gender', TRUE);
		
		
		if($_post['user_id'] == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!'); 
		}else if($_post['frist_name'] == NULL){
			$array=array('status'=>'0','Message'=>'User Frist Name Is Required!'); 
		}else if($_post['last_name'] == NULL){
			$array=array('status'=>'0','Message'=>'User Last Name Is Required!'); 
		}else if($_post['username'] == NULL){
			$array=array('status'=>'0','Message'=>'UserName Is Required!'); 
		}else if($_post['email'] == NULL){
			$array=array('status'=>'0','Message'=>'User Email Is Required!'); 
		}else if($_post['contact'] == NULL){
			$array=array('status'=>'0','Message'=>'User Contact Is Required!'); 
		}else if($_post['gender'] == NULL){
			$array=array('status'=>'0','Message'=>'User Gender Is Required!'); 
		}else{
				$uset_update = $this->Mdl_User_Api->update_user_profile($_post);
				$array=array('status'=>'1','Message'=>'Profile Update SuccessFully', 'data'=>$uset_update);
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function update_profile_image(){
		$user_id = $this->input->post('user_id', TRUE); 
		$file = $this->input->file('name', TRUE); 
		
		if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'Image Id Is Required!'); 
		}else{
			$array=array('status'=>'1','Message'=>'Profile Update SuccessFully', 'data'=>$file);
		}
		
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//product list
	function products(){
		//$offset = 0;
		//$limit = 10;
		//$user_id = 2;
		//$sort_by = 1;
		//$city = 'Surat';
		
		$offset = $this->input->post('offset', TRUE);
		$limit = $this->input->post('limit', TRUE);
		$user_id = $this->input->post('user_id', TRUE);
		$sort_by = $this->input->post('sort_by', TRUE);
		$category_id = $this->input->post('category_id', TRUE);
		$city = $this->input->post('city', TRUE);
		
		if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!'); 
		}else if($city == NULL){
			$array=array('status'=>'0','Message'=>'City Is Required'); 
		}else{
		
			$products = $this->Mdl_User_Api->get_products($offset, $limit,$sort_by, $city, $category_id);
			
			foreach($products as $val){
				//product images
				$val->images = $this->Mdl_User_Api->get_product_imgs($val->product_id);
				
				//check product fevoutit
				$val->isFevourit = 0;
				$is_store = 0;
				$check_fevourit = $this->Mdl_User_Api->check_fevourit($user_id,$val->product_id, $val->store_id, 1, $is_store);
				if($check_fevourit != NULL){
					$val->isFevourit = 1;
				}
				 
				//store timing
				$store_timin = $this->Mdl_User_Api->get_store_open_time($val->store_id);
				$val->store_timing = $store_timin['store_timing'];
				$val->is_store_open = $store_timin['store_open'];
				
			}
			
			$this->db->select('*');
			$this->db->from('category_master');
			$this->db->where('parent_category', NULL);
			$this->db->where('category_type', 1);
			$this->db->where('category_status', 1);
			$this->db->order_by("order", "ASC");
			$category = $this->db->get()->result();
			
			if($products == NULL){
				$array=array('status'=>1,'Message'=>'No Data','data'=>$products,'category'=>$category);
			}else{
				$array=array('status'=>1,'Message'=>'Success','data'=>$products,'category'=>$category);
			}
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//all Packages list
	function get_packages(){
		//$offset = 0;
		//$limit = 10;
		//$user_id = 4;
		//$sort_by = 1;
		//$city = surat;
		
		$offset = $this->input->post('offset', TRUE);
		$limit = $this->input->post('limit', TRUE);
		$user_id = $this->input->post('user_id', TRUE);
		$sort_by = $this->input->post('sort_by', TRUE);
		$category_id = $this->input->post('category_id', TRUE);
		$city = $this->input->post('city', TRUE);
		
		if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!');
		}else{
			$packages = $this->Mdl_User_Api->get_packages($offset, $limit, $sort_by, $city, $category_id);
			foreach($packages as $val){
				//check pachage fevoutit
				$val->isFevourit = 0;
				$is_store = 0;
				$check_fevourit = $this->Mdl_User_Api->check_fevourit($user_id,$val->Package_id, $val->store_id, 2, $is_store);
				if($check_fevourit != NULL){
					$val->isFevourit = 1;
				}
				
			}
			
			$this->db->select('*');
			$this->db->from('category_master');
			$this->db->where('parent_category', NULL);
			$this->db->where('category_type', 2);
			$this->db->where('category_status', 1);
			$this->db->order_by("order", "ASC");
			$category = $this->db->get()->result();
			
			$array=array('status'=>1,'Message'=>'Success','data'=>$packages,'category'=>$category);
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//Store Packages list
	function get_Store_packages(){
		//$offset = 0;
		//$limit = 10;
		//$user_id = 2;
		//$store_id = 2;
		
		$offset = $this->input->post('offset', TRUE);
		$limit = $this->input->post('limit', TRUE);
		$user_id = $this->input->post('user_id', TRUE);
		$store_id = $this->input->post('store_id', TRUE);
		
		if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!');
		}else if($store_id == NULL){
			$array=array('status'=>'0','Message'=>'Store Id Is Required!'); 
		}else{
			$packages = $this->Mdl_User_Api->get_store_packages($offset, $limit,$user_id, $store_id);
			foreach($packages as $val){
				$ck = $this->Mdl_User_Api->check_package_in_cart($val->Package_id, $user_id, $store_id);
				$val->Cart->InCart = 0;
				if($ck){
					$val->Cart->InCart = 1;
					$val->Cart->cart_item_id = $ck->cart_item_id;
				}
				
			}
			$array=array('status'=>1,'Message'=>'Success','data'=>$packages);
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//product Single
	function get_single_products(){
		
		//$user_id = 4;
		//$product_id = 1;
		//$store_id = 4;
		//$city = 'surat';

		$user_id = $this->input->post('user_id', TRUE);
		$product_id = $this->input->post('product_id', TRUE);
		$store_id = $this->input->post('store_id', TRUE);
		$city = $this->input->post('city', TRUE);
		
		if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!');
		}else if($product_id == NULL){
			$array=array('status'=>'0','Message'=>'Product Id Is Required!'); 
		}else if($store_id == NULL){
			$array=array('status'=>'0','Message'=>'store Id Is Required!'); 
		}else{
		
			$products = $this->Mdl_User_Api->get_single_products($user_id, $product_id, $store_id);
			
				//product images
				$products->images = $this->Mdl_User_Api->get_product_imgs($product_id);
				
				//check product fevoutit
				$products->isFevourit = 0;
				$is_store = 0;
				$check_fevourit = $this->Mdl_User_Api->check_fevourit($user_id,$product_id, $store_id, 1, 0);
				if($check_fevourit != NULL){
					$products->isFevourit = 1;
				}
				 
				//store timing
				$store_timin = $this->Mdl_User_Api->get_store_open_time($products->store_id);
				$products->store_timing = $store_timin['store_timing'];
				$products->is_store_open = $store_timin['store_open'];
				
				//cart
				$cart = $this->Mdl_User_Api->get_cart($user_id, 1);
				if($cart){
					$products->cart_store_id = $cart->store_id ;
				}else{
					$products->cart_store_id = $products->store_id;
				}
				
			
			if($products == NULL){
				$array=array('status'=>1,'Message'=>'No Data','data'=>$products, 'related_products'=>'');
			}else{
				$related_products = $this->Mdl_User_Api->get_related_products($city, $product_id, $products->product_parent_category);
				$array=array('status'=>1,'Message'=>'Success','data'=>$products,'related_products'=>$related_products);
			}
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//Pachage Single
	function get_single_pachage(){
		
		//$user_id = 2;
		//$Package_id = 61;
		//$store_id = 14;

		$user_id = $this->input->post('user_id', TRUE);
		$Package_id = $this->input->post('Package_id', TRUE);
		$store_id = $this->input->post('store_id', TRUE);
		$city = $this->input->post('city', TRUE);
		
		if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!');
		}else if($Package_id == NULL){
			$array=array('status'=>'0','Message'=>'Package Id Is Required!'); 
		}else if($store_id == NULL){
			$array=array('status'=>'0','Message'=>'store Id Is Required!'); 
		}else{
		
			$res = $this->Mdl_User_Api->get_single_pachage($user_id, $Package_id, $store_id);
			
				
				
				//check product fevoutit
				$res->isFevourit = 0;
				$is_store = 0;
				$check_fevourit = $this->Mdl_User_Api->check_fevourit($user_id,$Package_id, $store_id, 2, 0);
				if($check_fevourit != NULL){
					$res->isFevourit = 1;
				}
				
				//cart
				$cart = $this->Mdl_User_Api->get_cart($user_id, 2);
				if($cart){
					$res->cart_store_id = $cart->store_id ;
				}else{
					$res->cart_store_id = $res->store_id;
				}
				
				//store info
				$Stores = $this->Mdl_User_Api->get_single_Store($store_id);
				
				//check Store fevoutit
				$Stores->isFevourit = 0;
				$is_store = 1;
				$check_fevourit = $this->Mdl_User_Api->check_fevourit($user_id,$Stores->store_id, $Stores->store_id, 1, $is_store);
				if($check_fevourit != NULL){
					$Stores->isFevourit = 1;
				}
				
				//check Store Follow
				$Stores->isFollow = 0;
				$check_follow = $this->Mdl_User_Api->check_follow($user_id,$Stores->store_id);
				if($check_follow != NULL){
					$Stores->isFollow = 1;
				}
				 
				//store timing
				$store_timin = $this->Mdl_User_Api->get_store_open_time($Stores->store_id);
				$Stores->store_timing = $store_timin['store_timing'];
				$Stores->is_store_open = $store_timin['store_open']; 
				
			
			if($res == NULL){
				$array=array('status'=>1,'Message'=>'No Data','data'=>$res, 'Stores'=>$Stores, 'related_packages'=>'');
			}else{
				$related_packages = $this->Mdl_User_Api->get_related_packages($city, $Package_id, $res->main_category);
				$array=array('status'=>1,'Message'=>'Success','data'=>$res, 'Stores'=>$Stores, 'related_packages'=>$related_packages);
			}
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//Favorite
	function favouriteRequest(){
		$type = $this->input->post('type', TRUE);
		$item_id = $this->input->post('item_id', TRUE);
		$store_id = $this->input->post('store_id', TRUE);
		$user_id = $this->input->post('user_id', TRUE);
		$is_store = $this->input->post('is_store', TRUE);
		
		if($type == NULL){
			$array=array('status'=>'0','Message'=>'Type Is Required!');
		}else if($item_id == NULL){
			$array=array('status'=>'0','Message'=>'Item Id Is Required!'); 
		}else if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!'); 
		}else if($is_store == NULL){
			$array=array('status'=>'0','Message'=>'Is Store Or Note Id Is Required!'); 
		}else{
			$check_fevourit = $this->Mdl_User_Api->check_fevourit($user_id,$item_id, $store_id, $type,$is_store);
			if($check_fevourit != NULL){
				//delete data
				$this->db->where('user_id', $user_id);
				$this->db->where('item_id', $item_id);
				$this->db->where('store_id', $store_id);
				$this->db->where('type', $type);
				$this->db->where('is_store', $is_store);
				$this->db->delete('Favourit_item_mster');
				$array=array('status'=>0,'Message'=>'Removed from Favourite','data'=>$check_fevourit);
			}else{
				$check_fevourit = $this->Mdl_User_Api->set_item_fevourit($user_id,$item_id, $store_id, $type, $is_store);
				$array=array('status'=>1,'Message'=>'Added To Favourite','data'=>$check_fevourit);
			}
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function get_fevourites(){
		$type = $this->input->post('type', TRUE);
		$is_store = $this->input->post('is_store', TRUE);
		$user_id = $this->input->post('user_id', TRUE);
		$offset = $this->input->post('offset', TRUE);
		$limit = $this->input->post('limit', TRUE);
		
		if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!'); 
		}else if($type == NULL){
			$array=array('status'=>'0','Message'=>'Type Is Required!');
		}else if($is_store == NULL){
			$array=array('status'=>'0','Message'=>'Is Store Or Note Id Is Required!'); 
		}else{
			$fevoutit_data = $this->Mdl_User_Api->get_fevourites($user_id, $type, $is_store, $offset, $limit);
			foreach($fevoutit_data as $val){
				
				if($is_store == 1){//store data
			
				}else if($type == 1){//product
					//product images
					$val->images = $this->Mdl_User_Api->get_product_imgs($val->item_id);
				}else if($type == 2){//service
					
				}
			}
			$array=array('status'=>1,'Message'=>'SuccessFully','data'=>$fevoutit_data);
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//Store List
	function Store_list(){
		//$offset = 0;
		//$limit = 10;
		//$user_id = 2;
		//$category = 173;
		//$sort_by = 1; 
		//$store_type = 1; 
		//$city='surat';
		
		$offset = $this->input->post('offset', TRUE); 
		$limit = $this->input->post('limit', TRUE);
		$user_id = $this->input->post('user_id', TRUE);
		$sort_by = $this->input->post('sort_by', TRUE);
		$category_id = $this->input->post('category_id', TRUE);
		$store_type = $this->input->post('store_type', TRUE);
		$city = $this->input->post('city', TRUE);
		
		$Stores = $this->Mdl_User_Api->get_Store($offset, $limit,$sort_by, $store_type, $city, $category_id);
		
		foreach($Stores as $val){
			
			//check Store fevoutit
			$val->isFevourit = 0;
			$is_store = 1;
			$check_fevourit = $this->Mdl_User_Api->check_fevourit($user_id,$val->store_id, $val->store_id, 1, $is_store);
			if($check_fevourit != NULL){
				$val->isFevourit = 1;
			}
			
			//check Store Follow
			$val->isFollow = 0;
			$check_follow = $this->Mdl_User_Api->check_follow($user_id,$val->store_id);
			if($check_follow != NULL){
				$val->isFollow = 1;
			}
			 
			//store timing
			$store_timin = $this->Mdl_User_Api->get_store_open_time($val->store_id);
			$val->store_timing = $store_timin['store_timing'];
			$val->is_store_open = $store_timin['store_open'];
			
		}
		
		$this->db->select('*');
			$this->db->from('category_master');
			$this->db->where('parent_category', NULL);
			$this->db->where('category_status', 1);
			$this->db->order_by("order", "ASC");
			$category = $this->db->get()->result();
		
		if($Stores == NULL){
			$array=array('status'=>1,'Message'=>'No Data','data'=>$Stores,'category'=>$category);
		}else{
			$array=array('status'=>1,'Message'=>'Success','data'=>$Stores,'category'=>$category);
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//get Single Store
	function singl_Store_list(){
		//$store_id = 0;
		
		$store_id = $this->input->post('store_id', TRUE);
		$user_id = $this->input->post('user_id', TRUE);
		
		if($store_id == NULL){
			$array=array('status'=>'0','Message'=>'Store Id Is Required!'); 
		}else if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!'); 
		}else{
				$Stores = $this->Mdl_User_Api->get_single_Store($store_id);
				
				//check Store fevoutit
				$Stores->isFevourit = 0;
				$is_store = 1;
				$check_fevourit = $this->Mdl_User_Api->check_fevourit($user_id,$Stores->store_id, $Stores->store_id, 1, $is_store);
				if($check_fevourit != NULL){
					$Stores->isFevourit = 1;
				}
				
				//check Store Follow
				$Stores->isFollow = 0;
				$check_follow = $this->Mdl_User_Api->check_follow($user_id,$Stores->store_id);
				if($check_follow != NULL){
					$Stores->isFollow = 1;
				}
				 
				//store timing
				$store_timin = $this->Mdl_User_Api->get_store_open_time($Stores->store_id);
				$Stores->store_timing = $store_timin['store_timing'];
				$Stores->is_store_open = $store_timin['store_open'];
				
			
			if($Stores == NULL){
				$array=array('status'=>1,'Message'=>'No Data','data'=>$Stores);
			}else{
				$array=array('status'=>1,'Message'=>'Success','data'=>$Stores);
			}
		}
		
		
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//Favorite
	function followRequest(){
		$stor_id = $this->input->post('stor_id', TRUE);
		$user_id = $this->input->post('user_id', TRUE);
		
		if($stor_id == NULL){
			$array=array('status'=>'0','Message'=>'Store Id Is Required!'); 
		}else if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!'); 
		}else{
			$check_follow = $this->Mdl_User_Api->check_follow($user_id,$stor_id);
			if($check_follow != NULL){
				//delete data
				$this->db->where('follow_id', $check_follow->follow_id);
				$this->db->delete('Follow_master');
				$array=array('status'=>0,'Message'=>'UnFollowed','data'=>$check_follow);
			}else{
				$this->Mdl_User_Api->set_follow($user_id,$stor_id);
				$array=array('status'=>1,'Message'=>'You Are Follow','data'=>$check_follow);
			}
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function get_Following_store(){
		$user_id = $this->input->post('user_id', TRUE);
		$offset = $this->input->post('offset', TRUE);
		$limit = $this->input->post('limit', TRUE);
		
		if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!'); 
		}else{
			$following_data = $this->Mdl_User_Api->get_Following_store($user_id, $offset, $limit);
			$array=array('status'=>1,'Message'=>'SuccessFully','data'=>$following_data);
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//get store week timing and days
	function get_store_week_timing(){
		$stor_id = $this->input->post('stor_id', TRUE);
		//$stor_id = 2;
		
		if($stor_id == NULL){
			$array=array('status'=>'0','Message'=>'Store Id Is Required!'); 
		}else{
			$week = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
			$data = array();
			foreach($week as $weekday){
				$store_timin = $this->Mdl_User_Api->get_store_open_time($stor_id,$weekday);
				$data[]= $store_timin;
			}
			$array=array('status'=>1,'Message'=>'Add To Follow','data'=>$data);
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//get store home
	function get_store_home(){
		
		$user_id = $this->input->post('user_id', TRUE);
		$store_id = $this->input->post('store_id', TRUE);
		
		if($store_id == NULL){
			$array=array('status'=>'0','Message'=>'Store Id Is Required!'); 
		}else if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!'); 
		}else{
			
			//store products
			$products = $this->Mdl_User_Api->get_store_products($store_id);
			foreach($products as $val){
				//product images
				$val->images = $this->Mdl_User_Api->get_product_imgs($val->product_id);
			}
			
			//store services
			$packages = $this->Mdl_User_Api->get_store_packages(0, 8,$user_id, $store_id);
			
			//store info
			$Store = $this->Mdl_User_Api->get_single_Store($store_id);
			
			$array=array('status'=>1,'Message'=>'Success','products'=>$products, 'packages'=>$packages, 'Store'=>$Store);
		}
		
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
		
	}
	//get product of store
	function get_store_products(){
		//$user_id = 2;
		//$store_id = 2;
		
		$user_id = $this->input->post('user_id', TRUE);
		$store_id = $this->input->post('store_id', TRUE);
		
		if($store_id == NULL){
			$array=array('status'=>'0','Message'=>'Store Id Is Required!'); 
		}else if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!'); 
		}else{
		
			$store_products = $this->Mdl_User_Api->get_store_products($store_id);
			
			foreach($store_products as $val){
				//product images
				$val->images = $this->Mdl_User_Api->get_product_imgs($val->product_id);
				
				//check product fevoutit
				$val->isFevourit = 0;
				$is_store = 0;
				$check_fevourit = $this->Mdl_User_Api->check_fevourit($user_id,$val->product_id, $val->store_id, 1, $is_store);
				if($check_fevourit != NULL){
					$val->isFevourit = 1;
				}
				 
				//store timing
				$store_timin = $this->Mdl_User_Api->get_store_open_time($val->store_id);
				$val->store_timing = $store_timin['store_timing'];
				$val->is_store_open = $store_timin['store_open'];
				
			}
			
			if($store_products == NULL){
				$array=array('status'=>1,'Message'=>'No Data','data'=>$store_products);
			}else{
				$array=array('status'=>1,'Message'=>'Success','data'=>$store_products);
			}
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function report_abuse(){
		$type = $this->input->post('type', TRUE);
		$item_id = $this->input->post('item_id', TRUE);
		$user_id = $this->input->post('user_id', TRUE);
		$is_store = $this->input->post('is_store', TRUE);
		$msg = $this->input->post('msg', TRUE);
		
		if($type == NULL){
			$array=array('status'=>'0','Message'=>'Type Is Required!');
		}else if($item_id == NULL){
			$array=array('status'=>'0','Message'=>'Item Id Is Required!'); 
		}else if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!'); 
		}else if($is_store == NULL){
			$array=array('status'=>'0','Message'=>'Is Store Or Note Id Is Required!'); 
		}else if($msg == NULL){
			$array=array('status'=>'0','Message'=>'Abuse Message Is Required!'); 
		}else{
			$this->Mdl_User_Api->set_report_abuse($user_id,$item_id, $type,$is_store, $msg); 
			$array=array('status'=>1,'Message'=>'Report Abuse Submited SuccessFully','data'=>'');
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function add_to_cart(){
		$type = $this->input->post('type', TRUE);
		$item_id = $this->input->post('item_id', TRUE);
		$user_id = $this->input->post('user_id', TRUE);
		$store_id = $this->input->post('store_id', TRUE);
		
		//$type = 1;
		//$item_id = 3;
		//$user_id = 2;
		//$store_id = 2;
		
		if($type == NULL){
			$array=array('status'=>'0','Message'=>'Type Is Required!');
		}else if($item_id == NULL){
			$array=array('status'=>'0','Message'=>'Item Id Is Required!'); 
		}else if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!'); 
		}else if($store_id == NULL){
			$array=array('status'=>'0','Message'=>'Store Id Is Required!'); 
		}else{
			$check_cart = $this->Mdl_User_Api->get_cart($user_id, $type); 
			if($check_cart->store_id != $store_id){
				//delete user Cart
				$this->db->where('cart_id', $check_cart->cart_id);
				$this->db->delete('Cart_master');
				
				//delete user Cart items
				$this->db->where('cart_id', $check_cart->cart_id);
				$this->db->delete('Cart_item_master');
				
				$check_cart = $this->Mdl_User_Api->get_cart($user_id, $type);
			}
			if($check_cart != NULL){
				$check_cart_item = $this->Mdl_User_Api->get_cart_item($check_cart->cart_id,$item_id,$type); 
				if($check_cart_item == NULL){
					$cart_item_id = $this->Mdl_User_Api->add_cart_item($check_cart->cart_id,$item_id,$type);
					$data['cart_item_id'] = $cart_item_id;
					$array=array('status'=>1,'Message'=>'Added To Cart SuccessFully','data'=>$data);
				}else{
					$array=array('status'=>1,'Message'=>'item already exists In Cart','data'=>'');
				}
				
			}else{
				$cart_item_id = $this->Mdl_User_Api->set_cart($user_id,$item_id, $type, $store_id);
				$data['cart_item_id'] = $cart_item_id;
				$array=array('status'=>1,'Message'=>'Added To Cart SuccessFully','data'=>$data);
			}
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	
	function get_user_cart(){
		$type = $this->input->post('type', TRUE);
		$user_id = $this->input->post('user_id', TRUE);
		
		//$type = 2;
		//$user_id = 2;
		
		if($type == NULL){
			$array=array('status'=>'0','Message'=>'Type Is Required!');
		}else if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!'); 
		}else{
			$user_cart = $this->Mdl_User_Api->get_cart($user_id, $type);
			if($user_cart != NULL){
				$user_cart->cart_items = $this->Mdl_User_Api->get_cart_all_item($user_cart->cart_id, $user_cart->store_id,$type);
				$user_cart->address = $this->Mdl_User_Api->get_single_address($user_cart->address_id);
				foreach($user_cart->cart_items as $img){
					 $img->images = $this->Mdl_User_Api->get_product_imgs($img->item_id);
				}
				
				if($user_cart->cart_items == NULL){
					$this->db->where('cart_id', $user_cart->cart_id);
					$this->db->delete('Cart_master');
				}
				$array=array('status'=>1,'Message'=>'SuccessFully','data'=>$user_cart);
			}else{
				$array=array('status'=>0,'Message'=>'Cart Is Empty','data'=>$user_cart);
			}
			
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function update_cart_qty(){
		$cart_item_id = $this->input->post('cart_item_id', TRUE);
		$qty = $this->input->post('qty', TRUE);
		
		if($cart_item_id == NULL){
			$array=array('status'=>'0','Message'=>'Cart Item Id Is Required!');
		}else if($qty == NULL){
			$array=array('status'=>'0','Message'=>'Cart qty Is Required!'); 
		}else{
			$this->Mdl_User_Api->update_cart_qty($cart_item_id, $qty);
			$array=array('status'=>'1','Message'=>'Cart qty Upadate SuccessFully'); 
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function remove_cart_item(){
		$cart_item_id = $this->input->post('cart_item_id', TRUE);
		
		if($cart_item_id == NULL){
			$array=array('status'=>'0','Message'=>'Cart Item Id Is Required!');
		}else{
			//delete data
			$this->db->where('cart_item_id', $cart_item_id);
			$this->db->delete('Cart_item_master');
			$array=array('status'=>'1','Message'=>'Item Remove SuccessFully'); 
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//get cart count
	function get_cart_count(){
		$user_id = $this->input->post('user_id', TRUE);
		//$user_id = 2;
		
		if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User ID Is Required!');
		}else{
			$data['order_counts'] = $this->Mdl_User_Api->get_cart_count($user_id, 1);
			$data['booking_counts'] = $this->Mdl_User_Api->get_cart_count($user_id, 2);
			$array=array('status'=>1,'Message'=>'Success','data'=>$data);
		}
		
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	 
	}
	
	//get Store Gallary
	function get_store_gallary(){
		$store_id = $this->input->post('store_id', TRUE);
		//$store_id = 2;
		
		if($store_id == NULL){
			$array=array('status'=>'0','Message'=>'Store ID Is Required!');
		}else{
			$res = $this->Mdl_User_Api->get_store_gallary($store_id);
			$array=array('status'=>1,'Message'=>'Success','data'=>$res);
		}
		
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//place order
	function place_order(){
		$post['user_id'] = $this->input->post('user_id', TRUE);
		$post['cart_id'] = $this->input->post('cart_id', TRUE);
		$post['coupon_amount'] = $this->input->post('coupon_amount', TRUE);
		$post['shipping_charge'] = $this->input->post('shipping_charge', TRUE);
		
		//$post['user_id'] = 2;
		//$post['cart_id'] = 1;
		
		if($post['user_id'] == NULL){
			$array=array('status'=>'0','Message'=>'User ID Is Required!');
		}else if($post['cart_id'] == NULL){
			$array=array('status'=>'0','Message'=>'Cart Is Required!');
		}else{
				
			//place to order
			$order_detail = $this->Mdl_User_Api->place_to_order($post);
			
			//set order 
			$this->Mdl_User_Api->place_order_items($order_detail, $post);
			
			//email
			$this->Mdl_emails->order_received_by_store_mail($order_detail['order_id']);
			
			$array=array('status'=>'1','Message'=>'Order Placed SuccessFully');	
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	} 
	
	//cancel order by user
	function upadate_order_status(){
		$order_id = $this->input->post('order_id', TRUE);
		$order_status = $this->input->post('order_status', TRUE);
		
		//$id = 27;
		if($order_id == NULL){
			$array=array('status'=>'0','Message'=>'Order Id Is Required!');
		}else{
			$order_detail = $this->Mdl_User_Api->Get_single_order($order_id);
			if($order_detail == NULL){
				$array=array('status'=>'0','Message'=>'Order Not Exist');
			}else{
				$this->Mdl_User_Api->upadate_order_status($order_id, $order_status);
				
				if($order_status == 7){
					$this->Mdl_emails->order_cancel_by_store_mail($order_id);
				}
				$array=array('status'=>1,'Message'=>'Order Update SuccessFully','data'=>$order_status);
			}
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//cancel order by user
	function upadate_booking_status(){
		$booking_id = $this->input->post('booking_id', TRUE);
		$booking_status = $this->input->post('booking_status', TRUE);
		
		//$id = 27;
		if($booking_id == NULL){
			$array=array('status'=>'0','Message'=>'Order Id Is Required!');
		}else{
			$booking_detail = $this->Mdl_User_Api->Get_single_booking($booking_id);
			if($booking_detail == NULL){
				$array=array('status'=>'0','Message'=>'Order Not Exist');
			}else{
				$this->Mdl_User_Api->upadate_booking_status($booking_id, $booking_status);
				
				if($booking_status == 7){
					$this->Mdl_emails->booking_cancel_by_store_mail($booking_id);
				}
				$array=array('status'=>1,'Message'=>'Order Update SuccessFully','data'=>$booking_status);
			}
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function get_user_address(){
		$user_id = $this->input->post('user_id', TRUE);
		$offset = $this->input->post('offset', TRUE);
		$limit = $this->input->post('limit', TRUE);
		
		if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!');
		}else{
			$addresses = $this->Mdl_User_Api->get_user_address($user_id, $offset, $limit);
			$array=array('status'=>1,'Message'=>'SuccessFully','data'=>$addresses);
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function update_cart_address(){
		$post['address_id'] = $this->input->post('address_id', TRUE);
		$post['address_type'] = $this->input->post('address_type', TRUE);
		$post['take_by'] = $this->input->post('take_by', TRUE);
		$post['customer_name'] = $this->input->post('customer_name', TRUE);
		$post['customer_contact'] = $this->input->post('customer_contact', TRUE);
		$post['note'] = $this->input->post('note', TRUE);
		$post['date'] = $this->input->post('date', TRUE);
		$post['cart_id'] = $this->input->post('cart_id', TRUE);
		$store_type = $this->input->post('store_type', TRUE);
		
		//$post['address_id'] = 1;
		//$post['address_type'] = 1;
		//$post['take_by'] = 1;
		//$post['customer_name'] = 'ravi';
		//$post['customer_contact'] = 1212121212;
		//$post['note'] = 'test';
		//$post['date'] = date("Y-m-d");
		//$post['cart_id'] = 54;
		
		if($post['cart_id'] == NULL){
			$array=array('status'=>'0','Message'=>'Cart Id Is Required!');
		}else if($post['address_type'] == NULL){
			$msg = 'Please Select Delivery Type !';
			if($store_type == 2){ $msg = 'Please Choose Service Location !'; }
			$array=array('status'=>'0','Message'=>$msg);
		}else{
			if($post['address_type'] == 1){ //product = Pickup At Store. service = At Service Provider address
				if($post['take_by'] == NULL){
					$array=array('status'=>'0','Message'=>'Take By Is Required!');
				}else if($post['customer_name'] == NULL){
					$array=array('status'=>'0','Message'=>'Customer Name Is Required!');
				}else if($post['customer_contact'] == NULL){
					$array=array('status'=>'0','Message'=>'Customer Contact Is Required!');
				}else{
					$this->Mdl_User_Api->update_cart_address($post);
					$array=array('status'=>1,'Message'=>'Address Add SuccessFully');
				}
			}else if($post['address_type'] == 2){ //product = Delivery To Address. service = At Your address
				if($post['address_id'] == NULL){
					$array=array('status'=>'0','Message'=>'Please Select Address !');
				}else{
					$this->Mdl_User_Api->update_cart_address($post);
					$array=array('status'=>1,'Message'=>'Address Add SuccessFully');
				}
			}else{
				$array=array('status'=>'0','Message'=>'Somthing Wrong !');
			}
		}
		
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	
	function add_address(){
		$post['user_id'] = $this->input->post('user_id', TRUE);
		$post['name'] = $this->input->post('name', TRUE);
		$post['contact'] = $this->input->post('contact', TRUE);
		$post['address1'] = $this->input->post('address1', TRUE);
		$post['address2'] = $this->input->post('address2', TRUE);
		$post['city'] = $this->input->post('city', TRUE);
		$post['state'] = $this->input->post('state', TRUE);
		$post['country'] = $this->input->post('country', TRUE);
		$post['pincode'] = $this->input->post('pincode', TRUE);
		$post['address_type'] = $this->input->post('address_type', TRUE);
		
		if($post['user_id'] == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!');
		}else if($post['name'] == NULL){
			$array=array('status'=>'0','Message'=>'Name Is Required!');
		}else if($post['contact'] == NULL){
			$array=array('status'=>'0','Message'=>'Contact Is Required!');
		}else if($post['address1'] == NULL){
			$array=array('status'=>'0','Message'=>'Address1 Is Required!');
		}else if($post['city'] == NULL){
			$array=array('status'=>'0','Message'=>'City Is Required!');
		}else if($post['state'] == NULL){
			$array=array('status'=>'0','Message'=>'State Is Required!');
		}else if($post['country'] == NULL){
			$array=array('status'=>'0','Message'=>'Country Is Required!');
		}else if($post['pincode'] == NULL){
			$array=array('status'=>'0','Message'=>'PinCode Is Required!');
		}else if($post['address_type'] == NULL){
			$array=array('status'=>'0','Message'=>'Address Type Is Required!');
		}else{
			$this->Mdl_User_Api->add_address($post);
			$array=array('status'=>1,'Message'=>'Address Add SuccessFully');
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function update_address(){
		$post['address_id'] = $this->input->post('address_id', TRUE);
		$post['user_id'] = $this->input->post('user_id', TRUE);
		$post['name'] = $this->input->post('name', TRUE);
		$post['contact'] = $this->input->post('contact', TRUE);
		$post['address1'] = $this->input->post('address1', TRUE);
		$post['address2'] = $this->input->post('address2', TRUE);
		$post['city'] = $this->input->post('city', TRUE);
		$post['state'] = $this->input->post('state', TRUE);
		$post['country'] = $this->input->post('country', TRUE);
		$post['pincode'] = $this->input->post('pincode', TRUE);
		$post['address_type'] = $this->input->post('address_type', TRUE);
		
		if($post['address_id'] == NULL){
			$array=array('status'=>'0','Message'=>'Address Id Is Required!');
		}else if($post['user_id'] == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!');
		}else if($post['name'] == NULL){
			$array=array('status'=>'0','Message'=>'Name Is Required!');
		}else if($post['contact'] == NULL){
			$array=array('status'=>'0','Message'=>'Contact Is Required!');
		}else if($post['address1'] == NULL){
			$array=array('status'=>'0','Message'=>'Address1 Is Required!');
		}else if($post['city'] == NULL){
			$array=array('status'=>'0','Message'=>'City Is Required!');
		}else if($post['state'] == NULL){
			$array=array('status'=>'0','Message'=>'State Is Required!');
		}else if($post['country'] == NULL){
			$array=array('status'=>'0','Message'=>'Country Is Required!');
		}else if($post['pincode'] == NULL){
			$array=array('status'=>'0','Message'=>'PinCode Is Required!');
		}else if($post['address_type'] == NULL){
			$array=array('status'=>'0','Message'=>'Address Type Is Required!');
		}else{
			$this->Mdl_User_Api->update_address($post);
			$array=array('status'=>1,'Message'=>'Address Upadate SuccessFully');
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function delete_address(){
		$address_id = $this->input->post('address_id', TRUE);
		
		if($address_id == NULL){
			$array=array('status'=>'0','Message'=>'Address Id Is Required!');
		}else{
			
			$this->db->where('address_id', $address_id);
			$this->db->delete('address_master');
			$array=array('status'=>1,'Message'=>'Address Delete SuccessFully');
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function get_user_order(){
		$user_id = $this->input->post('user_id', TRUE);
		$offset = $this->input->post('offset', TRUE);
		$limit = $this->input->post('limit', TRUE);
		if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!');
		}else{
			$order = $this->Mdl_User_Api->get_user_order($user_id, $offset, $limit);
			foreach($order as $od){
				$od->order_item = $this->Mdl_User_Api->get_order_items($od->order_id, 1);
				$od->address = $this->Mdl_User_Api->get_single_address($od->addres_id);
				foreach($od->order_item as $oim){
					//product images
					$oim->images = $this->Mdl_User_Api->get_product_imgs($oim->product_id);
				}
			}
			$array=array('status'=>1,'Message'=>'SuccessFully','data'=>$order);
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function get_user_booking(){
		$user_id = $this->input->post('user_id', TRUE);
		$offset = $this->input->post('offset', TRUE);
		$limit = $this->input->post('limit', TRUE);
		if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User Id Is Required!');
		}else{
			$order = $this->Mdl_User_Api->get_user_booking($user_id, $offset, $limit);
			foreach($order as $od){
				$od->order_item = $this->Mdl_User_Api->get_booking_items($od->booking_id);
				$od->address = $this->Mdl_User_Api->get_single_address($od->addres_id);
			}
			$array=array('status'=>1,'Message'=>'SuccessFully','data'=>$order);
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//get single order details
	function get_single_order_details(){
		$order_id = $this->input->post('order_id', TRUE);
		//$order_id = 27;
		if($order_id == NULL){
			$array=array('status'=>'0','Message'=>'Order Id Is Required!');
		}else{
			$order = $this->Mdl_User_Api->Get_single_order($order_id);
			
			$order->order_item = $this->Mdl_User_Api->get_order_items($order->order_id, 1);
			$order->address = $this->Mdl_User_Api->get_single_address($order->addres_id);
			foreach($order->order_item as $oim){
				//product images
				$oim->images = $this->Mdl_User_Api->get_product_imgs($oim->product_id);
			}
			$array=array('status'=>1,'Message'=>'SuccessFully','data'=>$order);
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//get single Booking details
	function get_single_booking_details(){
		$booking_id = $this->input->post('booking_id', TRUE);
		//$booking_id = 3;
		if($booking_id == NULL){
			$array=array('status'=>'0','Message'=>'Order Id Is Required!');
		}else{
			$order = $this->Mdl_User_Api->Get_single_booking($booking_id);
			
			$order->order_item = $this->Mdl_User_Api->get_booking_items($order->booking_id);
			$order->address = $this->Mdl_User_Api->get_single_address($order->addres_id);
			
			$array=array('status'=>1,'Message'=>'SuccessFully','data'=>$order);
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//order pdf invoice
	function order_invoice_pdf(){
		$id = $this->input->post('order_id', TRUE);
		
		//$id = 27;
		if($id == NULL){
			$array=array('status'=>'0','Message'=>'Order Id Is Required!');
		}else{
			$order_detail = $this->Mdl_User_Api->Get_single_order($id);
		
			$order_detail->store = $this->Mdl_User_Api->get_single_Store($order_detail->store_id);
			
			if($order_detail->delivery_type == 2){
				$order_detail->user_address = $this->Mdl_User_Api->get_single_address($order_detail->addres_id);
			}
			
			$order_detail->Order_items = $this->Mdl_User_Api->Get_order_items($id, 1);
			
			
			$data ['order_detail'] = $order_detail;
			//$this->load->view('templates/product_pdf_invoice',$data);
			$html = $this->load->view('templates/product_pdf_invoice',$data, TRUE);
			
			$filename = "Order-invoce_ord_" . $id . "_user_" . $order_detail->user_id .".pdf"; 
			
			$msg = '<p>Order Id <span style="background-color:#36c6d3;padding:3px;">#' . $id . '</span>.Is On ' . $data['order'][0]['om_date'] . '</p> From ';
          
            $html = str_replace('{{message}}', $msg, $html);
            $this->load->library('pdf');
            $this->pdf->loadHtml($html);
            $this->pdf->setPaper('A4', 'portrait');
            $this->pdf->render();
            $output = $this->pdf->output();
            file_put_contents('uploads/PDF_invoice/' . $filename, $output);
			
			$array=array('status'=>1,'Message'=>'SuccessFully','data'=>base_url()."uploads/PDF_invoice/" . $filename);
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//Booking pdf invoice
	function Booking_pdf_invoice(){
		$id = $this->input->post('booking_id', TRUE);
		//$id = 17;
		if($id == NULL){
			$array=array('status'=>'0','Message'=>'Booking Id Is Required!');
		}else{
			$booking_detail = $this->Mdl_User_Api->Get_single_booking($id);
			
			$booking_detail->store = $this->Mdl_User_Api->get_single_Store($booking_detail->store_id);
			
			if($booking_detail->service_type == 2){
				$booking_detail->user_address = $this->Mdl_User_Api->get_single_address($booking_detail->addres_id);
			}
			
			$booking_detail->Booking_items = $this->Mdl_User_Api->get_booking_items($id);
			
			
			$data ['booking_detail'] = $booking_detail;
			//$this->load->view('templates/Booking_pdf_invoice',$data);
			$html = $this->load->view('templates/Booking_pdf_invoice',$data, TRUE);
			
			$filename = "Booking-invoce_ord_" . $id . "_user_" . $booking_detail->user_id .".pdf"; 
		
            $msg = '<p>Booking Id <span style="background-color:#36c6d3;padding:3px;">#' . $id . '</span>.Is On </p> From ';
          
            $html = str_replace('{{message}}', $msg, $html);
            $this->load->library('pdf');
            $this->pdf->loadHtml($html);
            $this->pdf->setPaper('A4', 'portrait');
            $this->pdf->render();
            $output = $this->pdf->output();
            file_put_contents('uploads/PDF_invoice/' . $filename, $output);
			
			$array=array('status'=>1,'Message'=>'SuccessFully','data'=>base_url()."uploads/PDF_invoice/" . $filename);
		}
			
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//place order
	function place_booking(){
		$post['user_id'] = $this->input->post('user_id', TRUE);
		$post['cart_id'] = $this->input->post('cart_id', TRUE);
		$post['coupon_amount'] = $this->input->post('coupon_amount', TRUE);
		$post['inspection_charge'] = $this->input->post('inspection_charge', TRUE);
		$post['service_charge'] = $this->input->post('service_charge', TRUE);
		
		//$post['user_id'] = 2;
		//$post['cart_id'] = 1;
		
		
		 if($post['user_id'] == NULL){
			$array=array('status'=>'0','Message'=>'User ID Is Required!');
		}else if($post['cart_id'] == NULL){
			$array=array('status'=>'0','Message'=>'Cart Id Is Required!');
		}else{
			//place to order
			$booking_detail = $this->Mdl_User_Api->book_service($post);
			
			//set order 
			 $this->Mdl_User_Api->set_booking_items($booking_detail, $post);
			
			//email
			$this->Mdl_emails->booking_received_by_store_mail($booking_detail['booking_id']);
			$array=array('status'=>'1','Message'=>'Service Book SuccessFully');
		}
				
		
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	} 
	
	/**************** Coupons ********************/
	function add_coupons(){
		$post['user_id'] = $this->input->post('user_id', TRUE);
		$post['store_id'] = $this->input->post('store_id', TRUE);
		$post['cart_id'] = $this->input->post('cart_id', TRUE);
		$post['coupon_code'] = $this->input->post('coupon_code', TRUE);
		$post['cart_amount'] = $this->input->post('cart_amount', TRUE);
		
		//$post['user_id'] = 2;
		//$post['store_id'] = 2;
		//$post['cart_id'] = 64;
		//$post['coupon_code'] = 'DIWALI50';
		//$post['cart_amount'] = 100;
		
		if($post['user_id'] == NULL){
			$array=array('status'=>'0','Message'=>'User ID Is Required!');
		}else if($post['store_id'] == NULL){
			$array=array('status'=>'0','Message'=>'Store ID Is Required!');
		}else if($post['cart_id'] == NULL){
			$array=array('status'=>'0','Message'=>'Catr ID Is Required!');
		}else if($post['coupon_code'] == NULL){
			$array=array('status'=>'0','Message'=>'Coupon Code Is Required!');
		}else if($post['cart_amount'] == NULL){
			$array=array('status'=>'0','Message'=>'Cart Amount Is Required!');
		}else{
			$coupon = $this->Mdl_User_Api->get_coupon($post);
			if($coupon == NULL){
				$array=array('status'=>'0','Message'=>'Coupon Not Exist', 'data'=>$coupon);
			}else{
				$user_coupon = $this->Mdl_User_Api->get_user_coupon_history($post, $coupon);
				$coupon->counts = $user_coupon;
				if(date("Y-m-d") >= $coupon->coupon_end_date || date("Y-m-d") < $coupon->coupon_start_date){ // check date
					$array=array('status'=>'0','Message'=>'Coupon Expired!', 'data'=>$coupon);
				}else if($coupon->coupon_per_user > 0 && $user_coupon >= $coupon->coupon_per_user){ // check Coupon limit per user
					$array=array('status'=>'0','Message'=>'Sorry ! Your Max Coupon Limit Is Over!', 'data'=>$coupon);
				}else if($coupon->coupon_limit <= 0){ //check coupon limit
					$array=array('status'=>'0','Message'=>'Sorry ! Coupon Limit Is Over!', 'data'=>$coupon);
				}else if($post['cart_amount'] < $coupon->cart_min_amount){ // check coupon minimum amount
					$array=array('status'=>'0','Message'=>'Coupon Is Not Valid On This Amount min!', 'data'=>$coupon);
				}else if($post['cart_amount'] > $coupon->cart_max_amount){ // check coupon maximum amount
					$array=array('status'=>'0','Message'=>'Coupon Is Not Valid On This Amount max!', 'data'=>$coupon);
				}else{
					$this->Mdl_User_Api->set_coupon_in_cart($post, $coupon);
					$array=array('status'=>1,'Message'=>'Coupon Added SuccessFully','data'=>$coupon);
				}
			}
			
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function remove_Coupon(){
		$post['user_id'] = $this->input->post('user_id', TRUE);
		$post['store_id'] = $this->input->post('store_id', TRUE);
		$post['cart_id'] = $this->input->post('cart_id', TRUE);
		
		if($post['user_id'] == NULL){
			$array=array('status'=>'0','Message'=>'User ID Is Required!');
		}else if($post['store_id'] == NULL){
			$array=array('status'=>'0','Message'=>'Store ID Is Required!');
		}else if($post['cart_id'] == NULL){
			$array=array('status'=>'0','Message'=>'Cart ID Is Required!');
		}else{
			$this->Mdl_User_Api->remove_coupon_in_cart($post['cart_id']);
			$array=array('status'=>1,'Message'=>'Coupon Removed SuccessFully','data'=>$coupon);
			
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	/**************** Home ********************/
	
	function search(){
		$city = $this->input->post('city', TRUE);
		$search_text = $this->input->post('search_text', TRUE);
		$search_type = $this->input->post('search_type', TRUE);
		
		$result = $this->Mdl_User_Api->get_search($city, $search_text, $search_type);
		
		$array=array('status'=>1,'Message'=>'Success','data'=>$result);
		
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	/**************** Home ********************/
	
	
	function get_home_Stores(){ 
		//$offset = 0;
		//$limit = 10;
		//$user_id = 2;
		//$category = 173;
		//$sort_by = 1; 
		//$store_type = 1; 
		//$city='surat';
		
		$offset = 0; 
		$limit = 8;
		$user_id = $this->input->post('user_id', TRUE);
		$city = $this->input->post('city', TRUE);
		
		$Stores = $this->Mdl_User_Api->get_all_main_categories($city);
		$Stores['stores'] = $this->Mdl_User_Api->get_home_Stores($city);
		$Stores['banner'] = $this->Mdl_User_Api->get_home_banner();
		$Stores['products'] = $this->Mdl_User_Api->get_home_products($city);
		$Stores['packages'] = $this->Mdl_User_Api->get_home_packages($city);
		
		
		
		if($Stores == NULL){
			$array=array('status'=>1,'Message'=>'No Data','data'=>$Stores);
		}else{
			$array=array('status'=>1,'Message'=>'Success','data'=>$Stores);
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	/**************** other ********************/

	
	function get_faq(){
		
		$faq = $this->Mdl_User_Api->get_faq();
		$array=array('status'=>1,'Message'=>'SuccessFully','data'=>$faq);
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function get_eagles(){
		
		$faq = $this->Mdl_User_Api->get_eagles();
		$array=array('status'=>1,'Message'=>'SuccessFully','data'=>$faq);
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	/**************** Locations ********************/
	function get_cities(){
		
		$city = $this->Mdl_User_Api->get_cities();
		$array=array('status'=>1,'Message'=>'SuccessFully','data'=>$city);
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	/**************** Chat ********************/
	
	function get_user_chat_list(){
		$user_id = $this->input->post('user_id', TRUE);
		
		//$user_id = 2;
		
		
		 if($user_id == NULL){
			$array=array('status'=>'0','Message'=>'User ID Is Required!');
		}else {
			$chats = $this->Mdl_User_Api->get_user_chat_list($user_id);
			foreach($chats as $val){
				 $to_info = $this->Mdl_User_Api->get_to_details($val->to);
				 $val->to_image =  $to_info->to_image;
				 $val->to_name =  $to_info->to_name;
				 $val->created_at = date("g:iA", strtotime($val->created_at));
			}
			$array=array('status'=>1,'Message'=>'SuccessFully','data'=>$chats);
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function get_uset_chat_history(){
		$from_id = $this->input->post('from_id', TRUE);
		$to_id = $this->input->post('to_id', TRUE);
		$offset = $this->input->post('offset', TRUE);
		$limit = $this->input->post('limit', TRUE);
		
		
		//$from_id = 2;
		//$to_id = 11;
		//$offset = 0;
		//$limit = 100;
		
		 if($from_id == NULL){
			$array=array('status'=>'0','Message'=>'From ID Is Required!');
		}else if($to_id == NULL){
			$array=array('status'=>'0','Message'=>'To ID Is Required!');
		}else {
			$chats = $this->Mdl_User_Api->get_uset_chat_history($from_id, $to_id, $offset, $limit);
			
			$array=array('status'=>1,'Message'=>'SuccessFully','data'=>$chats);
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
}
?>
