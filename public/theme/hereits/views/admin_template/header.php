<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Hereits | Admin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
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
	
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	
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
				.pagination a{
					position: relative;
					padding: .5rem .75rem;
					margin-left: -2px;
					line-height: 1.25;
					background-color: transparent;
					border: 2px solid transparent;
					border-top-width: 2px;
					border-right-width: 2px;
					border-bottom-width: 2px;
					border-left-width: 2px;
				}
				
				.pagination strong{
					position: relative;
					padding: .5rem .75rem;
					margin-left: -2px;
					line-height: 1.25;
					color:red;
					background-color: transparent;
					border: 2px solid transparent;
					border-top-width: 2px;
					border-right-width: 2px;
					border-bottom-width: 2px;
					border-left-width: 2px;
				}
				.error p{
					color:red;
				}
				.error{
					color:red;
					font-size: medium;
				}
			  </style>
</head>
<body class="sidebar-mini sidebar-collapse" style="font-size: 0.8rem;">
<div class="wrapper">

  