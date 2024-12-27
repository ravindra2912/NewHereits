<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_Follow extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Store_Follow');
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
			'main_content'=>'Follow_list',   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	//ajex get Coupons list
	function get_Follow_list($rowno=0){
		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Store_Follow->get_Follow_list_count();

		// Get records
		$record = $this->Mdl_Store_Follow->get_Follow_list($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		$grid = '';
		foreach($record as $res){
			
			$user_image = base_url().'assets/admin/images/no-image.png';
			if($res->user_image != NULL){
				$path = $res->user_image;
				if(file_exists($path)) { 
					$user_image = base_url().$path; 
				}
			}
			//this for table veiw
			$table .= '<tr id="tr-'.$res->booking_id .'">';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><img src="'.$user_image.'" style="height: 60px;width: 60px;"/></td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $res->username .'</td>';
			$table .= '</tr>';
			
			//this for grid view
			$grid .=' 
				<a class="col-12" href="" style="box-shadow: 2px 2px 20px rgba(107, 128, 168, 0.6); margin-bottom: 10px;background-color: white; padding-top: 3px;">
					<div class="row" style="text-align: center;">
						<div class="col-2" style="margin-left: 9px;"> 
							<img src="'.$user_image.'" style="height: 60px;width: 60px; border-radius: 30px;"/>
						</div>
						<div class="col-7" style="text-align: left;align-self: center; margin-left: 13px;"> 
							<p style="margin-bottom: unset; font-size: 19px;">'.$res->username.'</p>
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
	
	
}
?>
