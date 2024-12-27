<?php
	error_reporting(0);
    $this->load->view('Store_template/header');	
	$this->load->view('Store_template/left_sidebar');	
	$this->load->view($main_content);
    $this->load->view('Store_template/footer');
?>