<?php 
class Mdl_Store_Order extends CI_Model
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
		');
		$this->db->from('Order_master as om');
		
		if(!empty($_POST['search'])){
			$this->db->like('om.order_id', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('om.order_status', $_POST['status']);
		}
		
		$this->db->join('User_master AS um','um.user_id = om.user_id','Left');
		
		$this->db->limit($rowperpage, $rowno); 
		$this->db->order_by('om.created_at_date','desc'); 
		$this->db->order_by('om.created_at_time','desc'); 
		$this->db->where('om.store_id', $this->session->User->store_id);
		return $this->db->get()->result();
	}
	
	public function getrecordCount_order() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Order_master');
		
		if(!empty($_POST['search'])){
			$this->db->like('order_id', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('order_status', $_POST['status']);
		}
		
		$this->db->where('store_id', $this->session->User->store_id);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	  
	  function Get_order_details($id){
		  $this->db->select('
			om.*,
			um.username,
			um.contact,
		');
		$this->db->from('Order_master as om');
		
		$this->db->join('User_master AS um','um.user_id = om.user_id','Left');
		
		$this->db->limit($rowperpage, $rowno); 
		$this->db->where('om.store_id', $this->session->User->store_id);
		$this->db->where('om.order_id', $id);
		return $this->db->get()->row();
	  }
	  
	  function get_address($id){
		$this->db->select('*');
		$this->db->from('address_master');		
		$this->db->where('address_id', $id);
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
		$data['cancel_reason'] = $_POST['action'];
		$this->db->where('order_id',$_POST['order_id']);
		$this->db->update('Order_master',$data);
		
		$data2['order_id'] = $_POST['order_id'];
		$data2['order_status'] = $_POST['order_status'];
		$data2['created_at'] = date("Y-m-d H:i:s");
		$this->db->insert('Order_Log_Master',$data2);
	  }
	  
	  
	  
	  
	  
	  
}
?>