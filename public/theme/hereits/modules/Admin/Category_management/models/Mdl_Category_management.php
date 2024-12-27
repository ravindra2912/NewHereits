<?php 
class Mdl_Category_management extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_parent_category($category_type){
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('parent_category', NULL);
		$this->db->where('category_type', $category_type);
		$this->db->order_by("created_at", "desc");
		return $this->db->get()->result();
	}
	
	/********************* Parent category *********************/
	
	function get_parent_category_data($rowno,$rowperpage)
	{
		$this->db->select('*');
		$this->db->from('category_master');
		
		if(!empty($_POST['search'])){
			$this->db->like('category_name', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('category_status', $_POST['status']);
		}
		
		$this->db->limit($rowperpage, $rowno); 
		$this->db->where('parent_category', NULL);
		$this->db->where('category_type', $_POST['category_type']);
		$this->db->order_by("created_at", "desc");
		return $this->db->get()->result_array();
	}
	
	public function getrecordCount_parent_category() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('category_master');
		
		if(!empty($_POST['search'])){
			$this->db->like('category_name', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('category_status', $_POST['status']);
		}
		
		$this->db->where('parent_category', NULL);
		$this->db->where('category_type', $_POST['category_type']);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
  
  
	function insert_parent_category($img){ 
	
		$data['category_name'] = $_POST['category_name'];
		$data['category_image'] = $img;
		$data['category_type'] = $_POST['category_type'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		if(isset($_POST['parent_category'])){
			$data['parent_category'] = $_POST['parent_category'];
		}
		
		$this->db->insert('category_master',$data);
		$id =$this->db->insert_id();
		
		$tags = explode(",", $_POST['category_tag']);
		foreach($tags as $val)
		{
			$data2['item_id'] = $id;
			$data2['tag'] = $val;
			$data2['type'] = 3;
			$data2['teg_type'] = $_POST['category_type'];
			$data2['created_at'] = date("Y-m-d H:i:s");
			$this->db->insert('tag_master',$data2);
		}
	}
	
	function parent_category_exists(){
		
		
		$this->db->select('*');
		if(isset($_POST['category_id']) != ''){
			$this->db->where('category_id !=', $_POST['category_id']);
		}
		
		$this->db->where('parent_category', NULL);
		$this->db->where('category_name', $_POST['category_name']);
		$this->db->where('category_type', $_POST['category_type']);
		$this->db->from('category_master');
		return $this->db->get()->result();
		
	}
	
	function get_tag(){
		$this->db->select('*');
		$this->db->from('tag_master');
		return $this->db->get()->result();
	}  
	function get_single_parent_cat($id){
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('category_id', $id);
		
		return $this->db->get()->row();
	}
	function edit_tags($id){
		$this->db->select('*');
		$this->db->from('tag_master');
		$this->db->where('item_id',$id);
		$this->db->where('type',3);
		return $this->db->get()->result();
	}
	
	function update_tags($id){
		 
		$this->db->select('*');
		$this->db->from('category_master as cm');
		$this->db->where('category_id', $id);
		$type = $this->db->get()->row();
		
		if($type->category_type == 1){
					$teg_type = 1;
		}else if($type->category_type == 2) {
					$teg_type = 2;
		}
		$this->db->where('item_id',$id);
		$this->db->where('type',3);
		$this->db->where('teg_type',$teg_type);
		$this->db->delete('tag_master');
		
		$tags = explode(",", $_POST['category_tag']);
		foreach($tags as $val)
			{
				
				$data['teg_type'] = $teg_type;
				$data['tag'] = $val;
				$data['type'] = 3;
				$data['item_id'] = $id;
				$data['created_at'] = date("Y-m-d H:i:s");
				$this->db->insert('tag_master',$data);
				
			}
			
		if($type->category_type == 1){
					return 1;
				}else if($type->category_type == 2) {
					return 2;
			}
		
	}
	function update_parent_category(){
	
		$data['category_name'] = $_POST['category_name'];
		$data['category_status'] = $_POST['category_status'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
	
		if($_POST['approval_required'] == on){
			$data['approval_required'] = 1;
		}else{
			$data['approval_required'] = 0;
		}
		
		if(isset($_POST['category_image'])){
			$data['category_image'] = $_POST['category_image'];
		}
		
		if(isset($_POST['parent_category'])){
			$data['parent_category'] = $_POST['parent_category'];
		}
		
		$this->db->where('category_id',$_POST['update_id']);
		$this->db->update('category_master',$data);
		
		
	}
	
	function deletes_parent_category($id){
		$this->db->where('category_id', $id);
		$this->db->delete('category_master');
		
		$this->db->select('*');
		$this->db->where('parent_category', $id);
		$this->db->from('category_master');
		$child = $this->db->get()->result();
		
		foreach($child as $val){
			//delete image
			$path = $val->category_image;
			if(file_exists($path)) { unlink($path); }
			
			$this->db->where('category_id', $val->category_id);
			$this->db->delete('category_master');
		}
		
	}
	
	/********************* Parent category *********************/
	
	function get_child_category_data($rowno,$rowperpage)
	{
		$this->db->select('cm.*, pcm.category_name as parent_category_name');
		$this->db->from('category_master as cm');
		
		if(!empty($_POST['search'])){
			$this->db->like('cm.category_name', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('cm.category_status', $_POST['status']);
		}
		
		if($_POST['parent_category'] != ''){
			$this->db->where('cm.parent_category', $_POST['parent_category']);
		}
		
		$this->db->limit($rowperpage, $rowno); 
		$this->db->where('cm.parent_category !=', NULL);
		$this->db->where('cm.category_type', $_POST['category_type']);
		$this->db->order_by("cm.created_at", "desc");
		$this->db->join('category_master AS pcm','pcm.`category_id` = cm.`parent_category`','Left');
		return $this->db->get()->result_array();
	}
	
	public function getrecordCount_child_category() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('category_master');
		
		if(!empty($_POST['search'])){
			$this->db->like('category_name', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('category_status', $_POST['status']);
		}
		
		if($_POST['parent_category'] != ''){
			$this->db->where('parent_category', $_POST['parent_category']);
		}
		
		$this->db->where('parent_category !=', NULL);
		$this->db->where('category_type', $_POST['category_type']);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
  
  
	function insert_child_category($img){ 
	
		$data['category_name'] = $_POST['category_name'];
		$data['category_image'] = $img;
		$data['category_tag'] = $_POST['category_tag'];
		$data['category_type'] = $_POST['category_type'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		if(isset($_POST['parent_category'])){
			$data['parent_category'] = $_POST['parent_category'];
		}
		
		$this->db->insert('category_master',$data);
	}
	
	function child_category_exists(){
		
		
		$this->db->select('*');
		if(isset($_POST['category_id']) != ''){
			$this->db->where('category_id !=', $_POST['category_id']);
		}
		$this->db->where('parent_category !=', NULL);
		$this->db->where('category_name', $_POST['category_name']);
		$this->db->where('category_type', $_POST['category_type']);
		$this->db->from('category_master');
		return $this->db->get()->result();
		
	}
	
	function get_single_child_cat($id){
		$this->db->select('cm.*,pcm.category_name as parent_category_name');
		$this->db->where('cm.category_id', $id);
		$this->db->from('category_master as cm');
		$this->db->join('category_master AS pcm','pcm.`category_id` = cm.`parent_category`','Left');
		return $this->db->get()->row();
	}
	
	function update_child_category(){
		$data['category_name'] = $_POST['category_name'];
		$data['category_tag'] = $_POST['category_tag'];
		$data['category_status'] = $_POST['category_status'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		if(isset($_POST['category_image'])){
			$data['category_image'] = $_POST['category_image'];
		}
		
		if(isset($_POST['parent_category'])){
			$data['parent_category'] = $_POST['parent_category'];
		}
		
		$this->db->where('category_id',$_POST['id']);
		$this->db->update('category_master',$data);
	}
	
	function deletes_child_category($id){
		$this->db->where('category_id', $id);
		$this->db->delete('category_master');
	}
	
	
	
}
?>