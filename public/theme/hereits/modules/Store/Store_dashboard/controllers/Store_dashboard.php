<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_dashboard extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Store_dashboard');
		$this->load->model('Mdl_common');
		$this->load->library("pagination");
		
		if($this->session->User == null)
		{redirect('Login');}
	}
	Public function index()
	{   
	
		$counts = $this->Mdl_Store_dashboard->get_counts();
		$store_info = $this->Mdl_Store_dashboard->get_store_details();
		$subscription = $this->Mdl_common->get_store_subscription();
	
		$data =array(
			'main_content'=>'Store_dashboard',   
			'counts'=>$counts,   
			'store_info'=>$store_info,   
			'subscription'=>$subscription,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	function get_store_messages(){
		$store = $this->Mdl_common->get_store_details();
		$subscription = $this->Mdl_common->get_store_subscription();
		
		$msg = '';
		if($store->store_status == 0){
			$msg .= '
				<div class="alert alert-info alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h5><i class="icon fas fa-info"></i> Alert!</h5>
					pending for approval:  we have received your registration request. its take minimum 1-2 working day to approve your request. since we will approve your request please set store timing, album and other details of your store.
				</div>
			';
		}else if($store->store_status == 2){
			$msg .= '
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h5><i class="icon fas fa-ban"></i> Alert!</h5>
					store disapproved <br> Reason: '.$store->disapprove_reason	.' <a href="https://hereits.com/Store_Profile">Click here to edit</a>
				</div>
			';
		}else{
			$datediff = strtotime($subscription->plan_end_date) - time();
			$day_left = round($datediff / (60 * 60 * 24));
			
			if($subscription == null){
				$msg .= '
					<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h5><i class="icon fas fa-ban"></i> Alert!</h5>
						you don`t have any active subscription plan, please buy one subscription plan to enjoy our services. click here to buy plan <a href="'.base_url().'Store_Plans">click Here</a>
					</div>
				';
			}else if($day_left <= 5){
				$msg .= '
					<div class="alert alert-warning alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
						your current plan will be expire on '.$subscription->plan_end_date.', please buy new plan to continue services otherwise your store product/ service will not show to customers.
					</div>
				';
			}
		}
		
		
		
		
		echo $msg;
	}
	
	function get_data_product($rowno2=0){
		// Row per page
		$rowperpage2 = 10;

		// Row position
		if($rowno2 != 0){
		  $rowno2 = ($rowno2-1) * $rowperpage2;
		}
	 
		// All records count
		$allcountproduct = $this->Mdl_Store_dashboard->getrecordCount_product();

		// Get records
		$recordproduct = $this->Mdl_Store_dashboard->get_product_data($rowno2,$rowperpage2);

		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcountproduct;
		$config['per_page'] = $rowperpage2;
		
		
		$this->pagination->initialize($config);
		$table2 = '';
		foreach($recordproduct as $res){
			
			if($res->order_status == 0){
			   $status = 'Pending for Approval';
			}else if($res->order_status == 1){
			   $status = 'Accepted';
			} if($res->order_status == 2){
			   $status = 'Rejected';
			} 
			
						
		
			$table2 .= '<tr id="tr-'.$res->order_id .'">';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->frist_name .' '.$res->last_name .'</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->item_amount .'/-</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a href="'.base_url().'Store_Order/Order_details/'.$res->order_id.'" target=_blanck" style="color: green;padding-right: 7px;"><i class="far fa-eye" style="font-size: 20px;"></i></a></td>';
			$table2 .= '</tr>';
		}
	
		$data['pagination2'] = $this->pagination->create_links();
		$data['table2'] = $table2;
		$data['row2'] = $rowno2;
		
		echo json_encode($data);
	}
	
	function get_data_Packages($rowno3=0){
		// Row per page
		$rowperpage3 = 10;

		// Row position
		if($rowno3 != 0){
		  $rowno3 = ($rowno3 -1) * $rowperpage3;
		}
	 
		// All records count
		$allcountpackage = $this->Mdl_Store_dashboard->getrecordCount_package();

		$recordpackage = $this->Mdl_Store_dashboard->get_package_data($rowno3,$rowperpage3);

		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcountpackage;
		$config['per_page'] = $rowperpage3;
		
		
		$this->pagination->initialize($config);
		$table3 = '';
		foreach($recordpackage as $res){
			
			if($res->booking_status == 0){
			   $status = 'Pending for Approval';
			}else if($res->booking_status == 1){
			   $status = 'Accepted';
			} if($res->booking_status == 2){
			   $status = 'Rejected';
			} 
			
			$table3 .= '<tr id="tr-'.$res->booking_id .'">';
			$table3 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->frist_name .' '.$res->last_name .'</td>';
			$table3 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->item_amount .'/-</td>';
			$table3 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table3 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a href="'.base_url().'Store_Booking/Booking_details/'.$res->booking_id.'" target=_blanck" style="color: green;padding-right: 7px;"><i class="far fa-eye" style="font-size: 20px;"></i></a></td>';
			$table3 .= '</tr>';
		}
	
		$data['pagination2'] = $this->pagination->create_links();
		$data['table3'] = $table3;
		$data['row3'] = $rowno3;
		
		echo json_encode($data);
	}

	
}
?>
