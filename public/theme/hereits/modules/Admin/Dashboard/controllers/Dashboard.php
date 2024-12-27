<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		if($this->session->Admin == null)
		{ redirect('Admin');}
		$this->load->model('Mdl_dashboard');
		$this->load->library("pagination");
	}
	Public function index()
	{ 
		$pendingstore_count = $this->Mdl_dashboard->pending_reg_count();
		$data =array(
				'main_content'=>'dashboard',
				'left_sidebar'=>'Dashboard', 
				'pendingstore_count'=>$pendingstore_count, 
				
			);
			$this->load->view('admin_template/template',$data); 
	}
	
	
	
	function get_store_data($rowno=0){
		// Row per page
		$rowperpage = 10;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_dashboard->getrecordCount_store();

		// Get records
		$record = $this->Mdl_dashboard->get_store_data($rowno,$rowperpage);
		
		$users_count = $this->Mdl_dashboard->getuser_count();	
		$store_count = $this->Mdl_dashboard->getstore_count();	
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$result = '';
		foreach($record as $res){
			
			
			if($res->store_type == 1){
			   $store_type = 'Product';
			}else if($res->store_type == 2){
			   $store_type = 'Service';
			}else if($res->store_type == 3){
			   $store_type = 'Product and Service';
			}
			
			if($res->store_status == 0){
			   $status = 'Pending for Approval';
			} 
			
						
			//check image
			$img = base_url().'assets/admin/images/no-image.png';
			if($res->store_image != NULL){
				$path = $res->store_image;
				if(file_exists($path)) { 
					$img = base_url().$path; 
				}
			}
			$result .= '<tr id="tr-'.$res->store_id .'">';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><img src="'.$img.'" style="height: 60px;width: 60px;"/></td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Store_name .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->username .'</td>';
			//$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$store_type .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->city .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a href="'.base_url().'Store_management/single_store/'.$res->store_id.'" target=_blanck" style="color: green;padding-right: 7px;"><i class="far fa-eye" style="font-size: 20px;"></i></a></td>';
			$result .= '</tr>';
		}
		
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $result;
		$data['row'] = $rowno;
		$data['users_count'] = $users_count;
		$data['store_count'] = $store_count;
		
		
		echo json_encode($data);
	}
	
	function get_data_product($rowno2=0){
		// Row per page
		$rowperpage2 = 10;

		// Row position
		if($rowno2 != 0){
		  $rowno2 = ($rowno2-1) * $rowperpage2;
		}
	 
		// All records count
		$allcountproduct = $this->Mdl_dashboard->getrecordCount_product();

		// Get records
		$recordproduct = $this->Mdl_dashboard->get_product_data($rowno2,$rowperpage2);

		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcountproduct;
		$config['per_page'] = $rowperpage2;
		
		
		$this->pagination->initialize($config);
		$table2 = '';
		foreach($recordproduct as $res){
			
			$parent_category = $this->Mdl_dashboard->parent_category($res->product_parent_category);
			$category = $parent_category->category_name;
			
			$request_store_id = $this->Mdl_dashboard->request_store_id($res->request_store_id);
			$store_name = $request_store_id->Store_name;
			
			$product_img = $this->Mdl_dashboard->product_img($res->product_id);
			
			if($res->product_status == 0){
			   $status = 'Pending for Approval';
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
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->product_name .'</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$store_name .'</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$category .'</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a href="'.base_url().'Product_management/Product_details/'.$res->product_id.'" target=_blanck" style="color: green;padding-right: 7px;"><i class="far fa-eye" style="font-size: 20px;"></i></a></td>';
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
		$allcountpackage = $this->Mdl_dashboard->getrecordCount_package();

		$recordpackage = $this->Mdl_dashboard->get_package_data($rowno3,$rowperpage3);

		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcountpackage;
		$config['per_page'] = $rowperpage3;
		
		
		$this->pagination->initialize($config);
		$table3 = '';
		foreach($recordpackage as $res){
			
			$package_category = $this->Mdl_dashboard->package_category($res->main_category);
			$category = $package_category->category_name;
			
			$request_store_id = $this->Mdl_dashboard->request_store_id($res->request_store_id);
			$store_name = $request_store_id->Store_name;
						
			if($res->packege_status == 0){
			   $status = 'Pending for Approval';
			} 
			
						
			$path = $res->packege_image;
			if(file_exists($path)) { 
					$img = base_url().$path; 
				}
			
			$table3 .= '<tr id="tr-'.$res->Package_id .'">';
			$table3 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><img src="'.$img.'" style="height: 60px;width: 60px;"/></td>';
			$table3 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Package_name .'</td>';
			$table3 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$store_name .'</td>';
			$table3 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$category .'</td>';
			$table3 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table3 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a href="'.base_url().'Package_management/Package_details/'.$res->Package_id.'" target=_blanck" style="color: green;padding-right: 7px;"><i class="far fa-eye" style="font-size: 20px;"></i></a></td>';
			$table3 .= '</tr>';
		}
	
		$data['pagination2'] = $this->pagination->create_links();
		$data['table3'] = $table3;
		$data['row3'] = $rowno3;
		
		echo json_encode($data);
	}

	function get_semi_approved_users($rowno4=0){
		// Row per page
		$rowperpage4 = 10;

		// Row position
		if($rowno4 != 0){
		  $rowno4 = ($rowno4 -1) * $rowperpage4;
		}
	 
		// All records count
		$allcountpackage = $this->Mdl_dashboard->get_semi_verfied_Count_users();

		$recordpackage = $this->Mdl_dashboard->get_semi_approved_users_data($rowno4,$rowperpage4);

		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcountpackage;
		$config['per_page'] = $rowperpage4;
		
		
		$this->pagination->initialize($config);
		$table4 = '';
		foreach($recordpackage as $res){
			
			if($res->user_status == 0){
			   $status = 'Pending for Approval';
			} if($res->user_status == 1){
			   $status = 'Active';
			} 
			
			if($res->gender == NULL){
			   $gender = ' ';
			} elseif($res->gender == 0){
			   $gender = 'Female';
			}elseif($res->gender == 1){
			   $gender = 'Male';
			}elseif($res->gender == 2){
			   $gender = 'Others';
			}
			
			
						
			$path = $res->user_image;
			if(file_exists($path)) { 
					$img = base_url().$path; 
				}
			
			$table4 .= '<tr id="tr-'.$res->user_id .'">';
			$table4 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><img src="'.$img.'" style="height: 60px;width: 60px;"/></td>';
			$table4 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->username .'</td>';
			$table4 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->email .'</td>';
			$table4 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$gender.'</td>';
			$table4 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table4 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a href="'.base_url().'User_management/edit_user/'.$res->user_id.'" target=_blanck" style="color: green;padding-right: 7px;"><i class="far fa-eye" style="font-size: 20px;"></i></a></td>';
			$table4 .= '</tr>';
		}
	
		$data['pagination4'] = $this->pagination->create_links();
		$data['table4'] = $table4;
		$data['row4'] = $rowno4;
		
		echo json_encode($data);
	}
	
	function get_semi_approved_stores($rowno5=0){
		// Row per page
		$rowperpage5 = 10;

		// Row position
		if($rowno5 != 0){
		  $rowno5 = ($rowno5 -1) * $rowperpage5;
		}
	 
		// All records count
		$allcountpackage = $this->Mdl_dashboard->get_semi_verfied_Count_stores();

		$recordpackage = $this->Mdl_dashboard->get_semi_approved_stores_data($rowno5,$rowperpage5);

		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcountpackage;
		$config['per_page'] = $rowperpage5;
		
		
		$this->pagination->initialize($config);
		$table5 = '';
		foreach($recordpackage as $res){
			if($res->store_type == 1){
			   $store_type = 'Product';
			}else if($res->store_type == 2){
			   $store_type = 'Service';
			}else if($res->store_type == 3){
			   $store_type = 'Product and Service';
			}
			
			if($res->store_status == 0){
			   $status = 'Pending for Approval';
			} else if($res->store_status == 1){
			   $status = 'Active';
			} else if($res->store_status == 2){
			   $status = 'In-Active';
			} 
			
						
			//check image
			$img = base_url().'assets/admin/images/no-image.png';
			if($res->store_image != NULL){
				$path = $res->store_image;
				if(file_exists($path)) { 
					$img = base_url().$path; 
				}
			}
			$table5 .= '<tr id="tr-'.$res->store_id .'">';
			$table5 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><img src="'.$img.'" style="height: 60px;width: 60px;"/></td>';
			$table5 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Store_name .'</td>';
			$table5 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->username .'</td>';
			//$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$store_type .'</td>';
			$table5 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->city .'</td>';
			$table5 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table5 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a href="'.base_url().'Store_management/single_store/'.$res->store_id.'" target=_blanck" style="color: green;padding-right: 7px;"><i class="far fa-eye" style="font-size: 20px;"></i></a></td>';
			$table5 .= '</tr>';
		}
	
		$data['pagination5'] = $this->pagination->create_links();
		$data['table5'] = $table5;
		$data['row5'] = $rowno5;
		
		echo json_encode($data);
	}
	function invoice(){
		$data =array(
				'main_content'=>'invoice',
				'left_sidebar'=>'Invoice', 
				//'all_view' => $all_view, 
			);
			$this->load->view('invoice',$data); 
	}
	
	Public function Pending_Reg_list()
	{ 
		$data =array(
				'main_content'=>'Pending_Reg_list',
				'left_sidebar'=>'Dashboard', 
			);
			$this->load->view('admin_template/template',$data); 
	}
	function get_pending_reg_data($rowno=0){
		// Row per page
		$rowperpage = 10;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_dashboard->get_pending_reg_count();

		// Get records
		$record = $this->Mdl_dashboard->get_pending_reg($rowno,$rowperpage);
	
		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$result = '';
		foreach($record as $res){
			
			
			if($res->Registration_completed  == 1){
			   $status = 'Complete';
			}else if($res->Registration_completed == 0){
			   $status = 'Incomplete';
			}
			
			$result .= '<tr id="tr-'.$res->store_id .'">';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Phone_no  .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $res->created_at .'</td>';
			$result .= '</tr>';
		}
		
		
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $result;
		$data['row'] = $rowno;
		
		echo json_encode($data);
	}
}
?>
