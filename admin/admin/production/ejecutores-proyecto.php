<?php  

require_once 'inc.aplication_top.php';
include_once _includes_."inc.head.php";

$obj          = new Secciones();

$idcat = (isset($_GET['cat'])) ? $_GET['cat'] : $_SESSION['categoria'];
$_SESSION['categoria'] = $idcat;


$action = "list";
if (isset($_GET['action'])) {
  $action = $_GET['action'];
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
          <div class="">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Listado de Modulos</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a href="?cat=0" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-th-list"></i> Listado</a></li>
                      <li><a href="?actioncat=new" class="btn btn-default btn-xs"><i class="fa fa-plus"></i> Crear Categoria</a></li>
                      <li><a href="?action=new" class="btn btn-default btn-xs"><i class="fa fa-plus"></i> Crear Contenido</a></li>
                    </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <?php 
                        echo $msgbox->getMsgbox(); 
                        $obj_categoria  = new ModeloEjecutoresProyectoCategoria($idcat, $idioma);
                        $obj_c          = new ModeloEjecutoresProyectoCategorias($idioma, $msgbox);
                        $obj            = new ModeloEjecutoresProyectos($idioma, $msgbox, $user);
                
                if(isset($_GET['actioncat']) && $_GET['actioncat']!= ''){
                  $accion = $_GET['actioncat']."EjecutoresProyectoCategorias";  
                  $obj_c->$accion($obj_categoria->__get('_id'));
                  if($_GET['actioncat'] == 'add' || $_GET['actioncat'] == 'update' || $_GET['actioncat'] == 'delete'){
                    //$obj->listtInformes($obj_categoria->__get('_id'));
                  }
                }
                        // CREAR NUEVA CATEGORIA
                        if(!isset($_GET['actioncat'])){
                          if(isset($_GET['action']) && $_GET['action']!= ''){
                              $accion = $_GET['action']."EjecutoresProyectos"; 
                              $obj->$accion($obj_categoria->__get('_id'));
                          }else{
                                  $obj->listEjecutoresProyectos($obj_categoria->__get('_id'));
                          }
                        }
                          ?>
                  
                </div>

           
          </div>
        </div>

          </div>
        </div>
        <div id="idContenido" data-value="<?php echo $idp; ?>"></div>


        
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


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Detalle del Usuario</h4>
          </div>
          <div class="modal-body">
            ...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
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
