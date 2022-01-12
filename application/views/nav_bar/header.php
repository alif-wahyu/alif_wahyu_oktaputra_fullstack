<!DOCTYPE html>
<html lang="en">
    <head>
        <title>JSC 2022<?php $title = isset($judul) ? ' - '.$judul : ''; echo $title;?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/style.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/font_awesome.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/sweetalert2.min.css">
        <script src="<?php echo base_url();?>assets/dist/js/jquery.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/bootstrap.css">
    </head>
    <body>
    <?php 
        $message = $this->session->flashdata('message');
        if(isset($message)){
      ?>
        <script>
            Swal.fire({
                title: 'Opps',
                html: '<?= $message;?>',
                icon: 'error'
            })
        </script>
      <?php
        }
      ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-jsc">
        <div class="container">
            <a class="navbar-brand" href="#">NOVA</i></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item me-4 lh-lg">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item me-4 lh-lg">
                        <a class="nav-link" href="#">Article</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:;"><button class="btn btn-jsc btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#signup">Sign Up</button></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:;"><button class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#login">Login</button></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="hero-wrap">

    </div>