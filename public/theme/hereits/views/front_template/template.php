<?php
	error_reporting(0);
    $this->load->view('front_template/header');	
		$this->load->view('front_template/left_sidebar');	
	$this->load->view($main_content);
    $this->load->view('front_template/footer');
?>