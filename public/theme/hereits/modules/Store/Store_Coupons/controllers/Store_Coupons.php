<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_Coupons extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Store_Coupons');
		$this->load->library("pagination");
		
		if($this->session->User == null)
		{redirect('Login');}
	}
	Public function index()
	{   
		$data =array(
			'main_content'=>'Coupons_list',   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	Public function insert_form()
	{   
		$data =array(
			'main_content'=>'coupon_add',      
		);
		$this->load->view('Store_template/template',$data);
	}
	
	Public function update_form($coupon_id)
	{   
		$coupon_data = $this->Mdl_Store_Coupons->get_single_coupon($coupon_id);
		$data =array(
			'main_content'=>'coupon_edit',   
			'coupon_data'=>$coupon_data,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	//ajex get Coupons list
	function get_coupons_data($rowno=0){
		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Store_Coupons->getrecordCount_coupons();

		// Get records
		$record = $this->Mdl_Store_Coupons->get_coupons_data($rowno,$rowperpage);
		
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
			$status = 'Active';
			if($res->coupon_status == 0){
			   $status = 'In-Active';
			}
			
			//coupon Discount 
			if($res->coupon_discount_type == 1){
				$coupon_amount = 'Rs. '.$res->coupon_amount;
			}else if($res->coupon_discount_type == 2){ 
				$coupon_amount = $res->coupon_amount.'%';
			}
			
			
			//this for table veiw
			$table .= '<tr id="tr-'.$res->coupon_id .'">';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->coupon_name .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->coupon_code .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$coupon_amount .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->coupon_start_date .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->coupon_end_date .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">
							<a onclick="delete_coupon('.$res->coupon_id .')"  style="color: red;padding-right: 7px;"><i class="fas fa-trash-alt"></i></a>
							<a href="'.base_url().'Store_Coupons/update_form/'.$res->coupon_id.'" style="color: blue;padding-right: 7px;"><i class="fas fa-edit"></i></i></a></td>';
			$table .= '</tr>';
			
			//this for grid view
			$grid .='
				<div class="col-12" style="box-shadow: 2px 2px 20px rgba(107, 128, 168, 0.6); margin-bottom: 10px;background-color: white;" id="tr-'.$res->coupon_id .'">
					<div class="noo-product-inner"> <!-- productssize -->
						<div class="row">
						
							<div class="col-3" style="text-align: center;">
								<span style="font-size: 13px;" class="amount">'.$res->coupon_code .'</span>
							</div>
							
							<div class="col-3" style="text-align: center;">
								<span style="font-size: 13px;" class="amount">'.$coupon_amount.'</span>
							</div>
							
							<div class="col-3" style="text-align: center;">
								<span style="font-size: 13px;" class="amount">'. $status.'</span>
							</div>
							
							<div class="col-3" style="text-align: center;">
								<div class="nav-item dropdown" style="text-align: center;">
									<a class=" dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
									  Edit <span class="caret"></span>
									</a>
									<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: -97px; transform: translate3d(0px, 40px, 0px);">
										<a class="dropdown-item" tabindex="-1" onclick="delete_coupon('.$res->coupon_id .')" href="#">Delete</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" tabindex="-1" href="'.base_url().'Store_Coupons/update_form/'.$res->coupon_id.'">Edit</a>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			';
		}
		
		
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['table_view'] = $table;
		$data['grid_view'] = $grid;
		$data['row'] = $rowno;
		
		
		echo json_encode($data);
	}
	
	function coupon_code_exists(){
		$res = $this->Mdl_Store_Coupons->coupon_code_exists();
		if($res != NULL){
			echo json_encode(FALSE);
		}else{
			echo json_encode(TRUE);
		}
		die;
	}
	
	function insert_coupon(){
		$this->Mdl_Store_Coupons->insert_coupon();
		redirect('Store_Coupons');
	}
	
	function update_coupon(){
		$this->Mdl_Store_Coupons->update_coupon();
		redirect('Store_Coupons');
	}
	
	function delete_coupon(){
		//delete product record
		$this->db->where('coupon_id', $_POST['coupon_id']);
		$this->db->delete('Coupons_master');
		
		die;
		
	}
	
	
	
}
?>
