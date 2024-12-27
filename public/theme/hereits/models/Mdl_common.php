<?php
class Mdl_common extends CI_Model{	function __construct()	{		parent::__construct();     	}
	function thumb($img_url, $fullname, $width, $height)
    {
        // Path to image thumbnail in your root
        $dir = './uploads/'.$img_url;
        $url = base_url() . 'uploads/'.$img_url;
        // Get the CodeIgniter super object
        $CI = &get_instance();
        // get src file's extension and file name
        $extension = pathinfo($fullname, PATHINFO_EXTENSION);
        $filename = pathinfo($fullname, PATHINFO_FILENAME);
        $image_org = $dir . $filename . "." . $extension;
        $image_thumb = $dir . $filename . "-" . $height . '_' . $width . "." . $extension;
        $image_returned = $url . $filename . "-" . $height . '_' . $width . "." . $extension;

        if (!file_exists($image_thumb)) {
            // LOAD LIBRARY
            $CI->load->library('image_lib');
            // CONFIGURE IMAGE LIBRARY
            $config['source_image'] = $image_org;
            $config['new_image'] = $image_thumb;
            $config['width'] = $width;
            $config['height'] = $height;
            $CI->image_lib->initialize($config);
            $CI->image_lib->resize();
            $CI->image_lib->clear();
        }
        return $image_returned;
    }
	
	//main logo
	function get_logo()
	{ 
		$this->db->select('*');
		$this->db->from('logo');
		return $this->db->get()->row();	
	} 
	//Tab logo
	function get_tab_logo() 
	{ 
		$this->db->select('*'); 
		$this->db->where('type','tab');
		$this->db->from('logo'); 
		return $this->db->get()->row();	

	} 
	
	//Tab contact info for footer
	function footer_contact() 
	{ 
		$this->db->select('*'); 
		$this->db->from('Admin_master'); 
		return $this->db->get()->row();	

	} 
	
	function get_seo()
	{
		$this->db->select('*'); 
		$this->db->from('sco'); 
		return $this->db->get()->row();	
	}
	
	function get_store_subscription(){
		$this->db->select('ssm.*, sm.type');
		$this->db->from('store_subscription_master as ssm');
		$this->db->join('subscription_master as sm', 'sm.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.store_id', $this->session->User->store_id);
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		return $this->db->get()->row();
		
	}
	
	function get_store_details(){
		$this->db->select('*');
		$this->db->where('store_id', $this->session->User->store_id);
		$this->db->from('Store_master');
		return $this->db->get()->row();
	}
	
	function product_slug($store_id, $product_id){
		$this->db->select('*');
		$this->db->where('product_id', $product_id);
		$this->db->from('product_master');
		$product = $this->db->get()->row();
		
		$this->db->select('*');
		$this->db->where('store_id', $store_id);
		$this->db->from('Store_master');
		$store = $this->db->get()->row();
		
		$slug = $product->product_name.' '.$store->Store_name.' store '.$store->city.' '.$store->state;
		$slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug));
		
		$this->db->select('*');
		$this->db->where('product_slug', $slug);
		$this->db->from('store_product_master');
		$check_slug = $this->db->get()->row();
		
		if($check_slug != null){
			$slug = $product->product_name.' '.$store->Store_name.' store '.$store->city.' '.$store->state.' '.$product_id.$store_id;
			$slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug));
		}
		
		$data['product_slug'] = $slug;
		$this->db->where('store_id', $store_id);
		$this->db->where('product_id', $product_id);
		$this->db->update('store_product_master', $data);
	}

	function package_slug($store_id, $Package_id){
		$this->db->select('*');
		$this->db->where('Package_id', $Package_id);
		$this->db->from('Packages_master');
		$Package = $this->db->get()->row();
		
		$this->db->select('*');
		$this->db->where('store_id', $store_id);
		$this->db->from('Store_master');
		$store = $this->db->get()->row();
		
		$slug = $Package->Package_name.' '.$store->Store_name.' store '.$store->city.' '.$store->state;
		$slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug));
		
		$this->db->select('*');
		$this->db->where('package_slug', $slug);
		$this->db->from('store_Packages_master');
		$check_slug = $this->db->get()->row();
		
		if($check_slug != null){
			$slug = $Package->Package_name.' '.$store->Store_name.' store '.$store->city.' '.$store->state.' '.$Package_id.$store_id;
			$slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug));
		}
		
		$data['package_slug'] = $slug;
		$this->db->where('store_id', $store_id);
		$this->db->where('Package_id', $Package_id);
		$this->db->update('store_Packages_master', $data);
	}
	
	function store_slug($store_id){
		
		$this->db->select('*');
		$this->db->where('store_id', $store_id);
		$this->db->from('Store_master');
		$store = $this->db->get()->row();
		
		//creat slug
		$slug = $store->Store_name.'  '.$store->city;
		if($store->city != $store->district){
			$slug .= ' '.$store->district;
		}
		$slug .= ' '.$store->state.' '.$store->country.' '.$store->pincode;
		
		
		//check slug exist
		$this->db->select('*');
		$this->db->where('store_slug', $slug);
		$this->db->from('Store_master');
		$check_slug = $this->db->get()->row();
		
		if($check_slug != null){
			$slug = ' '.$store_id;
		}
		$slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug));
		
		//update slug
		$data['store_slug'] = $slug;
		$this->db->where('store_id', $store_id);
		$this->db->update('Store_master', $data);
	}
	
	function site_seo(){
		$data['description'] = 'Buy Products or Services Near by, Get Store Details,direction, Contact Store, Check Pricing of Products And Services Locally.Download hereits App.Find Best deals and offers in your city.Get onlin order and Services or get it at yout home.';
		$data['keywords'] = 'find nearby stores,find nearby services,get order online,pick up order from store,book services online,book appointment,book service,book service from near by store,near by grocery store,applience shope';
		$data['title'] = ' Hereits| Find Store-Products-Services In City| No Commission. ';
		$data['url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$data['city'] = '';
		$data['state'] = '';
		$data['position'] = '';
		$data['image'] = base_url().'assets/front-end/images/fevicon-icon.png';
		
		return $data;
	}
	
	function get_cart_count($type){
		$this->db->select('
			cm.*, 
			');
		$this->db->from('Cart_master as cm');
		$this->db->where('cm.user_id', $this->session->User->user_id);
		$this->db->where('cm.store_type', $type);
		$cart = $this->db->get()->row();
		
		$this->db->from('Cart_item_master as cim');
		$this->db->where('cim.cart_id', $cart->cart_id);
		$this->db->where('cim.type', $type);
		$cart_item = $this->db->get()->result();
		
		
		return count($cart_item);
	}
	
	//get all city 
	function get_cities(){
		$this->db->select('sm.city, sm.state');
		$this->db->from('Store_master as sm');
		$this->db->where('sm.store_status', 1);
		$this->db->group_by('sm.city');
		$this->db->order_by('sm.city', 'asc');
		
		//check subscription
		$this->db->join('store_subscription_master as ssm', 'ssm.store_id = sm.store_id','left');
		$this->db->join('subscription_master as sum', 'sum.subscription_id = ssm.subscription_id','left');
		$this->db->where('ssm.plan_start_date <=', date("Y-m-d"));
		$this->db->where('ssm.plan_end_date >', date("Y-m-d"));
		$this->db->where('ssm.status ', 1);
		
		return $this->db->get()->result();
	}
	
	
}?>