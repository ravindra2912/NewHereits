<?php 
class Mdl_Store_products extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function ajax_search_product($rowno,$rowperpage){ 
		$this->db->select('pm.* ');
		$this->db->from('product_master as pm');
		$this->db->like('pm.product_name',$_POST['search']);
		$this->db->where('pm.product_parent_category',$_POST['store_parent_category']);
		$this->db->where('pm.product_status',1);
		$this->db->where('pm.show_in_listing',1);
		//$this->db->group_by('pm.product_id');
		$this->db->limit($rowperpage, $rowno); 
		return $this->db->get()->result();
	}
	public function ajax_search_product_Count() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('product_master');
		$this->db->like('product_name',$_POST['search']);
		$this->db->where('product_parent_category',$_POST['store_parent_category']);
		$this->db->where('product_status',1);
		$this->db->where('show_in_listing',1);
		//$this->db->group_by('product_id');
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	
	function get_all_store_product(){
		$this->db->select('pm.* ');
		$this->db->from('store_product_master as pm');
		$this->db->where('pm.store_id',$this->session->User->store_id);
		$this->db->group_by('pm.product_id');
		return $this->db->get()->result();
	}
	
	function product_limit(){
		$this->db->select('sm.Product_Limit');
		$this->db->from('subscription_master as sm');
		$this->db->join('store_subscription_master AS ssm','ssm.`subscription_id` = sm.`subscription_id`','Left');
		$this->db->where('ssm.store_id',$this->session->User->store_id);
		$this->db->where('ssm.status',1);
		return $this->db->get()->row();
	}
	public function getCount_product() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('store_product_master as spm');
		$this->db->join('product_master AS pm','pm.`product_id` = spm.`product_id`','Left');
		$this->db->where('spm.store_id', $this->session->User->store_id);
		$this->db->where('pm.product_status', 1);
		$this->db->where('spm.product_status', 1);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	function submit_to_list(){
		$data['store_id'] = $this->session->User->store_id;
		$data['product_id'] = $_POST['product_id'];
		$data['price_type'] = $_POST['price_type'];
		if($_POST['price_type'] == 1){
			$data['product_price'] = $_POST['product_price'];
			$data['product_sele_price'] = $_POST['product_sele_price'];
		}elseif($_POST['price_type'] == 2){
			$data['product_price'] = $_POST['maximum_product_price'];
			$data['product_sele_price'] = $_POST['minimum_product_price'];
		}
		$data['product_qty'] = $_POST['product_qty'];
		$data['brand_name'] = $_POST['brand_name'];
		$data['selling_unit'] = $_POST['selling_unit'];
		$data['selling_unit_qty'] = $_POST['selling_unit_qty'];
		if(isset($_POST['product_price_hide'])){
			$data['product_price_hide'] = $_POST['product_price_hide'];
		}
		$data['product_description'] = $_POST['product_description'];
		$data['created_at'] = date("Y-m-d H:i:s");
		$data['updated_at'] = date("Y-m-d H:i:s");
		$this->db->insert('store_product_master',$data);
		
		return $this->db->insert_id();
	}
	
	function submit_update_list(){
		
		$data['price_type'] = $_POST['price_type'];
		if($_POST['price_type'] == 1){
			$data['product_price'] = $_POST['product_price'];
			$data['product_sele_price'] = $_POST['product_sele_price'];
		}elseif($_POST['price_type'] == 2){
			$data['product_price'] = $_POST['maximum_product_price'];
			$data['product_sele_price'] = $_POST['minimum_product_price'];
		}
		$data['product_qty'] = $_POST['product_qty'];
		$data['brand_name'] = $_POST['brand_name'];
		if(isset($_POST['product_price_hide'])){
			$data['product_price_hide'] = $_POST['product_price_hide'];
		}else{
			$data['product_price_hide'] = 0;
		}
		$data['product_description'] = $_POST['product_description'];
		if(isset($_POST['selling_unit'])){
			$data['selling_unit']= $_POST['selling_unit'];
		}
		$data['selling_unit_qty'] = $_POST['selling_unit_qty'];
		$data['product_status'] = $_POST['product_status'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		$this->db->where('store_id',$this->session->User->store_id);
		$this->db->where('product_id',$_POST['product_id']);
		$this->db->update('store_product_master',$data);
	}
	
	function get_all_parent_category(){
		$this->db->select('scm.*, cm.category_name, cm.category_image');
		$this->db->from('Store_category_master as scm');
		$this->db->join('category_master AS cm','cm.`category_id` = scm.`category_id`','Left');
		$data = $this->db->where('scm.store_id',$this->session->User->store_id);
		$data = $this->db->where('cm.category_type',1);
		return $this->db->get()->result();
	}
	
	function get_child_category($parent_id){
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('parent_category', $parent_id);
		$this->db->where('category_status', 1);
		$this->db->where('category_type', $this->session->User->store_type);
		return $this->db->get()->result();
	}
	
	function get_single_product($product_id){
		$this->db->select('*');
		$this->db->from('product_master');
		$this->db->where('product_id', $product_id);
		return $this->db->get()->row();
	}
	
	function get_single_store_product($product_id){
		$this->db->select('
			pm.product_name,
			pm.fixed_selling_unit,
			pm.brand_fixed,
			spm.*,
		
		');
		$this->db->from(' store_product_master as spm');
		
		$this->db->join('product_master AS pm','pm.`product_id` = spm.`product_id`','Left');
		$this->db->where('spm.store_id', $this->session->User->store_id);
		$this->db->where('spm.product_id', $product_id);
		
		 
		
		return $this->db->get()->row();
	}
	
	function get_product_single_image($product_id){
		$this->db->select('*');
		$this->db->from('product_image_master');
		$this->db->where('product_id', $product_id);
		$this->db->order_by("image_order", "asc");
		return $this->db->get()->row();
	}
	
	function get_single_product_img($id){
		$this->db->select('*');
		$this->db->from('product_image_master');
		$this->db->where('id', $id);
		return $this->db->get()->row();
	}
	
	function product_images($product_id){
		$this->db->select('*');
		$this->db->from('product_image_master');
		$this->db->where('product_id', $product_id);
		return $this->db->get()->result();
	}
	
	function category_name($id){
		$this->db->select('
			pm.*,
			cm.category_name,
			');
		$this->db->from('product_master as pm');
		$this->db->join('category_master AS cm','cm.`category_id` = pm.`product_parent_category`','Left');
		$this->db->where('pm.product_id', $id);	
		return $this->db->get()->row();		
	}
	
	function get_product_data($rowno,$rowperpage)
	{
		$this->db->select('
			pm.product_id,
			pm.product_name,
			pm.product_status as product_tb_status,
			spm.product_qty,
			spm.product_price,
			spm.product_sele_price,
			spm.price_type,
			spm.product_status,
			spm.selling_unit,
			spm.selling_unit_qty,
		
		');
		$this->db->from('product_master as pm');
		//$this->db->where('pm.product_status', 1);
		
		$this->db->join('store_product_master AS spm','spm.`product_id` = pm.`product_id`','Left');
		$this->db->where('spm.store_id', $this->session->User->store_id);
		
		if(!empty($_POST['search'])){
			$this->db->like('pm.product_name', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('spm.product_status', $_POST['status']);
		}
		
		$this->db->limit($rowperpage, $rowno); 
		
		return $this->db->get()->result();
	}
	
	public function getrecordCount_product() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('product_master as pm');
		//$this->db->where('pm.product_status', 1);
		
		$this->db->join('store_product_master AS spm','spm.`product_id` = pm.`product_id`','Left');
		$this->db->where('spm.store_id', $this->session->User->store_id);
		
		if(!empty($_POST['search'])){
			$this->db->like('pm.product_name', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('spm.product_status', $_POST['status']);
		}
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	
	  
	function get_tag(){
		$this->db->select('*');
		$this->db->from('tag_master');
		return $this->db->get()->result();
	}
	  
	function insert_product(){
		
		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('category_id', $_POST['product_parent_category']);
		$cat = $this->db->get()->row();
		
		if($cat->approval_required != 1){
			$data['product_status'] = 1;
		}
		$data['request_store_id'] = $this->session->User->store_id;
		$data['product_name'] = $_POST['product_name'];
		
		if($_POST['price_type'] == 1){
			$data['product_price'] = $_POST['product_price'];
			$data['product_sele_price'] = $_POST['product_sele_price'];
		}elseif($_POST['price_type'] == 2){
			$data['product_price'] = $_POST['maximum_product_price'];
			$data['product_sele_price'] = $_POST['minimum_product_price'];
		}
		$data['product_parent_category'] = $_POST['product_parent_category'];
		$data['selling_unit'] = $_POST['selling_unit'];
		$data['selling_unit_qty'] = $_POST['selling_unit_qty'];
		$data['brand_name'] = $_POST['brand_name'];
		$data['product_description'] = $_POST['product_description'];
		$data['created_at'] =  date("Y-m-d H:i:s");
		$data['updated_at'] =  date("Y-m-d H:i:s");
		$this->db->insert('product_master',$data);
		
		$pid = $this->db->insert_id();
		
		$data1['store_id'] = $this->session->User->store_id;
		$data1['product_id'] = $pid;
		$data1['price_type'] = $_POST['price_type'];
		if($_POST['price_type'] == 1){
			$data1['product_price'] = $_POST['product_price'];
			$data1['product_sele_price'] = $_POST['product_sele_price'];
		}elseif($_POST['price_type'] == 2){
			$data1['product_price'] = $_POST['maximum_product_price'];
			$data1['product_sele_price'] = $_POST['minimum_product_price'];
		}
		$data1['product_description'] = $_POST['product_description'];
		$data1['product_qty'] = $_POST['product_qty'];
		$data1['selling_unit'] = $_POST['selling_unit'];
		$data1['selling_unit_qty'] = $_POST['selling_unit_qty'];
		$data1['brand_name'] = $_POST['brand_name'];
		$data1['product_status'] = 0;
		$data1['created_at'] = date("Y-m-d H:i:s");
		$data1['updated_at'] = date("Y-m-d H:i:s");
		$this->db->insert('store_product_master',$data1);
		
		
		//set product tags
		$tags = explode(",", $_POST['tags']);
		foreach($tags as $val){
			$t['item_id'] = $pid;
			$t['tag'] = $val;
			$t['type'] = 1;
			$t['teg_type'] = 1;
			$t['created_at'] = date("Y-m-d H:i:s");
			$this->db->insert('tag_master',$t);
		}
		
		return $pid;
		
	}
	
	function get_product_images(){
		$this->db->select('*');
		$this->db->where('product_id', $_POST['product_id']);
		$this->db->order_by("image_order", "asc");
		$this->db->from('product_image_master');
		return $this->db->get()->result();
	}	
	
	function get_product_images_count(){
		$this->db->select('count(*) as allcount');
		$this->db->from('product_image_master');
		$this->db->where('product_id', $_POST['product_id']);
		$query = $this->db->get();
		$result = $query->result_array();
		return (int)$result[0]['allcount'];
	}
	
	function insert_product_images($img){
		$data['product_id'] = $_POST['product_id'];
		$data['image_url'] = $img;
		$data['created_at'] = date("Y-m-d H:i:s");
		$this->db->insert('product_image_master',$data);
	}
	
	function get_product_img()	{
		$this->db->select('*');
		$this->db->from('product_image_master');
		$this->db->where('id',$_POST['id']);
		return $this->db->get()->row();
	}
	
	function chnage_product_image_order(){
		$data['image_order'] = $_POST['order'];
		$this->db->where('id',$_POST['id']);
		$this->db->update('product_image_master',$data);
	}
	
	 function delete_product(){
		 
		
		//delete product record
		$this->db->where('store_id', $this->session->User->store_id);
		$this->db->where('product_id', $_POST['product_id']);
		$this->db->delete('store_product_master');
		
		//delete record from user cart
		$this->db->select('');
		$this->db->from('Cart_item_master as ctm');
		$this->db->join('Cart_master AS cm','cm.`cart_id` = ctm.`cart_id`','Left');
		$this->db->where('ctm.item_id', $_POST['product_id']);
		$this->db->where('cm.store_type',1);
		$cart = $this->db->get()->result();
		
		foreach ($cart  as $crt){
			$this->db->where('cart_item_id', $crt->cart_item_id);
			$this->db->delete('Cart_item_master');
			}
		
		
		
		// delete permenent 
		$this->db->select('*');
		$this->db->from('store_product_master');
		$this->db->where('product_id', $_POST['product_id']);
		$store = $this->db->get()->result();
		if($store == NULL)
		{
			$this->db->select('*');
			$this->db->from('product_master as pm');
			$this->db->join('category_master AS cm','cm.`category_id` = pm.`product_parent_category`','Left');
			$this->db->where('pm.product_id', $_POST['product_id']);
			$this->db->where('cm.approval_required', 0 );
			$product = $this->db->get()->row();
			
			if($product != NULL ){
				
				$this->db->where('product_id', $_POST['product_id']);
				$this->db->delete('product_master');
				
				$this->db->select('*');
				$this->db->from('product_image_master');
				$this->db->where('product_id', $_POST['product_id']);
				$pim = $this->db->get()->result();
				
				foreach($pim as $pval){
					//delete image
					$path = $pval->image_url;
					if(file_exists($path)) { unlink($path); }
					
					$this->db->where('id', $pval->id);
					$this->db->delete('product_image_master');
				}	
			}
			
		}
			
	 }
	  
	 
}
?>