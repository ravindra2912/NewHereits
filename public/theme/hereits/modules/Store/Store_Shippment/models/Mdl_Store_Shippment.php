<?php 
class Mdl_Store_Shippment extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kuala_Lumpur");
	} 
	
	function get_store_details()
	{   
		$this->db->select('shipping_charge, minimum_cart_amount, delivery_to_address');
		//$this->db->where('store_type',1);
		$this->db->where('store_id',$this->session->User->store_id);
		$this->db->from('Store_master');
		return $this->db->get()->row();
	} 
	
	function update_shippment()
	{   
		if($_POST['delivery'] == 1){
			$data['shipping_charge'] = $_POST['shipping_charge'];
			$data['minimum_cart_amount'] = $_POST['minimum_cart_amount'];
			$data['delivery_to_address'] = 1;
		}else{
			$data['delivery_to_address'] = 0;
		}
		$this->db->where('store_id',$this->session->User->store_id);
		$this->db->update('Store_master',$data);
	} 
	
	
}
?>