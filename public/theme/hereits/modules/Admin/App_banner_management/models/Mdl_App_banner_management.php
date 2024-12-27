<?php 
class Mdl_App_banner_management extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_app_banners(){
		$this->db->select('*');
		$this->db->order_by("order", "asc");
		$this->db->from('app_banner_master');
		return $this->db->get()->result();
	}	
	function insert_app_banner_images($img){
		$data['image_url'] = $img;
		$data['created_at'] = date("Y-m-d H:i:s");
		$this->db->insert('app_banner_master',$data);
	}
	function chnage_image_order(){
		$data['order'] = $_POST['order'];
		$this->db->where('id',$_POST['id']);
		$this->db->update('app_banner_master',$data);
	}
	
	function get_app_banner_img()
	{
		$this->db->select('*');
		$this->db->from('app_banner_master');
		$this->db->where('id',$_POST['id']);
		return $this->db->get()->row();
	}
		
		
	
}
?>