<?php  
class ModeloEjecutoresProyectos{

	private $_idioma, $_msgbox;

	public function __construct(ModeloIdioma $idioma, Msgbox $msg, ModeloUsuario $user){
		$this->_idioma  = $idioma ;
		$this->_msgbox  = $msg ;
		$this->_usuario = $user;
	}


	public function listEjecutoresProyectos($cat=0){

	
		$idc = ($cat > 0) ? $cat : 0;

		$sql = " SELECT * FROM ejecutores_proyecto_categorias c, ejecutores_proyecto_categorias_idiomas ci
					WHERE c.id_parent  =  ".$idc."
						AND c.id_categoria = ci.id_categoria
						AND ci.id_idioma = '2'";

		$query = new Consulta($sql);
		$sqlp = " SELECT * FROM proyectos_ejecutores p, proyectos_ejecutores_idiomas pi
						WHERE p.id_categoria =  ".$idc."
							AND p.id_proyecto = pi.id_proyecto
							AND pi.id_idioma  = '".$this->_idioma->__get('_id')."'
						";
		$queryp = new Consulta($sqlp);
		?>
		<div class="table-responsive">
				  <table class="table table-striped jambo_table bulk_action">
				    <thead>
				      <tr class="headings">
				        <th class="column-title">Categoria / Contenido </th>
				        <th class="column-title">url</th>
				        <th class="column-title no-link last"><span class="nobr">Opciones</span>
				        </th>
				      </tr>
				    </thead>

				    <tbody>
				      
				      
        	 <?php

				$y = 1;
				while($row = $query->VerRegistro()){
					?>
					<tr class="even pointer">
			            <td class=" "><i class="glyphicon glyphicon-folder-open"></i>&nbsp; <?php echo $row['titulo'] ?></td>
				        <td class=" "><?php echo $row['url'] ?></td>
				        <td class=" last">
				        	<a href="?actioncat=edit&cat=<?php echo $row['id_categoria']; ?>" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i> Editar</a>
				        	<a href="?cat=<?php echo $row['id_categoria']; ?>" class="btn btn-success"><i class="glyphicon glyphicon-level-up"></i> Ver Categorias</a>
				        	<a href="#" class="btn btn-danger" onClick="mantenimiento_cat('ejecutores-proyecto.php','<?php echo $row['id_categoria'] ?>','delete')"><i class="glyphicon glyphicon-remove"></i> Eliminar</a>
				        </td>
				    </tr>
				<?php
					$y++;
				}
				$y = 1;
				while($rowp = $queryp->VerRegistro()){
					?>
				 		<tr class="even pointer">
				            <td class=" "><i class="glyphicon glyphicon-file"></i>&nbsp; <?php echo $rowp['titulo'] ?></td>
					        <td class=" "><?php echo $rowp['url'] ?></td>
				        	<td class=" last">
					        	<a href="?id=<?php echo $rowp['id_proyecto']; ?>&action=edit" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i> Editar</a>
					        	<a href="#" class="btn btn-danger" onClick="mantenimiento('ejecutores-proyecto	.php','<?php echo $rowp['id_proyecto'] ?>','delete')"><i class="glyphicon glyphicon-remove"></i> Eliminar</a>
					        	
					        </td>
					    </tr>
				<?php
					$y++;
					}
				?>
             </ul>
		    </tbody>
		  </table>
		</div>
        <?php

	}
	public function newEjecutoresProyectos($idcat){
		$obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();
		?>
        	<legend>Nuevo Contenido</legend>
        	<form action="" method="post" name="contenido" enctype="multipart/form-data" class="form-horizontal form-label-left">
                <input type="hidden" name="imagen" id="imagen" value="<?php //echo TIPO_CAMBIO ?>" />
            	<?php
				for($i = 0; $i < count($idiomas); $i++){
                    if($i==0){
                        $bandera="images/en.png";
                    }
                    if($i==1){
                        $bandera="images/es.png";
                    }
                    ?> 
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Titulo: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" name="titulo[]" value="" class="form-control col-md-7 col-xs-12" size="59" maxlength="50">
						</div>

					</div>

				<?php  
				}

				for($i = 0; $i < count($idiomas); $i++){
                    if($i==0){
                        $bandera="images/en.png";
                    }
                    if($i==1){
                        $bandera="images/es.png";
                    }
                    ?> 
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Sub Titulo: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" name="sub_titulo[]" value="" class="form-control col-md-7 col-xs-12" size="59" maxlength="150">
						</div>

					</div>

				<?php  
				}

				for($i = 0; $i < count($idiomas); $i++){
                    if($i==0){
                        $bandera="images/en.png";
                    }
                    if($i==1){
                        $bandera="images/es.png";
                    }
                    ?> 
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Descripción: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<textarea id="" cols="20" rows="10" name="descripcion[]" class="form-control col-md-7 col-xs-12"></textarea>
						</div>

					</div>
					
				<?php  
				}
				?>
				<div class="ln_solid"></div>
	  				<div class="form-group">
	  					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	  					<input type="hidden" name="foto_usuario" value="">
	  						<input type="reset" name="cancelar" value="CANCELAR" class="btn btn-danger" onclick="history.back()">  
							<input type="button" name="" value="GUARDAR" onclick="return valida_proyecto('add','')" class="btn btn-success"><br clear="all">
	  					</div>
	  				</div>
        	</form>
		<?php
	}

	public function addEjecutoresProyectos($cat=0){

		
		$query = new Consulta("INSERT INTO  proyectos_ejecutores (id_categoria, id_proyecto, registro) VALUES('".$cat."',
			'".addslashes($_POST['titulo'][0])."',
			'".TIEMPO."'
			)");


		$id = $query->NuevoId();
		$obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();
		for($i = 0; $i < count($idiomas); $i++)
		{	
			$sql = "INSERT INTO  proyectos_ejecutores_idiomas (id_proyecto, id_idioma, titulo, url, sub_titulo, descripcion,imagen)
										VALUES (
											'".$id."',
											'".$idiomas[$i]['id']."',
											'".addslashes($_POST['titulo'][$i])."',
											'".url_amigable($_POST['titulo'][0],1)."',
											'".addslashes($_POST['sub_titulo'][$i])."',
											'".addslashes($_POST['descripcion'][$i])."',
											'".$_POST['imagen']."')";
			$query = new Consulta($sql);
		}
		$this->_msgbox->setMsgbox('Contenido grabado correctamente',2);
		location("ejecutores-proyecto.php?cat=".$cat);

	}

	public function editEjecutoresProyectos(){

		$obj = new ModeloEjecutoresProyecto($_GET['id'], $this->_idioma);
		$contenido = $obj->__get("_contenido_idiomas");

		$obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();
		?>
		<fieldset id="form">
        	<legend>Editar Contenido</legend>
        	<form action="" method="post" name="contenido" enctype="multipart/form-data" class="form-horizontal form-label-left">
                <input type="hidden" name="imagen" id="imagen" value="<?php //echo TIPO_CAMBIO ?>" />
            	<?php
				for($i = 0; $i < count($idiomas); $i++){
                    if($i==0){
                        $bandera="images/en.png";
                    }
                    if($i==1){
                        $bandera="images/es.png";
                    }
                    ?> 
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Titulo: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" name="titulo[]" value="<?php echo $contenido[$idiomas[$i]['id']]['nombre']; ?>" class="form-control col-md-7 col-xs-12" size="59" maxlength="50">
						</div>

					</div>

				<?php  
				}

				for($i = 0; $i < count($idiomas); $i++){
                    if($i==0){
                        $bandera="images/en.png";
                    }
                    if($i==1){
                        $bandera="images/es.png";
                    }
                    ?> 
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Sub Titulo: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" name="sub_titulo[]" value="<?php echo $contenido[$idiomas[$i]['id']]['sub_titulo']; ?>" class="form-control col-md-7 col-xs-12" size="59" maxlength="250">
						</div>

					</div>

				<?php  
				}

				for($i = 0; $i < count($idiomas); $i++){
                    if($i==0){
                        $bandera="images/en.png";
                    }
                    if($i==1){
                        $bandera="images/es.png";
                    }
                    ?> 
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Descripción: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<textarea id="" cols="20" rows="10" name="descripcion[]" class="form-control col-md-7 col-xs-12"><?php echo $contenido[$idiomas[$i]['id']]['descripcion']; ?></textarea>
						</div>

					</div>
					
				<?php  
				}
				?>
				<div class="ln_solid"></div>
	  				<div class="form-group">
	  					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	  					<input type="hidden" name="foto_usuario" value="">
	  						<input type="reset" name="cancelar" value="CANCELAR" class="btn btn-danger" onclick="history.back()">  
							<input type="button" name="" value="ACTUALIZAR" onclick="return valida_proyecto('update','<?php echo $_GET['id'];?>')" class="btn btn-success"><br clear="all">
	  					</div>
	  				</div>
        	</form>
        </fieldset>
		<?php

	}

	public function updateEjecutoresProyectos($cat=0){

		
		//Insertando idiomas
		$obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();
		for($i = 0; $i < count($idiomas); $i++)
		{
			$query = new Consulta("UPDATE  proyectos_ejecutores_idiomas
										SET 
										titulo	    =  '".addslashes($_POST['titulo'][$i])."',
										sub_titulo	    =  '".addslashes($_POST['sub_titulo'][$i])."',
											descripcion  =  '".addslashes($_POST['descripcion'][$i])."',
											url        =  '".url_amigable($_POST['titulo'][0], 1)."'
										WHERE id_idioma = '".$idiomas[$i]['id']."'
										AND id_proyecto = '".$_GET['id']."'");
		}


		$this->_msgbox->setMsgbox('Se actualizo correctamente.',2);
		location("ejecutores-proyecto.php?cat=".$cat);
	}

	public function deleteEjecutoresProyectos($cat=0){

		$query = new Consulta("DELETE  FROM proyectos_ejecutores WHERE id_proyecto = '".$_GET['id']."'");
		$query = new Consulta("DELETE  FROM proyectos_ejecutores_idiomas WHERE id_proyecto = '".$_GET['id']."'");


		$this->_msgbox->setMsgbox('Se elimino correctamente.',2);
		location("ejecutores-proyecto.php?cat=".$cat);
	}


	public function listaProductos($cat=0){
		$idc = ($cat > 0) ? $cat : 0;
		$sql = " SELECT * FROM categorias c, categorias_idiomas ci WHERE c.id_parent  =  ".$idc."
				AND c.id_categoria = ci.id_categoria AND ci.id_idioma = '".$this->_idioma->__get('_id')."'
				ORDER BY c.orden_categoria ASC";

		$query = new Consulta($sql);
		return $query;

		}


	public function getEjecutoresProyectos(){

		$sql = "SELECT * FROM proyectos WHERE id_usuario  = '".$this->_usuario->getId()."' ORDER BY orden_proyecto";

		$query_p = new Consulta($sql);
		while($row_p = $query_p->VerRegistro()){
			$data[] = array(
				'id'		=> $row_p['id_proyecto'],
				'nombre' 	=> $row_p['cliente_producto'],
				'ciudad' 	=> $row_p['ciudad_producto']
			);
		}
		return $data;

	}

	public function getProductosListado($idioma){
		$sql = "SELECT * FROM proyectos p 
		inner join proyectos_idiomas i on(i.id_proyecto=p.id_proyecto) 
		inner join categorias_idiomas c on(c.id_categoria=p.id_categoria and c.id_idioma=i.id_idioma) 
		where i.id_idioma='$idioma->_id'
		ORDER BY i.orden DESC ";
		//echo $sql;
		$query_p = new Consulta($sql);
		while($row_p = $query_p->VerRegistro()){
			$data[] = $row_p;
		}
		return $data;
		
	}

	public function orderProductos($cat=0){
		$query = new Consulta("SELECT MAX(orden_producto) max_orden
									FROM productos WHERE id_categoria = '".$cat."'");

		$row   = $query->VerRegistro();
		return (int)($row['max_orden']+1);
	}

	function imagenesProductos($cat){

		$id 		= $_GET['id'];

		$nombre 	= '';
		$destino 	= _ruta_imagenes_saweto_;
        $update 	= ", '" . $nombre . "' ";
		

		//pre($_FILES);
        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        	$nombre_archivo = $_FILES['image']['name'];

			$nombre_file = time().$nombre_archivo;
			$nombre = $nombre_file;	
			
			define("NAMETHUMB", "/tmp/thumbtemp");
                        
                        
			// $thumbnail = new ThumbnailBlob($_FILES['image'],NAMETHUMB, _ruta_imagenes_saweto_.'/big_');
			// $thumbnail->setQuality(9);
			// $thumbnail->SetTransparencia(true);
			// $thumbnail->CreateThumbnail(600, 500,$nombre);		
			
			
			// $thumbnail2 = new ThumbnailBlob($_FILES['image'],NAMETHUMB, _ruta_imagenes_saweto_.'/thumb_');
			// $thumbnail2->setQuality(90);
			// $thumbnail2->SetTransparencia(true);
			// $thumbnail2->CreateThumbnail(245, 150,$nombre);	

            $temp = $_FILES['image']['tmp_name'];
            $temp1 = $_FILES['image']['tmp_name'];
            $temp2 = $_FILES['image']['tmp_name'];
            move_uploaded_file($temp, $destino.$nombre); 
            //move_uploaded_file($temp1, $destino . '/big_'.$nombre); 
            //move_uploaded_file($temp2, $destino . '/thumb_'. $nombre);
			
                        $query = new Consulta("INSERT INTO productos_imagenes(id_producto, thumb_producto_imagen, big_producto_imagen, 
                        	imagen,url, order_producto_imagen) VALUES(
	        	'".$_GET['id']."',
	        	'".$nombre."',
	        	'".$nombre."',
	        	'".$nombre."',
	        	'"._imagenes_saweto_.$nombre."',
	        	0)");

	        $this->_msgbox->setMsgbox('Banner actualizado correctamente.',2);
	        location("ejecutores-proyecto	.php?id=".$id."&action=imagenes");
        }

		$obj = new ModeloProducto($_GET['id'], $this->_idioma);
		$imagenes = $obj->__get("_imagenes");
		?>
		<div id="mantinance">
			<fieldset id="crud">
				<legend> Galeria de Imagenes </legend>
				<form name="f1" id="f1" method="post" enctype="multipart/form-data" action="ejecutores-proyecto	.php?id=<?php echo $_GET['id'] ?>&action=imagenes"   >
				<div id="iframe">
					<div class="ileft_img" style="float: left;">
						<label for="imagen">Imagen : </label>
						<input id="file" type="file" name="image" size="31" class="btn btn-info fileinput" />
					</div>
				</div>
				<div style="clear:both"></div>
				<br><br>
				<div id="images">
					<div class="lefti" style="width: 270px; float: left;"> <?php
						if(is_array($imagenes) && count($imagenes) > 0){

							for($i=0; $i < count($imagenes); $i++){ ?>
								<div id="item_image" class="imagen<?php echo $imagenes[$i]['id'];?>">
									<input type="checkbox" name="chkimag" value="<?php echo $imagenes[$i]['id'];?>"/>
									<a href="#" title="<?php echo _imagenes_saweto_.$imagenes[$i]['original'];?>">
									<?php echo $imagenes[$i]['imagen'];?> </a>
								</div> <?php

							}
						} ?>
						<p id="msg_delete"> </p>
	 				</div>
					<div class="righti" id="imgs" style="width: 570px; float: right;"><?php if(!empty($imagenes[0]['imagen'])){ ?>
						<table width="100%" height="100%">
                        	<tr><td valign="middle" align="center"><img src="<?php echo _imagenes_saweto_.$imagenes[0]['original'];?>" id="imgp" width="250"/></td></tr>
                        </table><?php
						}else{
							echo "<BR><BR><BR><BR><BR><BR><H3> SIN IMAGENES </H3>";
						} ?>
					</div>
					<br clear="all" />
					<br clear="all" />
					<br clear="all" />
					<div class="bottom"><a href="javascript:;">
						<i class="glyphicon glyphicon-option-vertical"></i></a> Para eliminar una imagen activa su(s) respectiva(s) casilla de verificacion y haz cilck en <span class="btn btn-danger" onclick="javascript: delete_imagen('prod')" >ELIMINAR </span>
					</div>
				</div>
			</form>
			</fieldset>
		</div>
		<?php
	}

}
 ?>