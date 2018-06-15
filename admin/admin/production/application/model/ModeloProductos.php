<?php
class ModeloProductos{

	private $_idioma, $_msgbox;

	public function __construct(ModeloIdioma $idioma, Msgbox $msg, ModeloUsuario $user){
		$this->_idioma  = $idioma ;
		$this->_msgbox  = $msg ;
		$this->_usuario = $user;
	}

	public function newProductos($idcat){
		$obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();
		?>
        	<legend>Nuevo Contenido</legend>
        	<form action="" method="post" name="contenido" enctype="multipart/form-data" class="form-horizontal form-label-left">
                <input type="hidden" name="tipo_cambio" id="tipo_cambio" value="<?php //echo TIPO_CAMBIO ?>" />
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
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Descripción: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<textarea id="" cols="20" rows="10" name="descripcion[]" class="form-control col-md-7 col-xs-12"></textarea>
						</div>

					</div>
					
				<?php  
				}

				?>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;Link: </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="link" value="" placeholder="http://youtube.com/v=sdsdsdsd" class="url form-control col-md-7 col-xs-12" size="59" maxlength="50">
					</div>

				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;Fecha: </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="fecha" value="" placeholder="10/05/2017" class="date form-control col-md-7 col-xs-12" size="59" maxlength="50">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;Latitud: </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="latitud" value=""  placeholder="-10.1511515151" class="url form-control col-md-7 col-xs-12" size="59" maxlength="50">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;Longitud: </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="longitud" value="" placeholder="-7.155515485" class="url form-control col-md-7 col-xs-12" size="59" maxlength="50">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;Imagen	: </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="file" class="foto" name="foto" id="foto">							
					</div>

				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;PDF	: </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="file" class="foto" name="pdf" id="pdf">							
					</div>

				</div>

				
				<div class="ln_solid"></div>
	  				<div class="form-group">
	  					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	  					<input type="hidden" name="foto_usuario" value="">
	  						<input type="reset" name="cancelar" value="CANCELAR" class="btn btn-danger" onclick="history.back()">  
							<input type="button" name="" value="GUARDAR" onclick="return valida_contenido('add','')" class="btn btn-success"><br clear="all">
	  					</div>
	  				</div>
        	</form>
		<?php
	}

	public function addProductos($cat=0){

		$query = new Consulta("INSERT INTO  productos (id_categoria, codigo_producto, orden_producto) VALUES('".$cat."',
			'".addslashes($_POST['titulo'][0])."',
			'".$this->orderProductos($cat)."'
			)");

		$nombre 	= '';
		$nombre_pdf	= '';
		$destino 	= _ruta_imagenes_saweto_;
    	$update 	= ", '" . $nombre . "' ";
	

        if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "") {
        	$nombre_archivo = $_FILES['foto']['name'];

			$nombre_file = time().trim($nombre_archivo);
			$nombre = $nombre_file;	
			
            $temp = $_FILES['foto']['tmp_name'];
            move_uploaded_file($temp, $destino.'productos/'.$nombre); 
        }

        if (isset($_FILES['pdf']['name']) && $_FILES['pdf']['name'] != "") {
        	$nombre_archivo = $_FILES['pdf']['name'];

			$nombre_file 	= time().trim($nombre_archivo);
			$nombre_pdf 	= $nombre_file;	
			
            $temp = $_FILES['pdf']['tmp_name'];
            move_uploaded_file($temp, $destino.'productos/'.$nombre_pdf); 
        }


		$id = $query->NuevoId();
		$obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();
		for($i = 0; $i < count($idiomas); $i++)
		{
			$query = new Consulta("INSERT INTO  productos_idiomas (id_producto, id_idioma, nombre_producto, descripcion_producto,url_producto, link_producto, fecha, latitud, longitud, foto, pdf)
										VALUES (
											'".$id."',
											'".$idiomas[$i]['id']."',
											'".addslashes($_POST['titulo'][$i])."',
											'".addslashes($_POST['descripcion'][$i])."',
											'".url_amigable($_POST['titulo'][0], 1)."',
											'".addslashes($_POST['link'])."',
											'".formato_date('/',$_POST['fecha'])."',
											'".addslashes($_POST['latitud'])."',
											'".addslashes($_POST['longitud'])."',
											'".$nombre."',
											'".$nombre_pdf."'
											)");
		}
		$this->_msgbox->setMsgbox('Contenido grabado correctamente',2);
		location("modulos-web.php?cat=".$cat);

	}

	public function editProductos(){

		$obj = new ModeloProducto($_GET['id'], $this->_idioma);
		$contenido = $obj->__get("_contenido_idiomas");

		$obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();
		?>
		<fieldset id="form">
        	<legend>Editar Contenido</legend>
        	<form action="" method="post" name="contenido" enctype="multipart/form-data" class="form-horizontal form-label-left">
                <input type="hidden" name="tipo_cambio" id="tipo_cambio" value="<?php //echo TIPO_CAMBIO ?>" />
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
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Descripción: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<textarea id="" cols="20" rows="10" name="descripcion[]" class="form-control col-md-7 col-xs-12"><?php echo $contenido[$idiomas[$i]['id']]['descripcion']; ?></textarea>
						</div>

					</div>
					
				<?php  
				}
				?>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;Link: </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="link" value="<?php echo $contenido[$idiomas[0]['id']]['link']; ?>" placeholder="http://youtube.com/v=sdsdsdsd" class="url form-control col-md-7 col-xs-12" size="59" maxlength="50">
					</div>

				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;Fecha: </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="fecha" value="<?php echo formato_slash('-',$contenido[$idiomas[0]['id']]['fecha']); ?>" placeholder="10/05/2017" class="date form-control col-md-7 col-xs-12" size="59" maxlength="50">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;Latitud: </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="latitud" value="<?php echo $contenido[$idiomas[0]['id']]['latitud']; ?>"  placeholder="-10.1511515151" class="url form-control col-md-7 col-xs-12" size="59" maxlength="50">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;Longitud: </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="longitud" value="<?php echo $contenido[$idiomas[0]['id']]['longitud']; ?>" placeholder="-7.155515485" class="url form-control col-md-7 col-xs-12" size="59" maxlength="50">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;Imagen: </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="file" class="foto" name="foto" id="foto">							
					</div>

				</div>
				<?php  
				if ($contenido[$idiomas[0]['id']]['foto'] != ''): 
					$extension = get_extension($contenido[$idiomas[0]['id']]['foto']);
					if ($extension != 'pdf') : ?>
						<div class="form-group text-center">
							<img src="<?php echo _imagenes_saweto_.'productos/'. $contenido[$idiomas[0]['id']]['foto']; ?>" width="200" alt="">
						</div>
					<?php endif; ?>
				<?php endif; ?>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;PDF: </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="file" class="foto" name="pdf" id="pdf">							
					</div>

				</div>
				<div class="ln_solid"></div>
	  				<div class="form-group">
	  					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	  					<input type="hidden" name="foto_usuario" value="">
	  						<input type="reset" name="cancelar" value="CANCELAR" class="btn btn-danger" onclick="history.back()">  
							<input type="button" name="" value="ACTUALIZAR" onclick="return valida_contenido('update','<?php echo $_GET['id'];?>')" class="btn btn-success"><br clear="all">
	  					</div>
	  				</div>
        	</form>
        </fieldset>
		<?php

	}

	public function updateProductos($cat=0){

		$nombre 	= '';
		$nombre_pdf	= '';
		$destino 	= _ruta_imagenes_saweto_;
		$update 	= '';
		$update_pdf	= '';

	    if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "") {
	    	$nombre_archivo = $_FILES['foto']['name'];

			$nombre_file = time().trim($nombre_archivo);
			$nombre = $nombre_file;	
			
	        $temp = $_FILES['foto']['tmp_name'];
	        move_uploaded_file($temp, $destino.'productos/'.$nombre); 
	    	$update 	= ",foto='" . $nombre . "' ";
	    }

	    if (isset($_FILES['pdf']['name']) && $_FILES['pdf']['name'] != "") {
	    	$nombre_archivo = $_FILES['pdf']['name'];

			$nombre_file 	= time().trim($nombre_archivo);
			$nombre_pdf 	= $nombre_file;	
			
	        $temp = $_FILES['pdf']['tmp_name'];
	        move_uploaded_file($temp, $destino.'productos/'.$nombre_pdf); 
	    	$update_pdf 	= ",pdf='" . $nombre_pdf . "' ";
	    }

		$query = new Consulta("UPDATE productos SET codigo_producto = '".$_POST['titulo'][0]."'													WHERE id_producto = '".$_GET['id']."'");

		//Insertando idiomas
		$obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();
		for($i = 0; $i < count($idiomas); $i++)
		{
			$query = new Consulta("UPDATE  productos_idiomas
										SET nombre_producto	    =  '".addslashes($_POST['titulo'][$i])."',
											descripcion_producto  =  '".addslashes($_POST['descripcion'][$i])."',
											url_producto        =  '".url_amigable($_POST['titulo'][0], 1)."',
											link_producto        =  '".addslashes($_POST['link'])."',
											fecha        =  '".formato_date('/',$_POST['fecha'])."',
											latitud        =  '".addslashes($_POST['latitud'])."',
											longitud        =  '".addslashes($_POST['longitud'])."'
											$update
											$update_pdf
										WHERE id_idioma = '".$idiomas[$i]['id']."'
										AND id_producto = '".$_GET['id']."'");
		}


		$this->_msgbox->setMsgbox('Se actualizo correctamente.',2);
		location("modulos-web.php?cat=".$cat);
	}

	public function deleteProductos($cat=0){

		$query = new Consulta("DELETE  FROM productos WHERE id_producto = '".$_GET['id']."'");
		$query = new Consulta("DELETE  FROM productos_idiomas WHERE id_producto = '".$_GET['id']."'");


		$this->_msgbox->setMsgbox('Se elimino correctamente.',2);
		location("modulos-web.php?cat=".$cat);
	}


	public function listaProductos($cat=0){
		$idc = ($cat > 0) ? $cat : 0;
		$sql = " SELECT * FROM categorias c, categorias_idiomas ci WHERE c.id_parent  =  ".$idc."
				AND c.id_categoria = ci.id_categoria AND ci.id_idioma = '".$this->_idioma->__get('_id')."'
				ORDER BY c.orden_categoria ASC";

		$query = new Consulta($sql);
		return $query;

		}


	public function listProductos($cat=0){

	
		$idc = ($cat > 0) ? $cat : 0;

		$sql = " SELECT * FROM categorias c, categorias_idiomas ci
					WHERE c.id_parent  =  ".$idc."
						AND c.id_categoria = ci.id_categoria
						AND ci.id_idioma = '2'
					ORDER BY c.orden_categoria ASC";

		$query = new Consulta($sql);
		$sqlp = " SELECT * FROM productos p, productos_idiomas pi
						WHERE p.id_categoria =  ".$idc."
							AND p.id_producto = pi.id_producto
							-- AND pi.id_idioma  = '".$this->_idioma->__get('_id')."'
							AND pi.id_idioma  = '2'
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
			            <td class=" "><i class="glyphicon glyphicon-folder-open"></i>&nbsp; <?php echo $row['nombre_categoria'] ?></td>
				        <td class=" "><?php echo $row['url_categoria'] ?></td>
				        <td class=" last">
				        	<a href="?actioncat=edit&cat=<?php echo $row['id_categoria']; ?>" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i> Editar</a>
				        	<a href="?cat=<?php echo $row['id_categoria']; ?>" class="btn btn-success"><i class="glyphicon glyphicon-level-up"></i> Ver Categorias</a>
				        	<a href="#" class="btn btn-danger" onClick="mantenimiento_cat('modulos-web.php','<?php echo $row['id_categoria'] ?>','delete')"><i class="glyphicon glyphicon-remove"></i> Eliminar</a>
				        </td>
				    </tr>
				<?php
					$y++;
				}
				$y = 1;
				while($rowp = $queryp->VerRegistro()){
					?>
				 		<tr class="even pointer">
				            <td class=" "><i class="glyphicon glyphicon-file"></i>&nbsp; <?php echo $rowp['nombre_producto'] ?></td>
					        <td class=" "><?php echo $rowp['url_producto'] ?></td>
				        	<td class=" last">
					        	<a href="?id=<?php echo $rowp['id_producto']; ?>&action=edit" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i> Editar</a>
					        	<a href="?id=<?php echo $rowp['id_producto']; ?>&action=imagenes" class="btn btn-warning"><i class="glyphicon glyphicon-camera"></i> Agregar fotos</a>
					        	<a href="#" class="btn btn-danger" onClick="mantenimiento('modulos-web.php','<?php echo $rowp['id_producto'] ?>','delete')"><i class="glyphicon glyphicon-remove"></i> Eliminar</a>
					        	
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

	public function getProductos(){

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
	        location("modulos-web.php?id=".$id."&action=imagenes");
        }

		$obj = new ModeloProducto($_GET['id'], $this->_idioma);
		$imagenes = $obj->__get("_imagenes");
		?>
		<div id="mantinance">
			<fieldset id="crud">
				<legend> Galeria de Imagenes </legend>
				<form name="f1" id="f1" method="post" enctype="multipart/form-data" action="modulos-web.php?id=<?php echo $_GET['id'] ?>&action=imagenes"   >
				<div id="iframe">
					<div class="ileft_img" style="float: left;">
						<label for="imagen">Imagen : </label>
						<input id="file" type="file" name="image" size="31" class="btn btn-info fileinput" />
					</div>
				</div>
				<div style="clear:both"></div>
				<br><br>
				<div id="images">
					<div class="lefti" style="width: 500px; float: left;"> <?php
						if(is_array($imagenes) && count($imagenes) > 0){

							for($i=0; $i < count($imagenes); $i++){ ?>
								<div id="item_image" class="imagen<?php echo $imagenes[$i]['id'];?>">
									<input type="checkbox" name="chkimag" value="<?php echo $imagenes[$i]['id'];?>"/>
									<a href="#" title="<?php echo _imagenes_saweto_.$imagenes[$i]['original'];?>">
									<?php echo _imagenes_saweto_.$imagenes[$i]['imagen'];?> </a>
								</div> <?php

							}
						} ?>
						<p id="msg_delete"> </p>
	 				</div>
					<div class="righti" id="imgs" style="width: 500px; float: right;"><?php if(!empty($imagenes[0]['imagen'])){ ?>
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
	public function firstPhotoProject($id){
		$query = new Consulta("SELECT * FROM proyectos_imagenes WHERE id_proyecto  = '".$id."' LIMIT 1");
		return $query->VerRegistro();
			
	}

	public function listadoPorCategoria($idioma, $url){
		$query = new Consulta("SELECT * FROM proyectos p 
				INNER JOIN proyectos_idiomas pi	ON(p.id_proyecto = pi.id_proyecto)
				INNER JOIN categorias_idiomas ci ON(p.id_categoria = ci.id_categoria AND pi.id_idioma = ci.id_idioma )
				WHERE pi.id_idioma = '$idioma->_id' 
				AND url_categoria = '$url'
				ORDER BY pi.orden DESC");
		
		while($row=$query->VerRegistro()){
			$data[] = $row;
		}
		return $data;

	}


	public function detalleProyectoUrl($idioma, $url){
		$query = new Consulta("SELECT * FROM proyectos p 
				INNER JOIN proyectos_idiomas pi	ON(p.id_proyecto = pi.id_proyecto)
				INNER JOIN categorias_idiomas ci ON(p.id_categoria = ci.id_categoria AND pi.id_idioma = ci.id_idioma )
				WHERE pi.id_idioma = '$idioma->_id' AND url_proyecto = '$url'");
		
		return $query->VerRegistro();
	}


	public function getFotosProyectoId($id){
		$query = new Consulta("SELECT * FROM proyectos_imagenes WHERE id_proyecto  = '".$id."'");

		while($row=$query->VerRegistro()){
			$data[] = $row;
		}
		return $data;
	}

	

}
 ?>