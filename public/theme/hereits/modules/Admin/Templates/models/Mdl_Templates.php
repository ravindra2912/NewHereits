<?php 
class Mdl_Templates extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	function Get_order_details($id){
		  $this->db->select('
			om.*,
			um.username,
			um.contact,
		');
		$this->db->from('Order_master as om');
		
		$this->db->join('User_master AS um','um.user_id = om.user_id','Left');
		
		$this->db->where('om.order_id', $id);
		return $this->db->get()->row();
	  }
	  
	  function Get_Store_detail($id){
		$this->db->select('*');
		$this->db->from('Store_master');		
		$this->db->where('store_id', $id);
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
	  
	  
	function Get_booking_details($id){
		  $this->db->select('
			bm.*,
			um.username,
			um.contact,
		');
		$this->db->from('booking_master as bm');
		
		$this->db->join('User_master AS um','um.user_id = bm.user_id','Left');
		
		$this->db->where('bm.booking_id', $id);
		return $this->db->get()->row();
	  }
	  
	 function Get_booking_items($booking_id){
		  $this->db->select('
			bim.*,
			pm.Package_id,
			pm.Package_name,
			pm.packege_image,
		');
		$this->db->from('booking_item_master as bim');
		
		$this->db->join('Packages_master AS pm','pm.Package_id = bim.item_id','Left');
		$this->db->where('bim.booking_id', $booking_id);
		return $this->db->get()->result();
	  }
	
	
}
?>