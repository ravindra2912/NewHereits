<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_management extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Category_management');
		$this->load->library("pagination");
		
		if($this->session->Admin == null)
		{redirect('Admin');}
	}
	Public function Service_parent()
	{   
		$header_import = '<script src="'.base_url().'assets/tags/tagcomplete.js"></script>
							<link rel="stylesheet" href="'.base_url().'assets/tags/tag.css">'; 
		
		$data =array(
			'main_content'=>'Service_parent', 	
			'header_import'=>$header_import,			
		);
		$this->load->view('admin_template/template',$data);
	}
	
	Public function Product_parent()
	{   
		$header_import = '<script src="'.base_url().'assets/tags/tagcomplete.js"></script>
							<link rel="stylesheet" href="'.base_url().'assets/tags/tag.css">'; 
		
		$data =array(
			'main_content'=>'Product_parent',
			'header_import'=>$header_import,
		);
		$this->load->view('admin_template/template',$data);
	}
	
	function get_tag()
	{
		$tags = $this->Mdl_Category_management->get_tag();
		echo json_encode($tags);
	}
	function edit_tags($id){
		$tags = $this->Mdl_Category_management->edit_tags($id);
		
		$tag = '';
		for($i =0 ;$i <= count($tags) - 1 ; $i++ ){
			if($i == count($tags)-1){
				$tag .= $tags[$i]->tag;
			}else{
				$tag .= $tags[$i]->tag.',';
			}
		}
		$header_import = '<script src="'.base_url().'assets/tags/tagcomplete.js"></script>
							<link rel="stylesheet" href="'.base_url().'assets/tags/tag.css">'; 

		$data =array(
			'main_content'=>'Edit_tags',
			'header_import'=>$header_import,
			'tags'=>$tag,
			'id'=>$id,
		);
		

		$this->load->view('admin_template/template',$data);
	}
	function update_tags($id){
		$type = $this->Mdl_Category_management->update_tags($id);

		if ($type == 1){
			redirect('Category_management/Product_parent');
		}else if ($type == 2){
			redirect('Category_management/Service_parent');
		}
		
	}
	
	function Service_child(){
		$header_import = '<script src="'.base_url().'assets/tags/tagcomplete.js"></script>
							<link rel="stylesheet" href="'.base_url().'assets/tags/tag.css">'; 
		
		$category_data = $this->Mdl_Category_management->get_all_parent_category(2);
		$data =array(
			'main_content'=>'Service_child',   
			'category_data'=>$category_data,
			'header_import'=>$header_import,			
		);
		$this->load->view('admin_template/template',$data);
	}
	
	function Product_child(){
		$header_import = '<script src="'.base_url().'assets/tags/tagcomplete.js"></script>
							<link rel="stylesheet" href="'.base_url().'assets/tags/tag.css">'; 
		
		$category_data = $this->Mdl_Category_management->get_all_parent_category(1);
		$data =array(
			'main_content'=>'Product_child',   
			'category_data'=>$category_data,
			'header_import'=>$header_import,
		);
		$this->load->view('admin_template/template',$data);
	}
	
	/***************** Parent Category *******************/
	
	function get_parent_category_data($rowno=0){
		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Category_management->getrecordCount_parent_category();

		// Get records
		$users_record = $this->Mdl_Category_management->get_parent_category_data($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$result = '';
		foreach($users_record as $res){
			$status = 'Active';
			if($res['category_status'] == 0){
			   $status = 'In-Active';
			}
			
			//check image
			$img = base_url().'assets/admin/images/no-image.png';
			if($res['category_image'] != NULL){
				$path = $res['category_image'];
				if(file_exists($path)) { 
					$img = base_url().$path; 
				}
			}
			$result .= '<tr id="tr-'.$res['category_id'] .'">';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><img src="'.$img.'" style="height: 80px;width: 80px;"/></td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res['category_name'] .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a onclick="deletes('.$res['category_id'] .')"  style="color: red;padding-right: 7px;"><i class="fas fa-trash-alt"></i></a><a onclick="edit_model('.$res['category_id'] .')"  style="color: blue;padding-right: 7px;"><i class="fas fa-edit"></i></i></a><a href="'.base_url().'/Category_management/edit_tags/'.$res['category_id'] .'"  style="color: blue;padding-right: 7px;"><i class="fas fa-tags"></i></i></a></td>';
			$result .= '</tr>';
		}
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $result;
		$data['row'] = $rowno;
		
		
		echo json_encode($data);
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
		$this->Mdl_Category_management->insert_parent_category($img);
		die;
	}
	
	function parent_category_exists(){
		$res = $this->Mdl_Category_management->parent_category_exists();
		
		if($res != NULL){
			echo json_encode(FALSE);
		}else{
			echo json_encode(TRUE);
		}
		die;
	}
	
	function get_single_parent_cat(){
		$res = $this->Mdl_Category_management->get_single_parent_cat($_POST['id']);
		echo json_encode($res);
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
								<input type="text" value="'.$res->category_tag.'" class="tags_input" name="category_tag" id="category_tag"  placeholder="Category Tags" >
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
						
						<div class="col-4">
							<div class="form-group">
								<input type="checkbox" name="approval_required" value="1"'; if($res->approval_required==1) { $data .='Checked';} $data .='>
								<label>Approval Required</label>
							</div>
						</div>
						
						
					</div>
                </div>
		';
		
		//echo $data;
	}
	
	function update_parent_category(){
		
		//image upload
		if($_FILES['category_image']['name'] != null)
		{
			$res = $this->Mdl_Category_management->get_single_parent_cat($_POST['id']);
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
		
		
		$this->Mdl_Category_management->update_parent_category();
		
		//return Updated Record
		$res = $this->Mdl_Category_management->get_single_parent_cat($_POST['update_id']);
		
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
		$res = $this->Mdl_Category_management->get_single_parent_cat($_POST['id']);
		//delete image
		$path = $res->category_image;
		if(file_exists($path)) { unlink($path); }
		
		$this->Mdl_Category_management->deletes_parent_category($_POST['id']);
	}
	
	/***********************  Child Category **************************/
	
	function get_child_category_data($rowno=0){
		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		  $rowno = ($rowno-1) * $rowperpage;
		}
	 
		// All records count
		$allcount = $this->Mdl_Category_management->getrecordCount_child_category();

		// Get records
		$users_record = $this->Mdl_Category_management->get_child_category_data($rowno,$rowperpage);
		
		// Pagination Configuration
		$config['base_url'] = base_url()."Category_management/viewget_service_parent_category_data";
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		
		
		$this->pagination->initialize($config);
		$result = '';
		foreach($users_record as $res){
			$status = 'Active';
			if($res['category_status'] == 0){
			   $status = 'In-Active';
			}
			
			//check image
			$img = base_url().'assets/admin/images/no-image.png';
			if($res['category_image'] != NULL){
				$path = $res['category_image'];
				if(file_exists($path)) { 
					$img = base_url().$path; 
				}
			}
			$result .= '<tr id="tr-'.$res['category_id'] .'">';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><img src="'.$img.'" style="height: 80px;width: 80px;"/></td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res['category_name'] .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res['parent_category_name'] .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'. $status .'</td>';
			$result .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a onclick="deletes('.$res['category_id'] .')"  style="color: red;padding-right: 7px;"><i class="fas fa-trash-alt"></i></a><a onclick="edit_model('.$res['category_id'] .')"  style="color: blue;padding-right: 7px;"><i class="fas fa-edit"></i></i></a></td>';
			$result .= '</tr>';
		}
		
		// Initialize $data Array
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $result;
		$data['row'] = $rowno;
		
		
		echo json_encode($data);
	}
	
	function insert_child_category(){ 
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
		$this->Mdl_Category_management->insert_child_category($img);
		die;
	}
	
	function child_category_exists(){
		$res = $this->Mdl_Category_management->child_category_exists();
		
		if($res != NULL){
			echo json_encode(FALSE);
		}else{
			echo json_encode(TRUE);
		}
		die;
	}
	
	function get_single_child_cat(){
		$res = $this->Mdl_Category_management->get_single_child_cat($_POST['id']);
		$category_data = $this->Mdl_Category_management->get_all_parent_category($_POST['category_type']);
		
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
								<label>Parent Category</label>
								<select name="parent_category" class="form-control select2" placeholder="Category Name" style="width: 100%;">
									<option value="">Select Parent Category</option>';
								 foreach($category_data as $val){ 
									$data .='<option value="'.$val->category_id.'"'; if($res->parent_category == $val->category_id){$data .='selected';} $data .='>'.$val->category_name.'</option>';
								}
							  $data .='</select>
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
								<input type="text" value="'.$res->category_tag.'" name="category_tag" class="tags_input" placeholder="Category Tags" >
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
	
	function update_child_category(){
		
		//image upload
		if($_FILES['category_image']['name'] != null)
		{
			$res = $this->Mdl_Category_management->get_single_child_cat($_POST['id']);
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
		$this->Mdl_Category_management->update_child_category();
		
		//return Updated Record
		$res = $this->Mdl_Category_management->get_single_child_cat($_POST['id']);
		
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
		$tr .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$res->parent_category_name .'</td>';
		$tr .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;">'.$status .'</td>';
		$tr .= '<td class="text-center" style="padding: .20rem; vertical-align: unset;"><a onclick="deletes('.$res->category_id.')"  style="color: red;padding-right: 7px;"><i class="fas fa-trash-alt"></i></a><a onclick="edit_model('.$res->category_id .')"  style="color: blue;padding-right: 7px;"><i class="fas fa-edit"></i></i></a></td>';
         echo $tr;
	}
	
	function deletes_child_category(){
		$res = $this->Mdl_Category_management->get_single_child_cat($_POST['id']);
		//delete image
		$path = $res->category_image;
		if(file_exists($path)) { unlink($path); }
		
		$this->Mdl_Category_management->deletes_child_category($_POST['id']);
	}
	
	
}
?>
