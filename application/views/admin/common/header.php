<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bet Score 24</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="ico" href="<?= base_url('assets/admin/images/favicon.ico.ico') ?>"/>
	<link rel="stylesheet" href="<?=base_url('assets/admin/assets/css/normalize.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/admin/assets/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
<!--    <link rel="stylesheet" href="--><?//=base_url('assets/admin/assets/css/themify-icons.css')?><!--">-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    
    <link rel="stylesheet" href="<?=base_url('assets/admin/assets/css/cs-skin-elastic.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/admin/assets/css/style.css')?>">
    <link href="<?=base_url('assets/admin/assets/css/chartist.min.css')?>" rel="stylesheet">
    <link href="<?=base_url('assets/admin/assets/css/jqvmap.min.css')?>" rel="stylesheet">
    <link href="<?=base_url('assets/admin/assets/css/weather-icons.css')?>" rel="stylesheet" />
    <link href="<?=base_url('assets/admin/assets/css/fullcalendar.min.css')?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?=base_url('assets/admin/assets/css/lib/datatable/dataTables.bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/admin/assets/js/sweetalert/sweetalert.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/admin/assets/js/sweetalert/jquery.sweet-modal.css')?>">
</head>

<body>
<!-- Left Panel -->
<aside id="left-panel" class="left-panel">
    <?php include(APPPATH."views/admin/common/menu.php"); ?>
</aside>
<!-- /#left-panel -->
<!-- Right Panel -->
<div id="right-panel" class="right-panel">
    <!-- Header-->
    <header id="header" class="header">
        <div class="top-left">
            <div class="navbar-header">
                <a class="navbar-brand" href=""><b>Bet</b><span><b style="color: #c16808"> Score</b></span> <b>24</b></a>
                <a class="navbar-brand hidden" href=""><b>Bet</b><span><b style="color: #c16808"> Score</b></span> <b>24</b></a>
                <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
            </div>
        </div>
        <div class="top-right">
            <div class="header-menu">

                <div class="user-area dropdown float-right">
                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="user-avatar rounded-circle" src="<?=base_url('assets/admin/images/admin.jpg')?>" alt="User Avatar">
                    </a>

                    <div class="user-menu dropdown-menu">
                   
                        <a class="nav-link" href="javascript:void();" onclick="change_admin_password();"><i class="fa fa-power -off"></i>Change Password</a>
                        <a class="nav-link" href="<?php echo base_url('login/logout'); ?>"><i class="fa fa-power -off"></i>Logout</a>
                    </div>
                </div>

            </div>
        </div>
    </header>
