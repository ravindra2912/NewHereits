<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq_management extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Faq_management');
		$this->load->library("pagination");
		
		if($this->session->Admin == null)
		{redirect('Admin');}
	}
	Public function index()
	{   
			$data =array(
				'main_content'=>'Faq_list',
			);
			$this->load->view('admin_template/template',$data);
			
		
	}
	
	function get_faq_data($rowno=0){
		// Row per page
		$rowperpage = 10;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Faq_management->getallrecord_faq();

		// Get records
		$record = $this->Mdl_Faq_management->get_faq($rowno,$rowperpage);
	
		// Pagination Configuration
		$config['base_url'] = base_url()."Faq_management/";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		foreach($record as $res){
		
			$date_time  = date_format(date_create($res->created_at), 'd-m-Y H:i');
			
			
			//this for table veiw
			$table .= '<tr id="tr-'.$res->faq_id .'">';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->faq_id .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->question	 .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->answer .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->category .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $res->status .'</td>';
			
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">
					<a href="'.base_url().'Faq_management/edit_faq/'.$res->faq_id.'" style="color: blue;padding-right: 7px;"><i class="fas fa-eye"></i></i></a>
					</td>';
			$table .= '</tr>';
		}
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['table_view'] = $table;
		$data['row'] = $rowno;
		
		
		echo json_encode($data);
	}
	
	function goto_add_form()
	{
		$data =array(
				'main_content'=>'Faq_add',
				'left_sidebar'=>'FAQ list', 
			);
		$this->load->view('admin_template/template',$data);
		
	}
	
	function insert_faq()
	{
		$this->Mdl_Faq_management->insert_faq();
		redirect('Faq_management');
	}
	
	function edit_faq($faq_id){
		
		$faq_data = $this->Mdl_Faq_management->faq_details($faq_id);
		
		$data =array( 
				'main_content'=>'faq_update',
				'faq_data'=>$faq_data,  
			);
			$this->load->view('admin_template/template',$data);
			
	}
	function faq_update(){
		$this->Mdl_Faq_management->faq_update();	
		redirect('Faq_management');
	}
	
	function delete_faq($faq_id){
		
		$this->Mdl_Faq_management->delete_faq($faq_id);
		redirect('Faq_management');
		
	}
	
	
}
?>
