<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Business extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Business');
		$this->load->model('Mdl_common');
		$this->load->model('Mdl_emails');
		
	}
	Public function index()
	{   
		
			//echo 'hello Word';die; 
			if($this->session->User->store_id != Null){
				redirect('Store_dashboard');
			}
			
			$product = $this->Mdl_Business->get_plans(1);
			$service = $this->Mdl_Business->get_plans(2);
			
			$both = $this->Mdl_Business->get_plans(3);
			$data =array(
				'main_content'=>'Landing_page',
				'left_sidebar'=>'Home', 
				'product'=>$product, 
				'service'=>$service, 
				'both'=>$both, 
			);
			$this->load->view('front_template/template',$data);
		
	}
	
	function set_otp(){
		if(!preg_match('/^[0-9]{10}+$/', $_POST['mobile_no'])){
			$data['status'] = 0;
			$data['msg'] = '<p class="error">Please Enter Valid Contact Number!</p>';
			echo json_encode($data);
			die;
		}
		$check_store = $this->Mdl_Business->check_store();
		if($check_store){
			$data['status'] = 0;
			$data['msg'] = '<p>you are already registered. please log in <a href="'.base_url().'Login" style="float: none;">Click Here</a></p>';
			echo json_encode($data);
			die;
		}
		  
		$otp = mt_rand(100000, 999999);
		$ccode = 91;
		$extra_param = '{"OTP":"'.$otp.'","company_mail":"support@hereits.com"}';
		$authkey = '349561ASdYhrdB5fdadbecP1';
		$template_id = '6080200c9becc929071041b4';
		$mobile = $ccode.$_POST['mobile_no'];

	
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.msg91.com/api/v5/otp?extra_param='.$extra_param.'&authkey='.$authkey.'&template_id='.$template_id.'&mobile='.$mobile.'&invisible=1&otp='.$otp.'&otp_length=6&otp_expiry=5',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		  CURLOPT_HTTPHEADER => array(
			"content-type: application/json"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		$res = json_decode($response, true);
		if ($err) {
		  echo "cURL Error #:" . $err;
		  $data['status'] = 0;
			$data['msg'] = '<p class="error">Please Enter Valid Contact Number!</p>';
		}else{
			if($res['type'] == 'success'){
				$data['status'] = 1;
				$data['msg'] = $res['message'];
			}else{
				$data['status'] = 0;
				$data['msg'] = '<p class="error">'.$res['message'].'</p>';
			}
		}
		$data['res'] = $response;
		echo json_encode($data);
		die;
	}
	
	function varify_otp(){
		
		$authentication_key = '349561ASdYhrdB5fdadbecP1';
		$ccode = 91;
		$mobile = $ccode.$_POST['mobile_no'];
		$otp = $_POST['otp'];
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.msg91.com/api/v5/otp/verify?mobile=$mobile&otp=$otp&authkey=$authentication_key",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		  CURLOPT_HTTPHEADER => array(
			"content-type: application/json"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		$res = json_decode($response, true);
		if ($err) {
		  echo "cURL Error #:" . $err;
		  $data['status'] = 0;
			$data['msg'] = '<p class="error">Enter Valid OTP</p>';
		} else {
			if($res['type'] == 'success'){
				$data['status'] = 1;
				$data['msg'] = $res['message'];
			}else{
				$data['status'] = 0;
				$data['msg'] = '<p class="error">'.$res['message'].'</p>';
			}
		  
		}
		$data['res'] = $res;
		echo json_encode($data);
		die;
	}
	
	function Store_registration(){
		if(!$_POST){ redirect('Business'); }
		$user_info = $this->Mdl_Business->get_user_detail();
		$this->Mdl_Business->store_phone_no();
		$data =array(
			'main_content'=>'Store_registration',
			'user_info'=>$user_info,  
			'mobile_no'=>$_POST['mobile_no'],  
		);
		$this->load->view('Store_registration',$data);
	}
	
	function store_register(){
		//upload user image
		if($_FILES['user_image']['name'] != null)
		{
			$target_path = "uploads/user_image/";
			$ext = explode('.', basename($_FILES['user_image']['name']));
			$digits = 2;
			$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
			$c_name = 'user-'.time().'-'.$rands . "." . $ext[count($ext) - 1];
			$c_image = $target_path . $c_name;
			move_uploaded_file($_FILES['user_image']['tmp_name'], $c_image);
			if(file_exists($c_image)) {
				$_POST['user_image'] = $target_path.$c_name;
			}
		}
		
		//upload adhar card front image
		if($_FILES['adhar_card_front_image']['name'] != null)
		{
			$target_path = "uploads/user_image/";
			$ext = explode('.', basename($_FILES['adhar_card_front_image']['name']));
			$digits = 2;
			$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
			$c_name = 'adhar-front-'.time().'-'.$rands . "." . $ext[count($ext) - 1];
			$c_image = $target_path . $c_name;
			move_uploaded_file($_FILES['adhar_card_front_image']['tmp_name'], $c_image);
			if(file_exists($c_image)) {
				$_POST['adhar_card_front_image'] = $target_path.$c_name;
			}
		}
		
		//upload adhar card back image
		if($_FILES['adhar_card_back_image']['name'] != null)
		{
			$target_path = "uploads/user_image/";
			$ext = explode('.', basename($_FILES['adhar_card_back_image']['name']));
			$digits = 2;
			$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
			$c_name = 'adhar-back-'.time().'-'.$rands . "." . $ext[count($ext) - 1];
			$c_image = $target_path . $c_name;
			move_uploaded_file($_FILES['adhar_card_back_image']['tmp_name'], $c_image);
			if(file_exists($c_image)) {
				$_POST['adhar_card_back_image'] = $target_path.$c_name;
			}
		}
		
		//upload store image
		if($_FILES['store_image']['name'] != null)
		{
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
		}
		
		//upload store image
		if($_FILES['address_proof_image']['name'] != null)
		{
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
		$store_id = $this->Mdl_Business->store_register();
		
		$this->Mdl_emails->store_panding_varification_email($store_id);
		
		//slug
		$this->Mdl_common->store_slug($store_id);
		echo json_encode($data);
	}
	
	
	function username_exists(){
		$res = $this->Mdl_Business->username_exists();
		if($res != NULL){
			echo json_encode(FALSE);
		}else{
			echo json_encode(TRUE);
		}
		die;
	}
	
	function user_email_exists(){
		$res = $this->Mdl_Business->user_email_exists();
		if($res != NULL){
			echo json_encode(FALSE);
		}else{
			echo json_encode(TRUE);
		}
		die;
	}
	
	function user_contact_exists(){
		$res = $this->Mdl_Business->user_contact_exists();
		if($res != NULL){
			echo json_encode(FALSE);
		}else{
			echo json_encode(TRUE);
		}
		die;
	}
	
	function check_referral()
	{
		$user = $this->Mdl_Business->check_referral();
		$data['user'] = $user; 
		echo json_encode($data);
	}
	
	function store_contact_exists(){
		$res = $this->Mdl_Business->store_contact_exists();
		if($res != NULL){
			echo json_encode(FALSE);
		}else{
			echo json_encode(TRUE);
		}
		die;
	}
	
	function store_email_exists(){
		$res = $this->Mdl_Business->store_email_exists();
		if($res != NULL){
			echo json_encode(FALSE);
		}else{
			echo json_encode(TRUE);
		}
		die;
	}
	
	
	
	
	
	function insert_plan(){ 
		$this->Mdl_Business->insert_plan();
		$success_msg='Plan Add Successfully';
		$this->session->set_flashdata('success_msg',$success_msg);
		redirect('Business');
	}
	
	
	function ajex_get_single_plan(){
		$res = $this->Mdl_Business->get_single_plan($_POST['id']);
		
		$data ='
				<input type="hidden" name="id" value="'.$res->id.'" />
				<div class="card-body">
					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<label>Plan Name</label>
								<input type="text" name="plan_name" value="'.$res->plan_name.'" class="form-control" placeholder="Plan Name" required>
							</div>
						</div>
						
						<div class="col-6">
							<div class="form-group">
								<label>Amount</label>
								<input type="number" name="amount" value="'.$res->amount.'" class="form-control" placeholder="Plan Amount" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Plan Duration </label>
								<select class="form-control" name="plan_duration" required>
									<option value="">Select Plan Duration</option>
									<option value="6" '; if($res->plan_duration == 6){$data .='selected';} $data .='>6 Month</option>
									<option value="12"'; if($res->plan_duration == 12){$data .='selected';} $data .='>12 Month</option>
									
								</select>
							</div> 
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								<label>Status </label>
								<select class="form-control" name="status" required>
									<option value="">Status</option>
									<option value="1" '; if($res->status == 1){$data .='selected';} $data .='>Active</option>
									<option value="0"'; if($res->status == 0){$data .='selected';} $data .='>In-Active</option>
									
								</select>
							</div> 
						</div>
						
						<div class="col-12">
							<div class="form-group">
								<label>Description</label>
								<textarea class="form-control" name="description" rows="3" placeholder="Enter ...">'.$res->description.'</textarea>									
							</div>
						</div>
					</div>
					
                </div>
		';
		
		echo $data;
	}
	
	function update_plan(){
			$this->Mdl_Business->update_plan();
			$success_msg='Plan Update Successfully';
			$this->session->set_flashdata('success_msg',$success_msg);
			redirect('Business');
	}
	
	function ajax_delete_plan(){
		if($_POST){
			$this->Mdl_Business->delete_plan($_POST['id']);
			echo $_POST['id'];
			$success_msg='Plan Add Successfully';
			$this->session->set_flashdata('success_msg',$success_msg);
		}
	}
	
	
	
	
	
	
	
	
	function go_to_edit($id){
		$user_data = $this->Mdl_Users->get_single_user($id);
			$data =array(
				'main_content'=>'User_Edit',
				'left_sidebar'=>'User Detail', 
				'user_data'=>$user_data,  
			);
			$this->load->view('admin_template/template',$data);
	}
	
	function update_user(){
		$this->Mdl_Users->update_user();
		redirect('Users');
	}
	
	function ajax_get_all_models(){
		$res = $this->Mdl_Users->get_models_by_id();
		$data = '';
		if($res == NULL){
			$data = '<tr> NO DATA </tr>';
		}else{ 
			foreach($res as $ress){
				$data.='
					<tr>
						<td id="modal_name_'.$ress->id.'" style="text-align: center;">'.$ress->modal_name.'</td>
						<td id="dp_'.$ress->id.'" style="text-align: center;">'.$ress->dp .'</td>
						<td id="Support_'.$ress->id.'" style="text-align: center;">'.$ress->Support .'</td>
						<td id="percentage_'.$ress->id.'" style="text-align: center;">'.$ress->percentage .'</td>
						<td id="mrp_'.$ress->id.'" style="text-align: center;">'.$ress->mrp .'</td>
					</tr>
				';
			}
		}
		echo $data;
	}
	
	function delete_user($id){
		$this->db->where('id', $id);
		$this->db->delete('User_master');
		redirect('Users');
	}
	
	
}
?>
