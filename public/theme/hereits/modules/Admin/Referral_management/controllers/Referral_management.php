<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referral_management extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Referral_management');
		$this->load->model('Mdl_emails');
		$this->load->library("pagination");
		
		if($this->session->Admin == null)
		{redirect('Admin');}
	}
	Public function index()
	{   
		$data =array(
			'main_content'=>'Referral_list',  
			
		);
		$this->load->view('admin_template/template',$data);
	}

	
	
	function get_user_data($rowno=0){
		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Referral_management->getrecordCount_user();

		// Get records
		$record = $this->Mdl_Referral_management->get_user_data($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$result = '';
			
		foreach($record as $res){
			$referral_cunt = 0;
			$referral_cunt = $this->Mdl_Referral_management->getrecordCount_referal($res->user_referal);
				
			$recorduser = $this->Mdl_Referral_management->get_user_pending_payments($res->user_referal);
			$pending_payments = 0;	
			foreach($recorduser as $val){
					$check_store = $this->Mdl_Referral_management->check_payment($val->store_id);
					if ($check_store == NULL){
						$pending_payments +=1;
					}	
				}
			$result .= '<tr id="tr-'.$res->user_id .'">';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->username .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->user_referal .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$referral_cunt .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$pending_payments .'</td>';
			if($pending_payments != 0)
			{	
				$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a href="'.base_url().'Referral_management/single_user/'.$res->user_id.'" target=_blanck" style="color: green;"><i class="far fa-eye" style="font-size: 20px;"></i></a><button class="btn btn-primary" style="max-width: fit-content;margin-left: 18px;" OnClick="pay_all('.$res->user_id .')">Pay All</button></td>';
			}else{	
				$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a href="'.base_url().'Referral_management/single_user/'.$res->user_id.'" target=_blanck" style="color: green;"><i class="far fa-eye" style="font-size: 20px;"></i></a></td>';
			}
			$result .= '</tr>';
			
		}
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $result;
		$data['row'] = $rowno;
		
		
		echo json_encode($data);
	}
	
	function pay_all_users($user_id)
	{
		$user_data = $this->Mdl_Referral_management->get_single_user_data($user_id);
		$recorduser = $this->Mdl_Referral_management->get_user_pending_payments($user_data->user_referal);
		 foreach($recorduser as $res){
			 $check_store = $this->Mdl_Referral_management->check_payment($res->store_id);
				if ($check_store == NULL){
					$this->Mdl_Referral_management->update_status($res->store_id);
				}
		}
		echo json_encode($data);
	}
	
	function single_user($user_id){
		$user_data = $this->Mdl_Referral_management->get_single_user_data($user_id);
		$data =array(
			'main_content'=>'single_referral',   
			'user_data'=>$user_data,   
		);
		$this->load->view('admin_template/template',$data);
	}
	function get_pending_payments($rowno2=0){
		// Row per page
		$rowperpage2 = 10;

		// Row position
		if($rowno2 != 0){
		  $rowno2 = ($rowno2-1) * $rowperpage2;
		}
	 
		$recordproduct = $this->Mdl_Referral_management->get_pending_payments($rowno2,$rowperpage2);
		// All records count
		$allcountreferal = $this->Mdl_Referral_management->getrecordCount_pending_payments();

		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcountproduct;
		$config['per_page'] = $rowperpage2;
		
		
		$this->pagination->initialize($config);
		$table2 = '';
		foreach($recordproduct as $res){
			
			if($res->store_status == 0 ){ $store_status= "pending for approval" ;} 
			elseif ($res->store_status == 1 ){ $store_status= "Active";}  
			elseif ($res->store_status == 2 ){ $store_status= "Dis-Approval";}  
			elseif ($res->store_status == 3 ){ $store_status= "DeActivate";} 
			elseif ($res->store_status == 4 ){ $store_status= "permanent close";} 
			elseif ($res->store_status == 5 ){ $store_status= "banned";} 


			
			$check_store = $this->Mdl_Referral_management->check_payment($res->store_id);
			if ($check_store == NULL){
				$pending_payments +=1;
				$table2 .= '<tr id="tr-'.$res->store_id .'">';
				$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Store_name .'</td>';
				$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->created_at .'</td>';
				$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$store_status .'</td>';
				$table2 .= '<td class="text-center" style="padding: .50rem; vertical-align: unset;"><a onclick="update_status('.$res->store_id.')"  style="color: white;" class="btn btn-block btn-primary">Pay</a></td>';
				$table2 .= '</tr>';
			}
		}
	
		$data['pagination2'] = $this->pagination->create_links();
		$data['table2'] = $table2;
		$data['row2'] = $rowno2;
		$data['allcountreferal'] = $allcountreferal;
		$data['pending_payments'] = $pending_payments;
		
		echo json_encode($data);
	}
	
	function update_status($store_id)
	{
		 $this->Mdl_Referral_management->update_status($store_id);
		 echo json_encode($data);
	}
	
	function get_completed_Pymts($rowno2=0){
		// Row per page
		$rowperpage2 = 10;

		// Row position
		if($rowno2 != 0){
		  $rowno2 = ($rowno2-1) * $rowperpage2;
		}
	 
		$record = $this->Mdl_Referral_management->get_completed_Pymts($rowno2,$rowperpage2);
		// All records count
		$complt_payment = $this->Mdl_Referral_management->complt_payment();

		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcountproduct;
		$config['per_page'] = $rowperpage2;
		
		
		$this->pagination->initialize($config);
		$table2 = '';
		foreach($record as $res){
			
			$store_data = $this->Mdl_Referral_management->get_store($res->store_id);
			if($store_data->store_status == 0 ){ $store_status= "pending for approval" ;} 
			elseif ($store_data->store_status == 1 ){ $store_status= "Active";}  
			elseif ($store_data->store_status == 2 ){ $store_status= "Dis-Approval";}  
			elseif ($store_data->store_status == 3 ){ $store_status= "DeActivate";} 
			elseif ($store_data->store_status == 4 ){ $store_status= "permanent close";} 
			elseif ($store_data->store_status == 5 ){ $store_status= "banned";} 

			$table2 .= '<tr id="tr-'.$store_data->store_id .'">';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$store_data->Store_name .'</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->created_at_date .'</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$store_status .'</td>';
			$table2 .= '<td class="text-center" style="padding: .50rem; vertical-align: unset;"><a  style="color: white;" class="btn btn-block btn-primary">Complete</a></td>';
			$table2 .= '</tr>';
		}
	
		$data['pagination3'] = $this->pagination->create_links();
		$data['table3'] = $table2;
		$data['row2'] = $rowno2;
		$data['complt_payment'] = $complt_payment;
		
		echo json_encode($data);
	}
	
	
	
}
?>
