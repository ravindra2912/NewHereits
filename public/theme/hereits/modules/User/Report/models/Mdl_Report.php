<?php 
class Mdl_Report extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function insert_report(){
		if($_FILES['images']['name'] != null)
		{
			$target_path = "uploads/Report_bug/";
			$ext = explode('.', basename($_FILES['images']['name']));
			$digits = 4;
			$rands = rand(pow(10, $digits-1), pow(100, $digits)-1);  
			$c_name = time().'-'.$rands . "." . $ext[count($ext) - 1];
			$c_image = $target_path . $c_name;
			move_uploaded_file($_FILES['images']['tmp_name'], $c_image);
			if(file_exists($c_image)) {
				$img = $target_path.$c_name;
				$data['images'] = $img;
			}
		}

			$data['email'] = $_POST['email'];
			$data['description'] = $_POST['description'];
			
			$data['reported_at'] = date("Y-m-d H:i:s");
			$this->db->insert('User_Report_Master',$data);
		
	}
	
	
}
?>