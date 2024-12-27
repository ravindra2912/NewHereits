<?php 
class Mdl_Business extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function check_store(){
		$this->db->select('stm.*');
		$this->db->from('Store_master as stm');
		$this->db->join('User_master as sm','sm.user_id = stm.user_id','left');
		$this->db->where('sm.contact', $_POST['mobile_no']);
		return $this->db->get()->row();
	}
	
	function get_user_detail(){
		$this->db->select('*');
		$this->db->from('User_master');
		$this->db->where('contact', $_POST['mobile_no']);
		$std = $this->db->get()->row();
		
		$data['contact_varify'] = 1;
		$this->db->where('user_id', $std->user_id);
		$this->db->update('User_master',$data);
		
		return $std;
	}
	function store_phone_no(){
		$mob['Phone_no'] = $_POST['mobile_no'];
		$mob['created_at'] = date("Y-m-d H:i:s");
		$this->db->insert('Registration_Master',$mob);
	}
	function get_plans($type){
		$this->db->select('*');
		$this->db->where('type', $type);
		$this->db->order_by('order', 'asc');
		$this->db->where('status', 1);
		$this->db->from('subscription_master');
		$sub = $this->db->get()->result();
		
		$data = array();
		foreach($sub as $plans){
			$this->db->select('*');
			$this->db->where('subscription_id', $plans->subscription_id);
			$this->db->order_by('month', 'asc');
			$this->db->from('subscription_plans_master');
			$splans = $this->db->get()->result();
			if($splans != NULL){
				$plans->plans = $splans;
				$data[] = $plans;
			}
		}
		return $data;
	}
	
	function check_referral()
	{
	
		$this->db->select('*');
		$this->db->from('User_master');
		$this->db->where('user_referal', $_POST['referral_code']);
		return $this->db->get()->row();
	}
	
	function store_register(){
		
		//insert user
		$user['user_image'] = $_POST['user_image'];
		$user['frist_name'] = $_POST['frist_name'];
		$user['last_name'] = $_POST['last_name'];
		$user['username'] = $_POST['username'];
		$user['email'] = $_POST['email'];
		$user['contact'] = $_POST['contact'];
		$user['gender'] = $_POST['gender'];
		
		$user['password'] = md5($_POST['password']);
		$user['adhar_card_front_image'] = $_POST['adhar_card_front_image'];
		$user['adhar_card_back_image'] = $_POST['adhar_card_back_image'];
		$user['adhar_card_number'] = $_POST['adhar_card_number'];
		$user['family_name'] = $_POST['family_name'];
		$user['family_relation'] = $_POST['family_relation'];
		$user['family_contact'] = $_POST['family_contact'];
		$user['created_at'] = date("Y-m-d H:i:s");
		$user['updated_at'] = date("Y-m-d H:i:s");
		
		if($_POST['user_id'] != NULL){
			$this->db->where('user_id', $_POST['user_id']);
			$this->db->update('User_master',$user);
			
			$store['user_id'] = $_POST['user_id'];
		}else{
			$this->db->insert('User_master',$user);
			$store['user_id'] = $this->db->insert_id();
		}
		
		$str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$str =substr(str_shuffle($str_result),0, 6);
		$user_refral = $str.$store['user_id'];
		$data1['user_referal'] = $user_refral;
		$this->db->where('user_id',$store['user_id']);
		$this->db->update('User_master',$data1);
		
		$mob['Registration_completed']=1;
		$this->db->update('Registration_Master',$mob);
		
		//insert store
		$store['store_image'] = $_POST['store_image'];
		$store['Store_name'] = $_POST['Store_name'];
		$store['store_email'] = $_POST['store_email'];
		$store['store_contact'] = $_POST['store_contact'];
		$store['description'] = $_POST['description'];
		$store['address_proof_image'] = $_POST['address_proof_image'];
		$store['store_address'] = $_POST['store_address'];
		$store['store_address_2'] = $_POST['store_address_2'];
		$store['latitude'] = $_POST['latitude'];
		$store['longitude'] = $_POST['longitude'];
		$store['city'] = $_POST['city'];
		$store['district'] = $_POST['district'];
		$store['state'] = $_POST['state'];
		$store['country'] = $_POST['country'];
		$store['pincode'] = $_POST['pincode'];
		$store['referral_code'] = $_POST['referral_code'];
		$store['created_at'] = date("Y-m-d H:i:s");
		$store['updated_at'] = date("Y-m-d H:i:s");
		
		$this->db->insert('Store_master',$store);
		$insert_id =  $this->db->insert_id();
		
		$tag['item_id'] = $insert_id;
		$tag['tag'] = $_POST['Store_name'];
		$tag['type'] = 2;
		$this->db->insert('tag_master',$tag);
		
		
		return $insert_id;
	}
	
	function username_exists(){
		$this->db->select('*');
		if($_POST['user_id'] != NULL){
			$this->db->where('user_id !=', $_POST['user_id']);
		}
		$this->db->where('username', $_POST['username']);
		$this->db->from('User_master');
		return $this->db->get()->result();
	}
	
	function user_email_exists(){
		$this->db->select('*');
		if($_POST['user_id'] != NULL){
			$this->db->where('user_id !=', $_POST['user_id']);
		}
		$this->db->where('email', $_POST['email']);
		$this->db->from('User_master');
		return $this->db->get()->result();
	}
	
	function user_contact_exists(){
		$this->db->select('*');
		if($_POST['user_id'] != NULL){
			$this->db->where('user_id !=', $_POST['user_id']);
		}
		$this->db->where('contact', $_POST['contact']);
		$this->db->from('User_master');
		return $this->db->get()->result();
	}
	
	function store_contact_exists(){
		$this->db->select('*');
		$this->db->where('store_contact', $_POST['store_contact']);
		$this->db->from('Store_master');
		return $this->db->get()->result();
	}
	
	function store_email_exists(){
		$this->db->select('*');
		$this->db->where('store_email', $_POST['store_email']);
		$this->db->from('Store_master');
		return $this->db->get()->result();
	}
	
	
	
	

	
	
}
?>