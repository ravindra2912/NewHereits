<?php
class Mdl_emails extends CI_Model{	function __construct()	{		parent::__construct();     	}

	function store_data($store_id){
		$this->db->select('Store_master.*, User_master.username');
		$this->db->where('Store_master.store_id', $store_id);
		$this->db->join('User_master','User_master.user_id = Store_master.user_id','left');
		$this->db->from('Store_master');
		return $this->db->get()->row();
	}
	
	function order_data($order_id){
		$this->db->select('om.*, um.username, um.email as user_email, sm.Store_name, sm.store_email, shn.username as store_holder');
		$this->db->from('Order_master as om');
		$this->db->where('om.order_id', $order_id);
		$this->db->join('User_master as um','um.user_id = om.user_id','left');
		$this->db->join('Store_master as sm','sm.store_id = om.store_id','left');
		$this->db->join('User_master as shn','shn.user_id = sm.user_id','left');
		$data = $this->db->get()->row();
		
		$this->db->select('om.*, pm.product_name, pim.image_url');
		$this->db->where('om.order_id', $order_id);
		$this->db->from('order_item_mastet as om');
		$this->db->join('product_master as pm','pm.product_id = om.item_id','left');
		$this->db->join('product_image_master as pim','pim.product_id = pm.product_id','left');
		$this->db->group_by('om.item_id');
		$data->order_item = $this->db->get()->result();
		
		return $data;
	}
	
	function booking_data($booking_id){
		$this->db->select('bm.*, um.username, um.email as user_email, sm.Store_name, sm.store_email, shn.username as store_holder');
		$this->db->from('booking_master as bm');
		$this->db->where('bm.booking_id', $booking_id);
		$this->db->join('User_master as um','um.user_id = bm.user_id','left');
		$this->db->join('Store_master as sm','sm.store_id = bm.store_id','left');
		$this->db->join('User_master as shn','shn.user_id = sm.user_id','left');
		$data = $this->db->get()->row();
		
		$this->db->select('bim.*, pm.Package_name, pm.packege_image');
		$this->db->where('bim.booking_id', $booking_id);
		$this->db->from('booking_item_master as bim');
		$this->db->join('Packages_master as pm','pm.Package_id = bim.item_id','left');
		$this->db->group_by('bim.item_id');
		$data->booking_item = $this->db->get()->result();
		
		return $data;
	}
	
	function send_mail($to, $subject, $msg){
		
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: Hereits<noreply@hereits.com>\r\n";
		mail($to,$subject,$msg,$headers);
	}
	
	function user_forgot_email($email){
		$this->db->select('*'); 
		$this->db->where('email', $email); 
		$this->db->from('User_master');
		$user = $this->db->get()->row();
		
		$data['email'] = $email;
		$data['url'] = base_url().'Login/Reset_password/'.$user->user_id;
		$msg = $this->load->view('templates/Forgot_password',$data, TRUE);
		
		$to = $email;
		$subject = "Reset Password";
		$this->send_mail($to, $subject, $msg);
	}
	
	function store_verified_email($store_id){
		$data = $this->store_data($store_id);
		$msg = $this->load->view('templates/store_verified_email',$data, TRUE);
		
		$to = $data->store_email;
		$subject = "congratulations You Store Is Verify";
		$this->send_mail($to, $subject, $msg);
	}
	
	function store_panding_varification_email($store_id){
		$data = $this->store_data($store_id);
		$msg = $this->load->view('templates/store_panding_varification_email',$data, TRUE);
		
		$to = $data->store_email;
		$subject = "your store pending for verification";
		$this->send_mail($to, $subject, $msg);
	}
	
	function store_subscription_buy_email($store_subscription_id){
		
		$this->db->select('ssm.*, um.username, sm.Store_name, sm.store_email, sum.name as plan_name');
		$this->db->from('store_subscription_master as ssm');
		$this->db->join('subscription_master as sum','sum.subscription_id = ssm.subscription_id','left');
		$this->db->join('Store_master as sm','sm.store_id = ssm.store_id','left');
		$this->db->join('User_master as um','um.user_id = sm.user_id','left');
		$this->db->where('ssm.store_subscription_id', $store_subscription_id);
		$data = $this->db->get()->row();
		
		
		
		$msg = $this->load->view('templates/store_subscription_buy_email',$data, TRUE);
		$to = $data->store_email;
		$subject = "Thank You For Your Order";
		$this->send_mail($to, $subject, $msg);
	}
	
	function order_received_by_store_mail($order_id){
		$data = $this->order_data($order_id);
		$msg = $this->load->view('templates/order_received_by_store_mail',$data, TRUE);
		
		$to = $data->store_email;
		$subject = "New order received ";
		$this->send_mail($to, $subject, $msg);
	}
	
	function order_confirm_by_user_mail($order_id){
		$data = $this->order_data($order_id);
		$msg = $this->load->view('templates/order_confirm_by_user_mail',$data, TRUE);
		
		$to = $data->user_email;
		$subject = 'your order  from '.$data->Store_name.' has confirmed';
		$this->send_mail($to, $subject, $msg);
	}
	
	function order_cancel_by_user_mail($order_id){
		$data = $this->order_data($order_id);
		$msg = $this->load->view('templates/order_cancel_by_user_mail',$data, TRUE);
		
		$to = $data->user_email;
		$subject = 'your order Cancel By '.$data->Store_name;
		$this->send_mail($to, $subject, $msg);
	}
	
	function order_cancel_by_store_mail($order_id){
		$data = $this->order_data($order_id);
		$msg = $this->load->view('templates/order_cancel_by_store_mail',$data, TRUE);
		
		$to = $data->store_email;
		$subject = 'order Cancel By '.$data->username;
		$this->send_mail($to, $subject, $msg);
	}
	
	function order_completed_by_user_mail($order_id){
		$data = $this->order_data($order_id);
		$msg = $this->load->view('templates/order_completed_by_user_mail',$data, TRUE);
		
		$to = $data->user_email;
		$subject = "Your order has been delivered.";
		$this->send_mail($to, $subject, $msg);
	}
	
	function booking_received_by_store_mail($booking_id){
		$data = $this->booking_data($booking_id);
		$msg = $this->load->view('templates/booking_received_by_store_mail',$data, TRUE);
		
		$to = $data->store_email;
		$subject = "New Booking received ";
		$this->send_mail($to, $subject, $msg);
	}
	
	function booking_confirm_by_user_mail($booking_id){
		$data = $this->booking_data($booking_id);
		$msg = $this->load->view('templates/booking_confirm_by_user_mail',$data, TRUE);
		
		$to = $data->user_email;
		$subject = 'your Booking  from '.$data->Store_name.' has confirmed';
		$this->send_mail($to, $subject, $msg);
	}
	
	function booking_cancel_by_store_mail($booking_id){
		$data = $this->booking_data($booking_id);
		$msg = $this->load->view('templates/booking_cancel_by_store_mail',$data, TRUE);
		
		$to = $data->store_email;
		$subject = 'Booking Cancel By '.$data->username;
		$this->send_mail($to, $subject, $msg);
	}
	
	function booking_cancel_by_user_mail($booking_id){
		$data = $this->booking_data($booking_id);
		$msg = $this->load->view('templates/booking_cancel_by_user_mail',$data, TRUE);
		
		$to = $data->user_email;
		$subject = 'your Booking Cancel By '.$data->Store_name;
		$this->send_mail($to, $subject, $msg);
	}
	
	function booking_completed_by_user_mail($booking_id){
		$data = $this->booking_data($booking_id);
		$msg = $this->load->view('templates/booking_completed_by_user_mail',$data, TRUE);
		
		$to = $data->user_email;
		$subject = "Your Booking has been completed.";
		$this->send_mail($to, $subject, $msg);
	}
	
	
}?>