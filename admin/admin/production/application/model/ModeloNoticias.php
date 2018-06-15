<?php  

class ModeloNoticias{

	private $_idioma, $_msgbox;

	public function __construct(ModeloIdioma $idioma, Msgbox $msg, ModeloUsuario $user){
		$this->_idioma  = $idioma ;
		$this->_msgbox  = $msg ;
		$this->_usuario = $user;
	}

	


	public function listNoticias()
	{
		
		$sql = "SELECT * FROM noticias n, noticias_idiomas ni 
				where n.id_noticia = ni.id_noticia
						AND ni.id_idioma = '2'
					ORDER BY n.orden ASC";
		$query = new Consulta($sql);

		?> 
		<div class="table-responsive">
			<table class="table table-striped jambo_table bulk_action">
				<thead>
				  <tr class="headings">
				    <th class="column-title">Tiulo</th>
				    <th class="column-title">url</th>
				    <th class="column-title no-link last"><span class="nobr">Opciones</span>
				    </th>
				  </tr>
				</thead>
				<tbody>
				<?php  

				while($row = $query->VerRegistro()){
					?>
					<tr class="even pointer">
			            <td class=" "><i class="glyphicon glyphicon-file"></i>&nbsp; <?php echo $row['titulo'] ?></td>
				        <td class=" "><?php echo $row['url'] ?></td>
				        <td class=" last">
				        	<a href="?action=edit&id=<?php echo $row['id_noticia']; ?>" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i> Editar</a>
				        	<a href="?action=relacionar&id=<?php echo $row['id_noticia']; ?>" class="btn btn-warning"><i class="glyphicon glyphicon-new-window"></i> Relacionar</a>
				        	<a href="#" class="btn btn-danger" onClick="mantenimiento('noticias.php','<?php echo $row['id_noticia'] ?>','delete')"><i class="glyphicon glyphicon-remove"></i> Eliminar</a>
				        </td>
				    </tr>
				<?php
				}

				?>
				</tbody>
			</table>
		</div>
		<?php					
	}

	public function newNoticias(){
		$obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();
		?>
        	<legend>Nueva noticia</legend>
        	<form action="?action=add" method="post" name="noticias" enctype="multipart/form-data" class="form-horizontal form-label-left">
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
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Imagen: </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="file" class="foto" name="foto" id="foto">
					</div>

				</div>

				<div class="ln_solid"></div>
	  				<div class="form-group">
	  					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	  						<input type="reset" name="cancelar" value="CANCELAR" class="btn btn-danger" onclick="history.back()">  
							<input type="button" name="" value="GUARDAR" onclick="return valida_noticias('add','')" class="btn btn-success"><br clear="all">
	  					</div>
	  				</div>
        	</form>
		<?php
	}

	public function editNoticias(){

		$obj = new ModeloNoticia($_GET['id'], $this->_idioma);
		$contenido = $obj->__get("_contenido_idiomas");

		$obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();
		?>
        	<legend>Editar noticia</legend>
        	<form action="?action=add" method="post" name="noticias" enctype="multipart/form-data" class="form-horizontal form-label-left">
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
							<input type="text" name="titulo[]" value="<?php echo $contenido[$idiomas[$i]['id']]['titulo']; ?>" class="form-control col-md-7 col-xs-12" size="59" maxlength="50">
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
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Imagen: </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="file" class="foto" name="foto" id="foto">
					</div>

				</div>
				<div class="form-group">
					<img src="<?php echo _imagenes_saweto_.'noticias/'. $contenido[$idiomas[0]['id']]['imagen']; ?>" alt="">

				</div>

				<div class="ln_solid"></div>
	  				<div class="form-group">
	  					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

	  						<input type="reset" name="cancelar" value="CANCELAR" class="btn btn-danger" onclick="history.back()">  
							<input type="button" name="" value="ACTUALIZAR" onclick="return valida_noticias('update','<?php echo $_GET['id'] ?>')" class="btn btn-success"><br clear="all">
	  					</div>
	  				</div>
        	</form>
		<?php
	}

	public function addNoticias()
	{
		$data =  new stdClass();

		if (isset($_POST['titulo']) && count($_POST['titulo']) > 0 ) {
			
			$nombre 	= '';
			$destino 	= _ruta_imagenes_saweto_;
        	$update 	= ", '" . $nombre . "' ";
		

	        if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "") {
	        	$nombre_archivo = $_FILES['foto']['name'];

				$nombre_file = time().trim($nombre_archivo);
				$nombre = $nombre_file;	
				
	            $temp = $_FILES['foto']['tmp_name'];
	            move_uploaded_file($temp, $destino.'noticias/'.$nombre); 
	        }
			$query = new Consulta("INSERT INTO  noticias (fecha, orden) VALUES('".TIEMPO."'
			,'".$this->orderNoticias()."'
			)");


			$id = $query->NuevoId();
			$obj_idiomas = new ModeloIdiomas();
			$idiomas	 = $obj_idiomas->getIdiomas();
			for($i = 0; $i < count($idiomas); $i++)
			{
				$query = new Consulta("INSERT INTO  noticias_idiomas (id_noticia, id_idioma, titulo, url, descripcion,imagen)
											VALUES (
												'".$id."',
												'".$idiomas[$i]['id']."',
												'".addslashes($_POST['titulo'][$i])."',
												'".url_amigable($_POST['titulo'][1], 1)."',
												'".addslashes($_POST['descripcion'][$i])."',
												'".$nombre."'
												)");
			}
			$this->_msgbox->setMsgbox('Noticia grabada correctamente',2);
			location("noticias.php");

		}
	}
		public function orderNoticias(){
		$query = new Consulta("SELECT MAX(orden) max_orden
									FROM noticias");

		$row   = $query->VerRegistro();
		return (int)($row['max_orden']+1);
	}

	public function deleteNoticias()
	{
		$sql =  "DELETE FROM noticias where id_noticia = '".$_GET['id']."'";
		$uqery =  new Consulta($sql);
		$this->_msgbox->setMsgbox('Se elimino correctamente.',2);
		location("noticias.php");

	}
	public function updateNoticias()
	{
		$nombre 	= '';
		$destino 	= _ruta_imagenes_saweto_;
		$update 	= '';
	
        if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "") {
        	$nombre_archivo = $_FILES['foto']['name'];

			$nombre_file = time().trim($nombre_archivo);
			$nombre = $nombre_file;	
			
            $temp = $_FILES['foto']['tmp_name'];
            move_uploaded_file($temp, $destino.'noticias/'.$nombre); 
        	$update 	= ",imagen='" . $nombre . "' ";
        }

        $obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();
		for($i = 0; $i < count($idiomas); $i++)
		{
			$query = new Consulta("UPDATE  noticias_idiomas
										SET titulo	    =  '".addslashes($_POST['titulo'][$i])."',
											url        =  '".url_amigable($_POST['titulo'][1], 1)."',
											descripcion  =  '".addslashes($_POST['descripcion'][$i])."'
											$update
										WHERE id_idioma = '".$idiomas[$i]['id']."'
										AND id_noticia = '".$_GET['id']."'");
		}


		$this->_msgbox->setMsgbox('Se actualizo correctamente.',2);
		location("noticias.php");
	}

	public function relacionarNoticias()
	{
		$data =  $this->getAnuncio($_GET['id']);
		//pre($data);

		
		?>
        	<legend>Noticias relacionadas</legend>
        	<form action="?action=add" method="post" name="noticias" enctype="multipart/form-data" class="form-horizontal form-label-left">
            	 	<?php  
            	 	for ($i=0; $i < count($data); $i++) { 
            	 		?> 
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">
							<?php echo $data[$i]['titulo']; ?></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<?php  
								$checked = $data[$i]['id_noticia_relacionado'] ? "checked= 'checked'" : '';
								?>

								<input type="checkbox" name="id_relacion[]" <?php echo $checked; ?> value="<?php echo $data[$i]['id_noticia']; ?>">
							</div>

						</div>


            	 		<?php
            	 	}
            	 	?>


				<div class="ln_solid"></div>
	  				<div class="form-group">
	  					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	  						<input type="reset" name="cancelar" value="CANCELAR" class="btn btn-danger" onclick="history.back()">  
							<input type="button" name="" value="GUARDAR" onclick="return valida_noticias('add','')" class="btn btn-success"><br clear="all">
	  					</div>
	  				</div>
        	</form>
		<?php
	}

	public function getAnuncio($id)
	{
		$sql =  "SELECT n.id_noticia, ni.titulo, nr.id_noticia_relacionado 
					FROM noticias n
					INNER JOIN noticias_idiomas ni ON (ni.id_noticia = n.id_noticia)
					LEFT JOIN noticias_relacionadas nr ON(nr.id_noticia = n.id_noticia)
					WHERE n.id_noticia <> '$id'
					GROUP BY id_noticia";
		
		$query =  new Consulta($sql);
		$data = array();
		while($row = $query->VerRegistro()){
			$data[] = array(
				'id_noticia' 			=> $row['id_noticia'],
				'titulo' 				=> $row['titulo'],
				'id_noticia_relacionado'=> $row['id_noticia_relacionado'],
			);				# code...
			}	

			return $data;			
	}
}
?>		