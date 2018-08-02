<!-- start: MAIN JAVASCRIPTS -->
<!--[if lt IE 9]>
<script src="assets/plugins/respond.min.js"></script>
<script src="assets/plugins/excanvas.min.js"></script>
<script type="text/javascript" src="assets/plugins/jQuery-lib/1.10.2/jquery.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script src="assets/plugins/jQuery-lib/2.0.3/jquery.min.js"></script>
<!--<![endif]-->
<script src="assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
<script src="assets/plugins/blockUI/jquery.blockUI.js"></script>
<script src="assets/plugins/iCheck/jquery.icheck.min.js"></script>
<script src="assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
<script src="assets/plugins/perfect-scrollbar/src/perfect-scrollbar-rtl.js"></script>
<script src="assets/plugins/less/less-1.5.0.min.js"></script>
<script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
<script src="assets/js/main.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="assets/js/login.js"></script>
<script src="assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="assets/js/form-validation.js"></script>
<script src="assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
<script src="assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.ar.js"></script>
<script src="assets/js/ui-modals.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script>
  jQuery(document).ready(function() {
    Main.init();
    Login.init();
    UIModals.init();
  });
  $('.datef').datepicker({
      autoclose: true,
      language: 'ar',
      format: 'yyyy-mm-dd'
  });
</script>
<script src="https://use.fontawesome.com/3cf2f45bf3.js"></script>
</body>
<!-- end: BODY -->
</html>
