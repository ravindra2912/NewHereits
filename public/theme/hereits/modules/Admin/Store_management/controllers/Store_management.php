<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_management extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Store_management');
		$this->load->model('Mdl_emails');
		$this->load->library("pagination");
		
		if($this->session->Admin == null)
		{redirect('Admin');}
	}
	Public function index()
	{   
		$data =array(
			'main_content'=>'Store_list',  
			'left_sidebar'=>'Report list', 
					
		);
		$this->load->view('admin_template/template',$data);
	}

	/***************** Parent Category *******************/
	function get_store_data($rowno=0){
		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Store_management->getrecordCount_store();

		// Get records
		$record = $this->Mdl_Store_management->get_store_data($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$result = '';
		foreach($record as $res){
			
			$status = '';
			if($res->store_status == 0){
			   $status = 'Pending for Approval';
			} else if($res->store_status == 1){
				$status = 'Approved';
			}else if($res->store_status == 2){
				$status = 'Disapproved';
			}
			
			
			$referral_code = $this->Mdl_Store_management->get_reffered_user($res->referral_code);
			
			//check image
			$img = base_url().'assets/admin/images/no-image.png';
			if($res->store_image != NULL){
				$path = $res->store_image;
				if(file_exists($path)) { 
					$img = base_url().$path; 
				}
			}
			$result .= '<tr id="tr-'.$res->store_id .'">';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><img src="'.$img.'" style="height: 50px;width: auto;object-fit: contain"/></td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Store_name .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->username .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$referral_code->user_id .'-'.$referral_code->frist_name .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->city .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a href="'.base_url().'Store_management/single_store/'.$res->store_id.'" target=_blanck" style="color: green;padding-right: 7px;"><i class="far fa-eye" style="font-size: 20px;"></i></a></td>';
			$result .= '</tr>';
		}
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $result;
		$data['row'] = $rowno;
		
		
		echo json_encode($data);
	}
	
	function single_store($store_id){
		
		$store_data = $this->Mdl_Store_management->get_single_store_data($store_id);
		$user_data = $this->Mdl_Store_management->user_data($store_id);
		
		$order_count = $this->Mdl_Store_management->getorder_count($store_id);	
		$report_count = $this->Mdl_Store_management->getreport_count($store_id);	
		$booking_count = $this->Mdl_Store_management->getbooking_count($store_id);
		$subscribe = $this->Mdl_Store_management->get_Subscription_data($store_id);
		/***Product count****/
		$allcountproduct = $this->Mdl_Store_management->get_Count_product($store_id);
		$live_products_count= $this->Mdl_Store_management->getlive_product_count($store_id);
		$approved_products_count= $this->Mdl_Store_management->getapproved_product_count($store_id);
		$pending_products_count= $this->Mdl_Store_management->getpending_product_count($store_id);
		
		/***store count****/
		$allcountpackage = $this->Mdl_Store_management->get_Count_package($store_id);
		$approved_package_count = $this->Mdl_Store_management->getapproved_package_count($store_id);
		$live_package_count = $this->Mdl_Store_management->getlive_package_count($store_id);
		$pending_packages_count = $this->Mdl_Store_management->getpending_package_count($store_id);
		
		$data =array(
			'main_content'=>'Store_Dashboard_view',   
			'store_data'=>$store_data,   
			'order_count'=>$order_count,  
			'booking_count'=>$booking_count,
			'report_count'=>$report_count,
			'subscribe'=>$subscribe,
			'user_data'=>$user_data,
			'allcountproduct'=>$allcountproduct,
			'live_products_count'=>$live_products_count,
			'approved_products_count'=>$approved_products_count,
			'allcountpackage'=>$allcountpackage,
			'approved_package_count'=>$approved_package_count,
			'live_package_count'=>$live_package_count,
			'pending_products_count'=>$pending_products_count,
			'pending_packages_count'=>$pending_packages_count,
		);
		$this->load->view('admin_template/template',$data);
	}
	
	function get_data_product($rowno2=0){
		// Row per page
		$rowperpage2 = 10;

		// Row position
		if($rowno2 != 0){
		  $rowno2 = ($rowno2-1) * $rowperpage2;
		}
	 
		// All records count
		$allcountproduct = $this->Mdl_Store_management->getrecordCount_product();

		// Get records
		$recordproduct = $this->Mdl_Store_management->get_product_data($rowno2,$rowperpage2);

		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcountproduct;
		$config['per_page'] = $rowperpage2;
		
		
		$this->pagination->initialize($config);
		$table2 = '';
		foreach($recordproduct as $res){
			
			$parent_category = $this->Mdl_Store_management->parent_category($res->product_parent_category);
			$category = $parent_category->category_name;
						
			$product_img = $this->Mdl_Store_management->product_img($res->product_id);
			
			if($res->product_status == 0){
			   $status = 'ofline';
			}else if($res->product_status == 1){
			   $status = 'Live';
			}
			if($res->p_status == 0){
			   $admin_status = 'Pending For approval';
			}else if($res->p_status == 1){
			   $admin_status = 'Active';
			} else if($res->p_status == 2){
			   $admin_status = 'De-active';
			} else if($res->p_status == 3){
			   $admin_status = 'Deleted';
			} 
			
						
			//check image
			$img = base_url().'assets/admin/images/no-image.png';
			if($product_img != NULL){
				$path = $product_img->image_url;
				if(file_exists($path)) { 
					$img = base_url().$path; 
				}
			}
			$table2 .= '<tr id="tr-'.$res->product_id .'">';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><img src="'.$img.'" style="height: 60px;width: 60px;"/></td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->p_name .'</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$category .'</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$admin_status .'</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a onclick="edit_model_product('.$res->product_id.')"  style="color: green;padding-right: 7px;"><i class="far fa-eye" style="font-size: 20px;"></i></a> <a href="'.base_url().'Product_management/Product_details/'.$res->product_id.'" target=_blanck" style="color: green;padding-right: 7px;"><i class="fas fa-arrow-circle-right" style="font-size: 20px;"></i></a></td>';
			$table2 .= '</tr>';
		}
	
		$data['pagination2'] = $this->pagination->create_links();
		$data['table2'] = $table2;
		$data['row2'] = $rowno2;
		
		echo json_encode($data);
	}
	
	function get_data_Packages($rowno3=0){
		// Row per page
		$rowperpage3 = 10;

		// Row position
		if($rowno3 != 0){
		  $rowno3 = ($rowno3 -1) * $rowperpage3;
		}
	 
		// All records count
		$allcountpackage = $this->Mdl_Store_management->getrecordCount_package();

		$recordpackage = $this->Mdl_Store_management->get_package_data($rowno2,$rowperpage2);

		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcountpackage;
		$config['per_page'] = $rowperpage3;
		
		
		$this->pagination->initialize($config);
		$table3 = '';
		foreach($recordpackage as $res){
			
			$package_category = $this->Mdl_Store_management->package_category($res->main_category);
			$category = $package_category->category_name;
	
			if($res->packege_status == 0){
			   $status = 'Ofline';
			} if($res->packege_status == 1){
			   $status = 'Live';
			} 
			
			if($res->p_status == 0){
			   $admin_status = 'Pending for Approval';
			} if($res->p_status == 1){
			   $admin_status = 'Active';
			} if($res->p_status == 2){
			   $admin_status = 'De-active';
			} if($res->p_status == 3){
			   $admin_status = 'Deleted';
			} 
			
			
						
			$path = $res->packege_image;
			if(file_exists($path)) { 
					$img = base_url().$path; 
				}
		
			$table3 .= '<tr id="tr-'.$res->Package_id .'">';
			$table3 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><img src="'.$img.'" style="height: 60px;width: 60px;"/></td>';
			$table3 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Package_name .'</td>';
			$table3 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$category .'</td>';
			$table3 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$admin_status .'</td>';
			$table3 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table3 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a onclick="edit_model('.$res->Package_id.')" style="color: green;padding-right: 7px;"><i class="far fa-eye" style="font-size: 20px;"></i></a><a href="'.base_url().'Package_management/Package_details/'.$res->Package_id.'" style="color: green;padding-right: 7px;"><i class="fas fa-arrow-circle-right" style="font-size: 20px;"></i></a></td> ';
			$table3 .= '</tr>';
		}
	
		$data['pagination2'] = $this->pagination->create_links();
		$data['table3'] = $table3;
		$data['row3'] = $rowno3;
		
		echo json_encode($data);
	}
	
	function edit_store($store_id){
		$store_data = $this->Mdl_Store_management->get_single_store_data($store_id);
		
		//google import js
		$header_import = '<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>';
		
		//Google map
		$footer_import .= '<script src="'.base_url().'assets/admin/custom_js/google_map.js"></script>';
		$footer_import .= '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApYAW3LEn3K2hO8jdq0O-fULmBmREdFtc&callback=initAutocomplete&libraries=places&region=in"></script>';
		
		
		$data =array(
			'main_content'=>'single_Store',   
			'store_data'=>$store_data,   
			'header_import'=>$header_import,   
			'footer_import'=>$footer_import, 
		);
		$this->load->view('admin_template/template',$data);
	}
	
	function get_single_product_data($id){
		$response = $this->Mdl_Store_management->get_single_product_data($id);
		echo json_encode($response);
	}
	function update_sinle_store_product(){
		
		$this->Mdl_Store_management->update_sinle_store_product();
		die;
	}
	
	function get_single_package_data($id){
		$response = $this->Mdl_Store_management->get_single_package_data($id);

		echo json_encode($response);
	}
	
	function update_sinle_store_package(){
		
		$this->Mdl_Store_management->update_sinle_store_package();
		die;
	}
	
	function update_store(){
		
		$store_data = $this->Mdl_Store_management->get_single_store_data($_POST['store_id']);
		
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
		
		$this->Mdl_Store_management->update_store();
		
		//mail
		if($store_data->store_status != 1 && $_POST['store_status'] == 1 ){
			$this->Mdl_emails->store_verified_email($_POST['store_id']);
		}
		$this->single_store($_POST['store_id']);
	}
	
	
	function insert_parent_category(){ 
		$img = '';
		if($_FILES['category_image'] != null)
		{
			$target_path = "uploads/category_image/";
			$ext = explode('.', basename($_FILES['category_image']['name']));
			$digits = 2;
			$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
			$c_name = time().'-'.$rands . "." . $ext[count($ext) - 1];
			$c_image = $target_path . $c_name;
			move_uploaded_file($_FILES['category_image']['tmp_name'], $c_image);
			if(file_exists($c_image)) {
				$img = $target_path.$c_name;
			}
		}
		$this->Mdl_Store_management->insert_parent_category($img);
		die;
	}
	
	function parent_category_exists(){
		$res = $this->Mdl_Store_management->parent_category_exists();
		
		if($res != NULL){
			echo json_encode(FALSE);
		}else{
			echo json_encode(TRUE);
		}
		die;
	}
	
	function get_single_parent_cat(){
		$res = $this->Mdl_Store_management->get_single_parent_cat($_POST['id']);
		
		$data ='
				<input type="hidden" name="id" id="update_id" value="'.$res->category_id.'" />
				<div class="card-body">
					<div class="row">
						<div class="col-4">
							<div class="form-group">
								<label>Image</label>
								<input type="file" name="category_image" class="form-control" placeholder="Category Name" >
							</div>
						</div>
						<div class="col-4">
							<div class="form-group">
								<label>Category Name</label>
								<input type="text" value="'.$res->category_name.'" id="update_category_name" name="category_name" class="form-control" placeholder="Category Name" >
							</div>
						</div>
						
						<div class="col-4">
							<div class="form-group">
								<label>Category Tags</label>
								<input type="text" value="'.$res->category_tag.'" name="category_tag" class="form-control" placeholder="Category Tags" >
							</div>
						</div>
						
						
						<div class="col-md-4">
							<div class="form-group">
								<label>Status </label>
								<select class="form-control" name="category_status" required>
									<option value="">Status</option>
									<option value="1" '; if($res->category_status == 1){$data .='selected';} $data .='>Active</option>
									<option value="0"'; if($res->category_status == 0){$data .='selected';} $data .='>In-Active</option>
									
								</select>
							</div> 
						</div>
						
						
					</div>
                </div>
		';
		
		echo $data;
	}
	
	function update_parent_category(){
		
		//image upload
		if($_FILES['category_image']['name'] != null)
		{
			$res = $this->Mdl_Store_management->get_single_parent_cat($_POST['id']);
			//delete image
			$path = $res->category_image;
			if(file_exists($path)) { unlink($path); }
			
			$target_path = "uploads/category_image/";
			$ext = explode('.', basename($_FILES['category_image']['name']));
			$digits = 2;
			$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
			$c_name = time().'-'.$rands . "." . $ext[count($ext) - 1];
			$c_image = $target_path . $c_name;
			move_uploaded_file($_FILES['category_image']['tmp_name'], $c_image);
			if(file_exists($c_image)) {
				 
			$_POST['category_image'] = $target_path.$c_name;
			}
		}
		//update record
		$this->Mdl_Store_management->update_parent_category();
		
		//return Updated Record
		$res = $this->Mdl_Store_management->get_single_parent_cat($_POST['id']);
		
		$status = 'Active';
		if($res->category_status == 0){ $status = 'In-Active'; }
		
		$path = $res->category_image;
		if(file_exists($path)) { 
			$img = base_url().$path; 
		}else{
			$img = base_url().'assets/admin/images/no-image.png';
		}
			
		$tr ='<td class="text-center" style="padding: .20rem; vertical-align: unset;"><img src="'.$img.'" style="height: 80px;width: 80px;"/></td>';	
		$tr .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->category_name .'</td>';
		$tr .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$status .'</td>';
		$tr .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a onclick="deletes('.$res->category_id.')"  style="color: red;padding-right: 7px;"><i class="fas fa-trash-alt"></i></a><a onclick="edit_model('.$res->category_id .')"  style="color: blue;padding-right: 7px;"><i class="fas fa-edit"></i></i></a></td>';
         echo $tr;
	}
	
	
	function deletes_parent_category(){
		$res = $this->Mdl_Store_management->get_single_parent_cat($_POST['id']);
		//delete image
		$path = $res->category_image;
		if(file_exists($path)) { unlink($path); }
		
		$this->Mdl_Store_management->deletes_parent_category($_POST['id']);
	}
	
	
	
	
}
?>
