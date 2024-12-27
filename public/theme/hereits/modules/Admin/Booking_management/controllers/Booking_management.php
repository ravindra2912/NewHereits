<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_management extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Booking_management');
		$this->load->library("pagination");
		
		if($this->session->Admin == null)
		{redirect('Admin');}
	}
	
	
	Public function index()
	{    
	
		$getuserid=$_GET['id'];
	    $is_user = $this->Mdl_Booking_management->fetch_user();

		$getstoreid=$_GET['store_id'];
		$is_store = $this->Mdl_Booking_management->fetch_store_name();		 
		 
		$data =array(
			'main_content'=>'Booking_list', 
			'left_sidebar'=>'Booking List', 
			'is_user'=>$is_user,
			'is_store'=>$is_store,
			'getstoreid'=>$getstoreid,
			'getuserid'=>$getuserid,
			
		);
		
	
		$this->load->view('admin_template/template',$data);
	}
	
	
	//ajex get Coupons list
	function get_booking_data($rowno=0){
		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Booking_management->getallrecord_booking();

		// Get records
		$record = $this->Mdl_Booking_management->get_booking_data($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Booking_management/";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		$grid = '';
		foreach($record as $res){
			
			// service type
			if ($res->service_type == 1)
			{
				$service_type= "At Service Provider`s Address";
			}
			else if ($res->service_type == 2)
			{
				$service_type= "At Your Address";
			}
			
			//Status
			if ($res->booking_status == 0)
			{
				$booking_status= "Pending For Approver, ";
			}
			else if ($res->booking_status == 1)
			{
				$booking_status= "Accept By Store";
			}
			else if ($res->booking_status == 2)
			{
				$booking_status= "Reject By Store";
			}
			else if ($res->booking_status == 3)
			{
				$booking_status= "Reject By Customer";
			}
			else if ($res->booking_status == 4)
			{
				$booking_status= "OnGoing";
			}
			else if ($res->booking_status == 5)
			{
				$booking_status= "Return";
			}
			else if ($res->booking_status == 6)
			{
				$booking_status= "Service completed";
			}
			else if ($res->booking_status == 7)
			{
				$booking_status= "Cancel by Customer";
			}
			else if ($res->booking_status == 8)
			{
				$booking_status= "Cancel By Store";
			}
			
			
			$date_time  = date_format(date_create($res->created_at), 'd-m-Y H:i');
			
			
			//this for table veiw
			$table .= '<tr id="tr-'.$res->booking_id .'">';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->booking_id .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Store_name	 .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->username .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->contact .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $service_type .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $booking_status .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">
					<a href="'.base_url().'Booking_management/booking_details/'.$res->booking_id.'" style="color: blue;padding-right: 7px;"><i class="fas fa-eye"></i></i></a>
					</td>';
			$table .= '</tr>';
			
			
			
		}
		
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['table_view'] = $table;
		$data['grid_view'] = $grid;
		$data['row'] = $rowno;
		
		
		echo json_encode($data);
	}
	
	function booking_details($booking_id){
	
		$booking_details = $this->Mdl_Booking_management->Get_booking_details($booking_id);
	
	
		if($booking_details->service_type == 2){
			$address = $this->Mdl_Booking_management->get_address($booking_details->addres_id);
		}


		$booking_details->Order_items = $this->Mdl_Booking_management->Get_booking_items($booking_id);
		
		$store= $this->Mdl_Booking_management->Get_store($booking_details->store_id);
	

		$data =array(
			'main_content'=>'Booking_details',   
			'booking_details'=>$booking_details,   
			'address'=>$address,   
			'store'=>$store,   
		);
		
		
		$this->load->view('admin_template/template',$data);
	}
	function Change_booking_status(){
		
		$this->Mdl_Booking_management->Change_booking_status();
		die;
	}

	
}
?>
