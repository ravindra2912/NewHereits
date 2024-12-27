<?php 
class Mdl_User_Api extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function check_user_email($email){
		$this->db->select('*');
		$this->db->from('User_master');
		$this->db->where('email', $email);
		return $this->db->get()->row();
	}
	
	function check_user_contact($contact){
		$this->db->select('*');
		$this->db->from('User_master');
		$this->db->where('contact', $contact);
		return $this->db->get()->row();
	}
	
	function check_user_username($username){
		$this->db->select('*');
		$this->db->from('User_master');
		$this->db->where('username', $username);
		return $this->db->get()->row();
	}
	
	function User_Registr($post){
		$post['created_at'] = date("Y-m-d H:i:s");
		$post['updated_at'] = date("Y-m-d H:i:s");
		$this->db->insert('User_master',$post);
		$id = $this->db->insert_id();
		
		$this->db->select('*');
		$this->db->from('User_master');
		$this->db->where('user_id', $id);
		return $this->db->get()->row();
	}
	
	function update_user_profile($_post){
		$_post['updated_at'] = date("Y-m-d H:i:s");
		$this->db->where('user_id', $_post['user_id']);
		$this->db->update('User_master',$_post);
		
		$this->db->select('*');
		$this->db->from('User_master');
		$this->db->where('user_id', $_post['user_id']);
		return $this->db->get()->row();
	}
	
	function get_single_user($user_id){
		$this->db->select('*');
		$this->db->from('User_master');
		$this->db->where('user_id', $user_id);
		return $this->db->get()->row();
	}
	
	
	function get_products($offset, $limit, $sort_by, $city){
		$this->db->select('pm.product_name, spm.*, sm.Store_name, cm.category_name');
		$this->db->from('store_product_master as spm');
		
		
		$this->db->join('product_master AS pm','pm.product_id = spm.product_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
		
		//check subscription
		$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
		$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		
		
		$this->db->join('category_master AS cm','cm.category_id = pm.product_parent_category','Left');
		
		$this->db->limit($limit, $offset); 
		$this->db->where('spm.product_status', 1);
		$this->db->where('pm.product_status', 1);
		$this->db->where('sm.store_status', 1);
		$this->db->where('sm.city', $city);
		
		//sort product
		if($sort_by == 1){
			//Popularity
		}else if($sort_by == 2){
			//Location
		}else if($sort_by == 3){
			//Newest First
			$this->db->order_by("pm.created_at", "DESC");
		}else if($sort_by == 4){
			//Rating
		}else if($sort_by == 5){
			//Price: Low to High
			$this->db->order_by("spm.product_sele_price", "ASC");
		}else if($sort_by == 6){
			//Price: High to Low
			$this->db->order_by("spm.product_sele_price", "DESC");
		}
		return $this->db->get()->result();
	}
	
	function get_store_packages($offset, $limit,$user_id, $store_id){
		$this->db->select('spm.*, pm.Package_name, pm.packege_image, spm.store_id');
		$this->db->from('store_Packages_master as spm');
		
		$this->db->join('Packages_master AS pm','pm.Package_id = spm.Package_id','Left');
		
		$this->db->limit($limit, $offset); 
		$this->db->where('spm.packege_status', 1);
		$this->db->where('pm.packege_status', 1);
		$this->db->where('spm.store_id', $store_id);
		return $this->db->get()->result();
	}
	
	function check_package_in_cart($Package_id, $user_id, $store_id){
		$this->db->select('cim.*');
		$this->db->from('Cart_item_master as cim');
		
		
		$this->db->join('Cart_master AS cm','cm.cart_id = cim.cart_id','Left');
		
		$this->db->where('cim.item_id', $Package_id);
		$this->db->where('cm.user_id', $user_id);
		$this->db->where('cm.store_id', $store_id);
		$this->db->where('cm.store_type', 2);
		return $this->db->get()->row();
	}
	
	function get_single_products($user_id, $product_id, $store_id){
		$this->db->select('pm.product_name, spm.*, sm.Store_name, sm.store_id, cm.category_name');
		
		$this->db->from('store_product_master as spm');
		$this->db->where('spm.store_id', $store_id);
		$this->db->where('spm.product_id', $product_id);
		$this->db->join('product_master AS pm','pm.product_id = spm.product_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
		$this->db->join('category_master AS cm','cm.category_id = pm.product_parent_category','Left');
		
		
		return $this->db->get()->row();
	}
	
	function get_store_products($store_id){
		$this->db->select('pm.product_name, spm.*, sm.Store_name, cm.category_name');
		$this->db->from('store_product_master as spm');
		
		$this->db->join('product_master AS pm','pm.product_id = spm.product_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
		
		$this->db->join('category_master AS cm','cm.category_id = pm.product_parent_category','Left');
		
		$this->db->limit($limit, $offset); 
		$this->db->where('pm.product_status', 1);
		$this->db->where('spm.product_status', 1);
		$this->db->where('spm.store_id', $store_id);
		return $this->db->get()->result();
	}
	function get_product_imgs($pid){
		$this->db->select('*');
		$this->db->from('product_image_master');
		$this->db->where('product_id', $pid);
		$this->db->order_by("image_order", "asc");
		return $this->db->get()->result();
	}
	
	//fevourite
	function check_fevourit($user_id,$item_id, $store_id, $type,$is_store){
		$this->db->select('*');
		$this->db->from('Favourit_item_mster');
		$this->db->where('user_id', $user_id);
		$this->db->where('item_id', $item_id);
		$this->db->where('store_id', $store_id);
		$this->db->where('type', $type);
		$this->db->where('is_store', $is_store);
		return $this->db->get()->row();
	}
	
	function set_item_fevourit($user_id,$item_id, $store_id, $type,$is_store){
		$data['user_id'] = $user_id;
		$data['item_id'] = $item_id;
		$data['store_id'] = $store_id;
		$data['type'] = $type;
		$data['is_store'] = $is_store;
	
		$this->db->insert('Favourit_item_mster',$data);
	}
	
	function get_fevourites($user_id, $type, $is_store, $offset, $limit){
		
		if($is_store == 1){//store data
			$this->db->select('	fm.*, sm.* ');
			$this->db->from('Favourit_item_mster as fm');
			$this->db->join('Store_master AS sm','sm.store_id = fm.item_id','Left');
			$this->db->where('fm.user_id', $user_id);
			//$this->db->where('fm.type', $type);
			$this->db->where('fm.is_store', $is_store);
			$this->db->where('sm.store_status', 1);
			$this->db->limit($limit, $offset);
			return $this->db->get()->result();
		}else if($type == 1){//product
			$this->db->select('	fm.*, pm.* ');
			$this->db->from('Favourit_item_mster as fm');
			$this->db->join('product_master AS pm','pm.product_id = fm.item_id','Left');
			$this->db->where('fm.user_id', $user_id);
			$this->db->where('fm.type', $type);
			$this->db->where('fm.is_store', $is_store);
			$this->db->where('pm.product_status', 1);
			$this->db->limit($limit, $offset);
			return $this->db->get()->result();
		}else if($type == 2){//service
			
		}
		
		
	}
	
	//Store timing
	function get_store_open_time($store_id, $weekday = null){
		
		if($weekday == null){
			$weekday = date("l", strtotime(date('Y-m-d')));
		}
		//get day
		$this->db->select('*');
		$this->db->from('store_timing_master');
		$this->db->where('store_id', $store_id);
		$this->db->where('day', $weekday);
		$store_day_id = $this->db->get()->row();
		
		
		//opening time
		$this->db->select('*');
		$this->db->from('store_timing_slot_master');
		$this->db->where('store_timing_id', $store_day_id->store_timing_id);
		$this->db->order_by("start_time", "ASC");
		$store_open_time = $this->db->get()->row();
		if($store_open_time->start_time == NULL){
			$store_open_time->start_time = '08:00:00';
		}
		
		//closing time
		$this->db->select('*');
		$this->db->from('store_timing_slot_master');
		$this->db->where('store_timing_id', $store_day_id->store_timing_id);
		$this->db->order_by("end_time", "DESC");
		$store_close_time = $this->db->get()->row();
		if($store_close_time->end_time == NULL){
			$store_close_time->end_time = '20:00:00';
		}
		
		$data['store_timing'] = '( '.date("g:iA", strtotime($store_open_time->start_time)).' - '.date("g:iA", strtotime($store_close_time->end_time)) .' )';
		
		if($store_day_id->closed == 1){
			$data['store_open'] = 0; //Close
		}
		else if(date("H:i:s") >= $store_open_time->start_time  && date("H:i:s") <= $store_close_time->end_time ){
			$data['store_open'] = 1; //Open
		}else{
			$data['store_open'] = 0; //Close
		}
		$data['week_day'] = $weekday;
		return $data;
	}
	
	function get_Store($offset, $limit, $sort_by, $store_type, $city, $category){
		$this->db->select('sm.*');
		$this->db->from('Store_master as sm');
		
		//sort product
		if($sort_by == 1){
			//Popularity
		}else if($sort_by == 2){
			//Location
		}else if($sort_by == 3){
			//Newest First
			$this->db->order_by("sm.created_at", "DESC");
		}else if($sort_by == 4){
			//Rating
		}
		
		
		if($category  != ''){
			$this->db->join('Store_category_master AS scm','scm.store_id = sm.store_id', 'Left');
			$this->db->where('scm.category_id', $category);
		}
		
		//check subscription
		$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
		$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		if($store_type  == 1){
			$this->db->where('sum.type !=', 2);
			$this->db->join('store_product_master AS spm','spm.store_id = sm.store_id');
			$this->db->join('product_master AS pm','pm.product_id = spm.product_id');
			$this->db->where('spm.product_status ', 1);
			$this->db->where('pm.product_status ', 1);
		}else if($store_type  == 2){
			$this->db->where('sum.type !=', 1);
			$this->db->join('store_Packages_master AS spm','spm.store_id = sm.store_id');
			$this->db->join('Packages_master AS pm','pm.Package_id = spm.Package_id');
			$this->db->where('spm.packege_status ', 1);
			$this->db->where('pm.packege_status ', 1);
		}
		
		$this->db->group_by('sm.store_id');
		$this->db->where('sm.city', $city);
		$this->db->limit($limit, $offset); 
		$this->db->where('sm.store_status', 1);
		//$this->db->where('store_type', $store_type);
		//$this->db->or_where_in('store_type', 3);
		return $this->db->get()->result();
	}
	
	//get single store
	function get_single_Store($store_id){
		$this->db->select('sm.*, sum.type as store_type');
		$this->db->from('Store_master as sm');
		$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
		$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		$this->db->where('sm.store_status', 1);
		$this->db->where('sm.store_id', $store_id);
		return $this->db->get()->row();
	}
	
	//follow
	function check_follow($user_id,$stor_id){
		$this->db->select('*');
		$this->db->from('Follow_master');
		$this->db->where('user_id', $user_id);
		$this->db->where('stor_id', $stor_id);
		return $this->db->get()->row();
	}
	
	function set_follow($user_id,$stor_id){
		$data['user_id'] = $user_id;
		$data['stor_id'] = $stor_id;
	
		$this->db->insert('Follow_master',$data);
	}
	
	function get_Following_store($user_id,$offset, $limit){
		$this->db->select(
			'fm.*,
			sm.store_id,
			sm.Store_name,
			sm.store_image,
			sm.store_address,
			sm.store_address_2,
			'
		);
		$this->db->from('Follow_master as fm');
		$this->db->join('Store_master AS sm','sm.store_id = fm.stor_id','Left');
		$this->db->where('fm.user_id', $user_id);
		$this->db->where('sm.store_status', 1);
		$this->db->limit($limit, $offset);
		return $this->db->get()->result();
	}
	
	function set_report_abuse($user_id,$item_id, $type,$is_store, $msg){
		$data['user_id'] = $user_id;
		$data['item_id'] = $item_id;
		$data['type'] = $type;
		$data['is_store'] = $is_store;
		$data['msg'] = $msg;
	
		$this->db->insert('Report_abuse_master',$data);
	}
	
	function get_cart($user_id, $type){
		$this->db->select('
			cm.*, 
			sm.delivery_to_address, 
			sm.shipping_charge, 
			sm.minimum_cart_amount, 
			sm.service_to_address, 
			sm.minimum_service_cart_amount, 
			sm.service_charge, 
			sm.inspection_charge
			');
		$this->db->from('Cart_master as cm');
		$this->db->join('Store_master AS sm','sm.store_id = cm.store_id','Left');
		$this->db->where('cm.user_id', $user_id);
		$this->db->where('cm.store_type', $type);
		return $this->db->get()->row();
	}
	
	function set_cart($user_id,$item_id, $type, $store_id){
		
		//insert to cart
		$cart['user_id'] = $user_id;
		$cart['store_id'] = $store_id;
		$cart['store_type'] = $type;
		$this->db->insert('Cart_master',$cart);
		$cart_id = $this->db->insert_id();
		 
		return $this->add_cart_item($cart_id,$item_id,$type);
	}
	
	//insert cart item 
	function add_cart_item($cart_id,$item_id,$type){
		$cart['cart_id'] = $cart_id;
		$cart['item_id'] = $item_id;
		$cart['type'] = $type;
	
		$this->db->insert('Cart_item_master',$cart);
		
		return $this->db->insert_id();
	}
	
	function get_cart_item($cart_id,$item_id,$type){
		$this->db->select('*');
		$this->db->from('Cart_item_master');
		$this->db->where('cart_id', $cart_id);
		$this->db->where('item_id', $item_id);
		$this->db->where('type', $type);
		return $this->db->get()->row();
	}
	
	function get_cart_all_item($cart_id, $store_id, $type){
		
		if($type == 1){
			$this->db->select(
				'cim.*,pm.product_id,
				pm.product_name,
				spm.product_price,
				spm.product_sele_price,
				spm.product_qty,
				spm.store_id,
				sm.Store_name'
			);
		}else if($type == 2){
				$this->db->select('
					cim.*, 
					spm.packege_price, 
					spm.packege_sale_price, 
					spm.packege_description, 
					spm.packege_excludes, 
					spm.packege_includes, 
					pm.Package_name, 
					pm.packege_image, 
					sm.Store_name
				' );
		}
		
		$this->db->from('Cart_item_master as cim');
		if($type == 1){
			$this->db->join('product_master AS pm','pm.product_id = cim.item_id','Left');
			$this->db->join('store_product_master AS spm','spm.product_id = cim.item_id','Left');
			$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
			$this->db->where('spm.store_id', $store_id);
		}else if($type == 2){
			$this->db->join('store_Packages_master AS spm','spm.Package_id = cim.item_id','Left');
			$this->db->join('Packages_master AS pm','pm.Package_id = spm.Package_id','Left');
			$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
			$this->db->where('spm.store_id', $store_id);
		}
		$this->db->where('cim.cart_id', $cart_id);
		$this->db->where('cim.type', $type);
		return $this->db->get()->result();
	}
	
	function update_cart_qty($cart_item_id, $qty){
		$cart['cart_qty'] = $qty;
	
		$this->db->where('cart_item_id', $cart_item_id);
		$this->db->update('Cart_item_master',$cart);
	}
	
	//get cart count
	function get_cart_count($user_id, $type){
		
		$this->db->select('*');
		$this->db->from('Cart_master');
		$this->db->where('user_id', $user_id);
		$this->db->where('store_type',  $type);
		$cart_data = $this->db->get()->row();
		
		$this->db->select('count(*) as allcount');
		$this->db->from('Cart_item_master');
		
		
		$this->db->where('cart_id', $cart_data->cart_id);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	
	function get_store_gallary($store_id){
		$this->db->select('*');
		$this->db->from('album_master');
		$this->db->where('store_id', $store_id);
		$gallary = $this->db->get()->result();
		
		foreach($gallary as $val){
			$this->db->select('*');
			$this->db->from('album_image_master');
			$this->db->where('album_id', $val->album_id);
			$val->images = $this->db->get()->result();
			 
		}
		
		return $gallary;
	}
	
	function place_to_order($post){
		
		//get user cart
		$this->db->select('*');
		$this->db->from('Cart_master');
		$this->db->where('user_id', $post['user_id']);
		$this->db->where('store_type', 1);
		$cart_data = $this->db->get()->row();
		
		if($cart_data->coupon_id != NULL){
			$order['coupon_id'] = $cart_data->coupon_id;
			$order['coupon_code'] = $cart_data->coupon_code;
			$order['coupon_amount'] = $post['coupon_amount'];
		}
		
		$order['shipping_charge'] = $post['shipping_charge'];
		$order['user_id'] = $post['user_id'];
		$order['store_id'] = $cart_data->store_id;
		$order['order_note'] = $cart_data->note;
		$order['payment_type'] = 1;
		$order['payment_status'] = 1;
		$order['created_at_date'] = date("Y-m-d");
		$order['created_at_time'] = date("H:i:s");
		$order['updated_at'] = date("Y-m-d H:i:s");
		
		if($cart_data->address_type == 1){
			$order['pickup_by'] = $cart_data->take_by;
			$order['pickup_name'] = $cart_data->customer_name;
			$order['pickup_contact'] = $cart_data->customer_contact;
		}
		
		if($cart_data->address_type == 2){
			$order['addres_id'] = $cart_data->address_id;
		}
		
		
		$order['delivery_type'] = $cart_data->address_type;
		
		
		$this->db->insert('Order_master',$order);
		$data['order_id'] = $this->db->insert_id();
		
		$data['cart_id'] = $cart_data->cart_id;
		$data['store_id'] = $cart_data->store_id;
		
		//delete user Cart
		$this->db->where('cart_id', $cart_data->cart_id);
		$this->db->delete('Cart_master');
		
		return $data;
	}
	
	function place_order_items($order_detail, $post){
		
			//get cart items
			$this->db->select('cim.*, spm.product_price, spm.product_sele_price');
			$this->db->from('Cart_item_master as cim');
			$this->db->join('store_product_master AS spm','spm.product_id = cim.item_id','Left');
			$this->db->where('cim.cart_id', $order_detail['cart_id']);
			$this->db->where('spm.store_id', $order_detail['store_id']);
			$cart_items = $this->db->get()->result();
			
			
			foreach($cart_items as $ci){
				$data['order_id'] = $order_detail['order_id'];
				$data['item_id'] = $ci->item_id;
				$data['type'] = $ci->type;
				$data['order_qty'] = $ci->cart_qty;
				$data['item_amount'] = $ci->product_sele_price;
				$this->db->insert('order_item_mastet',$data);
			}
		
		//delete user Cart
		$this->db->where('cart_id', $order_detail['cart_id']);
		$this->db->delete('Cart_item_master');
	}
	
	function upadate_order_status($order_id, $status){
		$data['order_status'] = $status;
		$this->db->where('order_id', $order_id);
		$this->db->update('Order_master',$data);
	}
	
	function upadate_booking_status($booking_id, $booking_status){
		$data['booking_status'] = $booking_status;
		$this->db->where('booking_id', $booking_id);
		$this->db->update('booking_master',$data);
	}
	
	
	function get_user_address($user_id, $offset, $limit){
		$this->db->select('*');
		$this->db->from('address_master');
		$this->db->where('user_id', $user_id);
		$this->db->limit($limit, $offset);
		return $this->db->get()->result();
	}
	
	function get_single_address($address_id){
		$this->db->select('*');
		$this->db->from('address_master');
		$this->db->where('address_id', $address_id);
		return $this->db->get()->row();
	}
	
	function update_cart_address($post){
		$this->db->where('cart_id',$post['cart_id']);
		$this->db->update('Cart_master',$post);
	}
	
	
	function add_address($post){
		$data['user_id'] = $post['user_id'];
		$data['name'] = $post['name'];
		$data['contact'] = $post['contact'];
		$data['address1'] = $post['address1'];
		$data['address2'] = $post['address2'];
		$data['city'] = $post['city'];
		$data['state'] = $post['state'];
		$data['country'] = $post['country'];
		$data['pincode'] = $post['pincode'];
		$data['address_type'] = $post['address_type'];
		$data['created_at'] = date("Y-m-d H:i:s");
		
		$this->db->insert('address_master',$data);
	}
	
	function update_address($post){
		$data['user_id'] = $post['user_id'];
		$data['name'] = $post['name'];
		$data['contact'] = $post['contact'];
		$data['address1'] = $post['address1'];
		$data['address2'] = $post['address2'];
		$data['city'] = $post['city'];
		$data['state'] = $post['state'];
		$data['country'] = $post['country'];
		$data['pincode'] = $post['pincode'];
		$data['address_type'] = $post['address_type'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		$this->db->where('address_id', $post['address_id']);
		$this->db->update('address_master',$data);
	}
	
	function get_user_order($user_id,$offset, $limit){
		$this->db->select(
			'om.*, 
			sm.store_id,
			sm.Store_name,
			sm.store_image, 
			sm.store_address, 
			sm.store_address_2'
		);
		$this->db->from('Order_master as om');
		$this->db->join('Store_master AS sm','sm.store_id = om.store_id','Left');
		$this->db->where('om.user_id', $user_id);
		$this->db->limit($limit, $offset);
		$this->db->order_by("created_at_date", "desc");
		$this->db->order_by("created_at_time", "desc");
		return $this->db->get()->result();
	}
	
	function get_user_booking($user_id,$offset, $limit){
		$this->db->select(
			'bm.*, 
			sm.store_id,
			sm.Store_name,
			sm.store_image, 
			sm.store_address, 
			sm.store_address_2'
		);
		$this->db->from('booking_master as bm');
		$this->db->join('Store_master AS sm','sm.store_id = bm.store_id','Left');
		$this->db->where('bm.user_id', $user_id);
		$this->db->limit($limit, $offset);
		$this->db->order_by("created_at_date", "desc");
		$this->db->order_by("created_at_time", "desc");
		return $this->db->get()->result();
	}
	
	function Get_single_order($order_id){
		$this->db->select('
			om.*, 
			sm.store_id,
			sm.Store_name,
			sm.store_image, 
			sm.store_address, 
			sm.store_address_2
		');
		$this->db->from('Order_master as om');
		$this->db->join('Store_master AS sm','sm.store_id = om.store_id','Left');
		$this->db->where('om.order_id', $order_id);
		return $this->db->get()->row();
	}
	
	function get_order_items($order_id, $type){
		
		if($type == 1){
			$this->db->select(
				'oim.*, 
				pm.product_name,
				pm.product_id,
				'
			);
			$this->db->from('order_item_mastet as oim');
			$this->db->join('product_master AS pm','pm.product_id = oim.item_id','Left');
			$this->db->where('oim.order_id', $order_id);
			return $this->db->get()->result();
		}else if($type == 2){
			$this->db->select(
				'oim.*, 
				pm.Package_name,
				pm.Package_id,
				'
			);
			$this->db->from('order_item_mastet as oim');
			$this->db->join('Packages_master AS pm','pm.Package_id = oim.item_id','Left');
			$this->db->where('oim.order_id', $order_id);
			return $this->db->get()->result();
		}
		
	}
	
	function get_booking_items($booking_id){
		
		$this->db->select(
			'bim.*, 
			pm.Package_name,
			pm.Package_id,
			pm.packege_image,
			'
		);
		$this->db->from('booking_item_master as bim');
		$this->db->join('Packages_master AS pm','pm.Package_id = bim.item_id','Left');
		$this->db->where('bim.booking_id', $booking_id);
		return $this->db->get()->result();
		
	}
	
	function Get_single_booking($booking_id){
		$this->db->select('
			bm.*, 
			sm.store_id,
			sm.Store_name,
			sm.store_image, 
			sm.store_address, 
			sm.store_address_2
		');
		$this->db->from('booking_master as bm');
		$this->db->join('Store_master AS sm','sm.store_id = bm.store_id','Left');
		$this->db->where('bm.booking_id', $booking_id);
		return $this->db->get()->row();
	}
	
	
	
	function book_service($post){
		
		//get user cart
		$this->db->select('*');
		$this->db->from('Cart_master');
		$this->db->where('user_id', $post['user_id']);
		$this->db->where('cart_id', $post['cart_id']);
		$cart_data = $this->db->get()->row();
		
		if($cart_data->coupon_id != NULL){
			$booking['coupon_id'] = $cart_data->coupon_id;
			$booking['coupon_code'] = $cart_data->coupon_code;
			$booking['coupon_amount'] = $post['coupon_amount'];
		}
		
		$booking['inspection_charge'] = $post['inspection_charge'];
		$booking['service_charge'] = $post['service_charge'];
		$booking['user_id'] = $post['user_id'];
		$booking['store_id'] = $cart_data->store_id;
		$booking['service_date'] = $cart_data->date;
		$booking['booking_note'] = $cart_data->note;
		$booking['payment_type'] = 1;
		$booking['payment_status'] = 1;
		$booking['service_type'] = $cart_data->address_type;
		$booking['created_at_date'] = date("Y-m-d");
		$booking['created_at_time'] = date("H:i:s");
		$booking['updated_at'] = date("Y-m-d H:i:s");
		
		if($cart_data->address_type == 1){
			$booking['service_by'] = $cart_data->take_by;
			$booking['customer_name'] = $cart_data->customer_name;
			$booking['customer_contact'] = $cart_data->customer_contact;
		}
		
		if($cart_data->address_type == 2){
			$booking['addres_id'] = $cart_data->address_id;
		}
		
		
		$this->db->insert('booking_master',$booking);
		$data['booking_id'] = $this->db->insert_id();
		
		$data['cart_id'] = $cart_data->cart_id;
		$data['store_id'] = $cart_data->store_id;
		
		//delete user Cart
		$this->db->where('cart_id', $cart_data->cart_id);
		$this->db->delete('Cart_master');
		
		return $data;
	}
	
	function set_booking_items($booking_detail, $post){
		
			//get cart items
			$this->db->select('cim.*, spm.packege_sale_price');
			$this->db->from('Cart_item_master as cim');
			$this->db->join('store_Packages_master AS spm','spm.Package_id = cim.item_id','Left');
			$this->db->where('cim.cart_id', $booking_detail['cart_id']);
			$this->db->where('spm.store_id', $booking_detail['store_id']);
			$cart_items = $this->db->get()->result();
			
			foreach($cart_items as $ci){
				$data['booking_id'] = $booking_detail['booking_id'];
				$data['item_id'] = $ci->item_id;
				$data['booking_qty'] = $ci->cart_qty;
				$data['item_amount'] = $ci->packege_sale_price;
				$data['created_at'] = date("Y-m-d H:i:s");
				$this->db->insert('booking_item_master',$data);
			}
		
		//delete user Cart
		$this->db->where('cart_id', $booking_detail['cart_id']);
		$this->db->delete('Cart_item_master');
	}
	
	/**************** Coupons ********************/
	function get_coupon($post){
		$this->db->select('*');
		$this->db->from('Coupons_master');
		$this->db->where('coupon_store_id', $post['store_id']);
		$this->db->where('coupon_code', $post['coupon_code']);
		return $this->db->get()->row();
	}
	
	function get_user_coupon_history($post, $coupon){
		$this->db->select('count(*) as allcount');
		$this->db->from('Coupons_history_master');
		$this->db->where('store_id', $coupon->coupon_store_id);
		$this->db->where('user_id', $post['user_id']);
		$this->db->where('coupon_id', $coupon->coupon_id);
		$result = $this->db->get()->result_array();
		return $result[0]['allcount'];
	}
	
	function set_coupon_in_cart($post, $coupon){
		
		$data['coupon_id'] = $coupon->coupon_id;
		$data['coupon_code'] = $coupon->coupon_code;
		$data['coupon_discount_type'] = $coupon->coupon_discount_type;
		$data['coupon_amount'] = $coupon->coupon_amount;
		$data['coupon_free_shipping'] = $coupon->coupon_free_shipping;
		
		$this->db->where('cart_id', $post['cart_id']);
		$this->db->update('Cart_master',$data);
	}
	
	function remove_coupon_in_cart($cart_id){
		
		$data['coupon_id'] = NULL;
		$data['coupon_code'] = NULL;
		$data['coupon_discount_type'] = NULL;
		$data['coupon_amount'] = NULL;
		$data['coupon_free_shipping'] = NULL;
		
		$this->db->where('cart_id', $cart_id);
		$this->db->update('Cart_master',$data);
	}
	
	/**************** Home ********************/
	function get_main_categories(){
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('parent_category', NULL);
		$this->db->where('category_image !=', '');
		$this->db->where('category_status', 1);
		return $this->db->get()->result();
	}
	
	function get_home_Stores($offset, $limit, $city, $store_type){
		$this->db->select('sm.store_id, sm.Store_name, sm.store_image, sum.type as store_type');
		$this->db->from('Store_master as sm');
		
		//check subscription
		$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
		$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		if($store_type  == 1){
			$this->db->where('sum.type !=', 2);
			$this->db->join('store_product_master AS spm','spm.store_id = sm.store_id');
			$this->db->join('product_master AS pm','pm.product_id = spm.product_id');
			$this->db->where('spm.product_status ', 1);
			$this->db->where('pm.product_status ', 1);
		}else if($store_type  == 2){
			$this->db->where('sum.type !=', 1);
			$this->db->join('store_Packages_master AS spm','spm.store_id = sm.store_id');
			$this->db->join('Packages_master AS pm','pm.Package_id = spm.Package_id');
			$this->db->where('spm.packege_status ', 1);
			$this->db->where('pm.packege_status ', 1);
		}
		
		$this->db->group_by('sm.store_id');
		$this->db->where('sm.city', $city);
		$this->db->limit($limit, $offset); 
		$this->db->where('sm.store_status', 1);
		//$this->db->where('store_type', $store_type);
		//$this->db->or_where_in('store_type', 3);
		return $this->db->get()->result();
	}
	
	function get_home_banner(){
		$this->db->select('*');
		$this->db->from('app_banner_master');
		$this->db->where('image_url !=', NULL);
		$this->db->where('status', 1);
		$this->db->order_by("order", "ASC");
		return $this->db->get()->result();
		
		
	}
	
		/**************** other ********************/
	function get_all_main_categories(){
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('parent_category', NULL);
		$this->db->where('category_type', 1);
		$this->db->where('category_status', 1);
		$this->db->order_by("order", "ASC");
		$data['product'] = $this->db->get()->result();
		
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('parent_category', NULL);
		$this->db->where('category_type', 2);
		$this->db->where('category_status', 1);
		$this->db->order_by("order", "ASC");
		$data['service'] = $this->db->get()->result();
		
		return $data;
	}
	
	function get_faq(){
		$this->db->select('*');
		$this->db->from('faq_master');
		$this->db->where('status', 1);
		return $this->db->get()->result();
	}
	
	function get_eagles(){
		$this->db->select('*');
		$this->db->from('setting_master');
		return $this->db->get()->row();
	}
	
	/**************** Locations ********************/
	function get_cities(){
		$this->db->select('city, state');
		$this->db->from('Store_master');
		$this->db->where('store_status', 1);
		$this->db->group_by('city');
		$this->db->order_by('city', 'asc');
		return $this->db->get()->result();
	}
	
	/**************** Chat ********************/
	
	function get_user_chat_list($user_id){
		$this->db->select('*');
		$this->db->from('Chat_last_msg_master');
		$this->db->where('from', $user_id);
		$this->db->order_by("created_at", "desc");
		
		return $this->db->get()->result();
	}
	
	function get_to_details($to_id){
		$this->db->select('store_image as to_image, Store_name as to_name');
		$this->db->from('Store_master');
		$this->db->where('user_id', $to_id);
		$data =  $this->db->get()->row();
		
		if($store == NULL){
			$this->db->select('user_image as to_image, username as to_name');
			$this->db->from('User_master');
			$this->db->where('user_id', $to_id);
			$data =  $this->db->get()->row();
		}
		return $data;
	}
	
	function get_uset_chat_history($from_id, $to_id, $offset, $limit){
		$this->db->select('*');
		$this->db->from('Chat_master');
		$this->db->where('from', $from_id);
		$this->db->where('to', $to_id);
		$this->db->or_where('from', $to_id);
		$this->db->or_where('to', $from_id);
		$this->db->limit($limit, $offset); 
		$this->db->order_by("created_at", "desc");
		return $this->db->get()->result();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function get_store_timing(){
		$this->db->select('*');
		$this->db->from('store_timing_master');
		$this->db->where('store_id', $this->session->User->store_id);
		return $this->db->get()->result();
	}
	
	function get_time_slots($store_timing_id){
		$this->db->select('*');
		$this->db->from('store_timing_slot_master');
		$this->db->order_by("start_time", "asc");
		$this->db->where('store_timing_id', $store_timing_id);
		return $this->db->get()->result();
	}
	
	function get_set_days(){
		$week = ['Sunday','Saturday','Friday','Thursday','Wednesday','Tuesday','Monday'];
		
		foreach($week as $val){
			
			$data['store_id'] =$this->session->User->store_id;
			$data['day'] = $val;
			$data['created_at'] = date("Y-m-d H:i:s");
			$data['updated_at'] = date("Y-m-d H:i:s");
		
			$this->db->insert('store_timing_master',$data);
		}
	}
	
	function set_time_slot(){
		$data['store_timing_id'] = $_POST['store_timing_id'];
		$data['start_time'] = $_POST['start_time'];
		$data['end_time'] = $_POST['end_time'];
		$data['created_at'] = date("Y-m-d H:i:s");
		$data['updated_at'] = date("Y-m-d H:i:s");
	
		$this->db->insert('store_timing_slot_master',$data);
	}
	
	function set_single_time_slot(){
		$this->db->select('*');
		$this->db->from('store_timing_slot_master');
		$this->db->where('store_timing_slot_id', $_POST['store_timing_slot_id']);
		return $this->db->get()->row();
	}
	
	function update_time_slot(){
		$data['start_time'] = $_POST['start_time'];
		$data['end_time'] = $_POST['end_time'];
		$data['updated_at'] = date("Y-m-d H:i:s");
	
		$this->db->where('store_timing_slot_id', $_POST['store_timing_slot_id']);
		$this->db->update('store_timing_slot_master',$data);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	function get_single_coupon($coupon_id){
		$this->db->select('*');
		$this->db->from('Coupons_master');
		$this->db->where('coupon_store_id', $this->session->User->store_id);
		$this->db->where('coupon_id', $coupon_id);
		return $this->db->get()->row();
	}
	
	function get_coupons_data($rowno,$rowperpage)
	{
		$this->db->select('*');
		$this->db->from('Coupons_master');
		
		if(!empty($_POST['search'])){
			$this->db->like('coupon_name', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('coupon_status', $_POST['status']);
		}
		
		$this->db->limit($rowperpage, $rowno); 
		$this->db->where('coupon_store_id', $this->session->User->store_id);
		return $this->db->get()->result();
	}
	
	public function getrecordCount_coupons() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Coupons_master');
		
		if(!empty($_POST['search'])){
			$this->db->like('coupon_name', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('coupon_status', $_POST['status']);
		}
		
		$this->db->where('coupon_store_id', $this->session->User->store_id);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	  
	function coupon_code_exists(){
		if(isset($_POST['coupon_id']) != NULL){
			$this->db->where('coupon_id !=', $_POST['coupon_id']);
		}
		$this->db->select('*');
		$this->db->from('Coupons_master'); 
		$this->db->where('coupon_code', $_POST['coupon_code']);
		$this->db->where('coupon_store_id', $this->session->User->store_id);
		return $this->db->get()->row();
	}
	  
	function insert_coupon(){
		$data['coupon_store_id'] = $this->session->User->store_id;
		$data['coupon_name'] = $_POST['coupon_name'];
		$data['coupon_code'] = $_POST['coupon_code'];
		$data['coupon_start_date'] = $_POST['coupon_start_date'];
		$data['coupon_end_date'] = $_POST['coupon_end_date'];
		$data['coupon_discount_type'] = $_POST['coupon_discount_type'];
		$data['coupon_amount'] = $_POST['coupon_amount'];
		$data['cart_min_amount'] = $_POST['cart_min_amount'];
		$data['cart_max_amount'] = $_POST['cart_max_amount'];
		if(isset($_POST['coupon_free_shipping'])){
			$data['coupon_free_shipping'] = $_POST['coupon_free_shipping'];
		}
		$data['coupon_per_user'] = $_POST['coupon_per_user'];
		$data['coupon_limit'] = $_POST['coupon_limit'];
		$data['coupon_description'] = $_POST['coupon_description'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		$this->db->insert('Coupons_master',$data);
		return $this->db->insert_id();
		
	}
	
	function update_coupon(){
		$data['coupon_store_id'] = $this->session->User->store_id;
		$data['coupon_name'] = $_POST['coupon_name'];
		$data['coupon_code'] = $_POST['coupon_code'];
		$data['coupon_start_date'] = $_POST['coupon_start_date'];
		$data['coupon_end_date'] = $_POST['coupon_end_date'];
		$data['coupon_discount_type'] = $_POST['coupon_discount_type'];
		$data['coupon_amount'] = $_POST['coupon_amount'];
		$data['cart_min_amount'] = $_POST['cart_min_amount'];
		$data['cart_max_amount'] = $_POST['cart_max_amount'];
		$data['coupon_free_shipping'] = 0;
		if(isset($_POST['coupon_free_shipping'])){
			$data['coupon_free_shipping'] = $_POST['coupon_free_shipping'];
		}
		$data['coupon_per_user'] = $_POST['coupon_per_user'];
		$data['coupon_limit'] = $_POST['coupon_limit'];
		$data['coupon_description'] = $_POST['coupon_description'];
		$data['coupon_status'] = $_POST['coupon_status'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		$this->db->where('coupon_store_id',$this->session->User->store_id);
		$this->db->where('coupon_id',$_POST['coupon_id']);
		$this->db->update('Coupons_master',$data);
		
		
	}
	  
	
	
}
?>