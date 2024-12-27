<?php 
class Mdl_Product_management extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	function get_Product_data($rowno,$rowperpage)
	{
		$this->db->select('pm.* ,sn.Store_name');
		$this->db->from('product_master as pm');
		
		if(!empty($_POST['search'])){
			$this->db->like('pm.product_id', $_POST['search']);
			$this->db->or_like('pm.product_name', $_POST['search']);
			$this->db->or_like('sn.Store_name', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('pm.product_status', $_POST['status']);
		}
				
		$this->db->join('Store_master AS sn','sn.store_id = pm.request_store_id','Left');
		$this->db->order_by("pm.created_at", "desc");
		$this->db->limit($rowperpage, $rowno); 
		return $this->db->get()->result();
	}
	
	public function getallrecord_product() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('product_master');
		
		if(!empty($_POST['search'])){
			$this->db->like('product_id', $_POST['search']);
			$this->db->or_like('product_name', $_POST['search']);
		}
		   
		if($_POST['status'] != ''){
			$this->db->where('product_status', $_POST['status']);
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
		$data = $this->db->where('category_type',1);
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
		$this->db->from('product_master as pm');
		$this->db->group_by('sm.store_id'); 
		$this->db->join('Store_master AS sm','sm.store_id = pm.store_id','Left');
		return $this->db->get()->result();
	} */
	  
	  // Products Details 
	  
	function get_tag(){
		$this->db->select('*');
		$this->db->from('tag_master');
		return $this->db->get()->result();
	}  
	function Get_Product_details($id){
		  $this->db->select('*');
		$this->db->from('product_master');
		$this->db->where('product_id', $id);
		return $this->db->get()->row();
	}
	
	function Get_store($id){
		$this->db->select('*');
		$this->db->from('Store_master');		
		$this->db->where('store_id', $id);
		return $this->db->get()->row();
	}
		 
	function Get_product_img($product_id){
		$this->db->select('*');
		$this->db->from('product_image_master');		
		$this->db->where('product_id', $product_id);
		return $this->db->get()->row();
	}
	function Get_allproduct_img($product_id){
		$this->db->select('*');
		$this->db->from('product_image_master');		
		$this->db->where('product_id', $product_id);
		return $this->db->get()->result();
	}
	
	function Get_item_details($id){
		$this->db->select('pm.product_id , oim.*');
		$this->db->from('product_master as pm');		
		$this->db->where('pm.product_id', $id);
		$this->db->join('order_item_mastet AS oim','oim.item_id = pm.product_id','Left');
		
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
		$array = array('is_store' => 0, 'type' =>1, 'item_id' => $id);
		$this->db->where($array);			
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	
	public function report_count($id) 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Report_abuse_master');
		$array = array('is_store' => 0, 'type' =>1, 'item_id' => $id);
		$this->db->where($array);	
		$query = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
	}
	  
	function Change_product_status(){
		$data['product_status'] = $_POST['product_status'];
		$this->db->where('product_id',$_POST['product_id']);
		$this->db->update('product_master',$data);
		
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
		$this->db->where('oim.item_id',$_POST['product_id']);
		
		$this->db->limit($rowperpage, $rowno); 
		return $this->db->get()->result();
	}
	public function getallrecord_order() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Order_master as om');
		$this->db->join('order_item_mastet as oim','oim.order_id = om.order_id','Left');
		$this->db->where('oim.item_id',$_POST['product_id']);
		$query = $this->db->get();
	
		$result = $query->result_array();
	 	return $result[0]['allcount'];
	}
	
	function get_store_data($rowno,$rowperpage)
	{
		$this->db->select('sm.*,');
		$this->db->from('Store_master  as sm');
		$this->db->join('store_product_master AS spm','spm.store_id = sm.store_id','Left');
		$this->db->where('spm.product_id',$_POST['product_id']);
		
		$this->db->limit($rowperpage2, $rowno2); 
		return $this->db->get()->result();
	}
		
	public function getallrecord_store() 
	{
		$this->db->select('count(*) as allcountstore');
		$this->db->from('Store_master as sm');
		$this->db->join('store_product_master as spm','spm.store_id = sm.store_id','Left');
		$this->db->where('spm.product_id',$_POST['product_id']);
		$query = $this->db->get();
	
		$result = $query->result_array();
	 	return $result[0]['allcountstore'];
	}
	
	function insert_product(){
		
		$data['product_name']=$_POST['product_name'];
		$data['product_price']=$_POST['product_price'];
		$data['product_sele_price']=$_POST['product_sele_price'];
		$data['product_parent_category']= $_POST['product_parent_category'];
		$data['product_child_category']= $_POST['product_child_category'];
		$data['brand_name']= $_POST['brand_name'];
		$data['selling_unit']= $_POST['selling_unit'];
		$data['selling_unit_qty']= $_POST['selling_unit_qty'];
		$data['fixed_selling_unit']= $_POST['fixed_selling_unit'];
		$data['brand_fixed']= $_POST['brand_fixed'];
		$data['product_description']= $_POST['product_description'];
		$data['product_status']= 0;
		
		$data['created_at'] = date("Y-m-d H:i:s");
		$this->db->insert('product_master',$data);
		$id = $this->db->insert_id();
		
		$tags = explode(",", $_POST['product_tag']);
		foreach($tags as $val)
		{
			$data2['item_id'] = $id;
			$data2['tag'] = $val;
			$data2['type'] = 1;
			$data2['teg_type'] = 1;
			$data2['created_at'] = date("Y-m-d H:i:s");
			$this->db->insert('tag_master',$data2);
		}
		
		return $id;
	}
	
		
	function update_product(){
	
	
		$data['product_name']=$_POST['product_name'];
		$data['product_price']=$_POST['product_price'];
		$data['product_sele_price']=$_POST['product_sele_price'];
		$data['product_parent_category']= $_POST['product_parent_category'];
		$data['product_child_category']= $_POST['product_child_category'];
		$data['brand_name']= $_POST['brand_name'];
		$data['product_description']= $_POST['product_description'];
		$data['product_status']= $_POST['product_status'];
		$data['selling_unit']= $_POST['selling_unit'];
		$data['brand_fixed']= $_POST['brand_fixed'];
		$data['selling_unit_qty']= $_POST['selling_unit_qty'];
		$data['fixed_selling_unit']= $_POST['fixed_selling_unit'];
		$data['show_in_listing']= $_POST['show_in_listing'];
		$data['updated_at'] = date("Y-m-d H:i:s");
				
		$this->db->where('product_id',$_POST['product_id']);
		$this->db->update('product_master',$data);
		
		if($_POST['fixed_selling_unit'] == 1)
		{
			$data3['selling_unit']= $_POST['selling_unit'];
			$data3['selling_unit_qty']= $_POST['selling_unit_qty'];
			$this->db->where('product_id',$_POST['product_id']);
			$this->db->update('store_product_master',$data3);
		}
		if(isset($_POST['product_tag']) != NULL ){
			$this->db->where('item_id',$_POST['product_id']);
			$this->db->where('teg_type',1);
			$this->db->where('type',1);
			$this->db->delete('tag_master');
			$tags = explode(",", $_POST['product_tag']);
			
			foreach($tags as $val)
			{
				$data2['item_id'] = $_POST['product_id'];
				$data2['tag'] = $val;
				$data2['type'] = 1;
				$data2['teg_type'] = 1;
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
		$this->db->where('teg_type',1);
		return $this->db->get()->result();
	}
	
	function get_product_images(){
		$this->db->select('*');
		
		if(isset($_POST['product_id']) != NULL ){
			$this->db->where('product_id', $_POST['product_id']);
		}else{
			$this->db->where('product_id', 'store-'.$this->session->User->store_id);
		}
		$this->db->order_by("image_order", "asc");
		$this->db->from('product_image_master');
		return $this->db->get()->result();
	}
	
	function get_single_product_img($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$this->db->from('product_image_master');
		return $this->db->get()->row();
	}  
	  
	function insert_product_images($img){
		$data['product_id'] = $_POST['product_id'];
		$data['image_url'] = $img;
		$this->db->insert('product_image_master',$data);
	}
	
	function chnage_product_image_order(){
		$data['image_order'] = $_POST['order'];
		$this->db->where('id',$_POST['id']);
		$this->db->update('product_image_master',$data);
	}
	
	function Product_delete($id){
		
				
		// delete from Cart
		$this->db->select('');
		$this->db->from('Cart_item_master as ctm');
		$this->db->join('Cart_master AS cm','cm.`cart_id` = ctm.`cart_id`','Left');
		$this->db->where('ctm.item_id', $id);
		$this->db->where('cm.store_type',1);
		$cart = $this->db->get()->result();
		foreach ($cart  as $crt){
			$this->db->where('cart_item_id', $crt->cart_item_id);
			$this->db->delete('Cart_item_master');
		}
		
		// delete product from store

		$this->db->where('product_id', $id);
		$this->db->delete('store_product_master');
		
		
		// delete from favrouit
		$this->db->where('type',1);
		$this->db->where('is_store',1);
		$this->db->where('item_id',$id);
		$this->db->delete('Favourit_item_mster');
		
		//Check for order
		$this->db->select('*');
		$this->db->from('order_item_mastet');
		$this->db->where('item_id', $id);
		$this->db->where('type', 1);
		$order = $this->db->get()->result();
		
		if ($order == NULL)
		{
			$this->db->select('*');
			$this->db->from('product_image_master');
			$this->db->where('product_id', $id);
			$pim = $this->db->get()->result();
				

				foreach($pim as $pval){
				//delete image
				$path = $pval->image_url;
				if(file_exists($path)) { unlink($path); }
						
						$this->db->where('id', $pval->id);
						$this->db->delete('product_image_master');
					}
				// delete from product table
				$this->db->where('product_id',$id);
				$this->db->delete('product_master');
		}elseif ($order != NULL){
			$update['product_status'] = 3;
			$this->db->where('product_id',$id);
			$this->db->update('product_master',$update);
		}		
	}
}
?>