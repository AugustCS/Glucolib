<?php

class ModeloNoticia{
	
	private $_id, $_idioma, $_titulo, $_descripcion_corta, $_descripcion, $_tags, $_pdf, $_contenido_idiomas, $_relacionados,$_imagenes, $_imagen;
	
	public function __construct($id = 0, ModeloIdioma $idioma){
		$this->_id = $id;
		$this->_idioma = $idioma;
		
		if($this->_id > 0){
			 
			$sql = " SELECT * FROM noticias n, noticias_idiomas ni 
						WHERE n.id_noticia = '".$this->_id."'
							AND n.id_noticia = ni.id_noticia
							AND ni.id_idioma  = '".$this->_idioma->__get("_id")."'";
			
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 
				$this->_titulo 	   		= $row['titulo'];
				$this->_descripcion 	= $row['descripcion'];
				$this->_imagen	 		= $row['imagen'];
				$this->_url				= $row['url'];
			}
			
			$sqlq = "SELECT * FROM noticias_idiomas WHERE id_noticia = '".$this->_id."' ORDER BY id_idioma ";


			$queryq = new Consulta($sqlq);
			while($rowq = $queryq->VerRegistro()){		
				
				$this->_contenido_idiomas[$rowq['id_idioma']] = array(
					'id_noticia_idioma' 	=> $rowq['id_noticia_idioma'],
					'id_noticia'			=> $rowq['id_noticia'],
					'titulo'				=> $rowq['titulo'],
					'descripcion'			=> $rowq['descripcion'],
					'imagen'				=> $rowq['imagen'],
				);				
			}
			
			
			$sql_imgs = " SELECT * FROM noticias_relacionadas WHERE id_noticia = '".$this->_id."'";
			$query_imgs = new Consulta($sql_imgs);
			if($query_imgs->NumeroRegistros() > 0){
				while($row_imgs = $query_imgs->VerRegistro()){
					$this->_imagenes[] = array(
							'id' 		=> $row_imgs['id_noticia'],
							'relacion' 	=> $row_imgs['id_noticia_relacion']

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