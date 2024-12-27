<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_management extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Report_management');
		$this->load->library("pagination");
		
		if($this->session->Admin == null)
		{redirect('Admin');}
	}
	
	
	Public function index()
	{   
		$getid=$_GET['id'];
		$is_user = $this->Mdl_Report_management->fetch_user();
		
		$getstoreid=$_GET['store_id'];
		$is_store = $this->Mdl_Report_management->fetch_store_name();	
		
		$data =array(
			'main_content'=>'Report_list', 
			'left_sidebar'=>'Report list', 
			'getid'=>$getid, 
			'is_user'=>$is_user,
			'is_store'=>$is_store,
			'getstoreid'=>$getstoreid,
		);
		$this->load->view('admin_template/template',$data);
	}
	
	
	
	//ajex get Coupons list
	function get_report_data($rowno=0){
		// Row per page
		$rowperpage = 20;

		$_GET['user_id'];
		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Report_management->getallrecord_report();
		
		
		
		
		// Get records
		$record = $this->Mdl_Report_management->get_report_data($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Report_management/";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		
		foreach($record as $res){
			if($res->order_status == 0){
			   $status = '<button type="button" class="btn btn-warning btn-xs">Pending For Approver</button>';
			}else if($res->order_status == 1){
				$status = '<button type="button" class="btn btn-success btn-xs">Accept By Store</button>';
			}else if($res->order_status == 2){
				$status = '<button type="button" class="btn btn-danger btn-xs">Reject By Store</button>';
			}else if($res->order_status == 3){
				$status = '<button type="button" class="btn btn-danger btn-xs">Reject By User</button>';
			}else if($res->order_status == 4){
				$status = '<button type="button" class="btn btn-info btn-xs">Shipped</button>';
			}else if($res->order_status == 5){
				$status = '<button type="button" class="btn btn-danger btn-xs">Return</button>';
			}else if($res->order_status == 6){
				$status = '<button type="button" class="btn btn-success btn-xs">Order completed</button>';
			}else if($res->order_status == 7){
				$status = '<button type="button" class="btn btn-danger btn-xs">Cancel by Customer</button>';
			}else if($res->order_status == 8){
				$status = '<button type="button" class="btn btn-danger btn-xs">Cancel By Store</button>';
			}
			
						
			If($res->is_store == 1){
			   $store = $this->Mdl_Report_management->get_store_details($res->item_id);
			   $type = 'Store Abuse';
			}else{
				  $store = $this->Mdl_Report_management->get_details($res->item_id, $res->type);
				  if($res->type == 1){
					  $type = 'Product Abuse';
				  }else if($res->type == 2){
					  $type = 'Package Abuse';
				  }
			   }

					
			
			//this for table veiw
			$table .= '<tr id="tr-'.$res->report_id .'">';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->report_id .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->username	 .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$store->Store_name .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$store->product_name .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$store->Package_name.'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $res->msg .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$type .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">
					<a href="'.base_url().'Report_management/report_details/'.$res->report_id.'" style="color: blue;padding-right: 7px;"><i class="fas fa-eye"></i></i></a>
					</td>';
			$table .= '</tr>';
			
			
		}
		
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['table_view'] = $table;
		$data['row'] = $rowno;
		
		
		echo json_encode($data);
	}
	
	
	
	
	function report_details($report_id){
	

	    $record = $this->Mdl_Report_management->report_details($report_id); 
		
			
		If($record->is_store == 1){
			   $store = $this->Mdl_Report_management->get_store($record->item_id);
			   $type = 'Store Abuse';
			}else{
				  $store = $this->Mdl_Report_management->get_pm_pkm_details($record->item_id, $record->type);
				  if($record->type == 1){
					  $type = 'Product Abuse';
				  }else if($record->type == 2){
					  $type = 'Package Abuse';
				  }
			   }
		
		
		$data =array(
			'main_content'=>'report_details',   
			'record'=>$record,  
			'store'=>$store,
			'type'=>$type,
		);
		
		$this->load->view('admin_template/template',$data);
	}

}
?>
