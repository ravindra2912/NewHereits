<?php 
class Mdl_Cart extends CI_Model
{
	function __construct()
	{
		parent::__construct();
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
	
	function get_single_address($address_id){
		$this->db->select('*');
		$this->db->from('address_master');
		$this->db->where('address_id', $address_id);
		return $this->db->get()->row();
	}
	
	function update_cart_qty(){
		if($_POST['type'] == 0){
			$this->db->set('cart_qty', 'cart_qty-1', FALSE); 
		}else if($_POST['type'] == 1){
			$this->db->set('cart_qty', 'cart_qty+1' , FALSE); 
		}
		$this->db->where('cart_item_id', $_POST['cart_item_id']);
		$this->db->update('Cart_item_master');
	}
	
	
	  
	function get_product_single_image($product_id){
		$this->db->select('*');
		$this->db->from('product_image_master');
		$this->db->where('product_id', $product_id);
		$this->db->order_by("image_order", "asc");
		return $this->db->get()->row();
	}
	
	
	
}
?>