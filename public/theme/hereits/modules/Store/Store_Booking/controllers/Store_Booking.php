<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_Booking extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Store_Booking');
		$this->load->model('Mdl_common');
		$this->load->model('Mdl_emails');
		$this->load->library("pagination");
		
		if($this->session->User == null)
		{redirect('Login');}
		
		$store_subscription = $this->Mdl_common->get_store_subscription();
		if($store_subscription->type == 1 || $store_subscription->type == 0){redirect('Store_Plans');}
	}
	Public function index()
	{   
		$data =array(
			'main_content'=>'Booking_list',   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	
	//ajex get Coupons list
	function get_Bokking_data($rowno=0){
		// Row per page
		$rowperpage = 15;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Store_Booking->getrecordCount_booking();

		// Get records
		$record = $this->Mdl_Store_Booking->get_booking_data($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		$grid = '';
		foreach($record as $res){
			if($res->booking_status == 0){
			   $status = '<button type="button" class="btn btn-warning btn-xs">Pending For Approval</button>';
			}else if($res->booking_status == 1){
				$status = '<button type="button" class="btn btn-success btn-xs">Accept By Store</button>';
			}else if($res->booking_status == 2){
				$status = '<button type="button" class="btn btn-danger btn-xs">Reject By Store</button>';
			}else if($res->booking_status == 3){
				$status = '<button type="button" class="btn btn-danger btn-xs">Reject By Customer</button>';
			}else if($res->booking_status == 4){
				$status = '<button type="button" class="btn btn-info btn-xs">Shipped</button>';
			}else if($res->booking_status == 5){
				$status = '<button type="button" class="btn btn-danger btn-xs">Return</button>';
			}else if($res->booking_status == 6){
				$status = '<button type="button" class="btn btn-success btn-xs">Service completed</button>';
			}else if($res->booking_status == 7){
				$status = '<button type="button" class="btn btn-danger btn-xs">Cancel by Customer</button>';
			}else if($res->booking_status == 8){
				$status = '<button type="button" class="btn btn-danger btn-xs">Cancel By Store</button>';
			}
			
			if($res->service_type == 1){
				$service_type = '<button type="button" class="btn btn-info btn-xs">At Service Provider Address</button>';
			}else if($res->service_type == 2){
				$service_type = '<button type="button" class="btn btn-success btn-xs">At Customer Address</button>';
			}
			
			$date_time  = date_format(date_create($res->created_at_date), 'd-m-Y');
			
			
			//this for table veiw
			$table .= '<tr id="tr-'.$res->booking_id .'">';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->booking_id .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $date_time .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->username	 .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->contact .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $service_type .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">
					<a href="'.base_url().'Store_Booking/Booking_details/'.$res->booking_id.'" style="color: blue;padding-right: 7px;"><i class="fas fa-eye"></i></i></a>
					</td>';
			$table .= '</tr>';
			
			//this for grid view
			$grid .=' 
				<a class="col-12" href="'.base_url().'Store_Booking/Booking_details/'.$res->booking_id.'" style="box-shadow: 2px 2px 20px rgba(107, 128, 168, 0.6); margin-bottom: 10px;background-color: white; padding-top: 3px;">
					<div class="row" style="text-align: center;">
						<div class="col-2" > 
							<h5 style="margin-bottom: -5px;color: gray;">'.date('Y', strtotime($res->created_at_date)).'</h5> 
							<h2 style="color: blue;">'.date('d', strtotime($res->created_at_date)).'</h2>
							<h5 style="margin-top: -13px;color: gray;">'.date('M', strtotime($res->created_at_date)).'</h5>
						</div>
						<div class="col-7" style="text-align: left;"> 
							<div>
								<span style="color: gray;">Booking Id : </span><span>#'.$res->booking_id.'</span> 
							</div>
							<p style="margin-bottom: unset; font-size: 19px;">'.$res->username.'</p>
							<p style="margin-bottom: unset; color: gray;">'.$res->contact .'</p>
						</div>
						<div class="col-3" style="align-self: center;">  
							'. $status .' 
							
						</div>
					</div>
				</a>
			';
		}
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['table_view'] = $table;
		$data['grid_view'] = $grid;
		$data['row'] = $rowno;
		
		
		echo json_encode($data);
	}
	
	function Booking_details($id){
		$booking_detail = $this->Mdl_Store_Booking->Get_booking_details($id);
		
		if($booking_detail->service_type == 2){
			$booking_detail->address = $this->Mdl_Store_Booking->get_address($booking_detail->addres_id);
		}
		
		$booking_detail->Order_items = $this->Mdl_Store_Booking->Get_booking_items($id);
		$data =array(
			'main_content'=>'Booking_details',   
			'booking_detail'=>$booking_detail,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	function Change_booking_status(){
		$this->Mdl_Store_Booking->Change_booking_status();
		
		//mail
		if($_POST['booking_status'] == 1){
			$this->Mdl_emails->booking_confirm_by_user_mail($_POST['booking_id']);
		}else if($_POST['booking_status'] == 2 || $_POST['booking_status'] == 8){
			$this->Mdl_emails->booking_cancel_by_user_mail($_POST['booking_id']);
		}else if($_POST['booking_status'] == 6){
			$this->Mdl_emails->booking_completed_by_user_mail($_POST['booking_id']);
		}
		die;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>
