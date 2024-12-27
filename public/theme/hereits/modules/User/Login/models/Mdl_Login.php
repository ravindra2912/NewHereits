<?php 
class Mdl_Login extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kuala_Lumpur");
	} 
	
	function login_check()
	{   
    	$this->db->where('email', $_POST['email_id']);
		$this->db->where('password',md5($_POST['password'])); 
		$data=$this->db->get('User_master');
		return $data->row(); 
	} 
	
	function get_user_store($user_id)
	{   
    	$this->db->where('user_id', $user_id); 
		$data=$this->db->get('Store_master');
		return $data->row(); 
	} 
	function checkmail(){
		
		$this->db->select('*'); 
		$this->db->where('email', $_POST['email_id']); 
		$data=$this->db->get('User_master');
		return $data->row();
		
	}
	
	function checkuser($user_id)
	{
		$this->db->select('*'); 
		$this->db->where('user_id',$user_id); 
		$this->db->from('User_master');
		return $this->db->get()->row();
	}
	
	function User_Registr($post){
		$post['created_at'] = date("Y-m-d H:i:s");
		$post['updated_at'] = date("Y-m-d H:i:s");
		$this->db->insert('User_master',$post);
		$id = $this->db->insert_id();
		
		$str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$str =substr(str_shuffle($str_result),0, 6);
		$user_refral = $str.$id;
		$data1['user_referal'] = $user_refral;
		$this->db->where('user_id',$id);
		$this->db->update('User_master',$data1);
		
		$id = $this->db->insert_id();
	}
	
	
	function update_forgot_password($email){
		$data['forgot_password']=1;
		$data['forgot_created_at']=date("Y-m-d H:i:s");;
		$this->db->where('email',$email); 
		$this->db->update('User_master',$data);
	}
	function update_password($id){
		$data['forgot_password']=0;
		$data['password']=md5($_POST['password']);
		$this->db->where('user_id', $id); 
		$this->db->update('User_master',$data);
	}
	
}
?>