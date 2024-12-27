<?php 
class Mdl_product extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function ajax_get_products($offset = null,$limit = null)
	{
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
		
		if($_POST['category'] != ''){
			$this->db->where('pm.product_parent_category', $_POST['category']);
		}
		
		if($_POST['search'] != ''){
			$this->db->join('tag_master as tm', 'tm.item_id = spm.product_id','left');
			$this->db->like('tm.tag ', $_POST['search'] );
			$this->db->where('tm.teg_type ', 1);
			$this->db->where('tm.type ', 1);
		}
		
		$this->db->group_by('spm.product_slug');
		if($offset != null && $limit != null){
			$this->db->limit($limit, $offset); 
		}
		
		$this->db->where('spm.product_status', 1);
		$this->db->where('pm.product_status', 1);
		$this->db->where('sm.store_status', 1);
		$this->db->where('sm.city', $_COOKIE['city']);
		
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
	
	
	  
	function get_product_single_image($product_id){
		$this->db->select('*');
		$this->db->from('product_image_master');
		$this->db->where('product_id', $product_id);
		$this->db->order_by("image_order", "asc");
		return $this->db->get()->row();
	}
	
	function get_single_products($product_slug){
		$this->db->select('pm.product_name, pm.product_parent_category, spm.*, sm.Store_name, sm.store_contact, sm.store_slug, sm.store_id, cm.category_name');
		
		$this->db->from('store_product_master as spm');
		//$this->db->where('spm.store_id', $store_id);
		$this->db->where('spm.product_slug', $product_slug);
		$this->db->join('product_master AS pm','pm.product_id = spm.product_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
		$this->db->join('category_master AS cm','cm.category_id = pm.product_parent_category','Left');
		
		
		return $this->db->get()->row();
	}
	
	function get_product_imgs($pid){
		$this->db->select('*');
		$this->db->from('product_image_master');
		$this->db->where('product_id', $pid);
		$this->db->order_by("image_order", "asc");
		return $this->db->get()->result();
	}
	
	function get_related_products($product_id, $cat_id){
		$this->db->select('pm.product_name, pm.product_parent_category, spm.*, sm.Store_name, sm.store_id, cm.category_name');
		
		$this->db->from('store_product_master as spm');
		//$this->db->where('spm.store_id', $store_id);
		$this->db->where('spm.product_id !=', $product_id);
		$this->db->where('pm.product_parent_category', $cat_id);
		$this->db->join('product_master AS pm','pm.product_id = spm.product_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
		$this->db->join('category_master AS cm','cm.category_id = pm.product_parent_category','Left');
		
		//check subscription
		$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
		$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		
		$this->db->where('spm.product_status', 1);
		$this->db->where('pm.product_status', 1);
		$this->db->where('sm.store_status', 1);
		
		
		$this->db->order_by('rand()');
		$this->db->limit(4);
		
		
		return $this->db->get()->result();
	}
	
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
}
?>