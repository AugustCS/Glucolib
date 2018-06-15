<?php
class ModeloEjecutoresProyectoCategorias{

	private $_idioma, $_msgbox;


	public function __construct(ModeloIdioma $idioma, Msgbox $msg){
		$this->_idioma = $idioma ;
		$this->_msgbox = $msg ;

	}

	public function newEjecutoresProyectoCategorias(){
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
							<input type="text" name="nombre[]" value="" class="form-control col-md-7 col-xs-12" size="59" maxlength="50">
						</div>

					</div>

                    <?php
                }
				?>


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
							<input type="button" name="" value="GUARDAR" onclick="return valida_categoriasP('add','', 'categorias')" class="btn btn-success"><br clear="all">
	  					</div>
	  				</div>
					
				</form> 
		<?php
	}

	public function editEjecutoresProyectoCategorias(){
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
				?>
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

	public function addEjecutoresProyectoCategorias($cat=0){
		
		$query = new Consulta("INSERT INTO  ejecutores_proyecto_categorias (id_parent) VALUES ('$cat')");
		//$id = mysql_insert_id();
		$id =  $query->nuevoId();

		//INSERTANDO IDIOMAS
		$obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();
		for($i = 0; $i < count($idiomas); $i++)
		{
			$query = new Consulta("INSERT INTO  ejecutores_proyecto_categorias_idiomas (id_categoria,id_idioma, titulo, url, descripcion, registro) VALUES(
											'".$id."',
											'".$idiomas[$i]['id']."',
											'".addslashes($_POST['nombre'][$i])."',
											'".url_amigable($_POST['nombre'][$i], 1)."',
											'".addslashes($_POST['descripcion'][$i])."',
											'".TIEMPO."')");
		}
		$url = "ejecutores-proyecto.php?cat=".$cat;

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

	public function updateEjecutoresProyectoCategorias($cat = 0){

		$parent_id = $this->obtenerParent($cat);
		//INSERTANDO IDIOMAS
		$obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();
		for($i = 0; $i < count($idiomas); $i++)
		{
			$query = new Consulta("UPDATE  categorias_idiomas SET nombre_categoria ='".addslashes($_POST['nombre_categoria'][$i])."',url_categoria ='".url_amigable($_POST['nombre_categoria'][$i], 1)."' WHERE id_idioma = '".$idiomas[$i]['id']."' AND id_categoria = '".$_GET['id']."'");
		}

		$this->_msgbox->setMsgbox('La categoria se actualizo correctamente.',2);
		location("ejecutores-proyecto.php?cat=".$parent_id);
	}

	public function deleteEjecutoresProyectoCategorias($cat = 0){

		$query  = new Consulta("DELETE FROM  categorias WHERE id_categoria = '".$_GET['cat']."'");
		$query2 = new Consulta("DELETE FROM  categorias_idiomas WHERE id_categoria = '".$_GET['cat']."'");

		$this->_msgbox->setMsgbox('La categoria se elimino con exito.',2);
		$cat = 0;
		location("ejecutores-proyecto.php?cat=".$cat);
	}


	public function getCategorias($id = "", $id_parent = 999999){

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