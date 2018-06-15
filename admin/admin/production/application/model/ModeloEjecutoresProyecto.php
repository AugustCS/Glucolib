<?php  

require_once _model_.'ModeloEjecutoresProyectoCategoria.php';

class ModeloEjecutoresProyecto{
	
	private $_id, $_categoria_id, $_idioma, $_categoria, $_nombre, $_sub_titulo, $_descripcion, $_tags, $_pdf, $_contenido_idiomas, $_relacionados,$_imagenes, $_imagen;
	
	public function __construct($id = 0, ModeloIdioma $idioma){
		$this->_id = $id;
		$this->_idioma = $idioma;
		
		if($this->_id > 0){
			 
			$sql = " SELECT * FROM proyectos_ejecutores p, proyectos_ejecutores_idiomas pi 
						WHERE p.id_proyecto = '".$this->_id."'
							AND p.id_proyecto = pi.id_proyecto
							AND pi.id_idioma  = '".$this->_idioma->__get("_id")."'";
			
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 
				$this->_nombre 	   				= $row['titulo'];
				$this->_sub_titulo 	   			= $row['sub_titulo'];
				$this->_categoria_id 			= $row['id_categoria'];
				$this->_imagen	 				= $row['imagen'];
				$this->_descripcion				= $row['descripcion'];
			}
			
			$sqlq = "SELECT * FROM proyectos_ejecutores_idiomas WHERE id_proyecto = '".$this->_id."' ORDER BY id_proyecto, id_idioma ";


			$queryq = new Consulta($sqlq);
			while($rowq = $queryq->VerRegistro()){		
				
				$this->_contenido_idiomas[$rowq['id_idioma']] = array(
					'nombre' 	  	=> $rowq['titulo'],
					'descripcion'		=> $rowq['descripcion'],
					'url'			=> $rowq['url'],
					'sub_titulo'			=> $rowq['sub_titulo'],
								
				);				
			}
			
			
			$sql_imgs = " SELECT * FROM productos_imagenes WHERE id_producto = '".$this->_id."' ORDER BY order_producto_imagen ASC";
			$query_imgs = new Consulta($sql_imgs);
			if($query_imgs->NumeroRegistros() > 0){
				while($row_imgs = $query_imgs->VerRegistro()){
					$this->_imagenes[] = array(
							'id' 		=> $row_imgs['id'],
							'thumbnail' => $row_imgs['thumb_producto_imagen'],
							'imagen' 	=> $row_imgs['big_producto_imagen'],
							'original' 	=> $row_imgs['imagen']
					);
				}
			}
			
			
		}					
	}
	
	public function __get($attribute){
		return	$this->$attribute;
	}
	
}
 ?>