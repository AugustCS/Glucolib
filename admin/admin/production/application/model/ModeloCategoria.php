<?php
class ModeloCategoria{

	private $_id, $_idioma, $_nombre,$_parent,$_fecha, $_contenido_idiomas;

	public function __construct($id = 0, ModeloIdioma $idioma){
		$this->_id = $id;
		$this->_idioma = $idioma;

		if($this->_id > 0){

			$sql = " SELECT * FROM
							categorias c, categorias_idiomas ci
							WHERE  c.id_categoria = ci.id_categoria
							AND ci.id_idioma   = '".$this->_idioma->__get('_id')."'
							AND c.id_categoria = '".$this->_id."'";

			$query = new Consulta($sql);

			if($row = $query->VerRegistro()){
				$this->_nombre 	 = $row['nombre_categoria'];
				$this->_parent	 = $row['id_parent'];
			}

			$sqlq = "SELECT * FROM categorias_idiomas WHERE id_categoria = '".$this->_id."' ORDER BY id_categoria, id_idioma ";
			$queryq = new Consulta($sqlq);
			while($rowq = $queryq->VerRegistro()){
				$this->_contenido_idiomas[$rowq['id_idioma']] = array(
					'nombre' 		=> $rowq['nombre_categoria'],
					'descripcion' 	=> $rowq['descripcion'],
					'imagen' 		=> $rowq['imagen']
				);
			}
		}
	}

	public function __get($attribute){
		return	$this->$attribute;
	}
} ?>