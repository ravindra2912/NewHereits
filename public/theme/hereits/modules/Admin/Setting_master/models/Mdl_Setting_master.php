<?php 
class Mdl_Setting_master extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_data(){
		$this->db->select('*');
		$this->db->from('setting_master');
		return $this->db->get()->row();
	}
	
	
	function update_privacy_policy(){
		
		$data['Privacy_policy'] = $_POST['Privacy_policy'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		$this->db->where('id',$_POST['id']);
		$this->db->update('setting_master',$data);
	}
	
	function update_Terms_Conditions(){
		
		$data['Terms_Conditions'] = $_POST['Terms_Conditions'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		$this->db->where('id',$_POST['id']);
		$this->db->update('setting_master',$data);
	}
	
	function update_Aboutus(){
		
		$data['Aboutus'] = $_POST['Aboutus'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		$this->db->where('id',$_POST['id']);
		$this->db->update('setting_master',$data);
	}
	
	function update_Credits(){
		
		$data['Credits'] = $_POST['Credits'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		$this->db->where('id',$_POST['id']);
		$this->db->update('setting_master',$data);
	}
	
	function update_copyright_Policy(){
		
		$data['copyright'] = $_POST['copyright'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		$this->db->where('id',$_POST['id']);
		$this->db->update('setting_master',$data);
	}
	
	
	function get_Banners(){
		$this->db->select('*');
		$this->db->from('banner_master');
		return $this->db->get()->result();
	}
	
	function add_banner($img){
		$data['image_url'] = $img;
		
		$this->db->insert('banner_master',$data);
	}
	
	function get_single_banner($id){
		$this->db->select('*');
		$this->db->where('id',$id);
		$this->db->from('banner_master');
		return $this->db->get()->row();
	}
	
	function update_site_setting(){
		$data['maintenance'] = $_POST['maintenance'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		$this->db->where('id',$_POST['id']);
		$this->db->update('setting_master',$data);
	}
	
}
?>