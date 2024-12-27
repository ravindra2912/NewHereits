<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Cart');
		$this->load->model('Mdl_common');
		$this->load->library("pagination");
		
		if($this->session->User == null)
		{redirect('Home');}
		
	}
	Public function index()
	{  
		$header_import = '';
		$footer_import = '';
		$data =array(
			'main_content'=>'Product_cart',
			'SCO'=>'', 
			'header_import'=>$header_import, 
			'footer_import'=>$footer_import, 
		);
		$this->load->view('front_template/template',$data);
		
	}
	
	Public function Booking_cart()
	{  
		$header_import = '';
		$footer_import = '';
		$data =array(
			'main_content'=>'Booking_cart',
			'SCO'=>'', 
			'header_import'=>$header_import, 
			'footer_import'=>$footer_import, 
		);
		$this->load->view('front_template/template',$data);
		
	}
	
	//for product cart
	function get_user_cart(){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		
		
		$user_cart = $this->Mdl_Cart->get_cart(1);
		if($user_cart != NULL){
			$user_cart->cart_items = $this->Mdl_Cart->get_cart_all_item($user_cart->cart_id, $user_cart->store_id,1);
			$user_cart->address = $this->Mdl_Cart->get_single_address($user_cart->address_id);
			foreach($user_cart->cart_items as $img){
				 $img->product_images = $this->Mdl_Cart->get_product_single_image($img->item_id)->image_url;
			}
			
			if($user_cart->cart_items == NULL){
				$this->db->where('cart_id', $user_cart->cart_id);
				$this->db->delete('Cart_master');
				$array=array('status'=>0,'Message'=>'Cart Is Empty','data'=>$cart);
			}else{
				$cart['cart'] = '';
				$cart['total_item'] = 0;
				$cart['Subtotal'] = 0;
				$cart['Shipping'] = 0;
				$cart['Discount'] = 'Discount <span class="float-right text-4 font-weight-500 text-dark" id="Discount">Rs.0</span>';
				$cart['totalAmount'] = 0;
				foreach($user_cart->cart_items as $val){
					//service image
					$img = base_url().'assets/admin/images/no-image.png';
					if(file_exists($val->product_images)) { $img = base_url().$val->product_images; }
					$cart['cart'] .='
							<tr>
							  <td class="align-middle text-center"><img src="'.$img.'" class="img-thumbnail cart_img d-inline-flex mr-1"></td>
							  <td > 
								<span class="text-3 d-inline-flex">'.$val->product_name.'</span>
								<p class="mb-2">  
									<span class="text-black-50 store-name"><i class="fas fa-store"></i> '.$val->Store_name.'</span> 
								</p>
								<div class="bg-primary cart-counter mt-3">
									<button class="CounterButton" onclick="update_qty(0,'.$val->cart_item_id.')" id="btn_decrement-'.$val->cart_item_id.'"'; if($val->cart_qty == 1){$cart['cart'] .='disabled';} $cart['cart'] .='>-</button>
									<span class="CounterValue" id="CounterValue-'.$val->cart_item_id.'">'.$val->cart_qty.'</span>
									<button class="CounterButton" onclick="update_qty(1,'.$val->cart_item_id.')" id="increment-'.$val->cart_item_id.'"'; if($val->cart_qty == $val->product_qty){$cart['cart'] .='disabled';} $cart['cart'] .='>+</button>
								</div>
							</td>
							  <td class="align-middle text-right">Rs. '.$val->product_sele_price * $val->cart_qty.'</td>
							  <td class="align-middle text-center "><a href="#" data-toggle="tooltip" onclick="remove_cart_items('.$val->cart_item_id.')" data-original-title="Delete"><i class="fas fa-trash-alt text-danger"></i></a></td>
							</tr>
					';
					$cart['Subtotal'] += $val->product_sele_price * $val->cart_qty;
					$cart['total_item'] ++;
				}
				$cart['totalAmount'] = $cart['Subtotal'];
				if($user_cart->coupon_id != Null && $user_cart->coupon_id != 0){
					if($user_cart->coupon_discount_type == 1){ //Amount
						$cart['totalAmount'] = $cart['Subtotal'] - $user_cart->coupon_amount;
						$cart['Discount'] = 'Discount('.$user_cart->coupon_code.') <span class="far fa-times-circle text-danger text-4 p-1" ></span><span class="float-right text-4 font-weight-500 text-dark" id="Discount">Rs. '.$user_cart->coupon_amount.'</span>';
					} else if($user_cart->coupon_discount_type == 2){//persontage
						$cart['totalAmount'] = ($cart['Subtotal'] * $user_cart->coupon_amount)/ 100;
						$cart['Discount'] = 'Discount('.$user_cart->coupon_code.') <span class="far fa-times-circle text-danger text-4 p-1" ></span><span class="float-right text-4 font-weight-500 text-dark" id="Discount">Rs. '.(($cart['Subtotal'] * $user_cart->coupon_amount)/ 100).'</span>';

					}
					
				}
				$array=array('status'=>1,'Message'=>'SuccessFully','data'=>$cart);
			}
			
		}else{
			$array=array('status'=>0,'Message'=>'Cart Is Empty','data'=>$cart);
		}
		
		
		
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	//for service cart
	function get_user_booking_cart(){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		
		
		$user_cart = $this->Mdl_Cart->get_cart(2);
		if($user_cart != NULL){
			$user_cart->cart_items = $this->Mdl_Cart->get_cart_all_item($user_cart->cart_id, $user_cart->store_id,2);
			$user_cart->address = $this->Mdl_Cart->get_single_address($user_cart->address_id);
			
			
			if($user_cart->cart_items == NULL){
				$this->db->where('cart_id', $user_cart->cart_id);
				$this->db->delete('Cart_master');
				$array=array('status'=>0,'Message'=>'Cart Is Empty','data'=>$cart);
			}else{
				$cart['cart'] = '';
				$cart['total_item'] = 0;
				$cart['Subtotal'] = 0;
				$cart['Shipping'] = 0;
				$cart['Discount'] = 'Discount <span class="float-right text-4 font-weight-500 text-dark" id="Discount">Rs.0</span>';
				$cart['totalAmount'] = 0;
				foreach($user_cart->cart_items as $val){
					//service image
					$img = base_url().'assets/admin/images/no-image.png';
					if(file_exists($val->packege_image)) { $img = base_url().$val->packege_image; }
					$cart['cart'] .='
							<tr>
							  <td class="align-middle text-center"><img src="'.$img.'" class="img-thumbnail cart_img d-inline-flex mr-1"></td>
							  <td > 
								<span class="text-3 d-inline-flex">'.$val->Package_name.'</span>
								<p class="mb-2">  
									<span class="text-black-50 store-name"><i class="fas fa-store"></i> '.$val->Store_name.'</span> 
								</p>
							</td>
							  <td class="align-middle text-right">Rs. '.$val->packege_sale_price * $val->cart_qty.'</td>
							  <td class="align-middle text-center "><a href="#" data-toggle="tooltip" onclick="remove_cart_items('.$val->cart_item_id.')" data-original-title="Delete"><i class="fas fa-trash-alt text-danger"></i></a></td>
							</tr>
					';
					$cart['Subtotal'] += $val->packege_sale_price * $val->cart_qty;
					$cart['total_item'] ++;
				}
				$cart['totalAmount'] = $cart['Subtotal'];
				if($user_cart->coupon_id != Null && $user_cart->coupon_id != 0){
					if($user_cart->coupon_discount_type == 1){ //Amount
						$cart['totalAmount'] = $cart['Subtotal'] - $user_cart->coupon_amount;
						$cart['Discount'] = 'Discount('.$user_cart->coupon_code.') <span class="far fa-times-circle text-danger text-4 p-1" ></span><span class="float-right text-4 font-weight-500 text-dark" id="Discount">Rs. '.$user_cart->coupon_amount.'</span>';
					} else if($user_cart->coupon_discount_type == 2){//persontage
						$cart['totalAmount'] = ($cart['Subtotal'] * $user_cart->coupon_amount)/ 100;
						$cart['Discount'] = 'Discount('.$user_cart->coupon_code.') <span class="far fa-times-circle text-danger text-4 p-1" ></span><span class="float-right text-4 font-weight-500 text-dark" id="Discount">Rs. '.(($cart['Subtotal'] * $user_cart->coupon_amount)/ 100).'</span>';

					}
					
				}
				$array=array('status'=>1,'Message'=>'SuccessFully','data'=>$cart);
			}
			
		}else{
			$array=array('status'=>0,'Message'=>'Cart Is Empty','data'=>$cart);
		}
		
		
		
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function update_cart_qty(){
		$this->Mdl_Cart->update_cart_qty();
	}
	
	function remove_cart_item(){
		
		//delete data
		$this->db->where('cart_item_id', $_POST['cart_item_id']);
		$this->db->delete('Cart_item_master');
		die;
	}
	
	
	
	
}
?>
