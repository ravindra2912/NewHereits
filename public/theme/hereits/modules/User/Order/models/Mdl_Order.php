<?php 
class Mdl_Order extends CI_Model
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
	
	function get_addresses(){
		$this->db->select('*');
		$this->db->from('address_master');
		$this->db->where('user_id', $this->session->User->user_id);
		return $this->db->get()->result();
	}
	
	function get_coupons($store_id){
		$this->db->select('*');
		$this->db->from('Coupons_master');
		$this->db->where('coupon_store_id', $store_id);
		$this->db->where('coupon_hide', 0);
		return $this->db->get()->result();
	}
	
	function get_single_coupon($store_id){
		$this->db->select('*');
		$this->db->from('Coupons_master');
		$this->db->where('coupon_store_id', $store_id);
		$this->db->where('coupon_code', $_POST['coupon_code']);
		return $this->db->get()->row();
	}
	
	function set_coupon_in_cart($cart_id, $coupon){
		
		$data['coupon_id'] = $coupon->coupon_id;
		$data['coupon_code'] = $coupon->coupon_code;
		$data['coupon_discount_type'] = $coupon->coupon_discount_type;
		$data['coupon_amount'] = $coupon->coupon_amount;
		$data['coupon_free_shipping'] = $coupon->coupon_free_shipping;
		
		$this->db->where('cart_id', $cart_id);
		$this->db->update('Cart_master',$data);
	}
	
	function get_user_coupon_history($post, $coupon){
		$this->db->select('count(*) as allcount');
		$this->db->from('Coupons_history_master');
		$this->db->where('store_id', $coupon->coupon_store_id);
		$this->db->where('user_id', $this->session->User->user_id);
		$this->db->where('coupon_id', $coupon->coupon_id);
		$result = $this->db->get()->result_array();
		return $result[0]['allcount'];
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
	  
	function get_product_single_image($product_id){
		$this->db->select('*');
		$this->db->from('product_image_master');
		$this->db->where('product_id', $product_id);
		$this->db->order_by("image_order", "asc");
		return $this->db->get()->row();
	}
	
	function place_to_order($cart_data){
		
		
		//coupons amount
		if($cart_data->coupon_id != NULL && $cart_data->coupon_id != 0){
			$order['coupon_id'] = $cart_data->coupon_id;
			$order['coupon_code'] = $cart_data->coupon_code;
			
			$Subtotal = 0;
			foreach($cart_data->cart_items as $val){
				$Subtotal += $val->product_sele_price * $val->cart_qty;
			}
			
			$coupon_amount = 0;
			if($cart_data->coupon_discount_type == 1){ //Amount
				
				if($cart_data->coupon_amount >= $Subtotal){
					$coupon_amount = $Subtotal;
					$Subtotal =0;
				}else{
					$coupon_amount = $cart_data->coupon_amount;
				}
			} else if($cart_data->coupon_discount_type == 2){//persontage
			
				if(($Subtotal * $cart_data->coupon_amount)/ 100 >= $Subtotal){
					$coupon_amount = $Subtotal;
					$Subtotal =0;
				}else{
					$coupon_amount = ($Subtotal * $cart_data->coupon_amount)/ 100;
				}
			}
			
			$order['coupon_amount'] = $coupon_amount;
		}
		
		$order['user_id'] = $this->session->User->user_id;
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
			$order['shipping_charge'] = $cart_data->shipping_charge;
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
	
	function place_order_items($order_detail){
		
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
	
	
	
}
?>