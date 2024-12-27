<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_Order extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Store_Order');
		$this->load->model('Mdl_common');
		$this->load->model('Mdl_emails');
		$this->load->library("pagination");
		
		if($this->session->User == null)
		{redirect('Login');}
		
		$store_subscription = $this->Mdl_common->get_store_subscription();
		if($store_subscription->type == 2 || $store_subscription->type == 0){redirect('Store_Plans');}
	}
	Public function index()
	{   
		$data =array(
			'main_content'=>'Order_list',   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	
	//ajex get Coupons list
	function get_online_order_data($rowno=0){
		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Store_Order->getrecordCount_order();

		// Get records
		$record = $this->Mdl_Store_Order->get_order_data($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Store_Order/";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		$grid = '';
		foreach($record as $res){
			if($res->order_status == 0){
			   $status = '<button type="button" class="btn btn-warning btn-xs">Pending For Approvel</button>';
			}else if($res->order_status == 1){
				$status = '<button type="button" class="btn btn-success btn-xs">Accept By Store</button>';
			}else if($res->order_status == 2){
				$status = '<button type="button" class="btn btn-danger btn-xs">Reject By Store</button>';
			}else if($res->order_status == 3){
				$status = '<button type="button" class="btn btn-danger btn-xs">Reject By Customer</button>';
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
				$delivery_type = '<button type="button" class="btn btn-info btn-xs">Pickup At Store</button>';
			}else if($res->delivery_type == 2){
				$delivery_type = '<button type="button" class="btn btn-success btn-xs">Home Delivery</button>';
			}
			
			$date_time  = date_format(date_create($res->created_at), 'd-m-Y H:i');
			
			
			//this for table veiw
			$table .= '<tr id="tr-'.$res->order_id .'">';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->order_id .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $date_time .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->username	 .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->contact .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $delivery_type .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">
					<a href="'.base_url().'Store_Order/Order_details/'.$res->order_id.'" style="color: blue;padding-right: 7px;"><i class="fas fa-eye"></i></i></a>
					</td>';
			$table .= '</tr>';
			
			//this for grid view
			$grid .=' 
				<a class="col-12" href="'.base_url().'Store_Order/Order_details/'.$res->order_id.'" style="box-shadow: 2px 2px 20px rgba(107, 128, 168, 0.6); margin-bottom: 10px;background-color: white; padding-top: 3px;">
					<div class="row" style="text-align: center;">
						<div class="col-2" > 
							<h5 style="margin-bottom: -5px;color: gray;">'.date('Y', strtotime($res->created_at_date)).'</h5> 
							<h2 style="color: blue;">'.date('d', strtotime($res->created_at_date)).'</h2>
							<h5 style="margin-top: -13px;color: gray;">'.date('M', strtotime($res->created_at_date)).'</h5>
						</div>
						<div class="col-7" style="text-align: left;"> 
							<div>
								<span style="color: gray;">Order Id : </span><span>#'.$res->order_id.'</span> 
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
	
	function Order_details($id){
		$order_detail = $this->Mdl_Store_Order->Get_order_details($id);
		
		if($order_detail->delivery_type == 2){
			$order_detail->address = $this->Mdl_Store_Order->get_address($order_detail->addres_id);
		}
		
		$order_detail->Order_items = $this->Mdl_Store_Order->Get_order_items($id);
		foreach($order_detail->Order_items as $val){
			$img = $this->Mdl_Store_Order->get_product_image($val->product_id);
			$val->images = $img->image_url;
		}
		$data =array(
			'main_content'=>'Order_details',   
			'order_detail'=>$order_detail,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	function Change_order_status(){
		$this->Mdl_Store_Order->Change_order_status();
		
		//mail
		if($_POST['order_status'] == 1){
			$this->Mdl_emails->order_confirm_by_user_mail($_POST['order_id']);
		}else if($_POST['order_status'] == 2 || $_POST['order_status'] == 8){
			$this->Mdl_emails->order_cancel_by_user_mail($_POST['order_id']);
		}else if($_POST['order_status'] == 6){
			$this->Mdl_emails->order_completed_by_user_mail($_POST['order_id']);
		}
		
		die;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>
