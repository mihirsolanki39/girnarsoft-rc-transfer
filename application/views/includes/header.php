<?php 
$userinfo=$this->session->userdata('userinfo');
//echo "<pre>"; print_r($userinfo); exit;?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
     <link rel="icon" href="<?=base_url('assets/images/favicon.ico')?>">
      <title><?php if(isset($pageTitle)){ echo $pageTitle;}?></title>
      <!-- Bootstrap core CSS -->
      <link href="<?=base_url('assets/admin_assets/css/bootstrap.min.css')?>" rel="stylesheet">
      <link href="<?=base_url('assets/admin_assets/css/font-awesome.css')?>" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
      <!-- Common styles for this template -->
      <link href="<?=base_url('assets/admin_assets/css/progressbar.css')?>" rel="stylesheet">
      <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-select.css')?>">
      <link href="<?=base_url('assets/admin_assets/css/daterangepicker.css')?>" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/css/jquery.datetimepicker.css" rel="stylesheet">
      <link href="<?=base_url('assets/admin_assets/css/select2.min.css')?>" rel="stylesheet" />
      <link href="<?=base_url('assets/admin_assets/css/sumoselect.min.css')?>" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <!--<link href="<//?=base_url('assets/admin_assets/css/common-advance.css')?>" rel="stylesheet">-->
      <link href="<?=base_url('assets/admin_assets/css/dashboard.css')?>" rel="stylesheet">
      <!-- Common styles for this template -->
      <link href="<?=base_url('assets/admin_assets/css/common.css')?>" rel="stylesheet">
      <link href="<?=base_url('assets/admin_assets/css/style.css')?>" rel="stylesheet">
      <!-- Common styles for this template -->
      <script src="<?=base_url('assets/js/loan_validation.js')?>"></script>
      <!--<link href="css/datepicker.css" rel="stylesheet">-->
      <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
      <!--[if lt IE 9]><script src="js/assets/ie8-responsive-file-warning.js"></script><![endif]-->
      <script src="<?=base_url('assets/admin_assets/js/assets/ie-emulation-modes-warning.js')?>"></script>
      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
      <script src="<?=base_url('assets/js/jquery.min.js')?>"></script>
      <!--<script src="<?=base_url('assets/admin_assets/js/tooltip.js')?>"></script>
      <script src="<?=base_url('assets/admin_assets/js/transition.js')?>"></script>-->
      <script>
      var base_url="<?=base_url();?>";
      </script>
       <style>
           .navbar{min-height: 64px !important}
           .navbar-default .navbar-nav>li>a {color: rgba(255, 255, 255, 0.82); border-bottom: 3px solid transparent;}
           .navbar-right .dropdown-menu:before {content: '';border-bottom: 7px solid #fff;border-left: 7px solid transparent;border-right: 7px solid transparent;position: absolute;top: -7px !important;left: 36%;}
           .navbar-right .dropdown-menu {top: 42px;left: -20px;right: 0;}
       </style>
   </head>
   <body id="myPage">
       <div id="snakbarAlert"></div>
       <!--/Top Header -->