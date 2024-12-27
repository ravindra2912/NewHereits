<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Booking');
		$this->load->model('Mdl_emails');
		
		if($this->session->User == null)
		{redirect('Home');}
		
	}
	Public function index()
	{  
		$user_cart = $this->Mdl_Booking->get_cart(2);
		$addresses = $this->Mdl_Booking->get_addresses();
		
		if($user_cart == NULL){
			redirect('Cart');
		}
		
		
		$data =array(
			'main_content'=>'booking_address',
			'SCO'=>'', 
			'user_cart'=>$user_cart, 
			'addresses'=>$addresses, 
		);
		
		$this->load->view('front_template/template',$data);
		
	}
	
	function update_address(){
		$user_cart = $this->Mdl_Booking->get_cart(2);
		$post['date'] = $_POST['date'];
		$post['address_type'] = $_POST['delivery_type'];
		if($_POST['note'] != NULL){
			$post['note'] = $_POST['note'];
		}
		if($_POST['delivery_type'] == 1){
			$post['take_by'] = $_POST['pickup_buy'];
			$post['customer_name'] = $_POST['name'];
			$post['customer_contact'] = $_POST['contact'];
		}else if($_POST['delivery_type'] == 2){
			$post['address_id'] = $_POST['address'];
		}
		

		$this->db->where('cart_id',$user_cart->cart_id);
		$this->db->update('Cart_master',$post);
		
		redirect('Booking/Booking_summary');
	}
	
	
	function Booking_summary(){
		
		$user_cart = $this->Mdl_Booking->get_cart(2);
		$this->Mdl_Booking->remove_coupon_in_cart($user_cart->cart_id);
		
		
		$header_import = '';
		$footer_import = '';
		$data =array(
			'main_content'=>'Booking_summary',
			'SCO'=>'', 
			'header_import'=>$header_import, 
			'footer_import'=>$footer_import, 
		);
		$this->load->view('front_template/template',$data);
	}
	
	function get_user_cart(){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		
		$user_cart = $this->Mdl_Booking->get_cart(2);
		if($user_cart != NULL){
			$user_cart->cart_items = $this->Mdl_Booking->get_cart_all_item($user_cart->cart_id, $user_cart->store_id,2);
			
			
			if($user_cart->cart_items == NULL){
				$this->db->where('cart_id', $user_cart->cart_id);
				$this->db->delete('Cart_master');
				$array=array('status'=>0,'Message'=>'Cart Is Empty','data'=>$cart);
			}else{
				$cart['note'] = $user_cart->note;
				$cart['cart'] = '';
				$cart['total_item'] = 0;
				$cart['Subtotal'] = 0;
				$cart['Shipping'] = 0;
				$cart['Discount'] = 'Discount <span class="float-right text-4 font-weight-500 text-dark" id="Discount">Rs.0</span>';
				$cart['totalAmount'] = 0;
				foreach($user_cart->cart_items as $val){
					//Product image
					$img = base_url().'assets/admin/images/no-image.png';
					if(file_exists($val->packege_image)) { $img = base_url().$val->packege_image; }
					$cart['cart'] .='
							<tr>
							  <td class="align-middle text-center"><img src="'.$img.'" class="img-thumbnail cart_img d-inline-flex mr-1"></td>
							  <td class="align-middle"> 
								<span class="text-3 d-inline-flex">'.$val->Package_name.'</span>
								
							</td>
							  <td class="align-middle text-right">qty : '.$val->cart_qty.'</td>
							  <td class="align-middle text-right">Rs. '.$val->packege_sale_price.'</td>
							</tr>
					';
					$cart['Subtotal'] += $val->packege_sale_price * $val->cart_qty;
					$cart['total_item'] ++;
				}
				
				$cart['totalAmount'] = $cart['Subtotal'];
				
				//coupons
				if($user_cart->coupon_id != Null && $user_cart->coupon_id != 0){
					if($user_cart->coupon_discount_type == 1){ //Amount
						$coupon_amount = 0;
						if($user_cart->coupon_amount >= $cart['Subtotal']){
							$coupon_amount = $cart['Subtotal'];
							$cart['Subtotal'] =0;
						}else{
							$coupon_amount = $user_cart->coupon_amount;
						}
						$cart['totalAmount'] = $cart['Subtotal'] - $coupon_amount;
						$cart['Discount'] = 'Discount('.$user_cart->coupon_code.') <span class="far fa-times-circle text-danger text-4 p-1" onclick="remove_coupon()" ></span><span class="float-right text-4 font-weight-500 text-dark" id="Discount">Rs. '.$coupon_amount.'</span>';
					} else if($user_cart->coupon_discount_type == 2){//persontage
					
						$coupon_amount = 0;
						if(($cart['Subtotal'] * $user_cart->coupon_amount)/ 100 >= $cart['Subtotal']){
							$coupon_amount = $cart['Subtotal'];
							$cart['Subtotal'] =0;
						}else{
							$coupon_amount = ($cart['Subtotal'] * $user_cart->coupon_amount)/ 100;
						}
						
						$cart['totalAmount'] = $cart['Subtotal'] - $coupon_amount;
						$cart['Discount'] = 'Discount('.$user_cart->coupon_code.') <span class="far fa-times-circle text-danger text-4 p-1" onclick="remove_coupon()" ></span><span class="float-right text-4 font-weight-500 text-dark" id="Discount">Rs. '.$coupon_amount.'</span>';

					}
				}
				
				//shipping chage
				if($user_cart->address_type == 2){
					if($cart['Subtotal'] < $user_cart->minimum_service_cart_amount  ){
						$cart['Shipping'] = $user_cart->service_charge;
						$cart['totalAmount'] += $user_cart->service_charge; 
					}
				}
				
				//address
				if($user_cart->address_type == 1){
					$cart['address'] = '
										<h2 id="reviews" class="text-6">Service By</h2>
										<hr class="mx-n3">
										<div id="delivery" class="p-2" >
											<div class="row" >
												<div class="col-12" style="text-align: end;">
													<a href="'.base_url().'Booking"> Change Address</a>
												</div>
												<label class="col-sm-12 col-12 m-1 p-3 address" >
													<p class="address_type bg-info">'; if($user_cart->take_by == 1){ $cart['address'] .= "self"; } else if($user_cart->take_by == 2){ $cart['address'] .= "Other"; } $cart['address'] .='</p>
													<p class="name">'.$user_cart->customer_name .'</p>
													<p>'.$user_cart->customer_contact .'</p>
													<p ><span class="name">Service On :- </span><span>'.$user_cart->date .'</span></p>
												</label>
												 
											</div>
										</div> ';
				}else if($user_cart->address_type == 2){
					$address = $this->Mdl_Booking->get_single_address($user_cart->address_id);
					$cart['address'] = '
										<h2 id="reviews" class="text-6">Service To</h2>
										<hr class="mx-n3">
										<div id="delivery" class="p-2" >
											<div class="row" >
												<div class="col-12" style="text-align: end;">
													<a href="'.base_url().'Booking"> Change Address</a>
												</div>
												<label class="col-sm-12 col-12 m-1 p-3 address" >
													<p class="address_type bg-info">'; if($address->address_type == 1){ $cart['address'] .= "Home"; } else if($address->address_type == 2){ $cart['address'] .= "Office"; } else if($address->address_type == 3){ $cart['address'] .= "Other"; } $cart['address'] .='</p>
													<p class="name">'.$address->name .'</p>
													<p>'.$address->address1.', '.$address->address2 .'</p>
													<p>'.$address->city.', '.$address->state.', '.$address->pincode .'</p>
													<p>'.$address->country .'</p>
													<p>'.$address->contact .'</p>
													<p ><span class="name">Service On :- </span><span>'.$user_cart->date .'</span></p>
												</label>
												 
											</div>
										</div> ';
				}
				
				//Promo Code
					$coupons = $this->Mdl_Booking->get_coupons($user_cart->store_id);
					$cart['coupons'] = '
										<h3 class="text-4 mb-3 mt-4">Promo Code</h3>
										<div class="input-group form-group">
											<input class="form-control" id="coupon_input" placeholder="Promo Code" aria-label="Promo Code" type="text">
											<span class="input-group-append">
												<button class="btn btn-secondary" type="submit" onclick="update_coupon()">APPLY</button>
											</span> 
										</div>
										<div id="coupon_msg"></div>
										<ul class="promo-code pre-scrollable">';
											foreach($coupons as $val){
												$cart['coupons'] .= '<li onclick="app_coupon('.$val->coupon_code.')"><span class="d-block text-3 font-weight-600">'.$val->coupon_name.'</span>'.$val->coupon_description.'. <!-- a class="text-1" href="">Terms &amp; Conditions</a --></li>';
											}
											
										$cart['coupons'] .= '</ul>
					';
				
				$array=array('status'=>1,'Message'=>'SuccessFully','data'=>$cart);
			}
			
		}else{
			$array=array('status'=>0,'Message'=>'Cart Is Empty','data'=>$cart);
		}
		
		
		
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function apply_coupon(){
		$user_cart = $this->Mdl_Booking->get_cart(2);
		//remoce coupons
		$this->Mdl_Booking->remove_coupon_in_cart($user_cart->cart_id);
		
		$user_cart->cart_items = $this->Mdl_Booking->get_cart_all_item($user_cart->cart_id, $user_cart->store_id,1);
		foreach($user_cart->cart_items as $val){
			$cart_amount += $val->product_sele_price * $val->cart_qty;
		}
		
			$coupon = $this->Mdl_Booking->get_single_coupon($user_cart->store_id);
			if($coupon == NULL){
				$array=array('status'=>'0','Message'=>'Coupon Not Exist', 'data'=>$coupon);
			}else{
				$user_coupon = $this->Mdl_Booking->get_user_coupon_history($post, $coupon);
				$coupon->counts = $user_coupon;
				if(date("Y-m-d") >= $coupon->coupon_end_date || date("Y-m-d") < $coupon->coupon_start_date){ // check date
					$array=array('status'=>'0','Message'=>'Coupon Expired!', 'data'=>$coupon);
				}else if($coupon->coupon_per_user > 0 && $user_coupon >= $coupon->coupon_per_user){ // check Coupon limit per user
					$array=array('status'=>'0','Message'=>'Sorry ! Your Max Coupon Limit Is Over!', 'data'=>$coupon);
				}else if($coupon->coupon_limit <= 0){ //check coupon limit
					$array=array('status'=>'0','Message'=>'Sorry ! Coupon Limit Is Over!', 'data'=>$coupon);
				}else if($cart_amount < $coupon->cart_min_amount){ // check coupon minimum amount
					$array=array('status'=>'0','Message'=>'Coupon Is Not Valid On This Amount min!', 'data'=>$coupon);
				}else if($cart_amount > $coupon->cart_max_amount){ // check coupon maximum amount
					$array=array('status'=>'0','Message'=>'Coupon Is Not Valid On This Amount max!', 'data'=>$coupon);
				}else{
					$this->Mdl_Booking->set_coupon_in_cart($user_cart->cart_id, $coupon);
					$array=array('status'=>1,'Message'=>'Coupon Added SuccessFully','data'=>$coupon);
				}
			}
			
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function remove_coupon_in_cart(){
		$user_cart = $this->Mdl_Booking->get_cart(2);
		$this->Mdl_Booking->remove_coupon_in_cart($user_cart->cart_id);
		die;
	}
	
	function place_to_booking(){
		$user_cart = $this->Mdl_Booking->get_cart(2);
		$user_cart->cart_items = $this->Mdl_Booking->get_cart_all_item($user_cart->cart_id, $user_cart->store_id,2);
		
		if($user_cart != NUll){
			//place to booking
			$booking_detail = $this->Mdl_Booking->place_to_booking($user_cart);
			 
			//set booking items 
			$this->Mdl_Booking->place_booking_items($booking_detail);
			
			//email
			$this->Mdl_emails->booking_received_by_store_mail($booking_detail['booking_id']);
		}
		
		redirect('Booking/Booking_Suucess');
	}
	
	function Booking_Suucess(){
		$header_import = '';
		$footer_import = '';
		$data =array(
			'main_content'=>'Booking_Suucess',
		);
		$this->load->view('front_template/template',$data);
	}
	
}
?>
