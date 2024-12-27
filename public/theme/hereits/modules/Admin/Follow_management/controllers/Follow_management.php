<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Follow_management extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Follow_management');
		$this->load->library("pagination");
		
		if($this->session->Admin == null)
		{redirect('Admin');}
	}
	
	
	Public function index()
	{   $is_user = $this->Mdl_Follow_management->fetch_user();
		$data =array(
			'main_content'=>'Follow_list', 
			'left_sidebar'=>'Follow List', 
			'is_user'=>$is_user,
		);
		$this->load->view('admin_template/template',$data);
	}
	
	
	//ajex get Coupons list
	function get_follow_data($rowno=0){

		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Follow_management->getallrecord_follow();

		// Get records
		$record = $this->Mdl_Follow_management->get_follow_data($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Follow_management/";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		$grid = '';
		foreach($record as $res){
			
			$date_time  = date_format(date_create($res->created_at), 'd-m-Y H:i');
			
			//this for table veiw
			$table .= '<tr id="tr-'.$res->follow_id .'">';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->follow_id .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->username.'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Store_name	 .'</td>';
			$table .= '</tr>';
		
		}
			
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['table_view'] = $table;
		$data['row'] = $rowno;
		
		
		echo json_encode($data);
	}
	
	

	
}
?>
