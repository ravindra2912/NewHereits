<?php 
class Mdl_Store_dashboard extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_counts(){
		$this->db->select('count(*) as allcount');
		$this->db->from('Order_master');
		$this->db->where('store_id', $this->session->User->store_id);
		$query = $this->db->get();
		$order = $query->result_array();
		
		$this->db->select('count(*) as allcount');
		$this->db->from('booking_master');
		$this->db->where('store_id', $this->session->User->store_id);
		$query = $this->db->get();
		$booking = $query->result_array();
		
		$this->db->select('count(*) as allcount');
		$this->db->from('store_product_master');
		$this->db->where('store_id', $this->session->User->store_id);
		$query = $this->db->get();
		$product = $query->result_array();
		
		$this->db->select('count(*) as allcount');
		$this->db->from('store_Packages_master');
		$this->db->where('store_id', $this->session->User->store_id);
		$query = $this->db->get();
		$Packages = $query->result_array();
		
		$this->db->select('count(*) as allcount');
		$this->db->from('Coupons_master');
		$this->db->where('coupon_store_id', $this->session->User->store_id);
		$query = $this->db->get();
		$Coupons = $query->result_array();
		
		$this->db->select('count(*) as allcount');
		$this->db->from('album_master');
		$this->db->where('store_id', $this->session->User->store_id);
		$query = $this->db->get();
		$album = $query->result_array();
		
		$this->db->select('count(*) as allcount');
		$this->db->from('store_timing_master');
		$this->db->where('store_id', $this->session->User->store_id);
		$this->db->where('closed', 0);
		$query = $this->db->get();
		$store_timing = $query->result_array();
	 
		$data['order'] = $order[0]['allcount'];
		$data['booking'] = $booking[0]['allcount'];
		$data['product'] = $product[0]['allcount'];
		$data['Packages'] = $Packages[0]['allcount'];
		$data['Coupons'] = $Coupons[0]['allcount'];
		$data['album'] = $album[0]['allcount'];
		$data['store_timing'] = $store_timing[0]['allcount'];
		
		return $data;
	}
	
	function get_store_details(){
		$this->db->select('*');
		$this->db->where('store_id', $this->session->User->store_id);
		$this->db->from('Store_master');
		return $this->db->get()->row();
	}
	function get_single_child_cat($id){
		$this->db->select('cm.*,pcm.category_name as parent_category_name');
		$this->db->where('cm.category_id', $id);
		$this->db->from('category_master as cm');
		$this->db->join('category_master AS pcm','pcm.`category_id` = cm.`parent_category`','Left');
		return $this->db->get()->row();
	}
	
	function get_product_data($rowno2,$rowperpage2)
	{
		$this->db->select('om.*,um.*,otm.item_amount');
		$this->db->from('Order_master as om');
		$this->db->join('order_item_mastet AS otm','otm.order_id = om.order_id','Left');
		$this->db->join('User_master AS um','um.user_id = om.user_id','Left');
		$this->db->limit($rowperpage2, $rowno2); 
		$this->db->order_by("om.created_at", "desc");
		$this->db->where('om.order_status',0);
		$this->db->where('om.store_id',$this->session->User->store_id);
		return $this->db->get()->result();
	}	
	public function getrecordCount_product() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Order_master');
		
		$this->db->where('order_status',0);
		$this->db->where('store_id',$this->session->User->store_id);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	
	function get_package_data($rowno3,$rowperpage3)
	{
		$this->db->select('bm.*,btm.item_amount,um.frist_name,um.last_name');
		$this->db->from('booking_master as bm');
		$this->db->join('booking_item_master AS btm','btm.booking_id = bm.booking_id','Left');
		$this->db->join('User_master AS um','um.user_id = bm.user_id','Left');
		$this->db->limit($rowperpage3, $rowno3); 
		$this->db->order_by("bm.created_at_time", "desc");
		$this->db->where('bm.booking_status',0);
		$this->db->where('bm.store_id',$this->session->User->store_id);
		return $this->db->get()->result();
	}
	
	public function getrecordCount_package() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('booking_master');
		
		$this->db->where('booking_status',0);
		$this->db->where('store_id',$this->session->User->store_id);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	
}
?>