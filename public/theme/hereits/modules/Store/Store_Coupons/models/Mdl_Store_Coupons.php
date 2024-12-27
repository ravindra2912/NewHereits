<?php 
class Mdl_Store_Coupons extends CI_Model
{
	function __construct()
	{
		parent::__construct();
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
		if ( $_POST['coupon_discount_type'] == 1){
			$data['coupon_amount'] = $_POST['coupon_amount'];
		}elseif ( $_POST['coupon_discount_type'] == 2){
			$data['coupon_amount'] = $_POST['coupon_percentage'];
		}
		$data['cart_min_amount'] = $_POST['cart_min_amount'];
		$data['cart_max_amount'] = $_POST['cart_max_amount'];
		if(isset($_POST['coupon_free_shipping'])){
			$data['coupon_free_shipping'] = $_POST['coupon_free_shipping'];
		}
		$data['coupon_per_user'] = $_POST['coupon_per_user'];
		$data['coupon_hide'] = $_POST['coupon_hide'];
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
		if ( $_POST['coupon_discount_type'] == 1){
			$data['coupon_amount'] = $_POST['coupon_amount'];
		}elseif ( $_POST['coupon_discount_type'] == 2){
			$data['coupon_amount'] = $_POST['coupon_percentage'];
		}
		$data['cart_min_amount'] = $_POST['cart_min_amount'];
		$data['cart_max_amount'] = $_POST['cart_max_amount'];
		$data['coupon_free_shipping'] = 0;
		if(isset($_POST['coupon_free_shipping'])){
			$data['coupon_free_shipping'] = $_POST['coupon_free_shipping'];
		}
		$data['coupon_per_user'] = $_POST['coupon_per_user'];
		$data['coupon_hide'] = $_POST['coupon_hide'];
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