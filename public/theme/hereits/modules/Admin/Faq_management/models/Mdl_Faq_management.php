<?php 
class Mdl_Faq_management extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_faq($rowno,$rowperpage){
		
		$this->db->select('*');
		$this->db->from('faq_master');
		$this->db->limit($rowperpage, $rowno);
		
		return $this->db->get()->result();
	}
	
	public function getallrecord_faq() 
	{
		$this->db->select('count(*) as allcount');
		$this->db->from('faq_master');
		$query = $this->db->get();
		$result = $query->result_array();
	 
		return $result[0]['allcount'];
	 } 
	 
	function insert_faq(){
		$data['question']=$_POST['question'];
		$data['answer']=$_POST['answer'];
		$data['category']=$_POST['type'];
		$data['status']=$_POST['status'];
		$data['created_at']=date("Y-m-d H:i:s");
		$this->db->insert('faq_master',$data);
	}
	
	function faq_details($faq_id){
		
		$this->db->select('*');
		$this->db->from('faq_master');
		$this->db->where('faq_id',$faq_id);
		return $this->db->get()->row();
	}
	 function faq_update() {
		$data['question']=$_POST['question'];
		$data['answer']=$_POST['answer'];
		$data['category']=$_POST['type'];
		$data['status']=$_POST['status'];
		$data['updated_at']=date("Y-m-d H:i:s");
		$this->db->where('faq_id',$_POST['faq_id']);
		$this->db->update('faq_master',$data);
	 }
	
	function delete_faq($faq_id)
	{
		$this->db->where('faq_id',$faq_id);
		$this->db->delete('faq_master');
	}
	
}
?>