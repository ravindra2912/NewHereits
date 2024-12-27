<?php 
class Mdl_Store_Profile extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_store_info(){
		$this->db->select('*');
		$this->db->from('Store_master');
		$this->db->where('store_id', $this->session->User->store_id);
		return $this->db->get()->row();
	}
	
	function check_adhar(){
		$this->db->select('*');
		$this->db->from('User_master');
		$this->db->where('adhar_card_number',$_POST['adhar_card_number'] );
		return $this->db->get()->row();
	}
	
	function user_data(){
		$this->db->select('sm.user_id , um.*');
		$this->db->from('Store_master sm');
		$this->db->join('User_master AS um','um.user_id = sm.user_id','Left');
		$this->db->where('sm.store_id', $this->session->User->store_id);
		return $this->db->get()->row();
	}
	function update_user(){
	
		$this->db->select('*');
		$this->db->from('Store_master');
		$this->db->where('store_id',$this->session->User->store_id);
		$status = $this->db->get()->row();
		if($status->store_status == 2){
			$store['store_status'] = 0;
			$this->db->where('store_id',$this->session->User->store_id);
			$this->db->update('Store_master',$store);
		}
		
		if($_POST['frist_name']){
			$data['frist_name']=$_POST['frist_name'];
		}
		if($_POST['last_name']){
			$data['last_name']=$_POST['last_name'];
		}
		if($_POST['username']){
			$data['username']=$_POST['username'];
		}
		if($_POST['email']){
			$data['email']=$_POST['email'];
		}
		if($_POST['contact']){
			$data['contact']=$_POST['contact'];
		}
		if($_POST['gender']){
			$data['gender']=$_POST['gender'];
		}
		if($_POST['adhar_card_number']){
			$data['adhar_card_number']=$_POST['adhar_card_number'];
		}
		
		
		$data['family_contact']=$_POST['family_contact'];
		$data['family_relation']=$_POST['family_relation'];
		$data['family_name']=$_POST['family_name'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		if($_POST['user_image']){
			$data['user_image']= $_POST['user_image'];
		}
		if($_POST['adhar_card_front_image']){
			$data['adhar_card_front_image']= $_POST['adhar_card_front_image'];
		}
		if($_POST['adhar_card_back_image']){
			$data['adhar_card_back_image']= $_POST['adhar_card_back_image'];
		}
				
		if($_POST['password'] != NULL){
			$data['password'] = md5($_POST['password']);
		}
		
		$this->db->where('user_id',$_POST['user_id']);
		$this->db->update('User_master',$data);
	}
	
	
	public function get_Follow_list_count() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Follow_master');
		$this->db->where('stor_id', $this->session->User->store_id);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	  
	function update_store(){
		//update store
		$this->db->select('*');
		$this->db->from('Store_master');
		$this->db->where('store_id',$this->session->User->store_id);
		$status = $this->db->get()->row();
		if($status->store_status == 2){
			$store['store_status'] = 0;
		}	
		$store['Store_name'] = $_POST['Store_name'];
		$store['store_email'] = $_POST['store_email'];
		$store['store_contact'] = $_POST['store_contact'];
		//$store['store_status'] = $_POST['store_status'];
		$store['description'] = $_POST['description'];
		//$store['facebook'] = $_POST['facebook'];
		//$store['instagram'] = $_POST['instagram'];
		$store['store_address'] = $_POST['store_address'];
		$store['store_address_2'] = $_POST['store_address_2'];
		$store['latitude'] = $_POST['latitude'];
		$store['longitude'] = $_POST['longitude'];
		$store['city'] = $_POST['city'];
		$store['district'] = $_POST['district'];
		$store['state'] = $_POST['state'];
		$store['country'] = $_POST['country'];
		$store['pincode'] = $_POST['pincode'];
		$store['updated_at'] = date("Y-m-d H:i:s");
		
		if(isset($_POST['store_image']) != NULL){
			$store['store_image'] = $_POST['store_image'];
		}
		
		if(isset($_POST['address_proof_image']) != NULL){
			$store['address_proof_image'] = $_POST['address_proof_image'];
		}
		
		if(isset($_POST['pancard_image']) != NULL){
			$store['pancard_image'] = $_POST['pancard_image'];
			$store['pancard_number'] = $_POST['pancard_number'];
		}
		
		if(isset($_POST['gst_image']) != NULL){
			$store['gst_image'] = $_POST['gst_image'];
			$store['gst_number'] = $_POST['gst_number'];
		}
		
		
		$this->db->where('store_id',$this->session->User->store_id);
		$this->db->update('Store_master',$store);
		
		if(isset($_POST['tags']) != NULL ){
			$this->db->where('item_id',$this->session->User->store_id);
			$this->db->where('type',2);
			$this->db->delete('tag_master');
			$tags = explode(",", $_POST['tags']);
			
			foreach($tags as $val)
			{
				$data2['item_id'] = $this->session->User->store_id;
				$data2['tag'] = $val;
				$data2['type'] = 2;
				$data2['created_at'] = date("Y-m-d H:i:s");
				$this->db->insert('tag_master',$data2);
			}
		}
	}
	
		
	function get_store_timing(){
		$this->db->select('*');
		$this->db->from('store_timing_master');
		$this->db->where('store_id', $this->session->User->store_id);
		return $this->db->get()->result();
	}
	
	function get_refered_user($user_referal){
		$this->db->select('*');
		$this->db->from('User_master');
		$this->db->where('user_referal', $user_referal);
		return $this->db->get()->row();
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
	
	function get_tag(){
		$this->db->select('*');
		$this->db->from('tag_master');
		return $this->db->get()->result();
	}
	function get_tags(){
		$this->db->select('*');
		$this->db->from('tag_master');
		$this->db->where('item_id',$this->session->User->store_id);
		$this->db->where('type',2);
		return $this->db->get()->result();
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