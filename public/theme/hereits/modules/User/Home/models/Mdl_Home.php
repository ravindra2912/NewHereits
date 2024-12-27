<?php 
class Mdl_Home extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_categores($type){
		if($type == 1){
			$this->db->select('cm.*');
			$this->db->from('category_master as cm');
			
			$this->db->join('product_master AS pm','pm.product_parent_category = cm.category_id','Left');
			$this->db->join('store_product_master AS spm','spm.product_id = pm.product_id','Left');
			$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
			
			//check subscription
			$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
			$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
			$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
			$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
			$this->db->where('ssm.status ', 1);
			
			$this->db->where('spm.product_status', 1);
			$this->db->where('pm.product_status', 1);
			$this->db->where('sm.store_status', 1);
			$this->db->where('sm.city', $_COOKIE['city']);
			
			$this->db->where('cm.parent_category', NULL);
			$this->db->where('cm.category_type', $type);
			$this->db->where('cm.category_status', 1);
			$this->db->order_by("cm.order", "ASC");
			$this->db->group_by("cm.category_id");
			return $this->db->get()->result();
		} else if($type == 2){
			$this->db->select('cm.*');
			$this->db->from('category_master as cm');
			
			$this->db->join('Packages_master AS pm','pm.main_category = cm.category_id','Left');
			$this->db->join('store_Packages_master AS spm','spm.Package_id = pm.Package_id','Left');
			$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
			
			//check subscription
			$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
			$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
			$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
			$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
			$this->db->where('ssm.status ', 1);
			
			$this->db->where('spm.packege_status', 1);
			$this->db->where('pm.packege_status', 1);
			$this->db->where('sm.store_status', 1);
			$this->db->where('sm.city', $_COOKIE['city']);
			
			$this->db->where('cm.parent_category', NULL);
			$this->db->where('cm.category_type', $type);
			$this->db->where('cm.category_status', 1);
			$this->db->order_by("cm.order", "ASC");
			$this->db->group_by("cm.category_id");
			return $this->db->get()->result();
		}
		
	}
	
	function ajax_get_stores($offset,$limit)
	{
		$this->db->select('sm.*');
		$this->db->from('Store_master as sm');
		
		//check subscription
		$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
		$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		
		$this->db->group_by('sm.store_id');
		$this->db->where('sm.city', $_COOKIE['city']);
		$this->db->order_by('rand()');
		$this->db->limit($limit, $offset); 
		$this->db->where('sm.store_status', 1);
		return $this->db->get()->result();
	}
	
	function ajax_get_products($offset,$limit)
	{
		$this->db->select('pm.product_name, spm.*, sm.Store_name, sm.store_contact, cm.category_name');
		$this->db->from('store_product_master as spm');
		
		
		$this->db->join('product_master AS pm','pm.product_id = spm.product_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
		
		//check subscription
		$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
		$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		
		
		$this->db->join('category_master AS cm','cm.category_id = pm.product_parent_category','Left');
		
		$this->db->limit($limit, $offset); 
		$this->db->where('spm.product_status', 1);
		$this->db->where('pm.product_status', 1);
		$this->db->where('sm.store_status', 1);
		$this->db->where('sm.city', $_COOKIE['city']);
		$this->db->order_by('rand()');
		
		return $this->db->get()->result();
	}
	function get_product_single_image($product_id){
		$this->db->select('*');
		$this->db->from('product_image_master');
		$this->db->where('product_id', $product_id);
		$this->db->order_by("image_order", "asc");
		return $this->db->get()->row();
	}
	
	function ajax_get_services($offset,$limit)
	{
		$this->db->select('spm.*, pm.Package_name, pm.packege_image, spm.store_id, sm.store_contact, sm.Store_name');
		$this->db->from('store_Packages_master as spm');
		
		
		$this->db->join('Packages_master AS pm','pm.Package_id = spm.Package_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
		
		//check subscription
		$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
		$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		
		
		
		$this->db->limit($limit, $offset); 
		$this->db->where('spm.packege_status', 1);
		$this->db->where('pm.packege_status', 1);
		$this->db->where('sm.store_status', 1);
		$this->db->where('sm.city', $_COOKIE['city']);
		$this->db->order_by('rand()');
		
		return $this->db->get()->result();
	}
	
	// ================= Search =====================================
	
	function get_search_result(){
		$this->db->select('*');
		$this->db->from('tag_master');
		$this->db->like('tag', $_POST['search']);
		$this->db->where('type !=', 3);
		$this->db->limit(10);
		return $this->db->get()->result();
	}
	
	
}
?>