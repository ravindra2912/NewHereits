<?php 
class Mdl_Subscription_management extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_single_package($id){
		$this->db->select('*');
		$this->db->from('subscription_master');
		$this->db->where('subscription_id', $id);
		return $this->db->get()->row();
	}
	
	function get_package_data($rowno,$rowperpage)
	{
		$this->db->select('*');
		$this->db->from('subscription_master');
		
		if(!empty($_POST['search'])){
			$this->db->like('name', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('status', $_POST['status']);
		}
		
		$this->db->order_by('order', 'asc');
		
		$this->db->limit($rowperpage, $rowno); 
		return $this->db->get()->result();
	}
	
	public function getrecordCount_package() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('subscription_master');
		
		if(!empty($_POST['search'])){
			$this->db->like('name', $_POST['search']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('status', $_POST['status']);
		}
		
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	  }
	  
	  
	function insert_package(){
		$data['name'] = $_POST['name'];
		$data['Description'] = $_POST['Description'];
		$data['Product_Limit'] = $_POST['Product_Limit'];
		$data['package_Limit'] = $_POST['package_Limit'];
		$data['Feature_Product'] = $_POST['Feature_Product'];
		$data['Stories'] = $_POST['Stories'];
		$data['type'] = $_POST['type'];
		
		
		if(isset($_POST['Chat'])){
			$data['Chat'] = $_POST['Chat'];
		}
		
		
		if(isset($_POST['Feature_Store'])){
			$data['Feature_Store'] = $_POST['Feature_Store'];
		}
		
		if(isset($_POST['Verify_Batch'])){
			$data['Verify_Batch'] = $_POST['Verify_Batch'];
		}
		
		
		if(isset($_POST['Support'])){
			$data['Support'] = $_POST['Support'];
		}
		
		if(isset($_POST['Data_and_reporting'])){
			$data['Data_and_reporting'] = $_POST['Data_and_reporting'];
		}
		
		if(isset($_POST['recommended'])){
			$data['recommended'] = $_POST['recommended'];
		}
		if(isset($_POST['ads'])){
			$data['ads'] = $_POST['ads'];
		}
		
		
		$data['created_at'] = date("Y-m-d H:i:s");
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		
		$this->db->insert('subscription_master',$data);
		return $this->db->insert_id();
		
	}
	
	function upadate_package(){
		$data['name'] = $_POST['name'];
		$data['Description'] = $_POST['Description'];
		$data['Product_Limit'] = $_POST['Product_Limit'];
		$data['package_Limit'] = $_POST['package_Limit'];
		$data['Feature_Product'] = $_POST['Feature_Product'];
		$data['Stories'] = $_POST['Stories'];
		$data['type'] = $_POST['type'];
		$data['status'] = $_POST['status'];
		
		
		if(isset($_POST['Chat'])){
			$data['Chat'] = $_POST['Chat'];
		}else{
			$data['Chat'] = 0;
		}
		
		
		if(isset($_POST['Feature_Store'])){
			$data['Feature_Store'] = $_POST['Feature_Store'];
		}else{
			$data['Feature_Store'] = 0;
		}
		
		if(isset($_POST['Verify_Batch'])){
			$data['Verify_Batch'] = $_POST['Verify_Batch'];
		}else{
			$data['Verify_Batch'] = 0;
		}
		
		
		if(isset($_POST['Support'])){
			$data['Support'] = $_POST['Support'];
		}else{
			$data['Support'] = 0;
		}
		
		if(isset($_POST['Data_and_reporting'])){
			$data['Data_and_reporting'] = $_POST['Data_and_reporting'];
		}else{
			$data['Data_and_reporting'] = 0;
		}
		
		if(isset($_POST['recommended'])){
			$data['recommended'] = $_POST['recommended'];
		}else{
			$data['recommended'] = 0;
		}
		if(isset($_POST['ads'])){
			$data['ads'] = $_POST['ads'];
		}else{
			$data['ads'] = 0;
		}
		
		$data['updated_at'] = date("Y-m-d H:i:s");
		
		$this->db->where('subscription_id',$_POST['subscription_id']);
		$this->db->update('subscription_master',$data);
		
		
	}
	  
	function get_package_plans(){
		$this->db->select('*');
		$this->db->from('subscription_plans_master');
		$this->db->where('subscription_id', $_POST['subscription_id']);
		return $this->db->get()->result();
	}
	
	  
	function add_package_plans(){
		$data['subscription_id'] = $_POST['subscription_id'];
		$data['month'] = $_POST['month'];
		$data['amount'] = $_POST['amount'];
		$data['discount'] = $_POST['discount'];
		$data['created_at'] = date("Y-m-d H:i:s");
		
		
		$this->db->insert('subscription_plans_master',$data);
		//return $this->db->insert_id();
	}
	
	function change_order(){
		$data['order'] = $_POST['order'];
		$this->db->where('subscription_id',$_POST['subscription_id']);
		$this->db->update('subscription_master',$data);
	}
	
	// ====== Store List ==========
	
	function get_subscription_data($rowno,$rowperpage)
	{
		$this->db->select('ssm.* , 
						stm.Store_name,
						scm.name,
						scm.type,');
		$this->db->from('store_subscription_master AS ssm');
				
		if(!empty($_POST['search'])){
			$this->db->like('ssm.store_subscription_id', $_POST['search']);
		}
		if($_POST['is_store'] != ''){
			$this->db->where('ssm.store_id', $_POST['is_store']);
		}
		
		if($_POST['status'] != ''){
			$this->db->where('ssm.status', $_POST['status']);
		}	
		$this->db->join('Store_master AS stm','stm.store_id = ssm.store_id','Left');
		$this->db->join('subscription_master AS scm','scm.subscription_id = ssm.subscription_id','Left');
		$this->db->limit($rowperpage, $rowno); 
		$this->db->order_by("ssm.created_date", "desc");
		$this->db->order_by("ssm.created_time", "desc");
		
		return $this->db->get()->result();
	}
	
	function getrecordCount_subscription() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('store_subscription_master');
		
		if(!empty($_POST['search'])){
			$this->db->like('store_subscription_id', $_POST['search']);
		}
		if($_POST['is_store'] != ''){
				$this->db->where('store_id', $_POST['is_store']);
		}
		if($_POST['status'] != ''){
			$this->db->where('status', $_POST['status']);
		}
		
		$query = $this->db->get();
		$result = $query->result_array();



		return $result[0]['allcount'];
	  }
	  
	function get_single_sub_data($store_subscription_id)
	{ 
	
		$this->db->select('ssm.* ,stm.Store_name,');
		$this->db->from('store_subscription_master AS ssm');
		$this->db->join('Store_master AS stm','stm.store_id = ssm.store_id','Left');
		$this->db->where('store_subscription_id',$store_subscription_id);		
		return $this->db->get()->row();
	} 
	
	function get_single_Subscription_data($store_subscription_id)
	{
		$this->db->select('ssm.store_subscription_id ,scm.*,');
		$this->db->from('store_subscription_master AS ssm');
		$this->db->join('subscription_master AS scm','scm.subscription_id = ssm.subscription_id','Left');	
		$this->db->where('store_subscription_id',$store_subscription_id);
		return $this->db->get()->row();
	}
	
	function fetch_store_name(){
				
		$this->db->select('ssm.*,sm.store_id,sm.Store_name');
		$this->db->from('store_subscription_master as ssm');
		$this->db->group_by('sm.store_id'); 
		$this->db->join('Store_master AS sm','sm.store_id = ssm.store_id','Left');
		return $this->db->get()->result();
	} 
	
	function Change_sub_status(){
		$data['status'] = $_POST['sub_status'];
		$this->db->where('store_subscription_id',$_POST['store_subscription_id']);
		$this->db->update('store_subscription_master',$data);
	}
	function Change_sub_date(){
		
		if ( $_POST['datepicker'] != NULL){
		$data['plan_start_date'] = $_POST['datepicker'];
		}
		
		if ( $_POST['enddatepicker'] != NULL){
		$data['plan_end_date'] = $_POST['enddatepicker'];
		}
		
		$this->db->where('store_subscription_id',$_POST['store_subscription_id']);
		$this->db->update('store_subscription_master',$data);
	  }
	  
	
}
?>