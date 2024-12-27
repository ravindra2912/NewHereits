<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_management extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Order_management');
		$this->load->library("pagination");
		
		if($this->session->Admin == null)
		{redirect('Admin');}
	}
	
	
	Public function index()
	{ 

		$getuserid=$_GET['id'];
		$is_user = $this->Mdl_Order_management->fetch_user();
		
		$getstoreid=$_GET['store_id'];
		$is_store = $this->Mdl_Order_management->fetch_store_name();			
		$data =array(
			'main_content'=>'Online_order_list', 
			'left_sidebar'=>'Online Order list', 
			'is_store'=>$is_store,
			'getstoreid'=>$getstoreid,
			'is_user'=>$is_user,
			'getuserid'=>$getuserid,
		);
		$this->load->view('admin_template/template',$data);
	}
	
	
	//ajex get Coupons list
	function get_order_data($rowno=0){
		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Order_management->getallrecord_order();

		// Get records
		$record = $this->Mdl_Order_management->get_order_data($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Order_management/";
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
			
			if($res->delivery_type == 1){
				$delivery_type = 'Pickup At Store';
			}else if($res->delivery_type == 2){
				$delivery_type = 'Home Delivery';
			}
			
			$date_time  = date_format(date_create($res->created_at), 'd-m-Y H:i');
			
			
			//this for table veiw
			$table .= '<tr id="tr-'.$res->order_id .'">';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->order_id .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $date_time .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->username	 .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->contact .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Store_name .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $delivery_type .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">
					<a href="'.base_url().'Order_management/Order_details/'.$res->order_id.'" style="color: blue;padding-right: 7px;"><i class="fas fa-eye"></i></i></a>
					</td>';
			$table .= '</tr>';
			
			//this for grid view
			
		}
		
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['table_view'] = $table;
		$data['row'] = $rowno;
		
		
		echo json_encode($data);
	}
	
	function Order_details($id){
		
		$order_detail = $this->Mdl_Order_management->Get_order_details($id);
		
		$store= $this->Mdl_Order_management->Get_store($order_detail->store_id);
		if($order_detail->delivery_type == 2){
			$order_detail->address = $this->Mdl_Order_management->get_address($order_detail->addres_id);
		}
		
		$order_detail->Order_items = $this->Mdl_Order_management->Get_order_items($id);
		
		foreach($order_detail->Order_items as $val){
			$img = $this->Mdl_Order_management->get_product_image($val->product_id);
			$val->images = $img->image_url;
		}
		
		$data =array(
			'main_content'=>'Order_details', 
			'left_sidebar'=>'Order details', 			
			'order_detail'=>$order_detail,   
			'store'=>$store,   
		);
		$this->load->view('admin_template/template',$data);
	}
	
	function Change_order_status(){
		$this->Mdl_Order_management->Change_order_status();
		die;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>
