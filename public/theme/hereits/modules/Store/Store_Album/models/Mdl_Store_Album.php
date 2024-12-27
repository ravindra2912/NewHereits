<?php 
class Mdl_Store_Album extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	function get_albums(){
		$this->db->select('*');
		$this->db->where('store_id', $this->session->User->store_id);
		$this->db->from('album_master');
		$album = $this->db->get()->result();
		
		foreach($album as $albums){
			
			$this->db->select('*');
			$this->db->where('album_id', $albums->album_id);
			$this->db->from('album_image_master');
			$albums->imaghes = $this->db->get()->result();
			 
		}
		
		return $album;
	}
	
	function insert_album_namke(){
		$data['store_id'] = $this->session->User->store_id;
		$data['album_name'] = $_POST['album_name'];
		$data['created_at'] = date("Y-m-d H:i:s");
		
		$this->db->insert('album_master',$data);
		return $this->db->insert_id();
	}
	
	function add_album_image($img, $album_id){
		$data['album_id'] = $album_id;
		$data['image_url'] = $img;
		$data['created_at'] = date("Y-m-d H:i:s");
		
		$this->db->insert('album_image_master',$data);
		return $this->db->insert_id();
	}
	
	function update_album(){
		$data['album_name'] = $_POST['album_name'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		$this->db->where('album_id', $_POST['album_id']);
		$this->db->update('album_master',$data);
	}
	
	function get_single_image($id){
		$this->db->select('*');
		$this->db->where('image_id',$id);
		$this->db->from('album_image_master');
		return $this->db->get()->row();
	}
	
	function get_album_image($id){
		$this->db->select('*');
		$this->db->where('album_id',$id);
		$this->db->from('album_image_master');
		return $this->db->get()->result();
	}
	
	
	
	
	
	
	function add_offer($img){
		$data['image_url'] = $img;
		
		$this->db->insert('offer_banner_master',$data);
	}
	
	
	
	
	
}
?>