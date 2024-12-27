<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fav_item_management extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Fav_item_management');
		$this->load->library("pagination");
		
		if($this->session->Admin == null)
		{redirect('Admin');}
	}
	
	
	Public function index()
	{   
		$is_user = $this->Mdl_Fav_item_management->fetch_user();
		$data =array(
			'main_content'=>'Fav_item_list', 
			'left_sidebar'=>'Fav Item list', 
			'is_user'=>$is_user, 
		);
		$this->load->view('admin_template/template',$data);
	}
	
	
	//ajex get Coupons list
	function get_fav_item($rowno=0){
		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Fav_item_management->getallrecord_favitem();
		
		
		
		
		// Get records
		$record = $this->Mdl_Fav_item_management->get_fav_item($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Fav_item_management/";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';

		
		foreach($record as $res){
			
							
			If($res->is_store == 1){
			   $store = $this->Mdl_Fav_item_management->get_store_details($res->item_id);
			   
			}else if($res->is_store == 0){
				  $store = $this->Mdl_Fav_item_management->get_details($res->item_id, $res->type);
				   }
			
			if($res->type== 1){
				$type="Product";
			}else if($res->type== 2){
				$type="Service";
			}
					
			
			
			//this for table veiw
			$table .= '<tr id="tr-'.$res->favourit_id .'">';
			$table .= '<td class="text-center" style="padding: .60rem; vertical-align: unset;">'.$res->favourit_id .'</td>';
			$table .= '<td class="text-center" style="padding: .60rem; vertical-align: unset;">'.$res->username.$res->user_id	 .'</td>';
			$table .= '<td class="text-center" style="padding: .60rem; vertical-align: unset;">'.$store->Store_name .'</td>';
			$table .= '<td class="text-center" style="padding: .60rem; vertical-align: unset;">'.$store->product_name .'</td>';
			$table .= '<td class="text-center" style="padding: .60rem; vertical-align: unset;">'.$store->Package_name.'</td>';
			$table .= '<td class="text-center" style="padding: .60rem; vertical-align: unset;">'.$type .'</td>';
			
			$table .= '</tr>';
			
			
		}
		
		
		$data['pagination'] = $this->pagination->create_links();
		$data['table_view'] = $table;
		$data['row'] = $rowno;
			echo json_encode($data);
	}
	
	
	
	
	
	
}
?>
