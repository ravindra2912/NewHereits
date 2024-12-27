<?php 
class Mdl_Store extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function ajax_get_stores($offset,$limit)
	{
		$this->db->select('sm.*');
		$this->db->from('Store_master as sm');
		
		//sort product
		if($_POST['sort_by'] == 1){
			//Popularity
		}else if($_POST['sort_by'] == 2){
			//Location
		}else if($_POST['sort_by'] == 3){
			//Newest First
			$this->db->order_by("sm.created_at", "DESC");
		}else if($_POST['sort_by'] == 4){
			//Rating
		}
		
		
	//	if($category  != ''){
	//		$this->db->join('Store_category_master AS scm','scm.store_id = sm.store_id', 'Left');
	//		$this->db->where('scm.category_id', $category);
	//	}
		
		//check subscription
		$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
		$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		//if($store_type  == 1){
		//	$this->db->where('sum.type !=', 2);
		//	$this->db->join('store_product_master AS spm','spm.store_id = sm.store_id');
		//	$this->db->join('product_master AS pm','pm.product_id = spm.product_id');
		//	$this->db->where('spm.product_status ', 1);
		//	$this->db->where('pm.product_status ', 1);
		//}else if($store_type  == 2){
		//	$this->db->where('sum.type !=', 1);
		//	$this->db->join('store_Packages_master AS spm','spm.store_id = sm.store_id');
		//	$this->db->join('Packages_master AS pm','pm.Package_id = spm.Package_id');
		//	$this->db->where('spm.packege_status ', 1);
		//	$this->db->where('pm.packege_status ', 1);
		//}
		
		$this->db->group_by('sm.store_id');
		$this->db->where('sm.city', $_COOKIE['city']);
		$this->db->limit($limit, $offset); 
		$this->db->where('sm.store_status', 1);
		//$this->db->where('store_type', $store_type);
		//$this->db->or_where_in('store_type', 3);
		return $this->db->get()->result();
	}
	
	public function getrecordCount_ajax_stores() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Store_master as sm');
		
		
		$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
		$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		$this->db->where('sm.store_status', 1);
		$this->db->where('sm.city', $_COOKIE['city']);
		
		
		
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	  
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
	
	function check_fevourit($item_id, $store_id, $type,$is_store){
		$this->db->select('*');
		$this->db->from('Favourit_item_mster');
		$this->db->where('user_id', $this->session->User->user_id);
		$this->db->where('item_id', $item_id);
		$this->db->where('store_id', $store_id);
		$this->db->where('type', $type);
		$this->db->where('is_store', $is_store);
		return $this->db->get()->row();
	}
	
	//get single store
	function get_single_Store($store_slug){
		$this->db->select('sm.*, sum.type as store_type');
		$this->db->from('Store_master as sm');
		$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
		$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		$this->db->where('sm.store_status', 1);
		$this->db->where('sm.store_slug', $store_slug);
		return $this->db->get()->row();
		
	}
	
	/* =========================== Store gallery ======================*/
	
	function get_albums($store_id){
		$this->db->select('*');
		$this->db->from('album_master');
		$this->db->where('store_id', $store_id);
		$albums = $this->db->get()->result();
		
		foreach($albums as $val){
			$this->db->select('*');
			$this->db->from('album_image_master');
			$this->db->where('album_id', $val->album_id);
			$val->images = $this->db->get()->result();
		}
		return $albums;
	}
	
	
	/* =========================== Store products ======================*/
	
	function ajax_get_products($offset,$limit)
	{
		$this->db->select('pm.product_name, spm.*, sm.Store_name, sm.store_contact, cm.category_name');
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
		$this->db->where('spm.store_id', $_POST['store_id']);
		//$this->db->where('sm.city', $city);
		
		//sort product
		if($_POST['sort_by'] == 1){
			//Popularity
		}else if($_POST['sort_by'] == 2){
			//Location
		}else if($_POST['sort_by'] == 3){
			//Newest First
			$this->db->order_by("pm.created_at", "DESC");
		}else if($_POST['sort_by'] == 4){
			//Rating
		}else if($_POST['sort_by'] == 5){
			//Price: Low to High
			$this->db->order_by("spm.product_sele_price", "asc");
		}else if($_POST['sort_by'] == 6){
			//Price: High to Low
			$this->db->order_by("spm.product_sele_price", "desc");
		}
		return $this->db->get()->result();
	}
	
	public function getrecordCount_ajax_product() 
	{
		$this->db->select('count(*) as allcount');
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
		$this->db->where('spm.store_id', $_POST['store_id']);
		//$this->db->where('sm.city', $city);
		
		
		
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	  
	  function get_product_single_image($product_id){
		$this->db->select('*');
		$this->db->from('product_image_master');
		$this->db->where('product_id', $product_id);
		$this->db->order_by("image_order", "asc");
		return $this->db->get()->row();
	}
	
	/* =========================== Store services ======================*/
	
	function ajax_get_services($offset,$limit)
	{
		$this->db->select('spm.*, pm.Package_name, pm.packege_image, spm.store_id, sm.store_contact, sm.Store_name');
		$this->db->from('store_Packages_master as spm');
		
		
		$this->db->join('Packages_master AS pm','pm.Package_id = spm.Package_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
		
		//check subscription
		$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
		$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		
		
		
		$this->db->limit($limit, $offset); 
		$this->db->where('spm.packege_status', 1);
		$this->db->where('pm.packege_status', 1);
		$this->db->where('sm.store_status', 1);
		$this->db->where('spm.store_id', $_POST['store_id']);
		//$this->db->where('sm.city', $_COOKIE['city']);
		
		//sort product
		if($_POST['sort_by'] == 1){
			//Popularity
		}else if($_POST['sort_by'] == 2){
			//Location
		}else if($_POST['sort_by'] == 3){
			//Newest First
			$this->db->order_by("pm.created_at", "DESC");
		}else if($_POST['sort_by'] == 4){
			//Rating
		}else if($_POST['sort_by'] == 5){
			//Price: Low to High
			$this->db->order_by("spm.packege_sale_price", "asc");
		}else if($_POST['sort_by'] == 6){
			//Price: High to Low
			$this->db->order_by("spm.packege_sale_price", "desc");
		}
		return $this->db->get()->result();
	}
	
	public function getrecordCount_ajax_services() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('store_Packages_master as spm');
		
		
		$this->db->join('Packages_master AS pm','pm.Package_id = spm.Package_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
		
		//check subscription
		$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
		$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		
		
		$this->db->where('spm.packege_status', 1);
		$this->db->where('pm.packege_status', 1);
		$this->db->where('sm.store_status', 1);
		$this->db->where('spm.store_id', $_POST['store_id']);
		//$this->db->where('sm.city', $city);
		
		
		
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	
	/* cart */
	function get_cart($type){
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
		$this->db->where('cm.user_id', $this->session->User->user_id);
		$this->db->where('cm.store_type', $type);
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
	
	function get_cart_item($cart_id,$item_id,$type){
		$this->db->select('*');
		$this->db->from('Cart_item_master');
		$this->db->where('cart_id', $cart_id);
		$this->db->where('item_id', $item_id);
		$this->db->where('type', $type);
		return $this->db->get()->row();
	}
	
	function add_cart_item($cart_id,$item_id,$type){
		$cart['cart_id'] = $cart_id;
		$cart['item_id'] = $item_id;
		$cart['type'] = $type;
	
		$this->db->insert('Cart_item_master',$cart);
		
		return $this->db->insert_id();
	}
	
	function set_cart($item_id, $type, $store_id){
		
		//insert to cart
		$cart['user_id'] = $this->session->User->user_id;
		$cart['store_id'] = $store_id;
		$cart['store_type'] = $type;
		$this->db->insert('Cart_master',$cart);
		$cart_id = $this->db->insert_id();
		 
		return $this->add_cart_item($cart_id,$item_id,$type);
	}
	
	function update_cart_qty($qty_type, $cart_item_id){
		if($qty_type == 0){
			$this->db->set('cart_qty', 'cart_qty-1', FALSE); 
		}else if($qty_type == 1){
			$this->db->set('cart_qty', 'cart_qty+1' , FALSE); 
		}
		$this->db->where('cart_item_id', $cart_item_id);
		$this->db->update('Cart_item_master');
	}
}
?>