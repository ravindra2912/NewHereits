<?php 
class Mdl_dashboard extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_images($limit,$start)
	{ 
		$this->db->select('*');		
		$this->db->limit($limit, $start);
		$this->db->from('image_master');		 	
		return $this->db->get()->result();	
	} 
	
	function get_count()
	{ 
		return $this->db->count_all('image_master');	
	} 	
	
	function get_store_data($rowno,$rowperpage)
	{
		$this->db->select('sm.* , um.user_id,um.username	,');
		$this->db->from('Store_master as sm');
		
		if($_POST['datepicker'] != ''){
			$this->db->where('sm.created_at>=', $_POST['datepicker']);
		}
		if($_POST['enddatepicker'] != ''){
		$this->db->where('sm.created_at<=', $_POST['enddatepicker']);
		}
		
		$this->db->join('User_master AS um','um.user_id = sm.user_id','Left');
		$this->db->limit($rowperpage, $rowno); 
		$this->db->order_by("created_at", "desc");
		$this->db->where('store_status',0);
		return $this->db->get()->result();
	}
	
	public function getrecordCount_store() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Store_master');
		if($_POST['datepicker'] != ''){
			$this->db->where('created_at>=', $_POST['datepicker']);
		}
		if($_POST['enddatepicker'] != ''){
		$this->db->where('created_at<=', $_POST['enddatepicker']);
		}
		$this->db->where('store_status',0);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	
	public function pending_reg_count() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Registration_Master');
		$this->db->where('Registration_completed',0);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	
	function get_product_data($rowno2,$rowperpage2)
	{
		$this->db->select('pm.* , sm.Store_name	,');
		$this->db->from('product_master as pm');
		
		if($_POST['datepicker'] != ''){
			$this->db->where('pm.created_at>=', $_POST['datepicker']);
		}
		if($_POST['enddatepicker'] != ''){
		$this->db->where('pm.created_at<=', $_POST['enddatepicker']);
		}
		
		$this->db->join('Store_master AS sm','sm.store_id = pm.request_store_id','Left');
		$this->db->limit($rowperpage2, $rowno2); 
		$this->db->order_by("created_at", "desc");
		$this->db->where('product_status',0);
		return $this->db->get()->result();
	}
	
	public function getrecordCount_product() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('product_master');
		if($_POST['datepicker'] != ''){
			$this->db->where('created_at>=', $_POST['datepicker']);
		}
		if($_POST['enddatepicker'] != ''){
		$this->db->where('created_at<=', $_POST['enddatepicker']);
		}
		$this->db->where('product_status',0);
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
	
	function product_img($id){
		$this->db->select('*');
		$this->db->from('product_image_master');		
		$this->db->where('product_id', $id);
		return $this->db->get()->row();
	}
	
	function get_package_data($rowno3,$rowperpage3)
	{
		$this->db->select('pm.* , sm.Store_name	,');
		$this->db->from('Packages_master as pm');
		
		if($_POST['datepicker'] != ''){
			$this->db->where('pm.created_at>=', $_POST['datepicker']);
		}
		if($_POST['enddatepicker'] != ''){
		$this->db->where('pm.created_at<=', $_POST['enddatepicker']);
		}
		
		$this->db->join('Store_master AS sm','sm.store_id = pm.request_store_id','Left');
		$this->db->limit($rowperpage3, $rowno3); 
		$this->db->order_by("created_at", "desc");
		$this->db->where('packege_status',0);
		return $this->db->get()->result();
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
	
	function get_semi_approved_users_data($rowno4,$rowperpage4)
	{
		$this->db->select('*');
		$this->db->from('User_master');
		
		if($_POST['datepicker'] != ''){
			$this->db->where('pm.created_at>=', $_POST['datepicker']);
		}
		if($_POST['enddatepicker'] != ''){
		$this->db->where('pm.created_at<=', $_POST['enddatepicker']);
		}
		
		$this->db->limit($rowperpage4, $rowno4); 
		$this->db->order_by("created_at", "desc");
		$this->db->where('adhar_verifed',0);
		return $this->db->get()->result();
	}
	
	public function get_semi_verfied_Count_users() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('User_master');
		if($_POST['datepicker'] != ''){
			$this->db->where('created_at>=', $_POST['datepicker']);
		}
		if($_POST['enddatepicker'] != ''){
		$this->db->where('created_at<=', $_POST['enddatepicker']);
		}
		$this->db->where('adhar_verifed',0);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	
	function get_semi_approved_stores_data($rowno5,$rowperpage5)
	{
		$this->db->select('sm.* , um.user_id,um.username,');
		$this->db->from('Store_master as sm');
		
		if($_POST['datepicker'] != ''){
			$this->db->where('sm.created_at>=', $_POST['datepicker']);
		}
		if($_POST['enddatepicker'] != ''){
		$this->db->where('sm.created_at<=', $_POST['enddatepicker']);
		}
		
		$this->db->join('User_master AS um','um.user_id = sm.user_id','Left');
		$this->db->limit($rowperpage5, $rowno5); 
		$this->db->order_by("created_at", "desc");
		$this->db->where('address_verifed',0);
		$this->db->or_where('pancard_verifed',0);
		$this->db->or_where('gst_verifed',0);
		return $this->db->get()->result();
	}
	
	public function get_semi_verfied_Count_stores() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Store_master');
		if($_POST['datepicker'] != ''){
			$this->db->where('created_at>=', $_POST['datepicker']);
		}
		if($_POST['enddatepicker'] != ''){
		$this->db->where('created_at<=', $_POST['enddatepicker']);
		}
		$this->db->where('address_verifed',0);
		$this->db->or_where('pancard_verifed',0);
		$this->db->or_where('gst_verifed',0);
		
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
	function getuser_count() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('User_master');		
		if($_POST['datepicker'] != ''){
			$this->db->where('created_at>=', $_POST['datepicker']);
		}
		if($_POST['enddatepicker'] != ''){
		$this->db->where('created_at<=', $_POST['enddatepicker']);
		}
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	function getstore_count() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Store_master');		
		if($_POST['datepicker'] != ''){
			$this->db->where('created_at>=', $_POST['datepicker']);
		}
		if($_POST['enddatepicker'] != ''){
		$this->db->where('created_at<=', $_POST['enddatepicker']);
		}
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	
	function set_image($img)
	{ 		
	
		$data['title'] = $_POST['img_title'];
		$data['image'] = $img; 	
		$data['created_at'] = date("Y-m-d H:i:s"); 	
		$this->db->insert('image_master',$data); 
	} 
	
	function get_single_image()
	{ 
		$this->db->select('*');
		$this->db->where('id', $_POST['id']);
		$this->db->from('image_master ');
		return $this->db->get()->row();	
	} 
	
	function delete_image()
	{
		$this->db->where('id', $_POST['id']);
		$this->db->delete('image_master');
	}
	
	function get_pending_reg($rowno,$rowperpage)
	{
		$this->db->select('*');
		$this->db->from('Registration_Master');
		
		if($_POST['search'] != ''){
			$this->db->where('Phone_no', $_POST['search']);
		}
		$this->db->limit($rowperpage, $rowno); 
		$this->db->order_by("created_at", "desc");
		$this->db->where('Registration_completed',0);
		return $this->db->get()->result();
	}
	
	public function get_pending_reg_count() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Registration_Master');
		if($_POST['search'] != ''){
			$this->db->where('Phone_no', $_POST['search']);
		}
		
		$this->db->where('Registration_completed',0);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
}
?>