<?php 
class Mdl_Package_management extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_package_data($rowno,$rowperpage)
	{
		$this->db->select('*');
		$this->db->from('Packages_master ');
		
		if(!empty($_POST['search'])){
			$this->db->like('Package_id', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('packege_status', $_POST['status']);
		}
				
		//if($_POST['is_store'] != ''){
		//	$this->db->where('sn.store_id', $_POST['is_store']);
		//}
		
		//$this->db->join('Store_master AS sn','sn.store_id = pm.store_id','Left');
		$this->db->order_by("created_at", "desc");
		$this->db->limit($rowperpage, $rowno); 
		return $this->db->get()->result();
	}
	
	public function getallrecord_package() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Packages_master');
		
		if(!empty($_POST['search'])){
			$this->db->like('Package_id', $_POST['search']);
		}
		   
		if($_POST['status'] != ''){
			$this->db->where('packege_status', $_POST['status']);
		}
		
		if($_POST['is_store'] != ''){
				$this->db->where('store_id', $_POST['is_store']);
		}
		
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	  
	  function get_all_parent_category(){
		$this->db->select('*');
		$this->db->from('category_master');
		$data = $this->db->where('category_type',2);
		return $this->db->get()->result();
	}
	
	  function get_child_category($parent_id){
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('parent_category', $parent_id);
		$this->db->where('category_status', 1);
		$this->db->where('category_type', 1);
		return $this->db->get()->result();
	}
	
	/*function fetch_store_name(){
				
		$this->db->select('pm.*,sm.store_id,sm.Store_name');
		$this->db->from('Packages_master as pm');
		$this->db->group_by('sm.store_id'); 
		$this->db->join('Store_master AS sm','sm.store_id = pm.store_id','Left');
		return $this->db->get()->result();
	} */
	  
	  // Products Details 
	function Get_Package_details($id){
		  $this->db->select('*');
		$this->db->from('Packages_master');
		$this->db->where('Package_id', $id);
		return $this->db->get()->row();
	}
	function get_tag(){
		$this->db->select('*');
		$this->db->from('tag_master');
		return $this->db->get()->result();
	}  
	function Get_store($id){
		$this->db->select('*');
		$this->db->from('Store_master');		
		$this->db->where('store_id', $id);
		return $this->db->get()->row();
	}

	function Get_item_details($id){
		$this->db->select('pm.Package_id , oim.*');
		$this->db->from('Packages_master as pm');		
		$this->db->where('pm.Package_id', $id);
		$this->db->join('order_item_mastet AS oim','oim.item_id = pm.Package_id','Left');
		
		return $this->db->get()->row();
	}
	
	function Get_order_details($id){
		$this->db->select('oim.order_id , om.*');
		$this->db->from('order_item_mastet as oim');		
		$this->db->where('oim.order_id', $id);
		$this->db->join('Order_master AS om','om.order_id = oim.order_id','Left');
		return $this->db->get()->result();
	}
	
	public function fav_count($id) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Favourit_item_mster');
		$array = array('is_store' => 0, 'type' =>2, 'item_id' => $id);
		$this->db->where($array);			
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	
	public function report_count($id) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Report_abuse_master');
		$array = array('is_store' => 0, 'type' =>2, 'item_id' => $id);
		$this->db->where($array);	
		$query = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
	}
	  
	function Change_Package_status(){
		$data['packege_status'] = $_POST['packege_status'];
		$this->db->where('Package_id',$_POST['Package_id']);
		$this->db->update('Packages_master',$data);
		
	}
	
	function get_order_data($rowno,$rowperpage)
	{
		$this->db->select('
			om.*, 
			um.username,
			um.contact,
			sn.Store_name,
			sn.store_id,
		');
		$this->db->from('Order_master as om');
		$this->db->join('User_master AS um','um.user_id = om.user_id','Left');
		$this->db->join('Store_master AS sn','sn.user_id = om.user_id','Left');
		$this->db->join('order_item_mastet as oim','oim.order_id = om.order_id','Left');
		$this->db->where('oim.item_id',$_POST['Package_id']);
		
		$this->db->limit($rowperpage, $rowno); 
		return $this->db->get()->result();
	}
	public function getallrecord_order() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Order_master as om');
		$this->db->join('order_item_mastet as oim','oim.order_id = om.order_id','Left');
		$this->db->where('oim.item_id',$_POST['Package_id']);
		$query = $this->db->get();
	
		$result = $query->result_array();
	 	return $result[0]['allcount'];
	}
	
	function get_store_data($rowno,$rowperpage)
	{
		$this->db->select('sm.*,');
		$this->db->from('Store_master  as sm');
		$this->db->join('store_Packages_master AS spm','spm.store_id = sm.store_id','Left');
		$this->db->where('spm.Package_id',$_POST['Package_id']);
		
		$this->db->limit($rowperpage2, $rowno2); 
		return $this->db->get()->result();
	}
		
	public function getallrecord_store() 
	{
		$this->db->select('count(*) as allcountstore');
		$this->db->from('Store_master as sm');
		$this->db->join('store_Packages_master as spm','spm.store_id = sm.store_id','Left');
		$this->db->where('spm.Package_id',$_POST['Package_id']);
		$query = $this->db->get();
	
		$result = $query->result_array();
	 	return $result[0]['allcountstore'];
	}
	
	function insert_packege($c_image){


		$data['Package_name']=$_POST['Package_name'];
		$data['packege_price']=$_POST['packege_price'];
		$data['packege_sale_price']=$_POST['packege_sale_price'];
		$data['main_category']= $_POST['main_category'];
		//$data['packege_tage']= $_POST['packege_tage'];
		$data['packege_duration']= $_POST['packege_duration'];
		$data['packege_description']= $_POST['packege_description'];
		$data['packege_excludes']= $_POST['packege_excludes'];
		$data['packege_includes']= $_POST['packege_includes'];
		$data['packege_image']= $c_image;
		$data['packege_status']= 0;
		$data['created_at'] = date("Y-m-d H:i:s");
		$this->db->insert('Packages_master',$data);
		$id = $this->db->insert_id();
		
		$tags = explode(",", $_POST['packege_tage']);
		foreach($tags as $val)
		{
			$data2['item_id'] = $id;
			$data2['tag'] = $val;
			$data2['type'] = 1;
			$data2['teg_type'] = 2;
			$data2['created_at'] = date("Y-m-d H:i:s");
			$this->db->insert('tag_master',$data2);
		}
		
		return $id;
	}
	
		
	function update_package(){
		
		$data['Package_name']=$_POST['Package_name'];
		$data['packege_price']=$_POST['packege_price'];
		$data['packege_sale_price']=$_POST['packege_sale_price'];
		$data['main_category']= $_POST['main_category'];
		
		$data['packege_duration']= $_POST['packege_duration'];
		$data['packege_description']= $_POST['packege_description'];
		$data['packege_excludes']= $_POST['packege_excludes'];
		$data['packege_includes']= $_POST['packege_includes'];
		$data['packege_status']= $_POST['packege_status'];
		$data['show_in_listing']= $_POST['show_in_listing'];
		if($_POST['packege_image']){
			$data['packege_image']= $_POST['packege_image'];
		}
		$data['updated_at'] = date("Y-m-d H:i:s");
		$this->db->where('Package_id',$_POST['Package_id']);
		$this->db->update('Packages_master',$data);
		if(isset($_POST['packege_tage']) != NULL ){
			$this->db->where('item_id',$_POST['Package_id']);
			$this->db->where('type',1);
			$this->db->where('teg_type',2);
			$this->db->delete('tag_master');
			$tags = explode(",", $_POST['packege_tage']);
			
			foreach($tags as $val)
			{
				$data2['item_id'] = $_POST['Package_id'];
				$data2['tag'] = $val;
				$data2['type'] = 1;
				$data2['teg_type'] = 2;
				$data2['created_at'] = date("Y-m-d H:i:s");
				$this->db->insert('tag_master',$data2);
			}
		}
	}
	
	function get_tags($id){
		$this->db->select('*');
		$this->db->from('tag_master');
		$this->db->where('item_id',$id);
		$this->db->where('type',1);
		$this->db->where('teg_type',2);
		return $this->db->get()->result();
	}  
	
	function Package_delete()
	{
		
		// delete from Cart
		$this->db->select('');
		$this->db->from('Cart_item_master as ctm');
		$this->db->join('Cart_master AS cm','cm.`cart_id` = ctm.`cart_id`','Left');
		$this->db->where('ctm.item_id', $_POST['Package_id']);
		$this->db->where('cm.store_type',2);
		$cart = $this->db->get()->result();
		foreach ($cart  as $crt){
			$this->db->where('cart_item_id', $crt->cart_item_id);
			$this->db->delete('Cart_item_master');
		}
		
		// delete packege from store
		$this->db->where('Package_id', $_POST['Package_id']);
		$this->db->delete('store_Packages_master');
	
		//delete from favrouite
		$this->db->where('type',2);
		$this->db->where('is_store',1);
		$this->db->where('item_id',$_POST['Package_id']);
		$this->db->delete('Favourit_item_mster');
		
		//check for order
		$this->db->select('*');
		$this->db->from('booking_item_master');
		$this->db->where('item_id', $_POST['Package_id']);
		$order = $this->db->get()->result();
		
		if ($order == NULL){
			// delete from product table
			$this->db->select('*');
			$this->db->from('Packages_master');
			$this->db->where('Package_id',$_POST['Package_id']);
			$pval = $this->db->get()->row();
			$path = $pval->packege_image;
			if(file_exists($path)) { 
				unlink($path);
				$this->db->where('Package_id',$_POST['Package_id']);
				$this->db->delete('Packages_master');
			}
		}elseif($order != NULL)
		{
			$data['packege_status'] =3;
			$this->db->where('Package_id',$_POST['Package_id']);
			$this->db->update('Packages_master',$data);
		} 	
	redirect('Package_management');
	}
}
?>