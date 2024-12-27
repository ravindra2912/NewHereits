<?php 
class Mdl_Order_management extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	function get_order_data($rowno,$rowperpage)
	{
		$this->db->select('
			om.*,
			um.username,
			um.contact,
			sn.Store_name,
			sn.store_id,
		');
		$this->db->from('Order_master as om');
		
		if(!empty($_POST['search'])){
			$this->db->like('om.order_id', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('om.order_status', $_POST['status']);
		}
		if($_POST['is_user'] != ''){
				$this->db->where('om.user_id', $_POST['is_user']);
		   } 
		
		if($_POST['is_store'] != ''){
			$this->db->where('sn.store_id', $_POST['is_store']);
		}
		
		$this->db->join('User_master AS um','um.user_id = om.user_id','Left');
		$this->db->join('Store_master AS sn','sn.user_id = om.user_id','Left');
		
		$this->db->limit($rowperpage, $rowno); 
		return $this->db->get()->result();
	}
	
	public function getallrecord_order() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Order_master');
		
		if(!empty($_POST['search'])){
			$this->db->like('order_id', $_POST['search']);
		}
		
		if($_POST['is_user'] != ''){
				$this->db->where('user_id', $_POST['is_user']);
		   } 
		   
		if($_POST['status'] != ''){
			$this->db->where('order_status', $_POST['status']);
		}
		
		if($_POST['is_store'] != ''){
				$this->db->where('store_id', $_POST['is_store']);
		}
		
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	  
	function fetch_user(){
				
		$this->db->select('om.*,um.user_id,um.username');
		$this->db->from('Order_master as om');
		$this->db->join('User_master AS um','um.user_id = om.user_id','Left');
		$this->db->group_by('um.user_id'); 
		return $this->db->get()->result();
	}  
	
	function fetch_store_name(){
				
		$this->db->select('om.*,sm.store_id,sm.Store_name');
		$this->db->from('Order_master as om');
		$this->db->group_by('sm.store_id'); 
		$this->db->join('Store_master AS sm','sm.store_id = om.store_id','Left');
		return $this->db->get()->result();
	} 
	  
	  // Order Details 
	  function Get_order_details($id){
		  $this->db->select('
			om.*,
			um.frist_name,
			um.last_name,
			um.username,
			um.email,
			um.contact,	
		');
		$this->db->from('Order_master as om');
		
		$this->db->join('User_master AS um','um.user_id = om.user_id','Left');
		$this->db->where('om.order_id', $id);
		return $this->db->get()->row();
	  }
	  
	  function get_address($id){
		$this->db->select('*');
		$this->db->from('address_master');		
		$this->db->where('address_id', $id);
		return $this->db->get()->row();
	  }
	  
	  function Get_store($id){
		$this->db->select('*');
		$this->db->from('Store_master');		
		$this->db->where('store_id', $id);
		return $this->db->get()->row();
	  }
	  
	
	  
	  function Get_order_items($order_id){
		  $this->db->select('
			oim.*,
			pm.product_name,
			pm.product_id,
		');
		$this->db->from('order_item_mastet as oim');
		
		$this->db->join('product_master AS pm','pm.product_id = oim.item_id','Left');
		$this->db->where('order_id', $order_id);
		return $this->db->get()->result();
	  }
	  
	  function get_product_image($product_id){
		$this->db->select('*');
		$this->db->from('product_image_master');		
		$this->db->where('product_id', $product_id);
		$this->db->order_by("image_order", "asc");
		return $this->db->get()->row();
	  }
	  
	  function Change_order_status(){
		$data['order_status'] = $_POST['order_status'];
		$this->db->where('order_id',$_POST['order_id']);
		$this->db->update('Order_master',$data);
		
		$data['order_id'] = $_POST['order_id'];
		$data['order_status'] = $_POST['order_status'];
		$data['created_at'] = date("Y-m-d H:i:s");
		$this->db->insert('Order_Log_Master',$data);
	  }
	  
	  
	  
	  
	  
	  
}
?>