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
            <?php echo $msgbox->getMsgbox(); ?>
                   <?php
                    $id = isset($_GET['id1']) ? $_GET['id1'] : 0 ;                        
                    $user = new ModeloUsuario($id);
                    $usuarios = new ModeloUsuarios($msgbox);
                    switch($action){
                      case 'add':
                        $usuarios->AccesosAddUsuarios($id);
                        $usuarios->AccesoslistUsuarios($id);
                      break;
                      case 'list':              
                        $usuarios->AccesoslistUsuarios($id);
                      break;            
                      default:              
                        $usuarios->AccesoslistUsuarios($id);
                      break;          
                    }
                    ?>

           
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
    <script>
      $("#frmproducto").submit(function(){

        var nombre,unidadmedida,descripcion,precio; 

        nombre        = $("#nombre");
        unidadmedida  = $("#unidadmedida");
        descripcion   = $("#descripcion");
        precio        = $("#precio");

        if (nombre.val() == "") {
          nombre.focus();
          alert("El campo nombre es requerido");
          return false;
        }

        if (nombre.val() == "") {
          nombre.focus();
          alert("El campo nombre es requerido");
          return false;
        }

        if (unidadmedida.val() == "") {
          unidadmedida.focus();
          alert("El campo unidadmedida es requerido");
          return false;
        }

        if (descripcion.val() == "") {
          descripcion.focus();
          alert("El campo descripcion es requerido");
          return false;
        }

        if (precio.val() == "") {
          precio.focus();
          alert("El campo precio es requerido");
          return false;
        }

      });


    </script>


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




    <script>
    var listaproducto = $("#lista-productos");
    var total = listaproducto.data("total");
    var lista = listaproducto.data("producto");

    productos  = new Array (total);


    for(i=0; i<total; i++){
    productos[i] =[
        $('#lista-productos').data("producto"+i) ,
        $('#lista-productos').data("precio"+i) 
       
      ];
  }
    


var nombreProducto  = new Array();
var precioProducto   = new Array();
    for (var i = 0; i < productos.length; i++) {
          var producto   = productos[i];
           nombreProducto[i]    = producto[0];
    }

    //console.log(nombreProducto);

    var objeto = toObject(nombreProducto);
    //console.log(objeto);
      var productosArray = $.map(objeto, function(value, key) {
          return {
            value: value,
            data: key
          };
        });

      $('.autocomplete-producto').autocomplete({
          lookup: productosArray,
          onSelect: function (suggestion) {
            var input = $(this);
            var nombre = suggestion.value;


          for (var i = 0; i < productos.length; i++) {
                var producto   = productos[i];
                 nombreProducto[i]    = producto[0];
                 precioProducto[i]    = producto[1];
          }

          var posicion            = jQuery.inArray(nombre,nombreProducto);
          var precioEncontrado  = precioProducto[posicion];

          console.log(precioEncontrado);

          input.parent().next().find('.precio-producto').val(precioEncontrado);

              //console.log('You selected: ' + suggestion.value + ', ' + suggestion.data);
          }
        });

      
      function toObject(arr) {
        var rv = {};
        for (var i = 0; i < arr.length; ++i)
          rv[i] = arr[i];
        return rv;
      }


    </script>

  </body>
</html>
