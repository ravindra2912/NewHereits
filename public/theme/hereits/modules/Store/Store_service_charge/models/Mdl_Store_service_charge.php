<?php 
class Mdl_Store_service_charge extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kuala_Lumpur");
	} 
	
	function get_store_details()
	{   
		$this->db->select('service_to_address, service_charge, minimum_service_cart_amount, inspection_charge');
		//$this->db->where('store_type',1);
		$this->db->where('store_id',$this->session->User->store_id);
		$this->db->from('Store_master');
		return $this->db->get()->row();
	} 
	
	function update()
	{   
		if(isset($_POST['inspection_charge'])){
			$data['inspection_charge'] = $_POST['inspection_charge'];
		}else{
			if($_POST['service_to_address'] == 1){
				$data['service_charge'] = $_POST['service_charge'];
				$data['minimum_service_cart_amount'] = $_POST['minimum_service_cart_amount'];
				$data['service_to_address'] = 1;
			}else{
				$data['service_to_address'] = 0;
			}
		}
		
		
		$this->db->where('store_id',$this->session->User->store_id);
		$this->db->update('Store_master',$data);
	} 
	
	
}
?>