<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Hereits | Store </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!-- script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery-ui.min.js" type="text/javascript"></script -->
	
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	
	<!-- Custome css -->
	<link id="style-main-color" rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/custome_css/store_custom.css">
	
	<!-- alertify -->
	<link id="style-main-color" rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/alertify/alertify.core.css">
	<link id="style-main-color" rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/alertify/alertify.default.css" id="toggleCSS">
	<script src="<?php echo base_url(); ?>assets/admin/custom_js/store_custom.js"></script>
	
	<?php 
		if(isset($header_import) != null){
			echo $header_import;
		}
	?>
	
	<style>
				.pagination{
					justify-content: center;
				}
				.pagination a{
					border-style: groove;
					border-width: 2px;
					border-color: #0056b3;
					border-radius: 25px;
					margin: 5px 5px 5px 0px;
					color: #0056b3;
					padding: 0px 8px 0px 8px;
				}
				
				.pagination strong, .pagination a:hover{
					border-style: groove;
					border-width: 2px;
					border-color: #0056b3;
					border-radius: 25px;
					margin: 5px 5px 5px 0px;
					color: #fff;
					background-color: #0056b3;
					padding: 0px 8px 0px 8px;
				}
				#load{
					width:100%;
					height:100%;
					position:fixed;
					z-index:9999;
					background: #c6c0c08f;
				}
				.image {
					position: absolute;
					top: 50%;
					left: 50%;
					width: 120px;
					height: 120px;
					margin:-60px 0 0 -60px;
					-webkit-animation:spin 0.7s cubic-bezier(.45,.05,.55,.95) infinites;
					-moz-animation:spin 0.7s cubic-bezier(.45,.05,.55,.95) infinite;
					animation:spin 0.7s cubic-bezier(.45,.05,.55,.95) infinite;
				}
				@-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } }
				@-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } }
				@keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }
			  </style>
</head>
<body class="sidebar-mini">
<div id="load">
	<img class="image" src="<?= base_url() ?>assets/Spinner.png" alt="" width="120" height="120">
</div>
<div class="wrapper">

  