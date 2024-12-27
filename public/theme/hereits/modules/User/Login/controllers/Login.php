<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Login');
		$this->load->model('Mdl_emails');
		$this->load->library('encryption');
	}
	
	Public function index()
	{  
		$data =array(
		);
		$this->load->view('login',$data); 
		
		/*$data =array(
				'main_content'=>'login',
				'left_sidebar'=>'Dashboard',
			);
			$this->load->view('admin_template/template',$data);*/
	}
	
	
	public function chack_login()
	{   
		$rowdata = $this->Mdl_Login->login_check(); 
		
		if($rowdata == null)
		{    
			$credential=$_POST['email_id'];
			$this->session->set_flashdata('credential',$credential);
			$error_msg='Login failed. Please enter a valid email id and password.';
			$this->session->set_flashdata('error_msg',$error_msg);
			redirect('Login'); 
			
		}else
		{
			
			unset($rowdata->password); 
			$this->session->set_userdata("User",$rowdata);
			
			//add store id to session
			$store = $this->Mdl_Login->get_user_store($rowdata->user_id);
			if($store == NULL){
				$error_msg='Login failed. Please enter a valid email id and password.';
				$this->session->set_flashdata('error_msg',$error_msg);
				redirect('Login'); 
			}else if($store->store_status == 3){
				$error_msg='Your Account is De-Activate.';
				$this->session->set_flashdata('error_msg',$error_msg);
				redirect('Login'); 
			}else if($store->store_status == 4){
				$error_msg='Your Store is permanent close.';
				$this->session->set_flashdata('error_msg',$error_msg);
				redirect('Login'); 
			}else if($store->store_status == 5){
				$error_msg='Your Store is banned.';
				$this->session->set_flashdata('error_msg',$error_msg);
				redirect('Login'); 
			}
			$this->session->User->store_id = $store->store_id;
			$this->session->User->Store_name = $store->Store_name;
			
			$success_msg='Welcome '.$rowdata->email_id.'';
			$this->session->set_flashdata('success_msg',$success_msg);   
			redirect('Store_dashboard');
		}
		
	}
	
	public function chack_user_login()
	{   
		$rowdata = $this->Mdl_Login->login_check(); 
		
		if($rowdata == null)
		{    
			$credential=$_POST['email_id'];
			$this->session->set_flashdata('credential',$credential);
			$array=array('status'=>0,'Message'=>'Login failed. Please enter a valid email id and password.');
			
		}else
		{
			
			unset($rowdata->password); 
			$this->session->set_userdata("User",$rowdata);
			
			//add store id to session
			$store = $this->Mdl_Login->get_user_store($rowdata->user_id);
			
			$this->session->User->store_id = $store->store_id;
			$this->session->User->Store_name = $store->Store_name;
			
			$success_msg='Welcome';
			$this->session->set_flashdata('success_msg',$success_msg);   
			$array=array('status'=>1,'Message'=>'success');
		}
		
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
		
	}
	
	function User_Registration(){
		$post['frist_name'] = $this->input->post('frist_name', TRUE); 
		$post['last_name'] = $this->input->post('last_name', TRUE); 
		$post['username'] = $this->input->post('username', TRUE); 
		$post['contact'] = $this->input->post('contact', TRUE); 
		$post['email'] = $this->input->post('email', TRUE); 
		$post['password'] = $this->input->post('password', TRUE);
		
		
		if($post['frist_name'] == NULL){
			$array=array('status'=>'0','Message'=>'Enter Your Frist Name'); 
		}else if($post['last_name'] == NULL){
			$array=array('status'=>'0','Message'=>'Enter Your Last Name'); 
		}else if($post['username'] == NULL){
			$array=array('status'=>'0','Message'=>'Enter Your User Name'); 
		}else if($post['email'] == NULL){
			$array=array('status'=>'0','Message'=>'Enter Your Email'); 
		}else if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
			$array=array('status'=>'0','Message'=>'Enter Valid Email'); 
		}else if($post['contact'] == NULL){
			$array=array('status'=>'0','Message'=>'Enter Your Contact'); 
		}else if(!preg_match('/^[0-9]{10}+$/', $post['contact'])){
			$array=array('status'=>'0','Message'=>'Enter Valid Contact'); 
		}else if($post['password'] == NULL){
			$array=array('status'=>'0','Message'=>'Enter Your password'); 
		}else if(strlen($post['password']) < 6 ){
			$array=array('status'=>'0','Message'=>'Your Password Must Contain At Least 6 Characters!'); 
		}else{
			$this->db->select('*'); 
			$this->db->where('email', $post['email']); 
			$data=$this->db->get('User_master');
			$ck_email = $data->row();
			
			$this->db->select('*'); 
			$this->db->where('contact', $post['contact']); 
			$data=$this->db->get('User_master');
			$ck_contact = $data->row();
			
			$this->db->select('*'); 
			$this->db->where('username', $post['username']); 
			$data=$this->db->get('User_master');
			$ck_username = $data->row();
			
			if($ck_email){
				$array=array('status'=>'0','Message'=>'Email Id Already exists!'); 
			}else if($ck_contact){
				$array=array('status'=>'0','Message'=>'Contact Number Already exists!'); 
			}else if($ck_username){
				$array=array('status'=>'0','Message'=>'User Name Already exists!'); 
			}else{
				$data = $this->Mdl_Login->User_Registr($post);
				$array=array('status'=>'1','Message'=>'Registration Success', 'data'=>$data);
				$success_msg='Registration Success';
				$this->session->set_flashdata('error_msg','');
				$this->session->set_flashdata('success_msg',$success_msg);  
			}
			
		}
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	function user_forgot(){
		$_POST['email_id'] = $this->input->post('email', TRUE); 
		$checkmail = $this->Mdl_Login->checkmail();
		if($checkmail != NULL){
			$this->Mdl_Login->update_forgot_password($_POST['email_id']);
			$this->Mdl_emails->user_forgot_email($_POST['email_id']);
			$array=array('status'=>'1','Message'=>'Password reset link sent Successfully !,Please check your Email account');
		}else{
			$array=array('status'=>'0','Message'=>'Please enter a valid email');
		}
		
		$myJSON = json_encode($array);
		echo $myJSON;
		die;
	}
	
	
	function Forgot_password(){
		
		$data =array(
		
		);
		$this->load->view('Forgot_password',$data); 
	}
	
	function send_link(){
		$checkmail = $this->Mdl_Login->checkmail();
		if($checkmail != NULL){
			$this->Mdl_Login->update_forgot_password($_POST['email_id']);
			$this->Mdl_emails->user_forgot_email($_POST['email_id']);
			$success_msg='Password reset link sent Successfully !,Please check your Email account';
			$this->session->set_flashdata('error_msg','');
			$this->session->set_flashdata('success_msg',$success_msg);   
			$this->Forgot_password();
		}else{
			
			$error_msg='Please enter a valid email.';
			$this->session->set_flashdata('error_msg',$error_msg);
			$this->session->set_flashdata('success_msg','');   
			$this->Forgot_password();
		}
			
	}
	function Reset_password($user_id){
		$checkuser = $this->Mdl_Login->checkuser($user_id);
			
		
		if($checkuser->forgot_password  == 1){
			$minutes = ( time() - strtotime($checkuser->forgot_created_at)) / 60;
			if($minutes > 0 && $minutes <= 30 ){
				$data =array(
					'user'=>$checkuser,
				);
				$this->load->view('Reset_password',$data); 
			}else{
				exit('permission denied');
			}
			
		}else{
			exit('permission denied');
		}
		
	}
	function update_password($id){
		$checkuser = $this->Mdl_Login->checkuser($id);
		if($checkuser->forgot_password  == 1){
			$minutes = ( time() - strtotime($checkuser->forgot_created_at)) / 60;
			if($minutes > 0 && $minutes <= 30 ){
				$this->Mdl_Login->update_password($id);
				redirect('Login');
			}else{
				exit('permission denied');
			}
			
		}else{
			exit('permission denied');
		}
		
	}
	Public function logout()
	{
		$all_userdata = $this->session->all_userdata();
		$this->session->unset_userdata('User');
        //session_destroy();   
        redirect('Home');
	}
}
?>
