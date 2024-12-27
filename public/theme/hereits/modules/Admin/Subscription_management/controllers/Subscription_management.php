<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription_management extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Subscription_management');
		$this->load->library("pagination");
		
		if($this->session->Admin == null)
		{redirect('Admin');}
	}
	Public function index()
	{  
		
		$data =array(
			'main_content'=>'Subscription_list', 
			
		);
		$this->load->view('admin_template/template',$data);
	}
	
	Public function insert_form()
	{   
		$data =array(
			'main_content'=>'Subscription_add',      
		);
		$this->load->view('admin_template/template',$data);
	}
	
	Public function update_form($id)
	{   
		$package_data = $this->Mdl_Subscription_management->get_single_package($id);
		$data =array(
			'main_content'=>'Subscription_update',   
			'package_data'=>$package_data,   
		);
		$this->load->view('admin_template/template',$data);
	}
	
	

	//ajex get Coupons list
	function get_package_data($rowno=0){
		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Subscription_management->getrecordCount_package();

		// Get records
		$record = $this->Mdl_Subscription_management->get_package_data($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		$grid = '';
		foreach($record as $res){
			
			
			
			//status
			if($res->status == 1){
				$status = 'Active';
			}else if($res->status == 0){ 
				$status = 'In-Active';
			}
			
			//Type
			if($res->type == 1){
				$type = 'Product';
			}else if($res->type == 2){ 
				$type = 'Service';
			}else if($res->type == 3){ 
				$type = 'Both';
			}
			
			//Chat
			$Chat = 'No';
			if($res->Chat == 1){
				$Chat = 'Yes';
			}
			
			//Feature_Store
			$Feature_Store = 'No';
			if($res->Feature_Store == 1){
				$Feature_Store = 'Yes';
			}
			
			//Verify_Batch
			$Verify_Batch = 'No';
			if($res->Verify_Batch == 1){
				$Verify_Batch = 'Yes';
			}
			
			//Support
			$Support = 'Email';
			if($res->Support == 1){
				$Support = 'Employee';
			}
			
			
			//this for table veiw
			$table .= '<tr id="tr-'.$res->subscription_id .'">';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->name .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$type .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Product_Limit	.' / '.$res->package_Limit.'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$Chat .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$Feature_Store .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Feature_Product .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$Verify_Batch .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Stories .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$Support .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><input type="number" onchange="change_order(this.value,'.$res->subscription_id .' )" value="'.$res->order.'" /></td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">
							<a onclick="delete_coupon('.$res->coupon_id .')"  style="color: red;padding-right: 7px;"><i class="fas fa-trash-alt"></i></a>
							<a href="'.base_url().'Subscription_management/update_form/'.$res->subscription_id.'" style="color: blue;padding-right: 7px;"><i class="fas fa-edit"></i></i></a></td>';
			$table .= '</tr>';
			
			
		}
		
		
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['table_view'] = $table;
		$data['grid_view'] = $grid;
		$data['row'] = $rowno;
		
		
		echo json_encode($data);
	}
	
	
	function insert_package(){
		$this->Mdl_Subscription_management->insert_package();
		redirect('Subscription_management');
	}
	
	function upadate_package(){
		$this->Mdl_Subscription_management->upadate_package();
		redirect('Subscription_management');
	}
	
	function get_package_plans(){
		$res = $this->Mdl_Subscription_management->get_package_plans();
		$data ='';
		foreach($res as $val){
			$discount = $val->amount-($val->amount * $val->discount/100);
			$data .='
				<div class="col-md-3" id="'.$val->month.$val->subscription_id.'">
					<div class="card card-widget widget-user">
					  <!-- Add the bg color to the header using any of the bg-* classes -->
					  <div class="widget-user-header" style="height: 70px;">
						<h3 class="widget-user-username"><del style="font-size: 15px;color: red;">&#8377; '.$val->amount.'</del> &#8377; '.round($discount).'</h3>
						<!-- span class="description-text">$discount</span -->
					  </div>
					  <div class="card-footer" style="padding: 0px;">
						<div class="row">
						  
						  <div class="col-sm-4 border-right">
							<div class="description-block">
							  <h5 class="description-header"> '.$val->month.' </h5>
							  <span class="description-text">Month</span>
							</div>
						  </div>
						  
						  <div class="col-sm-4 border-right">
							<div class="description-block">
							  <h5 class="description-header">'.$val->discount.'%</h5>
							  <span class="description-text">Discount</span>
							</div>
						  </div>
						  
						  <div class="col-sm-4">
							<div class="description-block" style="color: red;" onclick="delete_plan('.$val->month.')">
							  <h5 class="description-header"><i class="fas fa-trash-alt"></i></h5>
							  <span class="description-text">Delete</span>
							</div>
						  </div>
						  
						</div>
						<!-- /.row -->
					  </div>
					</div>
					<!-- /.widget-user -->
				</div>
			';
		}
		
		echo $data;
	}
	
	function add_package_plans(){
		$this->Mdl_Subscription_management->add_package_plans();
	}
	
	function delete_package_plans(){
		//delete product record
		$this->db->where('subscription_id', $_POST['subscription_id']);
		$this->db->where('month', $_POST['month']);
		$this->db->delete('subscription_plans_master');
		
		die;
		
	}
	
	function change_order(){
		$this->Mdl_Subscription_management->change_order();
		die;
	}
	
	// ====== Store List ==========
	
		Public function store_sub_list()
	{   
		$is_store = $this->Mdl_Subscription_management->fetch_store_name();
		$data =array(
			
			'main_content'=>'sub_Store_list',  
			'is_store'=>$is_store,			
		);
		$this->load->view('admin_template/template',$data);
	}
	
	function get_store_data($rowno=0){
		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Subscription_management->getrecordCount_subscription();
			
		// Get records
		$record = $this->Mdl_Subscription_management->get_subscription_data($rowno,$rowperpage);

		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		foreach($record as $res){
			
			$status = '';
			if($res->status == 0){
			   $status = 'Payment Pending';
			} else if($res->status == 1){
				$status = 'Active';
			}else if($res->status == 2){
				$status = 'Expired';
			}
			
			if($res->type == 1){
				$type= "Product";
			}
			elseif($res->type == 2){
				$type= "Service";
			} 
			else if($res->type == 3){
				$type= "Both";
			}
			
			
			$table .= '<tr id="tr-'.$res->store_subscription_id .'">';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->store_subscription_id .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Store_name .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->subscription_id .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->name .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$type .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->duration .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->plan_start_date .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->plan_end_date .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a href="'.base_url().'Subscription_management/single_sub_store/'.$res->store_subscription_id.'" target=_blanck" style="color: green;padding-right: 7px;"><i class="far fa-eye" style="font-size: 20px;"></i></a></td>';
			$table .= '</tr>';
		}
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['table_view'] = $table;
		$data['row'] = $rowno;
		
		
		echo json_encode($data);
	}
	
	function single_sub_store($store_subscription_id){

		$sub_data = $this->Mdl_Subscription_management->get_single_sub_data($store_subscription_id);
		
		$subscribe = $this->Mdl_Subscription_management->get_single_Subscription_data($store_subscription_id);
		
		$data =array(
			'main_content'=>'single_Store_sub',   
			'sub_data'=>$sub_data,   
			'subscribe'=>$subscribe,
		);
		$this->load->view('admin_template/template',$data);
		
	}
	
	function Change_sub_status(){
		$this->Mdl_Subscription_management->Change_sub_status();
		die;
	}	
	function Change_date(){
		$this->Mdl_Subscription_management->Change_sub_date();
		die;
		
	}
	
}
?>
