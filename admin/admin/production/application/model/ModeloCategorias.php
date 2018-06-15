<?php
class ModeloCategorias{

	private $_idioma, $_msgbox;


	public function __construct(ModeloIdioma $idioma, Msgbox $msg){
		$this->_idioma = $idioma ;
		$this->_msgbox = $msg ;

	}

	public function newCategorias(){
		$obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();
		
		?>
		<legend> Nuevo Módulo</legend>			
				<form name="categorias" method="post" action="" enctype="multipart/form-data" class="form-horizontal form-label-left"> 
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
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Nombre: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" name="nombre_categoria[]" value="" class="form-control col-md-7 col-xs-12" size="59" maxlength="50">
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
						<label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;Imagen: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="file" class="foto" name="foto" id="foto">							
						</div>

					</div>
	  				
	  				<div class="ln_solid"></div>
	  				<div class="form-group">
	  					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	  					<input type="hidden" name="foto_usuario" value="">
	  						<input type="reset" name="cancelar" value="CANCELAR" class="btn btn-danger" onclick="history.back()">  
							<input type="button" name="" value="GUARDAR" onclick="return valida_categorias('add','', 'categorias')" class="btn btn-success"><br clear="all">
	  					</div>
	  				</div>
					
				</form> 
		<?php
	}

	public function editCategorias(){
		$obj = new ModeloCategoria($_GET['cat'], $this->_idioma);
		$contenido = $obj->__get("_contenido_idiomas");

		$obj_idiomas 	= new ModeloIdiomas();
		$idiomas	 	= $obj_idiomas->getIdiomas();
		$id 			= $_GET['cat'];

		?>
        <fieldset id="form">
        	<legend>Editar Categoria</legend>
        	<form action="" method="post" name="categorias"  enctype="multipart/form-data" class="form-horizontal form-label-left">

            	<!-- <div class="button-actions">
                	<input type="submit" name="" value="ACTUALIZAR" onclick="return valida_categorias('update','<?php echo $_GET['id'] ?>&ide=<?php echo $_GET['id'] ?>')"  />
               		<input type="reset" name="" value="CANCELAR" onclick="cancelarCat()" />
                </div> -->
                
               	 <?php
					for($i = 0; $i < count($idiomas); $i++){
                        if($i==1){
                            $bandera="images/es.png";
                        }
                        if($i==0){
                            $bandera="images/en.png";
                        }
				?>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Nombre: </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" name="nombre_categoria[]" value="<?php echo $contenido[$idiomas[$i]['id']]['nombre']; ?>" class="form-control col-md-7 col-xs-12" size="59" maxlength="50">
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
						<label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;Imagen: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="file" class="foto" name="foto" id="foto">							
						</div>

					</div>
					<div class="form-group">
						<img src="<?php echo _imagenes_saweto_.'categorias/'. $contenido[$idiomas[0]['id']]['imagen']; ?>" width="600" alt="">
					</div>
	  			
				<div class="ln_solid"></div>
	  				<div class="form-group">
	  					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	  					<input type="hidden" name="foto_usuario" value="">
	  						<input type="reset" name="cancelar" value="CANCELAR" class="btn btn-danger" onclick="history.back()">  
							<input type="button" name="" value="ACTUALIZAR" onclick="return valida_categorias('update','<?php echo $id; ?>', 'categorias')" class="btn btn-success"><br clear="all">
	  					</div>
	  				</div>
            </form>
         </fieldset>
		<?php
	}

	public function addCategorias($cat=0){
		
		$query = new Consulta("INSERT INTO  categorias (id_parent, orden_categoria)
									VALUES ('".$cat."','".$this->orderCategorias($cat)."')");
		//$id = mysql_insert_id();
		$id =  $query->nuevoId();

		//INSERTANDO IDIOMAS
		$obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();


		$nombre 	= '';
			$destino 	= _ruta_imagenes_saweto_;
        	$update 	= ", '" . $nombre . "' ";
		

	        if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "") {
	        	$nombre_archivo = $_FILES['foto']['name'];

				$nombre_file = time().trim($nombre_archivo);
				$nombre = $nombre_file;	
				
	            $temp = $_FILES['foto']['tmp_name'];
	            move_uploaded_file($temp, $destino.'categorias/'.$nombre); 
	        }

		for($i = 0; $i < count($idiomas); $i++)
		{
			$query = new Consulta("INSERT INTO  categorias_idiomas (id_categoria,id_idioma, nombre_categoria, url_categoria, descripcion, imagen) VALUES(
											'".$id."',
											'".$idiomas[$i]['id']."',
											'".addslashes($_POST['nombre_categoria'][$i])."',
											'".url_amigable($_POST['nombre_categoria'][$i], 1)."',
											'".addslashes($_POST['descripcion'][$i])."',
											'".$nombre."'
											)");
		}
		$url = "modulos-web.php?cat=".$cat;

		$this->_msgbox->setMsgbox('La categoria se grabo correctamente.',2);
		location($url);
	}

	public function orderCategorias($parent=0){
		$query = new Consulta("SELECT MAX(orden_categoria) max_orden FROM categorias WHERE id_parent = '".$parent."'");

		$row   = $query->VerRegistro();
		return (int)($row['max_orden']+1);
	}

	public function obtenerParent($cat)
	{
		$sql 	= "SELECT id_parent from categorias where id_categoria = $cat";
		$query 	= new Consulta($sql);
		$row   	= $query->VerRegistro();
		return $row['id_parent'];

	}

	public function updateCategorias($cat = 0){

		$nombre 	= '';
		$destino 	= _ruta_imagenes_saweto_;
		$update 	= '';
	
        if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "") {
        	$nombre_archivo = $_FILES['foto']['name'];

			$nombre_file = time().trim($nombre_archivo);
			$nombre = $nombre_file;	
			
            $temp = $_FILES['foto']['tmp_name'];
            move_uploaded_file($temp, $destino.'categorias/'.$nombre); 
        	$update 	= ",imagen='" . $nombre . "' ";
        }

        $parent_id = $this->obtenerParent($cat);
		//INSERTANDO IDIOMAS
		$obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();
		for($i = 0; $i < count($idiomas); $i++)
		{
			$query = new Consulta("UPDATE  categorias_idiomas SET nombre_categoria ='".addslashes($_POST['nombre_categoria'][$i])."',url_categoria ='".url_amigable($_POST['nombre_categoria'][$i], 1)."',
				descripcion ='".addslashes($_POST['descripcion'][$i])."'
				$update  
				WHERE id_idioma = '".$idiomas[$i]['id']."' AND id_categoria = '".$_GET['id']."'");
		}

		$this->_msgbox->setMsgbox('La categoria se actualizo correctamente.',2);
		location("modulos-web.php?cat=".$parent_id);
	}

	public function deleteCategorias($cat = 0){

		$query  = new Consulta("DELETE FROM  categorias WHERE id_categoria = '".$_GET['cat']."'");
		$query2 = new Consulta("DELETE FROM  categorias_idiomas WHERE id_categoria = '".$_GET['cat']."'");

		$this->_msgbox->setMsgbox('La categoria se elimino con exito.',2);
		$cat = 0;
		location("modulos-web.php?cat=".$cat);
	}


	function getCategorias($id = "", $id_parent = 999999){

		$where = $id != "" ? " AND c.id_categoria = '".$id."' " : "";
		$where .= $id_parent != 999999 ? " AND c.id_parent = '".$id_parent."' " : "";

		$sql = "SELECT * FROM categorias c, categorias_idiomas ci
					WHERE c.id_categoria = ci.id_categoria
					AND  ci.id_idioma = '".$this->_idioma->__get("_id")."' ".$where. " ORDER BY c.id_categoria";

		$query=new Consulta($sql);
		$retorno;

		while($row = $query->VerRegistro()){
			$retorno[] = array(
				'id'		  =>	$row['id_categoria'],
				'nombre'	  =>	$row['nombre_categoria'],
				'url'	  	  =>	$row['url_categoria'],
				'id1'		  =>	$row['id_parent']
			);
		}
		return $retorno;
	}




}
 ?>