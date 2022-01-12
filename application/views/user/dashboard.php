<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $judul_page;?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item" id='beranda_tgl'></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">

    </div>
    <script>
      $( document ).ready(function() {
        localStorage.clear();
        setInterval(display_ct, 1000);
        setTimeout(function() { 
          // $('.preload').fadeOut(300);
        }, 1000);
      });

      function display_ct() {
        let date = new Date();
        $('#beranda_tgl').html(date_indonesia(date));
      }
    </script>