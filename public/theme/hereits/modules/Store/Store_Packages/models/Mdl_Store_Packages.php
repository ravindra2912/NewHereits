<?php 
class Mdl_Store_Packages extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
		
	function get_package_data($rowno,$rowperpage)
	{
		$this->db->select('
			pm.Package_id,
			pm.Package_name,
			pm.main_category,
			pm.packege_image,
			pm.packege_status as packege_tb_status,
			spm.packege_sale_price,
			spm.price_type,
			spm.packege_price,
			spm.packege_status,
		
		');
		$this->db->from('Packages_master as pm');
		
		$this->db->join('store_Packages_master AS spm','spm.`Package_id` = pm.`Package_id`','Left');
		$this->db->where('spm.store_id', $this->session->User->store_id);
		
		if(!empty($_POST['search'])){
			$this->db->like('pm.Package_name', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('spm.packege_status', $_POST['status']);
		}
		
		$this->db->limit($rowperpage, $rowno); 
		$this->db->where('spm.store_id', $this->session->User->store_id);
	
		return $this->db->get()->result();
	}
	
	public function getrecordCount_packages() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('Packages_master as pm');
				
		$this->db->join('store_Packages_master AS spm','spm.`Package_id` = pm.`Package_id`','Left');
		$this->db->where('spm.store_id', $this->session->User->store_id);
		
		if(!empty($_POST['search'])){
			$this->db->like('pm.Package_name', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('spm.packege_status', $_POST['status']);
		}
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	
	function get_all_store_packages(){
		$this->db->select('*');
		$this->db->from('store_Packages_master');
		$this->db->where('store_id',$this->session->User->store_id);
		$this->db->group_by('Package_id');
		return $this->db->get()->result();
	}
	
	function active_package_count(){
		$this->db->select('count(*) as allcount');
		$this->db->from('store_Packages_master as spm');
		$this->db->join('Packages_master AS pm','pm.`Package_id` = spm.`Package_id`','Left');
		$this->db->where('spm.store_id', $this->session->User->store_id);
		$this->db->where('spm.packege_status',1);
		$this->db->where('pm.packege_status',1);
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	}
	function getCount_packages(){
		$this->db->select('sm.package_Limit');
		$this->db->from('subscription_master as sm');
		$this->db->join('store_subscription_master AS ssm','ssm.`subscription_id` = sm.`subscription_id`','Left');
		$this->db->where('ssm.store_id',$this->session->User->store_id);
		$this->db->where('ssm.status',1);
		return $this->db->get()->row();
	}
	function get_all_parent_category(){
		$this->db->select('scm.*, cm.category_name, cm.category_image');
		$this->db->from('Store_category_master as scm');
		$this->db->join('category_master AS cm','cm.`category_id` = scm.`category_id`','Left');
		$data = $this->db->where('scm.store_id',$this->session->User->store_id);
		$data = $this->db->where('cm.category_type',2);
		return $this->db->get()->result();
	}
	
	function ajax_search_package(){
		$this->db->select('pm.* ');
		$this->db->from('Packages_master as pm');
		//$this->db->join('store_Packages_master AS spm','spm.Package_id = pm.Package_id','Left');
		//$this->db->where('spm.Package_id IS NULL');
		$this->db->like('pm.Package_name',$_POST['search']);
		$this->db->where('pm.main_category',$_POST['package_parent_category']);
		$this->db->where('pm.packege_status',1);
		$this->db->where('pm.show_in_listing',1);
		$this->db->group_by('pm.Package_id');
	
		return $this->db->get()->result();
	}
	
	function get_single_Package($id){
		$this->db->select('*');
		$this->db->from('Packages_master');
		//$this->db->where('store_id', $this->session->User->store_id);
		$this->db->where('Package_id', $id);
		return $this->db->get()->row();
	}

	function category_name($id){
		$this->db->select('pm.*,cm.category_name');
		$this->db->from('Packages_master as pm');
		$this->db->join('category_master AS cm','cm.`category_id` = pm.`main_category`','Left');
		$this->db->where('pm.Package_id', $id);	
		return $this->db->get()->row();		
	}
	
	function get_single_store_Package($id){
		$this->db->select('*');
		$this->db->from('store_Packages_master');
		$this->db->where('store_id', $this->session->User->store_id);
		$this->db->where('Package_id', $id);
		return $this->db->get()->row();
	}
	
	function single_store_Package($id){
		$this->db->select('spm.* , pm.Package_name , pm.packege_image');
		$this->db->from('store_Packages_master as spm');
		$this->db->join('Packages_master AS pm','pm.`Package_id` = spm.`Package_id`','Left');
		$this->db->where('store_id', $this->session->User->store_id);
		$this->db->where('spm.Package_id', $id);
		return $this->db->get()->row();
	}
	
	function get_tag(){
		$this->db->select('*');
		$this->db->from('tag_master');
		return $this->db->get()->result();
	}
	function insert_package($img){

		$this->db->select('*');
		$this->db->from('category_master');
		$this->db->where('category_id', $_POST['main_category']);
		$cat = $this->db->get()->row();
		
		if($cat->approval_required != 1){
			$data['packege_status'] = 1;
		}
		
		$data['request_store_id'] = $this->session->User->store_id;
		$data['Package_name'] = $_POST['Package_name'];
		$data['packege_duration'] = $_POST['packege_duration'];
		$data['main_category'] = $_POST['main_category'];
		if($_POST['packege_price'] != NULL && $_POST['packege_sale_price'] != NULL ){
			$data['packege_price'] = $_POST['packege_price'];
			$data['packege_sale_price'] = $_POST['packege_sale_price'];
		}elseif($_POST['maximum_packege_price'] != NULL && $_POST['minimum_packege_price'] != NULL ){
			$data['packege_price'] = $_POST['maximum_packege_price'];
			$data['packege_sale_price'] = $_POST['minimum_packege_price'];
		}  
		//$data['packege_tage'] = $_POST['packege_tage'];
		$data['packege_description'] = $_POST['packege_description'];
		$data['packege_excludes'] = $_POST['packege_excludes'];
		$data['packege_includes'] = $_POST['packege_includes'];
		$data['packege_image'] = $img;
		$data['created_at'] = date("Y-m-d H:i:s");
		$data['updated_at'] = date("Y-m-d H:i:s");
		$this->db->insert('Packages_master',$data);
	    $pid = $this->db->insert_id();
		
		$data1['store_id'] = $this->session->User->store_id;
		$data1['Package_id'] = $pid;
		$data1['packege_duration'] = $_POST['packege_duration'];
		$data1['price_type'] = $_POST['price_type'];
		if($_POST['price_type'] == 1){
			$data1['packege_price'] = $_POST['packege_price'];
			$data1['packege_sale_price'] = $_POST['packege_sale_price'];
		}elseif($_POST['price_type'] == 2){
			$data1['packege_price'] = $_POST['maximum_packege_price'];
			$data1['packege_sale_price'] = $_POST['minimum_packege_price'];
		}  
		$data1['packege_description'] = $_POST['packege_description'];
		$data1['packege_excludes'] = $_POST['packege_excludes'];
		$data1['packege_includes'] = $_POST['packege_includes'];
		$data1['created_at'] = date("Y-m-d H:i:s");
		$this->db->insert('store_Packages_master',$data1);

		//set product tags
		$tags = explode(",", $_POST['packege_tage']);
		foreach($tags as $val){
			$t['item_id'] = $pid;
			$t['tag'] = $val;
			$t['type'] = 1;
			$t['teg_type'] = 2;
			$t['created_at'] = date("Y-m-d H:i:s");
			$this->db->insert('tag_master',$t);
		}
		
		return $pid;
	
	}
	
	function submit_to_list(){
	
		$data['store_id'] = $this->session->User->store_id;
		$data['Package_id'] = $_POST['Package_id'];
		$data['price_type'] = $_POST['price_type'];
		if($_POST['price_type'] == 1){
			$data['packege_price'] = $_POST['packege_price'];
			$data['packege_sale_price'] = $_POST['packege_sale_price'];
		}elseif($_POST['price_type'] == 2){
			$data['packege_price'] = $_POST['maximum_packege_price'];
			$data['packege_sale_price'] = $_POST['minimum_packege_price'];
		}  
		$data['packege_duration'] = $_POST['packege_duration'];
		$data['packege_description'] = $_POST['Package_description'];
		$data['packege_includes'] = $_POST['packege_includes'];
		$data['packege_excludes'] = $_POST['packege_excludes'];
		$data['created_at'] = date("Y-m-d H:i:s");
		$data['updated_at'] = date("Y-m-d H:i:s");
		$this->db->insert('store_Packages_master',$data);
		
		return $this->db->insert_id();
	}
	
	
	function update_package(){
		$data['packege_duration'] = $_POST['packege_duration'];
		$data['price_type'] = $_POST['price_type'];
		if($_POST['price_type'] == 1){
			$data['packege_price'] = $_POST['packege_price'];
			$data['packege_sale_price'] = $_POST['packege_sale_price'];
		}elseif($_POST['price_type'] == 2){
			$data['packege_price'] = $_POST['maximum_packege_price'];
			$data['packege_sale_price'] = $_POST['minimum_packege_price'];
		}  
		$data['packege_description'] = $_POST['packege_description'];
		$data['packege_excludes'] = $_POST['packege_excludes'];
		$data['packege_includes'] = $_POST['packege_includes'];
		$data['packege_status'] = $_POST['packege_status'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		$this->db->where('store_id',$this->session->User->store_id);
		$this->db->where('Package_id',$_POST['Package_id']);
		$this->db->update('store_Packages_master',$data);
		
		
	}
	  
	function delete_package($id)
	{ 
	   //delete record
		$this->db->where('Package_id', $_POST['Package_id']);
		$this->db->where('store_id', $this->session->User->store_id);
		$this->db->delete('store_Packages_master');
				
				
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
		
		$this->db->select('*');
		$this->db->from('store_Packages_master');
		$this->db->where('Package_id', $_POST['Package_id']);
		$pid=$this->db->get()->result();
		
		if($pid == NULL)
		{
			$this->db->select('*');
			$this->db->from('Packages_master as pm');
			$this->db->join('category_master AS cm','cm.`category_id` = pm.`main_category`','Left');
			$this->db->where('pm.Package_id', $_POST['Package_id']);
			$this->db->where('cm.approval_required', 0 );
			$product = $this->db->get()->row();
			
			if($product != NULL ){
						
				$this->db->select('*');
				$this->db->from('store_Packages_master');
				$this->db->where('Package_id', $_POST['Package_id']);
				$pim = $this->db->get()->result();
				
				$path = $res->packege_image;
				if(file_exists($path)) { unlink($path); }
				
				$this->db->where('Package_id', $_POST['Package_id']);
				$this->db->delete('Packages_master');
					
				}	
			}
			
		}
		
		
		
		
	}

?>