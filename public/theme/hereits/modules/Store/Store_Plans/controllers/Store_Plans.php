<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_Plans extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Store_Plans');
		$this->load->model('Mdl_common');
		$this->load->model('Mdl_paytm');
		$this->load->model('Mdl_emails');
		$this->load->library('pagination');
		
	}
	
	Public function index()
	{
		if($this->session->User == null)
		{redirect('Login');}
		
		$plans = $this->Mdl_Store_Plans->get_plans(0);
		//$product = $this->Mdl_Store_Plans->get_plans(1);
		//$service = $this->Mdl_Store_Plans->get_plans(2);
		//$both = $this->Mdl_Store_Plans->get_plans(3);
		$current_plan = $this->Mdl_common->get_store_subscription();
	
		$data =array(
			'main_content'=>'Plan_list',   
			//'product'=>$product,   
			//'service'=>$service,   
			//'both'=>$both,   
			'plans'=>$plans,   
			'current_plan'=>$current_plan,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	function Plan_history()
	{	
		
		if($this->session->User == null)
		{redirect('Login');}
		$data =array(
			'main_content'=>'Plan_history',    
		);
		
		$this->load->view('Store_template/template',$data);
		
	}
	
	function get_plans($rowno=0){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Store_Plans->getrecordCount_plans();

		// Get records
		$record = $this->Mdl_Store_Plans->get_plans_data($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Store_Plans/";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		$grid = '';
		foreach($record as $res){
			if($res->plan_status == 0){
			   $status = '<button type="button" class="btn btn-warning btn-xs">Pending For Payment</button>';
			}else if($res->plan_status == 1){
				$status = '<button type="button" class="btn btn-success btn-xs">Active</button>';
			}else if($res->plan_status == 2){
				$status = '<button type="button" class="btn btn-danger btn-xs">Expired</button>';
			}
			
			$date_time  = date_format(date_create($res->created_at), 'd-m-Y H:i');
			
			
			//this for table veiw
			$table .= '<tr id="tr-'.$res->store_subscription_id .'">';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->name .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->total_amount .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $res->duration .'-Months</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.  $res->plan_start_date  .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.  $res->plan_end_date  .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.  $status .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">
					<a href="'.base_url().'Store_Plans/get_plan_details/'.$res->store_subscription_id.'" class="onclick-load()" style="color: blue;padding-right: 7px;"><i class="fas fa-eye"></i></i></a>
					</td>';
			$table .= '</tr>';
			
			//this for grid view
			$grid .=' 
				<a class="col-12" href="'.base_url().'Store_Plans/get_plan_details/'.$res->store_subscription_id.'" class="onclick-load" style="box-shadow: 2px 2px 20px rgba(107, 128, 168, 0.6); margin-bottom: 10px;background-color: white; padding-top: 3px;">
					<div class="row" style="text-align: center;">
						<div class="col-2" > 
							<h7 style="margin-bottom: -5px;color: gray; font-size: 10px;">'.$res->plan_start_date.'</h5> 
							<h5 style="color: blue;margin-bottom: -2px;">To</h2>
							<h7 style="margin-top: -13px;color: gray;font-size: 10px;">'.$res->plan_end_date.'</h5>
						</div>
						<div class="col-7" style="text-align: left; "> 
							<div>
								<span>'.$res->name.'</span> 
							</div>
							<p style="margin-bottom: unset; ">'.$res->duration.'-Months</p>
							<p style="margin-bottom: unset; color: gray;">Amount : '.$res->total_amount .'/-</p>
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
	function get_plan_details($id){
		
		$store_sub =$this->Mdl_Store_Plans->store_sub_details($id);
			
		if($this->session->User == null)
		{redirect('Login');}
		$data =array(
			'main_content'=>'plan_history_detail',    
			'store_sub'=>$store_sub,        
			);
		
		$this->load->view('Store_template/template',$data);
	}
	
	function plan_details(){
		if($this->session->User == null)
		{redirect('Login');}
		
		$subscription = $this->Mdl_Store_Plans->get_plan();
		
		$data =array(
			'main_content'=>'Plan_details',   
			'subscription'=>$subscription,  
			'select_month'=>$_POST['month'],  
		);
		
		
		$this->load->view('Store_template/template',$data);
	}
	
	function get_single_plan(){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		if($this->session->User == null)
		{redirect('Login');}
		
		$res = $this->Mdl_Store_Plans->get_single_plan();
		$data['msg'] = $res;
		$data['month_discount'] = round($res->amount -($res->amount * $res->discount / 100));
		$data['month_price'] = round($res->amount);
		$data['CartTotal'] = $res->amount;
		$data['DiscountTotal'] = $res->amount - ($res->amount -($res->amount * $res->discount / 100));
		$data['net_amount'] =$data['CartTotal'] - $data['DiscountTotal'];
		$tex =($data['net_amount'] +($data['net_amount'] * 18 / 100)) - $data['net_amount'];
		$data['taxTotalCurrency'] =number_format((float)$tex, 2, '.', '');
		$data['TotalAmount'] =number_format((float)$data['net_amount'] + $data['taxTotalCurrency'], 2, '.', '');
		echo json_encode($data);
	}
	
	function proceed_to_payment(){
		if($this->session->User == null)
		{redirect('Login');}
		
		$res = $this->Mdl_Store_Plans->get_single_plan();
		
		
		unset($_POST['month']);
		$_POST['plan_start_date'] = date("Y-m-d");
		$_POST['plan_end_date'] = date('Y-m-d', strtotime("+".$res->month." months", strtotime(date("Y-m-d"))));
		$_POST['store_id'] = $this->session->User->store_id;
		$_POST['duration'] = $res->month;
		$_POST['total_amount'] = $res->amount;
		$_POST['discount'] = $res->amount - ($res->amount -($res->amount * $res->discount / 100));
		$net_amount =$_POST['total_amount'] - $_POST['discount'];
		$_POST['tex'] = ($net_amount +($net_amount * 18 / 100)) - $net_amount;
		
		$_POST['created_date'] = date("Y-m-d");
		$_POST['created_time'] = date("H:i:s");
		$_POST['updated_at'] = date("Y-m-d H:i:s");
		
		$sspi = $this->Mdl_Store_Plans->set_subscription();
		
		$this->payment($sspi);

		//redirect('Store_Plans');
	}
	
	function payment($sspi){
		
		//if($this->Mdl_common->check_maintenance()){
		//	$this->load->view('Other_view_and_template/maintenance');
		//	die;
		//}
		if($this->session->User == null)
		{redirect('Login');}
		
		$detais = $this->Mdl_Store_Plans->get_store_subscription_details($sspi);
		$payeble_amount = number_format((float)($detais->total_amount - $detais->discount) + $detais->tex, 2, '.', '');
		
		if($payeble_amount <= 0){
			
			// De-Active Store Current Plan
			$this->Mdl_Store_Plans->deactive_current_plan();
			
			$data['status'] = 1;
			$data['payment_status'] = 1;
			//$data['payment_info'] = json_encode($_POST);
			$this->db->where('store_subscription_id', $sspi);
			$this->db->update('store_subscription_master', $data);
			
			//email
			$this->Mdl_emails->store_subscription_buy_email($sspi);
			
			redirect('Store_Plans/payment_successful/'.$sspi);
			$this->payment_successful($sspi);
		}else{
			$ORDER_ID = $detais->store_subscription_id;
			$CUST_ID = $detais->store_id;
			$INDUSTRY_TYPE_ID = 'Retail';
			$CHANNEL_ID = 'WEB';
			$TXN_AMOUNT = $payeble_amount;
		}
	
		$this->Mdl_paytm->PAYTM_ENVIRONMENT();  
		
		$checkSum = "";
		$paramList = array();

		

		// Create an array having all required parameters for creating checksum.
		$paramList["MID"] = PAYTM_MERCHANT_MID;
		$paramList["ORDER_ID"] = $ORDER_ID;
		$paramList["CUST_ID"] = $CUST_ID;
		$paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
		$paramList["CHANNEL_ID"] = $CHANNEL_ID;
		$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
		$paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
		$paramList["CALLBACK_URL"] = base_url().'Store_Plans/payment_responce';

		/*
		$paramList["CALLBACK_URL"] = "http://localhost/PaytmKit/pgResponse.php";
		$paramList["MSISDN"] = $MSISDN; //Mobile number of customer
		$paramList["EMAIL"] = $EMAIL; //Email ID of customer
		$paramList["VERIFIED_BY"] = "EMAIL"; //
		$paramList["IS_USER_VERIFIED"] = "YES"; //

		*/

		//Here checksum string will return by getChecksumFromArray() function.
		$checkSum = $this->Mdl_paytm->getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
		
		$data = array();
		$data['paramList'] 	= $paramList;
		$data['checkSum'] = $checkSum;
		
		$this->load->view('paytm/payby_paytm', $data);
	}
	
	/******************* paytm Start *****************************/
	
	
	 public function payment_responce(){
		
		$this->Mdl_paytm->PAYTM_ENVIRONMENT();
    	$paytmChecksum = "";
		$paramList = array();
		$isValidChecksum = "FALSE";

		$paramList = $_POST;
		$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

		$isValidChecksum = $this->Mdl_paytm->verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.

		if($isValidChecksum == "TRUE") {
			//set sessuion
			if($this->session->User == null) { 
				$rowdata = $this->Mdl_Store_Plans->user_relogin($_POST['ORDERID']); 
				unset($rowdata->password); 
				$this->session->set_userdata("User",$rowdata);
			}
			
			if ($_POST["STATUS"] == "TXN_SUCCESS") {
				// De-Active Store Current Plan
				$this->Mdl_Store_Plans->deactive_current_plan();
				
				$data['status'] = 1;
				$data['payment_status'] = 1;
				$data['payment_info'] = json_encode($_POST);
				$this->db->where('store_subscription_id', $_POST['ORDERID']);
				$this->db->update('store_subscription_master', $data);
				
				//email
				$this->Mdl_emails->store_subscription_buy_email($_POST['ORDERID']);
				
				redirect('Store_Plans/payment_successful/'.$_POST['ORDERID']);
			
			}else{
				$data['payment_status'] = 2;
				$data['payment_info'] = json_encode($_POST);
				$this->db->where('store_subscription_id', $_POST['ORDERID']);
				$this->db->update('store_subscription_master', $data);
				redirect('Store_Plans/payment_failed/'.$_POST['ORDERID']);
			}
		}else{
			//set sessuion
			if($this->session->User == null) { 
				$rowdata = $this->Mdl_Store_Plans->user_relogin($_POST['ORDERID']); 
				unset($rowdata->password); 
				$this->session->set_userdata("User",$rowdata);
			}
			
			$data['payment_status'] = 2;
			$data['payment_info'] = json_encode($_POST);
			$this->db->where('store_subscription_id', $_POST['ORDERID']);
			$this->db->update('store_subscription_master', $data);
			redirect('Store_Plans/payment_failed/'.$_POST['ORDERID']);
		}
    } 
	
	function payment_successful($store_subscription_id){
		if($this->session->User == null)
		{redirect('Login');}
		$detais = $this->Mdl_Store_Plans->get_store_subscription_details($store_subscription_id);
		
		$data =array(  
			'status'=>1,  
			'detais'=>$detais,  
		);
		
		
		$this->load->view('payment_responce',$data);
		
			
	}
	
	function payment_failed($store_subscription_id){
		if($this->session->User == null)
		{redirect('Login');}
		$detais = $this->Mdl_Store_Plans->get_store_subscription_details($store_subscription_id);
		$data =array(  
			'status'=>0,  
			'detais'=>$detais,  
		);
		
		$this->load->view('payment_responce',$data);
	}
	
	
	
	
}
?>
