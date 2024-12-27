<?php
	error_reporting(0);
    $this->load->view('admin_template/header');	if($left_sidebar != 'User Chat Bord'){
		$this->load->view('admin_template/left_sidebar');	}
	$this->load->view($main_content);
    $this->load->view('admin_template/footer');
?>