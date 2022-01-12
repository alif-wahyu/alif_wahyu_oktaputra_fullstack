</div>
  <footer class="main-footer">
    <strong>Created By Alif Wahyu Oktaputra - 2022</strong>
    </div>
  </footer>
</div>
<script src="<?php echo base_url();?>assets/dist/js/adminlte.js"></script>
<script src="<?php echo base_url();?>assets/dist/js/font_awesome.js"></script>
<script src="<?php echo base_url();?>assets/dist/js/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url();?>assets/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/dist/js/toastr.min.js"></script>

</body>
</html>
<script>
    $(document).ready(function(){
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": true,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": true,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
  })
</script>