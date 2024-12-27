<?php 
class Mdl_Services extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function ajax_get_services($offset,$limit)
	{
		$this->db->select('spm.*, pm.Package_name, pm.packege_image, spm.store_id, sm.store_name');
		$this->db->from('store_Packages_master as spm');
		
		
		$this->db->join('Packages_master AS pm','pm.Package_id = spm.Package_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
		
		//check subscription
		$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
		$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		
		if($_POST['category'] != ''){
			$this->db->where('pm.main_category', $_POST['category']);
		}
		
		if($_POST['search'] != ''){
			$this->db->join('tag_master as tm', 'tm.item_id = spm.Package_id','left');
			$this->db->where('tm.tag ', $_POST['search'] );
			$this->db->where('tm.teg_type ', 2);
			$this->db->where('tm.type ', 1);
		}
		
		$this->db->limit($limit, $offset); 
		$this->db->where('spm.packege_status', 1);
		$this->db->where('pm.packege_status', 1);
		$this->db->where('sm.store_status', 1);
		$this->db->where('sm.city', $_COOKIE['city']);
		
		//sort product
		if($_POST['sort_by'] == 1){
			//Popularity
		}else if($_POST['sort_by'] == 2){
			//Location
		}else if($_POST['sort_by'] == 3){
			//Newest First
			$this->db->order_by("pm.created_at", "DESC");
		}else if($_POST['sort_by'] == 4){
			//Rating
		}else if($_POST['sort_by'] == 5){
			//Price: Low to High
			$this->db->order_by("spm.packege_sale_price", "asc");
		}else if($_POST['sort_by'] == 6){
			//Price: High to Low
			$this->db->order_by("spm.packege_sale_price", "desc");
		}
		return $this->db->get()->result();
	}
	
	public function getrecordCount_ajax_services() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('store_Packages_master as spm');
		
		
		$this->db->join('Packages_master AS pm','pm.Package_id = spm.Package_id','Left');
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
		
		if($_POST['category'] != ''){
			$this->db->where('pm.main_category', $_POST['category']);
		}
		
		if($_POST['search'] != ''){
			$this->db->join('tag_master as tm', 'tm.item_id = spm.Package_id','left');
			$this->db->where('tm.tag ', $_POST['search'] );
			$this->db->where('tm.teg_type ', 2);
			$this->db->where('tm.type ', 1);
		}
		
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	
	function get_service_details($package_slug){
		
		$this->db->select('spm.*, pm.Package_name, pm.packege_image, pm.main_category, spm.store_id, sm.store_name, sm.store_slug, cm.category_name');
		$this->db->from('store_Packages_master as spm');
		
		
		$this->db->join('Packages_master AS pm','pm.Package_id = spm.Package_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
		$this->db->join('category_master AS cm','cm.category_id = pm.main_category','Left');
		
		 
		$this->db->where('spm.package_slug', $package_slug);
		$this->db->where('spm.packege_status', 1);
		$this->db->where('pm.packege_status', 1);
		$this->db->where('sm.store_status', 1);
		
		return $this->db->get()->row();
	}
	
	function get_related_packages($Package_id, $cat_id){
		$this->db->select('spm.*, pm.Package_name, pm.packege_image, spm.store_id, sm.store_name, cm.category_name');
		$this->db->from('store_Packages_master as spm');
		$this->db->where('spm.Package_id !=', $Package_id);
		$this->db->where('pm.main_category', $cat_id);
		
		$this->db->join('Packages_master AS pm','pm.Package_id = spm.Package_id','Left');
		$this->db->join('Store_master AS sm','sm.store_id = spm.store_id','Left');
		$this->db->join('category_master AS cm','cm.category_id = pm.main_category','Left');
		
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
		//$this->db->where('sm.city', $city);
		
		
		$this->db->order_by('rand()');
		$this->db->limit(4);
		
		
		$record = $this->db->get()->result();
		$grid = '';
		foreach($record as $res){
			
			//service image
			$img = base_url().'assets/admin/images/no-image.png';
			if(file_exists($res->packege_image)) { $img = base_url().$res->packege_image; }
			
			
			
			//this for grid view
			$grid .='
				<div class="col-lg-6 ">
					<div class=" bg-white shadow-md rounded p-2 mb-2">
						<a href="#" style="float: right;" data-toggle="modal" data-target="#package-details-'.$res->Package_id.$res->store_id.'">Details</a>
						<div class="row">
							<div class="col-md-5 col-4 text-center" style="align-self: center;">
								<a href="'.base_url().'Services/service_details/'.$res->package_slug.'"><img class="img-fluid rounded align-top" src="'.$img.'" alt="Store"></a>
							</div>
							<div class="col-md-7 col-8 pl-3 pl-md-0 mt-3 mt-md-0">
								<h4><a href="#" class="text-dark text-3">'.$res->Package_name.'</a></h4>
								<p class="mb-2">  
									<span class="text-black-50 store-name"><i class="fas fa-store"></i> '.$res->store_name.'</span> 
								</p>
								';
								if($res->price_type == 1){
									$grid .='<span class="text-3 pr-2">Rs. '.$res->packege_sale_price.'</span><span class="text-3"><del>Rs. '.$res->packege_price.'</del></span>';
								}else if($res->price_type == 2){
									$grid .='<span class="text-3 pr-2">Rs. '.$res->packege_sale_price.'</span><span class="text-3 pr-2">-</span><span class="text-3">Rs. '.$res->packege_price.'</span>';
								}
								
								$grid .='
								<!--p class="reviews mb-2">
									<span class="reviews-score px-2 py-1 rounded font-weight-600 text-light text-2">8.2</span><a class="text-1 text-black-50" href="#">(245 reviews)</a>
								</p -->
								
							</div>
						</div>
					</div>
				</div>
				
				<!-- modal for plan details -->
				<div id="package-details-'.$res->Package_id.$res->store_id.'" class="modal fade" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">'.$res->Package_name.'</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
							</div>
							<div class="modal-body">
								<h5>Description</h5>
								'.$res->packege_description.'';
								
								if($res->packege_includes != NULL){
									$grid .='<h5 class="mt-2">includes</h5>
									'.$res->packege_includes.'';
								}
								
								if($res->packege_includes != NULL){
									$grid .='<h5 class="mt-2">excludes</h5>
									'.$res->packege_excludes.'';
								}
							$grid .='</div>
						</div>
					</div>
				</div>
			';
		}
		
		return $grid;
	}
	
	function get_cart($type){
		$this->db->select('
			cm.*, 
			sm.delivery_to_address, 
			sm.shipping_charge, 
			sm.minimum_cart_amount, 
			sm.service_to_address, 
			sm.minimum_service_cart_amount, 
			sm.service_charge, 
			sm.inspection_charge
			');
		$this->db->from('Cart_master as cm');
		$this->db->join('Store_master AS sm','sm.store_id = cm.store_id','Left');
		$this->db->where('cm.user_id', $this->session->User->user_id);
		$this->db->where('cm.store_type', $type);
		return $this->db->get()->row();
	}
	
	function get_cart_item($cart_id,$item_id,$type){
		$this->db->select('*');
		$this->db->from('Cart_item_master');
		$this->db->where('cart_id', $cart_id);
		$this->db->where('item_id', $item_id);
		$this->db->where('type', $type);
		return $this->db->get()->row();
	}
	
	function add_cart_item($cart_id,$item_id,$type){
		$cart['cart_id'] = $cart_id;
		$cart['item_id'] = $item_id;
		$cart['type'] = $type;
	
		$this->db->insert('Cart_item_master',$cart);
		
		return $this->db->insert_id();
	}
	
	function set_cart($item_id, $type, $store_id){
		
		//insert to cart
		$cart['user_id'] = $this->session->User->user_id;
		$cart['store_id'] = $store_id;
		$cart['store_type'] = $type;
		$this->db->insert('Cart_master',$cart);
		$cart_id = $this->db->insert_id();
		 
		return $this->add_cart_item($cart_id,$item_id,$type);
	}
	
	function check_fevourit($item_id, $store_id, $type,$is_store){
		$this->db->select('*');
		$this->db->from('Favourit_item_mster');
		$this->db->where('user_id', $this->session->User->user_id);
		$this->db->where('item_id', $item_id);
		$this->db->where('store_id', $store_id);
		$this->db->where('type', $type);
		$this->db->where('is_store', $is_store);
		return $this->db->get()->row();
	}
}
?>