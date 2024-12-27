<?php
	error_reporting(0);
    $this->load->view('user_template/header');	
		$this->load->view('user_template/left_sidebar');	
	$this->load->view($main_content);
    $this->load->view('user_template/footer');
?>