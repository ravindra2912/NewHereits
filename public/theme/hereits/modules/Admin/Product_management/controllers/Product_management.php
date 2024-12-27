<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_management extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Product_management');
		$this->load->library("pagination");
		
		if($this->session->Admin == null)
		{redirect('Admin');}
	}
	
	
	Public function index()
	{ 
	//$getstoreid=$_GET['store_id'];
		
		$data =array(
			'main_content'=>'Product_list', 
			'left_sidebar'=>'Product list', 
			
		);
		$this->load->view('admin_template/template',$data);
	}
	
	
	//ajex get Coupons list
	function get_Product_data($rowno=0){
		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Product_management->getallrecord_product();
		
		
		// Get records
		$record = $this->Mdl_Product_management->get_Product_data($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Product_management/";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$table = '';
		
		foreach($record as $res){
			
			if($res->product_status == 0){
			   $status = 'PENDING FOR APPROVEL';
			}else if($res->product_status == 1){
				$status = 'Active';
			}else if($res->product_status == 2){
				$status = 'Deactive';
			}else if($res->product_status == 3){
				$status = 'Deleted';
			}
			
			if($res->request_store_id == 0){
				$uploadby = 'Admin';
			} else {
				$Get_store = $this->Mdl_Product_management->Get_store($res->request_store_id);
				$uploadby = $Get_store->Store_name;
				}
			
			
		
			$date_time  = date_format(date_create($res->created_at), 'd-m-Y H:i');
	
			//this for table veiw
			$table .= '<tr id="tr-'.$res->product_id .'">';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->product_id .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; width: 600px; vertical-align: unset;">'.$res->product_name	 .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->product_price .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->product_sele_price .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; width: 150px; vertical-align: unset;">'. $uploadby .'</td>';
			$table .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">
					<a href="'.base_url().'Product_management/Product_details/'.$res->product_id.'" style="color: blue;padding-right: 7px;"><i class="fas fa-eye"></i></i></a>
					</td>';
			$table .= '</tr>';
		}
	
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['table_view'] = $table;
		$data['row'] = $rowno;
	
		echo json_encode($data);
	}
	
	
	/*********************** product INsert********************************/
	
	//view
	function Product_insert(){
		$parent_cat_data = $this->Mdl_Product_management->get_all_parent_category();
		
		$header_import = '<script src="'.base_url().'assets/tags/tagcomplete.js"></script>
							<link rel="stylesheet" href="'.base_url().'assets/tags/tag.css">'; 
							
		$data =array(
			'main_content'=>'Product_insert', 
			'parent_cat_data'=>$parent_cat_data,
			'header_import'=>$header_import,
			);
		$this->load->view('admin_template/template',$data);
	}
	
	//insert
	function insert_product(){
		$pid = $this->Mdl_Product_management->insert_product();
		
		redirect('Product_management/Product_image?id='.$pid);
	}
	
	
	//image 
	function Product_image(){
	    $product_id = $_GET['id'];
		$data =array(
			'main_content'=>'Product_image',   
			'product_id'=>$product_id,   
					);
		$this->load->view('admin_template/template',$data);
	}
	
	
	/************************** product details **********************/
	function get_child_category(){
		$res = $this->Mdl_Product_management->get_child_category($_POST['parent_id']);
		
		$data = '<option value="">Select Child Category</option>';
		foreach($res as $val){
			$data .= '<option value="'.$val->category_id.'">'.$val->category_name.'</option>';
		}
		echo $data;
	}
	
	function Product_details($id){
		
		$Product_details = $this->Mdl_Product_management->Get_Product_details($id);
	
		$store= $this->Mdl_Product_management->Get_store($Product_details->request_store_id);
				
		$product_img = $this->Mdl_Product_management->Get_product_img($id);
		
		$get_item = $this->Mdl_Product_management->Get_item_details($id);
//		$order_details = $this->Mdl_Product_management->Get_order_details($get_item->order_id);
		
		$fav_count =$this->Mdl_Product_management->fav_count($get_item->item_id);
		$report_count =$this->Mdl_Product_management->report_count($get_item->item_id);
						
		$data =array(
			'main_content'=>'Product_details', 
			'left_sidebar'=>'Product details', 			
			'Product_details'=>$Product_details,   
			'store'=>$store,   
			'product_img'=>$product_img,   
			'fav_count'=>$fav_count,   
			'get_item'=>$get_item,   
			'report_count'=>$report_count,   
		);
		$this->load->view('admin_template/template',$data);
	}
	
	function Change_product_status(){
		$this->Mdl_Product_management->Change_product_status();
		die;
	}
	function get_tag()
	{
		$tags = $this->Mdl_Product_management->get_tag();
		echo json_encode($tags);
	}
	// ******************* orders product ************************
	function get_order_data($rowno=0){
		// Row per page
		$rowperpage = 10;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Product_management->getallrecord_order();
		$orders_count = $this->Mdl_Product_management->getallrecord_order();

		// Get records
		$record = $this->Mdl_Product_management->get_order_data($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Product_management/";
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
	
	// ******************* STore displays product ************************
	
	function get_store_data($rowno2=0){
		// Row per page
		$rowperpage2 = 10;

		// Row position
		if($rowno2 != 0){
		  $rowno2 = ($rowno2-1) * $rowperpage2;
		}
	 
		// All records count
		$allcountstore = $this->Mdl_Product_management->getallrecord_store();
	
		// Get records
		$storedata = $this->Mdl_Product_management->get_store_data($rowno2,$rowperpage2);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Product_management/";
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

	function Product_update($id){
		$Product_details = $this->Mdl_Product_management->Get_Product_details($id);
		$parent_cat_data = $this->Mdl_Product_management->get_all_parent_category();
		$child_cat_data = $this->Mdl_Product_management->get_child_category($Product_details->product_parent_category );
		
		$header_import = '<script src="'.base_url().'assets/tags/tagcomplete.js"></script>
							<link rel="stylesheet" href="'.base_url().'assets/tags/tag.css">';

		$tags = $this->Mdl_Product_management->get_tags($id);

		
		$tag = '';
		for($i =0 ;$i <= count($tags) - 1 ; $i++ ){
			if($i == count($tags)-1){
				$tag .= $tags[$i]->tag;
			}else{
				$tag .= $tags[$i]->tag.',';
			}
		}
		$data =array(
			'main_content'=>'Product_update', 
			'header_import'=>$header_import,
			'Product_details'=>$Product_details, 
			'product_img'=>$product_img, 
			'child_cat_data'=>$child_cat_data,   
			'parent_cat_data'=>$parent_cat_data,
			'tag'=>$tag,
			
		);
		$this->load->view('admin_template/template',$data);
	}
	function update_product(){
		$this->Mdl_Product_management->update_product();
		redirect('Product_management');
	}

	
	// for image
	function get_product_images(){
		$res = $this->Mdl_Product_management->get_product_images();
		$data = '';
		foreach($res as $val){
			$data .='
				<div class="filtr-item col-sm-2" id="product_img-'.$val->id.'" style="margin-top: 10px;">
					<div style="height: 150px;text-align: center;">
						<img onclick="image_view_modal(this.src)" src="'.base_url().$val->image_url.'" class="img-fluid mb-2" alt="Product Image" style="max-height: 145px;"/> 
					</div>
					<div class="row">
						<div class="col-sm-10">
							<input id="order-'.$val->id.'" onchange="chnage_image_order('.$val->id.')" type="text" name="product_sele_price" value="'.$val->image_order.'" class="form-control" >
						</div>
						<div class="col-sm-2" style="margin-top: 8px;">
							<a onclick="delete_product_image('.$val->id.')" style="color: red;"><i class="fas fa-trash-alt"></i></a>
						</div>
					</div>
				</div>
			';
		}
		echo $data;
		die;
	}
	
	function add_product_image(){
		
		if($_FILES['product_images']['name'] != null)
		{
			$target_path = "uploads/product_images/";
			$ext = explode('.', basename($_FILES['product_images']['name']));
			$digits = 2;
			$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
			$c_name = time().'-'.$rands . "." . $ext[count($ext) - 1];
			$c_image = $target_path . $c_name;
			move_uploaded_file($_FILES['product_images']['tmp_name'], $c_image);
			if(file_exists($c_image)) {
				$img = $target_path.$c_name;
				$this->Mdl_Product_management->insert_product_images($img);
			}
		}
		die;
	}
	
	function chnage_product_image_order(){
		$this->Mdl_Product_management->chnage_product_image_order();
		die;
	}
	
	function Product_delete($id){
		$this->Mdl_Product_management->Product_delete($id);
		redirect('Product_management');
	}
	
	function delete_product_image(){
		$res = $this->Mdl_Product_management->get_single_product_img($_POST['id']);
		//delete image
		$path = $res->image_url;
		if(file_exists($path)) { unlink($path); }
		
		//delete record
		$this->db->where('id', $_POST['id']);
		$this->db->delete('product_image_master');
		die;
	}
	
}
?>
