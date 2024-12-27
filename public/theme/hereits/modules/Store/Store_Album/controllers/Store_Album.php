<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_Album extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Store_Album');
		
		if($this->session->User == null)
		{redirect('Login');}
	}
	
	Public function index()
	{   $album = $this->Mdl_Store_Album->get_albums();
	
		$data =array(
			'main_content'=>'album_list',   
			'album'=>$album, 
		);
		$this->load->view('Store_template/template',$data);
	}
	
	
	function add_album(){
		
		
		$album_id = $this->Mdl_Store_Album->insert_album_namke();
		
		if($_FILES['image_url']['tmp_name'][0] != NULL){
			foreach ($_FILES['image_url']['tmp_name'] as $key => $value){
				
				$target_path = "uploads/album_images/";
				$ext = explode('.', basename($_FILES['image_url']['name'][$key]));
				$digits = 2;
				$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
				$c_name = $album_id.'-'.time().'-'.$rands . "." . $ext[count($ext) - 1];
				$c_image = $target_path . $c_name;
				move_uploaded_file($_FILES['image_url']['tmp_name'][$key], $c_image);
				if(file_exists($c_image)) {
					$img = $target_path.$c_name;
					$this->Mdl_Store_Album->add_album_image($img, $album_id);
				}
				
			}
		}
		
		redirect('Store_Album');
	}
	
	
	function add_img(){
			if($_FILES['image_url']['tmp_name'][0] != NULL){
				foreach ($_FILES['image_url']['tmp_name'] as $key => $value){
				
				$target_path = "uploads/album_images/";
				$ext = explode('.', basename($_FILES['image_url']['name'][$key]));
				$digits = 2;
				$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
				$c_name = $_POST['album_id'].'-'.time().'-'.$rands . "." . $ext[count($ext) - 1];
				$c_image = $target_path . $c_name;
				move_uploaded_file($_FILES['image_url']['tmp_name'][$key], $c_image);
				if(file_exists($c_image)) {
					$img = $target_path.$c_name;
					$this->Mdl_Store_Album->add_album_image($img, $_POST['album_id']);
				}
				
			}
		}
		
		redirect('Store_Album');
	}
	
	function update_album(){
		$this->Mdl_Store_Album->update_album();
		redirect('Store_Album');
	}
	
	
	function delete_image($id){
		$res = $this->Mdl_Store_Album->get_single_image($id);
		//delete image
		$path = $res->image_url;
		if(file_exists($path)) { unlink($path); }
		
		//delete record
		$this->db->where('image_id', $id);
		$this->db->delete('album_image_master');
		
		redirect('Store_Album');
	}
	
	function delete_album($id){
		$album = $this->Mdl_Store_Album->get_album_image($id);
		
		foreach($album as $val){
			$res = $this->Mdl_Store_Album->get_single_image($val->image_id);
			//delete image
			$path = $res->image_url;
			if(file_exists($path)) { unlink($path); }
			
			//delete record
			$this->db->where('image_id', $val->image_id);
			$this->db->delete('album_image_master');
		}
		
			//delete record
			$this->db->where('album_id', $id);
			$this->db->delete('album_master');
			
			redirect('Store_Album');
	}
	
	
	
	
	
	
	
}
?>
