<?php 
class Mdl_Store_management extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	/********************* Parent category *********************/
	
	function get_store_data($rowno,$rowperpage)
	{
		$this->db->select('sm.* , um.user_id,um.username	,');
		$this->db->from('Store_master as sm');
				
		if(!empty($_POST['search'])){
			$this->db->like('Store_name', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('store_status', $_POST['status']);
		}
		if($_POST['type'] != ''){
			$this->db->where('store_type', $_POST['type']);
		}
		
		
		$this->db->join('User_master AS um','um.user_id = sm.user_id','Left');
		$this->db->limit($rowperpage, $rowno); 
		$this->db->order_by("created_at", "desc");
		return $this->db->get()->result();
	}
	
	public function getrecordCount_store() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Store_master');
		
		if(!empty($_POST['search'])){
			$this->db->like('Store_name', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('store_status', $_POST['status']);
		}
		
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
  
	function get_product_data($rowno2,$rowperpage2)
	{
		$this->db->select('spm.*,pm.product_name as p_name,pm.product_parent_category ,pm.product_status as p_status');
		$this->db->from('store_product_master as spm');
		$this->db->join('product_master AS pm','pm.product_id = spm.product_id','Left');
		$this->db->limit($rowperpage2, $rowno2); 
		$this->db->order_by("created_at", "desc");
		$this->db->where('spm.store_id',$_POST['store_id']);
		return $this->db->get()->result();
	}
	
	public function getrecordCount_product() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('store_product_master');
		$this->db->where('store_id',$_POST['store_id']);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	
	
	public function get_Count_product($store_id) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('store_product_master');
		$this->db->where('store_id',$store_id);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	public function getlive_product_count($store_id) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('store_product_master');
		$this->db->where('store_id',$store_id);
		$this->db->where('product_status',1);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}

	public function getapproved_product_count($store_id) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('product_master');
		$this->db->where('request_store_id',$store_id);
		$this->db->where('product_status',1);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}	
	public function getpending_product_count($store_id) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('product_master');
		$this->db->where('request_store_id',$store_id);
		$this->db->where('product_status',0);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}	
	
	public function get_Count_package($store_id) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('store_Packages_master');
		$this->db->where('store_id',$store_id);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	public function getlive_package_count($store_id) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('store_Packages_master');
		$this->db->where('store_id',$store_id);
		$this->db->where('packege_status',1);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}

	public function getapproved_package_count($store_id) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Packages_master');
		$this->db->where('request_store_id',$store_id);
		$this->db->where('packege_status',1);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	public function getpending_package_count($store_id) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Packages_master');
		$this->db->where('request_store_id',$store_id);
		$this->db->where('packege_status',0);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	function parent_category($id){
		$this->db->select('category_id , category_name');
		$this->db->from('category_master');		
		$this->db->where('category_id', $id);
		$this->db->where('category_type', 1);
		return $this->db->get()->row();
	}
	function request_store_id($id){
		$this->db->select('Store_name');
		$this->db->from('Store_master');		
		$this->db->where('store_id', $id);
		return $this->db->get()->row();
	}
	
	function get_reffered_user($referal){
		$this->db->select('*');
		$this->db->from('User_master');		
		$this->db->where('user_referal', $referal);
		return $this->db->get()->row();
	}
	
	function product_img($id){
		$this->db->select('*');
		$this->db->from('product_image_master');
		$this->db->where('product_id',$id);
		return $this->db->get()->row();
	}
	
	function get_package_data($rowno3,$rowperpage3)
	{
		$this->db->select('spm.* ,pm.Package_name,pm.main_category,pm.packege_status as p_status ,pm.packege_image');
		$this->db->from('store_Packages_master as spm');
		$this->db->join('Packages_master AS pm','pm.Package_id = spm.Package_id','Left');
		$this->db->limit($rowperpage3, $rowno3); 
		$this->db->order_by("created_at", "desc");
		$this->db->where('spm.store_id',$_POST['store_id']);
		return $this->db->get()->result();
	}
	
	function get_single_product_data($id){
	
		$this->db->select('spm.*,pm.product_name,pim.image_url');
		$this->db->from('store_product_master as spm');
		$this->db->join('product_master pm','pm.product_id = spm.product_id','Left');
		$this->db->join('product_image_master pim','pim.product_id = spm.product_id','Left');
		$this->db->where('spm.store_id',$_POST['store_id']);
		$this->db->where('spm.product_id',$id);
		return $this->db->get()->row();
	} 
	function update_sinle_store_product(){

		$data['product_price'] = $_POST['product_price'];
		$data['product_sele_price'] = $_POST['product_sele_price'];
		$data['product_qty'] = $_POST['product_qty'];
		$data['selling_unit'] = $_POST['selling_unit'];
		$data['selling_unit_qty'] = $_POST['selling_unit_qty'];
		$data['product_description'] = $_POST['product_description'];
		$data['brand_name'] = $_POST['brand_name'];
		$data['product_status'] = $_POST['product_status'];
		
		$data['updated_at'] = date("Y-m-d H:i:s");
		$this->db->where('store_id',$_POST['store_id']);
		$this->db->where('product_id',$_POST['product_id']);
		$this->db->update('store_product_master',$data);
	}
	
	function get_single_package_data($id){
	
		$this->db->select('spm.*,pm.Package_name,pm.packege_image');
		$this->db->from('store_Packages_master as spm');
		$this->db->join('Packages_master pm','pm.Package_id = spm.Package_id','Left');
		$this->db->where('spm.store_id',$_POST['store_id']);
		$this->db->where('spm.Package_id',$id);
		return $this->db->get()->row();
	} 
	function update_sinle_store_package(){
		
		$data['packege_price'] = $_POST['packege_price'];
		$data['packege_sale_price'] = $_POST['packege_sale_price'];
		$data['packege_status'] = $_POST['packege_status'];
		$data['packege_description'] = $_POST['packege_description'];
		$data['packege_excludes'] = $_POST['packege_excludes'];
		$data['packege_includes'] = $_POST['packege_includes'];
		$data['packege_duration'] = $_POST['packege_duration'];
		
		$data['updated_at'] = date("Y-m-d H:i:s");
		$this->db->where('store_id',$_POST['store_id']);
		$this->db->where('Package_id',$_POST['Package_id']);
		$this->db->update('store_Packages_master',$data);
	}
	public function getrecordCount_package() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Packages_master');
		if($_POST['datepicker'] != ''){
			$this->db->where('created_at>=', $_POST['datepicker']);
		}
		if($_POST['enddatepicker'] != ''){
		$this->db->where('created_at<=', $_POST['enddatepicker']);
		}
		$this->db->where('packege_status',0);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	
	function package_category($id){
		$this->db->select('category_id , category_name');
		$this->db->from('category_master');		
		$this->db->where('category_id', $id);
		$this->db->where('category_type', 2);
		return $this->db->get()->row();
	}
	
	function get_single_store_data($store_id){
		$this->db->select('*');
		$this->db->from('Store_master');
		$this->db->where('store_id', $store_id);
		return $this->db->get()->row();
	}
	function user_data($store_id){
		$this->db->select('store.store_id , store.user_id ,user.*');
		$this->db->from('Store_master as store');
		$this->db->join('User_master AS user','user.`user_id` = store.`user_id`','Left');
		$this->db->where('store.store_id', $store_id);
		return $this->db->get()->row();
	}
	
	function get_Subscription_data($store_id){
		$this->db->select('ssm.* , sm.name, sm.type');
		$this->db->from('store_subscription_master as ssm');
		$this->db->join('subscription_master AS sm','sm.subscription_id = ssm.subscription_id','Left');
		$this->db->where('store_id', $store_id);
		return $this->db->get()->row();
	}
	
	function getorder_count($store_id) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Order_master');
		$this->db->where('store_id',$store_id);		
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	  
	function getreport_count($store_id) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Report_abuse_master');
		$this->db->where('is_store',1);		
		$this->db->where('item_id',$store_id);	
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	  
	public function getbooking_count($store_id) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('booking_master');
		$this->db->where('store_id',$store_id);		
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	
	function update_store(){
		//update store
		
		$store['Store_name'] = $_POST['Store_name'];
		$store['store_email'] = $_POST['store_email'];
		$store['store_contact'] = $_POST['store_contact'];
		$store['store_status'] = $_POST['store_status'];
		$store['disapprove_reason'] = $_POST['disapprove_reason'];
		$store['description'] = $_POST['description'];
		$store['pancard_number'] = $_POST['pancard_number'];
		$store['gst_number'] = $_POST['gst_number'];
		$store['store_address'] = $_POST['store_address'];
		$store['store_address_2'] = $_POST['store_address_2'];
		$store['address_verifed'] = $_POST['address_verifed'];
		$store['pancard_verifed'] = $_POST['pancard_verifed'];
		$store['gst_verifed'] = $_POST['gst_verifed'];
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
		}
		
		if(isset($_POST['gst_image']) != NULL){
			$store['gst_image'] = $_POST['gst_image'];
		}
		
		
		$this->db->where('store_id',$_POST['store_id']);
		$this->db->update('Store_master',$store);
		
		$tag['item_id'] = $_POST['store_id'];
		$tag['tag'] = $_POST['Store_name'];
		$tag['type'] = 2;
		$this->db->insert('tag_master',$tag);
	}
  
  
  
  
  
  
  
	function insert_parent_category($img){ 
	
		$data['category_name'] = $_POST['category_name'];
		$data['category_image'] = $img;
		$data['category_tag'] = $_POST['category_tag'];
		$data['category_type'] = $_POST['category_type'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		if(isset($_POST['parent_category'])){
			$data['parent_category'] = $_POST['parent_category'];
		}
		
		$this->db->insert('category_master',$data);
	}
	
	function parent_category_exists(){
		
		
		$this->db->select('*');
		if(isset($_POST['category_id']) != ''){
			$this->db->where('category_id !=', $_POST['category_id']);
		}
		
		$this->db->where('parent_category', NULL);
		$this->db->where('category_name', $_POST['category_name']);
		$this->db->where('category_type', $_POST['category_type']);
		$this->db->from('category_master');
		return $this->db->get()->result();
		
	}
	
	function get_single_parent_cat($id){
		$this->db->select('*');
		$this->db->where('category_id', $id);
		$this->db->from('category_master');
		return $this->db->get()->row();
	}
	
	function update_parent_category(){
		$data['category_name'] = $_POST['category_name'];
		$data['category_tag'] = $_POST['category_tag'];
		$data['category_status'] = $_POST['category_status'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		if(isset($_POST['category_image'])){
			$data['category_image'] = $_POST['category_image'];
		}
		
		if(isset($_POST['parent_category'])){
			$data['parent_category'] = $_POST['parent_category'];
		}
		
		$this->db->where('category_id',$_POST['id']);
		$this->db->update('category_master',$data);
	}
	
	function deletes_parent_category($id){
		$this->db->where('category_id', $id);
		$this->db->delete('category_master');
		
		$this->db->select('*');
		$this->db->where('parent_category', $id);
		$this->db->from('category_master');
		$child = $this->db->get()->result();
		
		foreach($child as $val){
			//delete image
			$path = $val->category_image;
			if(file_exists($path)) { unlink($path); }
			
			$this->db->where('category_id', $val->category_id);
			$this->db->delete('category_master');
		}
		
	}
	
	
	
	
	
}
?>