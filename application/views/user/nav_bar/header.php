<!DOCTYPE html>
<html lang="en">
    <head>
        <title>JSC 2022<?php $title = isset($judul) ? ' - '.$judul : ''; echo $title;?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/adminlte.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/font_awesome.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/sweetalert2.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/toastr.min.css">
        <script src="<?php echo base_url();?>assets/dist/js/jquery.min.js"></script>
        <!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/bootstrap.css"> -->

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link" style="background-color: #fff !important; color:black !important;font-weight: 500 !important">
      <span class="brand-text">JSC Test 2022</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block"><?= $session['username'];?></a>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false"> 
          <li class="nav-item">
            <a href="<?php echo base_url();?>user/article" class="nav-link">
            <i class="nav-icon far fa-newspaper"></i>
              <p>
                Article
              </p>
            </a>
          </li>
          <li class="nav-header">ACCOUNT</li>
          <li class="nav-item">
            <a href="<?php echo base_url();?>user/logout" class="nav-link">
              <i class="nav-icon fas fa-key"></i>
              <p>
                Log out
              </p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
