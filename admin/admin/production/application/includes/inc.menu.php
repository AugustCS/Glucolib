<div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.php" class="site_title"><img src="/img/icono.png" alt="" width="20%"> <span>Consola Glucolib</span></a>
            </div>

            <div class="clearfix"></div>
          <?php
            if($sesion->getUsuario()->getLogeado() === TRUE){
              $secciones = $sesion->getUsuario()->getSeccionesId();
              $modulos   = explode(",",$sesion->getUsuario()->getModulos());
              sort($modulos);
            }else{
              $secciones = array($modulos);
            }
             ?>
 



            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                   <?php
                    if(is_array($modulos)){
                      $seccions = new ModeloSecciones();
                      reset($modulos);
                      $index = 1;
                      foreach($modulos as $key => $value){
                        $modulo = new ModeloModulo($value);
                        ?>
                        <li>
                                  <a href="javascript:;"><i class="<?php echo $modulo->getIcono(); ?>"></i><?php echo $modulo->getNombre(); ?> </a>
                        <?php
                          $sections = $seccions->getSeccionesPorModulo($modulo->getId());
                          $total    = count($sections);
                          if($total > 0){
                          ?>
                          <ul class="nav child_menu">
                           <?php
                            for($s = 0; $s < $total; $s++){
                              if(in_array($sections[$s]['id'],$secciones)){
                                $self = explode("/",$_SERVER['PHP_SELF']);
                                $self = end($self);
                                if(strstr("reporte.php",$sections[$s]['url'])){
                                  ?>
                                  <li><a href="<?php echo $sections[$s]['url']?>">  <?php echo $sections[$s]['nombre']?> </a></li><?php
                                }else {
                                  if(strstr($self,$sections[$s]['url'])){ ?>
                                    <li><a href="<?php echo $sections[$s]['url']?>"><?php echo $sections[$s]['nombre']?></a></li> <?php
                                  }else{ ?>
                                    <li><a href="<?php echo $sections[$s]['url']?>">  <?php echo $sections[$s]['nombre']?> </a></li><?php
                                  }
                                }
                              }
                            } ?>
                          </ul>
                         <?php
                        }
                        ?></li>
                              <?php
                      }
                    } ?>
                        <!--   <li class="last"></li> -->
                      </ul>



                <!-- <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="index.php">Panel</a></li>
                     
                    </ul>
                  </li>

                  <li><a><i class="fa fa-bar-chart-o"></i> Inventario <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="productos.php">Mis Productos</a></li>
                      <li><a href="insumos.php">Mis Insumos</a></li>
                      <li><a href="ingreso-almacen.php">Ingreso almacen</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-edit"></i> Ventas <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="pedidos-dia.php">Pedidos del dia</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Reportes <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="cierre-diario.php">Cierre diario</a></li>
                      <li><a href="#">Stock a la fecha</a></li>
                      <li><a href="pedidos.php">Lista Pedidos</a></li>
                    </ul>
                  </li>
                 
                </ul> -->

              </div>
              

            </div>

            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <!-- <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div> -->
            <!-- /menu footer buttons -->
          </div>
        </div>