<?php  

require_once 'inc.aplication_top.php';
include_once _includes_."inc.head.php";

$obj          = new Secciones();
$objProductos = new ModeloInsumos();


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
                  <h2>Listado de Usuarios <small>
                  <!-- <a href="?action=new"><i class="fa fa-plus"></i> Crear Usuario</a> -->
                  </small></h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <?php echo $msgbox->getMsgbox(); ?>
                        <?php
                          $metodoListar = $sesion->conFiltro() == false ? "listUsuarios" : "listUsuariosConFiltroDeUsuario";  
                          $id = isset($_GET['id']) ? $_GET['id'] : 0 ;                        
                          $user = new ModeloUsuario($id);
                          $usuarios = new ModeloUsuarios($msgbox);
                          switch($action){
                            case 'new':
                              $usuarios->newUsuarios($idioma);
                            break;
                            case 'add':
                              $usuarios->addUsuarios();
                              $usuarios->listUsuarios();
                            break;
                            case 'edit_psw':
                              $usuarios->editPassword($id);
                            break;
                            case 'update_psw':
                              $usuarios->update_password($id, $sesion->getUsuario());
                              $usuarios->listUsuarios();
                            break;
                            case 'edit':
                              $usuarios->editUsuarios($idioma);
                            break;
                            case 'update':
                              $usuarios->updateUsuarios($id, $sesion->getUsuario());
                              $usuarios->listUsuarios();
                            break;
                            case 'delete':              
                              $usuarios->deleteUsuarios();
                              $usuarios->listUsuarios();
                            break;
                            case 'list':              
                              $usuarios->listUsuarios();
                            break;            
                            default:              
                              $usuarios->listUsuarios();
                            break;          
                          } ?>
                  
                </div>

           
          </div>
        </div>

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

    <!-- Custom Theme Scripts -->
    <script src="../production/js/custom.min.js"></script>

     <script>
      $(document).ready(function() {
        $('#birthday').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_4"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>
    <!-- /bootstrap-daterangepicker -->

    <!-- bootstrap-wysiwyg -->
    <script>
    function mantenimiento(url,id,opcion){
            if(opcion!="delete"){ 
          
            location.replace(url+'?action='+opcion+'&id='+id);      
          }else if(opcion=="delete"){
            if(!confirm("Esta Seguro que desea Eliminar el Registro")){
              return false; 
            }else{
              location.replace(url+'?action='+opcion+'&id='+id);      
            }   
          }
        }
        
    function valida_usuarios(action,id){          
                if(document.usuarios.id_rol.value==""){
                  alert('ERROR: El campo  rol debe llenarse');
                  document.usuarios.id_rol.focus(); 
                  return false;
                }           
                          
                if(document.usuarios.nombre_usuario.value==""){
                  alert('ERROR: El campo nombre usuario debe llenarse');
                  document.usuarios.nombre_usuario.focus(); 
                  return false;
                }           
                          
                if(document.usuarios.apellidos_usuario.value==""){
                  alert('ERROR: El campo apellidos usuario debe llenarse');
                  document.usuarios.apellidos_usuario.focus(); 
                  return false;
                }           
                          
                if(document.usuarios.email_usuario.value==""){
                  alert('ERROR: El campo email usuario debe llenarse');
                  document.usuarios.email_usuario.focus(); 
                  return false;
                }           
                          
                if(document.usuarios.login_usuario.value==""){
                  alert('ERROR: El campo login usuario debe llenarse');
                  document.usuarios.login_usuario.focus(); 
                  return false;
                }           
                if(action=="add"){          
                if(document.usuarios.password_usuario.value==""){
                  alert('ERROR: El campo password usuario debe llenarse');
                  document.usuarios.password_usuario.focus(); 
                  return false;
                }           
                }
                document.usuarios.action="usuarios.php?action="+action+"&id="+id;
        document.usuarios.submit();
      }

    function view_user(user){
        $.get('ajax.php',{action:'viewUser', id:user},function(data){
          $(".modal-body").html(data);
        
        });
      }
      $(document).ready(function() {

        function mantenimiento(url,id,opcion){
            if(opcion!="delete"){ 
          
            location.replace(url+'?action='+opcion+'&id='+id);      
          }else if(opcion=="delete"){
            if(!confirm("Esta Seguro que desea Eliminar el Registro")){
              return false; 
            }else{
              location.replace(url+'?action='+opcion+'&id='+id);      
            }   
          }
        }




        function initToolbarBootstrapBindings() {
          var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
              'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
              'Times New Roman', 'Verdana'
            ],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
          $.each(fonts, function(idx, fontName) {
            fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
          });
          $('a[title]').tooltip({
            container: 'body'
          });
          $('.dropdown-menu input').click(function() {
              return false;
            })
            .change(function() {
              $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
            })
            .keydown('esc', function() {
              this.value = '';
              $(this).change();
            });

          $('[data-role=magic-overlay]').each(function() {
            var overlay = $(this),
              target = $(overlay.data('target'));
            overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
          });

          if ("onwebkitspeechchange" in document.createElement("input")) {
            var editorOffset = $('#editor').offset();

            $('.voiceBtn').css('position', 'absolute').offset({
              top: editorOffset.top,
              left: editorOffset.left + $('#editor').innerWidth() - 35
            });
          } else {
            $('.voiceBtn').hide();
          }
        }

        function showErrorAlert(reason, detail) {
          var msg = '';
          if (reason === 'unsupported-file-type') {
            msg = "Unsupported format " + detail;
          } else {
            console.log("error uploading file", reason, detail);
          }
          $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
            '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
        }

        initToolbarBootstrapBindings();

        $('#editor').wysiwyg({
          fileUploadError: showErrorAlert
        });

        window.prettyPrint;
        prettyPrint();
      });
    </script>
    <!-- /bootstrap-wysiwyg -->

    <!-- Select2 -->
    <script>
      $(document).ready(function() {
        $(".select2_single").select2({
          placeholder: "Select a state",
          allowClear: true
        });
        $(".select2_group").select2({});
        $(".select2_multiple").select2({
          maximumSelectionLength: 4,
          placeholder: "With Max Selection limit 4",
          allowClear: true
        });
      });
    </script>
    <!-- /Select2 -->

    <!-- jQuery Tags Input -->
    <script>
      function onAddTag(tag) {
        alert("Added a tag: " + tag);
      }

      function onRemoveTag(tag) {
        alert("Removed a tag: " + tag);
      }

      function onChangeTag(input, tag) {
        alert("Changed a tag: " + tag);
      }

      $(document).ready(function() {
        $('#tags_1').tagsInput({
          width: 'auto'
        });
      });
    </script>
    <!-- /jQuery Tags Input -->

    <!-- Parsley -->
    <script>
      $(document).ready(function() {
        $.listen('parsley:field:validate', function() {
          validateFront();
        });
        $('#demo-form .btn').on('click', function() {
          $('#demo-form').parsley().validate();
          validateFront();
        });
        var validateFront = function() {
          if (true === $('#demo-form').parsley().isValid()) {
            $('.bs-callout-info').removeClass('hidden');
            $('.bs-callout-warning').addClass('hidden');
          } else {
            $('.bs-callout-info').addClass('hidden');
            $('.bs-callout-warning').removeClass('hidden');
          }
        };
      });

      $(document).ready(function() {
        $.listen('parsley:field:validate', function() {
          validateFront();
        });
        $('#demo-form2 .btn').on('click', function() {
          $('#demo-form2').parsley().validate();
          validateFront();
        });
        var validateFront = function() {
          if (true === $('#demo-form2').parsley().isValid()) {
            $('.bs-callout-info').removeClass('hidden');
            $('.bs-callout-warning').addClass('hidden');
          } else {
            $('.bs-callout-info').addClass('hidden');
            $('.bs-callout-warning').removeClass('hidden');
          }
        };
      });
      try {
        hljs.initHighlightingOnLoad();
      } catch (err) {}
    </script>
    <!-- /Parsley -->
    


    <!-- Starrr -->
    <script>
      $(document).ready(function() {
        $(".stars").starrr();

        $('.stars-existing').starrr({
          rating: 4
        });

        $('.stars').on('starrr:change', function (e, value) {
          $('.stars-count').html(value);
        });

        $('.stars-existing').on('starrr:change', function (e, value) {
          $('.stars-count-existing').html(value);
        });
      });
    </script>

  </body>
</html>
