<?php 
class Mdl_Account extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	function get_profile()
	{
		$this->db->select('*');
		$this->db->from('User_master');
		$this->db->where('user_id', $this->session->User->user_id);
		return $this->db->get()->row();
	}
	
	function update_profile()
	{
		$data['frist_name']=$_POST['frist_name'];
		$data['last_name']=$_POST['last_name'];
		$data['email']=$_POST['email'];
		$data['contact']=$_POST['contact'];
		$data['gender']=$_POST['gender'];
		$data['username']=$_POST['username'];
		if ($_POST['user_image'] != NULL)
		{
			$data['user_image']=$_POST['user_image'];
		}	
		$this->db->where('user_id', $this->session->User->user_id);
		$this->db->update('User_master', $data);
	}
	function check_pswrd()
	{
		$this->db->select('*');
		$this->db->from('User_master');
		$this->db->where('user_id', $this->session->User->user_id);
		$this->db->where('password', md5($_POST['old_pswrd']));
		return $this->db->get()->row();
	}
	function update_password()
	{
		$data['new_pswrd']=md5($_POST['old_pswrd']);
		$this->db->where('user_id', $this->session->User->user_id);
		$this->db->update('User_master', $data);
		
	}
	function get_addresses()
	{
		$this->db->select('*');
		$this->db->from('address_master');
		$this->db->where('user_id', $this->session->User->user_id);
		return $this->db->get()->result();
	}
	function get_single_address($id)
	{
		$this->db->select('*');
		$this->db->from('address_master');
		$this->db->where('address_id', $id);
		return $this->db->get()->row();
	}	
	function insert_address()
	{
		$data['name']=$_POST['name'];
		$data['contact']=$_POST['contact'];
		$data['address1']=$_POST['address1'];
		$data['address2']=$_POST['address2'];
		$data['city']=$_POST['city'];
		$data['state']=$_POST['state'];
		$data['country']=$_POST['country'];
		$data['pincode']=$_POST['pincode'];
		$data['user_id']=$this->session->User->user_id;
		$data['address_type']=$_POST['address_type'];
		$data['created_at']=date("Y-m-d H:i:s");
		$this->db->insert('address_master', $data);
	}
	
	function update_address(){
		$data['name']=$_POST['name'];
		$data['contact']=$_POST['contact'];
		$data['address1']=$_POST['address1'];
		$data['address2']=$_POST['address2'];
		$data['city']=$_POST['city'];
		$data['state']=$_POST['state'];
		$data['country']=$_POST['country'];
		$data['pincode']=$_POST['pincode'];
		$data['address_type']=$_POST['address_type'];
		$data['updated_at']=date("Y-m-d H:i:s");
		$this->db->where('address_id', $_POST['address_id']);
		$this->db->update('address_master', $data);
	}
	function delete_addres($id)
	{
		$this->db->where('address_id', $id);
		$this->db->delete('address_master');
	}
	
	function get_orders()
	{
		$this->db->select('*');
		$this->db->from('Order_master');
		$this->db->where('user_id', $this->session->User->user_id);
		$this->db->order_by('created_at_date', 'desc');
		$this->db->order_by('created_at_time', 'desc');
		return $this->db->get()->result();
	}
		
	function get_single_orders($id)
	{
		$this->db->select('om.* , am.* , sm.* ,
							am.city as customer_city ,
							am.state as customer_state,
							am.country as customer_country,
							am.contact as customer_contact,
							am.pincode as customer_pincode');
		$this->db->from('Order_master as om');
		$this->db->join('address_master AS am','am.address_id = om.addres_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = om.store_id','Left');
		$this->db->where('om.order_id', $id);
		
		return $this->db->get()->row();
	}
	function get_order_items($id)
	{
		$this->db->select('otm.* , pm.* ');
		$this->db->from('order_item_mastet as otm');
		$this->db->join('product_master AS pm','pm.product_id= otm.item_id','Left');
		$this->db->where('otm.order_id', $id);
		return $this->db->get()->result();
	}
	function get_single_store($id)
	{
		$this->db->select('*');
		$this->db->from('Store_master');
		$this->db->where('store_id', $id);
		return $this->db->get()->row();
	}
	function cancel_order($id){
		
		$this->db->where('order_id', $id);
		$this->db->delete('order_item_mastet');
		
		$this->db->where('order_id', $id);
		$this->db->delete('Order_master');
	}
		
	function get_bookings()
	{
		$this->db->select('*');
		$this->db->from('booking_master');
		$this->db->where('user_id', $this->session->User->user_id);
		$this->db->order_by('created_at_date', 'desc');
		$this->db->order_by('created_at_time', 'desc');
		return $this->db->get()->result();
	}
	
	function get_single_Bookings($id)
	{
		$this->db->select('bm.* , am.* , sm.* ,
							am.city as customer_city ,
							am.state as customer_state,
							am.country as customer_country,
							am.contact as cust_contact,
							am.pincode as customer_pincode');
		$this->db->from('booking_master as bm');
		$this->db->join('address_master AS am','am.address_id = bm.addres_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = bm.store_id','Left');
		$this->db->where('bm.booking_id', $id);
		return $this->db->get()->row();
	}
	function get_Bookings_service($id)
	{
		$this->db->select('btm.* , pm.* ');
		$this->db->from('booking_item_master as btm');
		$this->db->join('Packages_master AS pm','pm.Package_id= btm.item_id','Left');
		$this->db->where('btm.booking_id', $id);
		return $this->db->get()->result();
	} 
	
	function cancel_Booking($id){
		
		$this->db->where('booking_id', $id);
		$this->db->delete('booking_item_master');
		
		$this->db->where('booking_id', $id);
		$this->db->delete('booking_master');
	} 
	
	function ajax_get_products($offset,$limit)
	{
		$this->db->select('pm.product_name, spm.*, sm.Store_name, cm.category_name');
		$this->db->from('store_product_master as spm');
		
		
		$this->db->join('product_master AS pm','pm.product_id = spm.product_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
		
		//check subscription
		$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
		$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		
		
		$this->db->join('category_master AS cm','cm.category_id = pm.product_parent_category','Left');
		
		$this->db->limit($limit, $offset); 
		$this->db->where('spm.product_status', 1);
		$this->db->where('pm.product_status', 1);
		$this->db->where('sm.store_status', 1);
		//$this->db->where('sm.city', $city);
		
		//sort product
		if($_POST['sort_by'] == 1){
			//Popularity
		}else if($_POST['sort_by'] == 2){
			//Location
		}else if($_POST['sort_by'] == 3){
			//Newest First
			$this->db->order_by("pm.created_at", "DESC");
		}else if($_POST['sort_by'] == 4){
			//Rating
		}else if($_POST['sort_by'] == 5){
			//Price: Low to High
			$this->db->order_by("spm.product_sele_price", "asc");
		}else if($_POST['sort_by'] == 6){
			//Price: High to Low
			$this->db->order_by("spm.product_sele_price", "desc");
		}
		return $this->db->get()->result();
	}
	
	public function getrecordCount_ajax_product() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('store_product_master as spm');
		
		
		$this->db->join('product_master AS pm','pm.product_id = spm.product_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
		
		//check subscription
		$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
		$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		
		
		$this->db->join('category_master AS cm','cm.category_id = pm.product_parent_category','Left');
		
		$this->db->limit($limit, $offset); 
		$this->db->where('spm.product_status', 1);
		$this->db->where('pm.product_status', 1);
		$this->db->where('sm.store_status', 1);
		//$this->db->where('sm.city', $city);
		
		//sort product
		if($_POST['sort_by'] == 1){
			//Popularity
		}else if($_POST['sort_by'] == 2){
			//Location
		}else if($_POST['sort_by'] == 3){
			//Newest First
			$this->db->order_by("pm.created_at", "DESC");
		}else if($_POST['sort_by'] == 4){
			//Rating
		}else if($_POST['sort_by'] == 5){
			//Price: Low to High
			$this->db->order_by("spm.product_sele_price", "ASC");
			$this->db->order_by("spm.product_sele_price", "ASC");
		}else if($_POST['sort_by'] == 6){
			//Price: High to Low
			$this->db->order_by("spm.product_sele_price", "DESC");
			$this->db->order_by("spm.product_sele_price", "DESC");
		}
		
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	  
	function get_product_single_image($product_id){
		$this->db->select('*');
		$this->db->from('product_image_master');
		$this->db->where('product_id', $product_id);
		$this->db->order_by("image_order", "asc");
		return $this->db->get()->row();
	}
	
	function get_single_products($product_id){
		$this->db->select('pm.product_name, pm.product_parent_category, spm.*, sm.Store_name, sm.store_id, cm.category_name');
		
		$this->db->from('store_product_master as spm');
		//$this->db->where('spm.store_id', $store_id);
		$this->db->where('spm.product_id', $product_id);
		$this->db->join('product_master AS pm','pm.product_id = spm.product_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
		$this->db->join('category_master AS cm','cm.category_id = pm.product_parent_category','Left');
		
		
		return $this->db->get()->row();
	}
	
	function get_product_imgs($pid){
		$this->db->select('*');
		$this->db->from('product_image_master');
		$this->db->where('product_id', $pid);
		$this->db->order_by("image_order", "asc");
		return $this->db->get()->result();
	}
	
	function get_related_products($product_id, $cat_id){
		$this->db->select('pm.product_name, pm.product_parent_category, spm.*, sm.Store_name, sm.store_id, cm.category_name');
		
		$this->db->from('store_product_master as spm');
		//$this->db->where('spm.store_id', $store_id);
		$this->db->where('spm.product_id !=', $product_id);
		$this->db->where('pm.product_parent_category', $cat_id);
		$this->db->join('product_master AS pm','pm.product_id = spm.product_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
		$this->db->join('category_master AS cm','cm.category_id = pm.product_parent_category','Left');
		
		//check subscription
		$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
		$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		
		$this->db->where('spm.product_status', 1);
		$this->db->where('pm.product_status', 1);
		$this->db->where('sm.store_status', 1);
		
		
		$this->db->order_by('rand()');
		$this->db->limit(4);
		
		
		return $this->db->get()->result();
	}
	
}
?>