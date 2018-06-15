<?php  
require_once 'inc.aplication_top.php';
include_once _includes_."inc.head.php";

$action = "list";
$id     = '';
if (isset($_GET['action'])) {
  $action = $_GET['action'];
}
if (isset($_GET['id']) && $_GET['id'] != '') {
  $id = $_GET['id'];
}


?>  

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php include_once _includes_."inc.menu.php"; ?>

        <!-- top navigation -->
        <?php include_once _includes_."inc.menu_top.php"; ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="row">
            <?php 

            switch($action){
              case 'edit':
                $config_site->editConfiguration($id);    
              break;
              case 'update':
                $config_site->updateConfiguration($id);
                $config_site->listConfiguration($id);
              break;        
              default:  
                $config_site->listConfiguration($id);
              break; 
          } ?>
 
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.0/css/fileinput.min.css">

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="../vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="../vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="../vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="../vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="../vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="../vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="../vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="../vendors/starrr/dist/starrr.js"></script>
    <script src="../production/js/custom.min.js"></script>
    <!-- <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script> -->
    <script src="../production/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.0/js/fileinput.min.js"></script>
    <script src="../production/js/js.js"></script>
  </body>
</html>
