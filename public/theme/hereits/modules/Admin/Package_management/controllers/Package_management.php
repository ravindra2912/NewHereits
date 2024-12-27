<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package_management extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Package_management');
		$this->load->library("pagination");
		
		if($this->session->Admin == null)
		{redirect('Admin');}
	}

	Public function index()
	{ 
	//$getstoreid=$_GET['store_id'];
		
		$data =array(
			'main_content'=>'Package_list', 
			'left_sidebar'=>'Package list', 
			
		);
		$this->load->view('admin_template/template',$data);
	}

	//ajex get Coupons list
	function get_package_data($rowno=0){
		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Package_management->getallrecord_package();
		
		
		// Get records
		$record = $this->Mdl_Package_management->get_package_data($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Package_management/";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		
		foreach($record as $res){
			
			if($res->packege_status == 1){
				$status = 'Active';
			}else if($res->packege_status == 2){
				$status = 'Deactive';
			}else if($res->packege_status == 0){
			   $status = 'PENDING FOR APPROVEL';
			}else if($res->packege_status == 3){
			   $status = 'Deleted';
			}
			
			if($res->request_store_id == 0){
				$uploadby = 'Admin';
			} else {
				$Get_store = $this->Mdl_Package_management->Get_store($res->request_store_id);
				$uploadby = $Get_store->Store_name;
				}
			
			
		
			$date_time  = date_format(date_create($res->created_at), 'd-m-Y H:i');
	
			//this for table veiw
			$table .= '<tr id="tr-'.$res->Package_id .'">';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Package_id .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Package_name	 .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->packege_price .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->packege_sale_price .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $uploadby .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">
					<a href="'.base_url().'Package_management/Package_details/'.$res->Package_id.'" style="color: blue;padding-right: 7px;"><i class="fas fa-eye"></i></i></a>
					</td>';
			$table .= '</tr>';
		}
	
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['table_view'] = $table;
		$data['row'] = $rowno;
	
		echo json_encode($data);
	}
	
	
	/*********************** packege INsert********************************/
	
	//view
	function Package_insert(){
		$parent_cat_data = $this->Mdl_Package_management->get_all_parent_category();
		$header_import = '<script src="'.base_url().'assets/tags/tagcomplete.js"></script>
							<link rel="stylesheet" href="'.base_url().'assets/tags/tag.css">'; 
		
		$data =array(
			'main_content'=>'Package_insert', 
			'parent_cat_data'=>$parent_cat_data,
			'header_import'=>$header_import,
			);
		$this->load->view('admin_template/template',$data);
	}
	
	//insert
	function insert_packege(){
	
		if($_FILES['packege_image']['name'] != null)
			{   
  			
					$target_path = "uploads/packege_images/";
					$ext = explode('.', basename($_FILES['packege_image']['name']));
					$digits = 4;
					$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
					$c_name = $_POST['Package_id'].'-'.time().'-'. $rands . "." . $ext[count($ext) - 1];
					$c_image = $target_path . $c_name;
					move_uploaded_file($_FILES['packege_image']['tmp_name'], $c_image);
					$this->Mdl_Package_management->insert_packege($c_image);
					redirect('Package_management');
				
			} 	
	}
	
	
	function Package_details($id){
		
		$Package_details = $this->Mdl_Package_management->Get_Package_details($id);
		$store= $this->Mdl_Package_management->Get_store($Package_details->request_store_id);
		$get_item = $this->Mdl_Package_management->Get_item_details($id);
//		$order_details = $this->Mdl_Package_management->Get_order_details($get_item->order_id);
		
		$fav_count =$this->Mdl_Package_management->fav_count($get_item->item_id);
		$report_count =$this->Mdl_Package_management->report_count($get_item->item_id);
						
		$data =array(
			'main_content'=>'Package_details', 
			'left_sidebar'=>'packege details', 			
			'Package_details'=>$Package_details,   
			'store'=>$store,      
			'fav_count'=>$fav_count,   
			'get_item'=>$get_item,   
			'report_count'=>$report_count,   
		);
		$this->load->view('admin_template/template',$data);
	}
	
	function Change_Package_status(){
		$this->Mdl_Package_management->Change_Package_status();
		die;
	}
	
	// ******************* orders packege ************************
	function get_order_data($rowno=0){
		// Row per page
		$rowperpage = 10;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Package_management->getallrecord_order();
		$orders_count = $this->Mdl_Package_management->getallrecord_order();

		// Get records
		$record = $this->Mdl_Package_management->get_order_data($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Package_management/";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';	
		foreach($record as $res){
			if($res->order_status == 0){
			   $status = '<button type="button" class="btn btn-warning btn-xs">Pending For Approval</button>';
			}else if($res->order_status == 1){
				$status = '<button type="button" class="btn btn-success btn-xs">Accept By Store</button>';
			}else if($res->order_status == 2){
				$status = '<button type="button" class="btn btn-danger btn-xs">Reject By Store</button>';
			}else if($res->order_status == 3){
				$status = '<button type="button" class="btn btn-danger btn-xs">Reject By User</button>';
			}else if($res->order_status == 4){
				$status = '<button type="button" class="btn btn-info btn-xs">Shipped</button>';
			}else if($res->order_status == 5){
				$status = '<button type="button" class="btn btn-danger btn-xs">Return</button>';
			}else if($res->order_status == 6){
				$status = '<button type="button" class="btn btn-success btn-xs">Order completed</button>';
			}else if($res->order_status == 7){
				$status = '<button type="button" class="btn btn-danger btn-xs">Cancel by Customer</button>';
			}else if($res->order_status == 8){
				$status = '<button type="button" class="btn btn-danger btn-xs">Cancel By Store</button>';
			}
			
			if($res->delivery_type == 1){
				$delivery_type = 'Pickup At Store';
			}else if($res->delivery_type == 2){
				$delivery_type = 'Home Delivery';
			}
			
			$date_time  = date_format(date_create($res->created_at), 'd-m-Y H:i');
			
			
			//this for table veiw
			$table .= '<tr id="tr-'.$res->order_id .'">';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->order_id .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $date_time .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->username	 .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->contact .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Store_name .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $delivery_type .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">
					<a href="'.base_url().'Order_management/Order_details/'.$res->order_id.'" style="color: blue;padding-right: 7px;"><i class="fas fa-eye"></i></i></a>
					</td>';
			$table .= '</tr>';
			
			//this for grid view
			
		}
		
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['table_view'] = $table;
		$data['row'] = $rowno;
		$data['orders_count'] = $orders_count;
		
		
		echo json_encode($data);
	}
	
	// ******************* STore displays packege ************************
	
	function get_store_data($rowno2=0){
		// Row per page
		$rowperpage2 = 10;

		// Row position
		if($rowno2 != 0){
		  $rowno2 = ($rowno2-1) * $rowperpage2;
		}
	 
		// All records count
		$allcountstore = $this->Mdl_Package_management->getallrecord_store();
	
		// Get records
		$storedata = $this->Mdl_Package_management->get_store_data($rowno2,$rowperpage2);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Package_management/";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcountstore;
		$config['per_page'] = $rowperpage2;
		
		
		$this->pagination->initialize($config);
		$table2 = '';	
		foreach($storedata as $res){
					
			//this for table veiw
			$table2 .= '<tr id="tr-'.$res->store_id .'">';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->store_id .'</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->Store_name	 .'</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->store_contact .'</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->store_email .'</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->city.'-'.$res->pincode.'</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->state.'</td>';
			$table2 .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">
					<a href="'.base_url().'Store_management/single_store/'.$res->store_id.'" style="color: blue;padding-right: 7px;"><i class="fas fa-eye"></i></i></a>
					</td>';
			$table2.= '</tr>';	
		}
		// Initialize $data Array
		$data['pagination2'] = $this->pagination->create_links();
		$data['table_view2'] = $table2;
		$data['row2'] = $rowno2;
		$data['allcountstore'] = $allcountstore;
		echo json_encode($data);
	}
	function get_tag()
	{
		$tags = $this->Mdl_Package_management->get_tag();
		echo json_encode($tags);
	}
	function Package_update($id){
		$Package_details = $this->Mdl_Package_management->Get_Package_details($id);
		$parent_cat_data = $this->Mdl_Package_management->get_all_parent_category();
		$header_import = '<script src="'.base_url().'assets/tags/tagcomplete.js"></script>
							<link rel="stylesheet" href="'.base_url().'assets/tags/tag.css">';
		
		$tags = $this->Mdl_Package_management->get_tags($id);
		$tag = '';
		for($i =0 ;$i <= count($tags) - 1 ; $i++ ){
			if($i == count($tags)-1){
				$tag .= $tags[$i]->tag;
			}else{
				$tag .= $tags[$i]->tag.',';
			}
		}
		
		$data =array(
			'main_content'=>'Package_update', 
			'header_import'=>$header_import,
			'Package_details'=>$Package_details, 
			'parent_cat_data'=>$parent_cat_data,
			'tag'=>$tag,
		);
		$this->load->view('admin_template/template',$data);
	}
	function update_package(){

		if($_FILES['packege_image']['name'] != null)
			{   
  			
					$target_path = "uploads/packege_images/";
					$ext = explode('.', basename($_FILES['packege_image']['name']));
					$digits = 4;
					$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
					$c_name = $_POST['Package_id'].'-'.time().'-'. $rands . "." . $ext[count($ext) - 1];
					$c_image = $target_path . $c_name;
					move_uploaded_file($_FILES['packege_image']['tmp_name'], $c_image);
					
					if(file_exists($c_image)) 
					{
						$_POST['packege_image'] = $c_image;
						
						$Package_details = $this->Mdl_Package_management->Get_Package_details($_POST['Package_id']);
						$path = $Package_details->packege_image;
						
					if(file_exists($path)) 
						{
							unlink($path);
						}
						
					}
					
			} 
		$this->Mdl_Package_management->update_package();
		redirect('Package_management');
	}

	function Package_delete(){
		
		$this->Mdl_Package_management->Package_delete();
		
	}
	
}
?>
