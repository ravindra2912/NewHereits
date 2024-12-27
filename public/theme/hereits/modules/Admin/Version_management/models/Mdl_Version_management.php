<?php 
class Mdl_Version_management extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function logo(){
		$this->db->select('image_url');
		$this->db->from('app_banner_master');
		$this->db->where('id',3);
		return $this->db->get()->row();
	}
	function get_version(){
		$this->db->select('*');
		$this->db->from('App_version_master');
		$this->db->order_by('id',"desc");
		$this->db->limit(1);
		return $this->db->get()->row();
	}
	
}
?>