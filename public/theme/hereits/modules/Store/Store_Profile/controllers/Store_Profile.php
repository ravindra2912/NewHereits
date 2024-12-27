<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_Profile extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Store_Profile');
		$this->load->library("pagination");
		
		if($this->session->User == null)
		{redirect('Login');}
	}
	Public function index()
	{   
		$store_data = $this->Mdl_Store_Profile->get_store_info();
		
		$user_data = $this->Mdl_Store_Profile->user_data();
		$follow_count = $this->Mdl_Store_Profile->get_Follow_list_count();
		
		$header_import .= '<script src="'.base_url().'assets/tags/tagcomplete.js"></script>
							<link rel="stylesheet" href="'.base_url().'assets/tags/tag.css">';

		$tags = $this->Mdl_Store_Profile->get_tags();

		
		$tag = '';
		for($i =0 ;$i <= count($tags) - 1 ; $i++ ){
			if($i == count($tags)-1){
				$tag .= $tags[$i]->tag;
			}else{
				$tag .= $tags[$i]->tag.',';
			}
		}
		
		//google import js
		$header_import .= '<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>';
		
		//Google map
		$footer_import .= '<script src="'.base_url().'assets/admin/custom_js/google_map.js"></script>';
		$footer_import .= '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApYAW3LEn3K2hO8jdq0O-fULmBmREdFtc&callback=initAutocomplete&libraries=places&region=in"></script>';
		
		$data =array(
			'main_content'=>'Store_profile',   
			'store_data'=>$store_data,   
			'header_import'=>$header_import,   
			'footer_import'=>$footer_import,   
			'follow_count'=>$follow_count,   
			'user_data'=>$user_data,   
			'tag'=>$tag,   
		);
		$this->load->view('Store_template/template',$data);
	}
	
	function user_edit(){
		$store_data = $this->Mdl_Store_Profile->get_store_info();
		$user_data = $this->Mdl_Store_Profile->user_data();
		$header_import = '<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>';
		$data =array(
		'main_content'=>'user_edit',
		'header_import'=>$header_import, 
		'user_data'=> $user_data,
		'store_data'=> $store_data,
		);
		$this->load->view('Store_template/template',$data);
	}
	
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
						
						$user_data = $this->Mdl_Store_Profile->user_data();;
						$path = $user_data->user_image;
						
						if(file_exists($path)) 
						{
							unlink($path);
						}
						
					}
					
			} 
			
		$this->Mdl_Store_Profile->update_user();
		redirect('Store_Profile');
	}		
	function get_tag(){
		(!$this->input->is_ajax_request()) ? exit('No direct script access allowed') : '' ;
		$tags = $this->Mdl_Store_Profile->get_tag();
		echo json_encode($tags);
	}
	function check_adhar(){
	   $check =	$this->Mdl_Store_Profile->check_adhar();
	   if ($check != NULL)
	   {
		   echo "true";
	   }else if($check == NULL)
	   {
		   echo "false";
	   }
	}
	function update_store(){
		
		$store_data = $this->Mdl_Store_Profile->get_store_info();
		
		//upload store image new
		if($_POST['store_image'] != null && $_FILES['store_image1']['name'] != null){
			$target_path = "uploads/store_image/";
			$img = $_POST['store_image'];
			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$data = base64_decode($img);
			$digits = 2;
			$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
			$file = $target_path . 'store-'.time().'-'.$rands . '.png';
			$success = file_put_contents($file, $data);
			if($success){
				//unlink image
				if(file_exists($store_data->store_image)) { unlink($store_data->store_image); }
				$_POST['store_image'] = $file;
			}else{
				unset($_POST['store_image']);
			}
		}else{
				unset($_POST['store_image']);
			}
		
		
		
		
		//upload store image old
		/*if($_FILES['store_image']['name'] != null)
		{
			//unlink image
			if(file_exists($store_data->store_image)) { unlink($store_data->store_image); }
			
			$target_path = "uploads/store_image/";
			$ext = explode('.', basename($_FILES['store_image']['name']));
			$digits = 2;
			$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
			$c_name = 'store-'.time().'-'.$rands . "." . $ext[count($ext) - 1];
			$c_image = $target_path . $c_name;
			move_uploaded_file($_FILES['store_image']['tmp_name'], $c_image);
			if(file_exists($c_image)) {
				$_POST['store_image'] = $target_path.$c_name;
			}
		} */
		
		//upload store address image
		if($_FILES['address_proof_image']['name'] != null)
		{
			//unlink image
			if(file_exists($store_data->address_proof_image)) { unlink($store_data->address_proof_image); }
			
			$target_path = "uploads/store_image/";
			$ext = explode('.', basename($_FILES['address_proof_image']['name']));
			$digits = 2;
			$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
			$c_name = 'address-proof-'.time().'-'.$rands . "." . $ext[count($ext) - 1];
			$c_image = $target_path . $c_name;
			move_uploaded_file($_FILES['address_proof_image']['tmp_name'], $c_image);
			if(file_exists($c_image)) {
				$_POST['address_proof_image'] = $target_path.$c_name;
			}
		}
		
		//upload store pancard image
		if($_FILES['pancard_image']['name'] != null)
		{
			//unlink image
			if(file_exists($store_data->pancard_image)) { unlink($store_data->pancard_image); }
			
			$target_path = "uploads/store_image/";
			$ext = explode('.', basename($_FILES['pancard_image']['name']));
			$digits = 2;
			$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
			$c_name = 'pancard-'.time().'-'.$rands . "." . $ext[count($ext) - 1];
			$c_image = $target_path . $c_name;
			move_uploaded_file($_FILES['pancard_image']['tmp_name'], $c_image);
			if(file_exists($c_image)) {
				$_POST['pancard_image'] = $target_path.$c_name;
			}
		}
		
		//upload store gst image
		if($_FILES['gst_image']['name'] != null)
		{
			//unlink image
			if(file_exists($store_data->gst_image)) { unlink($store_data->gst_image); }
			
			$target_path = "uploads/store_image/";
			$ext = explode('.', basename($_FILES['gst_image']['name']));
			$digits = 2;
			$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
			$c_name = 'gst-'.time().'-'.$rands . "." . $ext[count($ext) - 1];
			$c_image = $target_path . $c_name;
			move_uploaded_file($_FILES['gst_image']['tmp_name'], $c_image);
			if(file_exists($c_image)) {
				$_POST['gst_image'] = $target_path.$c_name;
			}
		}
		
		$this->Mdl_Store_Profile->update_store();
		redirect('Store_Profile');
	}
	
	
	function set_time_slot(){
		
		$this->Mdl_Store_Profile->set_time_slot();
		redirect('Store_Timing');
	}
	
	function edit_time_slot(){
		$res = $this->Mdl_Store_Profile->set_single_time_slot();
		
		echo json_encode($res);
		die;
	}
	
	function update_time_slot(){
		$this->Mdl_Store_Profile->update_time_slot();
		redirect('Store_Timing');
	} 
	
	function delete_time_slot(){
		//delete product record
		$this->db->where('store_timing_slot_id', $_POST['store_timing_slot_id']);
		$this->db->delete('store_timing_slot_master');
		
		die;
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
		$coupon_data = $this->Mdl_Store_Profile->get_single_coupon($coupon_id);
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
		$allcount = $this->Mdl_Store_Profile->getrecordCount_coupons();

		// Get records
		$record = $this->Mdl_Store_Profile->get_coupons_data($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		$grid = '';
		foreach($record as $res){
			$status = 'Active';
			if($res->coupon_status == 0){
			   $status = 'In-Active';
			}
			
			
			//this for table veiw
			$table .= '<tr id="tr-'.$res->coupon_id .'">';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->coupon_name .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->coupon_code .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->coupon_start_date .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->coupon_end_date .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">
							<a onclick="delete_coupon('.$res->coupon_id .')"  style="color: red;padding-right: 7px;"><i class="fas fa-trash-alt"></i></a>
							<a href="'.base_url().'Store_Coupons/update_form/'.$res->coupon_id.'" style="color: blue;padding-right: 7px;"><i class="fas fa-edit"></i></i></a></td>';
			$table .= '</tr>';
			
			//this for grid view
			$grid .=' ';
		}
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['table_view'] = $table;
		$data['grid_view'] = $grid;
		$data['row'] = $rowno;
		
		
		echo json_encode($data);
	}
	
	function coupon_code_exists(){
		$res = $this->Mdl_Store_Profile->coupon_code_exists();
		if($res != NULL){
			echo json_encode(FALSE);
		}else{
			echo json_encode(TRUE);
		}
		die;
	}
	
	function insert_coupon(){
		$this->Mdl_Store_Profile->insert_coupon();
		redirect('Store_Coupons');
	}
	
	function update_coupon(){
		$this->Mdl_Store_Profile->update_coupon();
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
