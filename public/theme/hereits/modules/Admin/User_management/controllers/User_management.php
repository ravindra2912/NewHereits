<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_management extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_User_management');
		$this->load->library("pagination");
		if($this->session->Admin == null)
		{redirect('Admin');}
	}
	
	Public function index()
	{    
			$data =array(
				'main_content'=>'user_list',
				'left_sidebar'=>'User List', 
			);
			$this->load->view('admin_template/template',$data);
		
	}
	
		//ajex get Coupons list
	function get_user_data($rowno=0){

		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_User_management->getallrecord_users();

		// Get records
		$record =  $this->Mdl_User_management->get_users($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."User_management/";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		
		foreach($record as $res){
			
			$date_time  = date_format(date_create($res->created_at), 'd-m-Y H:i');
			
			if($res->gender == NULL ){
				$gender = " ";
			}elseif($res->gender ==1 ){
				$gender = "Male";
			}else if($res->gender ==2 ){
				$gender = "Female";
			}if($res->gender ==3 ){
				$gender = "Other";
			}
			//this for table veiw
			$table .= '<tr id="tr-'.$res->user_id .'">';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->user_id .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->username.'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->email.'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$gender.'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->contact.'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">
					<a href="'.base_url().'User_management/edit_user/'.$res->user_id.'" style="color: blue;padding-right: 7px;"><i class="fas fa-eye"></i></i></a>
					</td>';
			$table .= '</tr>';
		
		}
			
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['table_view'] = $table;
		$data['row'] = $rowno;
		
		
		echo json_encode($data);
	}
	// Dashboard 
	function edit_user($user_id){
	
		$user_data = $this->Mdl_User_management->user_details($user_id);
		$report_count = $this->Mdl_User_management->getreport_count($user_id);	
		$booking_count = $this->Mdl_User_management->getbooking_count($user_id);	
		$ordercount = $this->Mdl_User_management->getorder_count($user_id);	
		
		$data =array( 
				'main_content'=>'User_Dashboard_view',
				
				'user_data'=>$user_data,  
				'report_count'=>$report_count,  
				'booking_count'=>$booking_count,  
				'ordercount'=>$ordercount,  
			);
			$this->load->view('admin_template/template',$data);
	}
	
	function user_full_details($user_id){
	
		$user_data = $this->Mdl_User_management->user_details($user_id);
		
		$data =array( 
				'main_content'=>'user_update',
				'user_data'=>$user_data,  
			);
			$this->load->view('admin_template/template',$data);
	}
	
	function orders_details($user_id){
	
		$user_data = $this->Mdl_User_management->orders_details($user_id);
		
		$data =array( 
				'main_content'=>'orders_details_view',
				'user_data'=>$user_data,  
			);
			$this->load->view('admin_template/template',$data);
	}
	
	function booking_details($user_id){
	
		$user_data = $this->Mdl_User_management->booking_details($user_id);
		
		$data =array( 
				'main_content'=>'booking_details_view',
				'user_data'=>$user_data,  
			);
			$this->load->view('admin_template/template',$data);
	}
	
	
	
	
	
	function user_update(){
		$this->Mdl_User_management->user_update();	
		redirect('User_management');
	}
	
	
	// USER UPDATE 
	function update_user(){
	

		if($_FILES['user_image']['name'] != null)
			{     			
					$target_path = "uploads/user_image/";
					$ext = explode('.', basename($_FILES['user_image']['name']));
					$digits = 4;
					$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
					$c_name = $_POST['user_id'].'-'.time().'-'. $rands . "." . $ext[count($ext) - 1];
					$c_image = $target_path . $c_name;
					move_uploaded_file($_FILES['user_image']['tmp_name'], $c_image);
					
					if(file_exists($c_image)) 
					{
						$_POST['user_image'] = $c_image;
						
						$user_data = $this->Mdl_User_management->user_details($_POST['user_id']);
						$path = $user_data->user_image;
						
						if(file_exists($path)) 
						{
							unlink($path);
						}
						
					}
					
			} 
			
		if($_FILES['adhar_card_front_image']['name'] != null)
			{     			
					$target_path = "uploads/user_image/";
					$digits = 4;
					$ext2 = explode('.', basename($_FILES['adhar_card_front_image']['name']));
					$rands2 = rand(pow(10, $digits-1), pow(100, $digits)-1);  
					$c_name2 = 'User-'.$_POST['user_id'].'-Adharcard'.time().'-'. $rands2 . "." . $ext2[count($ext2) - 1];
					$c_image2 = $target_path . $c_name2;
					move_uploaded_file($_FILES['adhar_card_front_image']['tmp_name'], $c_image2);
					
					if(file_exists($c_image2)) 
					{
						$_POST['adhar_card_front_image'] = $c_image2;
						
						$user_data = $this->Mdl_User_management->user_details($_POST['user_id']);
						$path1 = $user_data->adhar_card_front_image;
						
						if(file_exists($path1)) 
						{
							unlink($path1);
						}
						
					}
					
			}
		if($_FILES['adhar_card_back_image']['name'] != null)
			{     			
					$target_path = "uploads/user_image/";
					$digits = 4;
					$ext3 = explode('.', basename($_FILES['adhar_card_back_image']['name']));
					$rands3 = rand(pow(10, $digits-1), pow(100, $digits)-1);  
					$c_name3 = 'User-'.$_POST['user_id'].'-Adharcard'.time().'-'. $rands3 . "." . $ext3[count($ext3) - 1];
					$c_image3 = $target_path . $c_name3;
					move_uploaded_file($_FILES['adhar_card_back_image']['tmp_name'], $c_image3);
					if(file_exists($c_image3)) 
					{
						$_POST['adhar_card_back_image'] = $c_image3;
						
						$user_data = $this->Mdl_User_management->user_details($_POST['user_id']);
						$path3 = $user_data->adhar_card_back_image;
						
						if(file_exists($path3)) 
						{
							unlink($path3);
						}
						
					}
					
			} 
		$this->Mdl_User_management->update_user();	
		redirect('User_management');
	}
	
	
}
?>
