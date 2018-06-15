<?php 

require_once _model_.'ModeloModulo.php';


class ModeloSeccion{

	private $_id, $_nombre, $_url, $_modulo;
	
	public function __construct($id = 0){
		$this->_id = $id;
		
		if($this->_id > 0){
			$sqls = " SELECT * FROM secciones WHERE id_seccion = '".$this->_id."' ";
			$querys = new Consulta($sqls);
			if($rows = $querys->VerRegistro()){
				$this->_id 	   	= $rows['id_seccion'];
				$this->_modulo 	= new ModeloModulo($rows['id_modulo']);
				$this->_nombre 	= $rows['nombre_seccion'];
				$this->_url 	= $rows['url_seccion'];
			}			
		}
	}
	
	public function getId(){
		return $this->_id;
	}
	
	public function getNombre(){
		return $this->_nombre ;
	}
	
	public function getModulo(){
		return $this->_modulo ;
	}
	
	public function getUrl(){
		return $this->_url ;
	}	


		
}
?>