<?php
require_once _model_.'ModeloCategoria.php';

class ModeloProducto{
	
	private $_id, $_categoria_id, $_idioma, $_categoria, $_nombre, $_descripcion_corta, $_descripcion, $_tags, $_pdf, $_contenido_idiomas, $_relacionados,$_imagenes, $_imagen;
	
	public function __construct($id = 0, ModeloIdioma $idioma){
		$this->_id = $id;
		$this->_idioma = $idioma;
		
		if($this->_id > 0){
			 
			$sql = " SELECT * FROM productos p, productos_idiomas pi 
						WHERE p.id_producto = '".$this->_id."'
							AND p.id_producto = pi.id_producto
							AND pi.id_idioma  = '".$this->_idioma->__get("_id")."'";
			
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 
				$this->_nombre 	   		= $row['nombre_producto'];
				$this->_categoria_id 	= $row['id_categoria'];
				$this->_categoria   	= new ModeloCategoria($row['id_categoria'], $this->_idioma);
				$this->_imagen	 		= $row['imagen_producto'];
				$this->_url				= $row['url_producto'];
			}
			
			$sqlq = "SELECT * FROM productos_idiomas WHERE id_producto = '".$this->_id."' ORDER BY id_producto, id_idioma ";


			$queryq = new Consulta($sqlq);
			while($rowq = $queryq->VerRegistro()){		
				
				$this->_contenido_idiomas[$rowq['id_idioma']] = array(
					'nombre' 	  	=> $rowq['nombre_producto'],
					'descripcion'	=> $rowq['descripcion_producto'],
					'url'			=> $rowq['url_producto'],
					'link'			=> $rowq['link_producto'],
					'fecha'			=> $rowq['fecha'],
					'latitud'		=> $rowq['latitud'],
					'longitud'		=> $rowq['longitud'],
					'foto'			=> $rowq['foto']								
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